<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Authenticatable
{
    use HasFactory;

    protected $table = 'transaksi'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_transaksi'; // Menetapkan primary key yang benar

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'no_transaksi',
        'id_play',
        'harga',
        'bayar',
        'kembalian',
        'status',
        'created_at',
        'updated_at',
    ];

}
