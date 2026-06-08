@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold text-dark mb-1">Selamat datang kembali, <span style="color: #00B4B4;">{{ Auth::user()->name }}</span></h3>
            <p class="text-muted small mb-0">Pantau dan kelola seluruh sistem dari dashboard utama, Berikut ringkasan data dan aktivitas sistem.</p>
        </div>
        <div class="dropdown">
            <button class="btn fw-bold shadow-sm px-4 py-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" style="background-color: #0f172a; color: white; border-radius: 8px;">
                <i class="fa-solid fa-plus me-2 text-info"></i> Tambah Data
            </button>
            <ul class="dropdown-menu border-0 shadow mt-2" style="border-radius: 8px;">
                <li><a class="dropdown-item py-2 small fw-bold" href="{{ route('tikets.create') }}"><i class="fa-solid fa-ticket me-2 text-info"></i> Tambah Tiket</a></li>
                <li><a class="dropdown-item py-2 small fw-bold" href="{{ route('artikels.create') }}"><i class="fa-solid fa-newspaper me-2 text-warning"></i> Tambah Artikel</a></li>
                <li><a class="dropdown-item py-2 small fw-bold" href="{{ route('katalogs.create') }}"><i class="fa-solid fa-map-location-dot me-2 text-danger"></i> Tambah Destinasi</a></li>
            </ul>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Penjualan Tiket</p>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">{{ $totalTiket }}</h2>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fa-solid fa-ticket fs-4"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-medium">Tiket aktif di sistem</span>
                    <a href="{{ route('tikets.index') }}" class="small fw-bold text-decoration-none">Kelola <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Publikasi Artikel</p>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">{{ $totalArtikel }}</h2>
                    </div>
                    <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fa-solid fa-newspaper fs-4"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-medium">Artikel tayang publik</span>
                    <a href="{{ route('artikels.index') }}" class="small fw-bold text-decoration-none text-warning">Kelola <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-bold text-uppercase mb-2" style="letter-spacing: 0.5px;">Katalog Destinasi</p>
                        <h2 class="fw-bold text-dark mb-0" style="font-size: 2.5rem;">{{ \App\Models\Katalog::count() }}</h2>
                    </div>
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                        <i class="fa-solid fa-map-location-dot fs-4"></i>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-medium">Wahana & Museum</span>
                    <a href="{{ route('katalogs.index') }}" class="small fw-bold text-decoration-none text-danger">Kelola <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="row g-4">
        <!-- CHART -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold text-dark m-0">Jumlah Destinasi per Kategori</h6>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill shadow-sm">Real-Time Data</span>
                </div>
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="katalogChart"></canvas>
                </div>
            </div>
        </div>
        
        <!-- MESSAGES -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white" style="border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <h6 class="fw-bold text-dark m-0">Pesan Pengunjung</h6>
                    <a href="{{ route('admin.pesan.index') }}" class="small fw-bold text-decoration-none">Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
                
                <div class="d-flex flex-column gap-3 mt-2">
                    @forelse(\App\Models\Pesan::latest()->take(5)->get() as $p)
                    <div class="d-flex align-items-center">
                        <div class="bg-light border rounded-circle text-center me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; flex-shrink: 0;">
                            <i class="fa-solid fa-user text-muted"></i>
                        </div>
                        <div class="overflow-hidden">
                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.9rem;">{{ $p->nama }}</div>
                            <div class="text-muted text-truncate small" style="font-size: 0.8rem;">{{ $p->subjek }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted small py-4">Belum ada pesan masuk.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('katalogChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [{
                        label: 'Jumlah Destinasi',
                        data: {!! json_encode($chartData) !!},
                        backgroundColor: '#0f172a',
                        borderRadius: 6,
                        barPercentage: 0.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f8fafc' }, ticks: { color: '#64748b' } },
                        x: { grid: { display: false }, ticks: { color: '#64748b', font: { weight: '600' } } }
                    }
                }
            });
        });
    </script>
@endsection
