<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- ═══════════════════════════════════════ --}}
        {{-- SEO: TITLE & META DESCRIPTION           --}}
        {{-- ═══════════════════════════════════════ --}}
        @php
            $host = request()->getSchemeAndHttpHost();

            // PENTING: @section() meng-escape isinya (startSection -> e()) dan
            // yieldContent() meng-escape default-nya. Jadi nilai di bawah SUDAH
            // ter-escape sekali -> di-render dengan {!! !!}, bukan {{ }} (dobel).
            $seoTitle       = $__env->yieldContent('title', 'Islamic Adventurer | Open Trip Gunung & Sewa Peralatan Outdoor');
            $seoDescription = $__env->yieldContent('description', 'Platform open trip terpercaya untuk pendakian gunung dan sewa peralatan outdoor di Indonesia. Aman, nyaman, dan berkesan.');

            // og_image: jadikan URL absolut memakai host request, supaya gambar
            // link preview tetap terbaca walau APP_URL di .env masih localhost.
            $seoImageRaw    = $__env->yieldContent('og_image', 'image/logo.jpeg');
            $seoImagePath   = preg_replace('#^https?://[^/]+#i', '', $seoImageRaw);
            $seoImage       = $host . '/' . ltrim($seoImagePath, '/');

            $seoUrl         = url()->current();
        @endphp

        <title>{!! $seoTitle !!}</title>
        <meta name="description" content="{!! $seoDescription !!}">
        <meta name="keywords" content="@yield('keywords', 'open trip gunung, trip islami, pendakian gunung, sewa peralatan mendaki, open trip indonesia, open trip murah')">
        <meta name="robots" content="index, follow">
        <meta name="author" content="Islamic Adventurer">
        <link rel="canonical" href="{{ $seoUrl }}">

        {{-- ═══════════════════════════════════════ --}}
        {{-- SEO: OPEN GRAPH (Facebook, WhatsApp)    --}}
        {{-- ═══════════════════════════════════════ --}}
        <meta property="og:type"        content="@yield('og_type', 'website')">
        <meta property="og:url"         content="{{ $seoUrl }}">
        <meta property="og:title"       content="{!! $seoTitle !!}">
        <meta property="og:description" content="{!! $seoDescription !!}">
        <meta property="og:image"       content="{!! $seoImage !!}">
        <meta property="og:image:alt"   content="{!! $seoTitle !!}">
        <meta property="og:site_name"   content="Islamic Adventurer">
        <meta property="og:locale"      content="id_ID">

        {{-- ═══════════════════════════════════════ --}}
        {{-- SEO: TWITTER CARD                       --}}
        {{-- ═══════════════════════════════════════ --}}
        <meta name="twitter:card"        content="summary_large_image">
        <meta name="twitter:title"       content="{!! $seoTitle !!}">
        <meta name="twitter:description" content="{!! $seoDescription !!}">
        <meta name="twitter:image"       content="{!! $seoImage !!}">

        {{-- ═══════════════════════════════════════ --}}
        {{-- SEO: JSON-LD STRUCTURED DATA            --}}
        {{-- ═══════════════════════════════════════ --}}
        @stack('structured_data')

        {{-- Default Organization Schema (semua halaman) --}}
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "TravelAgency",
            "name": "Islamic Adventurer",
            "description": "Platform open trip pendakian gunung dan sewa peralatan outdoor terpercaya di Indonesia",
            "url": "{{ rtrim($host, '/') }}/",
            "logo": "{{ $host }}/image/logo.jpeg",
            "image": "{{ $host }}/image/background/islamic.jpeg",
            "telephone": "+62",
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "ID",
                "addressRegion": "Indonesia"
            },
            "sameAs": [],
            "priceRange": "Rp 100.000 - Rp 5.000.000",
            "currenciesAccepted": "IDR",
            "paymentAccepted": "Cash, Transfer Bank, E-Wallet"
        }
        </script>

        {{-- ═══════════════════════════════════════ --}}
        {{-- FAVICON                                  --}}
        {{-- ═══════════════════════════════════════ --}}
        <link rel="icon" type="image/png" href="{{ asset('image/favicon/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('image/favicon/favicon.svg') }}" />
        <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/favicon/apple-touch-icon.png') }}" />
        <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}" />

        <!-- Preconnect for performance -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="dns-prefetch" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-primary-600">
                        Logout
                    </button>
                </form>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
