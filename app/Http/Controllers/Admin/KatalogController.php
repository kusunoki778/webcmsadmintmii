<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Katalog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class KatalogController extends Controller
{
    public function index()
    {
        $katalogs = Katalog::latest()->get();
        return view('admin.katalogs.index', compact('katalogs'));
    }

    public function create()
    {
        return view('admin.katalogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required|in:Anjungan,Museum,Wahana',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $data = $request->only(['nama', 'kategori', 'deskripsi', 'gambar']);
        
        // Bikin URL SEO otomatis dan pastikan unik
        $slug = Str::slug($request->nama);
        $original_slug = $slug;
        $count = 1;
        while (Katalog::where('slug', $slug)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/katalogs'), $nama_file);
            $data['gambar'] = $nama_file;
        }

        Katalog::create($data);
        return redirect()->route('katalogs.index')->with('success', 'Konten Jelajahi berhasil ditambah!');
    }

    public function edit($id)
    {
        $katalog = Katalog::findOrFail($id);
        return view('admin.katalogs.edit', compact('katalog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required|in:Anjungan,Museum,Wahana',
            'deskripsi' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp'
        ]);

        $katalog = Katalog::findOrFail($id);
        $data = $request->only(['nama', 'kategori', 'deskripsi', 'gambar']);
        
        // Pastikan slug unik saat update (kecuali milik sendiri)
        $slug = Str::slug($request->nama);
        $original_slug = $slug;
        $count = 1;
        while (Katalog::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $original_slug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('gambar')) {
            if ($katalog->gambar) {
                File::delete(public_path('storage/katalogs/' . $katalog->gambar));
            }
            $file = $request->file('gambar');
            $nama_file = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('storage/katalogs'), $nama_file);
            $data['gambar'] = $nama_file;
        }

        $katalog->update($data);
        return redirect()->route('katalogs.index')->with('success', 'Konten Jelajahi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $katalog = Katalog::findOrFail($id);
        if ($katalog->gambar) {
            File::delete(public_path('storage/katalogs/' . $katalog->gambar));
        }
        $katalog->delete();
        return back()->with('success', 'Konten berhasil dihapus!');
    }
}