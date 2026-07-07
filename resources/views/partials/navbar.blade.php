@php
    $authUser = session('auth_user');
    // Sama seperti beranda: navbar selalu pakai background hero (nav dark/transparent)
    // supaya warna background konsisten di semua halaman.
    $isHeroNavbar = true;


    $navItems = [
        ['label' => 'Beranda', 'route' => 'home', 'active' => 'home', 'icon' => 'bi-house-door'],
        ['label' => 'Tentang', 'route' => 'about', 'active' => 'about', 'icon' => 'bi-info-circle'],
        ['label' => 'Paket', 'route' => 'packages.index', 'active' => 'packages.*', 'icon' => 'bi-map'],
        ['label' => 'Event', 'route' => 'events.index', 'active' => 'events.*', 'icon' => 'bi-calendar-event'],
        ['label' => 'Sade Mart', 'route' => 'market.index', 'active' => 'market.*', 'icon' => 'bi-bag-heart'],
        ['label' => 'Galeri', 'route' => 'gallery.index', 'active' => 'gallery.*', 'icon' => 'bi-images'],
        ['label' => 'Review', 'route' => 'reviews.index', 'active' => 'reviews.*', 'icon' => 'bi-star'],
        ['label' => 'Booking', 'route' => 'booking.index', 'active' => 'booking.*', 'icon' => 'bi-ticket-perforated'],
        ['label' => 'Kontak', 'route' => 'contact.index', 'active' => 'contact.*', 'icon' => 'bi-chat-dots'],
    ];
@endphp

