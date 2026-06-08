@extends('admin.layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold"><i class="fa-solid fa-pen text-primary me-2"></i> Tulis Artikel Baru</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('artikels.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" name="judul" class="form-control form-control-lg" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Gambar Cover</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Rekomendasi rasio 16:9, Maksimal 2MB</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Isi Konten</label>
                            <textarea name="konten" rows="10" class="form-control" placeholder="Tuliskan isi artikel di sini..." required></textarea>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('artikels.index') }}" class="btn btn-secondary px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">Terbitkan Artikel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
