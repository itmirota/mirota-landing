@php
    $segments = request()->segments();
    $isLocalized = in_array($segments[0] ?? null, ['id', 'en'], true);
    $altUrl = function (string $loc) use ($segments) {
        $s = $segments;
        $s[0] = $loc;
        return url(implode('/', $s));
    };
    $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/building.jpg');
    $pageTitle = trim($__env->yieldContent('title')) ?: 'PT Mirota KSM';
    $pageDesc  = trim($__env->yieldContent('meta_description')) ?: __('meta.description');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="theme-color" content="#0b4ea2">

    @unless(app()->isProduction())
        <meta name="robots" content="noindex, nofollow">
    @endunless

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Bahasa alternatif & canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">
    @if($isLocalized)
        <link rel="alternate" hreflang="id" href="{{ $altUrl('id') }}">
        <link rel="alternate" hreflang="en" href="{{ $altUrl('en') }}">
        <link rel="alternate" hreflang="x-default" href="{{ $altUrl('id') }}">
    @endif

    {{-- Open Graph / pratinjau saat dibagikan --}}
    <meta property="og:site_name" content="PT Mirota KSM">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:locale" content="{{ app()->getLocale() === 'en' ? 'en_US' : 'id_ID' }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-white font-sans text-slate-700 antialiased" x-data="{ open: false }">

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>