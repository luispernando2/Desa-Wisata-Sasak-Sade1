@php
    $aboutContent = ($homepageByKey ?? collect())->get('about.main');
    $aboutHighlights = (($homepageGroups ?? collect())->get('about_highlight') ?? collect())->sortBy('sort_order')->values();

    $assetFromValue = function (?string $value) {
        if (blank($value)) {
            return null;
        }

        if (preg_match('#^(https?:)?//#', $value)) {
            return $value;
        }

        $path = ltrim($value, '/');

        return str_starts_with($path, 'images/') ? asset($path) : asset('storage/' . $path);
    };
@endphp

<section id="about" class="about-modern-section py-5 overflow-hidden">

    <!-- BACKGROUND GLOW -->
    <div class="about-bg-glow"></div>

    <div class="row align-items-center gy-5">

        <!-- LEFT IMAGE AREA -->
        <div class="col-lg-6">

            <div class="about-image-layout">

                <!-- IMAGE BESAR -->
                <div class="about-main-image">
                    <img src="{{ $aboutContent?->image_src ?: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBLgkTNqCpr5HWKXGakrULdZJtnET4ZGEEGA&s' }}"
                        alt="{{ $aboutContent?->title ?: 'Village' }}">
                </div>

                <!-- FLOATING INFO CARD -->
                <div class="about-floating-card">

                    <span class="mini-badge">
                        {{ $aboutContent?->subtitle ?: 'Desa Wisata Tradisional' }}
                    </span>

                    <h4>
                        {{ data_get($aboutContent?->meta, 'card_title', $village['name'] ?? 'Desa Sasak Sade') }}
                    </h4>

                    <p>
                        {{ data_get($aboutContent?->meta, 'card_body', 'Menjaga budaya leluhur Lombok melalui rumah adat, tenun tradisional, dan kehidupan masyarakat asli Sasak.') }}
                    </p>

                </div>

                <!-- SMALL IMAGE -->
                <div class="about-small-image">
                    <img src="{{ $assetFromValue(data_get($aboutContent?->meta, 'secondary_image_url')) ?: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRn-8SJ_7X4l3j95nDfj5XUagZj1vLtz5pz8A&s' }}"
                        alt="Culture">
                </div>

                <!-- EXPERIENCE BOX -->
                <div class="about-experience-box">

                    <h2>{{ data_get($aboutContent?->meta, 'experience_number', '20+') }}</h2>

                    <span>
                        {{ data_get($aboutContent?->meta, 'experience_text', 'Tahun menjaga budaya & tradisi Lombok') }}
                    </span>

                </div>

            </div>

        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-lg-6">

            <div class="about-content-wrapper">

                <span class="section-title">
                    {{ data_get($aboutContent?->meta, 'section_kicker', 'Tentang Desa') }}
                </span>

                <h2 class="about-title mt-3">
                    {{ $aboutContent?->title ?: 'Rasakan Nuansa Budaya Sasak yang Masih Asli' }}
                </h2>

                <p class="about-description mt-4">
                    {{ $aboutContent?->body ?: $village['description'] }}
                </p>

                <!-- HIGHLIGHT -->
                <div class="about-highlight-grid mt-5">

                    @forelse($aboutHighlights as $highlight)

                        <div class="about-highlight-item">

                            <div class="highlight-icon">
                                <i class="bi {{ $highlight->icon ?: 'bi-stars' }}"></i>
                            </div>

                            <div>
                                <h5>
                                    {{ $highlight->title }}
                                </h5>

                                <p>
                                    {{ $highlight->body ?: 'Nikmati pengalaman budaya autentik khas Lombok.' }}
                                </p>
                            </div>

                        </div>

                    @empty
                        @foreach($village['highlights'] as $highlight)

                            <div class="about-highlight-item">

                                <div class="highlight-icon">
                                    <i class="bi bi-stars"></i>
                                </div>

                                <div>
                                    <h5>
                                        {{ $highlight }}
                                    </h5>

                                    <p>
                                        Nikmati pengalaman budaya autentik khas Lombok.
                                    </p>
                                </div>

                            </div>

                        @endforeach
                    @endforelse

                </div>

            </div>

        </div>

    </div>

</section>

