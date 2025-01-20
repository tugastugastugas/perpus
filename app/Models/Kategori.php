<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Authenticatable
{
    use HasFactory;

    protected $table = 'kategori'; 
    protected $primaryKey = 'id_kategori'; 

    protected $fillable = [
        'nama_kategori',
        'created_at',
        'updated_at',
    ];

}
