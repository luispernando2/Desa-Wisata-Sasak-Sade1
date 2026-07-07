@extends('admin.layout')

@section('title', 'Hero Beranda')
@section('subtitle', 'Kelola gambar slider hero yang tampil di halaman beranda')

@section('content')
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.hero-images.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Gambar Hero
        </a>

        <span class="text-muted small">
            Gambar aktif akan dipakai otomatis sebagai background dan kartu slider hero.
        </span>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 130px;">Gambar</th>
                        <th>Judul</th>
                        <th>Subtitle</th>
                        <th style="width: 110px;">Urutan</th>
                        <th style="width: 110px;">Status</th>
                        <th class="text-end" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heroImages as $heroImage)
                        <tr>
                            <td>
                                <img src="{{ Storage::url($heroImage->image_path) }}" alt="{{ $heroImage->title ?? 'Hero image' }}" class="table-thumb">
                            </td>
                            <td>
                                <strong>{{ $heroImage->title ?: 'Tanpa judul' }}</strong>
                            </td>
                            <td class="line-clamp">
                                {{ $heroImage->subtitle ?: '-' }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $heroImage->sort_order }}</span>
                            </td>
                            <td>
                                @if($heroImage->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.hero-images.edit', $heroImage) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.hero-images.destroy', $heroImage) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus gambar hero ini?');">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada gambar hero. Hero masih memakai gambar bawaan dari folder public/images.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
