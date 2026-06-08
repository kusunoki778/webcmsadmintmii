@extends('admin.layouts.admin')

@section('title', 'Manajemen Katalog')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Katalog Konten</h2>
            <p class="text-muted small">Kelola data destinasi Anjungan, Museum, dan Wahana TMII.</p>
        </div>
        <a href="{{ route('katalogs.create') }}" class="btn fw-bold shadow-sm" style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 10px 20px;">
            <i class="fa-solid fa-plus me-2 text-info"></i> Tambah Data
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
                        <th class="pb-3">Nama Destinasi</th>
                        <th class="text-center pb-3">Kategori</th>
                        <th class="pb-3" width="25%">Deskripsi</th>
                        <th class="text-center pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($katalogs as $k)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            @if($k->gambar)
                                <img src="{{ asset('storage/katalogs/' . $k->gambar) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                            @else
                                <div style="width: 80px; height: 50px; border-radius: 6px;" class="bg-light d-flex align-items-center justify-content-center text-muted small border">N/A</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $k->nama }}</div>
                            <div class="text-muted small" style="font-size: 0.75rem;">Slug: /{{ $k->slug }}</div>
                        </td>
                        <td class="text-center">
                            @if($k->kategori == 'Anjungan')
                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill" style="font-size: 0.75rem;">{{ $k->kategori }}</span>
                            @elseif($k->kategori == 'Museum')
                                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill" style="font-size: 0.75rem;">{{ $k->kategori }}</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill" style="font-size: 0.75rem;">{{ $k->kategori }}</span>
                            @endif
                        </td>
                        <td><small class="text-muted" style="font-size: 0.8rem;">{{ Str::limit($k->deskripsi, 60) }}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('katalogs.edit', $k->id) }}" class="btn btn-sm btn-light border shadow-sm text-primary" style="border-radius: 6px;">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('katalogs.destroy', $k->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" style="border-radius: 6px;" onclick="return confirm('Hapus data ini?')">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted small">Belum ada data destinasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
