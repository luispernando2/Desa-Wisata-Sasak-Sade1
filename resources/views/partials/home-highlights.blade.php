@php
    $editableHomepage = (bool) ($editableHomepage ?? false);
    $homeByKey = $homepageByKey ?? collect();
    $homeGroups = $homepageGroups ?? collect();

    $localImages = [
        asset('images/sade1.png'),
        asset('images/sade2.png'),
        asset('images/sade3.png'),
        asset('images/sade4.png'),
    ];

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

    $assetFromValue = function (?string $value) {
        if (blank($value)) {
            return null;
        }

        if (preg_match('#^(https?:)?//#', $value)) {
            return $value;
        }

        $path = ltrim($value, '/');

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    };

    $imageFor = function ($item, int $fallbackIndex = 0) use ($localImages, $assetFromValue) {
        if ($item && !empty($item->image_url)) {
            return $assetFromValue($item->image_url);
        }

        if ($item && !empty($item->image_path)) {
            return asset('storage/' . $item->image_path);
        }

        return $localImages[$fallbackIndex % count($localImages)];
    };

    $content = fn (string $key) => $homeByKey->get($key);
    $group = fn (string $name) => ($homeGroups->get($name) ?? collect())->sortBy('sort_order')->values();

    $contentImage = fn ($item, string $fallback) => $item?->image_src ?: $fallback;
    $metaImage = fn ($item, string $key, string $fallback) => $assetFromValue(data_get($item?->meta, $key)) ?: $fallback;

    $introContent = $content('home.intro');
    $cultureContent = $content('home.culture');
    $journeyContent = $content('home.journey');
    $packagesContent = $content('home.packages.preview');
    $eventsContent = $content('home.events.preview');
    $marketContent = $content('home.market.preview');
    $galleryContent = $content('home.gallery.preview');
    $reviewsContent = $content('home.reviews.preview');
    $ctaContent = $content('home.final_cta');

    $menuMetrics = [
        'home.menu.packages' => $packages->count(),
        'home.menu.events' => $events->count(),
        'home.menu.market' => $products->count(),
        'home.menu.gallery' => $galleries->count(),
    ];

    $menuCards = $group('home_menu')->map(function ($item) use ($resolveContentUrl, $menuMetrics) {
        $metric = array_key_exists($item->key, $menuMetrics)
            ? $menuMetrics[$item->key] . ' ' . ($item->subtitle ?: 'item')
            : $item->subtitle;

        return [
            'content' => $item,
            'title' => $item->title,
            'text' => $item->body,
            'route' => $resolveContentUrl($item->button_url),
            'icon' => $item->icon ?: 'bi-circle',
            'meta' => $metric,
        ];
    });

    if ($menuCards->isEmpty()) {
        $menuCards = collect([
            ['content' => null, 'title' => 'Paket Wisata', 'text' => 'Pilih pengalaman desa adat, tenun, kuliner, dan tur budaya.', 'route' => route('packages.index'), 'icon' => 'bi-map', 'meta' => $packages->count() . ' paket'],
            ['content' => null, 'title' => 'Event Budaya', 'text' => 'Lihat jadwal pertunjukan, aktivitas desa, dan agenda tradisi.', 'route' => route('events.index'), 'icon' => 'bi-calendar-event', 'meta' => $events->count() . ' event'],
            ['content' => null, 'title' => 'Sade Mart', 'text' => 'Temukan tenun, kerajinan, dan oleh-oleh khas Sasak Sade.', 'route' => route('market.index'), 'icon' => 'bi-bag-heart', 'meta' => $products->count() . ' produk'],
            ['content' => null, 'title' => 'Galeri', 'text' => 'Intip suasana rumah adat, aktivitas warga, dan momen wisata.', 'route' => route('gallery.index'), 'icon' => 'bi-images', 'meta' => $galleries->count() . ' foto'],
        ]);
    }

    $cultureItems = $group('home_culture_item')->map(fn ($item) => [
        'content' => $item,
        'icon' => $item->icon ?: 'bi-stars',
        'text' => $item->body ?: $item->title,
    ]);

    if ($cultureItems->isEmpty()) {
        $cultureItems = collect([
            ['content' => null, 'icon' => 'bi-house-heart', 'text' => 'Rumah adat dengan cerita ruang dan filosofi keluarga.'],
            ['content' => null, 'icon' => 'bi-flower1', 'text' => 'Tenun tradisional sebagai identitas dan karya warga lokal.'],
            ['content' => null, 'icon' => 'bi-people', 'text' => 'Interaksi langsung bersama masyarakat desa yang ramah.'],
            ['content' => null, 'icon' => 'bi-camera', 'text' => 'Sudut foto alami dari lanskap desa, rumah adat, dan aktivitas budaya.'],
        ]);
    }

    $journeySteps = $group('home_journey_step')->map(fn ($item, $index) => [
        'content' => $item,
        'time' => $item->subtitle ?: str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
        'title' => $item->title,
        'text' => $item->body,
    ]);

    if ($journeySteps->isEmpty()) {
        $journeySteps = collect([
            ['content' => null, 'time' => '01', 'title' => 'Disambut di desa', 'text' => 'Mulai dari orientasi singkat tentang adat dan tata cara berkunjung.'],
            ['content' => null, 'time' => '02', 'title' => 'Jelajah rumah adat', 'text' => 'Mengenal bentuk rumah, ruang keluarga, dan filosofi bangunan Sasak.'],
            ['content' => null, 'time' => '03', 'title' => 'Tenun dan produk lokal', 'text' => 'Melihat proses tenun, memilih karya warga, dan membawa cerita pulang.'],
        ]);
    }

    $customBlocks = $group('home_custom');

    $featuredPackages = $packages->take(3);
    $featuredEvents = $events->take(2);
    $featuredProducts = $products->take(3);
    $featuredReviews = $reviews->take(2);
    $galleryPreview = $galleries->take(4);
    $averageRating = $reviews->count() ? number_format($reviews->avg('rating'), 1) : '5.0';
