<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Pasien</h2>
                <p class="mt-1 text-sm text-slate-600">Riwayat Rekam Medis: {{ $pasien->nama }}</p>
            </div>
            <a href="{{ route('dokter.rekam-medis.list-pasien') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Info Pasien --}}
        <div class="grid grid-cols-2 gap-6">
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Data Pasien</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold tracking-wide">Nama</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $pasien->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold tracking-wide">NIK</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $pasien->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold tracking-wide">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ ucfirst($pasien->jenis_kelamin ?? '-') }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Informasi Tambahan</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold tracking-wide">Tanggal Lahir</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">
                            @if ($pasien->tanggal_lahir)
                                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold tracking-wide">Total Rekam Medis</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $rekamMedis->count() }} catatan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Rekam Medis --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Riwayat Rekam Medis</h3>
            </div>

            @if ($rekamMedis->count() > 0)
                <div class="divide-y divide-slate-200">
                    @foreach ($rekamMedis as $rm)
                        <div class="px-6 py-4 hover:bg-slate-50 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                        📋
                                    </div>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($rm->tanggal)->format('d M Y') }}</p>
                                        <p class="text-xs text-slate-600">Dokter: {{ $rm->dokter?->nama ?? 'Dokter' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('dokter.rekam-medis.edit', $rm) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium rounded-lg text-xs transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>
                            </div>

                            {{-- Collapsible Details --}}
                            <div class="ml-13 space-y-3 text-sm">
                                <div>
                                    <p class="text-xs text-slate-600 uppercase font-semibold mb-1">Keluhan</p>
                                    <p class="text-slate-700">{{ $rm->keluhan ?? '-' }}</p>
                                </div>

                                {{-- DIAGNOSA (SOAP) --}}
                                <div class="border-t border-slate-200 pt-3">
                                    <p class="text-xs text-slate-600 uppercase font-semibold mb-2">Diagnosa (Format SOAP)</p>
                                    
                                    <div class="space-y-2 ml-2">
                                        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded">
                                            <p class="text-xs font-semibold text-blue-900 mb-1">S - Subjective:</p>
                                            <p class="text-slate-700 text-xs">{{ $rm->subjective ?? '-' }}</p>
                                        </div>
                                        
                                        <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded">
                                            <p class="text-xs font-semibold text-green-900 mb-1">O - Objective:</p>
                                            <p class="text-slate-700 text-xs">{{ $rm->objective ?? '-' }}</p>
                                        </div>
                                        
                                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                                            <p class="text-xs font-semibold text-yellow-900 mb-1">A - Assessment:</p>
                                            <p class="text-slate-700 text-xs">{{ $rm->assessment ?? '-' }}</p>
                                        </div>
                                        
                                        <div class="bg-purple-50 border-l-4 border-purple-500 p-3 rounded">
                                            <p class="text-xs font-semibold text-purple-900 mb-1">P - Plan:</p>
                                            <p class="text-slate-700 text-xs">{{ $rm->plan ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-600 uppercase font-semibold mb-1">Terapi</p>
                                    <p class="text-slate-700">{{ $rm->terapi ?? '-' }}</p>
                                </div>

                                <div class="border-t border-slate-200 pt-3">
                                    <p class="text-xs text-slate-600 uppercase font-semibold">Tarif Penanganan</p>
                                    <p class="text-sm font-semibold text-green-700">Rp {{ number_format($rm->tarif ?? 0, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-slate-600 font-medium">Tidak ada rekam medis</p>
                    <p class="text-sm text-slate-500 mt-1">Belum ada catatan rekam medis untuk pasien ini</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleDetail(id) {
            const detail = document.getElementById('detail-' + id);
            const arrow = document.getElementById('arrow-' + id);
            detail.classList.toggle('hidden');
            arrow.style.transform = detail.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    </script>
</x-app-layout>
