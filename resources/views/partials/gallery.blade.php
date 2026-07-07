<section id="gallery" class="py-5">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 gap-3">
        <div>
            <span class="section-title">Galeri</span>
            <h2 class="section-heading">Momen Wisata Terbaik</h2>
        </div>
        <p class="text-muted mb-0">Galeri foto ini menampilkan suasana desa dan aktivitas wisata.</p>
    </div>
    <div class="row g-4 row-cols-2 row-cols-md-5">
        @forelse($galleries as $item)
            <div class="col">

                <a href="{{ route('gallery.index') }}" class="gallery-card-link" aria-label="{{ $item->caption }}">
                    <div class="card rounded-4 shadow-soft overflow-hidden border-0 h-100 gallery-card">
                        <div class="gallery-media">
                            <img
                                src="{{ $item->image_url ?? (isset($item->image_path) && $item->image_path ? asset('storage/' . $item->image_path) : asset('images/sade1.png')) }}"
                                alt="{{ $item->caption }}"
                                class="card-img-top"
                                style="height:260px; object-fit:cover;"
                                loading="lazy"
                            />

                            <div class="gallery-media-overlay">
                                <span class="gallery-overlay-badge">{{ $item->caption }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <h3 class="h6 fw-semibold mb-2">{{ $item->caption }}</h3>
                            <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($item->uploaded_at)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </a>

            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary">Belum ada foto atau video.</div>
            </div>
        @endforelse

    </div>

    <div class="mt-4">
        {{ $galleries->links() }}
    </div>

<style>
    /* Gallery enhancements (keep simple + compatible) */
    .gallery-card-link{ text-decoration:none; color: inherit; display:block; }
    .gallery-card{ position:relative; overflow:hidden; transition: .35s ease; }
    .gallery-card:hover{ transform: translateY(-10px); box-shadow: 0 30px 70px rgba(0,0,0,0.14); }
    .gallery-media{ position:relative; }
    .gallery-media-overlay{ position:absolute; inset:0; background: linear-gradient(180deg, rgba(0,0,0,0.0) 30%, rgba(0,0,0,0.55) 100%); opacity:0; transition:.35s ease; display:flex; align-items:flex-end; padding:14px; }
    .gallery-card:hover .gallery-media-overlay{ opacity:1; }
    .gallery-overlay-badge{ background: rgba(255,255,255,0.16); border:1px solid rgba(255,255,255,0.22); color:#fff; font-weight:900; padding:8px 12px; border-radius:999px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width:100%; }
    .gallery-media img{ transform: scale(1.02); transition: .7s ease; }
    .gallery-card:hover .gallery-media img{ transform: scale(1.08); }
</style>
</section>


