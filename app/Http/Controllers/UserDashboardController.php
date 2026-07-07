<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\PackageTour;
use App\Models\Review;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $authUser = $request->session()->get('auth_user');

        if (! $authUser) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userBookings = Booking::where('user_id', $authUser['id'])->with(['package', 'review'])->latest()->get();
        $totalBookings = $userBookings->count();
        $lastBooking = $userBookings->first();
        $favoritePackageCount = PackageTour::count();
        $averageRating = Review::avg('rating') ? number_format(Review::avg('rating'), 1) : '0.0';
        
        // Get recent admin activities
        $recentActivities = ActivityLog::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.user', [
            'userName' => $authUser['name'],
            'userBookings' => $userBookings,
            'totalBookings' => $totalBookings,
            'lastBooking' => $lastBooking,
            'favoritePackageCount' => $favoritePackageCount,
            'averageRating' => $averageRating,
            'bookingNotificationCount' => $totalBookings,
            'recentActivities' => $recentActivities,
        ]);
    }
}
