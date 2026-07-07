@extends('admin.layout')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Kelola semua data website: hero, events, galeri, paket, produk, kontak, review, dan booking')

@section('content')
    @php
        $stats = [
            ['label' => 'Hero Beranda', 'number' => $heroImages, 'icon' => 'bi-images'],
            ['label' => 'Events', 'number' => $events, 'icon' => 'bi-calendar-event'],
            ['label' => 'Galeri', 'number' => $galleries, 'icon' => 'bi-images'],
            ['label' => 'Paket Wisata', 'number' => $packages, 'icon' => 'bi-luggage'],
            ['label' => 'Tour Guides', 'number' => $guides, 'icon' => 'bi-person-badge'],
            ['label' => 'Produk Market', 'number' => $products, 'icon' => 'bi-shop'],
            ['label' => 'Reviews', 'number' => $reviews, 'icon' => 'bi-star'],
            ['label' => 'Kontak Pengelola', 'number' => $contacts, 'icon' => 'bi-people'],
            ['label' => 'Booking', 'number' => $bookings, 'icon' => 'bi-bookmark-check'],
        ];

        $modules = [
            [
                'title' => 'Hero Beranda',
                'description' => 'Kelola gambar slider hero utama yang tampil di bagian paling atas beranda.',
                'route' => route('admin.hero-images.index'),
                'icon' => 'bi-images',
            ],
            [
                'title' => 'Events',
                'description' => 'Tambah, edit, dan hapus jadwal pertunjukan atau kegiatan budaya.',
                'route' => route('admin.events.index'),
                'icon' => 'bi-calendar-event',
            ],
            [
                'title' => 'Galeri',
                'description' => 'Kelola foto, caption, dan dokumentasi wisata.',
                'route' => route('admin.galleries.index'),
                'icon' => 'bi-images',
            ],
            [
                'title' => 'Paket Wisata',
                'description' => 'Atur paket wisata, harga, durasi, dan fasilitas.',
                'route' => route('admin.packages.index'),
                'icon' => 'bi-luggage',
            ],
            [
                'title' => 'Tour Guide',
                'description' => 'Kelola data pemandu lokal dan kontak yang tersedia.',
                'route' => route('admin.guides.index'),
                'icon' => 'bi-person-badge',
            ],
            [
                'title' => 'Market Sade',
                'description' => 'Tambah dan ubah produk lokal yang tampil di market.',
                'route' => route('admin.products.index'),
                'icon' => 'bi-shop',
            ],
            [
                'title' => 'Reviews',
                'description' => 'Kelola ulasan, rating, dan testimoni pengunjung.',
                'route' => route('admin.reviews.index'),
                'icon' => 'bi-star',
            ],
            [
                'title' => 'Kontak Pengelola',
                'description' => 'Perbarui kontak dan informasi pengelola website.',
                'route' => route('admin.contacts.index'),
                'icon' => 'bi-people',
            ],
            [
                'title' => 'Kelola Booking',
                'description' => 'Konfirmasi lewat WhatsApp, ubah status kunjungan, dan arsipkan booking selesai.',
                'route' => route('admin.bookings.index'),
                'icon' => 'bi-bookmark-check',
            ],
        ];
    @endphp

    <div class="row g-3">
        @foreach($stats as $stat)
            <div class="col-md-6 col-lg-3">
                <div class="badge-count">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <div class="label">{{ $stat['label'] }}</div>
                            <div class="number">{{ $stat['number'] }}</div>
                        </div>
                        <i class="bi {{ $stat['icon'] }} fs-3 text-success"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <section class="mt-4">
        <h2 class="h5 mb-3">Menu CRUD Admin</h2>
        <div class="row g-3">
            @foreach($modules as $module)
                <div class="col-sm-6 col-xl-3">
                    <div class="card module-card">
                        <div class="card-body">
                            <span class="module-icon">
                                <i class="bi {{ $module['icon'] }}"></i>
                            </span>
                            <div>
                                <h3 class="h6 mb-1">{{ $module['title'] }}</h3>
                                <p class="small text-muted mb-0">{{ $module['description'] }}</p>
                            </div>
                            <a href="{{ $module['route'] }}" class="btn-add module-link">
                                <i class="bi bi-arrow-right"></i> Buka CRUD
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mt-4">
        <div class="card">
            <div class="card-body p-4">
                <h2 class="h5 mb-4">Aktivitas Terakhir</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu</th>
                                <th>Aksi</th>
                                <th>Modul</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <small class="text-muted">{{ $activity->created_at->format('d M Y, H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($activity->action === 'create')
                                            <span class="badge bg-success">Tambah</span>
                                        @elseif($activity->action === 'update')
                                            <span class="badge bg-warning text-dark">Ubah</span>
                                        @elseif($activity->action === 'delete')
                                            <span class="badge bg-danger">Hapus</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($activity->action) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ ucfirst($activity->module) }}</span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Belum ada aktivitas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
