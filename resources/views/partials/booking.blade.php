<section id="booking" class="booking-modern-section py-5">

    <!-- BACKGROUND BLUR -->
    <div class="booking-bg-circle circle-1"></div>
    <div class="booking-bg-circle circle-2"></div>

    <div class="row g-4 align-items-stretch">

        <!-- LEFT SIDE -->
        <div class="col-lg-4">

            <div class="booking-info-card h-100">

                <div class="booking-info-overlay"></div>

                <div class="booking-info-content position-relative z-2">

                    <span class="booking-mini-badge">
                        Booking Experience
                    </span>

                    <h2 class="booking-main-title mt-4">
                        Mulai Perjalanan Budaya
                        Bersama Desa Sasak Sade
                    </h2>

                    <p class="booking-main-desc mt-4">
                        Nikmati pengalaman budaya tradisional Lombok
                        dengan sistem booking modern, cepat,
                        dan langsung terhubung ke admin WhatsApp.
                    </p>

                    <!-- FEATURES -->
                    <div class="booking-feature-list mt-5">

                        <div class="booking-feature-item">
                            <div class="booking-feature-icon">
                                <i class="bi bi-whatsapp"></i>
                            </div>

                            <div>
                                <h6>Konfirmasi Cepat</h6>
                                <p>
                                    Booking langsung diproses admin melalui WhatsApp.
                                </p>
                            </div>
                        </div>

                        <div class="booking-feature-item">
                            <div class="booking-feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <h6>Pembayaran Aman</h6>
                                <p>
                                    Pembayaran transfer bank dengan verifikasi admin.
                                </p>
                            </div>
                        </div>

                        <div class="booking-feature-item">
                            <div class="booking-feature-icon">
                                <i class="bi bi-stars"></i>
                            </div>

                            <div>
                                <h6>Pengalaman Eksklusif</h6>
                                <p>
                                    Paket budaya autentik khas masyarakat Sasak.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- CTA -->
                    <a href="https://wa.me/6282339886647?text={{ rawurlencode('Halo Admin Sasak Sade, saya ingin booking paket wisata.') }}"
    target="_blank"
    class="booking-wa-btn mt-5">

    <i class="bi bi-whatsapp"></i>
    Hubungi Admin
