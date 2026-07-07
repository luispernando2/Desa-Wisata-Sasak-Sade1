<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\PackageTour;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function destroy(Request $request, Review $review)
    {
        $sessionUser = $request->session()->get('auth_user');

        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = $sessionUser['id'] ?? null;

        if (! $userId || (int) ($review->user_id ?? 0) !== (int) $userId) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus review ini.');
        }

        $review->delete();

        // redirect tergantung review terkait event/paket
        if (! blank($review->event_id)) {
            return redirect()->route('events.show', $review->event_id)->with('success', 'Review berhasil dihapus.');
        }

        if (! blank($review->package_id)) {
            return redirect()->route('packages.show', $review->package_id)->with('success', 'Review berhasil dihapus.');
        }

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }

    public function store(Request $request)

    {
        $sessionUser = $request->session()->get('auth_user');


        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberi review.');
        }

        $userId = $sessionUser['id'] ?? null;

        if (! $userId || ! Booking::where('user_id', $userId)->where('status', Booking::STATUS_COMPLETED)->exists()) {
            return back()->withInput()->with('error', 'Review hanya bisa diberikan setelah booking Anda berstatus selesai.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $data['visitor_name'] = $sessionUser['name'] ?? 'Pengunjung';
        $data['user_id'] = $userId;

        Review::create($data);

        return redirect()->route('reviews.index')->with('success', 'Terima kasih. Ulasan Anda telah tersimpan.');
    }

    public function storePackageReview(Request $request, \App\Models\PackageTour $package)
    {

        $sessionUser = session('auth_user');

        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberi review.');
        }

        $userId = $sessionUser['id'] ?? null;

        if (! $userId) {
            return redirect()->back()->with('error', 'Data review tidak valid (user null).');
        }

        // Syarat: user punya booking completed
        if (! Booking::where('user_id', $userId)->where('status', Booking::STATUS_COMPLETED)->exists()) {
            return redirect()->route('packages.show', $package)
                ->with('error', 'Review paket hanya bisa diberikan setelah booking Anda berstatus selesai.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $data['package_id'] = $package->id;
        $data['user_id'] = $userId;
        $data['visitor_name'] = $sessionUser['name'] ?? 'Pengunjung';

        $review = Review::updateOrCreate(
            [
                'package_id' => $package->id,
                'user_id' => $userId,
            ],
            $data
        );

        return redirect()->route('packages.show', $package)
            ->with('success', 'Terima kasih. Review paket Anda telah tersimpan.');
    }


    public function storeEventReview(Request $request, Event $event)
    {
        $sessionUser = session('auth_user');

        if (! $sessionUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memberi review.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $eventId = $event->id;
        $userId = $sessionUser['id'] ?? null;

        if (! $eventId || ! $userId) {
            return redirect()->to('/events/'.$eventId)
                ->with('error', 'Data review tidak valid (event/user null).');
        }

        if (! Booking::where('user_id', $userId)->where('status', Booking::STATUS_COMPLETED)->exists()) {
            return redirect()->route('events.show', $event)
                ->with('error', 'Review event hanya bisa diberikan setelah ada booking Anda yang berstatus selesai.');
        }

        $data['event_id'] = $eventId;
        $data['user_id'] = $userId;
        $data['visitor_name'] = $sessionUser['name'] ?? 'Pengunjung';

        try {
            $review = Review::updateOrCreate(
                [
                    'event_id' => $eventId,
                    'user_id' => $userId,
                ],
                $data
            );
        } catch (\Throwable $e) {
            return redirect()->route('events.show', $eventId)
                ->with('error', 'Gagal menyimpan review. '.$e->getMessage());
        }

        if (! $review) {
            return redirect()->route('events.show', $eventId)
                ->with('error', 'Gagal menyimpan review (Review::create returned null).');
        }

        return redirect()->route('events.show', $eventId)
            ->with('success', 'Terima kasih. Review event Anda telah tersimpan.');

    }
}
