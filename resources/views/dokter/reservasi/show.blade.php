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
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
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
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
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
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Status Reservasi</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($reservasi->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                        @elseif($reservasi->status === 'sudah_dikonfirmasi') bg-blue-100 text-blue-800
                        @elseif($reservasi->status === 'selesai') bg-green-100 text-green-800
                        @elseif($reservasi->status === 'dibatalkan') bg-red-100 text-red-800
                        @else bg-slate-100 text-slate-800 @endif">
                        @if($reservasi->status === 'menunggu_konfirmasi')
                            Menunggu Konfirmasi
                        @elseif($reservasi->status === 'sudah_dikonfirmasi')
                            Sudah Dikonfirmasi
                        @elseif($reservasi->status === 'selesai')
                            Selesai
                        @elseif($reservasi->status === 'dibatalkan')
                            Dibatalkan
                        @else
                            {{ ucfirst($reservasi->status) }}
                        @endif
                    </span>
                    <p class="mt-3 text-xs text-slate-600">Dibuat: {{ $reservasi->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs text-slate-600">Diperbarui: {{ $reservasi->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Keluhan --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Keluhan Pasien</h3>
            </div>
            <div class="px-6 py-4">
                <p class="text-slate-700">{{ $reservasi->keluhan ?? '-' }}</p>
            </div>
        </div>

        {{-- Riwayat Rekam Medis --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Riwayat Rekam Medis</h3>
            </div>
            <div class="px-6 py-4">
                @forelse ($reservasi->pasien->rekamMedis->sortByDesc('tanggal') as $rm)
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
                        <div id="detail-{{ $rm->id_rekam_medis }}" class="hidden space-y-3 text-sm">
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Keluhan</p>
                                <p class="text-slate-700">{{ $rm->keluhan }}</p>
                            </div>
                            
                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-xs text-slate-600 uppercase font-semibold mb-2">DIAGNOSA (Format SOAP)</p>
                                
                                <div class="ml-3 space-y-2 bg-blue-50 border-l-4 border-blue-500 p-3 rounded mb-2">
                                    <p class="text-xs font-semibold text-blue-900">S - Subjective:</p>
                                    <p class="text-slate-700 text-xs">{{ $rm->subjective ?? '-' }}</p>
                                </div>
                                
                                <div class="ml-3 space-y-2 bg-secondary-50 border-l-4 border-primary-500 p-3 rounded mb-2">
                                    <p class="text-xs font-semibold text-slate-900">O - Objective:</p>
                                    <p class="text-slate-700 text-xs">{{ $rm->objective ?? '-' }}</p>
                                </div>
                                
                                <div class="ml-3 space-y-2 bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded mb-2">
                                    <p class="text-xs font-semibold text-yellow-900">A - Assessment:</p>
                                    <p class="text-slate-700 text-xs">{{ $rm->assessment ?? '-' }}</p>
                                </div>
                                
                                <div class="ml-3 space-y-2 bg-purple-50 border-l-4 border-purple-500 p-3 rounded">
                                    <p class="text-xs font-semibold text-purple-900">P - Plan:</p>
                                    <p class="text-slate-700 text-xs">{{ $rm->plan ?? '-' }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-xs text-slate-600 uppercase font-semibold">Terapi</p>
                                <p class="text-slate-700">{{ $rm->terapi }}</p>
                            </div>

                            <div class="border-t border-slate-200 pt-3">
                                <p class="text-xs text-slate-600 uppercase font-semibold">Tarif Penanganan</p>
                                <p class="text-sm font-semibold text-primary-700">Rp {{ number_format($rm->tarif ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600 italic">Belum ada rekam medis</p>
                @endforelse
            </div>
        </div>

        {{-- Form Selesaikan Penanganan --}}
        @if ($reservasi->status === 'menunggu_konfirmasi' || $reservasi->status === 'sudah_dikonfirmasi')
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
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
                                rows="3" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Tuliskan keluhan pasien"
                                required></textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        {{-- DIAGNOSA (SOAP Format) --}}
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-slate-900 mb-3">
                                Diagnosa (Format SOAP) <span class="text-red-500">*</span>
                            </label>
                            
                            {{-- S - Subjective --}}
                            <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <label for="subjective" class="block text-sm font-semibold text-blue-900 mb-2">
                                    S - Subjective (Keluhan & Anamnesis)
                                </label>
                                <textarea 
                                    id="subjective" 
                                    name="subjective" 
                                    rows="3" 
                                    class="block w-full rounded-lg border border-blue-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Keluhan utama, riwayat penyakit, gejala yang dirasakan pasien..."
                                    required></textarea>
                                <p class="text-xs text-blue-700 mt-1">Informasi yang diceritakan langsung oleh pasien</p>
                                <x-input-error :messages="$errors->get('subjective')" class="mt-2" />
                            </div>

                            {{-- O - Objective --}}
                            <div class="mb-4 bg-secondary-50 border border-secondary-200 rounded-lg p-4">
                                <label for="objective" class="block text-sm font-semibold text-slate-900 mb-2">
                                    O - Objective (Pemeriksaan Fisik & Tanda Vital)
                                </label>
                                <textarea 
                                    id="objective" 
                                    name="objective" 
                                    rows="3" 
                                    class="block w-full rounded-lg border border-primary-300 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="Tekanan darah, suhu tubuh, pemeriksaan fisik, hasil laboratorium..."
                                    required></textarea>
                                <p class="text-xs text-primary-700 mt-1">Data yang diukur dan diamati melalui pemeriksaan</p>
                                <x-input-error :messages="$errors->get('objective')" class="mt-2" />
                            </div>

                            {{-- A - Assessment --}}
                            <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <label for="assessment" class="block text-sm font-semibold text-yellow-900 mb-2">
                                    A - Assessment (Penilaian & Diagnosa)
                                </label>
                                <textarea 
                                    id="assessment" 
                                    name="assessment" 
                                    rows="3" 
                                    class="block w-full rounded-lg border border-yellow-300 bg-white shadow-sm focus:border-yellow-500 focus:ring-yellow-500"
                                    placeholder="Diagnosa penyakit, penilaian klinis, analisis kondisi pasien..."
                                    required></textarea>
                                <p class="text-xs text-yellow-700 mt-1">Analisis dan kesimpulan berdasarkan S dan O</p>
                                <x-input-error :messages="$errors->get('assessment')" class="mt-2" />
                            </div>

                            {{-- P - Plan --}}
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <label for="plan" class="block text-sm font-semibold text-purple-900 mb-2">
                                    P - Plan (Rencana Tindakan)
                                </label>
                                <textarea 
                                    id="plan" 
                                    name="plan" 
                                    rows="3" 
                                    class="block w-full rounded-lg border border-purple-300 bg-white shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                    placeholder="Rencana pemeriksaan lanjutan, resep obat, tindakan medis..."
                                    required></textarea>
                                <p class="text-xs text-purple-700 mt-1">Rencana tindakan yang akan dilakukan ke depan</p>
                                <x-input-error :messages="$errors->get('plan')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Terapi --}}
                        <div class="col-span-2">
                            <label for="terapi" class="block text-sm font-semibold text-slate-900 mb-2">
                                Terapi / Tindakan Lanjutan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="terapi" 
                                name="terapi" 
                                rows="3" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Rencana terapi atau tindakan yang diberikan"
                                required></textarea>
                            <x-input-error :messages="$errors->get('terapi')" class="mt-2" />
                        </div>

                        {{-- Tarif --}}
                        <div class="col-span-2">
                            <label for="tarif" class="block text-sm font-semibold text-slate-900 mb-2">
                                Tarif Penanganan (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="tarif" 
                                name="tarif" 
                                min="0" 
                                step="1000"
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Contoh: 150000"
                                required>
                            <x-input-error :messages="$errors->get('tarif')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 justify-end border-t border-slate-200">
                        <a href="{{ route('dokter.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                            ← Kembali
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                            ✓ Simpan & Selesaikan Penanganan
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="rounded-2xl bg-amber-50 border border-amber-200 shadow-md overflow-hidden p-6">
                <p class="text-amber-700 font-semibold text-center mb-4">
                    @if ($reservasi->status === 'dibatalkan')
                        ✗ Reservasi ini telah dibatalkan
                    @else
                        ✓ Penanganan untuk reservasi ini sudah selesai
                    @endif
                </p>
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
