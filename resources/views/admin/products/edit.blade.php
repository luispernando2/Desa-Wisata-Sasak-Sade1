@extends('admin.layout')

@section('title', 'Edit Produk')
@section('subtitle', 'Perbarui data produk market lokal')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror" required>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="form-control @error('stock') is-invalid @enderror" required>
                                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ganti Gambar (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Detail Produk</h6>
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3" style="max-height: 220px; width: 100%; object-fit: cover;">
                @endif
                <h5 class="mb-3">{{ $product->name }}</h5>
                <dl class="detail-list">
                    <dt>Harga</dt>
                    <dd>Rp{{ number_format($product->price, 0, ',', '.') }}</dd>
                    <dt>Stok</dt>
                    <dd>{{ $product->stock }}</dd>
                    <dt>URL</dt>
                    <dd class="small text-muted">{{ $product->image_url ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
