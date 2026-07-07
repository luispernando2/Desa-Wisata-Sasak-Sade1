@extends('admin.layout')

@section('title', 'Kontak Pengelola')
@section('subtitle', 'Daftar kontak pengelola')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.contacts.create') }}" class="btn-add">
            <i class="bi bi-plus"></i> Tambah Kontak
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->role ?? '-' }}</td>
                            <td>{{ $contact->email ?? '-' }}</td>
                            <td>{{ $contact->phone ?? '-' }}</td>
                            <td class="text-end actions-cell">
                                <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kontak ini?');">
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
                            <td colspan="5" class="text-center text-muted py-4">Belum ada kontak pengelola.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
