<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Miss Dentist Sultan Care</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
        <div class="min-h-screen bg-gradient-to-br from-white via-primary-50 to-white">
            <div class="flex min-h-screen">
                @include('layouts.sidebar')

                <div class="flex-1 flex flex-col bg-gradient-to-b from-primary-700 to-primary-800 p-4 h-screen">
                    <main class="flex-1 flex flex-col overflow-hidden h-full">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden h-full flex flex-col">
                            <div class="flex-1 overflow-y-auto p-8">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
