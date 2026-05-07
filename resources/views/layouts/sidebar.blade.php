<aside class="w-80 shrink-0 bg-gradient-to-b from-primary-700 to-primary-800 border-r border-primary-900 shadow-md h-screen sticky top-0 overflow-y-auto">
    <!-- Header -->
    <div class="flex h-28 items-center px-8 text-white">
        <div class="w-full">
            <div class="flex items-center gap-3 mb-1">
                <img src="{{ asset('image/logo.webp') }}" alt="Logo Klinik Chantika" class="w-12 h-12 object-contain">
                <div>
                    <div class="text-xs font-semibold uppercase tracking-widest text-primary-100">Miss Dentist</div>
                    <div class="text-lg font-bold">Sultan Care</div>
                </div>
            </div>
            <p class="text-xs text-primary-100 mt-2">Sistem Manajemen Klinik</p>
        </div>
    </div>

    <!-- User Profile -->
    <div class="px-8">
        <div class="p-4 mb-2 bg-white rounded-xl shadow-md">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 rounded-lg bg-secondary-100 flex items-center justify-center text-primary-700 font-bold text-lg">
                    {{ substr(Auth::user()->nama ?? 'U', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-primary-700 truncate">{{ Auth::user()->nama }}</div>
                    <div class="text-xs text-primary-600 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <span class="inline-flex items-center rounded-full bg-secondary-100 text-primary-700 px-3 py-1 text-xs font-semibold uppercase tracking-widest">
                {{ Auth::user()->role }}
            </span>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-1 mb-8">
            @php
                $dashboardRoute = Auth::user()->role === 'admin' ? route('admin.dashboard') : (Auth::user()->role === 'dokter' ? route('dokter.dashboard') : route('dashboard'));
                $dashboardActive = Auth::user()->role === 'admin' ? request()->routeIs('admin.dashboard') : (Auth::user()->role === 'dokter' ? request()->routeIs('dokter.dashboard') : request()->routeIs('dashboard'));
            @endphp

            <a href="{{ $dashboardRoute }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ $dashboardActive ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            @if (Auth::user()->role === 'admin')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold uppercase text-primary-200 tracking-wider">Manajemen</p>
                </div>

                <a href="{{ route('admin.pasien.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.pasien.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>Pasien</span>
                </a>

                <a href="{{ route('admin.jadwal.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.jadwal.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    <span>Jadwal</span>
                </a>

                <a href="{{ route('admin.reservasi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reservasi.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                    <span>Reservasi</span>
                </a>

                <a href="{{ route('admin.rekam-medis.list-pasien') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.rekam-medis.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2z"/>
                    </svg>
                    <span>Rekam Medis</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold uppercase text-primary-200 tracking-wider">Laporan</p>
                </div>

                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Laporan</span>
                </a>
            @endif

            @if (Auth::user()->role === 'dokter')
                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold uppercase text-primary-200 tracking-wider">Fitur Dokter</p>
                </div>

                <a href="{{ route('dokter.jadwal.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dokter.jadwal.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    <span>Jadwal</span>
                </a>

                <a href="{{ route('dokter.reservasi.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dokter.reservasi.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                    <span>Reservasi</span>
                </a>

                <a href="{{ route('dokter.rekam-medis.list-pasien') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dokter.rekam-medis.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        <path d="M16 18H8v-2h8v2zm0-4H8v-2h8v2z"/>
                    </svg>
                    <span>Rekam Medis</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-4 text-xs font-semibold uppercase text-primary-200 tracking-wider">Laporan</p>
                </div>

                <a href="{{ route('dokter.reports.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dokter.reports.*') ? 'bg-white text-primary-700 shadow-md' : 'text-primary-100 hover:bg-white hover:text-primary-700' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                    </svg>
                    <span>Laporan</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- Logout Button -->
    <div class="px-8 ">
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-gray-100 text-primary-700 font-medium rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