</a>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-8">

            <div class="booking-form-wrapper">

                <!-- HEADER -->
                <div class="booking-form-header">

                    <div>
                        <span class="booking-form-badge">
                            Form Reservasi
                        </span>

                        <h3 class="booking-form-title">
                            Booking Paket Wisata
                        </h3>
                    </div>

                    <div class="booking-step">
                        <span>01</span>
                    </div>

                </div>

                @if(session('auth_user'))

                    <form action="{{ route('booking.store') }}"
                        method="POST"
                        class="mt-4">

                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>
                                        Nama Lengkap
                                    </label>

                                    <div class="booking-input-wrap">
                                        <i class="bi bi-person"></i>

                                        <input type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            class="@error('name') is-invalid @enderror"
                                            placeholder="Masukkan nama lengkap"
                                            required>
                                    </div>

                                    @error('name')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>Email</label>

                                    <div class="booking-input-wrap">
                                        <i class="bi bi-envelope"></i>

                                        <input type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="@error('email') is-invalid @enderror"
                                            placeholder="Masukkan email"
                                            required>
                                    </div>

                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>Nomor WhatsApp</label>

                                    <div class="booking-input-wrap">
                                        <i class="bi bi-whatsapp"></i>

                                        <input type="text"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            class="@error('phone') is-invalid @enderror"
                                            placeholder="08xxxxxxxxxx"
                                            required>
                                    </div>

                                    @error('phone')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>Tanggal Kunjungan</label>

                                    <div class="booking-input-wrap">
                                        <i class="bi bi-calendar-event"></i>

                                        <input type="date"
                                            name="visit_date"
                                            value="{{ old('visit_date') }}"
                                            class="@error('visit_date') is-invalid @enderror"
                                            required>
                                    </div>

                                    @error('visit_date')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-12">

                                <div class="booking-input-group">

                                    <label>Pilih Paket Wisata</label>

                                    <div class="booking-input-wrap">

                                        <i class="bi bi-box2-heart"></i>

                                        <select name="package_id"
                                            class="@error('package_id') is-invalid @enderror"
                                            required>

                                            <option value="">
                                                Pilih Paket Wisata
                                            </option>

                                            @foreach($packages as $package)

                                                <option value="{{ $package->id }}"
                                                    @selected(
                                                        old('package_id') == $package->id
                                                        || (
                                                            empty(old('package_id'))
                                                            && isset($selectedPackageId)
                                                            && (string) $selectedPackageId === (string) $package->id
                                                        )
                                                    )>


                                                    {{ $package->title }}
                                                    -
                                                    Rp{{ number_format($package->price,0,',','.') }}

                                                </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    @error('package_id')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>Jumlah Pengunjung</label>

                                    <div class="booking-input-wrap">

                                        <i class="bi bi-people"></i>

                                        <input type="number"
                                            name="guests"
                                            min="1"
                                            max="100"
                                            value="{{ old('guests', 1) }}"
                                            class="@error('guests') is-invalid @enderror"
                                            required>

                                    </div>

                                    @error('guests')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="booking-input-group">

                                    <label>Catatan Tambahan</label>

                                    <div class="booking-input-wrap">

                                        <i class="bi bi-chat-left-text"></i>

                                        <input type="text"
                                            name="message"
                                            value="{{ old('message') }}"
                                            class="@error('message') is-invalid @enderror"
                                            placeholder="Tambahkan catatan">

                                    </div>

                                    @error('message')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        <button type="submit"
                            class="booking-submit-btn mt-5">

                            <i class="bi bi-send-fill"></i>
                            Kirim Booking
                        </button>

                    </form>

                @else

                    <div class="booking-login-box mt-4">

                        <div class="booking-lock-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>

                        <h4>
                            Login Untuk Booking
                        </h4>

                        <p>
                            Silakan login atau daftar terlebih dahulu
                            agar dapat melakukan reservasi wisata budaya.
                        </p>

                        <div class="d-flex flex-wrap gap-3 justify-content-center">

                            <a href="{{ route('login') }}"
                                class="booking-login-btn">

                                Login

                            </a>

                            <a href="{{ route('register') }}"
                                class="booking-register-btn">

                                Daftar

                            </a>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

