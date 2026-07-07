@extends('admin.layout')

@section('title', 'Paket Wisata')
@section('subtitle', 'Kelola paket tour yang ditawarkan')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.packages.create') }}" class="btn-add"><i class="bi bi-plus"></i> Tambah Paket</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $package)
                        <tr>
                            <td>{{ $package->title }}</td>
                            <td>Rp{{ number_format($package->price, 0, ',', '.') }}</td>
                            <td>{{ $package->duration }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.packages.edit', $package) }}" class="btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Belum ada paket wisata.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
