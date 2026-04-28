<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Rekam Medis - ') }} {{ $reservasi->pasien?->nama ?? 'Pasien' }}
            </h2>
            <a href="{{ route('dokter.reservasi.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">← Kembali ke Reservasi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Pasien dan Jadwal -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold">Data Pasien</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reservasi->pasien?->nama ?? '-' }} • NIK: {{ $reservasi->pasien?->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Jadwal Pemeriksaan</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reservasi->jadwal?->tanggal ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Status Reservasi</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            @if($reservasi->status === 'selesai')
                                bg-green-100 text-green-800
                            @elseif($reservasi->status === 'confirmed')
                                bg-blue-100 text-blue-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif
                        ">{{ ucfirst($reservasi->status) }}</span>
                    </div>
                </div>
            </div>

            <!-- List Rekam Medis -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($rekamMedisList->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada rekam medis untuk reservasi ini</p>
                            <a href="{{ route('dokter.rekam-medis.create', $reservasi) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                + Buat Rekam Medis
                            </a>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($rekamMedisList as $item)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer"
                                     onclick="window.location.href='{{ route('dokter.rekam-medis.show', $item) }}'">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Tanggal: {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                                                @if ($loop->first && $reservasi->status !== 'selesai')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Terbaru</span>
                                                @endif
                                            </div>
                                            <div class="mt-3 space-y-2">
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Diagnosa</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $item->diagnosa }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Terapi</p>
                                                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $item->terapi }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if ($rekamMedisList->first()?->id_rekam_medis && $reservasi->status !== 'selesai')
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('dokter.rekam-medis.create', $reservasi) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                        + Tambah Rekam Medis Baru
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
