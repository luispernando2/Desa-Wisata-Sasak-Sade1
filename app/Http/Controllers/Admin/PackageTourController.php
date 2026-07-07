<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\PackageTour;
use App\Models\TourGuide;
use App\Traits\LogActivity;
use Illuminate\Http\Request;

class PackageTourController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.packages.index', ['packages' => PackageTour::orderBy('created_at', 'desc')->get()]);
    }

    public function create()
    {
        return view('admin.packages.create', [
            'tourGuides' => TourGuide::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'tour_guide_id' => 'nullable|exists:tour_guides,id',
        ]);

        $package = PackageTour::create($data);

        $this->logActivity(
            'create',
            'packages',
            "Paket wisata '{$data['title']}' ditambahkan",
            $package->id,
            null,
            $data
        );

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil ditambahkan.');
    }

    public function edit(PackageTour $package)
    {
        return view('admin.packages.edit', [
            'package' => $package,
            'tourGuides' => TourGuide::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, PackageTour $package)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'tour_guide_id' => 'nullable|exists:tour_guides,id',
        ]);

        $oldValues = $package->toArray();
        $package->update($data);

        $this->logActivity(
            'update',
            'packages',
            "Paket wisata '{$package->title}' diperbarui",
            $package->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil diperbarui.');
    }

    public function destroy(PackageTour $package)
    {
        $packageTitle = $package->title;
        $packageId = $package->id;
        $oldValues = $package->toArray();
        $package->delete();

        $this->logActivity(
            'delete',
            'packages',
            "Paket wisata '{$packageTitle}' dihapus",
            $packageId,
            $oldValues,
            null
        );

        return redirect()->route('admin.packages.index')->with('success', 'Paket wisata berhasil dihapus.');
    }
}

