<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Admin Dashboard</h2>
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                <span class="inline-flex h-3 w-3 rounded-full bg-green-600 animate-pulse"></span>
                {{ $reservasiPending }} Pending
            </span>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Welcome Card -->
        <div class="rounded-2xl bg-gradient-to-r from-green-600 to-green-700 shadow-lg overflow-hidden text-white">
            <div class="px-8 py-12 sm:px-10">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-widest text-green-100">Selamat datang</p>
                        <h1 class="mt-3 text-4xl font-bold">Kelola Klinik dengan Cepat</h1>
                        <p class="mt-2 text-lg text-green-100">Semua pengaturan pasien, jadwal, dan reservasi hadir di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Card 1: Total Pasien -->
            <div class="rounded-2xl bg-white border border-green-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Total Pasien</p>
                        <p class="mt-4 text-5xl font-bold text-green-600">{{ $pasienCount }}</p>
                        <p class="mt-2 text-sm text-slate-600">Data pasien terdaftar di klinik</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-green-100 to-green-50">
                            <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total Jadwal -->
            <div class="rounded-2xl bg-white border border-green-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Total Jadwal</p>
                        <p class="mt-4 text-5xl font-bold text-green-600">{{ $jadwalCount }}</p>
                        <p class="mt-2 text-sm text-slate-600">Slot praktik dokter yang tersedia</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-green-100 to-green-50">
                            <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Reservasi Pending -->
            <div class="rounded-2xl bg-white border border-orange-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Reservasi Pending</p>
                        <p class="mt-4 text-5xl font-bold text-orange-600">{{ $reservasiPending }}</p>
                        <p class="mt-2 text-sm text-slate-600">Menunggu konfirmasi Anda</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50">
                            <svg class="h-8 w-8 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <a href="{{ route('admin.pasien.index') }}" class="rounded-2xl bg-white border border-green-100 shadow-md hover:shadow-lg hover:border-green-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-green-100 to-green-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Kelola Pasien</p>
                <p class="mt-1 text-sm text-slate-600">Tambah & edit data</p>
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="rounded-2xl bg-white border border-green-100 shadow-md hover:shadow-lg hover:border-green-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-green-100 to-green-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Jadwal Dokter</p>
                <p class="mt-1 text-sm text-slate-600">Atur jadwal</p>
            </a>

            <a href="{{ route('admin.reservasi.index') }}" class="rounded-2xl bg-white border border-orange-100 shadow-md hover:shadow-lg hover:border-orange-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Reservasi</p>
                <p class="mt-1 text-sm text-slate-600">Kelola reservasi</p>
            </a>

            <div class="rounded-2xl bg-gradient-to-br from-green-50 to-white border border-green-100 shadow-md p-6">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-green-100 to-green-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900 text-center">Sistem Berjalan</p>
                <p class="mt-1 text-sm text-slate-600 text-center">Semua fitur aktif</p>
            </div>
        </div>
    </div>
</x-app-layout>

