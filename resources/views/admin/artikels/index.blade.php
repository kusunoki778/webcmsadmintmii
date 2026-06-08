@extends('admin.layouts.admin')

@section('title', 'Manajemen Artikel')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Artikel & Berita</h2>
            <p class="text-muted small">Kelola publikasi informasi terbaru untuk pengunjung.</p>
        </div>
        <a href="{{ route('artikels.create') }}" class="btn fw-bold shadow-sm" style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 10px 20px;">
            <i class="fa-solid fa-plus me-2 text-info"></i> Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded mb-4 p-3" style="font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="p-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px;">
        <div class="table-responsive">
            <table class="table align-middle table-hover m-0">
                <thead>
                    <tr class="text-muted small text-uppercase" style="border-bottom: 2px solid #e2e8f0;">
                        <th class="text-center pb-3">No</th>
                        <th class="pb-3">Gambar</th>
                        <th class="pb-3">Judul Berita</th>
                        <th class="pb-3">Penulis</th>
                        <th class="pb-3">Tanggal</th>
                        <th class="text-center pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($artikels as $a)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            @if($a->gambar)
                                <img src="{{ asset('storage/artikels/' . $a->gambar) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                            @else
                                <div style="width: 80px; height: 50px; border-radius: 6px;" class="bg-light d-flex align-items-center justify-content-center text-muted small border">N/A</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.95rem; max-width: 250px;">{{ $a->judul }}</div>
                        </td>
                        <td><span class="fw-600 small">{{ $a->user->name ?? 'Admin' }}</span></td>
                        <td><small class="text-muted">{{ $a->created_at->format('d M Y') }}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('artikels.edit', $a->id) }}" class="btn btn-sm btn-light border shadow-sm text-primary" style="border-radius: 6px;">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('artikels.destroy', $a->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" style="border-radius: 6px;" onclick="return confirm('Hapus artikel ini?')">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted small">Belum ada artikel publik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
