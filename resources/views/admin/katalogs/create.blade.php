@extends('admin.layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold"><i class="fa-solid fa-plus text-primary me-2"></i> Tambah Data Baru</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('katalogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama (Anjungan/Museum/Wahana)</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Anjungan Jawa Tengah" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Anjungan">Anjungan Daerah</option>
                                <option value="Museum">Museum</option>
                                <option value="Wahana">Wahana Rekreasi</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" rows="5" class="form-control" placeholder="Tuliskan deskripsi lengkap di sini..." required></textarea>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Latitude <span class="text-muted fw-normal">(opsional)</span></label>
                                <input type="text" name="latitude" class="form-control" placeholder="-6.302481">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Longitude <span class="text-muted fw-normal">(opsional)</span></label>
                                <input type="text" name="longitude" class="form-control" placeholder="106.894832">
                            </div>
                            <small class="text-muted mt-1"><i class="fa-solid fa-circle-info me-1"></i> Klik kanan di Google Maps → copy koordinat → paste di sini.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('katalogs.index') }}" class="btn btn-secondary px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
