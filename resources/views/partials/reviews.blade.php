<section id="reviews" class="py-5">
    @php
        $authUser = $authUser ?? session('auth_user');
        $canWriteReview = $canWriteReview ?? false;
    @endphp

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 gap-3">
        <div>
            <span class="section-title">Review</span>
            <h2 class="section-heading">Komentar Wisatawan</h2>
        </div>
        <p class="text-muted mb-0">Lihat pengalaman pengunjung yang sudah datang ke desa ini.</p>
    </div>

    @if($authUser && $canWriteReview)
        <form action="{{ route('review.store') }}" method="POST" class="card rounded-4 shadow-soft border-0 mb-4">
            @csrf

            <div class="card-body p-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="visitor_name" class="form-label small fw-semibold">Nama</label>
                        <input type="text" id="visitor_name" class="form-control rounded-3" value="{{ $authUser['name'] }}" disabled>
                        <input type="hidden" name="visitor_name" value="{{ $authUser['name'] }}">
                    </div>

                    <div class="col-md-2">
                        <label for="rating" class="form-label small fw-semibold">Rating</label>
                        <select name="rating" id="rating" class="form-select rounded-3 @error('rating') is-invalid @enderror" required>
                            <option value="">Pilih</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }} / 5</option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <label for="comment" class="form-label small fw-semibold">Komentar</label>
                        <textarea name="comment" id="comment" rows="2" class="form-control rounded-3 @error('comment') is-invalid @enderror" required maxlength="1000">{{ old('comment') }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-danger w-100 rounded-pill">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @elseif($authUser)
        <div class="alert alert-warning rounded-4 shadow-sm mb-4">
            <i class="bi bi-lock me-2"></i>
            Review hanya bisa diberikan setelah booking Anda berstatus selesai.
        </div>
    @else
        <div class="alert alert-warning rounded-4 shadow-sm mb-4">
            <i class="bi bi-info-circle me-2"></i>
            <a href="{{ route('login') }}" class="alert-link">Login terlebih dahulu</a> dan selesaikan booking untuk memberi review.
        </div>
    @endif

    <div class="row g-4 row-cols-2 row-cols-md-5">
        @forelse($reviews as $review)
            <div class="col">

                <div class="card rounded-4 shadow-soft h-100 border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="h6 fw-semibold mb-1">{{ $review->visitor_name }}</h3>
                                <small class="text-muted">{{ $review->rating }} / 5</small>
                            </div>
                            <span class="badge rounded-pill bg-success bg-opacity-15 text-success">Rating</span>
                        </div>
                        <p class="text-muted">{{ $review->comment }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary">Belum ada review dari pengunjung.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</section>

