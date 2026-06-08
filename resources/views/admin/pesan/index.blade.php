@extends('admin.layouts.admin')

@section('title', 'Pesan Pengunjung')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Pesan Pengunjung</h2>
            <p class="text-muted small">Kelola pesan dan masukan dari pengunjung TMII.</p>
        </div>
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
                        <th class="pb-3">Pengirim</th>
                        <th class="pb-3">Subjek</th>
                        <th class="text-center pb-3">Tanggal</th>
                        <th class="text-center pb-3">Status</th>
                        <th class="text-center pb-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesans as $p)
                    <tr style="border-bottom: 1px solid #f1f5f9; {{ !$p->is_read ? 'background-color: #f8fafc;' : '' }}">
                        <td class="text-center text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $p->nama }}</div>
                            <div class="text-muted small" style="font-size: 0.75rem;">{{ $p->email }}</div>
                        </td>
                        <td>
                            <span class="text-dark" style="font-size: 0.9rem;">{{ Str::limit($p->subjek, 40) }}</span>
                        </td>
                        <td class="text-center text-muted small">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                        <td class="text-center">
                            @if($p->is_read)
                                <span class="badge bg-light border text-muted px-3 py-2 rounded-pill" style="font-size: 0.75rem;">Sudah Dibaca</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill" style="font-size: 0.75rem;">Belum Dibaca</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.pesan.show', $p->id) }}" class="btn btn-sm btn-light border shadow-sm text-primary" style="border-radius: 6px;">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                                <form action="{{ route('admin.pesan.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger" style="border-radius: 6px;" onclick="return confirm('Hapus pesan ini?')">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted small">Belum ada pesan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
