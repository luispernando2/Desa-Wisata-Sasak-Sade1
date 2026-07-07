@extends('admin.layout')

@section('title', 'Galeri')
@section('subtitle', 'Kelola foto dan gambar wisata desa')

@section('content')

    <!-- HEADER BUTTON -->
    <div class="mb-4">
        <a href="{{ route('admin.galleries.create') }}" class="btn-add">
            <i class="bi bi-plus"></i>
            Tambah Galeri
        </a>
    </div>

    <!-- CARD TABLE -->
    <div class="card shadow-sm border-0">

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

                            <!-- IMAGE -->
                            <td>

                                @if($gallery->image_url)

                                    <img
                                        src="{{ $gallery->image_url }}"
                                        alt="{{ $gallery->caption }}"
                                        class="rounded-3 border"
                                        style="
                                            width: 90px;
                                            height: 65px;
                                            object-fit: cover;
                                        "
                                    >

                                @else

                                    <span class="badge bg-secondary">
                                        No Image
                                    </span>

                                @endif

                            </td>

                            <!-- CAPTION -->
                            <td>

                                <div class="fw-semibold text-dark">

                                    {{ $gallery->caption ?? 'Tanpa Keterangan' }}

                                </div>

                            </td>

                            <!-- DATE -->
                            <td>

                                {{ \Carbon\Carbon::parse($gallery->uploaded_at)->format('d M Y') }}

                            </td>

                            <!-- ACTION -->
                            <td class="text-end">

                                <a href="{{ route('admin.galleries.edit', $gallery) }}"
                                    class="btn-edit">

                                    <i class="bi bi-pencil"></i>
                                    Edit

                                </a>

                                <form
                                    action="{{ route('admin.galleries.destroy', $gallery) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Hapus galeri ini?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-delete">

                                        <i class="bi bi-trash"></i>
                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center text-muted py-5">

                                Belum ada galeri.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection