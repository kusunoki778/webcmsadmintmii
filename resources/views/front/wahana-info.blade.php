@extends('layouts.app')

@section('content')
<style>
    /* 1. HEADER & TABS */
    .header-section { padding: 60px 0 30px; text-align: center; }
    .header-section h1 { font-weight: 800; font-size: 2.8rem; color: #1e293b; letter-spacing: -1px; }
    .header-section p { color: #64748b; font-size: 1.1rem; }
    
    .nav-tabs-container { border-bottom: 1px solid #e2e8f0; margin-bottom: 60px; }
    .nav-tabs-custom { border: none; justify-content: center; }
    .nav-tabs-custom .nav-link { border: none; color: #64748b; font-weight: 600; padding: 15px 40px; position: relative; background: none; }
    .nav-tabs-custom .nav-link.active { color: #0f172a; }
    .nav-tabs-custom .nav-link.active::after { 
        content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; background-color: #3b82f6; 
    }

    /* 2. WAHANA WRAPPER */
    .wahana-wrapper { max-width: 850px; margin: 0 auto; }
    .wahana-title-main { font-weight: 800; font-size: 2.5rem; text-align: center; margin-bottom: 50px; }

    /* 3. CARD STYLE - FIX NUMPUK */
    .card-wahana-box {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 35px;
        padding: 45px;
        margin-bottom: 35px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    .wahana-name { font-weight: 800; font-size: 1.8rem; color: #1e293b; margin-bottom: 30px; }
    
    /* Styling Jadwal agar rapi */
    .schedule-item { margin-bottom: 20px; display: block; }
    .schedule-day { color: #00B4B4; font-weight: 700; font-size: 1.05rem; display: block; margin-bottom: 5px; }
    .schedule-time { color: #64748b; font-weight: 500; font-size: 0.95rem; display: block; }

    /* Styling Harga */
    .wahana-price { 
        font-weight: 800; 
        font-size: 1.5rem; 
        color: #1e293b; 
        margin-top: 25px; 
        padding-top: 20px;
        border-top: 1px solid #f1f5f9; 
    }

    .note-gray { 
        font-size: 0.85rem; 
        color: #94a3b8; 
        font-style: italic; 
        margin-top: 15px; 
        display: block; 
    }
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
            <li class="nav-item"><a class="nav-link" href="{{ route('tiket.info') }}">Tiket Masuk</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('museum.info') }}">Museum</a></li>
            <li class="nav-item"><a class="nav-link active" href="{{ route('wahana.info') }}">Wahana & Rekreasi</a></li>
        </ul>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="wahana-wrapper">
        <h2 class="wahana-title-main">Wahana & Rekreasi</h2>

        <div class="card-wahana-box">
            <h3 class="wahana-name">Tirta Menari</h3>
            <div class="schedule-item">
                <span class="schedule-day">Senin - Kamis</span>
                <span class="schedule-time">13.00 WIB</span>
            </div>
            <div class="schedule-item">
                <span class="schedule-day">Jumat</span>
                <span class="schedule-time">14.00 WIB</span>
            </div>
            <div class="schedule-item">
                <span class="schedule-day">Sabtu, Minggu & Libur Nasional</span>
                <span class="schedule-time">10.00, 13.00 & 16.00 WIB</span>
            </div>
            <p class="wahana-price">Gratis</p>
        </div>

        <div class="card-wahana-box">
            <h3 class="wahana-name">Tirta Cerita</h3>
            <div class="schedule-item">
                <span class="schedule-day">Setiap hari</span>
                <span class="schedule-time">18.30 WIB</span>
            </div>
            <p class="wahana-price">Gratis</p>
            <span class="note-gray">*drone show setiap Sabtu, Minggu & Libur Nasional</span>
        </div>

        <div class="card-wahana-box">
            <h3 class="wahana-name">Kereta Gantung</h3>
            <div class="schedule-item">
                <span class="schedule-day">Senin - Jumat</span>
                <span class="schedule-time">09.00 - 16.30 WIB / Rp50.000 per orang</span>
            </div>
            <div class="schedule-item">
                <span class="schedule-day">Sabtu - Minggu & Libur Nasional</span>
                <span class="schedule-time">09.00 - 17.30 WIB / Rp60.000 per orang</span>
            </div>
            <p class="wahana-price">Harga per rute</p>
        </div>

        <div class="card-wahana-box">
            <h3 class="wahana-name">Jagat Satwa Nusantara</h3>
            <div class="schedule-item">
                <span class="schedule-day">Setiap hari</span>
                <span class="schedule-time">09.00 - 17.00 WIB</span>
            </div>
            <p class="wahana-price">Harga berbeda tiap wahana</p>
        </div>

        <div class="card-wahana-box">
            <h3 class="wahana-name">Teater Keong Emas</h3>
            <div class="schedule-item">
                <span class="schedule-day">Setiap hari</span>
                <span class="schedule-time">Operasional menyesuaikan jadwal film</span>
            </div>
            <div class="mt-3">
                <p class="mb-1"><strong>Umum:</strong> Rp50.000</p>
                <p class="mb-1"><strong>VIP:</strong> Rp75.000</p>
                <p class="mb-1"><strong>VVIP:</strong> Rp100.000</p>
            </div>
            <p class="wahana-price">Harga Tiket Masuk</p>
        </div>
    </div>
</div>
@endsection
