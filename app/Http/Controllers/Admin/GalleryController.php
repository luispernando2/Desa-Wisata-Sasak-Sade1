<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Gallery;
use App\Traits\LogActivity;
use Illuminate\Http\Request;


class GalleryController extends AdminController
{
    use LogActivity;

    public function index()
    {
        return view('admin.galleries.index', ['galleries' => Gallery::orderBy('uploaded_at', 'desc')->get()]);
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('galleries', 'public');
        // kolom di database: galleries.image_url
        $data['image_url'] = 'galleries/' . basename($imagePath);



        $data['uploaded_at'] = now();
        $gallery = Gallery::create($data);

        $this->logActivity(
            'create',
            'galleries',
            "Galeri baru ditambahkan",
            $gallery->id,
            null,
            $data
        );

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'caption' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // file lama dihapus berdasarkan image_url (kolom DB)
            if ($gallery->image_url) {
                $oldRelativePath = preg_replace('#^galleries/#', '', $gallery->image_url);
                $oldFullPath = storage_path('app/public/galleries/' . $oldRelativePath);
                if (file_exists($oldFullPath)) {
                    @unlink($oldFullPath);
                }
            }

            $imagePath = $request->file('image')->store('galleries', 'public');
            // simpan hanya nama path folder/filename sesuai kolom DB image_url
            $data['image_url'] = 'galleries/' . basename($imagePath);
        }



        $oldValues = $gallery->toArray();
        $gallery->update($data);

        $this->logActivity(
            'update',
            'galleries',
            "Galeri diperbarui",
            $gallery->id,
            $oldValues,
            $data
        );

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $galleryId = $gallery->id;
        $oldValues = $gallery->toArray();

        // gunakan disk public untuk hapus file gambar galeri
        if ($gallery->image_path && file_exists(storage_path('app/public/' . $gallery->image_path))) {
            @unlink(storage_path('app/public/' . $gallery->image_path));
        }


        $gallery->delete();

        $this->logActivity(
            'delete',
            'galleries',
            "Galeri dihapus",
            $galleryId,
            $oldValues,
            null
        );

        return redirect()->route('admin.galleries.index')->with('success', 'Galeri berhasil dihapus.');
    }
}

