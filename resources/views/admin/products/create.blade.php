@extends('admin.layout')

@section('title', 'Tambah Produk')
@section('subtitle', 'Tambahkan produk market lokal baru')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" class="form-control @error('stock') is-invalid @enderror" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" required>
                    <small class="text-muted">Pilih dari device (Max 2MB)</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
