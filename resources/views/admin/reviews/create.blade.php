@extends('admin.layout')

@section('title', 'Tambah Review')
@section('subtitle', 'Tambahkan testimoni baru untuk ditampilkan di situs')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.reviews.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Pengunjung</label>
                    <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" class="form-control @error('visitor_name') is-invalid @enderror" required>
                    @error('visitor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Event</label>
                    <select name="event_id" class="form-select @error('event_id') is-invalid @enderror">
                        <option value="">- Pilih Event (Opsional) -</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }} ({{ \Carbon\Carbon::parse($event->date)->format('d M Y') }})</option>
                        @endforeach
                    </select>
                    @error('event_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} bintang</option>
                        @endfor
                    </select>
                    @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Komentar</label>
                    <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment') }}</textarea>
                    @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.reviews.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
