<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use Illuminate\Support\Facades\File; // Gunakan File untuk urusan hapus manual

class TiketController extends Controller
{
    public function index()
    {
        $tikets = Tiket::all(); 
        return view('admin.tikets.index', compact('tikets'));
    }

    public function create()
    {
        return view('admin.tikets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tiket' => 'required|string|max:255',
            'warna' => 'required|string|max:7',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'widget_code' => 'nullable|string',
        ]);
          
        $data = $request->only(['nama_tiket', 'warna', 'deskripsi', 'gambar', 'widget_code']);
        $data['harga'] = 0;
        $data['stok'] = 0;
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['has_tourist_types'] = $request->has('has_tourist_types');

        // Cek limit featured tickets (maksimal 3)
        if ($data['is_featured']) {
            $featuredCount = Tiket::where('is_featured', true)->count();
            if ($featuredCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Gagal! Maksimal tiket unggulan (Featured) hanya boleh 3 tiket.');
            }
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            // Bersihkan nama file secara ketat agar aman dari exploitasi URL dan path traversal
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            
            // Simpan LANGSUNG ke folder public agar pasti muncul
            $file->move(public_path('storage/tikets'), $nama_file); 
            
            $data['gambar'] = $nama_file;
        }

        Tiket::create($data);

        return redirect()->route('tikets.index')->with('success', 'Tiket berhasil disimpan!');
    }

    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('admin.tikets.edit', compact('tiket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([        
            'nama_tiket' => 'required|string|max:255',
            'warna' => 'required|string|max:7',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'widget_code' => 'nullable|string',
        ]);

        $tiket = Tiket::findOrFail($id);
        $data = $request->only(['nama_tiket', 'warna', 'deskripsi', 'gambar', 'widget_code']);
        $data['harga'] = 0;
        $data['stok'] = 0;
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');
        $data['has_tourist_types'] = $request->has('has_tourist_types');

        // Cek limit jika tiket ini sebelumnya bukan featured tapi sekarang mau dijadikan featured
        if ($data['is_featured'] && !$tiket->is_featured) {
            $featuredCount = Tiket::where('is_featured', true)->count();
            if ($featuredCount >= 3) {
                return redirect()->back()->withInput()->with('error', 'Gagal! Sudah ada 3 tiket unggulan. Nonaktifkan salah satu sebelum menambah yang baru.');
            }
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($tiket->gambar) {
                $pathLama = public_path('storage/tikets/' . $tiket->gambar);
                if (File::exists($pathLama)) {
                    File::delete($pathLama);
                }
            }

            $file = $request->file('gambar');
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/tikets'), $nama_file);
            $data['gambar'] = $nama_file;
        }

        $tiket->update($data);

        return redirect()->route('tikets.index')->with('success', 'Data tiket berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        
        if ($tiket->gambar) {
            $path = public_path('storage/tikets/' . $tiket->gambar);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $tiket->delete();

        return redirect()->route('tikets.index')->with('success', 'Tiket berhasil dihapus!');
    }
}