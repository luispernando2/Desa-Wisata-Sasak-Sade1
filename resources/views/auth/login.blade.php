@extends('layouts.app')

@section('title', 'Login - Sasak Sade')

@section('content')

<style>

    /* ========================================= */
    /* LOGIN SECTION */
    /* ========================================= */

    .login-modern-section{

        min-height: 100vh;

        padding:
            140px 20px
            80px;

        position: relative;

        overflow: hidden;

        background:
            linear-gradient(
                180deg,
                #f7f4ef 0%,
                #f1ebe3 100%
            );
    }

    /* ========================================= */
    /* BACKGROUND BLUR */
    /* ========================================= */

    .login-blur{

        position: absolute;

        border-radius: 50%;

        filter: blur(90px);

        z-index: 0;
    }

    .login-blur-1{

        width: 320px;
        height: 320px;

        background: rgba(25,135,84,0.14);

        top: -80px;
        left: -80px;
    }

    .login-blur-2{

        width: 380px;
        height: 380px;

        background: rgba(215,184,153,0.25);

        bottom: -120px;
        right: -120px;
    }

    /* ========================================= */
    /* LOGIN WRAPPER */
    /* ========================================= */

    .login-wrapper{

        position: relative;

        z-index: 2;

        max-width: 1180px;

        margin: auto;
    }

    /* LEFT BACKGROUND SASAK IMAGE */
    .login-left-bg{

        position:absolute;
        inset:0;
        background-image: url('{{ asset('images/sade2.png') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.22;
        z-index: 0;
    }

    .login-left{

        position: relative;
        z-index: 2;
    }

    .login-left > *{
        position: relative;
        z-index: 2;
    }

    /* ensure background image sits behind content */
    .login-left-bg{
        pointer-events:none;
        position:absolute;
        inset:0;
        z-index:0;
        background-image: url('{{ asset('images/sade2.png') }}');
        background-size: cover;
        background-position: center;
        opacity: 0.22;
    }




    .login-card{

        overflow: hidden;

        border-radius: 40px;

        background: rgba(255,255,255,0.72);

        backdrop-filter: blur(22px);

        border: 1px solid rgba(255,255,255,0.6);

        box-shadow:
            0 30px 80px rgba(0,0,0,0.10);
    }

    /* ========================================= */
    /* LEFT SIDE */
    /* ========================================= */

    .login-left{

        position: relative;

        padding:
            60px 50px;

        min-height: 100%;

        background:
            linear-gradient(
                135deg,
                rgba(20,92,72,0.98),
                rgba(7,46,43,0.98)
            );

        color: #fff;

        overflow: hidden;
    }

    .login-left::before{

        content: '';

        position: absolute;

        width: 260px;
        height: 260px;

        border-radius: 50%;

        background:
            rgba(255,255,255,0.08);

        top: -100px;
        right: -100px;
    }

    .login-left::after{

        content: '';

        position: absolute;

        width: 180px;
        height: 180px;

        border-radius: 50%;

        background:
            rgba(215,184,153,0.12);

        bottom: -70px;
        left: -70px;
    }

    .login-brand{

        position: relative;

        z-index: 2;

        display: flex;

        align-items: center;

        gap: 16px;

        margin-bottom: 60px;
    }

    .login-brand-logo{

        width: 56px;
        height: 56px;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                #e8c07d,
                #d7b899
            );

        display: flex;
        align-items: center;
        justify-content: center;

        color: #3d2417;

        font-size: 24px;
        font-weight: 800;

        box-shadow:
            0 10px 25px rgba(0,0,0,0.18);
    }

    .login-brand-title{

        font-size: 28px;
        font-weight: 800;
        line-height: 1;
    }

    .login-brand-sub{

        color: rgba(255,255,255,0.65);

        margin-top: 4px;
    }

    .login-left-title{

        position: relative;

        z-index: 2;

        font-size: 48px;

        line-height: 1.1;

        font-weight: 800;

        margin-bottom: 24px;
    }

    .login-left-desc{

        position: relative;

        z-index: 2;

        color: rgba(255,255,255,0.72);

        line-height: 1.9;

        font-size: 15px;

        max-width: 420px;
    }

    /* FEATURE BOX */

    .login-feature{

        position: relative;

        z-index: 2;

        margin-top: 40px;

        padding: 26px;

        border-radius: 28px;

        background:
            rgba(255,255,255,0.08);

        border:
            1px solid rgba(255,255,255,0.10);

        backdrop-filter: blur(10px);
    }

    .login-feature-icon{

        width: 56px;
        height: 56px;

        border-radius: 18px;

        background:
            linear-gradient(
                135deg,
                #e8c07d,
                #d7b899
            );

        display: flex;
        align-items: center;
        justify-content: center;

        color: #3d2417;

        font-size: 22px;

        margin-bottom: 18px;
    }

    .login-feature h5{

        font-weight: 700;
    }

    .login-feature p{

        color: rgba(255,255,255,0.65);

        margin-bottom: 0;

        line-height: 1.7;

        font-size: 14px;
    }

    /* ========================================= */
    /* RIGHT SIDE */
    /* ========================================= */

    .login-right{

        padding:
            65px 55px;

        /* transparan biar background di kanan terlihat */
        background:
            rgba(255,255,255,0.35);
    }

    .login-badge{

        display: inline-flex;

        align-items: center;

        gap: 10px;

        padding:
            10px 18px;

        border-radius: 50px;

        background:
            rgba(25,135,84,0.08);

        color: #198754;

        font-size: 13px;

        font-weight: 700;
    }

    .login-form-title{

        font-size: 42px;

        font-weight: 800;

        color: #222;

        margin-top: 22px;
    }

    .login-form-desc{

        color: #777;

        margin-top: 12px;

        margin-bottom: 38px;

        line-height: 1.8;
    }

    /* ========================================= */
    /* INPUT */
    /* ========================================= */

    .login-label{

        font-size: 14px;

        font-weight: 700;

        margin-bottom: 10px;

        color: #222;
    }

    .login-input{

        height: 62px;

        border-radius: 20px !important;

        border: 1px solid rgba(0,0,0,0.08);

        background: rgba(255,255,255,0.85);

        padding:
            0 22px;

        font-size: 15px;

        transition: all 0.3s ease;
    }

    .login-input:focus{

        border-color: #198754;

        box-shadow:
            0 0 0 4px rgba(25,135,84,0.10);
    }

    /* ========================================= */
    /* BUTTON */
    /* ========================================= */

    .login-btn{

        width: 100%;

        height: 62px;

        border: none;

        border-radius: 22px;

        background:
            linear-gradient(
                135deg,
                #198754,
                #32c671
            );

        color: #fff;

        font-weight: 700;

        font-size: 16px;

        margin-top: 12px;

        transition: all 0.35s ease;

        box-shadow:
            0 18px 35px rgba(25,135,84,0.22);
    }

    .login-btn:hover{

        transform: translateY(-4px);

        box-shadow:
            0 22px 45px rgba(25,135,84,0.28);
    }

    /* ========================================= */
    /* LINKS */
    /* ========================================= */

    .login-link{

        color: #198754;

        font-weight: 700;

        text-decoration: none;
    }

    .login-link:hover{

        color: #146c43;
    }

    .login-back{

        display: inline-flex;

        align-items: center;

        gap: 12px;

        color: #3d2417;

        text-decoration: none;

        font-weight: 700;
    }

    .login-back-icon{

        width: 36px;
        height: 36px;

        border-radius: 50%;

        background:
            rgba(215,184,153,0.28);

        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ========================================= */
    /* RESPONSIVE */
    /* ========================================= */

    @media (max-width: 992px){

        .login-left{

            padding: 45px 35px;
        }

        .login-right{

            padding: 45px 35px;
        }

        .login-left-title{

            font-size: 38px;
        }

        .login-form-title{

            font-size: 34px;
        }

    }

    @media (max-width: 768px){

        .login-modern-section{

            padding-top: 120px;
        }

        .login-left{

            padding: 40px 28px;
        }

        .login-right{

            padding: 40px 28px;
        }

        .login-left-title{

            font-size: 30px;
        }

        .login-form-title{

            font-size: 28px;
        }

    }

</style>

<section class="login-modern-section">

    <!-- BLUR -->
    <div class="login-blur login-blur-1"></div>
    <div class="login-blur login-blur-2"></div>

    <div class="login-wrapper">



            <div class="row g-0">

                <!-- LEFT -->
                <div class="col-lg-5">

                    <div class="login-left">
                        <div class="login-left-bg" aria-hidden="true"></div>


                        <!-- BRAND -->
                        <div class="login-brand">

                            <div class="login-brand-logo">
                                S
                            </div>

                            <div>

                                <div class="login-brand-title">
                                    Sasak Sade
                                </div>

                                <div class="login-brand-sub">
                                    Desa Wisata Budaya
                                </div>

                            </div>

                        </div>

                        <!-- TITLE -->
                        <h2 class="login-left-title">

                            Selamat Datang
                            Kembali 👋

                        </h2>

                        <p class="login-left-desc">

                            Login untuk menikmati pengalaman wisata budaya
                            Desa Sasak Sade, melakukan booking paket wisata,
                            melihat event budaya, dan menjelajahi produk lokal.

                        </p>

                        <!-- FEATURE -->

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-7">

                    <div class="login-right">

                        <span class="login-badge">

                            🔐 Secure Login

                        </span>

                        <h3 class="login-form-title">
                            Login Akun
                        </h3>

                        <p class="login-form-desc">

                            Gunakan email dan password untuk masuk
                            ke akun Anda.

                        </p>

                        @if(session('error'))

                            <div class="alert alert-danger rounded-4 mb-4">

                                {{ session('error') }}

                            </div>

                        @endif

                        <form action="{{ route('login.submit') }}"
                            method="POST">

                            @csrf

                            <!-- EMAIL -->
                            <div class="mb-4">

                                <label class="login-label">

                                    Email

                                </label>

                                <input type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control login-input"
                                    placeholder="nama@email.com"
                                    required>

                                @error('email')

                                    <div class="text-danger small mt-2">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <!-- PASSWORD -->
                            <div class="mb-4">

                                <label class="login-label">

                                    Password

                                </label>

                                <input type="password"
                                    name="password"
                                    class="form-control login-input"
                                    placeholder="••••••••"
                                    required>

                                @error('password')

                                    <div class="text-danger small mt-2">

                                        {{ $message }}

                                    </div>

                                @enderror

                            </div>

                            <!-- OPTIONS -->
                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="remember"
                                        name="remember">

                                    <label class="form-check-label"
                                        for="remember">

                                        Ingat saya

                                    </label>

                                </div>

                                <a href="{{ route('password.request') }}"
                                    class="login-link">

                                    Lupa password?

                                </a>

                            </div>

                            <!-- BUTTON -->
                            <button type="submit"
                                class="login-btn">

                                Masuk Sekarang

                            </button>

                            <!-- FOOTER -->
                            <div class="text-center mt-5">

                                <a href="{{ route('home') }}"
                                    class="login-back mb-3">

                                    <span class="login-back-icon">
                                        ←
                                    </span>

                                    Kembali ke Beranda

                                </a>

                                <div class="mt-3">

                                    <span class="text-muted">

                                        Belum punya akun?

                                    </span>

                                    <a href="{{ route('register') }}"
                                        class="login-link ms-2">

                                        Daftar sekarang

                                    </a>

                                </div>

                            </div>

                            @if($errors->any())

                                <div class="alert alert-danger rounded-4 mt-4 mb-0">

                                    <ul class="mb-0">

                                        @foreach($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                </div>

                            @endif

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
