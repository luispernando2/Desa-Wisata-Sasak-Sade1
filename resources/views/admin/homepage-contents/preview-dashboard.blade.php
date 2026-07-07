@extends('admin.layout')

@section('title', 'Menu Beranda (Editor)')
@section('subtitle', 'Tampilan seperti menu beranda + tombol Edit/Delete per konten (kecuali paket, sade mart, event).')

@section('content')
    @php
        $contents = $contents ?? collect();

        // Ambil hanya kartu menu beranda
        $menuItems = $contents
            ->where('group', 'home_menu')
            ->sortBy(['sort_order', 'id'])
            ->values();

        // Key yang dikecualikan: paket, sade mart, event
        $restrictedKeys = [
            'home.menu.packages',
            'home.menu.market',
            'home.menu.events',
        ];

        $isRestricted = function ($key) use ($restrictedKeys) {
            $key = (string) $key;
            return in_array($key, $restrictedKeys, true);
        };

        // Resolve URL untuk button_url
        $resolveContentUrl = function (?string $value, string $fallback = '#') {
            if (blank($value)) {
                return $fallback;
            }

            if (str_starts_with($value, 'route:')) {
                $routeName = substr($value, 6);

                return \Illuminate\Support\Facades\Route::has($routeName)
                    ? route($routeName)
                    : $fallback;
            }

            if (str_starts_with($value, '#') || preg_match('#^(https?:)?//#', $value)) {
                return $value;
            }

            return url($value);
        };
    @endphp

    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.homepage-contents.create') }}" class="btn-add">
                <i class="bi bi-plus"></i> Tambah Konten
            </a>
            <span class="btn-cancel" style="cursor: default;">
                <i class="bi bi-layout-text-window-reverse"></i> Editor Menu Beranda
            </span>
        </div>
        <span class="text-muted small">Gunakan status nonaktif untuk menyembunyikan kartu tanpa menghapus data.</span>
    </div>

    <div class="card overflow-hidden">
        <div class="home-menu-band">
            <div class="container">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-end justify-content-between gap-2">
                    <div>
                        <div style="color:#f5d296; font-weight:900;">Home Menu</div>
                        <div class="text-white opacity-75" style="font-size: 0.92rem;">Edit susunan & isi kartu menu beranda.</div>
                    </div>
                    <div class="text-white opacity-75" style="font-size: 0.9rem;">Kecuali: Paket, Sade Mart, Event</div>
                </div>
            </div>
        </div>

        <div class="p-4">
            <div class="home-menu-grid">
                @forelse($menuItems as $content)
                    @php
                        $route = $resolveContentUrl($content->button_url);
                        $icon = $content->icon ?: 'bi-circle';
                    @endphp

                    <div class="home-menu-item">
                        <a href="{{ $route }}" class="home-menu-card" target="_blank" rel="noopener" style="text-decoration: none;">
                            <span class="menu-icon">
                                <i class="bi {{ $icon }}" aria-hidden="true"></i>
                            </span>
                            <span class="menu-copy">
                                <strong>{{ $content->title ?: '-' }}</strong>
                                <small>{{ $content->body ?: ($content->subtitle ?: 'Konten menu') }}</small>
                            </span>
                            <span class="menu-meta">{{ $content->sort_order }}</span>
                        </a>

                        <div class="menu-admin-actions">
                            <a href="{{ route('admin.homepage-contents.edit', $content) }}" class="btn-edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            @if(!$isRestricted($content->key))
                                <form action="{{ route('admin.homepage-contents.destroy', $content) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten menu beranda ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="menu-admin-meta">
                            <span class="badge bg-light text-dark">{{ $content->group_label }}</span>
                            <span class="badge bg-light text-dark">{{ $content->key }}</span>

                            @if($content->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        Belum ada data menu beranda (group: <b>home_menu</b>).
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        /* gaya mendekati menu beranda pada sisi user */
        .home-menu-band{
            background:#0f2f2b;
            padding:18px 0;
            color:#fff;
        }
        .home-menu-grid{
            display:grid;
            grid-template-columns:repeat(4, minmax(0, 1fr));
            gap:14px;
        }
        .home-menu-item{
            border-radius: 10px;
            background: rgba(255,255,255,0.7);
            border: 1px solid rgba(23,36,31,0.10);
            overflow:hidden;
        }
        .home-menu-card{
            display:grid;
            grid-template-columns:auto minmax(0, 1fr);
            align-items:center;
            gap:12px;
            min-height:110px;
            padding:14px;
            color:#fff;
            background: rgba(15,47,43,0.92);
            border-bottom: 1px solid rgba(255,255,255,0.12);
            transition: transform .2s ease, background .2s ease;
        }
        .home-menu-card:hover{
            transform: translateY(-2px);
            background: rgba(15,47,43,1);
        }
        .menu-icon{
            width:44px; height:44px;
            display:inline-flex;
            align-items:center; justify-content:center;
            border-radius:8px;
            background:#e8c07d;
            color:#2d1b18;
            font-size:20px;
        }
        .menu-copy{ min-width:0; display:grid; gap:7px; }
        .menu-copy strong{ font-size: 16px; line-height:1.1; }
        .menu-copy small{ color: rgba(255,255,255,0.72); line-height:1.4; }
        .menu-meta{
            grid-column:2;
            width:max-content;
            display:inline-flex;
            padding:6px 10px;
            border-radius:999px;
            background: rgba(232,192,125,0.16);
            color:#f5d296;
            font-size:12px;
            font-weight:800;
            margin-top:10px;
        }

        .menu-admin-actions{
            padding:12px 14px;
            display:flex;
            gap:12px;
            align-items:center;
            justify-content:flex-start;
        }

        .menu-admin-meta{
            padding: 0 14px 14px 14px;
            display:flex;
            flex-wrap:wrap;
            gap:6px;
        }

        @media (max-width: 1199px){
            .home-menu-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 576px){
            .home-menu-grid{ grid-template-columns: 1fr; }
        }
    </style>
@endsection

