<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> {{-- Menambahkan locale dari app config --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Telkom Marketplace')</title> {{-- Menambahkan default title jika @yield('title') kosong --}}

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- Anda bisa memindahkan Google Fonts ke resources/css/app.css jika diinginkan --}}

    {{-- Jika dashboard.css adalah file CSS manual di public/css, biarkan seperti ini --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{-- TAMBAHKAN INI: Vite akan me-link ke app.css (yang berisi Tailwind) dan app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('styles') {{-- Untuk CSS spesifik per halaman --}}
</head>
<body class="font-sans antialiased"> {{-- Contoh menambahkan kelas dasar Tailwind ke body --}}
    @include('navbar') {{-- Pastikan navbar.blade.php juga menggunakan kelas Tailwind jika perlu --}}

    <div class="main-content">
        @yield('content')
    </div>

    @yield('scripts') {{-- Untuk JavaScript spesifik per halaman --}}
</body>
</html>