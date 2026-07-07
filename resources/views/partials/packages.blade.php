<section id="packages" class="packages-showcase py-2">

    <!-- BACKGROUND DECOR -->
    <div class="packages-decor decor-1"></div>
    <div class="packages-decor decor-2"></div>

    <!-- HEADER -->
    <div class="packages-top text-center">

        <span class="packages-mini-badge">
            Explore Experience
        </span>

        <h2 class="packages-heading mt-4">
            Temukan Paket Wisata
            Paling Berkesan
        </h2>

        <p class="packages-text mx-auto mt-4">
            Jelajahi budaya khas Desa Sade melalui paket wisata
            modern dengan pengalaman autentik, aktivitas tradisional,
            dan perjalanan yang dirancang nyaman untuk wisatawan.
        </p>

    </div>

    <!-- PACKAGE STACK -->
    <div class="packages-stack mt-5">

        @forelse($packages as $index => $package)

            <div class="package-stack-card">

                <!-- GLOW -->
                <div class="package-glow"></div>

                <!-- NUMBER -->
                <div class="package-number">
                    0{{ $index + 1 }}
                </div>

                <!-- CONTENT -->
                <div class="package-content">

                    <div class="package-top-info">

                        <span class="package-chip">
                            Wisata Budaya
                        </span>

                        <span class="package-duration">
                            {{ $package->duration }}
                        </span>

                    </div>

                    <h3 class="package-title">
                        {{ $package->title }}
                    </h3>

                    <p class="package-description">
                        {{ $package->description }}
                    </p>

                    <!-- BOTTOM -->
                    <div class="package-bottom">

                        <div>

                            <small class="package-label">
                                Harga Mulai
                            </small>

                            <h4 class="package-price">
                                Rp{{ number_format($package->price,0,',','.') }}
                            </h4>

                        </div>

                        <a href="{{ route('packages.show', $package) }}" class="package-action">
                            <span>Detail Paket</span>



                            <svg width="18"
                                height="18"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path d="M5 12h14"></path>
                                <path d="M13 5l7 7-7 7"></path>

                            </svg>
                        </a>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-secondary rounded-4">
                Tidak ada paket wisata tersedia.
            </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-5 package-pagination">
        {{ $packages->links() }}
    </div>

</section>

<style>

    /* =========================
       SECTION
    ========================== */

    .packages-showcase {
        position: relative;
        overflow: hidden;
        padding-inline: 10px;
    }

    /* =========================
       DECORATION
    ========================== */

    .packages-decor {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: .18;
    }

    .decor-1 {
        width: 320px;
        height: 320px;
        background: #d7b899;
        top: 0;
        left: -100px;
    }

    .decor-2 {
        width: 260px;
        height: 260px;
        background: #8b5e3c;
        bottom: 0;
        right: -80px;
    }

    /* =========================
       HEADER
    ========================== */

    .packages-top {
        position: relative;
        z-index: 2;
    }

    .packages-mini-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 22px;
        border-radius: 50px;
        background: rgba(215,184,153,0.15);
        color: #8b5e3c;
        font-size: 14px;
        font-weight: 700;
        border: 1px solid rgba(215,184,153,0.25);
        letter-spacing: .5px;
    }

    .packages-heading {
        font-size: 60px;
        line-height: 1.08;
        font-weight: 900;
        color: #2d1b18;
        max-width: 850px;
        margin-inline: auto;
    }

    .packages-text {
        max-width: 760px;
        color: #6e6159;
        line-height: 2;
        font-size: 17px;
    }

    /* =========================
       STACK
    ========================== */

    .packages-stack {
        position: relative;
        z-index: 2;

        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    /* =========================
       CARD
    ========================== */

    .package-stack-card {
        position: relative;
        overflow: hidden;
        border-radius: 38px;
        padding: 35px;

        background:
            linear-gradient(
                145deg,
                rgba(255,255,255,0.98),
                rgba(249,244,240,0.96)
            );

        border: 1px solid rgba(215,184,153,0.16);

        box-shadow:
            0 20px 45px rgba(0,0,0,0.06);

        transition: .45s ease;
    }

    .package-stack-card:hover {
        transform:
            translateY(-14px)
            rotate(-1deg);

        box-shadow:
            0 35px 70px rgba(0,0,0,0.10);
    }

    /* =========================
       GLOW
    ========================== */

    .package-glow {
        position: absolute;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(215,184,153,0.22);
        top: -120px;
        right: -120px;
        filter: blur(20px);
    }

    /* =========================
       NUMBER
    ========================== */

    .package-number {
        position: absolute;
        top: 24px;
        right: 28px;

        font-size: 75px;
        font-weight: 900;
        line-height: 1;

        color: rgba(139,94,60,0.08);

        user-select: none;
    }

    /* =========================
       CONTENT
    ========================== */

    .package-content {
        position: relative;
        z-index: 2;
    }

    .package-top-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .package-chip {
        background: rgba(139,94,60,0.10);
        color: #8b5e3c;
        padding: 9px 18px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .6px;
    }

    .package-duration {
        color: #7c6d64;
        font-weight: 600;
        font-size: 14px;
    }

    .package-title {
        font-size: 34px;
        line-height: 1.2;
        font-weight: 800;
        color: #2d1b18;
        margin-bottom: 20px;
    }

    .package-description {
        color: #6f625a;
        line-height: 1.9;
        font-size: 15px;
        margin-bottom: 45px;
    }

    /* =========================
       FOOTER
    ========================== */

    .package-bottom {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 20px;
    }

    .package-label {
        color: #8a7a70;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .package-price {
        margin-top: 6px;
        margin-bottom: 0;
        font-size: 32px;
        font-weight: 900;
        color: #8b5e3c;
    }

    .package-action {
        display: inline-flex;
        align-items: center;
        gap: 10px;

        padding: 15px 24px;

        border-radius: 50px;

        background: #2d1b18;
        color: #fff;
        text-decoration: none;

        font-weight: 700;

        transition: .3s ease;
    }

    .package-action:hover {
        background: #8b5e3c;
        color: #fff;

        transform: translateX(4px);
    }

    /* =========================
       PAGINATION
    ========================== */

    .package-pagination nav {
        display: flex;
        justify-content: center;
    }

    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 992px) {

        .packages-heading {
            font-size: 46px;
        }

        .package-title {
            font-size: 28px;
        }

    }

    @media (max-width: 768px) {

        .packages-heading {
            font-size: 36px;
        }

        .packages-text {
            font-size: 15px;
            line-height: 1.8;
        }

        .package-stack-card {
            padding: 28px;
            border-radius: 28px;
        }

        .package-number {
            font-size: 55px;
        }

        .package-title {
            font-size: 24px;
        }

        .package-price {
            font-size: 24px;
        }

        .package-action {
            padding: 13px 18px;
            font-size: 14px;
        }

    }

</style>