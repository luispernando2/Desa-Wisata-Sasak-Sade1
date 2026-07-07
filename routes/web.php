<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroImageController;
use App\Http\Controllers\Admin\PackageTourController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\TourGuideController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingReviewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductPurchaseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/profile/bookings', [ProfileController::class, 'bookings'])->name('profile.bookings');
Route::get('/profile/bookings/{booking}', [ProfileController::class, 'bookingDetail'])->name('profile.booking-detail');

Route::get('/', [HomeController::class, 'index'])->name('home');

// pages from navbar
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/packages', [HomeController::class, 'packages'])->name('packages.index');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/market', [HomeController::class, 'market'])->name('market.index');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery.index');
Route::get('/reviews', [HomeController::class, 'reviews'])->name('reviews.index');
Route::get('/booking', [HomeController::class, 'booking'])->name('booking.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.index');

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/bookings/{booking}/review', [BookingReviewController::class, 'store'])->name('bookings.review.store');
Route::delete('/booking-reviews/{review}', [BookingReviewController::class, 'destroy'])->name('booking-reviews.destroy');
Route::post('/purchase-product', [ProductPurchaseController::class, 'store'])->name('product.purchase');
Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

// Review paket wisata
Route::post('/packages/{package}/review', [ReviewController::class, 'storePackageReview'])
    ->name('packages.review.store');

Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy');


Route::get('/packages/{package}', [\App\Http\Controllers\PackageDetailController::class, 'show'])
    ->name('packages.show');

Route::get('/events/{event}', [\App\Http\Controllers\EventDetailController::class, 'show'])
    ->name('events.show')
    ->middleware('web');

Route::post('/events/{event}/review', [ReviewController::class, 'storeEventReview'])
    ->name('events.review.store');

Route::prefix('admin')->name('admin.')->group(function () {



    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('hero-images', HeroImageController::class)->except(['show']);
    Route::resource('events', EventController::class)->except(['show']);
    Route::resource('galleries', GalleryController::class)->except(['show']);
    Route::resource('packages', PackageTourController::class)->except(['show']);
    Route::resource('guides', TourGuideController::class)->except(['show']);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('reviews', AdminReviewController::class)->except(['show']);
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update-status');
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'show', 'destroy']);
    Route::resource('contacts', ContactController::class)->except(['show']);
});
