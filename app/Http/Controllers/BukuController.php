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
use App\Models\Buku;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class BukuController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function Buku()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Buku.',
        ]);
        $buku = Buku::with('kategori')->get();
        $kategori = Kategori::all();
        echo view('header');
        echo view('menu');
        echo view('buku', compact('kategori', 'buku'));
        echo view('footer');
    }

    public function t_buku(Request $request)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menambah Buku.',
        ]);

        try {
            // Validasi inputan
            $request->validate([
                'kategori' => 'required',
                'nama_buku' => 'required',
                'pengarang' => 'required',
                'genre' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
                'file_buku' => 'required',
                'cover_buku' => 'required',
            ]);

            $lastBook = Buku::orderBy('id_buku', 'desc')->first(); // Ambil buku terakhir berdasarkan ID
            $lastId = $lastBook ? $lastBook->id_buku : 0; // Ambil ID terakhir atau 0 jika belum ada buku
            $newId = $lastId + 1; // Tambahkan 1 untuk kode baru
            $kodeBuku = 'BKU' . str_pad($newId, 6, '0', STR_PAD_LEFT);

            // Simpan data ke tabel user
            $buku = new buku(); // Ubah variabel dari $quiz menjadi $buku untuk kejelasan
            $buku->id_kategori = $request->input('kategori');
            $buku->kode_buku = $kodeBuku;
            $buku->nama_buku = $request->input('nama_buku');
            $buku->pengarang = $request->input('pengarang');
            $buku->genre = $request->input('genre');
            $buku->penerbit = $request->input('penerbit');
            $buku->tahun_terbit = $request->input('tahun_terbit');
            $buku->tanggal_upload = now();

            if ($request->hasFile('cover_buku')) {
                $cover_buku = $request->file('cover_buku');
                $cover_buku_name = $cover_buku->getClientOriginalName();  // Mendapatkan nama asli file
                $buku->cover_buku = $cover_buku->storeAs('cover_buku', $cover_buku_name, 'public');  // Menyimpan dengan nama asli
            }
    
            if ($request->hasFile('file_buku')) {
                $file_buku = $request->file('file_buku');
                $file_buku_name = $file_buku->getClientOriginalName();  // Mendapatkan nama asli file
                $buku->file_buku = $file_buku->storeAs('file_buku', $file_buku_name, 'public');  // Menyimpan dengan nama asli
            }
            // Simpan ke database
            $buku->save();

            // Redirect ke halaman lain
            return redirect()->back()->withErrors(['msg' => 'Berhasil Menambahkan Akun.']);
        } catch (\Exception $e) {
            Log::error('Gagal : ' . $e->getMessage());
            return redirect()->back()->withErrors(['msg' => 'Gagal menambahkan akun. Silakan coba lagi.']);
        }
    }


    public function buku_destroy($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Menghapus Buku.',
        ]);
        // Cari data user berdasarkan ID
        $buku = buku::findOrFail($id);

        $buku->delete(); // Simpan perubahan

        // Redirect dengan pesan sukses
        return redirect()->route('buku')->with('success', 'Data user berhasil dihapus');
    }

    public function e_buku($id)
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User Masuk Ke Edit Buku.',
        ]);

        // Mencari pengguna berdasarkan ID
        $buku = buku::with('kategori')->findOrFail($id);
        $kategori = kategori::all();

        // Mengembalikan view dengan data pengguna dan level
        echo view('header');
        echo view('menu');
        echo view('e_buku', compact('kategori', 'buku'));
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
                'kategori' => 'required',
                'nama_buku' => 'required',
                'pengarang' => 'required',
                'genre' => 'required',
                'penerbit' => 'required',
                'tahun_terbit' => 'required',
                'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'file_buku' => 'nullable|mimes:pdf,docx|max:10000',
            ]);

            // Mencari buku berdasarkan ID
            $buku = buku::findOrFail($request->id_buku);

            // Update data buku
            $buku->id_kategori = $request->kategori;
            $buku->nama_buku = $request->nama_buku;
            $buku->pengarang = $request->pengarang;
            $buku->genre = $request->genre;
            $buku->penerbit = $request->penerbit;
            $buku->tahun_terbit = $request->tahun_terbit;

            // Menangani upload cover buku
            if ($request->hasFile('cover_buku')) {
                $cover_buku = $request->file('cover_buku');
                $cover_buku_name = $cover_buku->getClientOriginalName();  
                $buku->cover_buku = $cover_buku->storeAs('cover_buku', $cover_buku_name, 'public');
            }

            // Menangani upload file buku
            if ($request->hasFile('file_buku')) {
                $file_buku = $request->file('file_buku');
                $file_buku_name = $file_buku->getClientOriginalName();  
                $buku->file_buku = $file_buku->storeAs('file_buku', $file_buku_name, 'public');
            }

            // Simpan perubahan
            $buku->save();
            // Redirect dengan pesan sukses
            return redirect()->route('buku', $buku->id)->with('success', 'Detail pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            // Log error
            Log::error('Gagal memperbarui detail pengguna: ' . $e->getMessage());

            // Redirect kembali dengan pesan kesalahan
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui detail pengguna. Silakan coba lagi.']);
        }
    }
}
