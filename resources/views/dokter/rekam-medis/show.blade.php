<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Rekam Medis') }}
            </h2>
            <a href="{{ route('dokter.rekam-medis.index', $reservasi) }}" class="text-sm text-indigo-600 hover:text-indigo-900">← Kembali ke Riwayat</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold">Pasien</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reservasi->pasien?->nama ?? '-' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">NIK: {{ $reservasi->pasien?->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Jadwal</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $reservasi->jadwal?->tanggal ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Status Reservasi</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $reservasi->status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($reservasi->status) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Tanggal Rekam Medis</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Keluhan</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $rekamMedis->keluhan ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Diagnosa</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $rekamMedis->diagnosa }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Terapi</h3>
                            <p class="text-gray-900 dark:text-gray-100">{{ $rekamMedis->terapi }}</p>
                        </div>

                        <!-- Button Tandai Selesai -->
                        @if ($reservasi->status !== 'selesai')
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <form method="POST" action="{{ route('dokter.rekam-medis.mark-complete', $rekamMedis) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                        ✓ Tandai Selesai Penanganan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
