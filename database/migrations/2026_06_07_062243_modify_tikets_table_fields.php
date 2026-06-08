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
        Schema::table('tikets', function (Blueprint $table) {
            if (Schema::hasColumn('tikets', 'subtitle')) {
                $table->dropColumn('subtitle');
            }
            if (Schema::hasColumn('tikets', 'kategori')) {
                $table->dropColumn('kategori');
            }
            if (!Schema::hasColumn('tikets', 'warna')) {
                $table->string('warna')->default('#9333ea')->after('nama_tiket');
            }
            if (!Schema::hasColumn('tikets', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('stok');
            }
            if (!Schema::hasColumn('tikets', 'has_tourist_types')) {
                $table->boolean('has_tourist_types')->default(false)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            if (!Schema::hasColumn('tikets', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('nama_tiket');
            }
            if (!Schema::hasColumn('tikets', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_tiket');
            }
            if (Schema::hasColumn('tikets', 'warna')) {
                $table->dropColumn('warna');
            }
            if (Schema::hasColumn('tikets', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('tikets', 'has_tourist_types')) {
                $table->dropColumn('has_tourist_types');
            }
        });
    }
};
