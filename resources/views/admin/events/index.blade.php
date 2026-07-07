@extends('admin.layout')

@section('title', 'Events')
@section('subtitle', 'Kelola jadwal pertunjukan dan kegiatan budaya')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.events.create') }}" class="btn-add"><i class="bi bi-plus"></i> Tambah Event</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th>Tour Guide</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        <tr>
                            <td>
                                @if($event->image_path)
                                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}" style="height: 50px; width: 50px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td>{{ $event->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                            <td>{{ $event->time }}</td>
                            <td><span class="badge {{ $event->status_badge_class }}">{{ $event->status_label }}</span></td>
                            <td>{{ $event->tourGuide->name ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
