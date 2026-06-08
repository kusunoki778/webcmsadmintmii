@extends('admin.layouts.admin')

@section('title', 'Pengaturan Konten')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Pengaturan Konten</h2>
            <p class="text-muted small">Kelola seluruh teks dan informasi dinamis di website TMII.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded mb-4 p-3" style="font-size: 0.9rem;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Tabs Navigation -->
                <div class="col-md-3 bg-light border-end" style="min-height: 500px;">
                    <div class="nav flex-column nav-pills p-3" id="settingsTabs" role="tablist">
                        <button class="nav-link active text-start mb-2 py-3 fw-bold" data-bs-toggle="pill" data-bs-target="#general" type="button">
                            <i class="fa-solid fa-globe me-2"></i> Umum & Sosmed
                        </button>
                        <button class="nav-link text-start mb-2 py-3 fw-bold" data-bs-toggle="pill" data-bs-target="#home" type="button">
                            <i class="fa-solid fa-house me-2"></i> Halaman Beranda
                        </button>
                        <button class="nav-link text-start mb-2 py-3 fw-bold" data-bs-toggle="pill" data-bs-target="#about" type="button">
                            <i class="fa-solid fa-landmark me-2"></i> Halaman Tentang
                        </button>
                        <button class="nav-link text-start mb-2 py-3 fw-bold" data-bs-toggle="pill" data-bs-target="#tiket" type="button">
                            <i class="fa-solid fa-ticket me-2"></i> Jam Buka & Harga
                        </button>
                        <button class="nav-link text-start mb-2 py-3 fw-bold" data-bs-toggle="pill" data-bs-target="#peta" type="button">
                            <i class="fa-solid fa-map-location-dot me-2"></i> Peta & Lokasi
                        </button>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="col-md-9 bg-white p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="tab-content" id="settingsTabsContent">
                            
                            <!-- TAB GENERAL -->
                            <div class="tab-pane fade show active" id="general">
                                <h5 class="fw-bold mb-4">Pengaturan Umum</h5>
                                @foreach($settings['general'] ?? [] as $s)
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">{{ str_replace('_', ' ', $s->key) }}</label>
                                        @if($s->type == 'textarea')
                                            <textarea name="{{ $s->key }}" class="form-control bg-light border-0" rows="3" style="border-radius: 10px;">{{ $s->value }}</textarea>
                                        @elseif($s->type == 'image')
                                            @if($s->value)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $s->value) }}" alt="Preview" class="img-thumbnail" style="max-height: 100px; border-radius: 10px;">
                                                </div>
                                            @endif
                                            <input type="file" name="{{ $s->key }}" class="form-control bg-light border-0" style="border-radius: 10px; padding: 12px;">
                                        @else
                                            <input type="text" name="{{ $s->key }}" class="form-control bg-light border-0" value="{{ $s->value }}" style="border-radius: 10px; padding: 12px;">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- TAB HOME -->
                            <div class="tab-pane fade" id="home">
                                <h5 class="fw-bold mb-4">Konten Halaman Beranda</h5>
                                @foreach($settings['home'] ?? [] as $s)
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">{{ str_replace('_', ' ', $s->key) }}</label>
                                        @if($s->type == 'textarea')
                                            <textarea name="{{ $s->key }}" class="form-control bg-light border-0" rows="3" style="border-radius: 10px;">{{ $s->value }}</textarea>
                                        @elseif($s->type == 'image')
                                            @if($s->value)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $s->value) }}" alt="Preview" class="img-thumbnail" style="max-height: 100px; border-radius: 10px;">
                                                </div>
                                            @endif
                                            <input type="file" name="{{ $s->key }}" class="form-control bg-light border-0" style="border-radius: 10px; padding: 12px;">
                                        @else
                                            <input type="text" name="{{ $s->key }}" class="form-control bg-light border-0" value="{{ $s->value }}" style="border-radius: 10px; padding: 12px;">
                                        @endif
                                    </div>
                                @endforeach


                            </div>

                            <!-- TAB ABOUT -->
                            <div class="tab-pane fade" id="about">
                                <h5 class="fw-bold mb-4">Konten Halaman Tentang</h5>
                                @foreach($settings['about'] ?? [] as $s)
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">{{ str_replace('_', ' ', $s->key) }}</label>
                                        @if($s->type == 'textarea')
                                            <textarea name="{{ $s->key }}" class="form-control bg-light border-0" rows="4" style="border-radius: 10px;">{{ $s->value }}</textarea>
                                        @elseif($s->type == 'image')
                                            @if($s->value)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $s->value) }}" alt="Preview" class="img-thumbnail" style="max-height: 100px; border-radius: 10px;">
                                                </div>
                                            @endif
                                            <input type="file" name="{{ $s->key }}" class="form-control bg-light border-0" style="border-radius: 10px; padding: 12px;">
                                        @else
                                            <input type="text" name="{{ $s->key }}" class="form-control bg-light border-0" value="{{ $s->value }}" style="border-radius: 10px; padding: 12px;">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- TAB TIKET -->
                            <div class="tab-pane fade" id="tiket">
                                <h5 class="fw-bold mb-4">Jam Buka & Harga Tiket</h5>
                                @foreach($settings['tiket'] ?? [] as $s)
                                    <div class="mb-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">{{ str_replace('_', ' ', $s->key) }}</label>
                                        @if($s->type == 'textarea')
                                            <textarea name="{{ $s->key }}" class="form-control bg-light border-0" rows="3" style="border-radius: 10px;">{{ $s->value }}</textarea>
                                        @else
                                            <input type="text" name="{{ $s->key }}" class="form-control bg-light border-0" value="{{ $s->value }}" style="border-radius: 10px; padding: 12px;">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- TAB PETA -->
                            <div class="tab-pane fade" id="peta">
                                <h5 class="fw-bold mb-2">Peta & Lokasi</h5>
                                <p class="text-muted small mb-4">Koordinat ini digunakan untuk menampilkan peta interaktif di mobile app.</p>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Latitude</label>
                                        <input type="text" name="map_latitude" class="form-control bg-light border-0" value="{{ $settings->get('general')?->firstWhere('key', 'map_latitude')?->value }}" placeholder="-6.302481" style="border-radius: 10px; padding: 12px;">
                                        <small class="text-muted">Contoh: -6.302481</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Longitude</label>
                                        <input type="text" name="map_longitude" class="form-control bg-light border-0" value="{{ $settings->get('general')?->firstWhere('key', 'map_longitude')?->value }}" placeholder="106.894832" style="border-radius: 10px; padding: 12px;">
                                        <small class="text-muted">Contoh: 106.894832</small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Gambar Peta Fisik Kawasan (Mobile/Web)</label>
                                    @if($settings->get('general')?->firstWhere('key', 'map_image')?->value)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $settings->get('general')?->firstWhere('key', 'map_image')?->value) }}" alt="Peta Aktif" class="img-thumbnail" style="max-height: 120px; border-radius: 10px;">
                                        </div>
                                    @endif
                                    <input type="file" name="map_image" class="form-control bg-light border-0" style="border-radius: 10px; padding: 12px;">
                                    <small class="text-muted">Upload gambar peta kawasan/denah baru untuk menggantikan peta panzoom bawaan di website.</small>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Link Google Maps</label>
                                    <input type="text" name="map_gmaps_url" class="form-control bg-light border-0" value="{{ $settings->get('general')?->firstWhere('key', 'map_gmaps_url')?->value }}" placeholder="https://maps.app.goo.gl/..." style="border-radius: 10px; padding: 12px;">
                                    <small class="text-muted">Link ini akan dibuka saat user klik "Buka di Google Maps" di mobile app.</small>
                                </div>

                                <div class="alert alert-info border-0 rounded" style="border-radius: 12px !important;">
                                    <i class="fa-solid fa-circle-info me-2"></i>
                                    <strong>Cara mendapatkan koordinat:</strong> Buka Google Maps → klik kanan di lokasi → klik angka koordinatnya → paste di sini.
                                </div>
                            </div>

                        </div>

                        <div class="mt-5 pt-3 border-top d-flex justify-content-end">
                            <button type="submit" class="btn fw-bold px-5 py-2 shadow-sm" style="background: #0f172a; color: #ffffff; border-radius: 10px;">
                                <i class="fa-solid fa-save me-2 text-info"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-pills .nav-link { color: #64748b; border-radius: 10px; }
        .nav-pills .nav-link.active { background: #ffffff !important; color: #0f172a !important; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .nav-pills .nav-link:hover:not(.active) { background: #f1f5f9; }
    </style>
@endsection
