@extends('admin.layout')

@section('title', 'Tambah Event')
@section('subtitle', 'Buat jadwal pertunjukan baru untuk situs')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Event</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" value="{{ old('date') }}" class="form-control @error('date') is-invalid @enderror" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Waktu</label>
                        <input type="time" name="time" value="{{ old('time') }}" class="form-control @error('time') is-invalid @enderror" required>
                        @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror">
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tour Guide</label>
                    <select name="tour_guide_id" class="form-control @error('tour_guide_id') is-invalid @enderror">
                        <option value="">- Pilih Tour Guide -</option>
                        @foreach($tourGuides as $guide)
                            <option value="{{ $guide->id }}" {{ old('tour_guide_id') == $guide->id ? 'selected' : '' }}>{{ $guide->name }}</option>
                        @endforeach
                    </select>
                    @error('tour_guide_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Status Event</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', \App\Models\Event::STATUS_SCHEDULED) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Event</label>
                    <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                    <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.events.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
