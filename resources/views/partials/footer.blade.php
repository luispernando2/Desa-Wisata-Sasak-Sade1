@php
    $footerContent = ($homepageByKey ?? collect())->get('footer.main');

    $resolveContentUrl = function (?string $value, string $fallback = '#') {
        if (blank($value)) {
            return $fallback;
        }

        if (str_starts_with($value, 'route:')) {
            $routeName = substr($value, 6);

            return \Illuminate\Support\Facades\Route::has($routeName) ? route($routeName) : $fallback;
        }

        if (str_starts_with($value, '#') || preg_match('#^(https?:)?//#', $value)) {
            return $value;
        }

        return url($value);
    };

    $contact = $contact ?? [
        'address'  => 'Desa Sasak Sade, Lombok Tengah, Nusa Tenggara Barat',
        'phone'    => '+62 878-6593-6972',
        'email'    => 'info@sasaksade.com',
    ];

@endphp

<footer class="custom-footer">

    <div class="footer-glass">

        <div class="container footer-content">

            <div class="row gy-5">

                <!-- LEFT -->
                <div class="col-lg-5">

                    <div class="footer-brand d-flex align-items-center gap-3 mb-4">

                        <div class="footer-logo">
                            S
                        </div>

                        <div>

                            <h4 class="mb-1 text-white fw-bold">
                                {{ $footerContent?->title ?: 'Desa Wisata Sasak Sade' }}
                            </h4>

                            <p class="footer-subtitle mb-0">
                                {{ $footerContent?->subtitle ?: 'Wisata Budaya Lombok' }}
                            </p>

                        </div>

                    </div>

                    <p class="footer-description">
                        {{ $footerContent?->body ?: 'Temukan pengalaman budaya khas Lombok melalui wisata tradisional, pertunjukan budaya, rumah adat Sasak, serta produk lokal asli Desa Sasak Sade.' }}
                    </p>

                    <a href="{{ $resolveContentUrl($footerContent?->button_url, route('booking.index')) }}" class="footer-btn">
                        {{ $footerContent?->button_label ?: 'Booking Sekarang' }}
                    </a>

                </div>

                <!-- MENU -->
                <div class="col-6 col-lg-3">

                    <h5 class="footer-title">
                        Menu Cepat
                    </h5>

                    <ul class="footer-menu">

                        <li>
                            <a href="{{ route('about') }}">
                                Tentang
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('packages.index') }}">
                                Paket Wisata
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('events.index') }}">
                                Event
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('market.index') }}">
                                Produk Lokal
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('gallery.index') }}">
                                Galeri
                            </a>
                        </li>


                    </ul>

                </div>

                <!-- CONTACT -->
                <div class="col-6 col-lg-4">

                    <h5 class="footer-title">
                        Kontak
                    </h5>

                    <div class="footer-contact">

                        <div class="contact-item">

                            <span class="contact-label">
                                Alamat
                            </span>

                            <p>
                                {{ $contact['address'] }}
                            </p>

                        </div>

                        <div class="contact-item">

                            <span class="contact-label">
                                Telepon
                            </span>

                            <p>
                                {{ $contact['phone'] }}
                            </p>

                        </div>

                        <div class="contact-item">

                            <span class="contact-label">
                                Email
                            </span>

                            <p>
                                {{ $contact['email'] }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- COPYRIGHT -->
        <div class="footer-bottom">

            <div class="container text-center">

                <span class="footer-copyright">
                    {{ data_get($footerContent?->meta, 'copyright', 'Copyright 2026 Desa Wisata Sasak Sade - Semua Hak Dilindungi') }}
                </span>

                © 2026 Desa Wisata Sasak Sade • Semua Hak Dilindungi

            </div>

        </div>

    </div>

</footer>

<style>

    /* ===================================================== */
    /* FOOTER WRAPPER */
    /* ===================================================== */

    .custom-footer{

        margin-top:80px;

        padding:
            0 15px
            20px;

        /* BACKGROUND PUTIH */
        background:#ffffff;
    }

    /* ===================================================== */
    /* GLASS FOOTER */
    /* ===================================================== */

    .footer-glass{

        /* GLASS COKLAT TRANSPARAN */
        background: rgba(62, 39, 35, 0.45);

        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);

        border: 1px solid rgba(255,255,255,0.15);

        border-radius: 30px;

        overflow: hidden;

        box-shadow:
            0 10px 35px rgba(0,0,0,0.20);
    }

    /* ===================================================== */
    /* CONTENT */
    /* ===================================================== */

    .footer-content{

        padding-top:70px;
        padding-bottom:60px;
    }

    /* ===================================================== */
    /* BRAND */
    /* ===================================================== */

    .footer-logo{

        width:60px;
        height:60px;

        border-radius:50%;

        background: rgba(215,184,153,0.95);

        color:#3e2723;

        display:flex;
        align-items:center;
        justify-content:center;

        font-size:28px;
        font-weight:800;

        box-shadow:
            0 6px 15px rgba(0,0,0,0.20);
    }

    /* ===================================================== */
    /* SUBTITLE */
    /* ===================================================== */

    .footer-subtitle{

        color: rgba(255,255,255,0.72);

        font-size:14px;
    }

    /* ===================================================== */
    /* DESCRIPTION */
    /* ===================================================== */

    .footer-description{

        color:#f3e5d4;

        line-height:1.9;

        margin-bottom:28px;

        max-width:500px;
    }

    /* ===================================================== */
    /* BUTTON */
    /* ===================================================== */

    .footer-btn{

        display:inline-block;

        background: rgba(215,184,153,0.95);

        color:#3e2723;

        padding:
            12px
            24px;

        border-radius:16px;

        font-weight:700;

        text-decoration:none;

        transition: all 0.3s ease;

        box-shadow:
            0 6px 18px rgba(0,0,0,0.18);
    }

    .footer-btn:hover{

        background:#edd3b4;

        color:#2d1b18;

        transform:translateY(-2px);
    }

    /* ===================================================== */
    /* TITLE */
    /* ===================================================== */

    .footer-title{

        color:#fff;

        font-weight:700;

        margin-bottom:25px;
    }

    /* ===================================================== */
    /* MENU */
    /* ===================================================== */

    .footer-menu{

        list-style:none;

        padding:0;

        margin:0;
    }

    .footer-menu li{

        margin-bottom:14px;
    }

    .footer-menu a{

        color:#f3e5d4;

        text-decoration:none;

        font-weight:500;

        transition: all 0.3s ease;
    }

    .footer-menu a:hover{

        color:#fff;

        padding-left:5px;
    }

    /* ===================================================== */
    /* CONTACT */
    /* ===================================================== */

    .footer-contact{

        display:flex;

        flex-direction:column;

        gap:18px;
    }

    .contact-item p{

        margin:6px 0 0;

        color:#f3e5d4;

        line-height:1.7;
    }

    .contact-label{

        color:#E8C07D;

        font-size:14px;

        font-weight:700;

        letter-spacing:0.5px;
    }

    /* ===================================================== */
    /* BOTTOM */
    /* ===================================================== */

    .footer-bottom{

        background: rgba(255,255,255,0.08);

        backdrop-filter: blur(12px);

        border-top:
            1px solid rgba(255,255,255,0.10);

        padding:18px 0;

        color:#f3dcc0;

        font-size:14px;
    }

    .footer-bottom .container{

        font-size:0;
    }

    .footer-copyright{

        font-size:14px;
    }

    /* ===================================================== */
    /* RESPONSIVE */
    /* ===================================================== */

    @media(max-width:768px){

        .custom-footer{

            padding:
                0 8px
                12px;
        }

        .footer-content{

            padding-top:50px;
            padding-bottom:40px;
        }

        .footer-title{

            margin-top:10px;
        }

        .footer-glass{

            border-radius:24px;
        }

    }

</style>
