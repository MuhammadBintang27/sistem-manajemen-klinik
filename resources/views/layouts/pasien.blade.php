<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Miss Dentist Meulaboh')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        .font-display { font-family: 'Playfair Display', serif; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="{{ $bodyClass ?? '' }}">

    @hasSection('navbar')
        @yield('navbar')
    @else
        <nav class="sticky top-0 z-50 no-print text-white shadow-md"
             style="background: rgba(198, 63, 127, 0.96); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
            <div class="max-w-5xl mx-auto px-5 sm:px-6 py-3.5 flex items-center justify-between">
                <a href="{{ route('reservasi.index') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <span class="font-bold text-base">Miss Dentist Meulaboh</span>
                </a>
                @yield('navbar-right')
            </div>
        </nav>
    @endif

    @yield('content')

    @hasSection('footer')
        @yield('footer')
    @else
        <footer class="py-5 px-5 text-center no-print">
            <p class="text-xs text-slate-400">&copy; 2026 Miss Dentist Meulaboh. Semua hak dilindungi.</p>
        </footer>
    @endif

    @stack('scripts')
</body>
</html>