@extends('admin.layout')

@section('title', 'Edit Paket Wisata')
@section('subtitle', 'Perbarui informasi paket wisata')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.packages.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.packages.update', $package) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Paket</label>
                            <input type="text" name="title" value="{{ old('title', $package->title) }}" class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="price" value="{{ old('price', $package->price) }}" class="form-control @error('price') is-invalid @enderror" required>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Durasi</label>
                                <input type="text" name="duration" value="{{ old('duration', $package->duration) }}" class="form-control @error('duration') is-invalid @enderror" required>
                                @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $package->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fasilitas / Keterangan</label>
                            <textarea name="features" rows="4" class="form-control @error('features') is-invalid @enderror">{{ old('features', $package->features) }}</textarea>
                            @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tour Guide</label>
                            <select name="tour_guide_id" class="form-select @error('tour_guide_id') is-invalid @enderror">
                                <option value="">-- Pilih Tour Guide (opsional) --</option>
                                @foreach($tourGuides as $guide)
                                    <option value="{{ $guide->id }}" {{ (string)old('tour_guide_id', $package->tour_guide_id) === (string)$guide->id ? 'selected' : '' }}>
                                        {{ $guide->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tour_guide_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Ringkasan Paket</h6>
                <h5 class="mb-3">{{ $package->title }}</h5>
                <dl class="detail-list">
                    <dt>Harga</dt>
                    <dd>Rp {{ number_format($package->price, 0, ',', '.') }}</dd>
                    <dt>Durasi</dt>
                    <dd>{{ $package->duration }}</dd>
                    <dt>Deskripsi</dt>
                    <dd>{{ $package->description }}</dd>
                    <dt>Fasilitas</dt>
                    <dd>{{ $package->features ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
