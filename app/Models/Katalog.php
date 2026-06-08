<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'katalogs';

    /**
     * Kolom yang boleh diisi (Mass Assignable)
     * Sesuai sama migration yang kita buat tadi
     */
    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'deskripsi',
        'gambar',
        'latitude',
        'longitude',
    ];
}