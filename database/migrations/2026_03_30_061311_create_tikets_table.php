<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->string('nama_tiket');
        $table->text('deskripsi');
        $table->string('booking_url')->nullable();
        $table->bigInteger('harga'); 
        $table->integer('stok')->default(0);
        $table->string('gambar')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
