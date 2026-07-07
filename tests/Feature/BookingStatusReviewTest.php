<?php

use App\Models\Booking;
use App\Models\PackageTour;
use App\Models\User;

function makePackageTour(): PackageTour
{
    return PackageTour::create([
        'title' => 'Paket Test',
        'price' => 150000,
        'duration' => '2 jam',
        'description' => 'Paket untuk pengujian.',
        'features' => 'Guide lokal',
    ]);
}

test('booking review is only accepted after booking is completed', function () {
    $user = User::factory()->create();
    $package = makePackageTour();
    $booking = Booking::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => '081234567890',
        'package_id' => $package->id,
        'visit_date' => now()->subDay()->toDateString(),
        'guests' => 2,
        'message' => 'Test booking',
        'status' => Booking::STATUS_PENDING,
    ]);

    $this->withSession(['auth_user' => ['id' => $user->id, 'name' => $user->name, 'role' => 'user']])
        ->post(route('bookings.review.store', $booking), [
            'rating' => 5,
            'comment' => 'Kunjungan menyenangkan.',
        ])
        ->assertSessionHas('error');

    $this->assertDatabaseMissing('booking_reviews', [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
    ]);

    $booking->update(['status' => Booking::STATUS_COMPLETED]);

    $this->withSession(['auth_user' => ['id' => $user->id, 'name' => $user->name, 'role' => 'user']])
        ->post(route('bookings.review.store', $booking), [
            'rating' => 5,
            'comment' => 'Kunjungan menyenangkan.',
        ])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('booking_reviews', [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'rating' => 5,
    ]);
});

test('admin can delete booking only after it is completed', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();
    $package = makePackageTour();
    $booking = Booking::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone' => '081234567890',
        'package_id' => $package->id,
        'visit_date' => now()->subDay()->toDateString(),
        'guests' => 2,
        'message' => 'Test booking',
        'status' => Booking::STATUS_PENDING,
    ]);

    $adminSession = ['auth_user' => ['id' => $admin->id, 'name' => $admin->name, 'role' => 'admin']];

    $this->withSession($adminSession)
        ->delete(route('admin.bookings.destroy', $booking))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('bookings', ['id' => $booking->id]);

    $this->withSession($adminSession)
        ->patch(route('admin.bookings.update-status', $booking), [
            'status' => Booking::STATUS_COMPLETED,
        ])
        ->assertSessionHas('success');

    $this->withSession($adminSession)
        ->delete(route('admin.bookings.destroy', $booking->fresh()))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
});
