@extends('admin.layout')

@section('title', 'Tambah Galeri')
@section('subtitle', 'Tambah foto wisata atau dokumentasi desa')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih File Gambar</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" required>
                    <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="caption" value="{{ old('caption') }}" class="form-control @error('caption') is-invalid @enderror">
                    @error('caption')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.galleries.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
