@php
    $editableHomepage = (bool) ($editableHomepage ?? false);
    $heroContent = ($homepageByKey ?? collect())->get('hero.main');
    $heroSlides = collect($heroSlides ?? [])->filter(fn ($slide) => !empty($slide['src']))->values();

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

    $secondaryButtonLabel = data_get($heroContent?->meta, 'secondary_button_label', 'Lihat Paket');
    $secondaryButtonUrl = data_get($heroContent?->meta, 'secondary_button_url', 'route:packages.index');
@endphp

<section id="home-hero" class="hero-modern position-relative overflow-hidden{{ $editableHomepage && $heroContent ? ' homepage-editable' : '' }}">

        @if($editableHomepage && $heroContent)
            @include('admin.homepage-contents._content_actions', ['content' => $heroContent, 'label' => 'Hero Utama'])
        @endif

        <!-- BACKGROUND IMAGE -->
        <div class="hero-bg" id="heroBg"></div>

        <!-- OVERLAY -->
        <div class="hero-overlay"></div>

        <div class="container position-relative z-2">

            <div class="row align-items-center hero-content-row">

                <!-- LEFT CONTENT -->
                <div class="col-lg-5 text-white">

                    <span class="hero-badge">
                        {{ $heroContent?->subtitle ?: 'Discover Desa Sasak Sade' }}
                    </span>

                    <h1 class="hero-title">
                        {{ $heroContent?->title ?: 'Rasakan Wisata Budaya Otentik di Lombok' }}
                    </h1>

                    <p class="hero-description">
                        {{ $heroContent?->body ?: 'Nikmati pengalaman desa adat, tenun tradisional, pertunjukan budaya, dan paket wisata keluarga yang dirancang khusus untuk traveler modern.' }}
                    </p>

                    <div class="hero-actions d-flex flex-wrap gap-3">

                        <a href="{{ $resolveContentUrl($heroContent?->button_url, route('booking.index')) }}" class="btn btn-hero-primary">
                            {{ $heroContent?->button_label ?: 'Pesan Sekarang' }}
                        </a>

                        <a href="{{ $resolveContentUrl($secondaryButtonUrl, route('packages.index')) }}" class="btn btn-hero-outline">
                            {{ $secondaryButtonLabel }}
                        </a>

                    </div>

                    <!-- STATS -->
                    <div class="row g-3 hero-stats-row">

                        <div class="col-4">
                            <div class="hero-stat-card">
                                <small>Paket</small>

                                <h3>
                                    {{ $packages->count() }}
                                </h3>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="hero-stat-card">
                                <small>Event</small>

                                <h3>
                                    {{ $events->count() }}
                                </h3>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="hero-stat-card">
                                <small>Review</small>

                                <h3>
                                    {{ $reviews->count() }}
                                </h3>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-lg-7 hero-gallery-col">

                    <div class="gallery-wrapper">

                        <!-- RUNNING WORDS (above mini cards) -->
                        <div class="hero-running-words" aria-hidden="true">
                            <span class="hero-running-words__track" data-text="Selamat Datang di Website Lokal Sasak Sade" data-repeat="2"></span>
                        </div>




                        <div class="floating-gallery" id="galleryTrack">

                            @foreach($heroSlides as $index => $slide)
                                <div class="gallery-card {{ $index === 0 ? 'active-card' : ($index === 1 ? 'next-card' : 'hidden-card') }}">
                                    <img src="{{ $slide['src'] }}" alt="{{ $slide['title'] ?? 'Desa Sasak Sade' }}">
                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

</section>

<style>

/* ==========================================================
   HERO
========================================================== */

.hero-modern{

    --gallery-card-width: 6cm;
    --gallery-card-height: 4cm;
    --gallery-card-gap: 24px;
    --gallery-card-bottom: 3cm;

    /* Running text */
    --running-text-width: 12cm;
    --running-text-gap: 1cm;

    width:100%;
    height:100vh;
    height:100svh;

    position:relative;
    overflow:hidden;

    border-radius:34px;

    box-shadow:
        0 18px 50px rgba(0,0,0,.20);

}