<style>

    /* ========================= */
    /* BOOKING SECTION */
    /* ========================= */

    .booking-modern-section{
        position: relative;
        overflow: hidden;
    }

    .booking-bg-circle{
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        z-index: 0;
    }

    .circle-1{
        width: 350px;
        height: 350px;
        background: rgba(29,185,84,0.18);
        top: -120px;
        left: -120px;
    }

    .circle-2{
        width: 300px;
        height: 300px;
        background: rgba(255,193,7,0.12);
        bottom: -120px;
        right: -120px;
    }

    /* ========================= */
    /* LEFT CARD */
    /* ========================= */

    .booking-info-card{
        position: relative;
        border-radius: 35px;
        overflow: hidden;
        min-height: 100%;
        padding: 45px;
        background:
            url('https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=1200&auto=format&fit=crop')
            center center/cover no-repeat;
        box-shadow: 0 25px 50px rgba(0,0,0,0.18);
    }

    .booking-info-overlay{
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                180deg,
                rgba(10,10,10,0.35),
                rgba(10,10,10,0.82)
            );
    }

    .booking-mini-badge{
        display: inline-flex;
        align-items: center;
        padding: 10px 22px;
        border-radius: 50px;
        background: rgba(255,255,255,0.14);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
    }

    .booking-main-title{
        color: #fff;
        font-size: 42px;
        font-weight: 800;
        line-height: 1.15;
    }

    .booking-main-desc{
        color: rgba(255,255,255,0.78);
        line-height: 1.9;
        font-size: 16px;
    }

    /* ========================= */
    /* FEATURES */
    /* ========================= */

    .booking-feature-list{
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .booking-feature-item{
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .booking-feature-icon{
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: rgba(255,255,255,0.14);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 22px;
        flex-shrink: 0;
    }

    .booking-feature-item h6{
        color: #fff;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .booking-feature-item p{
        margin-bottom: 0;
        color: rgba(255,255,255,0.72);
        font-size: 14px;
        line-height: 1.7;
    }

    /* ========================= */
    /* WA BUTTON */
    /* ========================= */

    .booking-wa-btn{
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: #25d366;
        color: #fff;
        padding: 16px 28px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: 0.3s ease;
        box-shadow: 0 12px 30px rgba(37,211,102,0.3);
    }

    .booking-wa-btn:hover{
        transform: translateY(-3px);
        color: #fff;
    }

    /* ========================= */
    /* FORM */
    /* ========================= */

    .booking-form-wrapper{
        background: rgba(255,255,255,0.88);
        backdrop-filter: blur(16px);
        border-radius: 35px;
        padding: 45px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.4);
        height: 100%;
    }

    .booking-form-header{
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .booking-form-badge{
        background: rgba(29,185,84,0.12);
        color: #1db954;
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
    }

    .booking-form-title{
        margin-top: 18px;
        margin-bottom: 0;
        font-size: 34px;
        font-weight: 800;
        color: #1f1f1f;
    }

    .booking-step{
        width: 70px;
        height: 70px;
        border-radius: 24px;
        background:
            linear-gradient(
                135deg,
                #1db954,
                #63d471
            );
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        box-shadow: 0 15px 35px rgba(29,185,84,0.28);
    }

    /* ========================= */
    /* INPUT */
    /* ========================= */

    .booking-input-group label{
        font-weight: 700;
        margin-bottom: 12px;
        display: block;
        color: #333;
    }

    .booking-input-wrap{
        display: flex;
        align-items: center;
        gap: 14px;
        background: #fff;
        border-radius: 20px;
        padding: 0 20px;
        border: 1px solid rgba(0,0,0,0.08);
        transition: 0.3s ease;
        height: 62px;
    }

    .booking-input-wrap:focus-within{
        border-color: #1db954;
        box-shadow: 0 0 0 4px rgba(29,185,84,0.12);
    }

    .booking-input-wrap i{
        color: #1db954;
        font-size: 18px;
    }

    .booking-input-wrap input,
    .booking-input-wrap select{
        border: none;
        width: 100%;
        background: transparent;
        outline: none;
        font-size: 15px;
        color: #222;
    }

    /* ========================= */
    /* BUTTON SUBMIT */
    /* ========================= */

    .booking-submit-btn{
        border: none;
        background:
            linear-gradient(
                135deg,
                #1db954,
                #53d769
            );
        color: #fff;
        padding: 18px 34px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: 0.35s ease;
        box-shadow: 0 15px 35px rgba(29,185,84,0.22);
    }

    .booking-submit-btn:hover{
        transform: translateY(-4px);
    }

    /* ========================= */
    /* LOGIN BOX */
    /* ========================= */

    .booking-login-box{
        text-align: center;
        padding: 60px 30px;
        border-radius: 30px;
        background:
            linear-gradient(
                135deg,
                rgba(29,185,84,0.08),
                rgba(255,255,255,0.95)
            );
    }

    .booking-lock-icon{
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background:
            linear-gradient(
                135deg,
                #1db954,
                #53d769
            );
        color: #fff;
        font-size: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto auto 25px;
    }

    .booking-login-box h4{
        font-weight: 800;
        margin-bottom: 15px;
    }

    .booking-login-box p{
        max-width: 520px;
        margin: auto auto 30px;
        color: #666;
        line-height: 1.8;
    }

    .booking-login-btn,
    .booking-register-btn{
        padding: 14px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
        transition: 0.3s ease;
    }

    .booking-login-btn{
        background: #1db954;
        color: #fff;
    }

    .booking-register-btn{
        border: 2px solid #1db954;
        color: #1db954;
    }

    .booking-login-btn:hover,
    .booking-register-btn:hover{
        transform: translateY(-3px);
    }

    /* ========================= */
    /* RESPONSIVE */
    /* ========================= */

    @media (max-width: 992px){

        .booking-main-title{
            font-size: 34px;
        }

        .booking-form-title{
            font-size: 28px;
        }

        .booking-form-wrapper,
        .booking-info-card{
            padding: 35px;
        }

    }

    @media (max-width: 768px){

        .booking-main-title{
            font-size: 28px;
        }

        .booking-form-wrapper,
        .booking-info-card{
            padding: 28px;
            border-radius: 28px;
        }

        .booking-form-header{
            flex-direction: column;
            align-items: flex-start;
        }

        .booking-step{
            width: 60px;
            height: 60px;
            border-radius: 20px;
            font-size: 20px;
        }

        .booking-input-wrap{
            height: 58px;
        }

    }

</style>