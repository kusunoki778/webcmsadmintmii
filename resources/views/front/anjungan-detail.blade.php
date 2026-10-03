@extends('layouts.app')

@section('content')
<style>
    .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 16px; }
    
    .btn-orange { background: #f59e0b; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; margin-bottom: 10px; text-align: left; transition: 0.3s; }
    .btn-coral { background: #fb923c; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; text-align: left; transition: 0.3s; }
    .btn-orange:hover, .btn-coral:hover { opacity: 0.8; color: white; }
    
    .side-card-info { background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 25px; color: white; }
    
    .title-main { font-weight: 800; font-size: 2.5rem; color: #1e293b; }
    .title-main span { color: #00B4B4; }
    
    /* Style Card Bawah Sesuai Gambar */
    .card-lainnya { position: relative; border-radius: 20px; overflow: hidden; height: 300px; display: block; text-decoration: none; }
    .card-lainnya img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .card-lainnya:hover img { transform: scale(1.1); }
    .card-lainnya .overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 50px 20px 20px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); color: white; font-weight: 700; font-size: 1.1rem; }
</style>

<div class="container mt-4 mb-5">
    {{-- BAGIAN ATAS: STATIS --}}
    <img src="{{ asset('assets/img/hero-bg.jpg') }}" class="hero-img shadow-sm mb-5" alt="Anjungan TMII" data-aos="zoom-in" data-aos-duration="1000">

    <div class="row g-5">
        <div class="col-lg-3" data-aos="fade-right">
            <div class="mb-4">
                <a href="{{ route('tiket.info') }}" class="text-decoration-none"><button class="btn-orange">Lihat Jam & Tiket</button></a>
                <a href="{{ route('beli-tiket') }}" class="text-decoration-none"><button class="btn-coral">Beli Tiket Masuk</button></a>
            </div>

            <div class="side-card-info shadow-sm">
                <h5 class="fw-bold mb-3">Informasi Cepat</h5>
                <div class="small mb-2"><i class="fa-regular fa-calendar me-2"></i> Buka Setiap Hari</div>
                <div class="small"><i class="fa-regular fa-clock me-2"></i> 08.00 - 17.00 WIB</div>
            </div>
        </div>

        <div class="col-lg-9" data-aos="fade-left">
            <h1 class="title-main mb-4">Anjungan <span>Daerah</span></h1>
            <div class="text-muted" style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">
                <p>Taman Mini Indonesia Indah menghadirkan miniatur kepulauan Indonesia melalui berbagai <strong>Anjungan Daerah</strong>. Setiap anjungan menampilkan replika arsitektur tradisional yang menggambarkan kekayaan budaya, adat istiadat, dan sejarah dari masing-masing provinsi di Nusantara.</p>
                
                <p>Bangunan-bangunan ini dirancang dengan detail yang sangat teliti, menggunakan material dan teknik ukiran khas daerah asalnya untuk memberikan pengalaman autentik kepada setiap pengunjung yang datang.</p>

                <p>Di dalam area anjungan, pengunjung tidak hanya melihat keindahan rumah adat, tetapi juga dapat mempelajari berbagai koleksi artefak budaya, pakaian tradisional, senjata khas, hingga peralatan yang digunakan dalam kehidupan sehari-hari masyarakat setempat. Ini adalah jendela untuk memahami kearifan lokal yang diwariskan turun-temurun.</p>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: DINAMIS DARI DATABASE --}}
    <div class="mt-5 pt-5 border-top">
        <h2 class="fw-bold mb-4" data-aos="fade-up">Daftar <span style="color: #9333ea;">Provinsi</span></h2>
        
        <div class="row g-4">
            @forelse($anjungans as $index => $a)
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 4) }}">
                <a href="{{ route('katalog.show', $a->slug) }}" class="card-lainnya shadow-sm">
                    <img src="{{ asset('storage/katalogs/' . $a->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/card-anjungan.jpg') }}'">
                    <div class="overlay">{{ $a->nama }}</div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">Belum ada data anjungan dari admin.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
