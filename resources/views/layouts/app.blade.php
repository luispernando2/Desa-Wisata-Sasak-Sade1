<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'Sasak Sade')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body { background-color: #f6fbfa; }


        /* halaman auth: jangan kunci scroll layar */
        body.no-scroll {
            overflow-y: auto;
            overflow-x: hidden;
            height: auto;
            min-height: 100vh;
        }


        main.auth-fullscreen {
            min-height: 100vh;
            height: auto;
            overflow-y: auto;
            overflow-x: hidden;
            padding-block: 0;
        }


        body.is-home-page {

            background: #061210;
        }

        body.is-home-page .site-main-home,
        body.is-home-page .site-main-home > .container-fluid,
        body.is-home-page #home-hero {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        body.is-home-page .navbar-custom {
            top: 0 !important;
        }

        .hero-banner { background: linear-gradient(135deg, var(--sade-teal) 0%, #0b2f2d 60%, #08242d 100%); color: #ffffff; }
        .section-title { letter-spacing: .14em; font-size: .75rem; text-transform: uppercase; font-weight: 700; color: var(--sade-accent); }
        .section-heading { font-size: 2.5rem; font-weight: 700; line-height: 1.05; color: #1b1b18; }
        .shadow-soft { box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08); }

    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $isHomeRoute = request()->routeIs('home');
    $isAuthPage = request()->is('login') || request()->is('register') || request()->is('forgot-password') || request()->is('reset-password*');
@endphp

<body class="bg-light text-body {{ $isHomeRoute ? 'is-home-page' : '' }} {{ $isAuthPage ? 'no-scroll' : '' }}">
    @if(!$isAuthPage)
        @include('partials.navbar')
    @endif

    <main class="{{ $isHomeRoute ? 'site-main site-main-home' : 'site-main py-5' }} {{ $isAuthPage ? 'auth-fullscreen' : '' }}">

        <div class="{{ $isHomeRoute ? 'container-fluid px-0' : 'container' }}">
            @include('partials.flash')
            @yield('content')
        </div>
    </main>
    @php $hideFooterOnAuthPages = request()->is('login') || request()->is('register') || request()->is('forgot-password') || request()->is('reset-password*'); @endphp
    @if(!$hideFooterOnAuthPages)
        @include('partials.footer')
    @endif

    @include('partials.floating-whatsapp')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
