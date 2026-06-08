<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileController;

// Mobile API Routes with Rate Limiting (D-04)
Route::middleware('throttle:api')->group(function () {
    Route::get('/jelajahi/anjungan', [MobileController::class, 'anjungan']);
    Route::get('/jelajahi/wahana', [MobileController::class, 'wahana']);
    Route::get('/jelajahi/museum', [MobileController::class, 'museum']);
    Route::get('/beranda/artikel', [MobileController::class, 'artikels']);
    Route::get('/settings', [MobileController::class, 'settings']);
    Route::get('/tiket', [MobileController::class, 'tikets']);
});

// Contoh route dasar
Route::get('/user', function (Request $request) {
    return response()->json(['status' => 'success']);
});

// Proxy gambar untuk mengatasi masalah CORS di Flutter Web (Chrome) - Secured against Path Traversal (S-04)
Route::get('/image/{folder}/{filename}', function($folder, $filename) {
    $basePath = realpath(storage_path('app/public'));
    $targetPath = storage_path('app/public/' . $folder . '/' . $filename);
    $realTargetPath = realpath($targetPath);

    // Pastikan file ada dan berada di bawah folder base storage/app/public (mencegah directory traversal)
    if (!$realTargetPath || !$basePath || strpos($realTargetPath, $basePath) !== 0) {
        abort(404);
    }

    return response()->file($realTargetPath, [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
    ]);
});

