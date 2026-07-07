@extends('admin.layout')

@section('title', 'Edit Konten Beranda')
@section('subtitle', 'Perbarui konten yang tampil di halaman beranda')

@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <a href="{{ route('admin.homepage-contents.index') }}" class="btn-cancel mb-3">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>

                    <form action="{{ route('admin.homepage-contents.update', $content) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.homepage-contents._form')

                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="detail-panel">
                <h6 class="mb-3">Preview Saat Ini</h6>

                @if($content->image_src)
                    <img src="{{ $content->image_src }}" alt="{{ $content->title ?? $content->key }}" class="img-fluid rounded mb-3" style="max-height: 260px; width: 100%; object-fit: cover;">
                @endif

                <dl class="detail-list">
                    <dt>Grup</dt>
                    <dd>{{ $content->group_label }}</dd>
                    <dt>Key</dt>
                    <dd>{{ $content->key }}</dd>
                    <dt>Judul</dt>
                    <dd>{{ $content->title ?: '-' }}</dd>
                    <dt>Status</dt>
                    <dd>{{ $content->is_active ? 'Aktif' : 'Nonaktif' }}</dd>
                    <dt>Path Gambar Upload</dt>
                    <dd class="small text-muted">{{ $content->image_path ?: '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
