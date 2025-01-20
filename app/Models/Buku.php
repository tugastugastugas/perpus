<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Authenticatable
{
    use HasFactory;

    protected $table = 'buku'; 
    protected $primaryKey = 'id_buku'; 

    protected $fillable = [
        'id_kategori',
        'kode_buku',
        'nama_buku',
        'pengarang',
        'genre',
        'penerbit',
        'tahun_terbit',
        'file_buku',
        'cover_buku',
        'tanggal_upload',
        'created_at',
        'updated_at',
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
