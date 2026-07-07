@extends('layouts.app')

@section('title', 'Desa Wisata Sasak Sade')

@section('content')
    @php
        $active = $active_section ?? null;
    @endphp

    @if(!$active)
        @include('partials.hero')
    @endif


    {{-- beranda: tampilkan semua (existing behavior) --}}
    @if(!$active)
        {{-- @include('partials.about') --}}
        @include('partials.home-highlights')


    @else
        {{-- halaman menu: tampilkan hanya data dari menu tersebut --}}
        @if($active === 'about')
            @include('partials.about')
        @endif

        @if($active === 'packages')
            @include('partials.packages')
        @endif

        @if($active === 'events')
            @include('partials.events')
        @endif

        @if($active === 'market')
            @include('partials.products')
        @endif

        @if($active === 'gallery')
            @include('partials.gallery')
        @endif

        @if($active === 'reviews')
            @include('partials.reviews')
        @endif

        @if($active === 'booking')
            @include('partials.booking')
        @endif

        @if($active === 'contact')
            @include('partials.contact')
        @endif
    @endif
@endsection


