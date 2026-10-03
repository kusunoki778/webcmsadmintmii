@extends('layouts.app')

@section('content')
<style>
    /* 1. HERO IMAGE MELENGKUNG */
    .hero-tentang {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 40px;
        margin-top: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    /* 2. TIPOGRAFI & WARNA */
    .section-title-tentang { font-weight: 800; font-size: 2.8rem; color: #0f172a; margin-top: 50px; text-align: center; }
    .text-tosca { color: #00B4B4; }
    .text-purple { color: #9333ea; }
    
    .content-paragraph {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
        margin-bottom: 25px;
    }

    /* 3. EMPAT PILAR CARDS */
    .pilar-card {
        border: none;
        border-radius: 25px;
        padding: 40px 25px;
        text-align: center;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        height: 100%;
        transition: 0.3s;
    }
    .pilar-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
    
    .pilar-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        font-size: 1.8rem;
    }
    
    .bg-green { background-color: #e6f7f7; color: #00B4B4; }
    .bg-purple { background-color: #f3e8ff; color: #9333ea; }
    .bg-yellow { background-color: #fef9c3; color: #ca8a04; }
    .bg-teal { background-color: #f0fdf4; color: #15803d; }

    /* 4. TMII DALAM ANGKA (SLATE DARK) */
    .stats-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        padding: 60px 20px;
        color: white;
        margin-top: 80px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
    }
    .stat-number { font-weight: 800; font-size: 3rem; margin-bottom: 5px; color: #facc15; }
    .stat-label { font-weight: 600; font-size: 1rem; opacity: 0.9; }

    .note-scroll { font-size: 0.8rem; color: #94a3b8; font-style: italic; margin-top: 40px; text-align: center; }
</style>

<div class="container py-4">
    <img src="{{ get_setting('about_hero_image') ? asset('storage/' . get_setting('about_hero_image')) : asset('assets/img/peta-jelajah.jpg') }}" class="hero-tentang" data-aos="zoom-out" alt="Tentang TMII">

    <div class="row justify-content-center mt-5" data-aos="fade-up">
        <div class="col-md-10 text-center">
            <h1 class="section-title-tentang">{{ get_setting('about_history_title', 'TMII Dulu dan Kini') }}</h1>
            <div class="mt-4 text-start">
                @php
                    $historyParagraphs = explode("\n", str_replace("\r", "", get_setting('about_history_content', '')));
                @endphp

                @foreach($historyParagraphs as $p)
                    @if(trim($p) !== '')
                        <p class="content-paragraph">{{ trim($p) }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-5 pt-5">
        <h2 class="text-center fw-bold mb-3" style="font-size: 2.2rem;" data-aos="fade-up">Empat Pilar <span class="text-purple">{{ get_setting('site_name', 'TMII') }}</span></h2>
        <p class="text-center text-muted mb-5" data-aos="fade-up">Nilai-nilai yang menjadi fondasi pengembangan TMII ke depan</p>
        
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="pilar-card">
                    <div class="pilar-icon bg-green"><i class="fa-solid fa-leaf"></i></div>
                    <h5 class="fw-bold">Green</h5>
                    <p class="small text-muted">{{ get_setting('pilar_green_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="pilar-card">
                    <div class="pilar-icon bg-purple"><i class="fa-solid fa-users"></i></div>
                    <h5 class="fw-bold">Inclusive</h5>
                    <p class="small text-muted">{{ get_setting('pilar_inclusive_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="pilar-card">
                    <div class="pilar-icon bg-yellow"><i class="fa-solid fa-landmark"></i></div>
                    <h5 class="fw-bold">Culture</h5>
                    <p class="small text-muted">{{ get_setting('pilar_culture_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="pilar-card">
                    <div class="pilar-icon bg-teal"><i class="fa-solid fa-bolt"></i></div>
                    <h5 class="fw-bold">Smart</h5>
                    <p class="small text-muted">{{ get_setting('pilar_smart_desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-banner shadow-lg" data-aos="zoom-in">
        <h3 class="fw-bold mb-5" style="font-size: 2rem;">{{ get_setting('site_name', 'TMII') }} dalam Angka</h3>
        <div class="row">
            <div class="col-md-3 border-end border-light border-opacity-25 mb-4 mb-md-0">
                <div class="stat-number">{{ get_setting('stat_area', '250+') }}</div>
                <div class="stat-label">Hektar Area</div>
            </div>
            <div class="col-md-3 border-end border-light border-opacity-25 mb-4 mb-md-0">
                <div class="stat-number">{{ get_setting('stat_anjungan', '34') }}</div>
                <div class="stat-label">Anjungan Daerah</div>
            </div>
            <div class="col-md-3 border-end border-light border-opacity-25 mb-4 mb-md-0">
                <div class="stat-number">{{ get_setting('stat_museum', '18') }}</div>
                <div class="stat-label">Museum</div>
            </div>
            <div class="col-md-3">
                <div class="stat-number">{{ get_setting('stat_years', '48') }}</div>
                <div class="stat-label">Tahun Berdiri</div>
            </div>
        </div>
    </div>

</div>
@endsection
