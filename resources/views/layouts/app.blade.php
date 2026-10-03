<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMII - Jelajahi Indonesia dalam Satu Tempat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --tmii-primary: #00B4B4;
            --tmii-purple: #9333ea;
            --tmii-dark: #0f172a;
        }
        
        /* Page Transition Effect */
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #ffffff; 
            color: #1e293b; 
            margin: 0; 
            overflow-x: hidden;
            animation: fadeInPage 0.8s ease-in-out;
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .navbar { background-color: #f4f4f4; padding: 15px 0; border-bottom: 1px solid #f1f5f9; transition: all 0.3s ease; }
        .navbar-brand { font-weight: 800; color: var(--tmii-primary) !important; font-size: 1.6rem; letter-spacing: -1px; }
        .nav-link { color: #334155 !important; font-weight: 500; font-size: 0.95rem; margin: 0 15px; transition: 0.2s; }
        .nav-link:hover { color: var(--tmii-primary) !important; }
        .dropdown-toggle::after { font-size: 0.7rem; vertical-align: middle; }
        .dropdown-menu { border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-radius: 15px; padding: 10px 0; margin-top: 15px !important; }
        .dropdown-item { font-weight: 500; padding: 10px 25px; color: #334155; font-size: 0.9rem; }
        .dropdown-item:hover { background-color: #f8fafc; color: var(--tmii-primary); }
        .btn-beli-nav { background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); color: white !important; border-radius: 50px; padding: 10px 30px; font-weight: 600; font-size: 0.9rem; border: none; box-shadow: 0 4px 15px rgba(147, 51, 234, 0.3); transition: 0.3s; text-decoration: none; }
        .btn-beli-nav:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(147, 51, 234, 0.4); filter: brightness(1.1); }
        
        .footer { background-color: var(--tmii-dark); color: #94a3b8; padding: 70px 0 30px; }
        .footer-brand { font-weight: 800; color: var(--tmii-primary); font-size: 1.5rem; margin-bottom: 20px; display: block; text-decoration: none; }
        .footer h6 { color: #fff; font-weight: 700; margin-bottom: 25px; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
        .footer a { color: #94a3b8; text-decoration: none; font-size: 0.9rem; display: block; margin-bottom: 12px; transition: 0.2s; }
        .footer a:hover { color: var(--tmii-primary); }
        .social-icons a { display: inline-flex; width: 35px; height: 35px; background: rgba(255,255,255,0.05); border-radius: 50%; align-items: center; justify-content: center; margin-right: 10px; color: #fff; font-size: 0.9rem; transition: 0.3s; }
        .social-icons a:hover { background: var(--tmii-primary); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.05); margin-top: 50px; padding-top: 30px; font-size: 0.8rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="/">{{ get_setting('site_name', 'tmii') }}</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tentang.tmii') ? 'active' : '' }}" href="{{ route('tentang.tmii') }}">Tentang TMII</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="jelajahDrop" role="button" data-bs-toggle="dropdown">Jelajahi</a>
                        <ul class="dropdown-menu">
                            {{-- LINK ANJUNGAN NAVBAR SUDAH DIBENARKAN --}}
                            <li><a class="dropdown-item" href="{{ route('anjungan.index') }}">Anjungan Daerah</a></li>
                            <li><a class="dropdown-item " href="{{ route('museum.detail') }}">Museum</a></li>
                            <li><a class="dropdown-item " href="{{ route('wahana.detail') }}">Wahana Rekreasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tiket.info') ? 'active' : '' }}" href="{{ route('tiket.info') }}">Tiket & Jam Buka</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('hubungi.kami') ? 'active' : '' }}" href="{{ route('hubungi.kami') }}">Hubungi</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="{{ route('beli-tiket') }}" class="btn-beli-nav">Beli Vouchert</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <a href="/" class="footer-brand">{{ get_setting('site_name', 'tmii') }}</a>
                    <p class="small pe-md-5">{{ get_setting('footer_description') }}</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6>Navigasi</h6>
                    <a href="{{ route('tentang.tmii') }}">Tentang TMII</a>
                    <a href="{{ route('tiket.info') }}">Jadwal & Jam Buka</a>
                    <a href="{{ route('beli-tiket') }}">Beli Tiket</a>
                </div>
                <div class="col-md-3 mb-4">
                    <h6>Jelajahi</h6>
                    {{-- LINK ANJUNGAN FOOTER SUDAH DIBENARKAN --}}
                    <a href="{{ route('anjungan.index') }}">Anjungan Daerah</a>
                    <a href="{{ route('museum.detail') }}">Museum</a>
                    <a href="{{ route('wahana.detail') }}">Wahana Rekreasi</a>
                </div>
                <div class="col-md-3 mb-4 text-md-end">
                    <h6>Ikuti Kami</h6>
                    <div class="social-icons justify-content-md-end">
                        <a href="{{ get_setting('facebook_url', '#') }}"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="{{ get_setting('instagram_url', '#') }}"><i class="fa-brands fa-instagram"></i></a>
                        <a href="{{ get_setting('tiktok_url', '#') }}"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="{{ get_setting('youtube_url', '#') }}"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom d-flex justify-content-between align-items-center">
                <p class="mb-0">© {{ date('Y') }} {{ get_setting('site_name', 'Taman Mini Indonesia Indah') }}. All rights reserved.</p>
                <p class="mb-0">Powered by <span class="text-white fw-bold">Kelompok 8</span></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });

        // Hover effect for nav items
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => { this.style.transform = 'scale(1)'; }, 100);
            });
        });
    </script>
</body>
</html>
