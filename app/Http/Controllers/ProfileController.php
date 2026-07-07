<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected function user(Request $request): ?User
    {
        $auth = $request->session()->get('auth_user');

        if (! $auth) {
            return null;
        }

        return User::find($auth['id']);
    }

    public function index(Request $request)
    {
        $user = $this->user($request);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bookings = Booking::where('user_id', $user->id)->with(['package', 'review'])->latest()->get();

        return view('profile.index', [
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }

    public function bookings(Request $request)
    {
        $user = $this->user($request);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bookings = Booking::where('user_id', $user->id)->with(['package', 'review'])->latest()->get();

        return view('profile.bookings', [
            'user' => $user,
            'bookings' => $bookings,
        ]);
    }

    public function bookingDetail(Request $request, Booking $booking)
    {
        $user = $this->user($request);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($booking->user_id !== $user->id) {
            return redirect()->route('profile.bookings')->with('error', 'Anda tidak diizinkan mengakses booking ini.');
        }

        $booking->load('package', 'review.user');
        return view('profile.booking-detail', compact('booking', 'user'));
    }
}
