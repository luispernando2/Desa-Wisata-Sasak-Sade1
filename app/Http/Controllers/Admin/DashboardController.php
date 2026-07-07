<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\HeroImage;
use App\Models\PackageTour;
use App\Models\Product;
use App\Models\Review;
use App\Models\TourGuide;

class DashboardController extends AdminController
{
    public function index()
    {
        // Get recent activities
        $recentActivities = ActivityLog::orderBy('created_at', 'desc')
            ->limit(15)
            ->get();

        return view('admin.dashboard', [
            'events' => Event::count(),
            'heroImages' => HeroImage::count(),
            'galleries' => Gallery::count(),
            'packages' => PackageTour::count(),
            'guides' => TourGuide::count(),
            'products' => Product::count(),
            'contacts' => Contact::count(),
            'reviews' => Review::count(),
            'bookings' => Booking::count(),
            'recentActivities' => $recentActivities,
        ]);
    }
}

