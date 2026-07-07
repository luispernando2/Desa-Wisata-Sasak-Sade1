@extends('admin.layout')

@section('title', 'Edit Tour Guide')
@section('subtitle', 'Perbarui informasi pemandu wisata')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.guides.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.guides.update', $guide) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $guide->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="text" name="phone" value="{{ old('phone', $guide->phone) }}" class="form-control @error('phone') is-invalid @enderror" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bahasa</label>
                                <input type="text" name="languages" value="{{ old('languages', $guide->languages) }}" class="form-control @error('languages') is-invalid @enderror" required>
                                @error('languages')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $guide->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Detail Guide</h6>
                <h5 class="mb-3">{{ $guide->name }}</h5>
                <dl class="detail-list">
                    <dt>Kontak</dt>
                    <dd>{{ $guide->phone }}</dd>
                    <dt>Bahasa</dt>
                    <dd>{{ $guide->languages }}</dd>
                    <dt>Deskripsi</dt>
                    <dd>{{ $guide->description ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
