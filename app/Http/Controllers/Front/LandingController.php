<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Tiket;
use App\Models\Artikel;
use App\Models\Katalog; 
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Halaman Utama (Welcome)
     */
    public function index()
    {
        $tikets = Tiket::all();
        
        $artikels = Artikel::whereNotIn('kategori', ['Halaman', 'Anjungan'])
                           ->latest()
                           ->take(3)
                           ->get();

        $wajah_anjungans = Katalog::where('kategori', 'Anjungan')->get();
        $wajah_museums = Katalog::where('kategori', 'Museum')->get();
        $wajah_wahanas = Katalog::where('kategori', 'Wahana')->get();
                           
        return view('welcome', compact('tikets', 'artikels', 'wajah_anjungans', 'wajah_museums', 'wajah_wahanas'));
    }

    /**
     * Halaman Anjungan Daerah (List)
     */
    public function anjunganDetail()
    {
        // Ambil semua data katalog kategori Anjungan
        $anjungans = Katalog::where('kategori', 'Anjungan')->get();
        return view('front.anjungan-detail', compact('anjungans'));
    }

    /**
     * Halaman Museum (List)
     */
    public function museumDetail()
    {
        $museums = Katalog::where('kategori', 'Museum')->get();
        return view('front.museum-detail', compact('museums'));
    }

    /**
     * Halaman Wahana Rekreasi (List)
     */
    public function wahanaDetail()
    {
        $wahanas = Katalog::where('kategori', 'Wahana')->get();
        return view('front.wahana-detail', compact('wahanas'));
    }

    /**
     * Halaman Katalog Beli Tiket
     */
    public function beliTiket()
    {
        $tikets = Tiket::where('is_active', true)->orderBy('is_featured', 'desc')->get();
        return view('front.beli-tiket', compact('tikets'));
    }

    /**
     * Halaman Checkout Embed Goers
     */
    public function checkout($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('front.checkout', compact('tiket'));
    }

    /**
     * Halaman Baca Detail Katalog (Anjungan, Museum, Wahana)
     */
    public function katalogDetail($slug)
    {
        // Cari katalog berdasarkan slug
        $katalog = Katalog::where('slug', $slug)->firstOrFail();
        
        // Ambil 4 rekomendasi lain dari kategori yang sama
        $lainnya = Katalog::where('kategori', $katalog->kategori)
                          ->where('id', '!=', $katalog->id)
                          ->latest()
                          ->take(4)
                          ->get();
                          
        return view('front.katalog-single', compact('katalog', 'lainnya'));
    }

    // ==========================================
    // INI 2 FUNGSI BARU YANG TADI LU KELEWATAN
    // ==========================================

    /**
     * Halaman Daftar Semua Artikel (Blog)
     */
    public function artikelIndex()
    {
        // Ambil artikel, urutkan dari yang terbaru, kasih pagination 6 per halaman
        $artikels = Artikel::latest()->paginate(6);
        return view('front.artikel.index', compact('artikels'));
    }

    /**
     * Halaman Baca Artikel Detail
     */
    public function artikelDetail($slug)
    {
        // Cari artikel berdasarkan slug
        $artikel = Artikel::where('slug', $slug)->firstOrFail();
        
        // Ambil 3 artikel lain buat rekomendasi di bawah
        $artikel_lain = Artikel::where('id', '!=', $artikel->id)->latest()->take(3)->get();
        
        return view('front.artikel.detail', compact('artikel', 'artikel_lain'));
    }
}