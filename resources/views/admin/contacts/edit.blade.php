@extends('admin.layout')

@section('title', 'Edit Kontak Pengelola')
@section('subtitle', 'Ubah data kontak pengelola')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ old('name', $contact->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Role / Jabatan</label>
                    <input type="text" name="role" value="{{ old('role', $contact->role) }}" class="form-control @error('role') is-invalid @enderror">
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $contact->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $contact->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $contact->address) }}</textarea>
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div>
                    <button type="submit" class="btn-submit"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.contacts.index') }}" class="btn-cancel ms-2"><i class="bi bi-x"></i> Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
