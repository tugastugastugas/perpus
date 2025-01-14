<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Wahana;
use App\Models\Transaksi;
use App\Models\Play;
use App\Models\UserHistory;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class BookingController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function booking()
    {
        // Log aktivitas pengguna
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Wahana.',
        ]);

        // Ambil data dengan status active (Bermain), urutkan berdasarkan durasi terpendek
        $playActive = DB::table('play')
            ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
            ->leftJoin('transaksi', 'transaksi.id_play', '=', 'play.id_play')
            ->whereIn('play.status', ['active', 'pending']) // Ambil yang active atau pending
            ->orderBy('play.end', 'asc') // Urutkan berdasarkan durasi terpendek
            ->select(
                'wahana.nama_wahana',
                'play.nama_anak',
                'play.nohp',
                'play.start',
                'play.end',
                'play.id_play',
                'play.durasi',
                'play.id_wahana',
                'play.status',
                'wahana.harga as harga_per_jam',
                'transaksi.harga as current_harga',
            )
            ->get();


        // Ambil data dengan status completed (Selesai), urutkan berdasarkan durasi terpendek
        $playCompleted = DB::table('play')
            ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
            ->where('play.status', 'completed') // Hanya ambil yang completed
            ->orderBy('play.end', 'asc') // Urutkan berdasarkan durasi terpendek
            ->select(
                'wahana.nama_wahana',
                'play.nama_anak',
                'play.nohp',
                'play.start',
                'play.end',
                'play.id_play',
                'play.durasi',
                'play.id_wahana',
                'play.status',
            )
            ->get();

        // Ambil semua data wahana
        $wahana = Wahana::all();

        // Kirim data ke view
        echo view('header');
        echo view('menu');
        echo view('booking', compact('wahana', 'playActive', 'playCompleted'));
        echo view('footer');
    }

    public function t_anak(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Anak.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'nama_anak' => 'required|string|max:255',
                'nohp' => 'required|digits_between:10,15',
                'wahana' => 'required|integer|exists:wahana,id_wahana',
                'durasi' => 'required|numeric',
            ]);

            // Hitung waktu start dan end berdasarkan durasi
            $start = now();

            // Ambil durasi jam dari request
            $durasiJam = (int) filter_var($request->durasi, FILTER_SANITIZE_NUMBER_INT);

            // Hitung waktu akhir dengan menambah durasi jam ke waktu sekarang
            $end = $start->clone()->addHours($durasiJam);

            // Simpan data ke tabel Play
            $play = new Play();
            $play->id_wahana = $request->wahana;
            $play->durasi = $request->durasi;
            $play->nama_anak = $request->nama_anak;
            $play->nohp = $request->nohp;
            // $play->start = $start;
            // $play->end = $end;
            $play->status = 'pending';
            $play->save();

            // Ambil harga wahana berdasarkan id_wahana
            $wahana = Wahana::find($request->wahana);
            $harga = $wahana->harga; // Mengambil harga dari wahana yang dipilih

            // Hitung total harga berdasarkan durasi (harga wahana * durasi)
            $totalHarga = $harga * $durasiJam; // Durasi dalam jam
            $noTransaksi = 'TRS-' . now()->format('Ymd-His') . '-' . $play->id_play;

            // Membuat transaksi baru
            $transaksi = new Transaksi();
            $transaksi->id_play = $play->id_play; // Mengisi id_play dengan ID play yang baru ditambahkan
            $transaksi->no_transaksi = $noTransaksi;
            $transaksi->harga = $totalHarga; // Mengisi harga dengan total harga (harga wahana * durasi)
            $transaksi->bayar = 0; // Nilai default bayar
            $transaksi->kembalian = 0; // Nilai default kembalian
            $transaksi->status = 'pending'; // Status transaksi default
            $transaksi->save();


            // Redirect ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('success', 'Berhasil menambahkan data anak.');
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan data anak. Silakan coba lagi.']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $play = Play::find($id);
        if ($play) {
            $play->status = $request->status;
            $play->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }




    public function play_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Anak.',
        ]);
        // Cari data user berdasarkan ID
        $play = Play::findOrFail($id);

        $play->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data user berhasil dihapus');
    }

    public function e_wahana($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit Wahana.',
        ]);

        // Mencari pengguna berdasarkan ID
        $wahana = wahana::findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_wahana', compact('wahana'));
        echo view('footer');
    }

    public function updateDetail(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Mengupdate Wahana.',
        ]);

        try {
            // Validasi input
            $request->validate([
                'nama_wahana' => 'required',
                'harga' => 'required',
                // Validasi lain sesuai kebutuhan
            ]);

            // Mencari user berdasarkan ID
            $wahana = wahana::findOrFail($request->input('id'));

            // Perbarui data user
            $wahana->nama_wahana = $request->input('nama_wahana');
            $wahana->harga = $request->input('harga');
            $wahana->save();

            // Redirect dengan pesan sukses
            return redirect()->route('wahana', $wahana->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }

    public function getData($id_play)
    {
        $transaksi = Transaksi::where('id_play', $id_play)->first();

        if (!$transaksi) {
            return response()->json(['error' => 'Data transaksi tidak ditemukan'], 404);
        }

        return response()->json([
            'no_transaksi' => $transaksi->no_transaksi,
            'harga' => $transaksi->harga,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_play' => 'required|exists:play,id_play', // Pastikan id_play ada di tabel play
            'bayar' => 'required|integer|min:0',
            'kembalian' => 'required|integer|min:0',
        ]);

        // Cari transaksi berdasarkan id_play
        $transaksi = Transaksi::where('id_play', $request->id_play)->first();

        if (!$transaksi) {
            return redirect()->back()->withErrors(['error' => 'Transaksi tidak ditemukan']);
        }

        // Update data transaksi
        $transaksi->bayar = $request->bayar;
        $transaksi->kembalian = $request->kembalian;
        $transaksi->status = 'completed'; // Atur status menjadi selesai
        $transaksi->updated_at = now();
        $transaksi->save();

        $play = Play::where('id_play', $request->id_play)->first();

        $start = now();
        // Ambil durasi jam dari request
        $durasiJam = (int) filter_var($play->durasi, FILTER_SANITIZE_NUMBER_INT);

        // Hitung waktu akhir dengan menambah durasi jam ke waktu sekarang
        $end = $start->copy()->addHours($durasiJam);

        $play->start = $start;
        $play->end = $end;
        $play->status = 'active';
        $play->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui');
    }

    public function sendWhatsapp($id_play)
    {
        Log::info("sendWhatsapp called for play ID: {$id_play}");

        // Ambil data play berdasarkan id
        $dataPlay = DB::table('play')
            ->join('wahana', 'play.id_wahana', '=', 'wahana.id_wahana') // Join dengan tabel wahana
            ->where('play.id_play', $id_play)
            ->select('play.nama_anak', 'play.nohp', 'wahana.nama_wahana', 'play.durasi') // Pilih kolom yang diperlukan
            ->first();

        // Pastikan ada data yang ditemukan
        if ($dataPlay) {
            Log::info("Data play found for ID: {$id_play}");

            // Format nomor WhatsApp (misalnya, ke nomor orang tua)
            $nohp = $dataPlay->nohp;

            // Pesan yang akan dikirim
            $message = "🎉 **Pengumuman** 🎉\n\nWaktu untuk anak **{$dataPlay->nama_anak}** pada wahana **{$dataPlay->nama_wahana}** dengan durasi **{$dataPlay->durasi}** sudah **habis**! ⏰\n\nSemoga Anak-Anak anda menikmati waktunya! Jangan lupa untuk check-in di wahana lainnya! 🏰🎢";

            $params = [
                'token' => 'j3npmeiwh775lm7e',
                'to' => $this->formatWhatsappNumber($nohp),
                'body' => $message,
                'priority' => '1',
            ];

            // Kirim pesan menggunakan cURL
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "https://api.ultramsg.com/instance103952/messages/chat",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => [
                    "content-type: application/x-www-form-urlencoded"
                ],
            ]);

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            // Log hasil
            if ($err) {
                Log::error("cURL Error #: " . $err);
            } else {
                Log::info("Respon dari API: " . $response);
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'fail', 'message' => 'Data not found']);
    }



    // Fungsi untuk memformat nomor ke format internasional
    private function formatWhatsappNumber($number)
    {
        // Hapus karakter non-digit
        $number = preg_replace('/\D/', '', $number);

        // Tambahkan kode negara jika hilang
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1); // Ganti 0 di awal dengan 62
        }

        // Tambahkan suffix untuk WhatsApp API
        return $number . '@c.us';
    }


    public function addTime(Request $request)
{
    // Log data yang diterima dari request
    Log::info('AddTime Request Data', [
        'id_play' => $request->id_play,
        'durasi' => $request->durasi,
        'harga' => $request->harga,
        'bayar' => $request->bayar,
        'kembalian' => $request->kembalian
    ]);

    // Validasi input
    $request->validate([
        'id_play' => 'required|exists:play,id_play',
        'durasi' => 'required|numeric|min:1|max:5',
        'harga' => 'required|numeric',
        'bayar' => 'required|numeric',
        'kembalian' => 'required|numeric'
    ]);

    DB::beginTransaction();

    try {
        // Fungsi untuk mengonversi nilai dengan aman
        $safeFloat = function($value) {
            // Mengonversi nilai ke float jika valid, jika tidak, set ke 0
            return is_numeric($value) ? floatval($value) : 0;
        };

        // Mengonversi input dengan aman
        $harga = $safeFloat($request->harga);
        $bayar = $safeFloat($request->bayar);
        $kembalian = $safeFloat($request->kembalian);

        // Log nilai yang sudah dikonversi
        Log::info('Converted Values', [
            'harga' => $harga,
            'bayar' => $bayar,
            'kembalian' => $kembalian
        ]);

        // Cari play
        $play = Play::findOrFail($request->id_play);

        // Cari atau buat transaksi
        $transaksi = Transaksi::firstOrNew([
            'id_play' => $request->id_play
        ]);

        // Pastikan bahwa kolom harga, bayar, kembalian numerik
        $currentHarga = is_numeric($transaksi->harga) ? floatval($transaksi->harga) : 0;
        $currentBayar = is_numeric($transaksi->bayar) ? floatval($transaksi->bayar) : 0;
        $currentKembalian = is_numeric($transaksi->kembalian) ? floatval($transaksi->kembalian) : 0;

        Log::info('Current Transaksi Values', [
            'currentHarga' => $currentHarga,
            'currentBayar' => $currentBayar,
            'currentKembalian' => $currentKembalian
        ]);

        // Tambahkan nilai baru
        $transaksi->harga = $currentHarga + $harga;
        $transaksi->bayar = $currentBayar + $bayar;
        $transaksi->kembalian = $currentKembalian + $kembalian;

        // Simpan transaksi
        $transaksi->save();

        // Update durasi play
        $currentDurasi = $play->durasi ?? 0;
        $newDurasi = $currentDurasi + $request->durasi;

        // Hitung waktu end baru
        $currentEndTime = $play->end ? Carbon::parse($play->end) : Carbon::parse($play->start);
        $newEndTime = $currentEndTime->addHours($request->durasi);

        // Update play
        $play->durasi = $newDurasi;
        $play->end = $newEndTime;
        $play->save();

        // Log aktivitas
        ActivityLog::create([
            'action' => 'update',
            'user_id' => Session::get('id'),
            'description' => "Menambah waktu bermain {$request->durasi} jam untuk Play ID {$request->id_play}"
        ]);

        // Commit transaksi
        DB::commit();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil menambah waktu bermain.');

    } catch (\Exception $e) {
        // Rollback transaksi
        DB::rollBack();

        // Log error secara mendetail
        Log::error('Gagal menambah waktu', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        // Redirect dengan pesan error
        return redirect()->back()->withErrors(['msg' => 'Gagal menambah waktu: ' . $e->getMessage()]);
    }
}



    
}