@endphp

<section id="home-highlights" class="home-highlights">
    <div class="home-menu-band">
        <div class="container">
            <div class="home-menu-grid">
                @foreach($menuCards as $card)
                    @if($editableHomepage && $card['content'])
                        <div class="homepage-editable homepage-editable-menu-card">
                            @include('admin.homepage-contents._content_actions', ['content' => $card['content'], 'label' => 'Menu Beranda'])
                    @endif
                    <a href="{{ $card['route'] }}" class="home-menu-card">
                        <span class="menu-icon">
                            <i class="bi {{ $card['icon'] }}" aria-hidden="true"></i>
                        </span>
                        <span class="menu-copy">
                            <strong>{{ $card['title'] }}</strong>
                            <small>{{ $card['text'] }}</small>
                        </span>
                        <span class="menu-meta">{{ $card['meta'] }}</span>
                    </a>
                    @if($editableHomepage && $card['content'])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="container">
        <div class="home-intro-grid{{ $editableHomepage && $introContent ? ' homepage-editable' : '' }}">
            @if($editableHomepage && $introContent)
                @include('admin.homepage-contents._content_actions', ['content' => $introContent, 'label' => 'Intro Beranda'])
            @endif

            <div class="intro-copy">
                <span class="section-kicker">{{ $introContent?->subtitle ?: 'Beranda Sasak Sade' }}</span>
                <h2 class="section-title-large">{{ $introContent?->title ?: 'Satu halaman untuk mulai mengenal budaya, memilih pengalaman, dan merencanakan kunjungan.' }}</h2>
                <p class="section-lead">
                    {{ data_get($introContent?->meta, 'intro.lead')
                        ?: $introContent?->body
                        ?: 'Sasak Sade bukan sekadar destinasi. Di sini, rumah adat, tenun, keramahan warga, dan cerita turun-temurun hadir sebagai pengalaman yang bisa Anda rasakan langsung.' }}
                </p>

                <div class="intro-actions">
                    <a href="{{ $resolveContentUrl($introContent?->button_url, route('booking.index')) }}" class="home-btn primary">
                        <i class="bi bi-ticket-perforated" aria-hidden="true"></i>
                        {{ $introContent?->button_label ?: 'Booking Kunjungan' }}
                    </a>
                    <a href="{{ $resolveContentUrl(data_get($introContent?->meta, 'secondary_button_url'), route('about')) }}" class="home-btn secondary">
                        <i class="bi bi-info-circle" aria-hidden="true"></i>
                        {{ data_get($introContent?->meta, 'secondary_button_label', 'Kenali Desa') }}
                    </a>
                </div>
            </div>

            <div class="intro-media">
                <img src="{{ $contentImage($introContent, asset('images/sade1.png')) }}" alt="{{ $introContent?->title ?: 'Suasana Desa Sasak Sade' }}" loading="lazy">
                <div class="intro-stat-panel">
                    <div>
                        <strong>{{ $packages->count() }}</strong>
                        <span>Paket</span>
                    </div>
                    <div>
                        <strong>{{ $events->count() }}</strong>
                        <span>Event</span>
                    </div>
                    <div>
                        <strong>{{ $averageRating }}</strong>
                        <span>Rating</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="culture-row{{ $editableHomepage && $cultureContent ? ' homepage-editable' : '' }}">
            @if($editableHomepage && $cultureContent)
                @include('admin.homepage-contents._content_actions', ['content' => $cultureContent, 'label' => 'Panel Budaya'])
            @endif

            <div class="culture-image-stack">
                <img src="{{ $contentImage($cultureContent, asset('images/sade2.png')) }}" alt="{{ $cultureContent?->title ?: 'Rumah adat Sasak Sade' }}" loading="lazy">
                <img src="{{ $metaImage($cultureContent, 'secondary_image_url', asset('images/sade3.png')) }}" alt="Aktivitas budaya di Sasak Sade" loading="lazy">
            </div>

            <div class="culture-panel">
                <span class="section-kicker">{{ $cultureContent?->subtitle ?: 'Yang Bisa Anda Rasakan' }}</span>
                <h3>{{ $cultureContent?->title ?: 'Budaya yang masih hidup dalam keseharian.' }}</h3>
                <div class="culture-list">
                    @foreach($cultureItems as $item)
                        <div class="{{ $editableHomepage && $item['content'] ? 'homepage-editable' : '' }}">
                            @if($editableHomepage && $item['content'])
                                @include('admin.homepage-contents._content_actions', ['content' => $item['content'], 'label' => 'Item Budaya'])
                            @endif
                            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                            <span>{{ $item['text'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="section-heading-row{{ $editableHomepage && $journeyContent ? ' homepage-editable' : '' }}">
            @if($editableHomepage && $journeyContent)
                @include('admin.homepage-contents._content_actions', ['content' => $journeyContent, 'label' => 'Judul Rute'])
            @endif

            <div>
                <span class="section-kicker">{{ $journeyContent?->subtitle ?: 'Rute Pengalaman' }}</span>
                <h2 class="section-title-medium">{{ $journeyContent?->title ?: 'Alur kunjungan yang nyaman untuk wisatawan.' }}</h2>
            </div>
            <a href="{{ $resolveContentUrl($journeyContent?->button_url, route('packages.index')) }}" class="section-link">
                {{ $journeyContent?->button_label ?: 'Lihat semua paket' }}
                <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="journey-grid">
            @foreach($journeySteps as $step)
                <div class="journey-card{{ $editableHomepage && $step['content'] ? ' homepage-editable' : '' }}">
                    @if($editableHomepage && $step['content'])
                        @include('admin.homepage-contents._content_actions', ['content' => $step['content'], 'label' => 'Langkah Rute'])
                    @endif
                    <span>{{ $step['time'] }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Scroll Zoom Gallery Section -->
        <div class="scroll-zoom-gallery-wrapper">
            <div class="scroll-zoom-gallery">
                <div class="scroll-zoom-item">
                    <img src="{{ asset('images/sade9.png') }}" alt="Sade 7 - Momen Desa Sasak Sade" loading="lazy">
                </div>
            </div>
        </div>

        <div class="showcase-grid">
            <div class="showcase-main{{ $editableHomepage && $packagesContent ? ' homepage-editable' : '' }}">
                @if($editableHomepage && $packagesContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $packagesContent, 'label' => 'Preview Paket'])
                @endif

                <div class="section-heading-row compact">
                    <div>
                        <span class="section-kicker">{{ $packagesContent?->subtitle ?: 'Paket Pilihan' }}</span>
                        <h2 class="section-title-medium">{{ $packagesContent?->title ?: 'Mulai dari pengalaman yang paling pas.' }}</h2>
                    </div>
                </div>

                <div class="package-preview-grid">
                    @forelse($featuredPackages as $package)
                        <article class="package-preview-card">
                            <div class="package-preview-top">
                                <span>{{ $package->duration ?: 'Durasi fleksibel' }}</span>
                                <i class="bi bi-map" aria-hidden="true"></i>
                            </div>
                            <h3>{{ $package->title }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($package->description ?? 'Paket wisata budaya Desa Sasak Sade.', 112) }}</p>
                            <div class="package-preview-bottom">
                                <strong>Rp{{ number_format($package->price, 0, ',', '.') }}</strong>
                                <a href="{{ route('booking.index', ['package_id' => $package->id]) }}">
                                    Pesan
                                    <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">Paket wisata akan segera tersedia.</div>
                    @endforelse
                </div>
            </div>

            <aside class="event-preview-panel{{ $editableHomepage && $eventsContent ? ' homepage-editable' : '' }}">
                @if($editableHomepage && $eventsContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $eventsContent, 'label' => 'Preview Event'])
                @endif

                <span class="section-kicker">{{ $eventsContent?->subtitle ?: 'Agenda Terdekat' }}</span>
                <h2>{{ $eventsContent?->title ?: 'Event budaya yang bisa Anda ikuti.' }}</h2>

                <div class="event-preview-list">
                    @forelse($featuredEvents as $index => $event)
                        <a href="{{ route('events.show', $event) }}" class="event-preview-item">
                            <img src="{{ $imageFor($event, $index + 1) }}" alt="{{ $event->name }}" loading="lazy">
                            <span>
                                <strong>{{ $event->name }}</strong>
                                <small>
                                    <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                    {{ filled($event->date) ? \Carbon\Carbon::parse($event->date)->translatedFormat('d M Y') : 'Jadwal menyusul' }}
                                </small>
                            </span>
                        </a>
                    @empty
                        <div class="empty-state dark">Event akan segera diumumkan.</div>
                    @endforelse
                </div>

                <a href="{{ $resolveContentUrl($eventsContent?->button_url, route('events.index')) }}" class="panel-action">
                    {{ $eventsContent?->button_label ?: 'Buka Event' }}
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </a>
            </aside>
        </div>

        <div class="market-gallery-grid">
            <div class="market-panel{{ $editableHomepage && $marketContent ? ' homepage-editable' : '' }}">
                @if($editableHomepage && $marketContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $marketContent, 'label' => 'Preview Market'])
                @endif

                <div class="section-heading-row compact">
                    <div>
                        <span class="section-kicker">{{ $marketContent?->subtitle ?: 'Sade Mart' }}</span>
                        <h2 class="section-title-medium">{{ $marketContent?->title ?: 'Bawa pulang karya lokal.' }}</h2>
                    </div>
                    <a href="{{ $resolveContentUrl($marketContent?->button_url, route('market.index')) }}" class="section-link">
                        {{ $marketContent?->button_label ?: 'Belanja' }}
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="product-strip">
                    @forelse($featuredProducts as $index => $product)
                        <a href="{{ route('market.index') }}" class="product-mini-card">
                            <img src="{{ $imageFor($product, $index + 2) }}" alt="{{ $product->name }}" loading="lazy">
                            <span>
                                <strong>{{ $product->name }}</strong>
                                <small>Rp{{ number_format($product->price, 0, ',', '.') }}</small>
                            </span>
                        </a>
                    @empty
                        <div class="empty-state">Produk lokal akan segera tersedia.</div>
                    @endforelse
                </div>
            </div>

            <div class="gallery-panel{{ $editableHomepage && $galleryContent ? ' homepage-editable' : '' }}">
                @if($editableHomepage && $galleryContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $galleryContent, 'label' => 'Preview Galeri'])
                @endif

                <div class="section-heading-row compact">
                    <div>
                        <span class="section-kicker">{{ $galleryContent?->subtitle ?: 'Galeri' }}</span>
                        <h2 class="section-title-medium">{{ $galleryContent?->title ?: 'Momen dari desa.' }}</h2>
                    </div>
                    <a href="{{ $resolveContentUrl($galleryContent?->button_url, route('gallery.index')) }}" class="section-link">
                        {{ $galleryContent?->button_label ?: 'Lihat' }}
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="gallery-mosaic">
                    @forelse($galleryPreview as $index => $item)
                        <img src="{{ $imageFor($item, $index) }}" alt="{{ $item->caption ?: 'Galeri Sasak Sade' }}" loading="lazy">
                    @empty
                        @foreach($localImages as $image)
                            <img src="{{ $image }}" alt="Galeri Sasak Sade" loading="lazy">
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>

        <div class="review-cta-grid">
            <div class="review-panel{{ $editableHomepage && $reviewsContent ? ' homepage-editable' : '' }}">
                @if($editableHomepage && $reviewsContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $reviewsContent, 'label' => 'Preview Review'])
                @endif

                <span class="section-kicker">{{ $reviewsContent?->subtitle ?: 'Cerita Pengunjung' }}</span>
                <h2 class="section-title-medium">{{ $reviewsContent?->title ?: 'Kesan dari wisatawan yang sudah datang.' }}</h2>

                <div class="review-list">
                    @forelse($featuredReviews as $review)
                        <article class="review-card">
                            <div class="review-top">
                                <strong>{{ $review->visitor_name }}</strong>
                                <span>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    {{ $review->rating }}/5
                                </span>
                            </div>
                            <p>{{ \Illuminate\Support\Str::limit($review->comment, 150) }}</p>
                        </article>
                    @empty
                        <div class="empty-state">Review pengunjung akan tampil di sini.</div>
                    @endforelse
                </div>
            </div>

            <div class="final-cta{{ $editableHomepage && $ctaContent ? ' homepage-editable' : '' }}" style="background-image: linear-gradient(90deg, rgba(9, 24, 22, 0.88), rgba(9, 24, 22, 0.42)), url('{{ $contentImage($ctaContent, asset('images/sade4.png')) }}');">
                @if($editableHomepage && $ctaContent)
                    @include('admin.homepage-contents._content_actions', ['content' => $ctaContent, 'label' => 'CTA Beranda'])
                @endif

                <span class="section-kicker">{{ $ctaContent?->subtitle ?: 'Siap Berkunjung?' }}</span>
                <h2>{{ $ctaContent?->title ?: 'Rencanakan kunjungan budaya Anda ke Sasak Sade.' }}</h2>
                <p>{{ $ctaContent?->body ?: 'Pilih paket, cek event, atau hubungi pengelola untuk menyesuaikan jadwal rombongan.' }}</p>
                <div class="final-actions">
                    <a href="{{ $resolveContentUrl($ctaContent?->button_url, route('booking.index')) }}" class="home-btn primary">
                        <i class="bi bi-ticket-perforated" aria-hidden="true"></i>
                        {{ $ctaContent?->button_label ?: 'Booking' }}
                    </a>
                    <a href="{{ $resolveContentUrl(data_get($ctaContent?->meta, 'secondary_button_url'), route('contact.index')) }}" class="home-btn light">
                        <i class="bi bi-chat-dots" aria-hidden="true"></i>
                        {{ data_get($ctaContent?->meta, 'secondary_button_label', 'Kontak') }}
                    </a>
                </div>
            </div>
        </div>

        @if($customBlocks->isNotEmpty())
            <div class="custom-content-grid">
                @foreach($customBlocks as $block)
                    <article class="custom-content-card{{ $editableHomepage ? ' homepage-editable' : '' }}">
                        @if($editableHomepage)
                            @include('admin.homepage-contents._content_actions', ['content' => $block, 'label' => 'Konten Tambahan'])
                        @endif

                        @if($block->image_src)
                            <img src="{{ $block->image_src }}" alt="{{ $block->title ?: 'Konten Beranda' }}" loading="lazy">
                        @endif
                        <div>
                            @if($block->subtitle)
                                <span class="section-kicker">{{ $block->subtitle }}</span>
                            @endif
                            @if($block->title)
                                <h2 class="section-title-medium">{{ $block->title }}</h2>
                            @endif
                            @if($block->body)
                                <p>{{ $block->body }}</p>
                            @endif
                            @if($block->button_label && $block->button_url)
                                <a href="{{ $resolveContentUrl($block->button_url) }}" class="section-link">
                                    {{ $block->button_label }}
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    .home-highlights {
        background:
            linear-gradient(180deg, #f5f8f4 0%, #ffffff 36%, #eef5f2 100%);
        color: #1f2723;
        overflow: hidden;
        padding-bottom: 76px;
    }

    .home-menu-band {
        background: #0f2f2b;
        color: #fff;
        padding: 22px 0;
    }

    .home-menu-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
    }

    .home-menu-card {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr);
        align-items: center;
        gap: 12px;
        min-height: 120px;
        padding: 18px;
        border-radius: 8px;
        color: #fff;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: transform 0.25s ease, background 0.25s ease, border-color 0.25s ease;
    }

    .home-menu-card:hover {
        transform: translateY(-4px);
        color: #fff;
        background: rgba(255, 255, 255, 0.14);
        border-color: rgba(232, 192, 125, 0.45);
    }

    .menu-icon {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #e8c07d;
        color: #2d1b18;
        font-size: 20px;
    }

    .menu-copy {
        min-width: 0;
        display: grid;
        gap: 7px;
    }

    .menu-copy strong {
        font-size: 17px;
        line-height: 1.1;
    }

    .menu-copy small {
        color: rgba(255, 255, 255, 0.72);
        line-height: 1.55;
    }

    .menu-meta {
        grid-column: 2;
        width: max-content;
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(232, 192, 125, 0.16);
        color: #f5d296;
        font-size: 12px;
        font-weight: 800;
    }

    .home-intro-grid,
    .culture-row,
    .showcase-grid,
    .market-gallery-grid,
    .review-cta-grid {
        display: grid;
        gap: 28px;
        margin-top: 72px;
    }

    .home-intro-grid {
        grid-template-columns: minmax(0, 0.92fr) minmax(320px, 1.08fr);
        align-items: center;
    }

    .section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #7f522f;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }

    .section-kicker::before {
        content: "";
        width: 28px;
        height: 2px;
        background: #e8c07d;
    }

    .section-title-large {
        max-width: 760px;
        margin: 18px 0 0;
        color: #17241f;
        font-size: clamp(34px, 5vw, 64px);
        line-height: 1.02;
        font-weight: 950;
        letter-spacing: 0;
    }

    .section-title-medium {
        max-width: 680px;
        margin: 12px 0 0;
        color: #17241f;
        font-size: clamp(28px, 3.6vw, 46px);
        line-height: 1.08;
        font-weight: 950;
        letter-spacing: 0;
    }

    .section-lead {
        max-width: 620px;
        margin-top: 20px;
        color: #5f6d65;
        font-size: 17px;
        line-height: 1.9;
    }

    .intro-actions,
    .final-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .home-btn {
        min-height: 48px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 8px;
        font-weight: 900;
        text-decoration: none;
        transition: transform 0.22s ease, background 0.22s ease, color 0.22s ease;
    }

    .home-btn:hover {
        transform: translateY(-2px);
    }

    .home-btn.primary {
        background: #17241f;
        color: #fff;
    }

    .home-btn.primary:hover {
        background: #7f522f;
        color: #fff;
    }

    .home-btn.secondary {
        background: #fff;
        color: #17241f;
        border: 1px solid rgba(23, 36, 31, 0.14);
    }

    .home-btn.secondary:hover {
        background: #eef5f2;
        color: #17241f;
    }

    .home-btn.light {
        background: rgba(255, 255, 255, 0.16);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.22);
    }

    .home-btn.light:hover {
        background: rgba(255, 255, 255, 0.24);
        color: #fff;
    }

    .intro-media {
        position: relative;
        overflow: hidden;
        min-height: 560px;
        border-radius: 8px;
        background: #0f2f2b;
        box-shadow: 0 28px 70px rgba(23, 36, 31, 0.16);
    }

    .intro-media img {
        width: 100%;
        height: 100%;
        min-height: 560px;
        object-fit: cover;
        display: block;
    }

    .intro-media::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.00) 30%, rgba(8,18,16,0.76) 100%);
    }

    .intro-stat-panel {
        position: absolute;
        left: 18px;
        right: 18px;
        bottom: 18px;
        z-index: 2;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .intro-stat-panel div {
        padding: 16px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        color: #fff;
    }

    .intro-stat-panel strong {
        display: block;
        font-size: 28px;
        font-weight: 950;
        line-height: 1;
    }

    .intro-stat-panel span {
        display: block;
        margin-top: 8px;
        color: rgba(255, 255, 255, 0.74);
        font-size: 13px;
        font-weight: 800;
    }

    .culture-row {
        grid-template-columns: minmax(300px, 0.92fr) minmax(0, 1.08fr);
        align-items: stretch;
    }

    .culture-image-stack {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 12px;
        min-height: 420px;
    }

    .culture-image-stack img {
        width: 100%;
        height: 100%;
        min-height: 420px;
        object-fit: cover;
        border-radius: 20px;
        box-shadow: 0 22px 60px rgba(23, 36, 31, 0.14);
        transform: translateZ(0);
    }


    .culture-image-stack img:first-child {
        margin-top: 36px;
        min-height: 360px;
    }

    .culture-panel,
    .showcase-main,
    .market-panel,
    .gallery-panel,
    .review-panel {
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid rgba(23, 36, 31, 0.08);
        box-shadow: 0 22px 60px rgba(23, 36, 31, 0.08);
    }

    .culture-panel {
        padding: clamp(28px, 4vw, 50px);
    }

    .culture-panel h3 {
        margin: 14px 0 24px;
        color: #17241f;
        font-size: clamp(28px, 4vw, 50px);
        line-height: 1.08;
        font-weight: 950;
    }

    .culture-list {
        display: grid;
        gap: 14px;
    }

    .culture-list > div {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr);
        gap: 14px;
        align-items: start;
        padding: 16px;
        border-radius: 8px;
        background: #f5f8f4;
        border: 1px solid rgba(23, 36, 31, 0.06);
    }

    .culture-list i {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #0f2f2b;
        color: #f5d296;
    }

    .culture-list > div > span {
        color: #4f5e56;
        line-height: 1.7;
    }

    .section-heading-row {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-top: 76px;
    }

    .section-heading-row.compact {
        margin-top: 0;
    }

    .section-link,
    .panel-action {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        width: max-content;
        color: #7f522f;
        font-weight: 900;
        text-decoration: none;
    }

    .section-link:hover,
    .panel-action:hover {
        color: #17241f;
    }

    .journey-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-top: 28px;
    }

    .journey-card {
        min-height: 230px;
        padding: 26px;
        border-radius: 8px;
        background: #17241f;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: transform 0.25s ease;
    }

    .journey-card:nth-child(2) {
        background: #7f522f;
    }

    .journey-card:nth-child(3) {
        background: #0f2f2b;
    }

    .journey-card:hover {
        transform: translateY(-5px);
    }

    .journey-card span {
        display: inline-flex;
        margin-bottom: 42px;
        color: #f5d296;
        font-size: 14px;
        font-weight: 950;
        letter-spacing: 0.12em;
    }

    .journey-card h3 {
        margin: 0;
        font-size: 25px;
        font-weight: 950;
    }

    .journey-card p {
        margin: 12px 0 0;
        color: rgba(255, 255, 255, 0.72);
        line-height: 1.75;
    }

    .showcase-grid {
        grid-template-columns: minmax(0, 1.3fr) minmax(320px, 0.7fr);
        align-items: stretch;
    }

    .showcase-main,
    .market-panel,
    .gallery-panel,
    .review-panel {
        padding: clamp(24px, 3vw, 34px);
    }

    .package-preview-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 26px;
    }

    .package-preview-card,
    .product-mini-card,
    .review-card {
        border-radius: 8px;
        background: #f5f8f4;
        border: 1px solid rgba(23, 36, 31, 0.08);
    }

    .package-preview-card {
        display: flex;
        flex-direction: column;
        min-height: 300px;
        padding: 20px;
    }

    .package-preview-top,
    .package-preview-bottom,
    .review-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .package-preview-top span {
        color: #7f522f;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .package-preview-top i {
        color: #0f2f2b;
        font-size: 18px;
    }

    .package-preview-card h3 {
        margin: 24px 0 0;
        color: #17241f;
        font-size: 22px;
        line-height: 1.18;
        font-weight: 950;
    }

    .package-preview-card p {
        flex: 1;
        margin: 14px 0 24px;
        color: #5f6d65;
        line-height: 1.72;
    }

    .package-preview-bottom strong {
        color: #0f2f2b;
        font-size: 18px;
        font-weight: 950;
    }

    .package-preview-bottom a {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #7f522f;
        font-weight: 950;
        text-decoration: none;
    }

    .event-preview-panel {
        display: flex;
        flex-direction: column;
        padding: 30px;
        border-radius: 8px;
        background: #0f2f2b;
        color: #fff;
    }

    .event-preview-panel .section-kicker,
    .final-cta .section-kicker {
        color: #f5d296;
    }

    .event-preview-panel h2,
    .final-cta h2 {
        margin: 12px 0 0;
        font-size: clamp(28px, 3vw, 42px);
        line-height: 1.08;
        font-weight: 950;
    }

    .event-preview-list {
        display: grid;
        gap: 12px;
        margin: 26px 0;
    }

    .event-preview-item {
        display: grid;
        grid-template-columns: 84px minmax(0, 1fr);
        gap: 13px;
        align-items: center;
        padding: 10px;
        border-radius: 8px;
        color: #fff;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.10);
    }

    .event-preview-item:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.14);
    }

    .event-preview-item img {
        width: 84px;
        height: 78px;
        object-fit: cover;
        border-radius: 8px;
    }

    .event-preview-item span {
        min-width: 0;
        display: grid;
        gap: 8px;
    }

    .event-preview-item strong {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .event-preview-item small {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: rgba(255, 255, 255, 0.72);
    }

    .event-preview-panel .panel-action {
        margin-top: auto;
        color: #f5d296;
    }

    .market-gallery-grid {
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    }

    .product-strip {
        display: grid;
        gap: 12px;
        margin-top: 26px;
    }

    .product-mini-card {
        display: grid;
        grid-template-columns: 92px minmax(0, 1fr);
        align-items: center;
        gap: 14px;
        padding: 10px;
        color: #17241f;
        text-decoration: none;
        transition: transform 0.22s ease, background 0.22s ease;
    }

    .product-mini-card:hover {
        transform: translateX(4px);
        color: #17241f;
        background: #eef5f2;
    }

    .product-mini-card img {
        width: 92px;
        height: 82px;
        object-fit: cover;
        border-radius: 8px;
    }

    .product-mini-card span {
        min-width: 0;
        display: grid;
        gap: 8px;
    }

    .product-mini-card strong {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-mini-card small {
        color: #7f522f;
        font-weight: 950;
    }

    .gallery-mosaic {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        grid-auto-rows: 150px;
        gap: 10px;
        margin-top: 26px;
    }

.gallery-mosaic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 18px;
        /* bikin sudut gambar lebih modern + subtle depth */
        box-shadow: 0 18px 45px rgba(23, 36, 31, 0.14);
        transform: translateZ(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-mosaic img:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 26px 65px rgba(23, 36, 31, 0.20);
    }

    .gallery-mosaic img:first-child {
        grid-row: span 2;
    }

    .review-cta-grid {
        grid-template-columns: minmax(0, 0.9fr) minmax(320px, 1.1fr);
    }

    .custom-content-grid {
        display: grid;
        gap: 18px;
        margin-top: 72px;
    }

    .custom-content-card {
        display: grid;
        grid-template-columns: minmax(220px, 0.42fr) minmax(0, 0.58fr);
        gap: 24px;
        align-items: center;
        padding: clamp(22px, 3vw, 34px);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(23, 36, 31, 0.08);
        box-shadow: 0 22px 60px rgba(23, 36, 31, 0.08);
    }

    .custom-content-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 8px;
    }

    .custom-content-card p {
        margin: 16px 0 0;
        color: #5f6d65;
        line-height: 1.8;
    }

    .custom-content-card .section-link {
        margin-top: 20px;
    }

    .review-list {
        display: grid;
        gap: 12px;
        margin-top: 26px;
    }

    .review-card {
        padding: 20px;
    }

    .review-top strong {
        color: #17241f;
        font-size: 17px;
    }

    .review-top span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #7f522f;
        font-weight: 950;
    }

    .review-card p {
        margin: 14px 0 0;
        color: #5f6d65;
        line-height: 1.75;
    }

    .final-cta {
        min-height: 390px;
        display: flex;
        flex-direction: column;
        justify-content: end;
        padding: clamp(28px, 4vw, 48px);
        border-radius: 8px;
        color: #fff;
        background:
            linear-gradient(90deg, rgba(9, 24, 22, 0.88), rgba(9, 24, 22, 0.42)),
            url('{{ asset('images/sade4.png') }}') center / cover;
        overflow: hidden;
    }

    .final-cta p {
        max-width: 560px;
        margin: 16px 0 0;
        color: rgba(255, 255, 255, 0.78);
        line-height: 1.8;
    }

    .empty-state {
        padding: 18px;
        border-radius: 8px;
        background: #f5f8f4;
        color: #5f6d65;
        border: 1px solid rgba(23, 36, 31, 0.08);
    }

    .empty-state.dark {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.72);
        border-color: rgba(255, 255, 255, 0.12);
    }

    @media (max-width: 1199px) {
        .home-menu-grid,
        .package-preview-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .home-intro-grid,
        .culture-row,
        .showcase-grid,
        .market-gallery-grid,
        .review-cta-grid,
        .custom-content-card {
            grid-template-columns: 1fr;
        }

        .intro-media,
        .intro-media img {
            min-height: 460px;
        }
    }

    @media (max-width: 767px) {
        .home-highlights {
            padding-bottom: 52px;
        }

        .home-menu-grid,
        .journey-grid,
        .package-preview-grid {
            grid-template-columns: 1fr;
        }

        .home-menu-card {
            min-height: auto;
        }

        .home-intro-grid,
        .culture-row,
        .showcase-grid,
        .market-gallery-grid,
        .review-cta-grid,
        .custom-content-grid {
            margin-top: 50px;
        }

        .section-heading-row {
            align-items: start;
            flex-direction: column;
            margin-top: 56px;
        }

        .intro-media,
        .intro-media img {
            min-height: 380px;
        }

        .intro-stat-panel {
            grid-template-columns: 1fr;
        }

        .culture-image-stack {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .culture-image-stack img,
        .culture-image-stack img:first-child {
            min-height: 260px;
            margin-top: 0;
        }

        .gallery-mosaic {
            grid-template-columns: 1fr 1fr;
            grid-auto-rows: 120px;
        }

        .gallery-mosaic img:first-child {
            grid-row: span 1;
        }
    }

    /* Scroll Zoom Gallery Styles */
    .scroll-zoom-gallery-wrapper {
        width: 100vw;
        height: 18cm;
        margin-left: calc(-50vw + 50%);
        margin-right: calc(-50vw + 50%);
        margin-top: 72px;
        margin-bottom: 72px;
        overflow: hidden;
        background: #0f2f2b;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 32px;
    }

    .scroll-zoom-gallery {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        grid-template-columns: 1fr;
        gap: 0;
    }

    .scroll-zoom-item {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 32px;
    }

    .scroll-zoom-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(0.85);
        transform-origin: center;
        transition: transform 0.2s ease;
        border-radius: 32px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .scroll-zoom-gallery {
            grid-template-columns: 1fr;
        }

        .scroll-zoom-gallery-wrapper {
            height: auto;
            aspect-ratio: 16 / 9;
        }

        .scroll-zoom-item:nth-child(2),
        .scroll-zoom-item:nth-child(3) {
            display: none;
        }
    }
