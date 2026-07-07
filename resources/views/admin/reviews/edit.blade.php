@extends('admin.layout')

@section('title', 'Edit Review')
@section('subtitle', 'Perbarui testimoni pengunjung yang sudah ada')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.reviews.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Pengunjung</label>
                            <input type="text" name="visitor_name" value="{{ old('visitor_name', $review->visitor_name) }}" class="form-control @error('visitor_name') is-invalid @enderror" required>
                            @error('visitor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event</label>
                            <select name="event_id" class="form-select @error('event_id') is-invalid @enderror">
                                <option value="">- Pilih Event (Opsional) -</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id', $review->event_id) == $event->id ? 'selected' : '' }}>{{ $event->name }} ({{ \Carbon\Carbon::parse($event->date)->format('d M Y') }})</option>
                                @endforeach
                            </select>
                            @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                                @endfor
                            </select>
                            @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Komentar</label>
                            <textarea name="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Review Saat Ini</h6>
                <dl class="detail-list">
                    <dt>Nama</dt>
                    <dd>{{ $review->visitor_name }}</dd>
                    <dt>Event</dt>
                    <dd>{{ $review->event->name ?? '-' }}</dd>
                    <dt>Rating</dt>
                    <dd>{{ $review->rating }} / 5</dd>
                    <dt>Komentar</dt>
                    <dd>{{ $review->comment }}</dd>
                    <dt>Dibuat</dt>
                    <dd>{{ $review->created_at->format('d M Y') }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
