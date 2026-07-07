@extends('admin.layout')

@section('title', 'Tambah Gambar Hero')
@section('subtitle', 'Upload gambar baru untuk slider hero halaman beranda')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <a href="{{ route('admin.hero-images.index') }}" class="btn-cancel mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('admin.hero-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Gambar Hero</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" required>
                    <small class="text-muted">Rekomendasi: gambar landscape lebar, minimal 1600x900. Format JPG, PNG, GIF, WEBP. Maks 4MB.</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Judul Gambar</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Rumah Adat Sasak">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="form-control @error('sort_order') is-invalid @enderror">
                        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label">Subtitle / Catatan Singkat</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="form-control @error('subtitle') is-invalid @enderror" placeholder="Contoh: Suasana desa adat yang masih terjaga">
                    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">
                        Tampilkan di hero beranda
                    </label>
                </div>

                <div>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <a href="{{ route('admin.hero-images.index') }}" class="btn-cancel ms-2">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
