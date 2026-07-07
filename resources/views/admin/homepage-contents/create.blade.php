@extends('admin.layout')

@section('title', 'Tambah Konten Beranda')
@section('subtitle', 'Buat blok baru untuk halaman beranda')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <a href="{{ route('admin.homepage-contents.index') }}" class="btn-cancel mb-3">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('admin.homepage-contents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.homepage-contents._form')

                <div class="mt-4">
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <a href="{{ route('admin.homepage-contents.index') }}" class="btn-cancel ms-2">
                        <i class="bi bi-x"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
