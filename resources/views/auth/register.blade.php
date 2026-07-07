@extends('layouts.app')

@section('title', 'Daftar Akun - Sasak Sade')

@section('content')

<style>
    .register-sasak-image{
        position:absolute;
        inset:0;
        background-image:url('{{ asset('images/sade2.png') }}');
        background-size:cover;
        background-position:center;
        opacity:0.18;
        z-index:0;
    }
    .register-left{
        position:relative;
        z-index:1;
        overflow: visible;
    }

    /* transparan biar background terlihat full di samping gambar */
    .register-form-right{
        background: rgba(255,255,255,0.35) !important;
    }

    /* agar halaman register bisa scroll atas-bawah saat konten kepanjangan */
    .register-page{
        min-height: 100vh;
        overflow-y: auto;
    }
</style>

<div class="container py-0">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-5 p-4 p-lg-5" style="background: linear-gradient(135deg, rgba(26,87,84,.95) 0%, rgba(11,58,55,.95) 100%); color: #fff; position:relative; z-index:1;">
                        <div class="register-sasak-image" aria-hidden="true"></div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="me-3 rounded-circle bg-warning" style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;color:#3d2417;font-weight:900;">S</div>
                            <div>
                                <div class="fw-bold fs-4 lh-1">Sasak Sade</div>
                                <div class="text-white-50">Desa Wisata Budaya</div>
                            </div>
                        </div>

                        <h2 class="fw-bold mb-3">Bergabung jadi bagian perjalanan</h2>
                        <p class="mb-4 text-white-50">Daftar akun untuk booking dan memberikan review.</p>

                        @if($errors->any())
                            <div class="alert alert-danger rounded-4 mb-4" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-7 p-4 p-lg-5" style="background: rgba(255,255,255,0.35);">
                        <h3 class="fw-bold mb-3">Daftar</h3>
                        <p class="text-muted mb-4">Lengkapi data berikut.</p>

                        <form action="{{ route('register.submit') }}" method="POST" class="needs-validation">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control rounded-4" placeholder="Nama lengkap" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control rounded-4" placeholder="nama@email.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control rounded-4" placeholder="••••••••" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-4" placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-semibold">
                                Daftar
                            </button>

                            <div class="text-center mt-4">
                                <a href="{{ route('home') }}" class="d-inline-flex align-items-center justify-content-center gap-2 mb-2 text-decoration-none" style="color:#3d2417; font-weight:700;">
                                    <span style="width:28px;height:28px;border-radius:999px;background: rgba(232,192,125,.35); display:flex; align-items:center; justify-content:center;">←</span>
                                    Kembali ke Beranda
                                </a>

                                <div>
                                    <span class="text-muted">Sudah punya akun?</span>
                                    <a href="{{ route('login') }}" class="ms-2 fw-semibold" style="color:#3ad7d3; text-decoration:none;">
                                        Login
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

