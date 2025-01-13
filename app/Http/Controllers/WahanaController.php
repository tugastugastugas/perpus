<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Wahana;
use App\Models\UserHistory;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class WahanaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function wahana()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Wahana.',
        ]);
        $wahana = Wahana::all();
        echo view('header');
        echo view('menu');
        echo view('wahana', compact('wahana'));
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


    public function wahana_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Wahana.',
        ]);
        // Cari data user berdasarkan ID
        $wahana = Wahana::findOrFail($id);

        $wahana->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('wahana')->with('success', 'Data user berhasil dihapus');
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
