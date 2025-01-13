<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Play extends Authenticatable
{
    use HasFactory;

    protected $table = 'play'; // Menetapkan nama tabel jika tidak sesuai dengan konvensi
    protected $primaryKey = 'id_play'; // Menetapkan primary key yang benar

    // Daftar kolom yang dapat diisi massal
    protected $fillable = [
        'id_wahana',
        'nama_anak',
        'nohp',
        'start',
        'end',
        'durasi',
        'status',
        'created_at',
        'updated_at',
    ];

}
