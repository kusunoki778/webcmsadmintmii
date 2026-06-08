<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menghapus tabel yang dianggap gaguna
        Schema::dropIfExists('landing_pages');
    }

    public function down(): void
    {
        // Jika rollback, buat kembali tabelnya (opsional)
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('museum_title')->nullable();
            $table->text('museum_text')->nullable();
            $table->string('wahana_title')->nullable();
            $table->text('wahana_text')->nullable();
            $table->string('anjungan_title')->nullable();
            $table->text('anjungan_text')->nullable();
            $table->timestamps();
        });
    }
};