<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    /**
     * TAMPILAN ADMIN: Daftar Semua Pesan
     */
    public function index()
    {
        // Ambil pesan terbaru (yang belum dibaca muncul di atas bisa diatur)
        $pesans = Pesan::latest()->get();
        
        // Hitung total tiket dan artikel untuk statistik dashboard (opsional jika ingin dipassing)
        return view('admin.pesan.index', compact('pesans'));
    }

    /**
     * SISI USER: Simpan Pesan dari Form Hubungi Kami
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama'    => 'required|string|max:255',
            'email'   => 'required|email',
            'telepon' => 'required|string|max:20',
            'subjek'  => 'required|string',
            'pesan'   => 'required|string',
        ]);

        // Simpan ke database
        Pesan::create($validated);

        // Redirect balik dengan pesan sukses (SweetAlert akan menangkap ini)
        return back()->with('success', 'Pesan Anda telah terkirim! Tim kami akan segera menghubungi Anda.');
    }

    /**
     * TAMPILAN ADMIN: Lihat Detail Pesan & Tandai Dibaca
     */
    public function show($id)
    {
        $pesan = Pesan::findOrFail($id);

        // Otomatis tandai sudah dibaca (is_read = 1)
        $pesan->update(['is_read' => 1]);

        return view('admin.pesan.show', compact('pesan'));
    }

    /**
     * TAMPILAN ADMIN: Hapus Pesan
     */
    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->route('admin.pesan.index')->with('success', 'Pesan berhasil dihapus!');
    }
}