/* ==========================================================
   BACKGROUND
========================================================== */

.hero-bg{

    position:absolute;
    inset:0;

    background-size:100% 100%;
    background-position:center;
    background-repeat:no-repeat;

    transition:
        background-image .8s ease,
        opacity .8s ease;

}

.hero-overlay{

    position:absolute;
    inset:0;

    background:

    linear-gradient(

        90deg,

        rgba(8,18,16,.90) 0%,

        rgba(8,18,16,.45) 45%,

        rgba(8,18,16,.08) 100%

    ),

    linear-gradient(

        180deg,

        rgba(0,0,0,.08) 0%,

        rgba(0,0,0,0) 45%,

        rgba(0,0,0,.28) 100%

    );

}

/* ==========================================================
   CONTENT
========================================================== */

.hero-content-row{

    height:100vh;
    height:100svh;

    min-height:0;

    padding-top:112px;
    padding-bottom:28px;

    box-sizing:border-box;

}

/* ==========================================================
   LEFT CONTENT
========================================================== */

.hero-badge{

    display:inline-flex;
    align-items:center;

    padding:10px 22px;

    border-radius:999px;

    font-size:14px;
    font-weight:600;

    color:#fff;

    background:rgba(255,255,255,.12);

    border:1px solid rgba(255,255,255,.18);

    backdrop-filter:blur(10px);

}

.hero-title{

    margin-top:22px;

    font-size:60px;
    font-weight:800;
    line-height:1.06;

    color:#fff;

}

.hero-description{

    margin-top:18px;

    max-width:520px;

    color:rgba(255,255,255,.80);

    font-size:16px;
    line-height:1.68;

}

.hero-actions{

    margin-top:24px;

    display:flex;
    flex-wrap:wrap;
    gap:16px;

}

/* ==========================================================
   BUTTON
========================================================== */

.btn-hero-primary{

    background:#d7b899;
    color:#3e2723;

    text-decoration:none;

    padding:13px 28px;

    border-radius:999px;

    font-weight:700;

    transition:.3s;

}

.btn-hero-primary:hover{

    background:#edd3b4;
    color:#2d1b18;

}

.btn-hero-outline{

    color:#fff;

    text-decoration:none;

    border:1px solid rgba(255,255,255,.30);

    padding:13px 28px;

    border-radius:999px;

    font-weight:600;

    transition:.3s;

}

.btn-hero-outline:hover{

    background:rgba(255,255,255,.12);

}

/* ==========================================================
   STATS
========================================================== */

.hero-stats-row{

    margin-top:30px;

}

.hero-stat-card{

    background:rgba(255,255,255,.10);

    border:1px solid rgba(255,255,255,.12);

    backdrop-filter:blur(10px);

    border-radius:18px;

    padding:16px;

    text-align:center;

    color:#fff;

}

.hero-stat-card small{

    color:rgba(255,255,255,.70);

    font-size:12px;

    letter-spacing:1px;

    text-transform:uppercase;

}

.hero-stat-card h3{

    margin-top:8px;
    margin-bottom:0;

    font-size:27px;

    font-weight:700;

}

/* ==========================================================
   GALLERY WRAPPER
========================================================== */

.hero-gallery-col{

    position:relative;

    align-self:stretch;

}

.gallery-wrapper{

    position:relative;

    width:100%;
    height:100%;

    overflow:visible;

}

.floating-gallery{

    position:relative;

    width:100%;
    height:100%;

}

/* ==========================================================
   RUNNING WORDS
========================================================== */

