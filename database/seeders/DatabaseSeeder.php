<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\PackageTour;
use App\Models\Product;
use App\Models\Review;
use App\Models\TourGuide;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'adminsasaksade@gmail.com'],
            [
                'name' => 'Admin Sasak Sade',
                'password' => bcrypt('sade2121Q'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@sasaksade.local'],
            [
                'name' => 'Pengunjung Sasak',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        Event::insert([
            [
                'name' => 'Pertunjukan Tari Tradisional',
                'description' => 'Saksikan tarian tradisional Sasak yang memukau dengan kostum dan musik asli Lombok.',
                'date' => now()->addDays(3)->toDateString(),
                'time' => '10:00:00',
                'location' => 'Pusat Desa Sasak Sade',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wisata Rumah Adat',
                'description' => 'Jelajahi rumah adat Sasak dan pelajari filosofi serta tata cara tradisionalnya.',
                'date' => now()->addDays(7)->toDateString(),
                'time' => '14:00:00',
                'location' => 'Dusun Sade',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Gallery::insert([
            [
                'image_url' => 'https://images.unsplash.com/photo-1578496781983-0c5d12199cba?auto=format&fit=crop&w=900&q=80',
                'caption' => 'Rumah adat Sasak di malam hari',
                'uploaded_at' => now(),
            ],
            [
                'image_url' => 'https://images.unsplash.com/photo-1519817650390-64a93db511aa?auto=format&fit=crop&w=900&q=80',
                'caption' => 'Kerajinan tenun Lombok',
                'uploaded_at' => now()->subDays(1),
            ],
        ]);

        PackageTour::insert([
            [
                'title' => 'Paket Budaya Hemat',
                'price' => 250000,
                'duration' => '3 jam',
                'description' => 'Kunjungan singkat ke rumah adat, pertunjukan tari, dan pameran tenun.',
                'features' => "Rumah adat\nPertunjukan budaya\nSouvenir ringan",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Paket Wisata Lengkap',
                'price' => 450000,
                'duration' => '6 jam',
                'description' => 'Tour lengkap dengan pengalaman tenun, makan tradisional, dan hiking desa.',
                'features' => "Tour rumah adat\nWorkshop tenun\nMakan tradisional\nGuide lokal",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        TourGuide::insert([
            [
                'name' => 'Haji Amin',
                'phone' => '+6281234567890',
                'languages' => 'Indonesia, Inggris',
                'description' => 'Pemandu berpengalaman yang memahami adat Sasak dan cerita tradisional desa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maya Dewi',
                'phone' => '+6289876543210',
                'languages' => 'Indonesia, Inggris',
                'description' => 'Pemandu yang ramah dan fasih menjelaskan sejarah rumah adat dan budaya lokal.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Product::insert([
            [
                'name' => 'Kain Tenun Sasak',
                'price' => 150000,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=900&q=80',
                'description' => 'Kain tenun khas Sasak dengan motif tradisional Lombok.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aksesoris Giri',
                'price' => 85000,
                'stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=900&q=80',
                'description' => 'Aksesoris khas yang cocok untuk oleh-oleh budaya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Review::insert([
            [
                'visitor_name' => 'Wulan',
                'rating' => 5,
                'comment' => 'Pengalaman yang sangat berkesan. Guide sangat informatif dan suasana desa sangat asri.',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'visitor_name' => 'Rizka',
                'rating' => 4,
                'comment' => 'Sangat cocok untuk wisata keluarga. Paket lengkap dan harga terjangkau.',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
        ]);
    }
}
