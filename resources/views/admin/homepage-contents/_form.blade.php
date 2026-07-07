@php
    $content = $content ?? null;
    $metaValue = old('meta');

    if ($metaValue === null && $content) {
        $metaValue = $content->meta ? json_encode($content->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : '';
    }
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Grup Konten</label>
        <select name="group" class="form-select @error('group') is-invalid @enderror" required>
            @foreach($groupOptions as $value => $label)
                <option value="{{ $value }}" @selected(old('group', $content->group ?? 'home_custom') === $value)>
                    {{ $label }} ({{ $value }})
                </option>
            @endforeach
        </select>
        @error('group')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Key Unik</label>
        <input type="text" name="key" value="{{ old('key', $content->key ?? '') }}" class="form-control @error('key') is-invalid @enderror" placeholder="contoh: home.custom.promo" required>
        <small class="text-muted">Pakai huruf, angka, titik, garis bawah, atau tanda minus. Key bawaan dipakai oleh layout.</small>
        @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Judul</label>
        <input type="text" name="title" value="{{ old('title', $content->title ?? '') }}" class="form-control @error('title') is-invalid @enderror">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Subtitle / Kicker / Meta Singkat</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', $content->subtitle ?? '') }}" class="form-control @error('subtitle') is-invalid @enderror">
        @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

@php
    $currentGroup = old('group', $content->group ?? 'home_custom');
    $metaJson = old('meta');
    $metaArr = [];

    if (!blank($metaJson)) {
        $metaArr = json_decode($metaJson, true) ?? [];
    } elseif ($content && is_array($content->meta)) {
        $metaArr = $content->meta;
    }
@endphp

<div class="mb-3 mt-3">
    <label class="form-label">Isi Konten</label>

    @if(in_array($currentGroup, ['home_intro']))
        <textarea
            name="meta[intro][lead]"
            rows="5"
            class="form-control font-monospace"
            placeholder="Isi lead/paragraph utama untuk Intro Beranda"
        >{{ old('meta[intro][lead]', data_get($metaArr, 'intro.lead', $content->body ?? '')) }}</textarea>
        <small class="text-muted">Untuk group home_intro, lead disimpan di meta->intro->lead.</small>

        @error('body')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    @else
        <textarea name="body" rows="5" class="form-control @error('body') is-invalid @enderror">{{ old('body', $content->body ?? '') }}</textarea>
        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @endif
</div>

<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Ikon Bootstrap</label>
        <input type="text" name="icon" value="{{ old('icon', $content->icon ?? '') }}" class="form-control @error('icon') is-invalid @enderror" placeholder="bi-images">
        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Label Tombol</label>
        <input type="text" name="button_label" value="{{ old('button_label', $content->button_label ?? '') }}" class="form-control @error('button_label') is-invalid @enderror" placeholder="Booking">
        @error('button_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">URL Tombol</label>
        <input type="text" name="button_url" value="{{ old('button_url', $content->button_url ?? '') }}" class="form-control @error('button_url') is-invalid @enderror" placeholder="route:booking.index atau /booking">
        <small class="text-muted">Bisa pakai `route:nama.route`, `/path`, `#anchor`, atau URL penuh.</small>
        @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-6">
        <label class="form-label">Upload Gambar</label>
        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
        <small class="text-muted">Opsional. Maks 4MB, JPG/PNG/GIF/WEBP.</small>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

        @if($content?->image_path)
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                <label class="form-check-label" for="remove_image">Hapus gambar upload saat ini</label>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label class="form-label">URL Gambar</label>
        <input type="text" name="image_url" value="{{ old('image_url', $content->image_url ?? '') }}" class="form-control @error('image_url') is-invalid @enderror" placeholder="images/sade1.png atau https://...">
        <small class="text-muted">Dipakai jika tidak ada gambar upload.</small>
        @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-md-4">
        <label class="form-label">Urutan</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $content->sort_order ?? 0) }}" min="0" class="form-control @error('sort_order') is-invalid @enderror">
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-8 d-flex align-items-end">
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $content->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Tampilkan di website</label>
        </div>
    </div>
</div>

<div class="mb-3 mt-3">
    <label class="form-label">Meta JSON</label>
    <textarea name="meta" rows="6" class="form-control font-monospace @error('meta') is-invalid @enderror" placeholder='{"secondary_button_label":"Kontak"}'>{{ $metaValue }}</textarea>
    <small class="text-muted">Opsional untuk field tambahan seperti tombol kedua, gambar kedua, copyright, atau teks khusus layout.</small>
    @error('meta')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

