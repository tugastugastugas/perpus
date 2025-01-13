<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wahana extends Authenticatable
{
    use HasFactory;

    protected $table = 'wahana'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_wahana'; // Menetapkan primary key yang benar

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'nama_wahana',
        'harga',
        'created_at',
        'updated_at',
    ];

}
