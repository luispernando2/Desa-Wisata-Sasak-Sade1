@extends('admin.layout')

@section('title', 'Galeri')
@section('subtitle', 'Kelola foto dan gambar wisata desa')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.galleries.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Galeri
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 120px;">Gambar</th>
                        <th>Keterangan</th>
                        <th style="width: 180px;">Tanggal Upload</th>
                        <th class="text-end" style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $gallery)
                        <tr>
                            <td>
                                @if($gallery->image_url)
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->caption }}" class="table-thumb">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td>{{ $gallery->caption ?? 'Tanpa Keterangan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($gallery->uploaded_at)->format('d M Y') }}</td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus galeri ini?');">
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
                            <td colspan="4" class="text-center text-muted py-4">Belum ada galeri.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