<style>
    .navbar-custom {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        width: 100%;
        padding: 14px clamp(12px, 3vw, 42px);
        border: 0;
        transition: background 0.25s ease, box-shadow 0.25s ease;
    }

    .navbar-custom.navbar-hero {
        background:
            linear-gradient(
                180deg,
                rgba(4, 16, 14, 0.72) 0%,
                rgba(4, 16, 14, 0.36) 68%,
                rgba(4, 16, 14, 0.00) 100%
            );
        box-shadow: none;
    }

    .navbar-custom.navbar-solid {
        background: rgba(255, 255, 255, 0.90);
        border-bottom: 1px solid rgba(45, 27, 24, 0.10);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 14px 40px rgba(45, 27, 24, 0.10);
    }

    .navbar-custom .navbar-inner {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        align-items: center;
        gap: 14px;
        padding: 0;
    }

    .navbar-brand {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-width: max-content;
        margin: 0;
        text-decoration: none;
    }

    .navbar-brand .logo-badge {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #e8c07d;
        color: #3e2723;
        font-weight: 900;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
    }

    .navbar-brand .brand-title {
        display: block;
        color: #2d1b18;
        font-size: 18px;
        font-weight: 900;
        line-height: 1;
    }

    .navbar-brand .brand-subtitle {
        display: block;
        margin-top: 5px;
        color: rgba(45, 27, 24, 0.66);
        font-size: 12px;
        font-weight: 700;
    }

    .navbar-hero .navbar-brand .brand-title,
    .navbar-hero .navbar-brand .brand-subtitle {
        color: #fff;
        text-shadow: 0 2px 16px rgba(0, 0, 0, 0.30);
    }

    .nav-wrapper {
        min-width: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-nav {
        min-width: 0;
        max-width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 4px;
        margin: 0;
        padding: 6px;
        overflow-x: auto;
        border-radius: 999px;
        scrollbar-width: none;
    }

    .navbar-hero .navbar-nav {
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .navbar-solid .navbar-nav {
        background: rgba(45, 27, 24, 0.06);
        border: 1px solid rgba(45, 27, 24, 0.08);
    }

    .navbar-nav::-webkit-scrollbar {
        display: none;
    }

    .navbar-custom .nav-link {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: #2d1b18 !important;
        font-size: 13px;
        font-weight: 850;
        line-height: 1;
        padding: 10px 12px !important;
        border-radius: 999px;
        white-space: nowrap;
        transition: background 0.22s ease, color 0.22s ease, transform 0.22s ease;
    }

    .navbar-custom .nav-link i {
        font-size: 14px;
        line-height: 1;
    }

    .navbar-hero .nav-link {
        color: rgba(255, 255, 255, 0.92) !important;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.28);
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link:focus {
        background: rgba(45, 27, 24, 0.08);
        color: #2d1b18 !important;
        transform: translateY(-1px);
    }

    .navbar-hero .nav-link:hover,
    .navbar-hero .nav-link:focus {
        background: rgba(255, 255, 255, 0.16);
        color: #fff !important;
    }

    .navbar-custom .nav-link.active {
        background: #e8c07d;
        color: #2d1b18 !important;
        text-shadow: none;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.14);
    }

    .auth-buttons {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        min-width: max-content;
    }

    .btn-login,
    .btn-register,
    .btn-user,
    .btn-logout {
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 850;
        line-height: 1;
        text-decoration: none;
        transition: background 0.22s ease, color 0.22s ease, transform 0.22s ease, border-color 0.22s ease;
    }

    .btn-login,
    .btn-user,
    .btn-logout {
        border: 1px solid rgba(45, 27, 24, 0.14);
        background: rgba(255, 255, 255, 0.34);
        color: #2d1b18;
    }

    .navbar-hero .btn-login,
    .navbar-hero .btn-user,
    .navbar-hero .btn-logout {
        border-color: rgba(255, 255, 255, 0.24);
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .btn-register {
        border: 1px solid rgba(232, 192, 125, 0.82);
        background: #e8c07d;
        color: #3e2723;
    }

    .btn-login:hover,
    .btn-user:hover,
    .btn-logout:hover,
    .btn-register:hover {
        transform: translateY(-1px);
    }

    .btn-login:hover,
    .btn-user:hover,
    .btn-logout:hover {
        background: rgba(45, 27, 24, 0.08);
        color: #2d1b18;
    }

    .navbar-hero .btn-login:hover,
    .navbar-hero .btn-user:hover,
    .navbar-hero .btn-logout:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
    }

    .btn-register:hover {
        background: #f5d296;
        border-color: #f5d296;
        color: #2d1b18;
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #e8c07d;
        color: #3e2723;
        font-size: 12px;
        font-weight: 900;
    }

    @media (max-width: 1320px) {
        .navbar-custom .navbar-inner {
            grid-template-columns: auto minmax(0, 1fr);
        }

        .auth-buttons {
            grid-column: 2;
            justify-self: end;
            margin-top: -2px;
        }
    }

    @media (max-width: 991px) {
        .navbar-custom {
            padding: 12px;
        }

        .navbar-custom .navbar-inner {
            grid-template-columns: 1fr;
            align-items: start;
        }

        .nav-wrapper {
            width: 100%;
            justify-content: start;
        }

        .navbar-nav {
            justify-content: flex-start;
            width: 100%;
            border-radius: 8px;
        }

        .auth-buttons {
            grid-column: 1;
            justify-self: start;
        }
    }

    @media (max-width: 575px) {
        .navbar-brand .logo-badge {
            width: 38px;
            height: 38px;
        }

        .navbar-brand .brand-title {
            font-size: 16px;
        }

        .navbar-brand .brand-subtitle {
            display: none;
        }

        .navbar-custom .nav-link {
            padding-inline: 11px !important;
        }

        .btn-login span,
        .btn-register span,
        .btn-logout span {
            display: none;
        }

        .btn-user {
            max-width: 172px;
            overflow: hidden;
        }

        .btn-user > span:last-child {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>

<nav class="navbar navbar-custom {{ $isHeroNavbar ? 'navbar-hero' : 'navbar-solid' }}">
    <div class="container-fluid navbar-inner">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="logo-badge">S</span>
            <span>
                <span class="brand-title">Sasak Sade</span>
                <span class="brand-subtitle">Desa Wisata Budaya</span>
            </span>
        </a>

        <div class="nav-wrapper">
            <ul class="navbar-nav align-items-center">
                @foreach($navItems as $item)
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}"
                            href="{{ route($item['route']) }}"
                        >
                            <i class="bi {{ $item['icon'] }}" aria-hidden="true"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="auth-buttons">
            @if($authUser)
                @php $initial = strtoupper(substr($authUser['name'], 0, 1)); @endphp

                <a
                    href="{{ ($authUser['role'] ?? 'user') === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                    class="btn-user"
                >
                    <span class="user-avatar">{{ $initial }}</span>
                    <span>{{ $authUser['name'] }}</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="bi bi-person" aria-hidden="true"></i>
                    <span>Login</span>
                </a>

                <a href="{{ route('register') }}" class="btn-register">
                    <i class="bi bi-person-plus" aria-hidden="true"></i>
                    <span>Daftar</span>
                </a>
            @endif
        </div>
    </div>
</nav>
