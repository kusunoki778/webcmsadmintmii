<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Artikel;
use App\Models\Tiket; 
use App\Models\Katalog; // Pastikan model Katalog dipanggil
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- 0. MATIKAN CEK RELASI ---
        Schema::disableForeignKeyConstraints();

        // 1. PANGGIL ROLE SEEDER & SETTING SEEDER
        $this->call([
            RoleSeeder::class,
            SettingSeeder::class,
        ]);

        $admin = User::where('email', 'admin@tmii.com')->first();

        // 2. BUAT DATA TIKET
        DB::table('tikets')->truncate();
        DB::table('tikets')->insert([
            [
                'nama_tiket' => 'Tiket Masuk Reguler',
                'deskripsi' => 'Tiket masuk area TMII untuk semua umur.',
                'harga' => 25000,
                'stok' => 1000,
                'warna' => '#9333ea',
                'widget_code' => 'https://widget.goersapp.com/venues/schedules/demo-tmii--traintmii',
                'is_active' => true,
                'has_tourist_types' => true,
                'gambar' => 'card-anjungan.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tiket' => 'Tiket Kereta Gantung',
                'deskripsi' => 'Menikmati pemandangan miniatur Indonesia dari ketinggian.',
                'harga' => 50000,
                'stok' => 500,
                'warna' => '#0d9488',
                'widget_code' => 'https://widget.goersapp.com/venues/schedules/demo-tmii--traintmii',
                'is_active' => true,
                'has_tourist_types' => false,
                'gambar' => 'card-wahana.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_tiket' => 'Annual Pass',
                'deskripsi' => 'Akses unlimited ke TMII selama satu tahun penuh! Paling hemat.',
                'harga' => 500000,
                'stok' => 100,
                'warna' => '#eab308',
                'widget_code' => 'https://widget.goersapp.com/venues/schedules/demo-tmii--traintmii',
                'is_active' => true,
                'has_tourist_types' => false,
                'gambar' => 'peta-jelajah.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // 3. BUAT DATA ARTIKEL (KHUSUS BERITA DEPAN)
        DB::table('artikels')->truncate();
        
        $artikelData = [
            [
                'judul' => 'Pesona Baru Keong Emas',
                'kategori' => 'Wisata',
                'konten' => 'Teater Imax Keong Emas kini hadir dengan teknologi proyektor terbaru...',
                'tanggal_publish' => now(),
            ],
            [
                'judul' => 'Mengenal Budaya Lewat Anjungan Daerah',
                'kategori' => 'Budaya',
                'konten' => 'TMII memiliki 33 anjungan daerah yang merepresentasikan keberagaman...',
                'tanggal_publish' => now(),
            ]
        ];

        foreach ($artikelData as $item) {
            Artikel::create([
                'user_id' => $admin->id,
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']),
                'kategori' => $item['kategori'],
                'konten' => $item['konten'],
                'gambar' => 'hero-bg.jpg',
                'tanggal_publish' => $item['tanggal_publish'],
            ]);
        }

        // 4. BUAT DATA KATALOG (PENGGANTI LANDING PAGE)
        DB::table('katalogs')->truncate();
        
        $katalogData = [
            [
                'nama' => 'Anjungan Jawa Tengah',
                'kategori' => 'Anjungan',
                'deskripsi' => 'Anjungan Jawa Tengah menampilkan replika arsitektur tradisional yang menggambarkan kekayaan budaya dan sejarah. Pengunjung dapat melihat berbagai koleksi artefak budaya, pakaian adat, dan peralatan tradisional.',
                'gambar' => 'card-anjungan.jpg',
            ],
            [
                'nama' => 'Museum Indonesia',
                'kategori' => 'Museum',
                'deskripsi' => 'Kawasan ini tidak hanya menyajikan keindahan arsitektur daerah, tetapi juga menjadi pusat pelestarian dan edukasi melalui berbagai museum tematik yang dirancang untuk menjaga warisan peradaban bangsa.',
                'gambar' => 'card-museum.jpg',
            ],
            [
                'nama' => 'Kereta Gantung',
                'kategori' => 'Wahana',
                'deskripsi' => 'Wahana rekreasi yang menyajikan kombinasi sempurna antara hiburan dan keindahan alam. Rasakan sensasi melihat seluruh kepulauan Indonesia dari ketinggian dengan menaiki wahana ikonik ini.',
                'gambar' => 'card-wahana.jpg',
            ]
        ];

        foreach ($katalogData as $item) {
            Katalog::create([
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'kategori' => $item['kategori'],
                'deskripsi' => $item['deskripsi'],
                'gambar' => $item['gambar'],
            ]);
        }

        // --- 5. HIDUPKAN KEMBALI CEK RELASI ---
        Schema::enableForeignKeyConstraints();
    }
}