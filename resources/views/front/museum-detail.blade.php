@extends('layouts.app')

@section('content')
<style>
    /* Style sama persis biar rapi */
    .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 16px; }
    .btn-orange { background: #f59e0b; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; margin-bottom: 10px; text-align: left; transition: 0.3s; }
    .btn-coral { background: #fb923c; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; text-align: left; transition: 0.3s; }
    .btn-orange:hover, .btn-coral:hover { opacity: 0.8; color: white; }
    .side-card-info { background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 25px; color: white; }
    .title-main { font-weight: 800; font-size: 2.5rem; color: #1e293b; }
    .title-main span { color: #00B4B4; }
    .card-lainnya { position: relative; border-radius: 20px; overflow: hidden; height: 300px; display: block; text-decoration: none; }
    .card-lainnya img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .card-lainnya:hover img { transform: scale(1.1); }
    .card-lainnya .overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 50px 20px 20px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); color: white; font-weight: 700; font-size: 1.1rem; }
</style>

<div class="container mt-4 mb-5">
    {{-- BAGIAN ATAS: STATIS --}}
    <img src="{{ asset('assets/img/card-museum.jpg') }}" class="hero-img shadow-sm mb-5" alt="Museum TMII" data-aos="zoom-in" data-aos-duration="1000">

    <div class="row g-5">
        <div class="col-lg-3" data-aos="fade-right">
            <div class="mb-4">
                <a href="{{ route('tiket.info') }}" class="text-decoration-none"><button class="btn-orange">Lihat Jam & Tiket</button></a>
                <a href="{{ route('beli-tiket') }}" class="text-decoration-none"><button class="btn-coral">Beli Tiket Museum</button></a>
            </div>

            <div class="side-card-info shadow-sm">
                <h5 class="fw-bold mb-3">Informasi Cepat</h5>
                <div class="small mb-2"><i class="fa-regular fa-calendar me-2"></i> Buka Setiap Hari</div>
                <div class="small"><i class="fa-regular fa-clock me-2"></i> 08.00 - 16.00 WIB</div>
            </div>
        </div>

        <div class="col-lg-9" data-aos="fade-left">
            <h1 class="title-main mb-4">Jelajahi <span>Museum</span></h1>
            <div class="text-muted" style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">
                <p>Kawasan Taman Mini Indonesia Indah merupakan pusat pelestarian dan edukasi melalui berbagai <strong>Museum Tematik</strong>. Museum-museum ini dirancang khusus untuk menjaga warisan peradaban, teknologi, serta flora dan fauna Nusantara.</p>
                
                <p>Setiap museum menawarkan pengalaman yang sangat edukatif. Anda dapat menelusuri sejarah transportasi, melihat koleksi pusaka peninggalan leluhur, hingga mempelajari habitat alami satwa asli Indonesia.</p>
                
                <p>Kunjungan ke museum di TMII sangat direkomendasikan bagi pelajar, keluarga, and wisatawan yang ingin memperluas wawasan kebangsaan sambil menikmati wisata edukasi yang interaktif dan modern.</p>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: DINAMIS --}}
    <div class="mt-5 pt-5 border-top">
        <h2 class="fw-bold mb-4" data-aos="fade-up">Daftar <span style="color: #9333ea;">Museum</span></h2>
        
        <div class="row g-4">
            @forelse($museums as $index => $m)
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 4) }}">
                <a href="{{ route('katalog.show', $m->slug) }}" class="card-lainnya shadow-sm">
                    <img src="{{ asset('storage/katalogs/' . $m->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/card-museum.jpg') }}'">
                    <div class="overlay">{{ $m->nama }}</div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">Belum ada data museum dari admin.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
