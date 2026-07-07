<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\TourGuide;
use App\Traits\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.events.index', ['events' => Event::with('tourGuide')->orderBy('date', 'desc')->get()]);
    }

    public function create()
    {
        $tourGuides = TourGuide::all();
        $statusOptions = Event::statusOptions();

        return view('admin.events.create', compact('tourGuides', 'statusOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'nullable|string|max:255',
            'tour_guide_id' => 'nullable|exists:tour_guides,id',
            'status' => ['required', Rule::in(array_keys(Event::statusOptions()))],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image_path'] = $imagePath;
        }

        $event = Event::create($data);

        $this->logActivity(
            'create',
            'events',
            "Event '{$data['name']}' ditambahkan",
            $event->id,
            null,
            $data
        );

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        $tourGuides = TourGuide::all();
        $statusOptions = Event::statusOptions();

        return view('admin.events.edit', compact('event', 'tourGuides', 'statusOptions'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'nullable|string|max:255',
            'tour_guide_id' => 'nullable|exists:tour_guides,id',
            'status' => ['required', Rule::in(array_keys(Event::statusOptions()))],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($event->image_path && \Storage::disk('public')->exists($event->image_path)) {
                \Storage::disk('public')->delete($event->image_path);
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $data['image_path'] = $imagePath;
        }

        $oldValues = $event->toArray();
        $event->update($data);

        $this->logActivity(
            'update',
            'events',
            "Event '{$event->name}' diperbarui",
            $event->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $eventName = $event->name;
        $eventId = $event->id;
        $oldValues = $event->toArray();

        if ($event->image_path && \Storage::disk('public')->exists($event->image_path)) {
            \Storage::disk('public')->delete($event->image_path);
        }

        $event->delete();

        $this->logActivity(
            'delete',
            'events',
            "Event '{$eventName}' dihapus",
            $eventId,
            $oldValues,
            null
        );

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
