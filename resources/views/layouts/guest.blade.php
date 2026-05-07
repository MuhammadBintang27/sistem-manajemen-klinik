<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Miss Dentist Sultan Care</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-primary-50 via-white to-secondary-100">
            <div class="mb-8">
                <div class="flex flex-col items-center">

            <!-- Logo -->
            <div class="w-24 h-24 justify-center overflow-hidden ">
                <img 
                    src="{{ asset('image/logopink.webp') }}" 
                    alt="Miss Dentist Sultan Care"
                    class="w-full h-full object-contain"
                >
            </div>

            <!-- Title -->
            <h1 class="mt-4 text-3xl font-bold text-slate-900 text-center">
                Miss Dentist Sultan Care
            </h1>

            <!-- Subtitle -->
            <p class="mt-1 text-sm text-slate-600 text-center">
                Sistem Manajemen Klinik Modern
            </p>

        </div>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white border border-primary-100 shadow-lg overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
