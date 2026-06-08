@extends('admin.layouts.admin')

@section('title', 'Tambah Tiket Baru')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Tambah Tiket Baru</h2>
            <p class="text-muted small">Masukkan informasi tiket, harga, dan integrasi Goers.</p>
        </div>
        <a href="{{ route('tikets.index') }}" class="btn btn-light border shadow-sm" style="border-radius: 8px; font-weight: 500;">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded mb-4 p-3" style="font-size: 0.9rem;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('tikets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Description & Integration -->
            <div class="col-lg-8">
                
                <!-- Card 1: Ticket Description -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0" style="color: #1e293b;"><i class="fa-solid fa-file-lines me-2 text-primary"></i> Deskripsi Tiket</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Nama Tiket <span class="text-danger">*</span></label>
                                <input type="text" name="nama_tiket" class="form-control bg-light border-0" placeholder="Contoh: Tiket Masuk Reguler" value="{{ old('nama_tiket') }}" style="border-radius: 8px; padding: 10px 15px;" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Warna Tiket <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 align-items-center">
                                    <input type="color" name="warna" class="form-control form-control-color border-0" value="{{ old('warna', '#9333ea') }}" style="border-radius: 8px; width: 60px; height: 42px; padding: 5px; cursor: pointer;" required>
                                    <span class="text-muted small">Pilih warna latar belakang kartu tiket</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label small fw-bold text-muted">Deskripsi Lengkap <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control bg-light border-0" rows="4" placeholder="Jelaskan detail tiket ini..." style="border-radius: 8px; padding: 15px;" required>{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Integration -->
                <div class="card border-0 shadow-sm" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0" style="color: #1e293b;"><i class="fa-solid fa-link me-2 text-warning"></i> Booking Engine</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Link Booking Engine</label>
                            <textarea name="widget_code" class="form-control bg-light border-0 text-monospace" rows="4" placeholder="Contoh: https://widget.goersapp.com/..." style="border-radius: 8px; padding: 15px; font-family: monospace;">{{ old('widget_code') }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="form-check form-switch d-flex align-items-center gap-2 m-0 p-0">
                                        <input class="form-check-input ms-0 mt-0" type="checkbox" name="is_featured" value="1" id="isFeatured" style="width: 40px; height: 20px; cursor: pointer;">
                                        <label class="form-check-label fw-bold" for="isFeatured" style="cursor: pointer; color: #1e293b; font-size: 0.9rem;">Tiket Unggulan</label>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Tampilkan di paling atas.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="form-check form-switch d-flex align-items-center gap-2 m-0 p-0">
                                        <input class="form-check-input ms-0 mt-0" type="checkbox" name="is_active" value="1" id="isActive" checked style="width: 40px; height: 20px; cursor: pointer;">
                                        <label class="form-check-label fw-bold" for="isActive" style="cursor: pointer; color: #1e293b; font-size: 0.9rem;">Tampilkan di Web</label>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Aktifkan tiket di website.</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 h-100">
                                    <div class="form-check form-switch d-flex align-items-center gap-2 m-0 p-0">
                                        <input class="form-check-input ms-0 mt-0" type="checkbox" name="has_tourist_types" value="1" id="hasTouristTypes" style="width: 40px; height: 20px; cursor: pointer;">
                                        <label class="form-check-label fw-bold" for="hasTouristTypes" style="cursor: pointer; color: #1e293b; font-size: 0.9rem;">Pilihan Wisatawan</label>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Opsi turis asing & lokal.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Media & Pricing -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background: #ffffff;">
                    <div class="card-header bg-transparent border-bottom-0 pt-4 pb-0 px-4">
                        <h6 class="fw-bold mb-0" style="color: #1e293b;"><i class="fa-solid fa-image me-2 text-success"></i> Media Tiket</h6>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        
                        <div class="mb-4 text-center">
                            <div class="p-3 mb-2" style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px;">
                                <img id="preview-img" src="{{ asset('assets/img/default.jpg') }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover; width: 100%;">
                            </div>
                            <input type="file" name="gambar" class="form-control form-control-sm border-0 bg-light" id="file-input" accept="image/*" required>
                            <small class="text-muted mt-1 d-block">Maksimal 2MB (JPG, PNG)</small>
                        </div>

                        <div class="mt-auto pt-4 border-top">
                            <button type="submit" class="btn w-100 fw-bold shadow-sm" style="background: #4f46e5; color: white; padding: 12px; border-radius: 8px;">
                                <i class="fa-solid fa-save me-2"></i> Simpan Tiket
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // Preview gambar
    document.getElementById('file-input').onchange = evt => {
        const [file] = document.getElementById('file-input').files
        if (file) {
            document.getElementById('preview-img').src = URL.createObjectURL(file);
        }
    }
</script>
@endsection