.hero-running-words{

    position:absolute;

    width:var(--running-text-width);

    height:46px;

    left:0;

    transition:left .8s ease;

    /* geser lagi ke kanan ~5cm sesuai koreksi terbaru */
    left:7cm !important;





    bottom:calc(

        var(--gallery-card-bottom)
        + var(--gallery-card-height)
        + var(--running-text-gap)
    );

    display:flex;

    align-items:center;

    overflow:hidden;

    z-index:20;

    pointer-events:none;

}

    .hero-running-words__track{

    display:inline-flex;
    align-items:center;

    white-space:nowrap;

    font-size:20px;
    font-weight:500;

    line-height:1;

    color:rgba(255,255,255,.95);

    text-shadow:
        0 8px 20px rgba(0,0,0,.35);

    animation:
        heroMarquee 12s linear infinite;

}

.hero-running-word{

    display:inline-block;

    margin-right:.45ch;

    animation:
        heroWordRotate
        1.6s ease-in-out infinite;

}

@keyframes heroMarquee{

    from{

        transform:translateX(100%);

    }

    to{

        transform:translateX(-100%);

    }

}

@keyframes heroWordRotate{

    0%{

        transform:rotate(0deg);

    }

    50%{

        transform:rotate(7deg);

    }

    100%{

        transform:rotate(0deg);

    }

}

.hero-running-words--paused
.hero-running-word{

    animation-play-state:paused;

}

@media(prefers-reduced-motion:reduce){

    .hero-running-words__track{

        animation:none;

    }

    .hero-running-word{

        animation:none;

    }

}


/* ==========================================================
   GALLERY
========================================================== */

.gallery-card{

    position:absolute;

    right:0;

    bottom:var(--gallery-card-bottom);

    width:var(--gallery-card-width);
    height:var(--gallery-card-height);

    overflow:hidden;

    border-radius:22px;

    background:#fff;

    border:4px solid rgba(255,255,255,.18);

    box-shadow:
        0 18px 35px rgba(0,0,0,.28);

    transition:
        transform .8s ease,
        right .8s ease,
        opacity .8s ease;

}

.gallery-card img{

    width:100%;
    height:100%;

    display:block;

    object-fit:cover;

}


/* ==========================================================
   CARD POSITION
========================================================== */

.active-card{

    right:calc(
        var(--gallery-card-width)
        + var(--gallery-card-gap)
    );

    z-index:3;

    opacity:1;

    transform:
        scale(1);

}

.next-card{

    right:0;

    z-index:2;

    opacity:1;

    transform:
        scale(1);

}

.hidden-card{

    right:calc(

        (
            var(--gallery-card-width)
            + var(--gallery-card-gap)
        )

        * -1

    );

    opacity:0;

    z-index:1;

    transform:
        scale(.86);

}

/* ==========================================================
   RESPONSIVE
========================================================== */

@media (max-width:1400px){

    .hero-content-row{

        padding-top:104px;
        padding-bottom:24px;

    }

    .hero-title{

        font-size:56px;

    }

    .hero-stats-row{

        margin-top:26px;

    }

}


@media (max-width:1320px) and (min-width:993px){

    .hero-content-row{

        padding-top:132px;

    }

    .hero-title{

        font-size:50px;

    }

    .hero-description{

        font-size:15px;
        line-height:1.62;

    }

    .hero-stat-card{

        padding:14px 12px;

    }

    .hero-stat-card h3{

        font-size:24px;

    }

}


@media (max-height:740px) and (min-width:993px){

    .hero-content-row{

        padding-top:96px;
        padding-bottom:18px;

    }

    .hero-badge{

        padding:8px 18px;
        font-size:13px;

    }

    .hero-title{

        margin-top:18px;

        font-size:50px;

    }

    .hero-description{

        margin-top:14px;

        font-size:15px;

    }

    .hero-actions{

        margin-top:18px;

    }

    .btn-hero-primary,
    .btn-hero-outline{

        padding:11px 24px;

    }

    .hero-stat-card{

        padding:12px 10px;

    }

    .hero-stat-card h3{

        font-size:23px;

    }

}


