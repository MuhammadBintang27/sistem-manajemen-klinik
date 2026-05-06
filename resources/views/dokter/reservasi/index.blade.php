<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Daftar Reservasi</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-secondary-50 border border-secondary-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-slate-700">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-center gap-3">
                <svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Daftar Reservasi Pasien
                </h3>
                <p class="mt-1 text-sm text-primary-100">Kelola semua reservasi pasien Anda</p>
            </div>

            {{-- Filter Section --}}
            <div class="p-6 border-b border-secondary-100 bg-gradient-to-r from-slate-50/50 to-white">
                <form method="GET" action="{{ route('dokter.reservasi.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- Search --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.7.7l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                                Cari Pasien
                            </label>
                            <input type="text" name="search" placeholder="Nama atau NIK pasien..." 
                                value="{{ $search ?? '' }}"
                                class="w-full rounded-xl border-secondary-200 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-4 transition-all">
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                            <select name="status" class="w-full rounded-xl border-secondary-200 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-4 transition-all">
                                <option value="">-- Semua Status --</option>
                                <option value="menunggu_konfirmasi" @selected($status === 'menunggu_konfirmasi')>Menunggu Konfirmasi</option>
                                <option value="sudah_dikonfirmasi" @selected($status === 'sudah_dikonfirmasi')>Sudah Dikonfirmasi</option>
                                <option value="selesai" @selected($status === 'selesai')>Selesai</option>
                                <option value="dibatalkan" @selected($status === 'dibatalkan')>Dibatalkan</option>
                            </select>
                        </div>

                        {{-- Date Range Filter --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Periode</label>
                            <select name="date_range" class="w-full rounded-xl border-secondary-200 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm py-2 px-4 transition-all">
                                <option value="today" @selected($dateRange === 'today')>Hari Ini</option>
                                <option value="week" @selected($dateRange === 'week')>1 Minggu</option>
                                <option value="month" @selected($dateRange === 'month')>1 Bulan</option>
                                <option value="all" @selected($dateRange === 'all')>Semua</option>
                            </select>
                        </div>

                        {{-- Button --}}
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.7.7l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                </svg>
                                Filter
                            </button>
                            @if($search || $status || $dateRange !== 'today')
                                <a href="{{ route('dokter.reservasi.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl transition-all">
                                    Reset
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-white">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Pasien</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Jadwal</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Keluhan</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Status</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($reservasis as $reservasi)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-4 text-sm">
                                    <div class="font-semibold text-slate-900">{{ $reservasi->pasien?->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-600">NIK: {{ $reservasi->pasien?->nik ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($reservasi->jadwal?->tanggal)->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-600">Dokter: {{ auth()->user()->name }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm text-slate-700">{{ $reservasi->keluhan ?? '-' }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($reservasi->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                        @elseif($reservasi->status === 'sudah_dikonfirmasi') bg-blue-100 text-blue-800
                                        @elseif($reservasi->status === 'selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($reservasi->status === 'menunggu_konfirmasi') Menunggu Konfirmasi
                                        @elseif($reservasi->status === 'sudah_dikonfirmasi') Sudah Dikonfirmasi
                                        @elseif($reservasi->status === 'selesai') Selesai
                                        @else Dibatalkan @endif
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <a href="{{ route('dokter.reservasi.show', $reservasi) }}" class="inline-flex items-center px-4 py-2 bg-primary-100 hover:bg-primary-200 text-primary-700 font-medium rounded-xl transition-colors">
                                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="mt-4 text-sm text-slate-600">Belum ada reservasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Info --}}
            <div class="px-8 py-4 border-t border-secondary-100 bg-slate-50/50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600">
                        Menampilkan <span class="font-semibold">{{ $reservasis->firstItem() ?? 0 }}</span> hingga 
                        <span class="font-semibold">{{ $reservasis->lastItem() ?? 0 }}</span> dari 
                        <span class="font-semibold">{{ $reservasis->total() }}</span> reservasi
                    </p>
                </div>
            </div>
        </div>

        {{-- Pagination Links --}}
        <div class="flex justify-center">
            {{ $reservasis->links() }}
        </div>
    </div>
</x-app-layout>
