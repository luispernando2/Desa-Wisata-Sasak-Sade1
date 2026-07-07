@extends('admin.layout')

@section('title', 'Konten Beranda')
@section('subtitle', 'Kelola teks, tombol, ikon, gambar, urutan, dan blok tambahan yang tampil di halaman beranda')

@section('content')
    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.homepage-contents.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah Konten
            </a>
            <a href="{{ route('admin.homepage-contents.preview-dashboard') }}" class="btn-cancel">
                <i class="bi bi-layout-text-window-reverse"></i> Preview CRUD
            </a>
        </div>
        <span class="text-muted small">Gunakan status nonaktif untuk menyembunyikan blok tanpa menghapus datanya.</span>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 110px;">Media</th>
                        <th>Grup / Key</th>
                        <th>Konten</th>
                        <th style="width: 95px;">Urutan</th>
                        <th style="width: 110px;">Status</th>
                        <th class="text-end" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contents as $content)
                        <tr>
                            <td>
                                @if($content->image_src)
                                    <img src="{{ $content->image_src }}" alt="{{ $content->title ?? $content->key }}" class="table-thumb">
                                @else
                                    <span class="badge bg-light text-dark">No Image</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $content->group_label }}</strong>
                                <div class="small text-muted">{{ $content->key }}</div>
                                @if($content->icon)
                                    <span class="badge bg-light text-dark mt-1">
                                        <i class="bi {{ $content->icon }}"></i> {{ $content->icon }}
                                    </span>
                                @endif
                            </td>
                            <td class="line-clamp">
                                <strong>{{ $content->title ?: '-' }}</strong>
                                @if($content->subtitle)
                                    <div class="small text-success">{{ $content->subtitle }}</div>
                                @endif
                                @if($content->body)
                                    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($content->body, 130) }}</div>
                                @endif
                                @if($content->button_label || $content->button_url)
                                    <div class="small mt-1">
                                        <span class="badge bg-light text-dark">{{ $content->button_label ?: 'Tombol' }}</span>
                                        <span class="text-muted">{{ $content->button_url }}</span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $content->sort_order }}</span>
                            </td>
                            <td>
                                @if($content->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.homepage-contents.edit', $content) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.homepage-contents.destroy', $content) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten beranda ini?');">
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
                            <td colspan="6" class="text-center text-muted py-4">Belum ada konten beranda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
