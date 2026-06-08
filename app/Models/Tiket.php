<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    // Kasih tahu Laravel kalau tabel ini namanya 'tikets'
    protected $table = 'tikets';

    // Kolom yang boleh diisi manual lewat form
    protected $fillable = [
        'nama_tiket', 
        'warna',
        'deskripsi', 
        'harga', 
        'stok', 
        'gambar',
        'widget_code',
        'is_featured',
        'is_active',
        'has_tourist_types'
    ];
}