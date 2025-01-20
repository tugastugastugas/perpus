<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class KategoriController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function kategori()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke kategori.',
        ]);
        $kategori = Kategori::all();
        echo view('header');
        echo view('menu');
        echo view('kategori', compact('kategori'));
        echo view('footer');
    }

    public function t_kategori(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah kategori.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'nama_kategori' => 'required',
            ]);

            // Simpan data ke tabel user
            $kategori = new kategori(); // Ubah variabel dari $quiz menjadi $kategori untuk kejelasan
            $kategori->nama_kategori = $request->input('nama_kategori');

            // Simpan ke database
            $kategori->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function kategori_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Kategori.',
        ]);
        // Cari data user berdasarkan ID
        $kategori = kategori::findOrFail($id);

        $kategori->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('kategori')->with('success', 'Data user berhasil dihapus');
    }

    public function e_kategori($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit kategori.',
        ]);

        // Mencari pengguna berdasarkan ID
        $kategori = kategori::findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_kategori', compact('kategori'));
        echo view('footer');
    }

    public function updateDetail(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Mengupdate kategori.',
        ]);

        try {
            // Validasi input
            $request->validate([
                'nama_kategori' => 'required',
                // Validasi lain sesuai kebutuhan
            ]);

            // Mencari user berdasarkan ID
            $kategori = kategori::findOrFail($request->input('id'));

            // Perbarui data user
            $kategori->nama_kategori = $request->input('nama_kategori');
            $kategori->save();

            // Redirect dengan pesan sukses
            return redirect()->route('kategori', $kategori->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }
}