</style>

<script>
    // Scroll Zoom Gallery Effect (No Scroll Lock)
    document.addEventListener('DOMContentLoaded', function() {
        const gallery = document.querySelector('.scroll-zoom-gallery-wrapper');
        const items = document.querySelectorAll('.scroll-zoom-item img');

        if (!gallery) return;

        function updateZoom() {
            const rect = gallery.getBoundingClientRect();
            const viewportHeight = window.innerHeight;
            const galleryHeight = gallery.offsetHeight;

            // Calculate the scroll position relative to the gallery
            // When gallery is at bottom of viewport: ratio = 0
            // When gallery is at center of viewport: ratio = 0.5
            // When gallery is at top of viewport: ratio = 1
            const scrollRatio = Math.max(0, Math.min(1, (viewportHeight - rect.top) / (viewportHeight + galleryHeight)));

            // Calculate scale: 
            // When not in view (ratio near 0): scale 0.85
            // When in perfect view (ratio = 0.5): scale 1 (full size)
            // When scrolled past (ratio = 1): scale 0.85 again
            const currentScale = 0.85 + (Math.sin((scrollRatio - 0.5) * Math.PI) * 0.15);

            items.forEach(item => {
                item.style.transform = `scale(${currentScale})`;
            });
        }

        window.addEventListener('scroll', updateZoom, { passive: true });
        window.addEventListener('resize', updateZoom, { passive: true });
        updateZoom(); // Initial call
    });
</script>
