@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Pengaturan Halaman Depan</h2>
            <p class="text-muted">Ubah teks Hero dan Intro untuk Landing Page TMII.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.pengaturan.update') }}" method="POST">
                @csrf
                
                <h5 class="fw-bold text-primary mb-3">Bagian Hero (Atas)</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Utama (Hero Title)</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $pengaturan->hero_title) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Sub-judul (Hero Subtitle)</label>
                    <textarea name="hero_subtitle" rows="2" class="form-control" required>{{ old('hero_subtitle', $pengaturan->hero_subtitle) }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3">Halaman Museum</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Halaman Museum</label>
                    <input type="text" name="museum_title" class="form-control" value="{{ old('museum_title', $pengaturan->museum_title) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Teks Museum (Bisa panjang)</label>
                    <textarea name="museum_text" rows="4" class="form-control" required>{{ old('museum_text', $pengaturan->museum_text) }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3">Halaman Wahana</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Halaman Wahana</label>
                    <input type="text" name="wahana_title" class="form-control" value="{{ old('wahana_title', $pengaturan->wahana_title) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Teks Wahana (Bisa panjang)</label>
                    <textarea name="wahana_text" rows="4" class="form-control" required>{{ old('wahana_text', $pengaturan->wahana_text) }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3">Halaman Anjungan</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Halaman Anjungan</label>
                    <input type="text" name="anjungan_title" class="form-control" value="{{ old('anjungan_title', $pengaturan->anjungan_title) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Isi Teks Anjungan (Bisa panjang)</label>
                    <textarea name="anjungan_text" rows="4" class="form-control" required>{{ old('anjungan_text', $pengaturan->anjungan_text) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold" style="background: linear-gradient(135deg, #00B4B4, #9333ea); border: none;">
                        <i class="fa-solid fa-save me-2"></i> Simpan Semua Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
