<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'judul', 
        'slug', 
        'kategori', 
        'konten', 
        'gambar', // Tambahkan ini
        'tanggal_publish'
    ];

    // Relasi ke User (Penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}