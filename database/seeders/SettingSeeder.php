<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'TMII', 'group' => 'general', 'type' => 'text'],
            ['key' => 'footer_description', 'value' => 'Taman Mini Indonesia Indah adalah rangkuman keindahan budaya Indonesia dalam satu kawasan taman wisata yang menginspirasi.', 'group' => 'general', 'type' => 'textarea'],
            ['key' => 'contact_email', 'value' => 'info@tamanmini.com', 'group' => 'general', 'type' => 'text'],
            ['key' => 'contact_whatsapp', 'value' => '088289082184', 'group' => 'general', 'type' => 'text'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/tmiiofficial', 'group' => 'general', 'type' => 'text'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/tmiiofficial', 'group' => 'general', 'type' => 'text'],
            ['key' => 'tiktok_url', 'value' => 'https://tiktok.com/@tmiiofficial', 'group' => 'general', 'type' => 'text'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/tmiiofficial', 'group' => 'general', 'type' => 'text'],

            // Peta & Lokasi
            ['key' => 'map_latitude', 'value' => '-6.302481', 'group' => 'general', 'type' => 'text'],
            ['key' => 'map_longitude', 'value' => '106.894832', 'group' => 'general', 'type' => 'text'],
            ['key' => 'map_gmaps_url', 'value' => 'https://maps.app.goo.gl/taman-mini-indonesia-indah', 'group' => 'general', 'type' => 'text'],

            // Home Page
            ['key' => 'hero_bg_1', 'value' => '', 'group' => 'home', 'type' => 'image'],
            ['key' => 'hero_title_1', 'value' => 'Jelajahi Indonesia dalam Satu Tempat', 'group' => 'home', 'type' => 'text'],
            ['key' => 'hero_p_1', 'value' => 'Rasakan kemegahan budaya, keanekaragaman tradisi, dan keindahan alam Nusantara.', 'group' => 'home', 'type' => 'textarea'],
            ['key' => 'hero_bg_2', 'value' => '', 'group' => 'home', 'type' => 'image'],
            ['key' => 'hero_title_2', 'value' => 'Wajah Baru TMII', 'group' => 'home', 'type' => 'text'],
            ['key' => 'hero_p_2', 'value' => 'Destinasi wisata edukasi yang lebih nyaman, inklusif, dan ramah lingkungan.', 'group' => 'home', 'type' => 'textarea'],
            ['key' => 'hero_bg_3', 'value' => '', 'group' => 'home', 'type' => 'image'],
            ['key' => 'hero_title_3', 'value' => 'Tiket & Informasi', 'group' => 'home', 'type' => 'text'],
            ['key' => 'hero_p_3', 'value' => 'Cek harga tiket masuk dan rencanakan kunjungan seru Anda hari ini.', 'group' => 'home', 'type' => 'textarea'],
            ['key' => 'home_intro_image', 'value' => '', 'group' => 'home', 'type' => 'image'],
            ['key' => 'home_intro_title', 'value' => 'Taman Mini Indonesia Indah', 'group' => 'home', 'type' => 'text'],
            ['key' => 'home_intro_text', 'value' => "TMII adalah merangkum keindahan budaya Indonesia yang diaplikasikan dalam miniatur kepulauan nusantara di tengah danau, merepresentasikan berbagai suku dan budaya di Indonesia.\n\nSambutlah wajah baru TMII yang dirancang untuk lebih nyaman, inklusif, dan ramah lingkungan. Mari jelajahi kembali kekayaan Nusantara dalam satu destinasi harmoni.", 'group' => 'home', 'type' => 'textarea'],
            ['key' => 'instagram_embed', 'value' => '', 'group' => 'home', 'type' => 'textarea'],

            // About Page
            ['key' => 'about_hero_image', 'value' => '', 'group' => 'about', 'type' => 'image'],
            ['key' => 'about_history_title', 'value' => 'TMII Dulu dan Kini', 'group' => 'about', 'type' => 'text'],
            ['key' => 'about_history_content', 'value' => "Taman Mini Indonesia Indah (TMII) adalah sebuah kawasan taman wisata bertema budaya Indonesia yang terletak di Jakarta Timur. Diresmikan pada tanggal 20 April 1975, TMII dibangun atas prakarsa Ibu Tien Soeharto, istri Presiden Soeharto yang menjabat pada masa itu.\n\nVisi baru TMII adalah menjadi taman wisata budaya berkelas dunia yang mengedepankan pelestarian budaya, edukasi, dan hiburan keluarga. Dengan kombinasi antara nilai tradisional dan teknologi modern, TMII terus berupaya memberikan pengalaman terbaik bagi pengunjung dari berbagai kalangan.", 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'pilar_green_desc', 'value' => 'Komitmen terhadap pelestarian lingkungan dan pengembangan area hijau yang berkelanjutan', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'pilar_inclusive_desc', 'value' => 'Menciptakan ruang wisata yang dapat dinikmati oleh semua kalangan tanpa batasan', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'pilar_culture_desc', 'value' => 'Melestarikan dan mempromosikan kekayaan budaya Indonesia untuk generasi mendatang', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'pilar_smart_desc', 'value' => 'Mengintegrasikan teknologi modern untuk pengalaman wisata yang lebih baik', 'group' => 'about', 'type' => 'textarea'],
            ['key' => 'stat_area', 'value' => '250+', 'group' => 'about', 'type' => 'text'],
            ['key' => 'stat_anjungan', 'value' => '34', 'group' => 'about', 'type' => 'text'],
            ['key' => 'stat_museum', 'value' => '18', 'group' => 'about', 'type' => 'text'],
            ['key' => 'stat_years', 'value' => '48', 'group' => 'about', 'type' => 'text'],

            // Ticket Info Page
            ['key' => 'opening_gate_1', 'value' => '06:00 - 17:00 WIB', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'opening_gate_3', 'value' => '08:00 - 17:00 WIB', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'opening_gate_4', 'value' => '08:00 - 17:00 WIB', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_entrance', 'value' => 'Rp 25.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_car', 'value' => 'Rp 35.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_motor', 'value' => 'Rp 15.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_bicycle', 'value' => 'Rp 5.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_bus', 'value' => 'Rp 60.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'price_truck', 'value' => 'Rp 40.000', 'group' => 'tiket', 'type' => 'text'],
            ['key' => 'tiket_notes', 'value' => '<ul><li>Tiket masuk berlaku untuk satu kali kunjungan</li><li>Anak di bawah 3 tahun gratis</li><li>Harga dapat berubah sewaktu-waktu</li></ul>', 'group' => 'tiket', 'type' => 'textarea'],
            ['key' => 'tiket_facilities', 'value' => '<ul><li>Area parkir luas</li><li>Mushola dan toilet bersih</li><li>Food court dan restoran</li></ul>', 'group' => 'tiket', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
