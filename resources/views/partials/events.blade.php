<section id="events" class="events-section py-3">

    <!-- CONTAINER GLASS -->
    <div class="events-glass-wrapper">

        <!-- HEADER -->
        <div class="events-header mb-5">

            <div>
                <span class="events-mini-title">
                    Festival & Tradisi Desa
                </span>

                <h2 class="events-main-title">
                    Rasakan Atmosfer Event Budaya yang Tidak Terlupakan
                </h2>
            </div>

            <p class="events-description">
                Saksikan tradisi khas masyarakat Sasak, pertunjukan budaya,
                musik tradisional, hingga aktivitas desa yang hanya bisa
                Anda temukan di Desa Sade Lombok.
            </p>

        </div>

        <!-- GRID EVENT -->
        <div class="events-grid">

            @forelse($events as $event)

                <a href="{{ route('events.show', $event) }}"
                   class="event-card-modern text-decoration-none">

                    <!-- IMAGE -->
                    <div class="event-image-wrapper">

                        @if($event->image_path)

                            <img src="{{ Storage::url($event->image_path) }}"
                                 alt="{{ $event->name }}"
                                 class="event-image">



                        @else

                            <div class="event-placeholder">
                                <i class="bi bi-image"></i>
                            </div>

                        @endif

                        <!-- OVERLAY -->
                        <div class="event-overlay"></div>

                        <!-- DATE -->
                        <div class="event-date-box">

                            <span class="event-date-day">
                                {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d') }}
                            </span>

                            <small>
                                {{ \Carbon\Carbon::parse($event->date)->translatedFormat('M') }}
                            </small>

                        </div>

                        <!-- BADGE -->
                        <div class="event-floating-badge">
                            {{ $event->status_label }}
                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="event-content">

                        <h3 class="event-title">
                            {{ $event->name }}
                        </h3>

                        <div class="event-meta">

                            <span>
                                <i class="bi bi-calendar-event"></i>
                                {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}
                            </span>

                            @if($event->tourGuide)

                                <span>
                                    <i class="bi bi-person-circle"></i>
                                    {{ $event->tourGuide->name }}
                                </span>

                            @endif

                        </div>

                        <p class="event-text">
                            {{ strlen($event->description ?? '') > 110
                                ? substr($event->description, 0, 110) . '...'
                                : ($event->description ?? 'Nikmati pengalaman budaya khas Desa Sade bersama masyarakat lokal.') }}
                        </p>

                        <!-- FOOTER -->
                        <div class="event-footer">

                            @if($event->reviews->count() > 0)

                                <div class="event-rating">

                                    <i class="bi bi-star-fill"></i>

                                    {{ number_format($event->averageRating(), 1) }}

                                </div>

                            @else

                                <div class="event-rating empty-rating">
                                    Belum ada rating
                                </div>

                            @endif

                            <div class="event-button">

                                Detail

                                <i class="bi bi-arrow-right-short"></i>

                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="col-12">

                    <div class="alert alert-secondary rounded-4 border-0 shadow-sm">
                        Belum ada event budaya tersedia saat ini.
                    </div>

                </div>

            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="events-pagination mt-5">
            {{ $events->links() }}
        </div>

    </div>

</section>

<style>

    /* =========================
       SECTION
    ========================== */

    .events-section {
        position: relative;
    }

    /* =========================
       GLASS CONTAINER
    ========================== */

    .events-glass-wrapper {
    background: rgba(90, 90, 90, 0.32);
    border: 1px solid rgba(255,255,255,0.12);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-radius: 40px;
    padding: 50px;
    overflow: hidden;
    position: relative;
    box-shadow:
        0 20px 50px rgba(0,0,0,0.12);
}

.events-glass-wrapper::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(
            135deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.01)
        );
    pointer-events: none;
    }

    /* =========================
       HEADER
    ========================== */

    .events-header {
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 40px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }

    .events-mini-title {
        display: inline-block;
        padding: 10px 22px;
        border-radius: 50px;
        background: rgba(123,82,55,0.08);
        color: #7b5237;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 18px;
    }

    .events-main-title {
        font-size: 48px;
        line-height: 1.15;
        font-weight: 800;
        color: #1f1f1f;
        max-width: 760px;
        margin: 0;
    }

    .events-description {
        max-width: 420px;
        font-size: 15px;
        line-height: 1.8;
        color: #666;
        margin: 0;
    }

    /* =========================
       GRID
    ========================== */

    .events-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        position: relative;
        z-index: 2;
    }

    /* =========================
       CARD
    ========================== */

    .event-card-modern {
        background: rgba(255,255,255,0.85);
        border-radius: 32px;
        overflow: hidden;
        position: relative;
        transition: 0.45s ease;
        box-shadow:
            0 10px 30px rgba(0,0,0,0.05);
    }

    .event-card-modern:hover {
        transform: translateY(-12px);
        box-shadow:
            0 25px 60px rgba(0,0,0,0.18);
    }

    /* =========================
       IMAGE
    ========================== */

    .event-image-wrapper {
        position: relative;
        height: 300px;
        overflow: hidden;
    }

    .event-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .event-card-modern:hover .event-image {
        transform: scale(1.08);
    }

    .event-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                to top,
                rgba(0,0,0,0.7),
                rgba(0,0,0,0.08)
            );
    }

    /* =========================
       DATE
    ========================== */

    .event-date-box {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 74px;
        height: 82px;
        background: rgba(255,255,255,0.9);
        border-radius: 22px;
        backdrop-filter: blur(12px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .event-date-day {
        font-size: 30px;
        font-weight: 800;
        line-height: 1;
        color: #222;
    }

    .event-date-box small {
        color: #666;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* =========================
       BADGE
    ========================== */

    .event-floating-badge {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background: rgba(255,255,255,0.14);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }

    /* =========================
       CONTENT
    ========================== */

    .event-content {
        padding: 28px;
    }

    .event-title {
        font-size: 24px;
        font-weight: 800;
        color: #222;
        margin-bottom: 18px;
        line-height: 1.3;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 18px;
    }

    .event-meta span {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #777;
        font-size: 14px;
    }

    .event-meta i {
        color: #8a5a3a;
    }

    .event-text {
        color: #666;
        line-height: 1.8;
        font-size: 15px;
        margin-bottom: 26px;
    }

    /* =========================
       FOOTER
    ========================== */

    .event-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .event-rating {
        background: #fff3da;
        color: #cf8b00;
        padding: 10px 16px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .empty-rating {
        background: #f1f1f1;
        color: #777;
    }

    .event-button {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #7b5237;
        transition: 0.3s ease;
    }

    .event-card-modern:hover .event-button {
        gap: 14px;
    }

    /* =========================
       PAGINATION
    ========================== */

    .events-pagination {
        position: relative;
        z-index: 2;
    }

    .events-pagination nav {
        display: flex;
        justify-content: center;
    }

    .events-pagination .pagination {
        gap: 12px;
    }

    .events-pagination .page-link {
        border: none;
        width: 48px;
        height: 48px;
        border-radius: 50% !important;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.8);
        color: #444;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .events-pagination .active .page-link {
        background: #7b5237;
        color: #fff;
    }

    /* =========================
       RESPONSIVE
    ========================== */

    @media (max-width: 1200px) {

        .events-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 768px) {

        .events-glass-wrapper {
            padding: 28px;
            border-radius: 28px;
        }

        .events-main-title {
            font-size: 34px;
        }

        .events-grid {
            grid-template-columns: 1fr;
        }

        .event-image-wrapper {
            height: 240px;
        }

        .event-content {
            padding: 22px;
        }

        .event-title {
            font-size: 21px;
        }

    }

</style>
