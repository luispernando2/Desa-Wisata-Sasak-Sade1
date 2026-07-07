@extends('admin.layout')

@section('title', 'Edit Galeri')
@section('subtitle', 'Perbarui data gambar atau deskripsi galeri')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.galleries.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                            <small class="text-muted">Biarkan kosong jika tidak mengubah gambar.</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" name="caption" value="{{ old('caption', $gallery->caption) }}" class="form-control @error('caption') is-invalid @enderror">
                            @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Preview Gambar</h6>
                @if($gallery->image_url)
                    <img src="{{ $gallery->image_url }}" alt="Galeri {{ $gallery->caption }}" class="img-fluid rounded mb-3" style="max-height: 240px; width: 100%; object-fit: cover;">
                @endif
                <dl class="detail-list">
                    <dt>Keterangan</dt>
                    <dd>{{ $gallery->caption ?? '-' }}</dd>
                    <dt>URL</dt>
                    <dd class="small text-muted">{{ $gallery->image_url }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
