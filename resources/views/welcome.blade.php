@extends('layouts.app')

@section('content')
<style>
    :root {
        --tmii-tosca: #00B4B4;
        --tmii-purple: #9333ea;
        --tmii-yellow: #facc15;
    }

    /* 1. HERO SLIDER CSS - FINAL FIX */
    /* 1. HERO SLIDER CSS - CINEMATIC VERSION */
    .hero-home {
        height: 100vh;
        background-size: cover;
        background-position: center;
        display: flex !important; 
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        margin-top: -90px;
        position: relative;
        overflow: hidden;
    }

    /* Cinematic Ken Burns Effect */
    .carousel-item.active.hero-home {
        animation: kenburns 10s ease-out both;
    }

    @keyframes kenburns {
        from { transform: scale(1); }
        to { transform: scale(1.15); }
    }

    /* Text Animation for active slide */
    .carousel-item.active h1 { 
        animation: fadeInUp 1s both 0.3s;
    }
    .carousel-item.active p { 
        animation: fadeInUp 1s both 0.5s;
    }
    .carousel-item.active .btn-hero, 
    .carousel-item.active .btn-outline-light { 
        animation: fadeInUp 1s both 0.7s;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-home h1 { 
        font-size: clamp(2.5rem, 5vw, 4rem); 
        font-weight: 800; 
        margin-bottom: 15px;
        color: #ffffff !important;
        text-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }

    .hero-home p { 
        font-size: 1.1rem; 
        max-width: 600px; 
        margin: 0 auto 30px; 
        color: #ffffff !important;
        opacity: 0.9 !important;
    }

    /* 1. beranda*/
    .btn-hero { 
        background: var(--tmii-yellow) !important; 
        color: #000 !important; 
        border: none; 
        padding: 14px 40px; 
        border-radius: 50px; 
        font-weight: 800; 
        text-decoration: none !important; 
        transition: 0.3s;
        display: inline-block;
    }

    .btn-hero:hover { 
        transform: scale(1.05); 
        background: #eab308 !important; 
        color: #000 !important;
    }

    /* Indikator Slider (Titik-titik) */
    .hero-indicators {
        bottom: 50px !important;
        z-index: 15;
    }
    .hero-indicators .indicator {
        width: 40px !important;
        height: 6px !important;
        border-radius: 10px;
        background-color: rgba(255,255,255,0.3) !important;
        border: none !important;
    }
    .hero-indicators .indicator.active {
        background-color: var(--tmii-yellow) !important;
        width: 60px !important;
    }

    /* 2. INTRO SECTION */
    .intro-img-wrapper { border-radius: 20px; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .intro-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .btn-outline-yellow {
        background: var(--tmii-yellow); color: #000; padding: 12px 30px; 
        border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-block;
    }

    /* 3. WAJAH BARU TMII */
    .card-wajah {
        border-radius: 24px;
        overflow: hidden;
        aspect-ratio: 4/5;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.4s ease;
        display: block;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    }
    .card-wajah img { width: 100%; height: 100%; object-fit: cover; transition: opacity 0.4s ease, transform 0.6s cubic-bezier(0.16, 1, 0.3, 1), filter 0.4s ease; }
    .card-wajah:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12); }
    .card-wajah:hover img { transform: scale(1.06); filter: brightness(0.9); }
    
    .card-wajah-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px 20px 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%);
        color: white;
        text-align: left;
        z-index: 2;
        transition: opacity 0.4s ease, background 0.4s ease;
    }
    .card-wajah-overlay .category-tag {
        display: inline-block;
        padding: 4px 10px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(4px);
        color: #ffffff;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 8px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .card-wajah-overlay .item-title {
        font-weight: 800;
        font-size: 1.15rem;
        margin-bottom: 0;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .card-wajah.switching img, .card-wajah.switching .card-wajah-overlay {
        opacity: 0.15;
    }

    /* 4. ARTIKEL DEPAN */
    .card-artikel { border: 1px solid #e2e8f0; transition: 0.3s; }
    .card-artikel:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important; border-color: var(--tmii-tosca) !important; }

    /* 5. PETA LOKASI (VERSI ZOOM & DRAG) */
    .peta-lokasi-wrapper {
        position: relative;
        width: 100%;
        height: 550px;
        background: #f3f4f6;
        border-radius: 30px;
        overflow: hidden; 
        cursor: grab;
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .peta-lokasi-wrapper:active { cursor: grabbing; }

    #map-image {
        width: 100%;
        height: 100%;
        object-fit: contain; 
        will-change: transform;
    }

    .zoom-controls {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        z-index: 999; /* FIX: Supaya tombol tidak tertutup gambar dan bisa diklik */
    }

    .btn-zoom {
        width: 45px;
        height: 45px;
        background: white;
        border: none;
        border-radius: 12px;
        font-weight: bold;
        font-size: 22px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
        color: #333;
    }

    .btn-zoom:hover { background: #f9f9f9; transform: scale(1.1); }

    /* 6. IG FEED */
    .ig-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .ig-item { aspect-ratio: 1/1; border-radius: 10px; overflow: hidden; }
    .ig-item img { width: 100%; height: 100%; object-fit: cover; }
</style>

<section id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators hero-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active indicator"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" class="indicator"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" class="indicator"></button>
    </div>

    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active hero-home" data-bs-interval="5000" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('{{ get_setting('hero_bg_1') ? asset('storage/' . get_setting('hero_bg_1')) : asset('assets/img/hero-bg.jpg') }}');">
            <div class="container text-center">
                <h1>{{ get_setting('hero_title_1') }}</h1>
                <p>{{ get_setting('hero_p_1') }}</p>
                <a href="{{ route('beli-tiket') }}" class="btn-hero">Beli Tiket</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item hero-home" data-bs-interval="5000" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('{{ get_setting('hero_bg_2') ? asset('storage/' . get_setting('hero_bg_2')) : asset('assets/img/card-anjungan.jpg') }}');">
            <div class="container text-center">
                <h1>{{ get_setting('hero_title_2') }}</h1>
                <p>{{ get_setting('hero_p_2') }}</p>
                <a href="{{ route('tentang.tmii') }}" class="btn-hero">Mulai Menjelajah</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item hero-home" data-bs-interval="5000" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('{{ get_setting('hero_bg_3') ? asset('storage/' . get_setting('hero_bg_3')) : asset('assets/img/peta-jelajah.jpg') }}');">
            <div class="container text-center">
                <h1>{{ get_setting('hero_title_3') }}</h1>
                <p>{{ get_setting('hero_p_3') }}</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('tiket.info') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-bold" style="border-width: 2px; text-decoration: none;">Info Harga</a>
                    <a href="{{ route('beli-tiket') }}" class="btn-hero">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

<section class="container py-5 my-5">
    <div class="row align-items-center g-5">
        <div class="col-md-5" data-aos="fade-right">
            <div class="intro-img-wrapper">
                <img src="{{ get_setting('home_intro_image') ? asset('storage/' . get_setting('home_intro_image')) : asset('assets/img/hero-bg.jpg') }}" alt="Tarian TMII">
            </div>
        </div>
        <div class="col-md-7" data-aos="fade-left">
            <h2 class="fw-800 mb-4" style="font-size: 2.8rem;">
                {{ get_setting('home_intro_title') }}
            </h2>
            @php
                $introParagraphs = explode("\n", get_setting('home_intro_text', ''));
            @endphp
            @foreach($introParagraphs as $p)
                @if(trim($p) !== '')
                    <p class="text-muted mb-4 lh-lg">
                        {{ trim($p) }}
                    </p>
                @endif
            @endforeach
            <a href="{{ route('tentang.tmii') }}" class="btn-outline-yellow">Mulai Menjelajah</a>
        </div>
    </div>
</section>

<section id="wajah-baru" class="container py-5 text-center">
    <h3 class="fw-800 mb-5" style="font-size: 2rem;">
        Wajah Baru <span style="color: var(--tmii-purple);">TMII</span>
    </h3>
    <div class="row justify-content-center g-4">
        <!-- Anjungan Card -->
        <div class="col-md-4 col-4" data-aos="fade-up" data-aos-delay="100">
            <a href="#" id="card-anjungan" class="card-wajah position-relative">
                <img id="img-anjungan" src="{{ $wajah_anjungans->first() && $wajah_anjungans->first()->gambar ? asset('storage/katalogs/' . $wajah_anjungans->first()->gambar) : asset('assets/img/card-anjungan.jpg') }}" alt="Anjungan">
                <div class="card-wajah-overlay">
                    <span class="category-tag">Anjungan</span>
                    <h5 class="item-title" id="title-anjungan">{{ $wajah_anjungans->first() ? $wajah_anjungans->first()->nama : 'Anjungan Daerah' }}</h5>
                </div>
            </a>
        </div>
        <!-- Museum Card -->
        <div class="col-md-4 col-4" data-aos="fade-up" data-aos-delay="200">
            <a href="#" id="card-museum" class="card-wajah position-relative">
                <img id="img-museum" src="{{ $wajah_museums->first() && $wajah_museums->first()->gambar ? asset('storage/katalogs/' . $wajah_museums->first()->gambar) : asset('assets/img/card-museum.jpg') }}" alt="Museum">
                <div class="card-wajah-overlay">
                    <span class="category-tag">Museum</span>
                    <h5 class="item-title" id="title-museum">{{ $wajah_museums->first() ? $wajah_museums->first()->nama : 'Museum' }}</h5>
                </div>
            </a>
        </div>
        <!-- Wahana Card -->
        <div class="col-md-4 col-4" data-aos="fade-up" data-aos-delay="300">
            <a href="#" id="card-wahana" class="card-wajah position-relative">
                <img id="img-wahana" src="{{ $wajah_wahanas->first() && $wajah_wahanas->first()->gambar ? asset('storage/katalogs/' . $wajah_wahanas->first()->gambar) : asset('assets/img/card-wahana.jpg') }}" alt="Wahana">
                <div class="card-wajah-overlay">
                    <span class="category-tag">Wahana</span>
                    <h5 class="item-title" id="title-wahana">{{ $wajah_wahanas->first() ? $wajah_wahanas->first()->nama : 'Wahana Rekreasi' }}</h5>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="container py-5 my-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-800 mb-1" style="font-size: 2rem;">Artikel & <span style="color: var(--tmii-tosca);">Berita</span></h3>
            <p class="text-muted m-0">Ikuti perkembangan terbaru dan kegiatan seru di TMII</p>
        </div>
        <a href="{{ route('artikel.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4 d-none d-md-block">Lihat Semua</a>
    </div>

    <div class="row g-4">
        @forelse($artikels->take(3) as $a)
        <div class="col-md-4" data-aos="fade-up">
            <a href="{{ route('artikel.detail', $a->slug) }}" class="text-decoration-none text-dark">
                <div class="card-artikel bg-white h-100 rounded-4 overflow-hidden shadow-sm d-flex flex-column">
                    <img src="{{ asset('storage/artikels/' . $a->gambar) }}" class="w-100" style="height: 220px; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('assets/img/hero-bg.jpg') }}'">
                    
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <h5 class="fw-bold mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                            {{ $a->judul }}
                        </h5>
                        
                        <p class="text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ Str::limit(strip_tags($a->konten), 90) }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-top small text-muted fw-bold d-flex align-items-center">
                            <i class="fa-regular fa-calendar me-2" style="color: var(--tmii-tosca);"></i> 
                            {{ \Carbon\Carbon::parse($a->tanggal_publish)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada artikel terbaru.</p>
        </div>
        @endforelse
    </div>

    <div class="text-center mt-4 d-md-none">
        <a href="{{ route('artikel.index') }}" class="btn btn-outline-dark rounded-pill fw-bold px-4">Lihat Semua</a>
    </div>
</section>

<!-- PETA LOKASI JELAJAH -->
<section class="container py-5">
    <h3 class="fw-800 mb-5 text-center" style="font-size: 2rem;">
        Peta <span style="color: var(--tmii-purple);">Lokasi</span>
    </h3>
    
    <div class="peta-lokasi-wrapper" data-aos="zoom-in">
        <div class="zoom-controls">
            <button class="btn-zoom" id="zoom-in" title="Zoom In">+</button>
            <button class="btn-zoom" id="zoom-out" title="Zoom Out">-</button>
            <button class="btn-zoom" id="zoom-reset" title="Reset" style="font-size: 12px;">Reset</button>
        </div>

        <div id="panzoom-element" style="width: 100%; height: 100%;">
            <img src="{{ get_setting('map_image') ? asset('storage/' . get_setting('map_image')) : asset('assets/img/peta.jpg') }}" id="map-image" alt="Peta TMII">
        </div>
    </div>
</section>

<section class="container py-5 mb-5 text-center">
    <h4 class="fw-800 mb-1">#TamanMiniIndonesiaIndah</h4>
    <p class="text-muted mb-4 small">Momen perjalanan seru di Instagram</p>
    @if(get_setting('instagram_embed'))
        <div class="mx-auto" style="max-width: 800px;">
            {!! get_setting('instagram_embed') !!}
        </div>
    @else
        <div class="ig-grid mx-auto" style="max-width: 800px;">
            @foreach(['card-anjungan.jpg', 'hero-bg.jpg', 'card-museum.jpg', 'card-wahana.jpg', 'peta-jelajah.jpg', 'card-anjungan.jpg'] as $img)
            <div class="ig-item">
                <img src="{{ asset('assets/img/'.$img) }}" alt="IG Feed">
            </div>
            @endforeach
        </div>
    @endif
</section>

<!-- SCRIPT PANZOOM FIX -->
<script src="https://unpkg.com/panzoom@9.4.3/dist/panzoom.min.js"></script>
@php
    $listAnjunganMapped = $wajah_anjungans->map(function($item) {
        return [
            'nama' => $item->nama,
            'gambar' => $item->gambar ? asset('storage/katalogs/' . $item->gambar) : asset('assets/img/card-anjungan.jpg'),
            'link' => route('katalog.show', $item->slug)
        ];
    })->values()->toArray();

    $listMuseumMapped = $wajah_museums->map(function($item) {
        return [
            'nama' => $item->nama,
            'gambar' => $item->gambar ? asset('storage/katalogs/' . $item->gambar) : asset('assets/img/card-museum.jpg'),
            'link' => route('katalog.show', $item->slug)
        ];
    })->values()->toArray();

    $listWahanaMapped = $wajah_wahanas->map(function($item) {
        return [
            'nama' => $item->nama,
            'gambar' => $item->gambar ? asset('storage/katalogs/' . $item->gambar) : asset('assets/img/card-wahana.jpg'),
            'link' => route('katalog.show', $item->slug)
        ];
    })->values()->toArray();
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ROTATOR SCRIPT ---
        const listAnjungan = @json($listAnjunganMapped);
        const listMuseum = @json($listMuseumMapped);
        const listWahana = @json($listWahanaMapped);

        function setupRotator(cardId, imgId, titleId, itemsList, delay) {
            if (!itemsList || itemsList.length === 0) return;
            
            let currentIndex = 0;
            const cardEl = document.getElementById(cardId);
            const imgEl = document.getElementById(imgId);
            const titleEl = document.getElementById(titleId);

            // Set initial values
            cardEl.href = itemsList[currentIndex].link;
            imgEl.src = itemsList[currentIndex].gambar;
            titleEl.textContent = itemsList[currentIndex].nama;

            // Rotator loop
            setInterval(() => {
                cardEl.classList.add('switching');
                
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % itemsList.length;
                    cardEl.href = itemsList[currentIndex].link;
                    imgEl.src = itemsList[currentIndex].gambar;
                    titleEl.textContent = itemsList[currentIndex].nama;
                    
                    // Wait for image loading before fading back in
                    imgEl.onload = () => {
                        cardEl.classList.remove('switching');
                    };
                    // Fallback
                    setTimeout(() => {
                        cardEl.classList.remove('switching');
                    }, 300);
                }, 400);
            }, delay);
        }

        // Staggered intervals: Anjungan every 5s, Museum every 6s, Wahana every 7s
        setupRotator('card-anjungan', 'img-anjungan', 'title-anjungan', listAnjungan, 5000);
        setupRotator('card-museum', 'img-museum', 'title-museum', listMuseum, 6000);
        setupRotator('card-wahana', 'img-wahana', 'title-wahana', listWahana, 7000);


        // --- PANZOOM MAP SCRIPT ---
        const element = document.getElementById('map-image');
        const wrapper = document.getElementById('panzoom-element');

        const instance = panzoom(element, {
            maxZoom: 5,
            minZoom: 0.5,
            bounds: true,
            boundsPadding: 0.1
        });

        document.getElementById('zoom-in').addEventListener('click', function(e) {
            e.preventDefault();
            const rect = wrapper.getBoundingClientRect();
            instance.smoothZoom(rect.width / 2, rect.height / 2, 1.5);
        });

        document.getElementById('zoom-out').addEventListener('click', function(e) {
            e.preventDefault();
            const rect = wrapper.getBoundingClientRect();
            instance.smoothZoom(rect.width / 2, rect.height / 2, 0.75);
        });

        document.getElementById('zoom-reset').addEventListener('click', function(e) {
            e.preventDefault();
            instance.moveTo(0, 0);
            instance.zoomAbs(0, 0, 1);
        });
    });
</script>
@endsection