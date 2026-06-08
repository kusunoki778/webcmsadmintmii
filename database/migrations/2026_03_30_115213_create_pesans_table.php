<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('telepon');
            $table->string('subjek');
            $table->text('pesan');
            $table->timestamps(); // Ini otomatis buat kolom created_at (kapan pesan dikirim)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesans');
    }
};