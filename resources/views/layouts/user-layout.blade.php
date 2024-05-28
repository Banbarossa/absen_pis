<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <title>{{ config('app.name', 'Absen') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('style')
</head>

<body class="font-sans antialiased text-gray-900">

    <livewire:layouts.navbar>

    <div class="block w-full gap-6 px-4 bg-gradient-to-r from-gray-200 to-gray-100 md:flex md:px-6">
        <div class="py-4 md:h-screen">
            <livewire:layouts.sidebar>
        </div>
        <div class="w-full md:mt-12 md:py-8 min-h-svh md:ms-32">
            @if (isset($title))
            <div class="p-4 my-2 mb-4 text-red-800 bg-white rounded-lg ">
                <h3 class="w-full mb-2 text-xl font-bold tracking-wide">{{ $title }}</h3>
                <a href="{{ route('dashboard') }}" class="p-2 text-white bg-red-600 rounded-lg hover:ring-2 hover:ring-red-300">
                    Kembali Ke Tampilan Sebelumnya
                </a>
            </div>
            @endif
            {{ $slot }}
        </div>

    </div>

    @stack('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
