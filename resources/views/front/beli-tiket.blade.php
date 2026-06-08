@extends('layouts.app')

@section('content')
<style>
    .katalog-section { padding: 60px 0; background-color: #f8fafc; min-height: 80vh; }
    .title-area { text-align: center; margin-bottom: 50px; }
    .title-area h1 { font-weight: 800; font-size: 2.5rem; color: #0f172a; text-transform: uppercase; letter-spacing: -0.5px; }
    .title-area p { color: #64748b; font-size: 1.1rem; }
    
    .card-katalog {
        border-radius: 24px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #ffffff;
        display: flex;
        flex-direction: row;
        padding: 24px;
        align-items: center;
        height: 100%;
    }
    .card-katalog:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }
    
    .img-katalog-wrapper {
        width: 180px;
        height: 180px;
        flex-shrink: 0;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
    }
    .img-katalog-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .body-katalog {
        padding-left: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 180px;
        flex-grow: 1;
    }

    .ticket-title { font-weight: 800; font-size: 1.35rem; color: #0f172a; line-height: 1.3; margin-bottom: 8px; }
    .ticket-desc { font-size: 0.95rem; line-height: 1.5; color: #64748b; margin-bottom: 0; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .ticket-price { font-weight: 700; font-size: 1.1rem; color: #0f172a; margin-top: 5px; }

    .btn-beli-tiket-yellow {
        border: none;
        border-radius: 50px;
        padding: 10px 28px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-transform: uppercase;
        font-size: 0.85rem;
        cursor: pointer;
        text-decoration: none;
        background-color: #facc15;
        color: #000000 !important;
        transition: all 0.2s ease;
        width: fit-content;
    }
    .btn-beli-tiket-yellow:hover {
        background-color: #eab308;
        transform: translateY(-1px);
    }
    .btn-disabled {
        background-color: #e2e8f0;
        color: #94a3b8 !important;
        cursor: not-allowed;
    }
    .btn-disabled:hover {
        background-color: #e2e8f0;
        transform: none;
    }

    .help-box {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        border-radius: 24px;
        padding: 40px;
        color: #fff;
        text-align: center;
        margin-top: 60px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .wa-btn {
        background: #22c55e;
        color: #fff;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: transform 0.2s ease;
    }
    .wa-btn:hover { transform: scale(1.05); color: #fff; }
</style>

<div class="katalog-section">
    <div class="container">
        <div class="title-area" data-aos="fade-down">
            <h1>BELI TIKET</h1>
            <p>Pilih paket tiket yang sesuai dengan rencana liburan Anda</p>
        </div>

        <div class="row g-4">
            @foreach($tikets as $index => $t)
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 + 100 }}">
                <div class="card-katalog" style="border-left: 6px solid {{ $t->warna ?? '#facc15' }};">
                    <div class="img-katalog-wrapper">
                        @if($t->is_featured)
                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark px-2 py-1 shadow-sm" style="z-index: 10; font-weight: 800; border-radius: 6px; font-size: 0.75rem;">
                                <i class="fa-solid fa-star me-1"></i> TOP
                            </span>
                        @endif
                        <img src="{{ asset('storage/tikets/' . $t->gambar) }}" onerror="this.onerror=null;this.src='{{ asset('assets/img/default.jpg') }}'">
                    </div>

                    <div class="body-katalog">
                        <div>
                            <h4 class="ticket-title">{{ $t->nama_tiket }}</h4>
                            <p class="ticket-desc">{!! nl2br(e($t->deskripsi)) !!}</p>
                        </div>
                        
                        <div>
                            @if($t->widget_code)
                                @if($t->has_tourist_types)
                                    <button type="button" class="btn-beli-tiket-yellow" data-bs-toggle="modal" data-bs-target="#touristModal-{{ $t->id }}">
                                        BELI TIKET
                                    </button>
                                @else
                                    <a href="{{ route('checkout', $t->id) }}" class="btn-beli-tiket-yellow">
                                        BELI TIKET
                                    </a>
                                @endif
                            @else
                                <button type="button" class="btn-beli-tiket-yellow btn-disabled" disabled>
                                    TIDAK TERSEDIA
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Pemilihan Tipe Wisatawan --}}
            @if($t->has_tourist_types && $t->widget_code)
            <div class="modal fade" id="touristModal-{{ $t->id }}" tabindex="-1" aria-labelledby="touristModalLabel-{{ $t->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0" style="border-radius: 24px; overflow: hidden; background-color: #ffffff;">
                        <div class="modal-header border-0 pt-4 px-4 pb-0 justify-content-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body px-4 pb-5 pt-0">
                            <h3 class="text-center fw-bold mb-4" style="color: #0f172a;">Pilih tipe wisatawan</h3>
                            <div class="row g-4">
                                <!-- Foreign Tourist -->
                                <div class="col-md-6">
                                    <div class="p-4 d-flex flex-column justify-content-between text-white" style="background-color: #9333ea; border-radius: 20px; height: 100%; min-height: 240px; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.15);">
                                        <div>
                                            <h4 class="fw-bold mb-2">Foreign Tourist</h4>
                                            <p class="small opacity-90 mb-0" style="line-height: 1.6;">For tourist visiting from outside of Indonesia.</p>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('checkout', $t->id) }}" class="btn-beli-tiket-yellow text-center" style="display: inline-flex; width: auto; padding-left: 30px; padding-right: 30px;">Book Now</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Domestic Tourist -->
                                <div class="col-md-6">
                                    <div class="p-4 d-flex flex-column justify-content-between text-dark" style="background-color: #f3f4f6; border-radius: 20px; height: 100%; min-height: 240px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                                        <div>
                                            <h4 class="fw-bold mb-2" style="color: #0f172a;">Wisatawan Domestik</h4>
                                            <p class="small text-muted mb-0" style="line-height: 1.6;">Pilih ini untuk tamu yang berasal dari negara Indonesia. Memiliki KTP (Kartu Penduduk Indonesia).</p>
                                        </div>
                                        <div class="mt-4">
                                            <a href="{{ route('checkout', $t->id) }}" class="btn-beli-tiket-yellow text-center" style="display: inline-flex; width: auto; padding-left: 30px; padding-right: 30px;">Pesan Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="help-box" data-aos="zoom-in">
            <h3 class="fw-bold mb-3">Butuh Bantuan Rombongan?</h3>
            <p class="mb-4 text-light opacity-75">Dapatkan penawaran khusus untuk pembelian tiket rombongan sekolah atau perusahaan.</p>
            <a href="https://www.whatsapp.com/" class="wa-btn" target="_blank">
                <i class="fab fa-whatsapp fs-5"></i> Hubungi Sales Kami
            </a>
        </div>
    </div>
</div>
@endsection
