@php
    $address = $contact['address'] ?? 'Desa Sasak Sade, Pujut, Lombok Tengah, Nusa Tenggara Barat';
    $phone = $contact['phone'] ?? '+6287865936972';
    $email = $contact['email'] ?? 'info@sasaksade.id';
    $managerName = $contact['name'] ?? 'Pengelola Desa Wisata Sasak Sade';
    $managerRole = $contact['role'] ?? 'Admin Wisata Budaya';

    $phoneDigits = preg_replace('/\D+/', '', $phone);

    if (str_starts_with($phoneDigits, '0')) {
        $phoneDigits = '62' . substr($phoneDigits, 1);
    } elseif (str_starts_with($phoneDigits, '8')) {
        $phoneDigits = '62' . $phoneDigits;
    }

    /*
    |--------------------------------------------------------------------------
    | GOOGLE MAPS - DESA SASAK SADE
    |--------------------------------------------------------------------------
    */
    $mapEmbed = $contact['map_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2828.4885176867538!2d116.29005287321567!3d-8.8394536904981!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcda9172d983baf%3A0xfa9eed5a2752a97c!2sSade%20Village!5e1!3m2!1sid!2sid!4v1780836266982!5m2!1sid!2sid';

    $mapUrl = 'https://maps.google.com/?q=Sade+Village';

    $whatsappUrl = $phoneDigits
        ? 'https://wa.me/' . $phoneDigits . '?text=' . rawurlencode(
            'Halo Admin Sasak Sade, saya ingin bertanya tentang wisata budaya.'
        )
        : null;
@endphp

<section id="contact" class="contact-modern-section py-5">
    <div class="contact-shell">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="contact-story-panel">
                    <img src="{{ asset('images/sade4.png') }}" alt="Suasana Desa Sasak Sade" class="contact-story-image">
                    <div class="contact-story-overlay"></div>

                    <div class="contact-story-content">
                        <span class="contact-mini-badge">Kontak Desa Wisata</span>

                        <h2>
                            Datang, bertanya, dan rancang perjalanan budaya Anda.
                        </h2>

                        <p>
                            Tim pengelola siap membantu informasi paket wisata, jadwal kunjungan,
                            lokasi, serta kebutuhan perjalanan ke Desa Sasak Sade.
                        </p>

                        <div class="contact-manager">
                            <div class="contact-manager-avatar">
                                {{ strtoupper(substr($managerName, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $managerName }}</strong>
                                <span>{{ $managerRole }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-info-panel">
                    <div class="contact-heading-wrap">
                        <div>
                            <span class="section-title">Kontak & Lokasi</span>
                            <h2 class="contact-heading mt-3">Hubungi Pengelola Sasak Sade</h2>
                        </div>
                        <span class="contact-step">03</span>
                    </div>

                    <p class="contact-lead">
                        Pilih jalur komunikasi yang paling nyaman. Untuk respons cepat,
                        gunakan WhatsApp agar admin bisa langsung membantu.
                    </p>

                    <div class="contact-methods">
                        <a href="{{ $whatsappUrl ?? '#' }}" class="contact-method {{ $whatsappUrl ? '' : 'disabled' }}" @if($whatsappUrl) target="_blank" rel="noopener" @endif>
                            <span class="contact-method-icon">
                                <i class="bi bi-whatsapp"></i>
                            </span>
                            <span>
                                <small>WhatsApp / Telepon</small>
                                <strong>{{ $phone }}</strong>
                            </span>
                        </a>

                        <a href="mailto:{{ $email }}" class="contact-method">
                            <span class="contact-method-icon">
                                <i class="bi bi-envelope-paper"></i>
                            </span>
                            <span>
                                <small>Email</small>
                                <strong>{{ $email }}</strong>
                            </span>
                        </a>

                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="contact-method contact-method-wide">
                            <span class="contact-method-icon">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <span>
                                <small>Alamat</small>
                                <strong>{{ $address }}</strong>
                            </span>
                        </a>
                    </div>

                    <div class="contact-actions">
                        @if($whatsappUrl)
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="contact-primary-btn">
                                <i class="bi bi-whatsapp"></i>
                                Chat Admin
                            </a>
                        @endif

                        <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="contact-outline-btn">
                            <i class="bi bi-map"></i>
                            Buka Maps
                        </a>
                    </div>

                    <div class="contact-map-frame">
                        <iframe
                            src="{{ $mapEmbed }}"
                            title="Peta lokasi Desa Sasak Sade"
                            class="contact-map"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-modern-section {
        position: relative;
        overflow: hidden;
    }

    .contact-shell {
        position: relative;
        padding: 18px;
        border-radius: 40px;
        background:
            linear-gradient(135deg, rgba(45,27,24,0.08), rgba(215,184,153,0.22)),
            rgba(255,255,255,0.52);
        border: 1px solid rgba(139,94,60,0.12);
        box-shadow: 0 22px 70px rgba(45,27,24,0.08);
    }

    .contact-story-panel,
    .contact-info-panel {
        min-height: 100%;
        border-radius: 34px;
        overflow: hidden;
    }

    .contact-story-panel {
        position: relative;
        background: #2d1b18;
        box-shadow: 0 24px 55px rgba(45,27,24,0.24);
    }

    .contact-story-image {
        width: 100%;
        height: 100%;
        min-height: 650px;
        object-fit: cover;
        display: block;
        transform: scale(1.02);
    }

    .contact-story-overlay {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(180deg, rgba(45,27,24,0.08), rgba(45,27,24,0.86)),
            linear-gradient(90deg, rgba(14,58,55,0.35), rgba(14,58,55,0));
    }

    .contact-story-content {
        position: absolute;
        inset: auto 0 0;
        padding: 42px;
        color: #fff;
    }

    .contact-mini-badge {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 50px;
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.16);
        backdrop-filter: blur(12px);
        color: #f3dcc0;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .4px;
    }

    .contact-story-content h2 {
        margin-top: 24px;
        margin-bottom: 18px;
        font-size: 42px;
        line-height: 1.13;
        font-weight: 900;
        max-width: 560px;
    }

    .contact-story-content p {
        color: rgba(255,255,255,0.76);
        line-height: 1.9;
        font-size: 16px;
        margin-bottom: 28px;
        max-width: 560px;
    }

    .contact-manager {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border-radius: 22px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.14);
        backdrop-filter: blur(14px);
        max-width: 420px;
    }

    .contact-manager-avatar {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #d7b899;
        color: #2d1b18;
        font-size: 24px;
        font-weight: 900;
        flex-shrink: 0;
    }

    .contact-manager strong,
    .contact-manager span {
        display: block;
    }

    .contact-manager strong {
        color: #fff;
        line-height: 1.3;
    }

    .contact-manager span {
        color: rgba(255,255,255,0.68);
        font-size: 14px;
        margin-top: 4px;
    }

    .contact-info-panel {
        background: rgba(255,255,255,0.92);
        backdrop-filter: blur(18px);
        padding: 44px;
        border: 1px solid rgba(255,255,255,0.62);
        box-shadow: 0 18px 50px rgba(45,27,24,0.08);
    }

    .contact-heading-wrap {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 24px;
    }

    .contact-heading {
        max-width: 640px;
        font-size: 46px;
        line-height: 1.1;
        font-weight: 900;
        color: #2d1b18;
        margin-bottom: 0;
    }

    .contact-step {
        width: 68px;
        height: 68px;
        border-radius: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: linear-gradient(135deg, #0e3a37, #2d1b18);
        color: #e8c07d;
        font-size: 22px;
        font-weight: 900;
        box-shadow: 0 16px 32px rgba(14,58,55,0.24);
    }

    .contact-lead {
        color: #6e6159;
        line-height: 1.9;
        font-size: 16px;
        max-width: 760px;
        margin: 24px 0 0;
    }

    .contact-methods {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-top: 32px;
    }

    .contact-method {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 22px;
        border-radius: 24px;
        background:
            linear-gradient(145deg, rgba(255,255,255,0.98), rgba(249,244,240,0.98));
        border: 1px solid rgba(139,94,60,0.12);
        text-decoration: none;
        color: #2d1b18;
        transition: .3s ease;
        min-width: 0;
    }

    .contact-method:hover {
        color: #2d1b18;
        transform: translateY(-5px);
        box-shadow: 0 20px 42px rgba(45,27,24,0.10);
        border-color: rgba(139,94,60,0.22);
    }

    .contact-method.disabled {
        pointer-events: none;
        opacity: .72;
    }

    .contact-method-wide {
        grid-column: 1 / -1;
    }

    .contact-method-icon {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(14,58,55,0.10);
        color: #0e3a37;
        font-size: 22px;
    }

    .contact-method small,
    .contact-method strong {
        display: block;
    }

    .contact-method small {
        color: #8b5e3c;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .7px;
        margin-bottom: 7px;
    }

    .contact-method strong {
        color: #2d1b18;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .contact-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 30px;
    }

    .contact-primary-btn,
    .contact-outline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-height: 54px;
        padding: 14px 24px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        transition: .3s ease;
    }

    .contact-primary-btn {
        background: #25d366;
        color: #fff;
        box-shadow: 0 14px 32px rgba(37,211,102,0.24);
    }

    .contact-primary-btn:hover {
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 18px 42px rgba(37,211,102,0.30);
    }

    .contact-outline-btn {
        background: #2d1b18;
        color: #fff;
        border: 1px solid rgba(45,27,24,0.12);
    }

    .contact-outline-btn:hover {
        background: #8b5e3c;
        color: #fff;
        transform: translateY(-3px);
    }

    .contact-map-frame {
        margin-top: 34px;
        height: 315px;
        border-radius: 28px;
        overflow: hidden;
        border: 8px solid #fff;
        box-shadow: 0 20px 45px rgba(45,27,24,0.12);
        background: #efe5da;
    }

    .contact-map {
        width: 100%;
        height: 100%;
        border: 0;
        display: block;
    }

    @media (max-width: 992px) {
        .contact-story-image {
            min-height: 480px;
        }

        .contact-heading {
            font-size: 38px;
        }
    }

    @media (max-width: 768px) {
        .contact-shell {
            padding: 10px;
            border-radius: 30px;
        }

        .contact-story-panel,
        .contact-info-panel {
            border-radius: 26px;
        }

        .contact-story-content,
        .contact-info-panel {
            padding: 28px;
        }

        .contact-story-content h2 {
            font-size: 30px;
        }

        .contact-heading-wrap {
            flex-direction: column;
        }

        .contact-heading {
            font-size: 32px;
        }

        .contact-methods {
            grid-template-columns: 1fr;
        }

        .contact-map-frame {
            height: 280px;
            border-width: 6px;
        }
    }

    @media (max-width: 480px) {
        .contact-story-content,
        .contact-info-panel {
            padding: 22px;
        }

        .contact-story-image {
            min-height: 520px;
        }

        .contact-method {
            padding: 18px;
        }

        .contact-actions a {
            width: 100%;
        }
    }
</style>
