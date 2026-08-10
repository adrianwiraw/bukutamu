<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ config('app.name', 'Buku Tamu') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">

        <!-- Logo & Header -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/jateng.png') }}" alt="Logo" class="w-16 h-16 mb-3">
            <h1 class="text-xl font-bold text-gray-900">Dinas Arpus</h1>
            <p class="text-sm text-gray-500">Provinsi Jawa Tengah</p>
        </div>

        <!-- Card Form -->
        <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-xl border-t-4 border-yellow-500 px-6 py-8">
            {{ $slot }}
        </div>

        <p class="text-xs text-gray-400 mt-6">
            © {{ date('Y') }} Dinas Arpus Jateng. All rights reserved.
        </p>
    </div>
</body>

</html>