<style>

    /* ========================= */
    /* ABOUT SECTION */
    /* ========================= */

    .about-modern-section{
        position: relative;
        z-index: 1;
    }

    .about-bg-glow{
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
        top: -150px;
        left: -150px;
        filter: blur(60px);
        z-index: -1;
    }

    /* ========================= */
    /* IMAGE LAYOUT */
    /* ========================= */

    .about-image-layout{
        position: relative;
        min-height: 720px;
        padding-top: 20px;
    }

    /* IMAGE BESAR */

    .about-main-image{
        width: 72%;
        height: 520px;
        overflow: hidden;
        border-radius: 38px;
        box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        position: relative;
        z-index: 1;
    }

    .about-main-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.6s ease;
    }

    .about-main-image:hover img{
        transform: scale(1.05);
    }

    /* FLOAT CARD */

    .about-floating-card{
        position: absolute;
        top: 60px;
        right: 0;
        width: 300px;
        background: rgba(32,32,32,0.88);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 30px;
        border-radius: 30px;
        color: yellow;
        box-shadow: 0 20px 45px rgba(0,0,0,0.25);
        z-index: 3;
    }

    .mini-badge{
        display: inline-flex;
        align-items: center;
        background: rgba(255,255,255,0.10);
        border: 1px solid rgba(255,255,255,0.10);
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        margin-bottom: 18px;
    }

    .about-floating-card h4{
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .about-floating-card p{
        color: rgba(255,255,255,0.72);
        line-height: 1.8;
        margin-bottom: 0;
        font-size: 15px;
    }

    /* SMALL IMAGE */

    .about-small-image{
        position: absolute;
        right: 40px;
        bottom: 120px;
        width: 240px;
        height: 290px;
        border-radius: 30px;
        overflow: hidden;
        border: 8px solid rgba(255,255,255,0.72);
        box-shadow: 0 20px 45px rgba(0,0,0,0.28);
        z-index: 2;
    }

    .about-small-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* EXPERIENCE BOX */

    .about-experience-box{
        position: absolute;
        left: 40px;
        bottom: 10px;
        background: linear-gradient(
            135deg,
            #d6b08a,
            #f2d1a7
        );
        width: 230px;
        height: 180px;
        border-radius: 35px;
        padding: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 4;
    }

    .about-experience-box h2{
        font-size: 58px;
        font-weight: 900;
        color: #2d1b18;
        line-height: 1;
        margin-bottom: 12px;
    }

    .about-experience-box span{
        color: #4d342f;
        font-weight: 600;
        line-height: 1.6;
    }

    /* ========================= */
    /* CONTENT */
    /* ========================= */

    .about-content-wrapper{
        padding-left: 40px;
    }

    .about-title{
        font-size: 56px;
        font-weight: 900;
        line-height: 1.1;
        color: #d6b08a;
        max-width: 650px;
    }

    .about-title span{
        color: #d6b08a;
    }

    .about-description{
        color: rgb(0, 0, 0);
        line-height: 2;
        font-size: 17px;
        max-width: 600px;
    }

    /* HIGHLIGHT */

    .about-highlight-grid{
        display: grid;
        grid-template-columns: repeat(2,1fr);
        gap: 24px;
    }

    .about-highlight-item{
        display: flex;
        align-items: flex-start;
        gap: 18px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 22px;
        transition: 0.4s ease;
    }

    .about-highlight-item:hover{
        transform: translateY(-6px);
        background: rgba(255,255,255,0.08);
    }

    .highlight-icon{
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(
            135deg,
            #d6b08a,
            #f0cfaa
        );
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3e2723;
        font-size: 24px;
        flex-shrink: 0;
    }

    .about-highlight-item h5{
        color: #d6b08a;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .about-highlight-item p{
        color: rgba(0, 0, 0, 0.65);
        margin-bottom: 0;
        line-height: 1.7;
        font-size: 14px;
    }

    /* ========================= */
    /* RESPONSIVE */
    /* ========================= */

    @media(max-width: 1200px){

        .about-main-image{
            width: 68%;
        }

        .about-floating-card{
            width: 270px;
        }

        .about-title{
            font-size: 48px;
        }

        .about-content-wrapper{
            padding-left: 10px;
        }

    }

    @media(max-width: 992px){

        .about-image-layout{
            min-height: 650px;
        }

        .about-main-image{
            width: 100%;
            height: 450px;
        }

        .about-floating-card{
            top: 20px;
            right: 20px;
            width: 240px;
            padding: 22px;
        }

        .about-small-image{
            right: 20px;
            bottom: 120px;
            width: 180px;
            height: 220px;
        }

        .about-experience-box{
            left: 20px;
            width: 190px;
            height: 150px;
            padding: 22px;
        }

        .about-experience-box h2{
            font-size: 44px;
        }

        .about-title{
            font-size: 42px;
        }

        .about-content-wrapper{
            padding-left: 0;
        }

    }

    @media(max-width: 768px){

        .about-image-layout{
            min-height: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .about-main-image{
            width: 100%;
            height: 350px;
        }

        .about-floating-card,
        .about-small-image,
        .about-experience-box{
            position: relative;
            top: auto;
            right: auto;
            left: auto;
            bottom: auto;
            width: 100%;
        }

        .about-small-image{
            height: 260px;
        }

        .about-experience-box{
            height: auto;
        }

        .about-title{
            font-size: 34px;
        }

        .about-highlight-grid{
            grid-template-columns: 1fr;
        }

    }

</style>
