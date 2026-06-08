<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedKeys = [
            'site_name', 'footer_description', 'contact_email', 'contact_whatsapp',
            'facebook_url', 'instagram_url', 'tiktok_url', 'youtube_url',
            'map_latitude', 'map_longitude', 'map_gmaps_url', 'map_image',
            'hero_bg_1', 'hero_title_1', 'hero_p_1',
            'hero_bg_2', 'hero_title_2', 'hero_p_2',
            'hero_bg_3', 'hero_title_3', 'hero_p_3',
            'home_intro_image', 'home_intro_title', 'home_intro_text', 'instagram_embed',
            'about_hero_image', 'about_history_title', 'about_history_content',
            'pilar_green_desc', 'pilar_inclusive_desc', 'pilar_culture_desc', 'pilar_smart_desc',
            'stat_area', 'stat_anjungan', 'stat_museum', 'stat_years',
            'opening_gate_1', 'opening_gate_3', 'opening_gate_4',
            'price_entrance', 'price_car', 'price_motor', 'price_bicycle', 'price_bus', 'price_truck',
            'tiket_notes', 'tiket_facilities'
        ];

        $data = $request->only($allowedKeys);

        foreach ($data as $key => $value) {
            // Check if it's a file upload
            if ($request->hasFile($key)) {
                // Validasi berkas secara ketat agar hanya gambar yang diperbolehkan masuk (max 2MB)
                $request->validate([
                    $key => 'image|mimes:jpeg,png,jpg,webp,svg'
                ]);

                $file = $request->file($key);
                // Bersihkan nama file dari spasi dan karakter khusus agar terhindar dari path traversal
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
                $file->storeAs('settings', $filename, 'public');
                $value = 'settings/' . $filename;
            }

            // Untuk setting baru yang dibuat dinamis via form admin, tentukan group & type secara otomatis
            $settingData = ['value' => $value];
            if ($key === 'map_image') {
                $settingData['group'] = 'general';
                $settingData['type'] = 'image';
            } elseif ($key === 'instagram_embed') {
                $settingData['group'] = 'home';
                $settingData['type'] = 'textarea';
            }

            Setting::updateOrCreate(['key' => $key], $settingData);
            // Clear cache agar perubahan langsung terlihat
            Cache::forget('setting_' . $key);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
