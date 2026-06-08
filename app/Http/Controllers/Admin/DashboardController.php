<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Artikel;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil jumlah total data
        $totalTiket = Tiket::count();
        $totalArtikel = Artikel::count();

        // Data Real untuk Grafik (Jumlah Destinasi per Kategori)
        $katalogCounts = \App\Models\Katalog::select('kategori', \DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();
        $chartLabels = $katalogCounts->pluck('kategori');
        $chartData = $katalogCounts->pluck('total');

        // Mengirim data ke view dashboard
        return view('admin.dashboard', compact('totalTiket', 'totalArtikel', 'chartLabels', 'chartData'));
    }
}