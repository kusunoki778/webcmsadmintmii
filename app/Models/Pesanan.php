<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tiket_id', 'nama_pembeli', 'email_pembeli', 'whatsapp', 
        'tanggal_kunjungan', 'jumlah_tiket', 'total_harga', 'status', 'kode_pesanan'
    ];

    // Relasi balik ke Tiket (Biar bisa manggil $pesanan->tiket->nama_tiket)
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}