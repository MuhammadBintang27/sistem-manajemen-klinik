<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Rekam Medis</h2>
                <p class="mt-1 text-sm text-slate-600">{{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d M Y') }} • Pasien: {{ $reservasi->pasien?->nama }}</p>
            </div>
            <a href="{{ route('dokter.rekam-medis.index', $reservasi) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-xl bg-secondary-50 border border-secondary-200 p-4">
                <p class="text-sm font-semibold text-slate-700">✓ {{ session('success') }}</p>
            </div>
        @endif

        {{-- Info Pasien --}}
        <div class="grid grid-cols-3 gap-6">
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Data Pasien</h3>
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
                    <h3 class="text-lg font-bold text-slate-900">Jadwal</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm font-semibold text-slate-900">{{ $reservasi->jadwal?->tanggal ?? '-' }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Status</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                        @if($reservasi->status === 'selesai') bg-secondary-100 text-primary-800
                        @else bg-yellow-100 text-yellow-800 @endif
                    ">{{ ucfirst($reservasi->status) }}</span>
                </div>
            </div>
        </div>

        {{-- Keluhan --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Keluhan Pasien</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-slate-700 whitespace-pre-wrap">{{ $rekamMedis->keluhan ?? '-' }}</p>
            </div>
        </div>

        {{-- DIAGNOSA (SOAP Format) --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Diagnosa (Format SOAP)</h3>
            </div>
            <div class="p-6 space-y-3">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <h4 class="font-semibold text-blue-900 mb-2">S - Subjective (Keluhan & Anamnesis)</h4>
                    <p class="text-slate-700 whitespace-pre-wrap text-sm">{{ $rekamMedis->subjective ?? '-' }}</p>
                </div>

                <div class="bg-secondary-50 border-l-4 border-primary-500 p-4 rounded">
                    <h4 class="font-semibold text-green-900 mb-2">O - Objective (Pemeriksaan Fisik & Tanda Vital)</h4>
                    <p class="text-slate-700 whitespace-pre-wrap text-sm">{{ $rekamMedis->objective ?? '-' }}</p>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                    <h4 class="font-semibold text-yellow-900 mb-2">A - Assessment (Penilaian & Diagnosa)</h4>
                    <p class="text-slate-700 whitespace-pre-wrap text-sm">{{ $rekamMedis->assessment ?? '-' }}</p>
                </div>

                <div class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded">
                    <h4 class="font-semibold text-purple-900 mb-2">P - Plan (Rencana Tindakan)</h4>
                    <p class="text-slate-700 whitespace-pre-wrap text-sm">{{ $rekamMedis->plan ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Terapi --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Terapi / Tindakan Lanjutan</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-slate-700 whitespace-pre-wrap">{{ $rekamMedis->terapi ?? '-' }}</p>
            </div>
        </div>

        {{-- Tarif --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Tarif Penanganan</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-lg font-semibold text-green-700">Rp {{ number_format($rekamMedis->tarif ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3">
            @if ($reservasi->status !== 'selesai')
                <form method="POST" action="{{ route('dokter.rekam-medis.mark-complete', $rekamMedis) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tandai Selesai
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
