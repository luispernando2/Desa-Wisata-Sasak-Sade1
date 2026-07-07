<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\HeroImage;
use App\Models\HomepageContent;
use App\Models\PackageTour;
use App\Models\Product;
use App\Models\Review;
use App\Traits\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HomepageContentController extends AdminController
{
    use LogActivity;

    public function previewDashboard()
    {
        if (! Schema::hasTable('homepage_contents')) {
            abort(404);
        }

        $contents = HomepageContent::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $homepageByKey = $contents->keyBy('key');
        $homepageGroups = $contents->groupBy('group');

        $heroSlides = HeroImage::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (HeroImage $image) => [
                'src' => $image->image_src,
                'title' => $image->title,
                'subtitle' => $image->subtitle,
            ])
            ->values();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect(['sade3.png', 'sade2.png', 'sade4.png', 'sade1.png', 'sade5.jpeg', 'sade6.jpeg'])
                ->map(fn (string $image) => [
                    'src' => asset('images/' . $image),
                    'title' => 'Desa Sasak Sade',
                    'subtitle' => null,
                ])
                ->values();
        }

        return view('admin.homepage-contents.preview-dashboard', [
            'homepageByKey' => $homepageByKey,
            'homepageGroups' => $homepageGroups,
            'heroSlides' => $heroSlides,
            'packages' => PackageTour::orderBy('price')->get(),
            'events' => Event::with(['tourGuide', 'reviews'])->orderBy('date')->get(),
            'products' => Product::where('stock', '>', 0)->get(),
            'galleries' => Gallery::orderBy('uploaded_at', 'desc')->get(),
            'reviews' => Review::orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function index()
    {
        return view('admin.homepage-contents.index', [
            'contents' => HomepageContent::ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.homepage-contents.create', [
            'groupOptions' => HomepageContent::groupOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('homepage-contents', 'public');
        }

        $content = HomepageContent::create($data);

        $this->logActivity(
            'create',
            'homepage_contents',
            'Konten beranda baru ditambahkan',
            $content->id,
            null,
            $content->toArray()
        );

        return redirect()->route('admin.homepage-contents.index')->with('success', 'Konten beranda berhasil ditambahkan.');
    }

    public function edit(HomepageContent $homepageContent)
    {
        return view('admin.homepage-contents.edit', [
            'content' => $homepageContent,
            'groupOptions' => HomepageContent::groupOptions(),
        ]);
    }

    public function update(Request $request, HomepageContent $homepageContent)
    {
        $data = $this->validatedData($request, $homepageContent);

        if ($request->boolean('remove_image') && $homepageContent->image_path) {
            Storage::disk('public')->delete($homepageContent->image_path);
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($homepageContent->image_path) {
                Storage::disk('public')->delete($homepageContent->image_path);
            }

            $data['image_path'] = $request->file('image')->store('homepage-contents', 'public');
        }

        $oldValues = $homepageContent->toArray();
        $homepageContent->update($data);

        $this->logActivity(
            'update',
            'homepage_contents',
            'Konten beranda diperbarui',
            $homepageContent->id,
            $oldValues,
            $homepageContent->fresh()->toArray()
        );

        return redirect()->route('admin.homepage-contents.index')->with('success', 'Konten beranda berhasil diperbarui.');
    }

    public function destroy(HomepageContent $homepageContent)
    {
        $contentId = $homepageContent->id;
        $oldValues = $homepageContent->toArray();

        if ($homepageContent->image_path) {
            Storage::disk('public')->delete($homepageContent->image_path);
        }

        $homepageContent->delete();

        $this->logActivity(
            'delete',
            'homepage_contents',
            'Konten beranda dihapus',
            $contentId,
            $oldValues,
            null
        );

        return redirect()->back()->with('success', 'Konten beranda berhasil dihapus.');
    }

    private function validatedData(Request $request, ?HomepageContent $homepageContent = null): array
    {
        $data = $request->validate([
            'group' => ['required', 'string', 'max:80'],
            'key' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z0-9._-]+$/i',
                Rule::unique('homepage_contents', 'key')->ignore($homepageContent?->id),
            ],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:80'],
            'button_label' => ['nullable', 'string', 'max:120'],
            'button_url' => ['nullable', 'string', 'max:2048'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:4096'],
            'meta' => ['nullable', 'string'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['meta'] = $this->decodeMeta($request->input('meta'));




        return $data;
    }

    private function decodeMeta(...$args): ?array
    {
        $value = $args[0] ?? null;

        if (blank($value)) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw ValidationException::withMessages([
                'meta' => 'Meta harus berupa JSON object atau array yang valid.',
            ]);
        }

        return $decoded;
    }
}
