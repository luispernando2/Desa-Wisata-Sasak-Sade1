@extends('admin.layout')

@section('title', 'Edit Event')
@section('subtitle', 'Perbarui data event pertunjukan')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-secondary mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Event</label>
                            <input type="text" name="name" value="{{ old('name', $event->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" value="{{ old('date', $event->date) }}" class="form-control @error('date') is-invalid @enderror" required>
                                @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Waktu</label>
                                <input type="time" name="time" value="{{ old('time', $event->time) }}" class="form-control @error('time') is-invalid @enderror" required>
                                @error('time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="location" value="{{ old('location', $event->location) }}" class="form-control @error('location') is-invalid @enderror">
                                @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tour Guide</label>
                            <select name="tour_guide_id" class="form-control @error('tour_guide_id') is-invalid @enderror">
                                <option value="">- Pilih Tour Guide -</option>
                                @foreach($tourGuides as $guide)
                                    <option value="{{ $guide->id }}" {{ old('tour_guide_id', $event->tour_guide_id) == $guide->id ? 'selected' : '' }}>{{ $guide->name }}</option>
                                @endforeach
                            </select>
                            @error('tour_guide_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Event</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $event->status) === $value)>{{ $label }}</option>
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
                            <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="card-title">Data Saat Ini</h6>
                    @if($event->image_path)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}" class="img-fluid rounded" style="max-height: 200px; object-fit: cover; width: 100%;">
                        </div>
                    @endif
                    <h5 class="mb-3">{{ $event->name }}</h5>
                    <dl class="row small">
                        <dt class="col-sm-4">Tanggal:</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</dd>
                        <dt class="col-sm-4">Waktu:</dt>
                        <dd class="col-sm-8">{{ $event->time }}</dd>
                        <dt class="col-sm-4">Lokasi:</dt>
                        <dd class="col-sm-8">{{ $event->location ?? '-' }}</dd>
                        <dt class="col-sm-4">Status:</dt>
                        <dd class="col-sm-8"><span class="badge {{ $event->status_badge_class }}">{{ $event->status_label }}</span></dd>
                        <dt class="col-sm-4">Guide:</dt>
                        <dd class="col-sm-8">{{ $event->tourGuide->name ?? '-' }}</dd>
                        <dt class="col-sm-4">Deskripsi:</dt>
                        <dd class="col-sm-8"><small class="text-muted">{{ substr($event->description, 0, 100) }}...</small></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
