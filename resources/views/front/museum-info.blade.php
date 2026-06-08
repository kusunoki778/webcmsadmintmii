@extends('layouts.app')

@section('content')
<style>
    /* Header & Tab Styling (Consistent with Tiket Info) */
    .header-section { padding: 60px 0 30px; text-align: center; }
    .header-section h1 { font-weight: 800; font-size: 2.8rem; color: #1e293b; }
    
    .nav-tabs-container { border-bottom: 1px solid #e2e8f0; margin-bottom: 50px; }
    .nav-tabs-custom { border: none; justify-content: center; }
    .nav-tabs-custom .nav-link { border: none; color: #64748b; font-weight: 600; padding: 15px 40px; position: relative; background: none; }
    .nav-tabs-custom .nav-link.active { color: #0f172a; }
    .nav-tabs-custom .nav-link.active::after { 
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background-color: #3b82f6; 
    }

    /* Museum Card Grid Styling */
    .card-museum {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 25px;
        overflow: hidden;
        transition: 0.3s;
        height: 100%;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }
    .card-museum:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.06); }
    
    .img-museum {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .museum-body { padding: 25px; }
    .museum-name { font-weight: 800; font-size: 1.15rem; color: #1e293b; margin-bottom: 15px; }
    
    .info-item { display: flex; align-items: center; font-size: 0.85rem; color: #64748b; margin-bottom: 8px; }
    .info-item i { width: 20px; color: #2dd4bf; margin-right: 10px; }

    .price-label { font-size: 0.8rem; color: #94a3b8; margin-top: 15px; display: block; }
    .price-tag-museum { font-weight: 800; font-size: 1.2rem; color: #00B4B4; }
</style>

<div class="header-section">
    <div class="container">
        <h1>Jam Operasional TMII & Harga Tiket</h1>
        <p>Informasi lengkap mengenai jam buka dan harga tiket masuk</p>
    </div>
</div>

<div class="nav-tabs-container">
    <div class="container">
        <ul class="nav nav-tabs nav-tabs-custom">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tiket.info') }}">Tiket Masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('museum.info') }}">Museum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('wahana.info') }}">Wahana & Rekreasi</a>
            </li>
        </ul>
    </div>
</div>

<div class="container mb-5 pb-5">
    <h2 class="text-center fw-bold mb-5" style="font-size: 2.2rem;">HARGA TIKET</h2>
    
    <div class="row g-4">
        @php
            $museums = [
                ['name' => 'Museum Pusaka', 'time' => '08:00 - 17:00 WIB', 'price' => 'Gratis', 'img' => 'card-anjungan.jpg'],
                ['name' => 'Museum Indonesia', 'time' => '08:00 - 17:00 WIB', 'price' => 'Gratis', 'img' => 'hero-bg.jpg'],
                ['name' => 'Contemporary Art Gallery', 'time' => '08:00 - 17:00 WIB', 'price' => 'Rp 25.000', 'img' => 'card-museum.jpg'],
                ['name' => 'Museum Penerangan', 'time' => '09:00 - 15:00 WIB', 'price' => 'Gratis', 'img' => 'peta-jelajah.jpg'],
                ['name' => 'Museum Hakka', 'time' => '09:00 - 16:00 WIB', 'price' => 'Gratis', 'img' => 'card-anjungan.jpg'],
                ['name' => 'Museum Batik', 'time' => '09:00 - 15:00 WIB', 'price' => 'Gratis', 'img' => 'card-museum.jpg'],
                ['name' => 'Museum Transportasi', 'time' => '08:00 - 16:00 WIB', 'price' => 'Rp 10.000', 'img' => 'card-wahana.jpg'],
                ['name' => 'Indonesia Science Center - PPIPTEK', 'time' => '08:30 - 16:30 WIB', 'price' => 'Rp 27.500', 'img' => 'card-museum.jpg'],
            ];
        @endphp

        @foreach($museums as $m)
        <div class="col-md-3">
            <div class="card-museum">
                <img src="{{ asset('assets/img/' . $m['img']) }}" class="img-museum" alt="{{ $m['name'] }}">
                <div class="museum-body">
                    <h5 class="museum-name">{{ $m['name'] }}</h5>
                    <div class="info-item">
                        <i class="fa-regular fa-calendar"></i> Setiap Hari
                    </div>
                    <div class="info-item">
                        <i class="fa-regular fa-clock"></i> {{ $m['time'] }}
                    </div>
                    
                    <span class="price-label">Tiket Masuk:</span>
                    <div class="price-tag-museum">{{ $m['price'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
