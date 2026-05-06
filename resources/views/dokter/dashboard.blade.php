<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Dokter Dashboard</h2>
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold">
                <span class="inline-flex h-3 w-3 rounded-full bg-primary-600"></span>
                {{ $jadwals->count() }} Jadwal
            </span>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Welcome Card -->
        <div class="rounded-2xl bg-gradient-to-r from-primary-600 to-primary-700 shadow-lg overflow-hidden text-white">
            <div class="px-8 py-12 sm:px-10">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-widest text-primary-100">Dashboard Dokter</p>
                        <h1 class="mt-3 text-4xl font-bold">Pantau Pasien & Jadwal</h1>
                        <p class="mt-2 text-lg text-primary-100">Ringkasan reservasi dan jadwal Anda dalam satu halaman.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Card 1: Total Reservasi -->
            <div class="rounded-2xl bg-white border border-primary-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Total Reservasi</p>
                        <p class="mt-4 text-5xl font-bold text-primary-600">{{ $reservasiCount }}</p>
                        <p class="mt-2 text-sm text-slate-600">Jumlah reservasi yang terdaftar untuk Anda</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-primary-100 to-secondary-50">
                            <svg class="h-8 w-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Reservasi Pending -->
            <div class="rounded-2xl bg-white border border-primary-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Reservasi Pending</p>
                        <p class="mt-4 text-5xl font-bold text-primary-600">{{ $pendingCount }}</p>
                        <p class="mt-2 text-sm text-slate-600">Masih menunggu tindakan Anda</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50">
                            <svg class="h-8 w-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Jadwal Mendatang -->
            <div class="rounded-2xl bg-white border border-primary-100 shadow-md hover:shadow-lg transition-shadow p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase text-slate-600 tracking-wider">Jadwal Mendatang</p>
                        <p class="mt-4 text-5xl font-bold text-primary-600">{{ $jadwals->count() }}</p>
                        <p class="mt-2 text-sm text-slate-600">Slot praktik yang terjadwal</p>
                    </div>
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-16 w-16 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50">
                            <svg class="h-8 w-8 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('dokter.jadwal.index') }}" class="rounded-2xl bg-white border border-secondary-100 shadow-md hover:shadow-lg hover:border-secondary-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-secondary-100 to-secondary-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Jadwal Saya</p>
                <p class="mt-1 text-sm text-slate-600">Lihat jadwal praktik</p>
            </a>

            <a href="{{ route('dokter.reservasi.index') }}" class="rounded-2xl bg-white border border-primary-100 shadow-md hover:shadow-lg hover:border-primary-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Reservasi Pasien</p>
                <p class="mt-1 text-sm text-slate-600">Kelola reservasi</p>
            </a>

            <a href="{{ route('dokter.reservasi.index') }}" class="rounded-2xl bg-white border border-primary-100 shadow-md hover:shadow-lg hover:border-primary-300 transition-all p-6 text-center">
                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-br from-primary-100 to-primary-50 mx-auto mb-4">
                    <svg class="h-7 w-7 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                    </svg>
                </div>
                <p class="font-semibold text-slate-900">Rekam Medis</p>
                <p class="mt-1 text-sm text-slate-600">Lihat catatan medis</p>
            </a>
        </div>

        <!-- Jadwal Table -->
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-8 py-6">
                <h3 class="text-lg font-bold text-slate-900">Jadwal Praktik Mendatang</h3>
                <p class="mt-1 text-sm text-slate-600">Daftar lengkap jadwal praktik Anda</p>
            </div>

            @if ($jadwals->isEmpty())
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-sm text-slate-600">Belum ada jadwal yang terdaftar untuk Anda.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-secondary-100">
                        <thead class="bg-gradient-to-r from-secondary-50 to-white">
                            <tr>
                                <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Tanggal</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Waktu</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Kuota</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Pasien Terdaftar</th>
                                <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary-100">
                            @foreach ($jadwals as $jadwal)
                                <tr class="hover:bg-secondary-50 transition-colors">
                                    <td class="px-8 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-700">{{ $jadwal->kuota }} pasien</td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-secondary-100 text-primary-700">{{ $jadwal->reservasi()->count() }}</span>
                                    </td>
                                    <td class="px-8 py-4 whitespace-nowrap text-sm">
                                        @if ($jadwal->reservasi()->count() >= $jadwal->kuota)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">Penuh</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-secondary-100 text-primary-700">Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

