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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            
            // Bagian Hero (Atas)
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            
            // Bagian Museum
            $table->string('museum_title')->nullable();
            $table->text('museum_text')->nullable();
            
            // Bagian Wahana
            $table->string('wahana_title')->nullable();
            $table->text('wahana_text')->nullable();
            
            // Bagian Anjungan
            $table->string('anjungan_title')->nullable();
            $table->text('anjungan_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};