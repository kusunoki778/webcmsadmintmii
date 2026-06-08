<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('pesanans', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel tikets (Biar tahu tiket mana yang dibeli)
        $table->foreignId('tiket_id')->constrained('tikets')->onDelete('cascade');
        
        // Data Pembeli
        $table->string('nama_pembeli');
        $table->string('email_pembeli');
        $table->string('whatsapp');
        $table->date('tanggal_kunjungan');
        
        // Kalkulasi
        $table->integer('jumlah_tiket');
        $table->bigInteger('total_harga');
        
        // Status (Buat nanti kalau mau pake payment gateway)
        $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
        $table->string('kode_pesanan')->unique(); // Contoh: TMII-12345
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
