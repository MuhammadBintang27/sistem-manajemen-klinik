<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Miss Dentist Meulaboh')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        /* ── Global CSS Variables ── */
        :root {
            /* Shared pink palette */
            --pink-primary:  #D94A8C;
            --pink-dark:     #C63F7F;
            --pink-darker:   #A3326A;
            --pink-light:    #F8D6E9;
            --pink-lighter:  #FDF0F6;
            --pink-mid:      #E77BAA;

            /* index.blade uses these names */
            --rose:          #C8416E;
            --rose-dark:     #A93460;
            --rose-deep:     #8B2750;
            --rose-mid:      #DE7AA4;
            --rose-light:    #F5CEDE;
            --rose-pale:     #FBF0F5;
            --rose-faint:    #FEF8FB;
            --ink:           #1A1118;
            --ink-mid:       #3D2A35;
            --slate:         #7A6872;
            --cream:         #FDFAF8;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .font-display { font-family: 'Playfair Display', serif; }

        /* ── Navbar (shared) ── */
        .navbar-glass {
            background: rgba(198, 63, 127, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* ── Print utility ── */
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="{{ $bodyClass ?? '' }}">

    {{-- Navbar (dapat di-override per halaman) --}}
    @hasSection('navbar')
        @yield('navbar')
    @else
        {{-- Navbar default: simple --}}
        <nav class="navbar-glass text-white shadow-md sticky top-0 z-50 no-print">
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

    {{-- Main content --}}
    @yield('content')

    {{-- Footer (dapat di-override per halaman) --}}
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