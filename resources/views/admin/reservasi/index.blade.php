<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Manajemen Reservasi</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-secondary-100 border border-secondary-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-primary-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="rounded-2xl bg-white border border-primary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Daftar Reservasi
                </h3>
                <p class="mt-1 text-sm text-primary-100">Kelola semua reservasi pasien dan dokter</p>
            </div>

           

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-primary-100">
                    <thead class="bg-gradient-to-r from-primary-50 to-white">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Pasien</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Jadwal</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Keluhan</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Status</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary-100">
                        @foreach ($reservasis as $reservasi)
                            <tr class="hover:bg-primary-50 transition-colors">
                                <td class="px-8 py-4 text-sm">
                                    <div class="font-semibold text-slate-900">{{ $reservasi->pasien?->nama ?? '-' }}</div>
                                    <div class="text-xs text-slate-600">NIK: {{ $reservasi->pasien?->nik ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <div class="font-medium text-slate-900">{{ \Carbon\Carbon::parse($reservasi->jadwal?->tanggal)->format('d M Y') }}</div>
                                    <div class="text-xs text-slate-600">Dokter: {{ $reservasi->jadwal?->dokter?->nama ?? '-' }}</div>
                                </td>
                                <td class="px-8 py-4 text-sm text-slate-700">{{ $reservasi->keluhan ?? '-' }}</td>
                                <td class="px-8 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($reservasi->status === 'sudah_dikonfirmasi') bg-blue-100 text-blue-800
                                        @elseif($reservasi->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                        @elseif($reservasi->status === 'selesai') bg-green-100 text-green-800
                                        @elseif($reservasi->status === 'dibatalkan') bg-red-100 text-red-800
                                        @else bg-slate-100 text-slate-800 @endif">
                                        @if($reservasi->status === 'sudah_dikonfirmasi')
                                            Sudah Dikonfirmasi
                                        @elseif($reservasi->status === 'menunggu_konfirmasi')
                                            Menunggu Konfirmasi
                                        @elseif($reservasi->status === 'selesai')
                                            Selesai
                                        @elseif($reservasi->status === 'dibatalkan')
                                            Dibatalkan
                                        @else
                                            {{ ucfirst($reservasi->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-sm">
                                    <a href="{{ route('admin.reservasi.show', $reservasi) }}" class="inline-flex items-center px-4 py-2 bg-primary-100 hover:bg-primary-200 text-primary-700 font-medium rounded-xl transition-colors">
                                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($reservasis->count() === 0)
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-sm text-slate-600">Belum ada reservasi.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $reservasis->links() }}
        </div>
    </div>
</x-app-layout>

