@extends('admin.layout')

@section('title', 'Tambah Tour Guide')
@section('subtitle', 'Tambahkan pemandu wisata baru untuk pendampingan pengunjung')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.guides.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Bahasa</label>
                        <input type="text" name="languages" value="{{ old('languages') }}" class="form-control @error('languages') is-invalid @enderror" required>
                        @error('languages')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi Singkat</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.guides.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
