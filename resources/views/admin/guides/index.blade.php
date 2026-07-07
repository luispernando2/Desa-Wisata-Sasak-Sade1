@extends('admin.layout')

@section('title', 'Tour Guide')
@section('subtitle', 'Kelola pemandu wisata desa Sasak Sade')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.guides.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Guide
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Kontak</th>
                        <th>Bahasa</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guides as $guide)
                        <tr>
                            <td>{{ $guide->name }}</td>
                            <td>{{ $guide->phone }}</td>
                            <td>{{ $guide->languages }}</td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.guides.edit', $guide) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.guides.destroy', $guide) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tour guide ini?');">
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
                            <td colspan="4" class="text-center text-muted py-4">Belum ada tour guide.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
