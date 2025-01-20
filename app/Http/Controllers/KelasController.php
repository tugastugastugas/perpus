<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Kelas;
use App\Models\UserHistory;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class KelasController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function kelas()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke kelas.',
        ]);
        $kelas = kelas::all();
        echo view('header');
        echo view('menu');
        echo view('kelas', compact('kelas'));
        echo view('footer');
    }

    public function t_kelas(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Kelas.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'nama_kelas' => 'required',
            ]);

            // Simpan data ke tabel user
            $kelas = new kelas(); // Ubah variabel dari $quiz menjadi $kelas untuk kejelasan
            $kelas->nama_kelas = $request->input('nama_kelas');

            // Simpan ke database
            $kelas->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function kelas_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus kelas.',
        ]);
        // Cari data user berdasarkan ID
        $kelas = kelas::findOrFail($id);

        $kelas->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('kelas')->with('success', 'Data user berhasil dihapus');
    }

    public function e_kelas($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit kelas.',
        ]);

        // Mencari pengguna berdasarkan ID
        $kelas = kelas::findOrFail($id);

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_kelas', compact('kelas'));
        echo view('footer');
    }

    public function updateDetail(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Mengupdate Kelas.',
        ]);

        try {
            // Validasi input
            $request->validate([
                'nama_kelas' => 'required',
                // Validasi lain sesuai kebutuhan
            ]);

            // Mencari user berdasarkan ID
            $kelas = kelas::findOrFail($request->input('id'));

            // Perbarui data user
            $kelas->nama_kelas = $request->input('nama_kelas');
            $kelas->save();

            // Redirect dengan pesan sukses
            return redirect()->route('kelas', $kelas->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }
}
