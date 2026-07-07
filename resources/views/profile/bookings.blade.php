@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white p-8 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-semibold">Riwayat Booking</h2>
                    <p class="mt-2 text-gray-600">Berisi semua booking wisata yang tersimpan dalam akun Anda.</p>
                </div>
                <a href="{{ route('profile') }}" class="rounded-full border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">Kembali ke Profil</a>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="rounded-[2rem] bg-white p-8 shadow-sm text-gray-600">Belum ada riwayat booking.</div>
        @else
            <div class="grid gap-6">
                @foreach($bookings as $booking)
                    <article class="rounded-[2rem] border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl font-semibold">{{ $booking->package?->title ?? 'Paket tidak tersedia' }}</h3>
                                <p class="mt-1 text-sm text-gray-500">Tanggal booking: {{ $booking->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm uppercase tracking-[0.2em] text-gray-500">Status</p>
                                <span class="badge {{ $booking->status_badge_class }} mt-1">{{ $booking->status_label }}</span>
                                @if($booking->review)
                                    <p class="mt-2 text-sm font-semibold text-green-600"><i class="bi bi-check-circle me-1"></i> Review Diberikan</p>
                                @elseif($booking->canBeReviewed())
                                    <p class="mt-2 text-sm text-gray-600">Review sudah bisa diberikan</p>
                                @else
                                    <p class="mt-2 text-sm text-gray-600">Review terkunci sampai booking selesai</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 grid gap-4 md:grid-cols-2">
                            <div class="rounded-[1.5rem] bg-[#F8F2F0] p-4">
                                <p class="text-sm font-semibold text-[#1B1B18]">Tanggal kunjungan</p>
                                <p class="mt-2 text-gray-700">{{ \Carbon\Carbon::parse($booking->visit_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="rounded-[1.5rem] bg-[#EFF6FF] p-4">
                                <p class="text-sm font-semibold text-[#1B1B18]">Jumlah pengunjung</p>
                                <p class="mt-2 text-gray-700">{{ $booking->guests }} orang</p>
                            </div>
                        </div>
                        <div class="mt-5 text-gray-600">
                            <p class="font-semibold">Catatan</p>
                            <p class="mt-2">{{ $booking->message ?: 'Tidak ada catatan tambahan.' }}</p>
                        </div>
                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('profile.booking-detail', $booking) }}" class="inline-block rounded-full bg-[#F53003] px-6 py-2 text-sm font-semibold text-white hover:bg-[#d13202]">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
