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
        ->where('play.status', 'active') // Hanya ambil yang active
        ->orderBy('play.durasi', 'asc') // Urutkan berdasarkan durasi terpendek
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

    // Ambil data dengan status completed (Selesai), urutkan berdasarkan durasi terpendek
    $playCompleted = DB::table('play')
        ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
        ->where('play.status', 'completed') // Hanya ambil yang completed
        ->orderBy('play.durasi', 'asc') // Urutkan berdasarkan durasi terpendek
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
            'durasi' => 'required|string',
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
        $play->start = $start;
        $play->end = $end;
        $play->status = 'active';
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
}
