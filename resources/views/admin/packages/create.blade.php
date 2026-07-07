@extends('admin.layout')

@section('title', 'Tambah Paket Wisata')
@section('subtitle', 'Buat paket tour baru')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.packages.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Paket</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Durasi (cth: 3 hari)</label>
                        <input type="text" name="duration" value="{{ old('duration') }}" class="form-control @error('duration') is-invalid @enderror" required>
                        @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Fitur/Kegiatan</label>
                    <textarea name="features" rows="3" class="form-control @error('features') is-invalid @enderror">{{ old('features') }}</textarea>
                    @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tour Guide</label>
                    <select name="tour_guide_id" class="form-select @error('tour_guide_id') is-invalid @enderror">
                        <option value="">-- Pilih Tour Guide (opsional) --</option>
                        @foreach($tourGuides as $guide)
                            <option value="{{ $guide->id }}" {{ old('tour_guide_id') == $guide->id ? 'selected' : '' }}>
                                {{ $guide->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('tour_guide_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.packages.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
