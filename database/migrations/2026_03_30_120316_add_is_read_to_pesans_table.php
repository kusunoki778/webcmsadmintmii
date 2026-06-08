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
        Schema::table('pesans', function (Blueprint $table) {
        // Default 0 artinya Belum Dibaca
        $table->boolean('is_read')->default(0)->after('pesan');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesans', function (Blueprint $table) {
            //
        });
    }
};
