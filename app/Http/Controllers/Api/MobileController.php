<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\Katalog;
use App\Models\Tiket;
use App\Models\Setting;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    /**
     * Mengambil daftar Artikel untuk Beranda
     */
    public function artikels()
    {
        // Ambil 3 artikel terbaru
        $artikels = Artikel::whereNotIn('kategori', ['Halaman', 'Anjungan'])
                           ->latest()
                           ->take(3)
                           ->get();
                           
        return response()->json([
            'status' => 'success',
            'data' => $artikels
        ]);
    }

    /**
     * Mengambil daftar Anjungan Daerah
     */
    public function anjungan()
    {
        $anjungans = Katalog::where('kategori', 'Anjungan')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $anjungans
        ]);
    }

    /**
     * Mengambil daftar Wahana
     */
    public function wahana()
    {
        $wahanas = Katalog::where('kategori', 'Wahana')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $wahanas
        ]);
    }

    /**
     * Mengambil daftar Museum
     */
    public function museum()
    {
        $museums = Katalog::where('kategori', 'Museum')->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $museums
        ]);
    }

    /**
     * Mengambil settings/konfigurasi untuk mobile app
     */
    public function settings()
    {
        $keys = [
            'site_name',
            'contact_email',
            'contact_whatsapp',
            'facebook_url',
            'instagram_url',
            'tiktok_url',
            'youtube_url',
            'map_latitude',
            'map_longitude',
            'map_gmaps_url',
            'booking_url',
            'opening_gate_1',
            'opening_gate_3',
            'opening_gate_4',
            'about_history_content',
        ];

        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    /**
     * Mengambil daftar tiket untuk halaman Tiket mobile
     */
    public function tikets()
    {
        $tikets = Tiket::orderBy('harga', 'asc')->get();

        return response()->json([
            'status' => 'success',
            'data' => $tikets
        ]);
    }
}

