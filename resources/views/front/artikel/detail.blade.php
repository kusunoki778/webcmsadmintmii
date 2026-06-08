@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Tombol Kembali & Breadcrumb --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4" data-aos="fade-down">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('artikel.index') }}" class="text-decoration-none text-muted">Artikel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <a href="{{ route('artikel.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 mt-2 mt-md-0">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar
                </a>
            </div>

            {{-- Header Artikel --}}
            <div data-aos="fade-up" data-aos-delay="100">
                <h1 class="fw-bold mb-3" style="font-size: 3rem; line-height: 1.2; color: #0f172a; letter-spacing: -1px;">{{ $artikel->judul }}</h1>
                
                <div class="d-flex align-items-center text-muted mb-4 pb-2 border-bottom">
                    <div class="d-flex align-items-center me-4">
                        <div class="bg-tosca rounded-circle d-flex align-items-center justify-content-center text-white me-2" style="width: 32px; height: 32px; background-color: #00B4B4;">
                            <i class="fa-solid fa-user-pen" style="font-size: 0.8rem;"></i>
                        </div>
                        <span class="small fw-bold">Admin TMII</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa-regular fa-calendar-days me-2"></i>
                        <span class="small fw-bold">{{ \Carbon\Carbon::parse($artikel->tanggal_publish)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Gambar Utama --}}
            <div class="position-relative mb-5" data-aos="zoom-in" data-aos-duration="1000">
                <img src="{{ asset('storage/artikels/' . $artikel->gambar) }}" class="w-100 rounded-4 shadow-lg" style="max-height: 550px; object-fit: cover; border: 4px solid white;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero-bg.jpg') }}'">
            </div>

            {{-- Isi Konten --}}
            <div class="artikel-konten p-md-4" data-aos="fade-up" style="font-size: 1.2rem; line-height: 1.9; color: #334155; text-align: justify;">
                <div class="drop-cap-text">
                    {!! nl2br(e($artikel->konten)) !!}
                </div>
            </div>

            <hr class="my-5 opacity-25">

            {{-- Artikel Terkait --}}
            @if($artikel_lain->count() > 0)
            <div data-aos="fade-up">
                <h4 class="fw-bold mb-4 d-flex align-items-center">
                    <span class="bg-primary me-3" style="width: 4px; height: 24px; border-radius: 2px;"></span>
                    Baca Juga Artikel Lainnya
                </h4>
                <div class="row g-4">
                    @foreach($artikel_lain as $index => $al)
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <a href="{{ route('artikel.detail', $al->slug) }}" class="text-decoration-none text-dark card-artikel-mini">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 transition-hover" style="border: 1px solid #f1f5f9 !important;">
                                <img src="{{ asset('storage/artikels/' . $al->gambar) }}" class="w-100" style="height: 160px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero-bg.jpg') }}'">
                                <div class="card-body p-3">
                                    <h6 class="fw-bold mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">{{ $al->judul }}</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>
@endsection
