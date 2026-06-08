@extends('admin.layouts.admin')

@section('title', 'Manajemen Tiket')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Manajemen Tiket</h2>
            <p class="text-muted small">Kelola informasi tiket masuk dan tiket unggulan.</p>
        </div>
        <a href="{{ route('tikets.create') }}" class="btn fw-bold shadow-sm" style="background: #0f172a; color: #ffffff; border-radius: 8px; padding: 10px 20px;">
            <i class="fa-solid fa-plus me-2 text-info"></i> Tambah Tiket
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 p-3" style="font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- TIKET UNGGULAN (FEATURED) SECTION -->
    @php
        $featuredTikets = collect($tikets)->where('is_featured', true);
    @endphp

    @if($featuredTikets->count() > 0)
        <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-crown text-warning me-2"></i>Tiket Unggulan (Dipajang di Halaman Utama)</h6>
        <div class="row g-4 mb-5">
            @foreach($featuredTikets as $ft)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(145deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a !important; overflow: hidden;">
                    @if($ft->gambar)
                        <img src="{{ asset('storage/tikets/' . $ft->gambar) }}" style="height: 140px; width: 100%; object-fit: cover;">
                    @else
                        <div style="height: 140px; width: 100%;" class="bg-light d-flex align-items-center justify-content-center text-muted border-bottom">N/A</div>
                    @endif
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-star me-1"></i> Featured
                            </span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('tikets.edit', $ft->id) }}" class="btn btn-sm btn-light border-0 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $ft->nama_tiket }}</h5>
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: {{ $ft->warna ?? '#9333ea' }}; border: 1px solid #cbd5e1;" title="Warna Tiket"></span>
                            <span class="text-muted small fw-medium">Warna Kartu</span>
                        </div>
                        <div class="border-top border-warning-subtle pt-3 mt-2 text-center">
                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill small fw-bold" style="font-size: 0.75rem;">
                                {{ $ft->is_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <!-- SEMUA TIKET (TABEL) -->
    <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list text-muted me-2"></i>Daftar Semua Tiket</h6>
    <div class="p-4 shadow-sm" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px;">
        <div class="table-responsive">
            <table class="table align-middle table-hover m-0">
                <thead>
                    <tr class="text-muted small text-uppercase" style="border-bottom: 2px solid #e2e8f0;">
                        <th class="text-center pb-3" style="width: 5%;">No</th>
                        <th class="pb-3" style="width: 15%;">Gambar</th>
                        <th class="pb-3" style="width: 37%;">Nama Tiket</th>
                        <th class="text-center pb-3" style="width: 15%;">Status</th>
                        <th class="text-center pb-3" style="width: 13%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tikets as $t)
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            @if($t->gambar)
                                <img src="{{ asset('storage/tikets/' . $t->gambar) }}" style="width: 80px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0;">
                            @else
                                <div style="width: 80px; height: 50px; border-radius: 6px;" class="bg-light d-flex align-items-center justify-content-center text-muted small border">N/A</div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-inline-block rounded-circle" style="width: 12px; height: 12px; background-color: {{ $t->warna ?? '#9333ea' }}; border: 1px solid #cbd5e1; flex-shrink: 0;" title="Warna Tiket: {{ $t->warna }}"></span>
                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                                    {{ $t->nama_tiket }}
                                </div>
                            </div>
                            <div class="text-muted small" style="font-size: 0.75rem; padding-left: 20px;">ID: #{{ $t->id }}</div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1 align-items-center">
                                @if($t->is_active)
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded" style="font-size: 0.7rem;">Aktif</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded" style="font-size: 0.7rem;">Nonaktif</span>
                                @endif

                                @if($t->is_featured)
                                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded" style="font-size: 0.7rem;"><i class="fa-solid fa-star"></i> Featured</span>
                                @endif

                                @if($t->has_tourist_types)
                                    <span class="badge bg-info-subtle text-info px-2 py-1 rounded" style="font-size: 0.7rem;">Opsi Turis</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('tikets.edit', $t->id) }}" class="btn btn-sm btn-light border text-primary rounded-3 shadow-sm">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('tikets.destroy', $t->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger rounded-3 shadow-sm" onclick="return confirm('Hapus tiket ini?')">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted small">Belum ada data tiket.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
