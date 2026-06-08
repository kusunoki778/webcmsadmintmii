@extends('admin.layouts.admin') {{-- Sesuaikan dengan nama layout admin kamu --}}

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('admin.pesan.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="glass-card p-5">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold mb-1">{{ $pesan->subjek }}</h2>
                <p class="text-muted">Diterima pada: {{ $pesan->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <span class="badge bg-success px-4 py-2 rounded-pill">Sudah Dibaca</span>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-4">
                    <small class="text-muted d-block mb-1">Nama Pengirim</small>
                    <h6 class="fw-bold mb-0">{{ $pesan->nama }}</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-4">
                    <small class="text-muted d-block mb-1">Email</small>
                    <h6 class="fw-bold mb-0">{{ $pesan->email }}</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-light rounded-4">
                    <small class="text-muted d-block mb-1">Nomor Telepon</small>
                    <h6 class="fw-bold mb-0">{{ $pesan->telepon }}</h6>
                </div>
            </div>
        </div>

        <div class="p-4 border rounded-4 bg-white">
            <h6 class="fw-bold mb-3">Isi Pesan:</h6>
            <p class="mb-0" style="white-space: pre-line; line-height: 1.8; color: #475569;">
                {{ $pesan->pesan }}
            </p>
        </div>
    </div>
</div>
@endsection
