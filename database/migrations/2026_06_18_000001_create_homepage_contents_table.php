<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_contents', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('home_custom')->index();
            $table->string('key')->unique();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('body')->nullable();
            $table->string('icon')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_url', 2048)->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('homepage_contents')->insert([
            [
                'group' => 'hero',
                'key' => 'hero.main',
                'title' => 'Rasakan Wisata Budaya Otentik di Lombok',
                'subtitle' => 'Discover Desa Sasak Sade',
                'body' => 'Nikmati pengalaman desa adat, tenun tradisional, pertunjukan budaya, dan paket wisata keluarga yang dirancang khusus untuk traveler modern.',
                'button_label' => 'Pesan Sekarang',
                'button_url' => 'route:booking.index',
                'sort_order' => 1,
                'meta' => json_encode([
                    'secondary_button_label' => 'Lihat Paket',
                    'secondary_button_url' => 'route:packages.index',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'about',
                'key' => 'about.main',
                'title' => 'Rasakan Nuansa Budaya Sasak yang Masih Asli',
                'subtitle' => 'Desa Wisata Tradisional',
                'body' => 'Desa Wisata Sasak Sade memperlihatkan kehidupan masyarakat Sasak yang kaya adat, rumah tradisional, tenun, dan pertunjukan budaya. Kunjungi desa ini untuk merasakan pengalaman wisata budaya yang otentik dan mendalam.',
                'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSBLgkTNqCpr5HWKXGakrULdZJtnET4ZGEEGA&s',
                'sort_order' => 1,
                'meta' => json_encode([
                    'card_title' => 'Desa Sasak Sade',
                    'card_body' => 'Menjaga budaya leluhur Lombok melalui rumah adat, tenun tradisional, dan kehidupan masyarakat asli Sasak.',
                    'section_kicker' => 'Tentang Desa',
                    'secondary_image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRn-8SJ_7X4l3j95nDfj5XUagZj1vLtz5pz8A&s',
                    'experience_number' => '20+',
                    'experience_text' => 'Tahun menjaga budaya & tradisi Lombok',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'about_highlight',
                'key' => 'about.highlight.history',
                'title' => 'Sejarah desa adat Sasak yang masih terjaga.',
                'body' => 'Nikmati pengalaman budaya autentik khas Lombok.',
                'icon' => 'bi-stars',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'about_highlight',
                'key' => 'about.highlight.performance',
                'title' => 'Pertunjukan tari tradisional dan musik Sasak.',
                'body' => 'Nikmati pengalaman budaya autentik khas Lombok.',
                'icon' => 'bi-stars',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'about_highlight',
                'key' => 'about.highlight.craft',
                'title' => 'Kerajinan tenun, kain songket, serta produk lokal khas Lombok.',
                'body' => 'Nikmati pengalaman budaya autentik khas Lombok.',
                'icon' => 'bi-stars',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'about_highlight',
                'key' => 'about.highlight.gallery',
                'title' => 'Galeri foto dan video yang menampilkan suasana desa.',
                'body' => 'Nikmati pengalaman budaya autentik khas Lombok.',
                'icon' => 'bi-stars',
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_menu',
                'key' => 'home.menu.packages',
                'title' => 'Paket Wisata',
                'subtitle' => 'paket',
                'body' => 'Pilih pengalaman desa adat, tenun, kuliner, dan tur budaya.',
                'icon' => 'bi-map',
                'button_url' => 'route:packages.index',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_menu',
                'key' => 'home.menu.events',
                'title' => 'Event Budaya',
                'subtitle' => 'event',
                'body' => 'Lihat jadwal pertunjukan, aktivitas desa, dan agenda tradisi.',
                'icon' => 'bi-calendar-event',
                'button_url' => 'route:events.index',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_menu',
                'key' => 'home.menu.market',
                'title' => 'Sade Mart',
                'subtitle' => 'produk',
                'body' => 'Temukan tenun, kerajinan, dan oleh-oleh khas Sasak Sade.',
                'icon' => 'bi-bag-heart',
                'button_url' => 'route:market.index',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_menu',
                'key' => 'home.menu.gallery',
                'title' => 'Galeri',
                'subtitle' => 'foto',
                'body' => 'Intip suasana rumah adat, aktivitas warga, dan momen wisata.',
                'icon' => 'bi-images',
                'button_url' => 'route:gallery.index',
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_intro',
                'key' => 'home.intro',
                'title' => 'Satu halaman untuk mulai mengenal budaya, memilih pengalaman, dan merencanakan kunjungan.',
                'subtitle' => 'Beranda Sasak Sade',
                'body' => 'Sasak Sade bukan sekadar destinasi. Di sini, rumah adat, tenun, keramahan warga, dan cerita turun-temurun hadir sebagai pengalaman yang bisa Anda rasakan langsung.',
                'button_label' => 'Booking Kunjungan',
                'button_url' => 'route:booking.index',
                'image_url' => 'images/sade1.png',
                'sort_order' => 1,
                'meta' => json_encode([
                    'secondary_button_label' => 'Kenali Desa',
                    'secondary_button_url' => 'route:about',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_culture',
                'key' => 'home.culture',
                'title' => 'Budaya yang masih hidup dalam keseharian.',
                'subtitle' => 'Yang Bisa Anda Rasakan',
                'image_url' => 'images/sade2.png',
                'sort_order' => 1,
                'meta' => json_encode([
                    'secondary_image_url' => 'images/sade3.png',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_culture_item',
                'key' => 'home.culture.house',
                'body' => 'Rumah adat dengan cerita ruang dan filosofi keluarga.',
                'icon' => 'bi-house-heart',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_culture_item',
                'key' => 'home.culture.weaving',
                'body' => 'Tenun tradisional sebagai identitas dan karya warga lokal.',
                'icon' => 'bi-flower1',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_culture_item',
                'key' => 'home.culture.people',
                'body' => 'Interaksi langsung bersama masyarakat desa yang ramah.',
                'icon' => 'bi-people',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_culture_item',
                'key' => 'home.culture.photo',
                'body' => 'Sudut foto alami dari lanskap desa, rumah adat, dan aktivitas budaya.',
                'icon' => 'bi-camera',
                'sort_order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_journey',
                'key' => 'home.journey',
                'title' => 'Alur kunjungan yang nyaman untuk wisatawan.',
                'subtitle' => 'Rute Pengalaman',
                'button_label' => 'Lihat semua paket',
                'button_url' => 'route:packages.index',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_journey_step',
                'key' => 'home.journey.welcome',
                'title' => 'Disambut di desa',
                'subtitle' => '01',
                'body' => 'Mulai dari orientasi singkat tentang adat dan tata cara berkunjung.',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_journey_step',
                'key' => 'home.journey.houses',
                'title' => 'Jelajah rumah adat',
                'subtitle' => '02',
                'body' => 'Mengenal bentuk rumah, ruang keluarga, dan filosofi bangunan Sasak.',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_journey_step',
                'key' => 'home.journey.weaving',
                'title' => 'Tenun dan produk lokal',
                'subtitle' => '03',
                'body' => 'Melihat proses tenun, memilih karya warga, dan membawa cerita pulang.',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_packages',
                'key' => 'home.packages.preview',
                'title' => 'Mulai dari pengalaman yang paling pas.',
                'subtitle' => 'Paket Pilihan',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_events',
                'key' => 'home.events.preview',
                'title' => 'Event budaya yang bisa Anda ikuti.',
                'subtitle' => 'Agenda Terdekat',
                'button_label' => 'Buka Event',
                'button_url' => 'route:events.index',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_market',
                'key' => 'home.market.preview',
                'title' => 'Bawa pulang karya lokal.',
                'subtitle' => 'Sade Mart',
                'button_label' => 'Belanja',
                'button_url' => 'route:market.index',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_gallery',
                'key' => 'home.gallery.preview',
                'title' => 'Momen dari desa.',
                'subtitle' => 'Galeri',
                'button_label' => 'Lihat',
                'button_url' => 'route:gallery.index',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_reviews',
                'key' => 'home.reviews.preview',
                'title' => 'Kesan dari wisatawan yang sudah datang.',
                'subtitle' => 'Cerita Pengunjung',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'home_cta',
                'key' => 'home.final_cta',
                'title' => 'Rencanakan kunjungan budaya Anda ke Sasak Sade.',
                'subtitle' => 'Siap Berkunjung?',
                'body' => 'Pilih paket, cek event, atau hubungi pengelola untuk menyesuaikan jadwal rombongan.',
                'button_label' => 'Booking',
                'button_url' => 'route:booking.index',
                'image_url' => 'images/sade4.png',
                'sort_order' => 1,
                'meta' => json_encode([
                    'secondary_button_label' => 'Kontak',
                    'secondary_button_url' => 'route:contact.index',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'group' => 'footer',
                'key' => 'footer.main',
                'title' => 'Desa Wisata Sasak Sade',
                'subtitle' => 'Wisata Budaya Lombok',
                'body' => 'Temukan pengalaman budaya khas Lombok melalui wisata tradisional, pertunjukan budaya, rumah adat Sasak, serta produk lokal asli Desa Sasak Sade.',
                'button_label' => 'Booking Sekarang',
                'button_url' => 'route:booking.index',
                'sort_order' => 1,
                'meta' => json_encode([
                    'copyright' => 'Copyright 2026 Desa Wisata Sasak Sade - Semua Hak Dilindungi',
                ]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_contents');
    }
};
