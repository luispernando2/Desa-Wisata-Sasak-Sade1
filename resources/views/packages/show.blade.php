@extends('layouts.app')

@section('title', $package->title ?? 'Paket Wisata')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card rounded-4 shadow-soft border-0">
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-2 mb-3">
                        <h1 class="h3 fw-bold mb-0">{{ $package->title }}</h1>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="badge bg-secondary">{{ $package->duration }}</span>
                            <span class="h5 fw-bold text-danger">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-semibold mb-2">Deskripsi</h5>
                        <p class="text-muted lh-lg mb-0">{{ $package->description }}</p>
                    </div>

                    @if(!blank($package->features))
                        <div class="mb-4">
                            <h5 class="fw-semibold mb-2">Fitur / Paket termasuk</h5>
                            <p class="text-muted lh-lg mb-0">{{ $package->features }}</p>
                        </div>
                    @endif

                    @if($package->tourGuide)
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-3">Tour Guide</h5>
                                <div class="mb-2"><strong>Nama:</strong> {{ $package->tourGuide->name }}</div>
                                @if(!blank($package->tourGuide->phone))
                                    <div class="mb-2"><strong>Phone:</strong> {{ $package->tourGuide->phone }}</div>
                                @endif
                                @if(!blank($package->tourGuide->languages))
                                    <div class="mb-2"><strong>Languages:</strong> {{ $package->tourGuide->languages }}</div>
                                @endif
                                @if(!blank($package->tourGuide->description))
                                    <div class="mb-0"><strong>Deskripsi:</strong> <span class="text-muted">{{ $package->tourGuide->description }}</span></div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('booking.index', ['package_id' => $package->id]) }}#booking" class="btn btn-danger rounded-pill">
                            <i class="bi bi-calendar-check me-2"></i> Book Now
                        </a>
                        <a href="{{ route('packages.index') }}" class="btn btn-outline-danger rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>

                    {{-- Review paket --}}
                    <div class="mt-5">
                        <h4 class="fw-bold mb-3">Review Paket</h4>

@php
                            $canReviewPackage = false;
                            $authUser = session('auth_user');
                            if ($authUser && isset($authUser['id'])) {
                                $canReviewPackage = \App\Models\Booking::where('user_id', $authUser['id'])
                                    ->where('status', \App\Models\Booking::STATUS_COMPLETED)
                                    ->exists();
                            }
                            $packageReviews = $package->reviews ?? collect();
                        @endphp

                        @if($canReviewPackage)
                            <form method="POST" action="{{ route('packages.review.store', $package) }}" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Rating (1-5)</label>
                                    <select name="rating" class="form-select" required>
                                        @for($i=1;$i<=5;$i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Komentar</label>
                                    <textarea name="comment" class="form-control" rows="4" required maxlength="1000"></textarea>
                                </div>
                                <button class="btn btn-danger rounded-pill" type="submit">Kirim Review</button>
                            </form>
                        @else
                            <div class="alert alert-secondary">
                                Review paket hanya bisa diberikan setelah booking Anda berstatus <strong>selesai</strong>.
                            </div>
                        @endif

                        <div>
@forelse($packageReviews as $review)
                                <div class="card border-0 shadow-soft mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $review->visitor_name ?? 'Pengunjung' }}</h6>
                                                <div class="text-muted">Rating: {{ $review->rating }}/5</div>
                                            </div>
                                        </div>
                                        <p class="mb-0 mt-2">{{ $review->comment }}</p>

                                        @if(($review->user_id ?? null) && session('auth_user')['id'] === $review->user_id)
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Yakin ingin menghapus review ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif


                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Belum ada review untuk paket ini.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card rounded-4 shadow-soft border-0 sticky-top" style="top:20px;">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Ringkasan Paket</h5>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Duration</small>
                        <span class="fw-semibold">{{ $package->duration }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Harga mulai</small>
                        <span class="fw-semibold">Rp{{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-4">
                    <a href="{{ route('booking.index', ['package_id' => $package->id]) }}#booking" class="btn btn-outline-danger w-100 rounded-pill">
                        <i class="bi bi-chat-dots me-2"></i> Booking paket ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
