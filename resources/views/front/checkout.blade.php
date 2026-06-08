@extends('layouts.app')

@section('content')
<style>
    .checkout-section { padding: 40px 0; background-color: #f8fafc; min-height: 80vh; }
    .checkout-header { text-align: left; margin-bottom: 30px; }
    .checkout-header h1 { font-weight: 800; font-size: 2rem; color: #0f172a; text-transform: uppercase; margin-bottom: 5px; }
    .checkout-header .ticket-name { font-size: 1.5rem; color: #6366f1; font-weight: 700; }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #0f172a;
        font-weight: 700;
        text-decoration: none;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }
    .btn-back:hover { color: #4f46e5; }

    .widget-container {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        padding: 0;
        border: 1px solid #e2e8f0;
    }

    /* Gunakan tinggi responsif berbasis viewport agar ramah mobile dan bebas double scrollbar */
    .widget-container iframe {
        width: 100% !important;
        min-height: 750px !important;
        height: 85vh !important;
        border: none !important;
        display: block;
        overflow-y: auto;
    }
</style>

<div class="checkout-section">
    <div class="container">
        
        <a href="{{ route('beli-tiket') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>

        <div class="checkout-header">
            <div class="text-muted small fw-bold mb-1">BELI TIKET MASUK</div>
            <h1>Taman Mini Indonesia Indah</h1>
            <div class="ticket-name">{{ $tiket->nama_tiket }}</div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="widget-container">
                    @if($tiket->widget_code)
                        @if(filter_var($tiket->widget_code, FILTER_VALIDATE_URL) || str_starts_with(trim($tiket->widget_code), 'http'))
                            <iframe id="__GOERS_widget_frame" title="Goers Widget" src="{{ trim($tiket->widget_code) }}" style="background-color: transparent; overflow: hidden; height: 850px; width: 100%; border: none;" scrolling="yes"></iframe>
                        @else
                            {!! $tiket->widget_code !!}
                        @endif
                    @else
                        <div class="p-5 text-center text-muted">
                            <i class="fa-solid fa-triangle-exclamation fs-1 mb-3 text-warning"></i>
                            <h4>Widget Tidak Tersedia</h4>
                            <p>Maaf, kalender pemesanan untuk tiket ini belum diatur oleh Admin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    // Script otomatis pasang ID jika admin lupa, agar auto-resize Goers jalan
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.querySelector('.widget-container iframe');
        if (iframe && !iframe.id) {
            iframe.id = '__GOERS_widget_frame';
        }
    });
</script>
@endsection
