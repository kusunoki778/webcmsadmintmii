@extends('layouts.app')

@section('content')
<style>
    .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 30px; }
    
    .btn-orange { background: #f59e0b; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; margin-bottom: 10px; text-align: left; transition: 0.3s; }
    .btn-coral { background: #fb923c; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; margin-bottom: 10px; text-align: left; transition: 0.3s; }
    .btn-kembali-new { background: #f1f5f9; color: #475569; border-radius: 12px; padding: 12px; width: 100%; border: 1px solid #cbd5e1; font-weight: 700; text-align: left; transition: 0.3s; }
    .btn-orange:hover, .btn-coral:hover { opacity: 0.8; color: white; }
    .btn-kembali-new:hover { background: #e2e8f0; color: #0f172a; }
    
    .title-main { font-weight: 800; font-size: 2.5rem; color: #1e293b; }
    .title-main span { color: #00B4B4; }
    
    /* Style Card Bawah Sesuai Gambar */
    .card-lainnya { position: relative; border-radius: 20px; overflow: hidden; height: 300px; display: block; text-decoration: none; }
    .card-lainnya img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .card-lainnya:hover img { transform: scale(1.1); }
    .card-lainnya .overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 50px 20px 20px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); color: white; font-weight: 700; font-size: 1.1rem; }
</style>

<div class="container mt-4 mb-5">
    {{-- BAGIAN ATAS: GAMBAR UTAMA --}}
    @if($katalog->gambar)
        <img src="{{ asset('storage/katalogs/' . $katalog->gambar) }}" class="hero-img shadow-sm mb-5" alt="{{ $katalog->nama }}" data-aos="zoom-in" data-aos-duration="1000">
    @else
        <img src="{{ asset('assets/img/hero-bg.jpg') }}" class="hero-img shadow-sm mb-5" alt="{{ $katalog->nama }}" data-aos="zoom-in" data-aos-duration="1000">
    @endif

    <div class="row g-5">
        <div class="col-lg-3" data-aos="fade-right">
            <div class="mb-4">
                <a href="{{ route('tiket.info') }}" class="text-decoration-none"><button class="btn-orange"><i class="fa-solid fa-clock me-2"></i> Lihat Jam & Tiket</button></a>
                <a href="{{ route('beli-tiket') }}" class="text-decoration-none"><button class="btn-coral"><i class="fa-solid fa-ticket me-2"></i> Beli Tiket Masuk</button></a>
                <a href="{{ url()->previous() }}" class="text-decoration-none"><button class="btn-kembali-new"><i class="fa-solid fa-arrow-left me-2"></i> Kembali</button></a>
            </div>
        </div>

        <div class="col-lg-9" data-aos="fade-left">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-bold" style="font-size: 0.8rem;">
                <i class="fa-solid fa-map-location-dot me-1"></i> {{ $katalog->kategori }}
            </span>
            <h1 class="title-main mb-4">{{ $katalog->nama }}</h1>
            <div class="text-muted" style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">
                {!! nl2br(e($katalog->deskripsi)) !!}
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: REKOMENDASI LAINNYA --}}
    @if($lainnya->count() > 0)
    <div class="mt-5 pt-5 border-top">
        <h3 class="fw-bold mb-4">{{ $katalog->kategori }} <span style="color: #9333ea;">Lainnya</span></h3>
        
        <div class="row g-4">
            @foreach($lainnya as $index => $item)
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                <a href="{{ route('katalog.show', $item->slug) }}" class="card-lainnya shadow-sm">
                    <img src="{{ asset('storage/katalogs/' . $item->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/default.jpg') }}'">
                    <div class="overlay">{{ $item->nama }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
