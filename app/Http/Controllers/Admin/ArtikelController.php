<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('admin.artikels.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $data = $request->only(['judul', 'konten', 'gambar']);
        $data['kategori'] = 'Berita';
        
        // Bikin URL SEO otomatis dan pastikan unik
        $slug = Str::slug($request->judul);
        $original_slug = $slug;
        $count = 1;
        while (Artikel::where('slug', $slug)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;
        $data['user_id'] = Auth::id(); // Mengambil ID admin yang sedang login
        $data['tanggal_publish'] = now();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/artikels'), $nama_file);
            $data['gambar'] = $nama_file;
        }

        Artikel::create($data);
        return redirect()->route('artikels.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikels.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp'
        ]);

        $artikel = Artikel::findOrFail($id);
        $data = $request->only(['judul', 'konten', 'gambar']);
        $data['kategori'] = 'Berita';
        
        // Pastikan slug unik saat update (kecuali milik sendiri)
        $slug = Str::slug($request->judul);
        $original_slug = $slug;
        $count = 1;
        while (Artikel::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                File::delete(public_path('storage/artikels/' . $artikel->gambar));
            }
            $file = $request->file('gambar');
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/artikels'), $nama_file);
            $data['gambar'] = $nama_file;
        }

        $artikel->update($data);
        return redirect()->route('artikels.index')->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar) {
            File::delete(public_path('storage/artikels/' . $artikel->gambar));
        }
        $artikel->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}