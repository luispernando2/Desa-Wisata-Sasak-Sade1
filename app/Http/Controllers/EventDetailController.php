<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;

class EventDetailController extends Controller
{
    public function show(Event $event)
    {
        $event->load('tourGuide', 'reviews.user');
        $sessionUser = session('auth_user');
        $canReviewEvent = $sessionUser && isset($sessionUser['id'])
            ? Booking::where('user_id', $sessionUser['id'])->where('status', Booking::STATUS_COMPLETED)->exists()
            : false;

        return view('events.show', compact('event', 'canReviewEvent'));
    }
}
