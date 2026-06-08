<?php

use App\Http\Controllers\Front\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\TiketController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\Admin\KatalogController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/* --- PUBLIC ROUTES --- */
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('pages')->group(function () {
    Route::get('/tentang-tmii', function () { return view('front.tentang'); })->name('tentang.tmii');
    Route::get('/tiket-informasi', function () { return view('front.tiket-info'); })->name('tiket.info');
    Route::get('/museum-informasi', function () { return view('front.museum-info'); })->name('museum.info');
    Route::get('/wahana-informasi', function () { return view('front.wahana-info'); })->name('wahana.info');
    
    // --- MENU JELAJAHI (Panggil dari LandingController) ---
    Route::get('/jelajahi/anjungan', [LandingController::class, 'anjunganDetail'])->name('anjungan.index');
    Route::get('/jelajahi/museum', [LandingController::class, 'museumDetail'])->name('museum.detail');
    Route::get('/jelajahi/wahana', [LandingController::class, 'wahanaDetail'])->name('wahana.detail');
    Route::get('/jelajahi/item/{slug}', [LandingController::class, 'katalogDetail'])->name('katalog.show');
    
    // --- ARTIKEL / BERITA (INI YANG TADI LU LUPA MASUKIN) ---
    Route::get('/artikel', [LandingController::class, 'artikelIndex'])->name('artikel.index');
    Route::get('/artikel/{slug}', [LandingController::class, 'artikelDetail'])->name('artikel.detail');
    
    // --- HUBUNGI KAMI ---
    Route::get('/hubungi-kami', function () { return view('front.hubungi'); })->name('hubungi.kami');

    // --- FITUR BELI TIKET ---
    Route::get('/beli-tiket', [LandingController::class, 'beliTiket'])->name('beli-tiket');
    Route::get('/beli-tiket/checkout/{id}', [LandingController::class, 'checkout'])->name('checkout');
});

// Proses Kirim Pesan dari Halaman Hubungi Kami
Route::post('/hubungi-kami', [PesanController::class, 'store'])->name('hubungi.store');

/* --- AUTH ROUTES --- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/* --- ADMIN ROUTES (PROTECTED) --- */
Route::middleware(['auth', 'role:super-admin|staff|pimpinan'])->prefix('admin')->group(function () {
    
    // Dashboard (Bisa diakses semua role internal)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Manajemen Operasional (Super Admin & Staff)
    Route::middleware(['role:super-admin|staff'])->group(function () {
        // Manajemen Tiket & Artikel
        Route::resource('tikets', TiketController::class);
        Route::resource('artikels', ArtikelController::class);
        
        // Manajemen Katalog (Jelajahi: Anjungan, Museum, Wahana)
        Route::resource('katalogs', KatalogController::class);
        
        // Kelola Pesan dari Hubungi Kami
        Route::get('/pesan', [PesanController::class, 'index'])->name('admin.pesan.index');
        Route::get('/pesan/{id}', [PesanController::class, 'show'])->name('admin.pesan.show');
    });

    // Aksi Krusial Khusus Super Admin
    Route::middleware(['role:super-admin'])->group(function () {
        Route::delete('/pesan/{id}', [PesanController::class, 'destroy'])->name('admin.pesan.destroy');
        
        // Pengaturan Konten Dinamis
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    });

});