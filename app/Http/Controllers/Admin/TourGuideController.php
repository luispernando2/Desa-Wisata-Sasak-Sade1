<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\TourGuide;
use App\Traits\LogActivity;
use Illuminate\Http\Request;

class TourGuideController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.guides.index', ['guides' => TourGuide::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.guides.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'languages' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $guide = TourGuide::create($data);

        $this->logActivity(
            'create',
            'guides',
            "Tour guide '{$data['name']}' ditambahkan",
            $guide->id,
            null,
            $data
        );

        return redirect()->route('admin.guides.index')->with('success', 'Tour guide berhasil ditambahkan.');
    }

    public function edit(TourGuide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, TourGuide $guide)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'languages' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $oldValues = $guide->toArray();
        $guide->update($data);

        $this->logActivity(
            'update',
            'guides',
            "Tour guide '{$guide->name}' diperbarui",
            $guide->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.guides.index')->with('success', 'Tour guide berhasil diperbarui.');
    }

    public function destroy(TourGuide $guide)
    {
        $guideName = $guide->name;
        $guideId = $guide->id;
        $oldValues = $guide->toArray();
        $guide->delete();

        $this->logActivity(
            'delete',
            'guides',
            "Tour guide '{$guideName}' dihapus",
            $guideId,
            $oldValues,
            null
        );

        return redirect()->route('admin.guides.index')->with('success', 'Tour guide berhasil dihapus.');
    }
}
