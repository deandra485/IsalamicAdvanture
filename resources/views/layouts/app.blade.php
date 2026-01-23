<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'OpenTrip Islamic Advanture | Open Trip Gunung & Wisata Halal Terpercaya')</title>

        <meta name="description" content="@yield('description', 'OpenTrip Islamic Advanture menyediakan paket trip naik gunung, wisata alam, dan perjalanan halal yang aman, nyaman, dan terpercaya untuk para muslim traveler di Indonesia.')">

        <meta name="keywords" content="open trip gunung, wisata halal, trip islami, pendakian gunung, travel syariah, open trip indonesia">

        <meta name="robots" content="index, follow">

        <link rel="canonical" href="{{ url()->current() }}">


        <link rel="icon" type="image/png" href="{{ asset('image/favicon/favicon-96x96.png') }}" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="{{ asset('image/favicon/favicon.svg') }}" />
        <link rel="shortcut icon" href="{{ asset('image/favicon/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/favicon/apple-touch-icon.png') }}" />
        <link rel="manifest" href="{{ asset('image/favicon/site.webmanifest') }}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @extends('layouts.app')

        @section('title', 'OpenTrip Islamic Advanture | Open Trip Gunung')
        @section('description', 'Nikmati open trip gunung dan wisata halal aman & nyaman bersama tim profesional untuk muslim traveler di Indonesia.')

        @section('content')
            <h1>Selamat datang di OpenTrip Islamic Advanture!</h1>
            <p>Jelajahi paket wisata halal dan pendakian gunung terbaik kami.</p>
        @endsection
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            <!-- Page Heading -->
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

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
