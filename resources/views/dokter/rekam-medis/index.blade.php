<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Riwayat Rekam Medis</h2>
                <p class="mt-1 text-sm text-slate-600">Pasien: {{ $reservasi->pasien?->nama ?? 'Pasien' }}</p>
            </div>
            <a href="{{ route('dokter.reservasi.show', $reservasi) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Info Pasien --}}
        <div class="grid grid-cols-3 gap-6">
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-slate-900">Data Pasien</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Nama</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->pasien?->nama ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">NIK</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->pasien?->nik ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-slate-900">Jadwal</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm font-semibold text-slate-900">{{ $reservasi->jadwal?->tanggal ?? '-' }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-sm font-bold text-slate-900">Status</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                        @if($reservasi->status === 'selesai') bg-green-100 text-green-800
                        @elseif($reservasi->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                        @elseif($reservasi->status === 'sudah_dikonfirmasi') bg-blue-100 text-blue-800
                        @elseif($reservasi->status === 'dibatalkan') bg-red-100 text-red-800
                        @else bg-slate-100 text-slate-800 @endif
                    ">
                        @if($reservasi->status === 'selesai') Selesai
                        @elseif($reservasi->status === 'menunggu_konfirmasi') Menunggu Konfirmasi
                        @elseif($reservasi->status === 'sudah_dikonfirmasi') Sudah Dikonfirmasi
                        @elseif($reservasi->status === 'dibatalkan') Dibatalkan
                        @else {{ ucfirst($reservasi->status) }} @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-xl bg-secondary-50 border border-secondary-200 p-4">
                <p class="text-sm font-semibold text-primary-800">✓ {{ session('success') }}</p>
            </div>
        @endif

        {{-- List Rekam Medis --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Daftar Rekam Medis</h3>
            </div>

            @if ($rekamMedisList->isEmpty())
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-600 font-medium">Belum ada rekam medis</p>
                    <a href="{{ route('dokter.rekam-medis.create', $reservasi) }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buat Rekam Medis
                    </a>
                </div>
            @else
                <div class="divide-y divide-slate-200">
                    @foreach ($rekamMedisList as $item)
                        <div class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <p class="font-semibold text-slate-900">📅 {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                                </div>
                                <a href="{{ route('dokter.rekam-medis.show', $item) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium rounded-lg text-xs transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Lihat
                                </a>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div>
                                    <p class="text-xs text-slate-600 uppercase font-semibold mb-1">Diagnosa (SOAP)</p>
                                    <div class="space-y-1 ml-2">
                                        <div class="text-xs"><span class="font-semibold text-blue-700">S:</span> {{ substr($item->subjective ?? '-', 0, 60) }}...</div>
                                        <div class="text-xs"><span class="font-semibold text-primary-700">O:</span> {{ substr($item->objective ?? '-', 0, 60) }}...</div>
                                        <div class="text-xs"><span class="font-semibold text-yellow-700">A:</span> {{ substr($item->assessment ?? '-', 0, 60) }}...</div>
                                        <div class="text-xs"><span class="font-semibold text-purple-700">P:</span> {{ substr($item->plan ?? '-', 0, 60) }}...</div>
                                    </div>
                                </div>

                                <div class="border-t border-slate-200 pt-2">
                                    <p class="text-xs text-slate-600 uppercase font-semibold">Tarif Penanganan</p>
                                    <p class="text-sm font-semibold text-primary-700">Rp {{ number_format($item->tarif ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($reservasi->status !== 'selesai')
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                        <a href="{{ route('dokter.rekam-medis.create', $reservasi) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Rekam Medis
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
