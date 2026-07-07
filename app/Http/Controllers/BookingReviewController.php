<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingReview;
use Illuminate\Http\Request;

class BookingReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        $sessionUser = $request->session()->get('auth_user');

        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberi review.');
        }

        $userId = $sessionUser['id'] ?? null;

        if (! $userId || (int) $booking->user_id !== (int) $userId) {
            return redirect()->route('profile.bookings')->with('error', 'Anda tidak diizinkan memberi review untuk booking ini.');
        }

        if (! $booking->canBeReviewed()) {
            return back()->with('error', 'Review hanya bisa diberikan setelah admin menandai booking Anda selesai.');
        }

        if ($booking->review()->exists()) {
            return back()->with('error', 'Anda sudah memberikan review untuk booking ini.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $data['booking_id'] = $booking->id;
        $data['user_id'] = $userId;

        // 1) Simpan review booking (tabel BookingReview)
        BookingReview::create($data);

        // 2) Sync juga ke tabel reviews untuk review paket wisata
        // Agar tampil di resources/views/packages/show.blade.php (paket detail)
        \App\Models\Review::updateOrCreate(
            [
                'package_id' => $booking->package_id,
                'user_id' => $userId,
            ],
            [
                'visitor_name' => $sessionUser['name'] ?? 'Pengunjung',
                'event_id' => null,
                'rating' => $data['rating'],
                'comment' => $data['comment'],
                'package_id' => $booking->package_id,
                'user_id' => $userId,
            ]
        );

        return back()->with('success', 'Terima kasih. Review booking Anda telah terkirim.');
    }

    public function destroy(Request $request, BookingReview $review)
    {
        $sessionUser = $request->session()->get('auth_user');

        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $review->load('booking');

        if ((int) $review->booking->user_id !== (int) ($sessionUser['id'] ?? 0)) {
            return redirect()->route('profile.bookings')->with('error', 'Anda tidak diizinkan menghapus review ini.');
        }

        // Saat review booking dihapus, pastikan juga review paketnya ikut hilang.
        // Review paket memakai model Review (tabel reviews) dengan package_id + user_id.
        $packageId = $review->booking->package_id;
        $userId = $review->booking->user_id;

        // hapus review booking
        $review->delete();

        // hapus review paket (kalau ada)
        \App\Models\Review::where('package_id', $packageId)
            ->where('user_id', $userId)
            ->whereNull('event_id')
            ->delete();

        return back()->with('success', 'Review berhasil dihapus.');
    }
}
