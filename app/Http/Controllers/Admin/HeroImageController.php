<?php

namespace App\Http\Controllers\Admin;

use App\Models\HeroImage;
use App\Traits\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroImageController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.hero-images.index', [
            'heroImages' => HeroImage::orderBy('sort_order')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.hero-images.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data['image_path'] = $request->file('image')->store('hero-images', 'public');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        $heroImage = HeroImage::create($data);

        $this->logActivity(
            'create',
            'hero_images',
            'Gambar hero baru ditambahkan',
            $heroImage->id,
            null,
            $heroImage->toArray()
        );

        return redirect()->route('admin.hero-images.index')->with('success', 'Gambar hero berhasil ditambahkan.');
    }

    public function edit(HeroImage $heroImage)
    {
        return view('admin.hero-images.edit', compact('heroImage'));
    }

    public function update(Request $request, HeroImage $heroImage)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($heroImage->image_path && Storage::disk('public')->exists($heroImage->image_path)) {
                Storage::disk('public')->delete($heroImage->image_path);
            }

            $data['image_path'] = $request->file('image')->store('hero-images', 'public');
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        $oldValues = $heroImage->toArray();
        $heroImage->update($data);

        $this->logActivity(
            'update',
            'hero_images',
            'Gambar hero diperbarui',
            $heroImage->id,
            $oldValues,
            $heroImage->fresh()->toArray()
        );

        return redirect()->route('admin.hero-images.index')->with('success', 'Gambar hero berhasil diperbarui.');
    }

    public function destroy(HeroImage $heroImage)
    {
        $heroImageId = $heroImage->id;
        $oldValues = $heroImage->toArray();

        if ($heroImage->image_path && Storage::disk('public')->exists($heroImage->image_path)) {
            Storage::disk('public')->delete($heroImage->image_path);
        }

        $heroImage->delete();

        $this->logActivity(
            'delete',
            'hero_images',
            'Gambar hero dihapus',
            $heroImageId,
            $oldValues,
            null
        );

        return redirect()->route('admin.hero-images.index')->with('success', 'Gambar hero berhasil dihapus.');
    }
}
