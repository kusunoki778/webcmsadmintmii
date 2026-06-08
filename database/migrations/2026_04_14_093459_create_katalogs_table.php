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
    Schema::create('katalogs', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); // Nama Museum/Wahana/Anjungan
        $table->string('slug')->unique(); // URL SEO Friendly
        $table->enum('kategori', ['Anjungan', 'Museum', 'Wahana']); // Pembeda kategori
        $table->text('deskripsi'); // Isi konten/cerita
        $table->string('gambar'); // Nama file foto utama
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalogs');
    }
};