@media (max-width:992px){

    .hero-modern{

        --gallery-card-width:min(6cm,42vw);
        --gallery-card-height:min(4cm,58vw);
        --gallery-card-gap:14px;
        --gallery-card-bottom:0;

        --running-text-width:90%;

        height:auto;
        min-height:100svh;

        border-radius:0 0 28px 28px;

    }

    .hero-gallery-col{

        align-self:auto;

    }

    .hero-content-row{

        height:auto;
        min-height:100svh;

        padding-top:150px;
        padding-bottom:48px;

    }

    .hero-title{

        font-size:40px;

    }

    .gallery-wrapper{

        margin-top:50px;

        height:calc(
            var(--gallery-card-height)
            + 40px
        );

    }

    .hero-running-words{

        width:90%;

        left:5% !important;

        bottom:calc(
            var(--gallery-card-height)
            + .8cm
        );

    }

    .hero-running-words__track{

        font-size:22px;

    }

}


@media (max-width:768px){

    .hero-modern{

        border-radius:0 0 24px 24px;

    }

    .hero-content-row{

        padding-top:168px;

    }

    .hero-title{

        font-size:34px;

    }

    .hero-description{

        font-size:15px;

    }

    .gallery-wrapper{

        height:calc(
            var(--gallery-card-height)
            + 20px
        );

    }

    .hero-running-words{

        width:100%;

        left:0 !important;

    }

    .hero-running-words__track{

        font-size:18px;

    }

}

</style>

<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ===========================================
       RUNNING WORDS
    =========================================== */

    document.querySelectorAll(".hero-running-words__track").forEach(track => {

        const text = track.dataset.text || "";

        const words = text.trim().split(/\s+/).filter(Boolean);

        if(!words.length) return;

        track.innerHTML = words
            .map((word,index)=>{

                return `
                    <span
                        class="hero-running-word"
                        style="animation-delay:${index*0.18}s">
                        ${word}
                    </span>
                `;

            })
            .join("");

    });




    /* ===========================================
       ELEMENT
    =========================================== */

    const cards = document.querySelectorAll(".gallery-card");

    const heroBg = document.getElementById("heroBg");

    const runningWords =
        document.querySelector(".hero-running-words");

    const galleryWrapper =
        document.querySelector(".gallery-wrapper");

    let currentIndex = 0;




    /* ===========================================
       UPDATE RUNNING WORD POSITION
    =========================================== */

    function updateRunningWords(){

        if(!runningWords) return;

        const activeCard =
            document.querySelector(".gallery-card.active-card");

        if(!activeCard) return;

        const wrapper =
            galleryWrapper.getBoundingClientRect();

        const card =
            activeCard.getBoundingClientRect();

        const left =
            card.left - wrapper.left;

        runningWords.style.left = left + "px";

    }




    /* ===========================================
       UPDATE GALLERY
    =========================================== */

    function updateGallery(){

        if(!cards.length || !heroBg){

            return;

        }

        const total = cards.length;

        const first =
            currentIndex % total;

        const second =
            (currentIndex + 1) % total;



        cards.forEach(card=>{

            card.classList.remove(

                "active-card",
                "next-card",
                "hidden-card"

            );

        });



        cards[first]
            .classList
            .add("active-card");



        if(total>1){

            cards[second]
                .classList
                .add("next-card");

        }



        for(let i=0;i<total;i++){

            if(

                i!==first &&

                (
                    total===1
                    ||
                    i!==second
                )

            ){

                cards[i]
                    .classList
                    .add("hidden-card");

            }

        }



        const image =

            cards[first]

            .querySelector("img")

            ?.src;



        if(image){

            heroBg.style.backgroundImage =
                `url('${image}')`;

            heroBg.style.opacity = "1";

        }



        /* ==========================
           POSISI RUNNING WORDS
        ========================== */

        updateRunningWords();



        currentIndex++;

    }




    /* ===========================================
       INIT
    =========================================== */

    updateGallery();



    setInterval(function(){

        updateGallery();

    },3000);



    window.addEventListener(

        "resize",

        function(){

            updateRunningWords();

        }

    );

});

</script>