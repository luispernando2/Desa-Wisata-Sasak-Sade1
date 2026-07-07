<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Desa Wisata Sasak Sade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --dark: #1a1a1a;
            --light-bg: #f8f9fa;
        }
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: white;
            border-right: 1px solid #e0e0e0;
            min-height: 100vh;
            padding: 30px 0;
            position: fixed;
            width: 260px;
            top: 0;
            left: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            overflow-y: auto;
            max-height: 100vh;
        }

        .sidebar .logo {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--dark);
            padding: 0 20px 20px;
            display: block;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }
        .sidebar .subtitle {
            font-size: 0.85rem;
            color: #666;
            padding: 0 20px;
            margin-bottom: 30px;
        }
        .sidebar .user-info {
            background: #f0f9ff;
            border-left: 3px solid var(--primary);
            padding: 12px 20px;
            margin: 0 10px 20px;
            border-radius: 4px;
        }
        .sidebar .user-info .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--dark);
        }
        .sidebar .user-info .role {
            font-size: 0.75rem;
            color: #666;
            margin-top: 4px;
        }
        .sidebar nav {
            margin: 20px 10px;
        }
        .sidebar nav a {
            display: block;
            padding: 10px 20px;
            color: #555;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 5px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .sidebar nav a:hover,
        .sidebar nav a.active {
            background: #f0f9ff;
            color: var(--primary);
            font-weight: 500;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        .page-header {
            margin-bottom: 30px;
        }
        .page-header h1 {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }
        .page-header p {
            color: #666;
            margin: 0;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .btn-add {
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            transition: background 0.2s;
        }
        .btn-add:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        .btn-edit,
        .btn-detail {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            margin-right: 15px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-edit:hover,
        .btn-detail:hover {
            text-decoration: underline;
        }
        .btn-delete {
            color: var(--danger);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 0;
            background: transparent;
            padding: 0;
        }
        .btn-delete:hover {
            text-decoration: underline;
        }
        table {
            background: white;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .card {
            background: white;
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .form-control, .form-select, textarea {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
        .btn-submit {
            background: var(--primary);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-submit:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        .btn-cancel {
            background: #e0e0e0;
            color: #555;
            padding: 10px 25px;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }
        .btn-cancel:hover {
            background: #d0d0d0;
            text-decoration: none;
            color: #333;
        }
        .badge-count {
            display: block;
            width: 100%;
            height: 100%;
            background: white;
            color: var(--dark);
            padding: 24px;
            border-radius: 4px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .badge-count .label {
            font-size: 0.85rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 10px;
        }
        .badge-count .number {
            font-size: 2.25rem;
            font-weight: 600;
            color: var(--dark);
        }
        .module-card {
            height: 100%;
            margin-bottom: 0;
        }
        .module-card .card-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
            height: 100%;
        }
        .module-card .module-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background: #f0f9ff;
            color: var(--primary);
            font-size: 1.15rem;
        }
        .module-card .module-link {
            margin-top: auto;
            align-self: flex-start;
        }
        .detail-panel {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 20px;
            height: 100%;
        }
        .detail-panel h2,
        .detail-panel h3,
        .detail-panel h6 {
            color: var(--dark);
            font-weight: 600;
        }
        .detail-list dt {
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 2px;
        }
        .detail-list dd {
            color: #555;
            margin-bottom: 14px;
            word-break: break-word;
        }
        .table-thumb {
            width: 90px;
            height: 65px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }
        .actions-cell {
            white-space: nowrap;
        }
        .line-clamp {
            max-width: 420px;
            white-space: normal;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
                padding: 15px;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .page-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <i class="bi bi-gear"></i> Admin Sasak Sade
        </a>
        <p class="subtitle">Kelola konten website desa wisata.</p>
        
        @if(session('auth_user'))
            <div class="user-info">
                <div class="name">{{ data_get(session('auth_user'), 'name') }}</div>
                <div class="role">Role: {{ data_get(session('auth_user'), 'role') }}</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="px-3 mb-3">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
            </form>
        @endif
        
        @php $currentRouteName = request()->route()?->getName(); @endphp
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $currentRouteName === 'admin.dashboard' ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.hero-images.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.hero-images') ? 'active' : '' }}">
                <i class="bi bi-image"></i> Hero Beranda
            </a>
            <a href="{{ route('admin.events.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.events') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Events
            </a>
            <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.galleries') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Galeri
            </a>
            <a href="{{ route('admin.packages.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.packages') ? 'active' : '' }}">
                <i class="bi bi-luggage"></i> Paket Wisata
            </a>
            <a href="{{ route('admin.guides.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.guides') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Tour Guide
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.products') ? 'active' : '' }}">
                <i class="bi bi-shop"></i> Market Sade
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.contacts') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Kontak Pengelola
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.reviews') ? 'active' : '' }}">
                <i class="bi bi-star"></i> Reviews
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ str_contains($currentRouteName ?? '', 'admin.bookings') ? 'active' : '' }}">
                <i class="bi bi-bookmark-check"></i> Kelola Booking
            </a>
            <hr>
            <a href="{{ route('home') }}" class="nav-link" style="color: var(--primary);">
                <i class="bi bi-arrow-up-right"></i> Lihat Situs
            </a>
        </nav>
    </div>
    
    <main class="main-content">
        <div class="page-header">
            <h1>@yield('title')</h1>
            <p>@yield('subtitle')</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif
        
        @php $viewErrors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
        @if($viewErrors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($viewErrors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
