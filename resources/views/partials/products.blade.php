<section id="market" class="market-modern-section py-5">

    <!-- BACKGROUND DECOR -->
    <div class="market-blur-circle blur-left"></div>
    <div class="market-blur-circle blur-right"></div>

    <!-- HEADER -->
    <div class="market-header-wrapper mb-5">

        <div>

            <span class="market-mini-title">
                Sade Mart
            </span>

            <h2 class="market-main-title mt-3">
                Produk Lokal & Oleh-Oleh
                Khas Desa Sasak Sade
            </h2>

        </div>

        <p class="market-main-desc mb-0">
            Temukan kain tenun, kerajinan tangan,
            dan berbagai oleh-oleh khas budaya Sasak
            dengan kualitas terbaik langsung dari desa.
        </p>

    </div>

    <!-- PRODUCT GRID -->
    <div class="row g-4">

        {{-- HANYA TAMPIL 6 PRODUK --}}
        @forelse($products->take(6) as $product)

            <div class="col-lg-4 col-md-6">

                <div class="market-product-card">

                    <!-- IMAGE -->
                    <div class="market-product-image">

                                    <img
                                        src="{{ isset($product->image_path) && $product->image_path
                                            ? asset('storage/' . $product->image_path)
                                            : (isset($product->image_url) && $product->image_url ? $product->image_url : 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=900&q=80') }}"
                                        alt="{{ $product->name }}"
                                    >



                        <!-- OVERLAY -->
                        <div class="market-product-overlay">

                            <button
                                class="market-detail-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#productModal{{ $product->id }}"
                            >

                                <i class="bi bi-eye-fill"></i>
                                Lihat Detail

                            </button>

                        </div>

                        <!-- BADGE -->
                        <div class="market-stock-badge">

                            <i class="bi bi-box-seam"></i>
                            {{ $product->stock }} stok

                        </div>

                    </div>

                    <!-- CONTENT -->
                    <div class="market-product-content">

                        <div class="market-product-top">

                            <span class="market-category-badge">
                                Produk Lokal
                            </span>

                            <h3 class="market-product-title">
                                {{ $product->name }}
                            </h3>

                            <p class="market-product-desc">

                                {{ Str::limit($product->description ?? 'Produk khas budaya Sasak dengan kualitas terbaik.', 95) }}

                            </p>

                        </div>

                        <!-- FOOTER -->
                        <div class="market-product-footer">

                            <div>

                                <small class="market-price-label">
                                    Harga Produk
                                </small>

                                <div class="market-price">

                                    Rp{{ number_format($product->price,0,',','.') }}

                                </div>

                            </div>

                            <button
                                class="market-buy-btn"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#productModal{{ $product->id }}"
                            >

                                <i class="bi bi-bag-heart-fill"></i>

                            </button>

                        </div>

                    </div>

                </div>

            </div>

            <!-- MODAL DETAIL PRODUK -->
            <div class="modal fade"
                id="productModal{{ $product->id }}"
                tabindex="-1"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered market-small-modal">

                    <div class="modal-content market-modal-content border-0">

                        <div class="modal-body p-0">

                            <div class="market-modal-wrapper">

                                <!-- IMAGE -->
                                <div class="market-modal-image">

                                    <img
                                        src="{{ isset($product->image_path) && $product->image_path
                                            ? asset('storage/' . $product->image_path)
                                            : (isset($product->image_url) && $product->image_url ? $product->image_url : 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=900&q=80') }}"
                                        alt="{{ $product->name }}"
                                    >


                                    <button type="button"
                                        class="btn-close market-close-btn"
                                        data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <!-- CONTENT -->
                                <div class="market-modal-info">

                                    <span class="market-modal-badge">
                                        Sade Mart
                                    </span>

                                    <h2 class="market-modal-title mt-3">

                                        {{ $product->name }}

                                    </h2>

                                    <div class="market-modal-price">

                                        Rp{{ number_format($product->price,0,',','.') }}

                                    </div>

                                    <p class="market-modal-desc">

                                        {{ $product->description ?? 'Produk khas Desa Sasak Sade dengan sentuhan budaya tradisional Lombok.' }}

                                    </p>

                                    <!-- FEATURES -->
                                    <div class="market-modal-features">

                                        <div class="market-feature-box">

                                            <i class="bi bi-stars"></i>

                                            <div>
                                                <h6>Produk Premium</h6>
                                                <p>Kualitas khas budaya Sasak</p>
                                            </div>

                                        </div>

                                        <div class="market-feature-box">

                                            <i class="bi bi-box2-heart"></i>

                                            <div>
                                                <h6>Stok Produk</h6>
                                                <p>{{ $product->stock }} tersedia</p>
                                            </div>

                                        </div>

                                    </div>

                                    <!-- BUTTON -->
                                    <div class="market-modal-actions">

                                        <a href="{{ route('contact.index') }}"
                                            class="market-contact-btn">

                                            <i class="bi bi-chat-dots-fill"></i>
                                            Hubungi Penjual

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-secondary rounded-4 border-0 shadow-sm">

                    Belum ada produk tersedia di Sade Mart.

                </div>

            </div>

        @endforelse

    </div>

    <!-- BUTTON SELENGKAPNYA -->
    @if($products->count() > 6)

        <div class="text-center mt-5">

            <a href="{{ route('products.index') }}"
                class="market-more-btn">

                Lihat Selengkapnya
                <i class="bi bi-arrow-right"></i>

            </a>

        </div>

    @endif

</section>

<style>

    /* ============================ */
    /* MARKET SECTION */
    /* ============================ */

    .market-modern-section{
        position: relative;
        overflow: hidden;
    }

    .market-blur-circle{
        position: absolute;
        border-radius: 50%;
        filter: blur(90px);
        z-index: 0;
    }

    .blur-left{
        width: 300px;
        height: 300px;
        background: rgba(40,167,69,0.12);
        left: -100px;
        top: 50px;
    }

    .blur-right{
        width: 350px;
        height: 350px;
        background: rgba(255,193,7,0.10);
        right: -120px;
        bottom: -120px;
    }

    /* ============================ */
    /* HEADER */
    /* ============================ */

    .market-header-wrapper{
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 30px;
        flex-wrap: wrap;
    }

    .market-mini-title{
        display: inline-flex;
        align-items: center;
        padding: 10px 22px;
        border-radius: 50px;
        background: rgba(40,167,69,0.10);
        color: #198754;
        font-size: 13px;
        font-weight: 700;
    }

    .market-main-title{
        font-size: 52px;
        line-height: 1.1;
        font-weight: 800;
        max-width: 700px;
        color: #222;
    }

    .market-main-desc{
        max-width: 420px;
        color: #666;
        line-height: 1.8;
        font-size: 15px;
    }

    /* ============================ */
    /* CARD */
    /* ============================ */

    .market-product-card{
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        background: rgba(255,255,255,0.88);
        backdrop-filter: blur(14px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.08);
        transition: all 0.45s ease;
        height: 100%;
    }

    .market-product-card:hover{
        transform: translateY(-10px);
        box-shadow: 0 28px 60px rgba(0,0,0,0.14);
    }

    .market-product-image{
        position: relative;
        height: 320px;
        overflow: hidden;
    }

    .market-product-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .market-product-card:hover
    .market-product-image img{
        transform: scale(1.08);
    }

    /* OVERLAY */

    .market-product-overlay{
        position: absolute;
        inset: 0;
        background:
            linear-gradient(
                180deg,
                rgba(0,0,0,0.02),
                rgba(0,0,0,0.55)
            );
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: 0.4s ease;
    }

    .market-product-card:hover
    .market-product-overlay{
        opacity: 1;
    }

    .market-detail-btn{
        border: none;
        background: #fff;
        color: #111;
        padding: 14px 26px;
        border-radius: 50px;
        font-weight: 700;
    }

    .market-stock-badge{
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(255,255,255,0.92);
        color: #111;
        padding: 10px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }

    /* CONTENT */

    .market-product-content{
        padding: 28px;
    }

    .market-category-badge{
        background: rgba(255,193,7,0.14);
        color: #c28b00;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }

    .market-product-title{
        font-size: 24px;
        font-weight: 800;
        margin-top: 18px;
        margin-bottom: 14px;
        color: #222;
    }

    .market-product-desc{
        color: #777;
        line-height: 1.8;
        font-size: 14px;
    }

    .market-product-footer{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 28px;
        gap: 20px;
    }

    .market-price{
        font-size: 28px;
        font-weight: 800;
        color: #198754;
    }

    .market-buy-btn{
        width: 58px;
        height: 58px;
        border-radius: 20px;
        border: none;
        background:
            linear-gradient(
                135deg,
                #198754,
                #32c671
            );
        color: #fff;
        font-size: 20px;
    }

    /* ============================ */
    /* MODAL */
    /* ============================ */

    .market-small-modal{
        max-width: 720px;
    }

    .market-modal-content{
        border-radius: 26px;
        overflow: hidden;
        background: #fff;
    }

    .market-modal-wrapper{
        display: flex;
        align-items: stretch;
        min-height: 380px;
        max-height: 380px;
        overflow: hidden;
    }

    .market-modal-image{
        position: relative;
        flex: 1 1 300px;
        height: 380px;
        overflow: hidden;
    }

    .market-modal-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .market-close-btn{
        position: absolute;
        top: 18px;
        right: 18px;
        background: #fff;
        border-radius: 50%;
        padding: 10px;
    }

    .market-modal-info{
        flex: 1 1 320px;
        padding: 28px;
        overflow-y: auto;
    }

    .market-modal-badge{
        background: rgba(25,135,84,0.10);
        color: #198754;
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
    }

    .market-modal-title{
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 10px;
    }

    .market-modal-price{
        font-size: 26px;
        font-weight: 800;
        color: #198754;
        margin-top: 10px;
    }

    .market-modal-desc{
        margin-top: 14px;
        color: #666;
        line-height: 1.7;
        font-size: 14px;
    }

    /* FEATURES */

    .market-modal-features{
        margin-top: 18px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .market-feature-box{
        display: flex;
        gap: 14px;
        padding: 14px;
        border-radius: 16px;
        background: #f8f9fa;
    }

    .market-feature-box i{
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background:
            linear-gradient(
                135deg,
                #198754,
                #32c671
            );
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .market-modal-actions{
        margin-top: 20px;
    }

    .market-contact-btn{
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        padding: 14px;
        border-radius: 16px;
        background:
            linear-gradient(
                135deg,
                #198754,
                #32c671
            );
        color: #fff;
        font-weight: 700;
        font-size: 14px;
    }

    .market-contact-btn:hover{
        color: #fff;
    }

    /* BUTTON SELENGKAPNYA */

    .market-more-btn{
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 16px 32px;
        border-radius: 50px;
        text-decoration: none;
        background: #111;
        color: #fff;
        font-weight: 700;
        transition: 0.3s ease;
    }

    .market-more-btn:hover{
        transform: translateY(-4px);
        color: #fff;
    }

    /* RESPONSIVE */

    @media (max-width: 768px){

        .market-main-title{
            font-size: 34px;
        }

        .market-product-image{
            height: 260px;
        }

        .market-modal-wrapper{
            flex-direction: column;
            max-height: unset;
        }

        .market-modal-image{
            height: 240px;
        }

        .market-modal-info{
            padding: 24px;
        }

        .market-modal-title{
            font-size: 24px;
        }

    }

</style>