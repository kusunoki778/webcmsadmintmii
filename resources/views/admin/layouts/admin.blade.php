<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMII Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --sidebar-dark: #0f172a; --sidebar-active: #1e293b; --tmii-tosca: #00B4B4; --tmii-purple: #9333ea; --admin-bg: #f8fafc; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--admin-bg); margin: 0; overflow-x: hidden; }
        .sidebar { background-color: var(--sidebar-dark); height: 100vh; position: fixed; width: 260px; padding: 30px 15px; z-index: 1000; border-right: 1px solid #1e293b; }
        .sidebar-brand { color: #f8fafc; font-size: 1.6rem; font-weight: 800; margin-bottom: 40px; text-align: center; letter-spacing: 1px; }
        .sidebar-brand span { color: var(--tmii-tosca); }
        
        .nav-label { color: #475569; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; margin: 20px 0 10px 15px; }
        
        .nav-link { color: #94a3b8 !important; padding: 12px 20px; border-radius: 12px; margin-bottom: 4px; display: flex; align-items: center; text-decoration: none; transition: all 0.3s ease; font-weight: 500; font-size: 0.9rem; }
        .nav-link i { margin-right: 15px; font-size: 1rem; width: 20px; text-align: center; }
        .nav-link:hover { color: #f8fafc !important; background: rgba(255,255,255,0.05); transform: translateX(5px); }
        .nav-link.active { color: #ffffff !important; background: linear-gradient(90deg, #1e293b 0%, #0f172a 100%); border-left: 4px solid var(--tmii-tosca); border-radius: 4px 12px 12px 4px; }
        
        .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }
        .logout-container { position: absolute; bottom: 30px; left: 15px; right: 15px; border-top: 1px solid #1e293b; pt: 20px; }
        .btn-logout { background: transparent; border: none; width: 100%; text-align: left; cursor: pointer; font-size: 0.9rem; padding: 15px 20px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand"><span>tmii</span> admin</div>
        
        <nav class="nav flex-column">
            <div class="nav-label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney"></i> Dashboard
            </a>

            <div class="nav-label">Content & Catalog</div>
            <a href="{{ route('artikels.index') }}" class="nav-link {{ request()->is('admin/artikels*') ? 'active' : '' }}">
                <i class="fa-solid fa-newspaper"></i> Artikel Berita
            </a>
            <a href="{{ route('katalogs.index') }}" class="nav-link {{ request()->is('admin/katalog*') ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> Katalog Konten
            </a>
            
            <div class="nav-label">Operational</div>
            <a href="{{ route('tikets.index') }}" class="nav-link {{ request()->is('admin/tikets*') ? 'is-active' : '' }} {{ request()->is('admin/tikets*') ? 'active' : '' }}">
                <i class="fa-solid fa-ticket"></i> Manajemen Tiket
            </a>
            <a href="{{ route('admin.pesan.index') }}" class="nav-link {{ request()->is('admin/pesan*') ? 'active' : '' }}">
                <i class="fa-solid fa-comment-dots"></i> Pesan Masuk
            </a>

            @if(Auth::user()->hasRole('super-admin'))
            <div class="nav-label">System Settings</div>
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-sliders"></i> Pengaturan Web
            </a>
            @endif
        </nav>
        
        <div class="logout-container">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn-logout text-danger">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar Sistem
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
