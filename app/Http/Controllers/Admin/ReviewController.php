<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Review;
use App\Models\Event;
use App\Traits\LogActivity;
use Illuminate\Http\Request;

class ReviewController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.reviews.index', ['reviews' => Review::orderBy('created_at', 'desc')->get()]);
    }

    public function create()
    {
        $events = Event::all();
        return view('admin.reviews.create', compact('events'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $review = Review::create($data);

        $this->logActivity(
            'create',
            'reviews',
            "Review dari '{$data['visitor_name']}' ditambahkan",
            $review->id,
            null,
            $data
        );

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        $events = Event::all();
        return view('admin.reviews.edit', compact('review', 'events'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'visitor_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $oldValues = $review->toArray();
        $review->update($data);

        $this->logActivity(
            'update',
            'reviews',
            "Review diperbarui",
            $review->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        $reviewId = $review->id;
        $oldValues = $review->toArray();
        $review->delete();

        $this->logActivity(
            'delete',
            'reviews',
            "Review dihapus",
            $reviewId,
            $oldValues,
            null
        );

        return redirect()->route('admin.reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
