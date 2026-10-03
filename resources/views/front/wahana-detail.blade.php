@extends('layouts.app')

@section('content')
<style>
    .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 16px; }
    
    .btn-orange { background: #f59e0b; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; margin-bottom: 10px; text-align: left; transition: 0.3s; }
    .btn-tosca { background: #00B4B4; color: white; border-radius: 12px; padding: 12px; width: 100%; border: none; font-weight: 700; text-align: left; transition: 0.3s; }
    .btn-orange:hover, .btn-tosca:hover { opacity: 0.8; color: white; }
    
    .side-card-info { background: linear-gradient(135deg, #0f172a, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 25px; color: white; }
    
    .title-main { font-weight: 800; font-size: 2.5rem; color: #1e293b; }
    .title-main span { color: #00B4B4; }
    
    .card-lainnya { position: relative; border-radius: 20px; overflow: hidden; height: 300px; display: block; text-decoration: none; }
    .card-lainnya img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .card-lainnya:hover img { transform: scale(1.1); }
    .card-lainnya .overlay { position: absolute; bottom: 0; left: 0; width: 100%; padding: 50px 20px 20px; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); color: white; font-weight: 700; font-size: 1.1rem; }
</style>

<div class="container mt-4 mb-5">
    {{-- BAGIAN ATAS: STATIS (FOKUS DETAIL) --}}
    <img src="{{ asset('assets/img/card-wahana.jpg') }}" class="hero-img shadow-sm mb-5" alt="Wahana TMII" data-aos="zoom-in" data-aos-duration="1000">

    <div class="row g-5">
        <div class="col-lg-3" data-aos="fade-right">
            <div class="mb-4">
                <a href="{{ route('tiket.info') }}" class="text-decoration-none"><button class="btn-orange">Lihat Jam & Tiket</button></a>
                <a href="{{ route('beli-tiket') }}" class="text-decoration-none"><button class="btn-tosca">Beli Tiket</button></a>
            </div>

            <div class="side-card-info shadow-sm">
                <h5 class="fw-bold mb-3">Informasi Cepat</h5>
                <div class="small mb-2"><i class="fa-regular fa-calendar me-2"></i> Buka Setiap Hari</div>
                <div class="small mb-2"><i class="fa-regular fa-clock me-2"></i> 09.00 - 17.00 WIB</div>
                <div class="small"><i class="fa-solid fa-cloud-sun me-2"></i> Cek cuaca sebelum bermain</div>
            </div>
        </div>

        <div class="col-lg-9" data-aos="fade-left">
            <h1 class="title-main mb-4">Wahana <span>Rekreasi</span></h1>
            <div class="text-muted" style="line-height: 1.8; text-align: justify; font-size: 1.05rem;">
                <p>Wahana rekreasi di Taman Mini Indonesia Indah menyajikan kombinasi sempurna antara edukasi, keindahan alam, dan rekreasi modern. Didesain untuk memberikan keseruan serta wawasan baru bagi seluruh anggota keluarga, mulai dari anak-anak hingga dewasa.</p>
                
                <p>Salah satu ikon paling legendaris adalah <strong>Kereta Gantung</strong>. Rasakan sensasi melihat detail indahnya kepulauan miniatur Indonesia di atas Danau Archipelago dari ketinggian, memberikan pemandangan spektakuler yang membantu Anda memahami luasnya Nusantara.</p>
                
                <p>Selain itu, terdapat teater imersif, area bermain interaktif, serta fasilitas berkeliling taman yang nyaman. Temukan berbagai cerita dan sejarah di balik setiap sudut wahana yang dibangun untuk memperkenalkan kekayaan Indonesia dengan cara yang menyenangkan.</p>
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5 border-top">
        <h2 class="fw-bold mb-4" data-aos="fade-up">Daftar <span style="color: #9333ea;">Wahana</span></h2>
        
        <div class="row g-4">
            @forelse($wahanas as $index => $w)
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 4) }}">
                <a href="{{ route('katalog.show', $w->slug) }}" class="card-lainnya shadow-sm">
                    <img src="{{ asset('storage/katalogs/' . $w->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/card-wahana.jpg') }}'">
                    <div class="overlay">{{ $w->nama }}</div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-4">Belum ada detail wahana dari admin.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
