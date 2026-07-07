@extends('layouts.app')

@section('title', 'Lupa Password - Sasak Sade')

@section('content')
<style>
    .password-page {
        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 64px 0;
    }

    .password-card {
        overflow: hidden;
        border: 0;
        border-radius: 32px;
        box-shadow: 0 26px 70px rgba(15, 23, 42, 0.12);
    }

    .password-panel {
        min-height: 100%;
        padding: 42px;
        color: #fff;
        background: linear-gradient(135deg, #0e3a37 0%, #08242d 100%);
    }

    .password-logo {
        width: 48px;
        height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        background: #e8c07d;
        color: #4a2b1a;
        font-weight: 800;
    }

    .password-form {
        padding: 42px;
        background: rgba(255, 255, 255, 0.92);
    }

    .password-input {
        height: 56px;
        border-radius: 18px;
    }

    .password-submit {
        height: 56px;
        border: 0;
        border-radius: 999px;
        background: linear-gradient(135deg, #198754, #32c671);
        color: #fff;
        font-weight: 700;
    }

    .password-link {
        color: #198754;
        font-weight: 700;
        text-decoration: none;
    }

    .password-link:hover {
        color: #146c43;
    }
</style>

<div class="password-page">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-lg-9 col-xl-8">
            <div class="card password-card">
                <div class="row g-0">
                    <div class="col-lg-5">
                        <div class="password-panel">
                            <div class="d-flex align-items-center gap-3 mb-5">
                                <div class="password-logo">S</div>
                                <div>
                                    <div class="fw-bold fs-4 lh-1">Sasak Sade</div>
                                    <div class="text-white-50">Desa Wisata Budaya</div>
                                </div>
                            </div>

                            <h2 class="fw-bold mb-3">Lupa Password</h2>
                            <p class="text-white-50 mb-0">
                                Masukkan email akun Anda. Kami akan mengirimkan link untuk membuat password baru.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="password-form">
                            <h3 class="fw-bold mb-2">Reset Password</h3>
                            <p class="text-muted mb-4">Gunakan email yang terdaftar di akun Sasak Sade.</p>

                            @if($errors->any())
                                <div class="alert alert-danger rounded-4 mb-4">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control password-input"
                                        placeholder="nama@email.com"
                                        required
                                        autofocus>
                                </div>

                                <button type="submit" class="password-submit w-100">
                                    Kirim Link Reset
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}" class="password-link">Kembali ke Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
