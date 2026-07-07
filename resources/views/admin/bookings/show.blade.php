@extends('admin.layout')

@section('title', 'Detail Booking')
@section('subtitle', 'Informasi lengkap pesanan booking')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 mb-4">
                <div>
                    <span class="badge {{ $booking->status_badge_class }} mb-2">{{ $booking->status_label }}</span>
                    <h2 class="h4 mb-1">{{ $booking->name }}</h2>
                    <p class="text-muted mb-0">{{ $booking->package?->title ?? 'Paket tidak tersedia' }}</p>
                </div>
                <div class="d-flex flex-wrap align-items-start gap-2">
                    @if($booking->whatsapp_url)
                        <a href="{{ $booking->whatsapp_url }}" target="_blank" rel="noopener" class="btn btn-success">
                            <i class="bi bi-whatsapp"></i> Chat WhatsApp
                        </a>
                    @endif
                    <a href="{{ route('admin.bookings.index') }}" class="btn-cancel">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="detail-panel">
                        <h6 class="mb-3">Detail Pemesan</h6>
                        <dl class="detail-list">
                            <dt>Nama</dt>
                            <dd>{{ $booking->name }}</dd>
                            <dt>Email</dt>
                            <dd>{{ $booking->email }}</dd>
                            <dt>Telepon</dt>
                            <dd>{{ $booking->phone }}</dd>
                            <dt>Akun Terhubung</dt>
                            <dd>{{ $booking->user?->name ?? 'Tidak ditemukan' }}</dd>
                            <dt>Paket</dt>
                            <dd>{{ $booking->package?->title ?? 'Paket tidak tersedia' }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="detail-panel">
                        <h6 class="mb-3">Detail Booking</h6>
                        <dl class="detail-list">
                            <dt>Tanggal Kunjungan</dt>
                            <dd>{{ $booking->visit_date?->format('d M Y') ?? '-' }}</dd>
                            <dt>Jumlah Pengunjung</dt>
                            <dd>{{ $booking->guests }} orang</dd>
                            <dt>Pesan</dt>
                            <dd>{{ $booking->message ?? '-' }}</dd>
                            <dt>Dibuat</dt>
                            <dd>{{ $booking->created_at->format('d M Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-lg-6">
                    <div class="detail-panel">
                        <h6 class="mb-3">Ubah Status Kunjungan</h6>
                        <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Status Booking</label>
                            <select name="status" class="form-select mb-3" required>
                                @foreach(\App\Models\Booking::statusOptions() as $value => $label)
                                    <option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-submit">
                                <i class="bi bi-check2"></i> Simpan Status
                            </button>
                        </form>
                        <p class="small text-muted mb-0 mt-3">Form review user baru terbuka saat status booking menjadi Selesai.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="detail-panel">
                        <h6 class="mb-3">Review Booking</h6>
                        @if($booking->review)
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge bg-warning text-dark">{{ $booking->review->rating }}/5</span>
                                <span class="text-muted small">{{ $booking->review->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <p class="mb-0">{{ $booking->review->comment }}</p>
                        @elseif($booking->canBeReviewed())
                            <div class="alert alert-info mb-0">
                                Booking sudah selesai. User sudah bisa memberi review.
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                Review masih terkunci sampai status booking ditandai Selesai.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex flex-wrap gap-2">
                @if($booking->isCompleted())
                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Hapus booking selesai ini? Data review terkait juga akan terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus Booking
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-outline-secondary" disabled title="Tandai Selesai sebelum menghapus booking">
                        <i class="bi bi-trash"></i> Hapus aktif setelah selesai
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
