<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Miss Dentist Sultan Care')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        .font-display { font-family: 'Playfair Display', serif; }
        @media print { .no-print { display: none !important; } }
        #mobileMenu.open { display: flex; }
    </style>
</head>
<body class="{{ $bodyClass ?? '' }}">

    {{-- =====================================================================
         UNIFIED NAVBAR
         Slots available to child views:
           @section('navbar-links')        — desktop mid links
           @section('navbar-right')        — desktop right action
           @section('navbar-mobile-links') — mobile dropdown links
           @section('navbar-mobile-right') — mobile dropdown right action
         ===================================================================== --}}
    <nav class="fixed top-0 left-0 right-0 z-[100] no-print"
         style="background: rgba(198, 63, 127, 0.97); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255,255,255,0.10);">

        <div class="max-w-[1200px] mx-auto px-5 sm:px-6 h-[68px] flex items-center justify-between gap-4">

            {{-- Logo --}}
            <a href="{{ route('reservasi.index') }}" class="flex items-center gap-3 text-white no-underline flex-shrink-0">
                <img src="{{ asset('image/logo.webp') }}" alt="Logo Klinik Chantika" class="w-18 h-16 object-contain">
            </a>

            {{-- Desktop mid links --}}
            <div class="hidden md:flex items-center gap-8 flex-1 justify-center">
                @yield('navbar-links')
            </div>

            {{-- Desktop right action --}}
            <div class="hidden md:flex items-center flex-shrink-0">
                @yield('navbar-right')
            </div>

            {{-- Mobile: show right action directly when no hamburger needed --}}
            @hasSection('navbar-mobile-links')
                <button id="hamburgerBtn"
                        class="md:hidden text-white p-2 -mr-1 rounded-lg hover:bg-white/10 transition flex-shrink-0"
                        aria-label="Toggle menu" aria-expanded="false">
                    <svg id="hamburgerIcon" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @else
                <div class="md:hidden flex items-center flex-shrink-0">
                    @yield('navbar-right')
                </div>
            @endif

        </div>

        {{-- Mobile dropdown --}}
        @hasSection('navbar-mobile-links')
            <div id="mobileMenu"
                 class="hidden flex-col md:hidden px-5 pb-5 pt-2 border-t border-white/10 space-y-1"
                 style="background: rgba(198, 63, 127, 0.98);">
                @yield('navbar-mobile-links')
                <div class="pt-3 border-t border-white/10 mt-2">
                    @yield('navbar-mobile-right')
                </div>
            </div>
        @endif

    </nav>

    {{-- Spacer to prevent content hidden under fixed nav --}}
    <div class="h-[68px] no-print"></div>

    @yield('content')

    @hasSection('footer')
        @yield('footer')
    @else
        <footer class="py-5 px-5 text-center no-print">
            <p class="text-xs text-slate-400">&copy; 2026 Miss Dentist Sultan Care. Semua hak dilindungi.</p>
        </footer>
    @endif

    @stack('scripts')

    <script>
        (function () {
            var btn       = document.getElementById('hamburgerBtn');
            var menu      = document.getElementById('mobileMenu');
            var iconOpen  = document.getElementById('hamburgerIcon');
            var iconClose = document.getElementById('closeIcon');
            if (!btn || !menu) return;

            btn.addEventListener('click', function () {
                var isOpen = menu.classList.toggle('open');
                btn.setAttribute('aria-expanded', isOpen);
                iconOpen.classList.toggle('hidden', isOpen);
                iconClose.classList.toggle('hidden', !isOpen);
            });

            menu.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () {
                    menu.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                    iconOpen.classList.remove('hidden');
                    iconClose.classList.add('hidden');
                });
            });
        })();
    </script>
</body>
</html>