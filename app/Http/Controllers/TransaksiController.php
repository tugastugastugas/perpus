<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Wahana;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class TransaksiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function transaksi()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Transaksi.',
        ]);
       
        $transaksi = DB::table('transaksi')
        ->join('play', 'play.id_play', '=', 'transaksi.id_play')
        ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
        ->select(
            'wahana.nama_wahana',
            'play.nama_anak',
            'play.nohp',
            'play.start',
            'play.end',
            'play.id_play',
            'play.durasi',
            'play.id_wahana',
            'transaksi.id_transaksi',
            'transaksi.no_transaksi',
            'transaksi.harga',
            'transaksi.bayar',
            'transaksi.kembalian',
            'transaksi.status',
        )
        ->get();

        echo view('header');
        echo view('menu');
        echo view('transaksi', compact('transaksi'));
        echo view('footer');
    }

    public function t_wahana(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Wahana.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'nama_wahana' => 'required',
                'harga' => 'required',
            ]);

            // Simpan data ke tabel user
            $wahana = new Wahana(); // Ubah variabel dari $quiz menjadi $wahana untuk kejelasan
            $wahana->nama_wahana = $request->input('nama_wahana');
            $wahana->harga = $request->input('harga');

            // Simpan ke database
            $wahana->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function transaksi_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Transaksi.',
        ]);
        // Cari data user berdasarkan ID
        $transaksi = transaksi::findOrFail($id);

        $transaksi->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('transaksi')->with('success', 'Data user berhasil dihapus');
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

    public function print()
{
    $transaksi = DB::table('transaksi')
        ->join('play', 'transaksi.id_play', '=', 'play.id_play')
        ->join('wahana', 'play.id_wahana', '=', 'wahana.id_wahana')
        ->select('transaksi.no_transaksi', 'play.nama_anak', 'wahana.nama_wahana', 'transaksi.harga')
        ->get();

    $pdf = Pdf::loadView('transaksi.pdf', compact('transaksi'));
    return $pdf->download('laporan-transaksi.pdf');
}
}
