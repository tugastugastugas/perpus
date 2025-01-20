<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Authenticatable
{
    use HasFactory;

    protected $table = 'kelas'; 
    protected $primaryKey = 'id_kelas'; 

    protected $fillable = [
        'nama_kelas',
        'tanggal_terakhir_upload',
        'created_at',
        'updated_at',
    ];

}
