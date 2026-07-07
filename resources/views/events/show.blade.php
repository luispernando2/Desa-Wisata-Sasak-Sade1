@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Event Image -->
            @if($event->image_path)
                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}" class="img-fluid rounded-4 mb-4" style="width: 100%; height: 400px; object-fit: cover;">
            @else
                <div class="bg-light rounded-4 mb-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
                </div>
            @endif

            <!-- Event Details -->
            <div class="card rounded-4 shadow-soft border-0 mb-4">
                <div class="card-body p-4">
                    <h1 class="h3 fw-bold mb-3">{{ $event->name }}</h1>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-event text-danger"></i>
                                <div>
                                    <small class="text-muted d-block">Tanggal</small>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-clock text-danger"></i>
                                <div>
                                    <small class="text-muted d-block">Waktu</small>
                                    <span class="fw-semibold">{{ $event->time }}</span>
                                </div>
                            </div>
                        </div>
                        @if($event->location)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-geo-alt text-danger"></i>
                                    <div>
                                        <small class="text-muted d-block">Lokasi</small>
                                        <span class="fw-semibold">{{ $event->location }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($event->tourGuide)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-person-badge text-danger"></i>
                                    <div>
                                        <small class="text-muted d-block">Tour Guide</small>
                                        <span class="fw-semibold">{{ $event->tourGuide->name }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Deskripsi Event</h5>
                        <p class="text-muted lh-lg">{{ $event->description }}</p>
                    </div>

                    <!-- Tour Guide Info -->
                    @if($event->tourGuide)
                        <div class="alert alert-info bg-info bg-opacity-10 border-info mb-0">
                            <div class="d-flex gap-3">
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1">Tour Guide: {{ $event->tourGuide->name }}</h6>
                                    <p class="small text-muted mb-2">{{ $event->tourGuide->description }}</p>
                                    <div class="d-flex gap-3 flex-wrap">
                                        @if($event->tourGuide->phone)
                                            <div class="d-flex align-items-center gap-2 small">
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $event->tourGuide->phone }}</span>
                                            </div>
                                        @endif
                                        @if($event->tourGuide->languages)
                                            <div class="d-flex align-items-center gap-2 small">
                                                <i class="bi bi-chat-dots"></i>
                                                <span>{{ $event->tourGuide->languages }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="card rounded-4 shadow-soft border-0">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Review Event ({{ $event->reviews->count() }})</h5>

                    @if(session('auth_user') && $canReviewEvent)
                        <!-- Add Review Form -->
                        <div class="card bg-light mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-semibold mb-3">Berikan Review Anda</h6>
                                <form action="{{ route('events.review.store', $event) }}" method="POST">
                                    @csrf


                                    <div class="mb-3">
                                        <label class="form-label small">Rating</label>
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
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small">Komentar Anda</label>
                                        <textarea name="comment" class="form-control rounded-3" rows="3" required placeholder="Bagikan pengalaman Anda..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                        <i class="bi bi-send"></i> Kirim Review
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif(session('auth_user'))
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-lock me-2"></i>
                            Review event hanya bisa diberikan setelah salah satu booking Anda berstatus selesai.
                        </div>
                    @else
                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="alert-link">Login terlebih dahulu</a> untuk memberikan review
                        </div>
                    @endif


                    <!-- Reviews List -->
                    @forelse($event->reviews as $review)
                        <div class="card mb-3 border-0 bg-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $review->user->name ?? $review->visitor_name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-secondary mb-0">
                            Belum ada review untuk event ini
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card rounded-4 shadow-soft border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-4">Informasi Event</h5>
                    
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Status</small>
                        <span class="badge {{ $event->status_badge_class }}">{{ $event->status_label }}</span>
                    </div>

                    @if($event->averageRating())
                        <div class="mb-4">
                            <small class="text-muted d-block mb-2">Rating Rata-rata</small>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($event->averageRating()))
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="fw-semibold">{{ number_format($event->averageRating(), 1) }} / 5</span>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Total Review</small>
                        <span class="h5 fw-bold">{{ $event->reviews->count() }}</span>
                    </div>

                    <hr class="my-4">

                    <a href="{{ route('home') }}" class="btn btn-outline-danger btn-sm w-100 rounded-pill mb-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
