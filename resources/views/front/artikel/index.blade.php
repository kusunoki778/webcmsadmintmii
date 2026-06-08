@extends('layouts.app')

@section('content')
<style>
    .card-artikel { border-radius: 20px; border: 1px solid #e2e8f0; overflow: hidden; transition: 0.3s; height: 100%; display: flex; flex-direction: column; text-decoration: none; color: inherit; }
    .card-artikel:hover { box-shadow: 0 15px 30px rgba(0,0,0,0.08); transform: translateY(-5px); border-color: #00B4B4; }
    .card-artikel img { width: 100%; height: 220px; object-fit: cover; }
    .card-artikel .body { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
    .badge-kategori { background: #e0f2fe; color: #0284c7; padding: 5px 12px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; width: fit-content; margin-bottom: 15px; }
</style>

<div class="container mt-4 mb-5 pb-5">
    {{-- Navigasi Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-down">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Berita & Artikel</li>
        </ol>
    </nav>

    <div class="text-center mb-5" data-aos="fade-up">
        <h1 class="fw-bold" style="font-size: 3rem; letter-spacing: -1px;">Berita & <span style="color: #00B4B4;">Artikel</span></h1>
        <div class="mx-auto" style="width: 80px; height: 4px; background: linear-gradient(90deg, #00B4B4, #9333ea); border-radius: 2px; margin-top: 10px; margin-bottom: 20px;"></div>
        <p class="text-muted fs-5">Temukan informasi terbaru seputar aktivitas, event, dan cerita menarik di TMII</p>
    </div>

    <div class="row g-4">
        @forelse($artikels as $index => $a)
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 3) }}">
            <a href="{{ route('artikel.detail', $a->slug) }}" class="card-artikel bg-white shadow-sm">
                <div class="position-relative overflow-hidden">
                    <img src="{{ asset('storage/artikels/' . $a->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero-bg.jpg') }}'">
                </div>
                <div class="body">
                    <h5 class="fw-bold mb-3" style="line-height: 1.4; color: #1e293b;">{{ $a->judul }}</h5>
                    <p class="text-muted small mb-0" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.95rem;">
                        {{ Str::limit(strip_tags($a->konten), 120) }}
                    </p>
                    <div class="mt-auto pt-4 d-flex align-items-center justify-content-between border-top">
                        <div class="text-muted small fw-bold">
                            <i class="fa-regular fa-calendar-days me-1 text-tosca"></i> {{ \Carbon\Carbon::parse($a->tanggal_publish)->translatedFormat('d F Y') }}
                        </div>
                        <span class="text-tosca small fw-bold">Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></span>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5" data-aos="fade-up">
            <div class="mb-3 text-muted" style="font-size: 4rem;"><i class="fa-regular fa-newspaper"></i></div>
            <h4 class="text-muted">Belum ada artikel yang dipublikasikan.</h4>
            <a href="/" class="btn btn-primary rounded-pill px-4 mt-3">Kembali ke Beranda</a>
        </div>
        @endforelse
    </div>

    @if($artikels->hasPages())
    <div class="d-flex justify-content-center mt-5 pt-4" data-aos="fade-up">
        {{ $artikels->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
