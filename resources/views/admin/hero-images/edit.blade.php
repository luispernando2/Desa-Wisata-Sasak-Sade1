@extends('admin.layout')

@section('title', 'Edit Gambar Hero')
@section('subtitle', 'Perbarui gambar, status, dan urutan slider hero')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.hero-images.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <form action="{{ route('admin.hero-images.update', $heroImage) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Judul Gambar</label>
                                <input type="text" name="title" value="{{ old('title', $heroImage->title) }}" class="form-control @error('title') is-invalid @enderror">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" value="{{ old('sort_order', $heroImage->sort_order) }}" min="0" class="form-control @error('sort_order') is-invalid @enderror">
                                @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="form-label">Subtitle / Catatan Singkat</label>
                            <input type="text" name="subtitle" value="{{ old('subtitle', $heroImage->subtitle) }}" class="form-control @error('subtitle') is-invalid @enderror">
                            @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', $heroImage->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Tampilkan di hero beranda
                            </label>
                        </div>

                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Preview Gambar</h6>
                <img src="{{ $heroImage->image_src }}" alt="{{ $heroImage->title ?? 'Hero image' }}" class="img-fluid rounded mb-3" style="max-height: 260px; width: 100%; object-fit: cover;">

                <dl class="detail-list">
                    <dt>Judul</dt>
                    <dd>{{ $heroImage->title ?: '-' }}</dd>
                    <dt>Subtitle</dt>
                    <dd>{{ $heroImage->subtitle ?: '-' }}</dd>
                    <dt>Status</dt>
                    <dd>{{ $heroImage->is_active ? 'Aktif' : 'Nonaktif' }}</dd>
                    <dt>Path</dt>
                    <dd class="small text-muted">{{ $heroImage->image_path }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
