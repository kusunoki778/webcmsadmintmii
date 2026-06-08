@extends('layouts.app')

@section('content')
<style>
    /* Header & Tab Styling */
    .header-section {
        padding: 60px 0 30px;
        text-align: center;
    }
    .header-section h1 {
        font-weight: 800;
        font-size: 2.8rem;
        color: #1e293b;
        margin-bottom: 10px;
    }
    .header-section p {
        color: #64748b;
        font-size: 1.1rem;
    }

    .nav-tabs-container {
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 50px;
    }
    .nav-tabs-custom {
        border: none;
        justify-content: center;
    }
    .nav-tabs-custom .nav-link {
        border: none;
        color: #64748b;
        font-weight: 600;
        padding: 15px 40px;
        position: relative;
        background: none;
    }
    .nav-tabs-custom .nav-link.active {
        color: #0f172a;
    }
    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #3b82f6; /* Warna biru garis bawah aktif */
    }

    /* Card Styling */
    .card-info-tmii {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 30px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
        height: 100%;
    }
    .card-info-tmii:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }

    /* Icon Gradients (Identik Gambar) */
    .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        color: #fff;
        font-size: 1.8rem;
    }
    /* Warna gradasi icon sesuai baris dan kolom di gambar */
    .grad-blue { background: linear-gradient(135deg, #3b82f6 0%, #2dd4bf 100%); }
    .grad-tosca { background: #00B4B4; }
    .grad-purple { background: #9333ea; }
    .grad-yellow { background: #facc15; }

    .info-title {
        font-weight: 800;
        font-size: 1.4rem;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .info-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 12px;
    }
    .info-price {
        color: #00B4B4;
        font-weight: 800;
        font-size: 1.6rem;
    }

    /* Information Banner (Gradient Box) */
    .info-banner-box {
        background: linear-gradient(90deg, #00B4B4 0%, #9333ea 100%);
        border-radius: 25px;
        padding: 50px;
        color: white;
        margin-top: 80px;
    }
    .info-banner-box h4 {
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 30px;
    }
    .info-list-container {
        display: flex;
        justify-content: space-between;
    }
    .info-list-item h6 {
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }
    .info-list-item ul {
        list-style: none;
        padding: 0;
    }
    .info-list-item ul li {
        font-size: 0.95rem;
        margin-bottom: 10px;
        opacity: 0.9;
        position: relative;
        padding-left: 20px;
    }
    .info-list-item ul li::before {
        content: '\2022';
        position: absolute;
        left: 0;
        color: #facc15;
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
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('tiket.info') }}">Tiket Masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('museum.info') }}">Museum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('wahana.info') }}">Wahana & Rekreasi</a>
            </li>
        </ul>
    </div>
</div>

<div class="container mb-5 pb-5">
    <h2 class="text-center fw-bold mb-5" style="font-size: 2rem;" data-aos="fade-up">Jam Operasional</h2>
    <div class="row g-4 mb-5 pb-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card-info-tmii">
                <div class="icon-circle grad-blue"><i class="fa-regular fa-clock"></i></div>
                <h5 class="info-title">Gate 1</h5>
                <p class="info-subtitle">Senin - Minggu</p>
                <p class="fw-bold" style="color: #00B4B4; font-size: 1.2rem;">{{ get_setting('opening_gate_1', '06:00 - 17:00 WIB') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-info-tmii">
                <div class="icon-circle grad-blue"><i class="fa-regular fa-clock"></i></div>
                <h5 class="info-title">Gate 3</h5>
                <p class="info-subtitle">Senin - Minggu</p>
                <p class="fw-bold" style="color: #00B4B4; font-size: 1.2rem;">{{ get_setting('opening_gate_3', '08:00 - 17:00 WIB') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card-info-tmii">
                <div class="icon-circle grad-blue"><i class="fa-regular fa-clock"></i></div>
                <h5 class="info-title">Gate 4</h5>
                <p class="info-subtitle">Senin - Minggu</p>
                <p class="fw-bold" style="color: #00B4B4; font-size: 1.2rem;">{{ get_setting('opening_gate_4', '08:00 - 17:00 WIB') }}</p>
            </div>
        </div>
    </div>

    <h2 class="text-center fw-bold mb-5" style="font-size: 2rem;" data-aos="fade-up">Harga Tiket & Kendaraan</h2>
    <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card-info-tmii">
                <div class="icon-circle grad-tosca"><i class="fa-solid fa-door-open"></i></div>
                <h5 class="info-title">Pintu Masuk</h5>
                <p class="info-price">{{ get_setting('price_entrance', 'Rp 25.000') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-info-tmii">
                <div class="icon-circle grad-purple"><i class="fa-solid fa-car"></i></div>
                <h5 class="info-title">Mobil</h5>
                <p class="info-price" style="color: #9333ea;">{{ get_setting('price_car', 'Rp 35.000') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card-info-tmii">
                <div class="icon-circle grad-yellow"><i class="fa-solid fa-motorcycle"></i></div>
                <h5 class="info-title">Motor</h5>
                <p class="info-price" style="color: #facc15;">{{ get_setting('price_motor', 'Rp 15.000') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card-info-tmii">
                <div class="icon-circle grad-tosca"><i class="fa-solid fa-bicycle"></i></div>
                <h5 class="info-title">Sepeda</h5>
                <p class="info-price">{{ get_setting('price_bicycle', 'Rp 5.000') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="card-info-tmii">
                <div class="icon-circle grad-purple"><i class="fa-solid fa-bus"></i></div>
                <h5 class="info-title">Bus</h5>
                <p class="info-price" style="color: #9333ea;">{{ get_setting('price_bus', 'Rp 60.000') }}</p>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="card-info-tmii">
                <div class="icon-circle grad-yellow"><i class="fa-solid fa-truck"></i></div>
                <h5 class="info-title">Truk</h5>
                <p class="info-price" style="color: #facc15;">{{ get_setting('price_truck', 'Rp 40.000') }}</p>
            </div>
        </div>
    </div>

    @php
        if (!function_exists('parseSettingToListHtml')) {
            function parseSettingToListHtml($value, $defaultHtml = '') {
                $value = trim($value);
                if (empty($value)) {
                    return $defaultHtml;
                }
                // If it already has HTML list structure, just clean it and return
                if (strpos($value, '<ul') !== false || strpos($value, '<li') !== false) {
                    return strip_tags($value, '<ul><li><strong><b><i><br><p>');
                }
                // Otherwise, split by newline and turn each line into an <li>
                $lines = explode("\n", str_replace("\r", "", $value));
                $html = '<ul>';
                foreach ($lines as $line) {
                    $trimmed = trim($line);
                    // Remove leading bullet characters like -, *, •, or numbers like 1., 2)
                    $trimmed = preg_replace('/^[\s\-\*\•\d+\.\)]+/', '', $trimmed);
                    if ($trimmed !== '') {
                        $html .= '<li>' . e($trimmed) . '</li>';
                    }
                }
                $html .= '</ul>';
                return $html;
            }
        }
    @endphp

    <div class="info-banner-box">
        <h4 class="text-center">Informasi Penting</h4>
        <div class="row">
            <div class="col-md-6 border-end border-white border-opacity-25">
                <div class="info-list-item ps-md-4">
                    <h6>Catatan:</h6>
                    {!! parseSettingToListHtml(get_setting('tiket_notes'), '<ul><li>Tidak ada catatan khusus.</li></ul>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-list-item ps-md-5">
                    <h6>Fasilitas:</h6>
                    {!! parseSettingToListHtml(get_setting('tiket_facilities'), '<ul><li>Fasilitas standar tersedia.</li></ul>') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
