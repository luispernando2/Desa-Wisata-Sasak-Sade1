@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <a href="{{ route('profile.bookings') }}" class="btn btn-sm btn-outline-danger mb-3 rounded-pill">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <div class="card rounded-4 shadow-soft border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-4">Detail Booking</h4>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Nama Paket</small>
                                <h6 class="fw-semibold">{{ $booking->package?->title ?? 'N/A' }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Nama Pemesan</small>
                                <h6 class="fw-semibold">{{ $booking->name }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Email</small>
                                <h6 class="fw-semibold">{{ $booking->email }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Telepon</small>
                                <h6 class="fw-semibold">{{ $booking->phone }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Tanggal Kunjungan</small>
                                <h6 class="fw-semibold">{{ \Carbon\Carbon::parse($booking->visit_date)->translatedFormat('d M Y') }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Jumlah Tamu</small>
                                <h6 class="fw-semibold">{{ $booking->guests }} orang</h6>
                            </div>
                        </div>
                    </div>

                    @if($booking->message)
                        <div class="card bg-light">
                            <div class="card-body p-3">
                                <small class="text-muted d-block mb-2">Pesan Tambahan</small>
                                <p class="mb-0">{{ $booking->message }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Review Section -->
            <div class="card rounded-4 shadow-soft border-0">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Review Booking</h5>

                    @if($booking->review)
                        <!-- Existing Review -->
                        <div class="alert alert-info mb-3">
                            <strong>Anda sudah memberikan review untuk booking ini</strong>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ data_get(session('auth_user'), 'name', $booking->name) }}</h6>
                                        <small class="text-muted">{{ $booking->review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $booking->review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-3">{{ $booking->review->comment }}</p>
                                <form action="{{ route('booking-reviews.destroy', $booking->review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus review ini?')">
                                        <i class="bi bi-trash"></i> Hapus Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Add Review Form -->
                        @php
                            $canReview = $booking->canBeReviewed();
                        @endphp

                        @if(!$canReview)
                            <div class="alert alert-warning mb-3">
                                <i class="bi bi-lock me-2"></i>
                                Anda dapat memberikan review setelah admin menandai booking ini selesai.
                            </div>
                        @else
                            <form action="{{ route('bookings.review.store', $booking) }}" method="POST" class="card bg-light p-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Rating</label>
                                    <div class="d-flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" required>
                                                <label class="form-check-label" for="rating{{ $i }}">
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                </label>
                                            </div>
                                        @endfor
                                    </div>
                                    @error('rating')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Komentar Anda</label>
                                    <textarea name="comment" class="form-control rounded-3" rows="4" required placeholder="Bagikan pengalaman Anda tentang booking ini..." maxlength="1000"></textarea>
                                    @error('comment')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                    <i class="bi bi-send"></i> Kirim Review
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card rounded-4 shadow-soft border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Informasi Booking</h5>

                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Status</small>
                        <span class="badge {{ $booking->status_badge_class }}">{{ $booking->status_label }}</span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Dibuat</small>
                        <span>{{ $booking->created_at->translatedFormat('d M Y H:i') }}</span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Diperbarui</small>
                        <span>{{ $booking->updated_at->translatedFormat('d M Y H:i') }}</span>
                    </div>

                    @if($booking->review)
                        <div class="alert alert-success alert-sm">
                            <small><i class="bi bi-check-circle me-2"></i> Review sudah diberikan</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
