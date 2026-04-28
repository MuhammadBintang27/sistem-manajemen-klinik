<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Reservasi</h2>
                <p class="mt-1 text-sm text-slate-600">ID Reservasi: {{ $reservasi->id_reservasi }}</p>
            </div>
            <a href="{{ route('dokter.reservasi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if ($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 p-4">
                <p class="text-sm font-semibold text-red-800 mb-2">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Grid untuk 3 section utama --}}
        <div class="grid grid-cols-3 gap-6">
            {{-- Info Pasien --}}
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Data Pasien</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Nama</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->pasien->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">NIK</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->pasien->nik }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Jadwal --}}
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Data Jadwal</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Tanggal Jadwal</p>
                        <p class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Kuota</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->jadwal->kuota }}</p>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Status Reservasi</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($reservasi->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($reservasi->status === 'selesai') bg-green-100 text-green-800
                        @else bg-slate-100 text-slate-800 @endif">
                        {{ ucfirst($reservasi->status) }}
                    </span>
                    <p class="mt-3 text-xs text-slate-600">Dibuat: {{ $reservasi->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs text-slate-600">Diperbarui: {{ $reservasi->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Keluhan --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Keluhan Pasien</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-slate-700">{{ $reservasi->keluhan ?? '-' }}</p>
            </div>
        </div>

        {{-- Riwayat Rekam Medis --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Riwayat Rekam Medis</h3>
            </div>
            <div class="px-6 py-4">
                @forelse ($reservasi->pasien->rekamMedis as $rm)
                    <div class="mb-4 pb-4 border-b border-slate-200 last:border-b-0 last:mb-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-slate-900">📅 {{ \Carbon\Carbon::parse($rm->tanggal)->format('d M Y') }}</p>
                            <button 
                                type="button"
                                onclick="toggleDetail({{ $rm->id_rekam_medis }})"
                                id="arrow-{{ $rm->id_rekam_medis }}"
                                class="text-slate-600 hover:text-slate-900 transition-transform">
                                ▼
                            </button>
                        </div>
                        <div id="detail-{{ $rm->id_rekam_medis }}" class="hidden space-y-2 text-sm">
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Keluhan</p>
                                <p class="text-slate-700">{{ $rm->keluhan }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Diagnosa</p>
                                <p class="text-slate-700">{{ $rm->diagnosa }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Terapi</p>
                                <p class="text-slate-700">{{ $rm->terapi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600 italic">Belum ada rekam medis</p>
                @endforelse
            </div>
        </div>

        {{-- Form Selesaikan Penanganan --}}
        @if ($reservasi->status !== 'selesai')
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Isi Rekam Medis Baru & Selesaikan Penanganan</h3>
                </div>
                <form method="POST" action="{{ route('dokter.rekam-medis.store', $reservasi) }}" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        {{-- Keluhan --}}
                        <div class="col-span-2">
                            <label for="keluhan" class="block text-sm font-semibold text-slate-900 mb-2">
                                Keluhan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="keluhan" 
                                name="keluhan" 
                                rows="4" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Tuliskan keluhan pasien"
                                required></textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        {{-- Diagnosa --}}
                        <div class="col-span-1">
                            <label for="diagnosa" class="block text-sm font-semibold text-slate-900 mb-2">
                                Diagnosa <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="diagnosa" 
                                name="diagnosa" 
                                rows="3" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Hasil diagnosis"
                                required></textarea>
                            <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                        </div>

                        {{-- Terapi --}}
                        <div class="col-span-1">
                            <label for="terapi" class="block text-sm font-semibold text-slate-900 mb-2">
                                Terapi <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="terapi" 
                                name="terapi" 
                                rows="3" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Rencana terapi"
                                required></textarea>
                            <x-input-error :messages="$errors->get('terapi')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 justify-end border-t border-slate-200">
                        <a href="{{ route('dokter.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                            ← Kembali
                        </a>
                        <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors">
                            ✓ Simpan & Selesaikan Penanganan
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-2xl bg-green-50 border border-green-200 shadow-md overflow-hidden p-6">
                <p class="text-green-700 font-semibold text-center mb-4">✓ Penanganan untuk reservasi ini sudah selesai</p>
                <div class="flex justify-center">
                    <a href="{{ route('dokter.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                        ← Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        function toggleDetail(rmId) {
            const detail = document.getElementById(`detail-${rmId}`);
            const arrow = document.getElementById(`arrow-${rmId}`);
            
            detail.classList.toggle('hidden');
            arrow.style.transform = detail.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }
    </script>
</x-app-layout>
