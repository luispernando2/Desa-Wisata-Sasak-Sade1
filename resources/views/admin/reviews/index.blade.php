@extends('admin.layout')

@section('title', 'Reviews')
@section('subtitle', 'Kelola testimonial dan rating pengunjung')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.reviews.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Review
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Pengunjung</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->visitor_name }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $review->rating }}/5</span></td>
                            <td class="line-clamp">{{ \Illuminate\Support\Str::limit($review->comment, 80) }}</td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.reviews.edit', $review) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus review ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada review.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
