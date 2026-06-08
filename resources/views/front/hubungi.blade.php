@extends('layouts.app')

@section('content')
<style>
    /* 1. HEADER SECTION */
    .hubungi-header { padding: 80px 0 40px; text-align: center; }
    .hubungi-header h1 { font-weight: 800; font-size: 3rem; color: #1e293b; margin-bottom: 15px; }
    .hubungi-header p { color: #64748b; max-width: 600px; margin: 0 auto; line-height: 1.6; }

    /* 2. TOP INFO CARDS */
    .card-info-hubungi {
        border: none;
        border-radius: 25px;
        padding: 40px 20px;
        text-align: center;
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        height: 100%;
        transition: 0.3s;
    }
    .icon-circle-hubungi {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.5rem;
        color: white;
    }
    .bg-tosca { background-color: #00B4B4; }
    .bg-purple { background-color: #9333ea; }
    .bg-yellow { background-color: #facc15; }
    .bg-blue { background-color: #0ea5e9; }

    .card-info-hubungi h5 { font-weight: 800; font-size: 1.2rem; margin-bottom: 15px; color: #1e293b; }
    .card-info-hubungi p { font-size: 0.85rem; color: #64748b; margin: 0; line-height: 1.5; }

    /* 3. FORM SECTION */
    .form-hubungi-wrapper {
        max-width: 800px;
        margin: 60px auto;
        background: #fff;
        border-radius: 35px;
        padding: 50px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.04);
    }
    .form-hubungi-wrapper h3 { font-weight: 800; margin-bottom: 35px; color: #1e293b; }
    
    .label-hubungi { font-weight: 700; font-size: 0.85rem; color: #475569; margin-bottom: 8px; display: block; }
    .input-hubungi {
        width: 100%;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 0.95rem;
        margin-bottom: 25px;
        transition: 0.3s;
    }
    .input-hubungi:focus {
        border-color: #00B4B4;
        outline: none;
        box-shadow: 0 0 0 4px rgba(0, 180, 180, 0.1);
    }

    .btn-kirim-gradasi {
        background: linear-gradient(90deg, #00B4B4 0%, #9333ea 100%);
        color: white;
        border: none;
        border-radius: 15px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s;
    }
    .btn-kirim-gradasi:hover { opacity: 0.9; transform: translateY(-2px); }

    /* 4. SOCIAL MEDIA BANNER */
    .social-banner-hubungi {
        background: linear-gradient(90deg, #00B4B4 0%, #9333ea 100%);
        border-radius: 30px;
        padding: 60px 20px;
        color: white;
        text-align: center;
        margin-bottom: 80px;
    }
    .social-banner-hubungi h3 { font-weight: 800; font-size: 2rem; margin-bottom: 10px; }
    .social-circle-group { display: flex; justify-content: center; gap: 15px; margin-top: 30px; }
    .social-circle-item {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #1e293b;
        text-decoration: none;
        font-weight: 800;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .social-circle-item:hover { transform: scale(1.1); color: #00B4B4; }
</style>

<div class="hubungi-header" data-aos="fade-down">
    <div class="container">
        <h1>Hubungi <span class="text-tosca">Kami</span></h1>
        <p>Kami siap membantu Anda. Jangan ragu untuk menghubungi kami untuk informasi lebih lanjut tentang Taman Mini Indonesia Indah.</p>
    </div>
</div>

<div class="container">
    <div class="row g-4 justify-content-center">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="card-info-hubungi">
                <div class="icon-circle-hubungi bg-tosca"><i class="fa-solid fa-location-dot"></i></div>
                <h5>Alamat</h5>
                <p>Jl. Raya Taman Mini, Jakarta Timur, DKI Jakarta 13560</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="card-info-hubungi">
                <div class="icon-circle-hubungi bg-purple"><i class="fa-brands fa-whatsapp"></i></div>
                <h5>WhatsApp</h5>
                <p>{{ get_setting('contact_whatsapp', '088289082184') }}</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="card-info-hubungi">
                <div class="icon-circle-hubungi bg-yellow"><i class="fa-solid fa-envelope"></i></div>
                <h5>Email</h5>
                <p>{{ get_setting('contact_email', 'info@tamanmini.com') }}</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="card-info-hubungi">
                <div class="icon-circle-hubungi bg-blue"><i class="fa-solid fa-clock"></i></div>
                <h5>Jam Operasional</h5>
                <p>Senin - Minggu<br>06:00 - 17:00 WIB</p>
            </div>
        </div>
    </div>

    <div class="form-hubungi-wrapper" data-aos="fade-up">
        <h3>Kirim Pesan</h3>
        <form action="{{ route('hubungi.store') }}" method="POST">
            @csrf
            <label class="label-hubungi">Nama Lengkap</label>
            <input type="text" name="nama" class="input-hubungi" placeholder="Masukkan nama Anda" required>

            <label class="label-hubungi">Email</label>
            <input type="email" name="email" class="input-hubungi" placeholder="nama@email.com" required>

            <label class="label-hubungi">Nomor Telepon</label>
            <input type="text" name="telepon" class="input-hubungi" placeholder="08xxxxxxxxxx" required>

            <label class="label-hubungi">Subjek</label>
            <select name="subjek" class="input-hubungi" required>
                <option value="">Pilih Subjek</option>
                <option value="Informasi Tiket">Informasi Tiket</option>
                <option value="Keluhan & Saran">Keluhan & Saran</option>
                <option value="Kemitraan">Kemitraan</option>
            </select>

            <label class="label-hubungi">Pesan</label>
            <textarea name="pesan" class="input-hubungi" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>

            <button type="submit" class="btn-kirim-gradasi">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pesan
            </button>
        </form>
    </div>

    <div class="social-banner-hubungi shadow-lg" data-aos="zoom-in">
        <h3>Ikuti Kami di Media Sosial</h3>
        <p>Dapatkan update terbaru tentang event, promo, dan kegiatan di TMII</p>
        <div class="social-circle-group">
            <a href="{{ get_setting('facebook_url', '#') }}" class="social-circle-item"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="{{ get_setting('instagram_url', '#') }}" class="social-circle-item"><i class="fa-brands fa-instagram"></i></a>
            <a href="{{ get_setting('tiktok_url', '#') }}" class="social-circle-item"><i class="fa-brands fa-tiktok"></i></a>
            <a href="{{ get_setting('youtube_url', '#') }}" class="social-circle-item"><i class="fa-brands fa-youtube"></i></a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Pesan Terkirim!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#00B4B4',
        borderRadius: '20px'
    });
</script>
@endif

@endsection
