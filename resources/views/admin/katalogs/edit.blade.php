@extends('admin.layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold"><i class="fa-solid fa-pen-to-square text-warning me-2"></i> Edit Katalog Konten</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('katalogs.update', $katalog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $katalog->nama }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Anjungan" {{ $katalog->kategori == 'Anjungan' ? 'selected' : '' }}>Anjungan Daerah</option>
                                <option value="Museum" {{ $katalog->kategori == 'Museum' ? 'selected' : '' }}>Museum</option>
                                <option value="Wahana" {{ $katalog->kategori == 'Wahana' ? 'selected' : '' }}>Wahana Rekreasi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar (Kosongkan jika tidak diganti)</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/katalogs/' . $katalog->gambar) }}" class="rounded-3 shadow-sm" style="height: 100px; object-fit: cover;">
                            </div>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" rows="5" class="form-control" required>{{ $katalog->deskripsi }}</textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Latitude <span class="text-muted fw-normal">(opsional)</span></label>
                                <input type="text" name="latitude" class="form-control" value="{{ $katalog->latitude }}" placeholder="-6.302481">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Longitude <span class="text-muted fw-normal">(opsional)</span></label>
                                <input type="text" name="longitude" class="form-control" value="{{ $katalog->longitude }}" placeholder="106.894832">
                            </div>
                            <small class="text-muted mt-1"><i class="fa-solid fa-circle-info me-1"></i> Klik kanan di Google Maps → copy koordinat → paste di sini.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('katalogs.index') }}" class="btn btn-secondary px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 rounded-pill">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
