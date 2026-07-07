<div class="container py-4"></div>
@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    <div class="space-y-8">
        <section class="rounded-[2rem] bg-[#fffdf9] p-8 shadow-sm">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-[#F53003]">Dashboard</p>
                    <h1 class="mt-3 text-4xl font-semibold text-[#1B1B18]">Halo, {{ $userName }}</h1>
                    <p class="mt-2 text-gray-600">Selamat datang di panel pengguna Anda. Kelola booking dan lihat ringkasan perjalanan.</p>
                </div>
                <div class="rounded-full bg-[#F8B803]/10 px-5 py-3 text-sm font-semibold text-[#5A4200]">Anda memiliki {{ $totalBookings }} booking tersimpan</div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-3">
            <article class="rounded-[2rem] bg-white p-8 shadow-sm">
                <p class="text-sm uppercase tracking-[0.25em] text-gray-500">Total Booking</p>
                <p class="mt-4 text-4xl font-semibold text-[#F53003]">{{ $totalBookings }}</p>
            </article>
            <article class="rounded-[2rem] bg-white p-8 shadow-sm">
                <p class="text-sm uppercase tracking-[0.25em] text-gray-500">Paket Tersedia</p>
                <p class="mt-4 text-4xl font-semibold text-[#1B1B18]">{{ $favoritePackageCount }}</p>
            </article>
            <article class="rounded-[2rem] bg-white p-8 shadow-sm">
                <p class="text-sm uppercase tracking-[0.25em] text-gray-500">Rating Rata-rata</p>
                <p class="mt-4 text-4xl font-semibold text-[#1B1B18]">{{ $averageRating }}</p>
            </article>
        </section>

        <section class="rounded-[2rem] bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-[#F53003]">Booking Terakhir</p>
                    <h2 class="mt-2 text-2xl font-semibold text-[#1B1B18]">Ringkasan pesanan terbaru</h2>
                </div>
                <a href="{{ route('profile.bookings') }}" class="rounded-full border border-[#F53003] bg-[#FFF4F2] px-5 py-3 text-sm font-semibold text-[#F53003] hover:bg-[#fee7e4]">Lihat riwayat booking</a>
            </div>
            @if($lastBooking)
                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    <div class="rounded-[1.8rem] bg-[#F8F2EF] p-6">
                        <p class="text-sm text-gray-500">Nama Paket</p>
                        <p class="mt-3 text-xl font-semibold text-[#1B1B18]">{{ $lastBooking->package?->title ?? 'Paket tidak tersedia' }}</p>
                    </div>
                    <div class="rounded-[1.8rem] bg-[#EFF6FF] p-6">
                        <p class="text-sm text-gray-500">Tanggal Kunjungan</p>
                        <p class="mt-3 text-xl font-semibold text-[#1B1B18]">{{ $lastBooking->visit_date }}</p>
                    </div>
                    <div class="rounded-[1.8rem] bg-[#FDF8F7] p-6">
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="mt-3">
                            <span class="badge {{ $lastBooking->status_badge_class }}">{{ $lastBooking->status_label }}</span>
                        </p>
                        <p class="mt-2 text-sm text-gray-600">{{ $lastBooking->guests }} orang</p>
                    </div>
                </div>
            @else
                <p class="mt-8 text-gray-600">Anda belum memiliki booking.</p>
            @endif
        </section>

        <section class="rounded-[2rem] bg-[#F3FAFF] p-8 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-[#2563EB]">Aktivitas Admin</p>
                    <h2 class="mt-2 text-2xl font-semibold text-[#1B1B18]">Update terbaru dari pengelola wisata</h2>
                </div>
            </div>
            <div class="mt-8 space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="rounded-lg border-l-4 border-l-[#2563EB] bg-white p-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-[#1B1B18]">{{ $activity->description }}</p>
                                <p class="mt-1 text-xs text-gray-500">
                                    @if($activity->action === 'create')
                                        <span class="inline-block rounded bg-green-100 px-2 py-1 text-green-700">Ditambahkan</span>
                                    @elseif($activity->action === 'update')
                                        <span class="inline-block rounded bg-yellow-100 px-2 py-1 text-yellow-700">Diperbarui</span>
                                    @elseif($activity->action === 'delete')
                                        <span class="inline-block rounded bg-red-100 px-2 py-1 text-red-700">Dihapus</span>
                                    @endif
                                    • {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <span class="text-xs font-medium text-gray-400">{{ ucfirst($activity->module) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-600">Belum ada aktivitas dari pengelola</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
