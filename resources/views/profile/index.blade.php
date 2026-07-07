@extends('layouts.app')
<div class="container py-4"></div>
@section('title', 'Profil Saya')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-[2rem] bg-white p-8 shadow-sm">
            <h2 class="text-2xl font-semibold">Halo, {{ $user->name }}</h2>
            <p class="mt-3 text-gray-600">Email: {{ $user->email }}</p>
            <p class="text-sm text-gray-500">Role: {{ ucfirst($user->role) }}</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-[1.5rem] bg-[#FDF2F2] p-6">
                    <p class="text-sm text-gray-500">Total Booking</p>
                    <p class="mt-3 text-3xl font-semibold text-[#F53003]">{{ $bookings->count() }}</p>
                </div>
                <div class="rounded-[1.5rem] bg-[#EFF6FF] p-6">
                    <p class="text-sm text-gray-500">Booking Terakhir</p>
                    <p class="mt-3 text-xl font-semibold">{{ $bookings->first()?->visit_date ?? 'Belum ada' }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] bg-white p-8 shadow-sm">
            <h3 class="text-xl font-semibold">Aksi Cepat</h3>
            <div class="mt-6 space-y-3">
                <a href="{{ route('profile.bookings') }}" class="block rounded-full border border-[#F53003] bg-[#FFF4F2] px-5 py-3 text-sm font-semibold text-[#F53003] hover:bg-[#FEE7E4]">Lihat Riwayat Booking</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full rounded-full bg-[#F53003] px-5 py-3 text-sm font-semibold text-white hover:bg-[#d13202]">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-10 rounded-[2rem] bg-white p-8 shadow-sm">
        <h3 class="text-xl font-semibold">Ringkasan Booking</h3>
        <div class="mt-6 space-y-4">
            @forelse($bookings as $booking)
                <article class="rounded-[1.5rem] border border-gray-200 p-6">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h4 class="text-lg font-semibold">{{ $booking->package?->title ?? 'Paket tidak tersedia' }}</h4>
                            <p class="text-sm text-gray-600">Tanggal kunjungan: {{ $booking->visit_date }}</p>
                            <span class="badge {{ $booking->status_badge_class }} mt-2">{{ $booking->status_label }}</span>
                        </div>
                        <span class="rounded-full bg-[#F53003]/10 px-4 py-2 text-sm font-semibold text-[#F53003]">{{ $booking->guests }} orang</span>
                    </div>
                    <p class="mt-4 text-gray-600">{{ $booking->message ?: 'Tidak ada catatan tambahan.' }}</p>
                </article>
            @empty
                <p class="text-gray-600">Belum ada booking yang tersimpan di akun Anda.</p>
            @endforelse
        </div>
    </div>
@endsection
