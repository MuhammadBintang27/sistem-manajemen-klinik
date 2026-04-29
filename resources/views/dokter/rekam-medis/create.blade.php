<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Buat Rekam Medis Baru</h2>
                <p class="mt-1 text-sm text-slate-600">Pasien: {{ $reservasi->pasien->nama }}</p>
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
        {{-- Error Messages --}}
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

        {{-- Form --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Isi Data Rekam Medis</h3>
            </div>

            <form method="POST" action="{{ route('dokter.rekam-medis.store', $reservasi) }}" class="p-6 space-y-6">
                @csrf

                {{-- Keluhan --}}
                <div>
                    <label for="keluhan" class="block text-sm font-semibold text-slate-900 mb-2">
                        Keluhan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="keluhan" 
                        name="keluhan" 
                        rows="3" 
                        class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-4 py-2"
                        placeholder="Tuliskan keluhan pasien"
                        required>{{ old('keluhan') }}</textarea>
                    <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                </div>

                {{-- DIAGNOSA (SOAP Format) --}}
                <div class="border-t-2 pt-6">
                    <label class="block text-lg font-semibold text-slate-900 mb-4">
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
                            rows="4" 
                            class="block w-full rounded-lg border border-blue-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 px-4 py-2"
                            placeholder="Keluhan utama, riwayat penyakit, gejala yang dirasakan pasien..."
                            required>{{ old('subjective') }}</textarea>
                        <p class="text-xs text-blue-700 mt-2">Informasi yang diceritakan langsung oleh pasien</p>
                        <x-input-error :messages="$errors->get('subjective')" class="mt-2" />
                    </div>

                    {{-- O - Objective --}}
                    <div class="mb-4 bg-green-50 border border-green-200 rounded-lg p-4">
                        <label for="objective" class="block text-sm font-semibold text-green-900 mb-2">
                            O - Objective (Pemeriksaan Fisik & Tanda Vital)
                        </label>
                        <textarea 
                            id="objective" 
                            name="objective" 
                            rows="4" 
                            class="block w-full rounded-lg border border-green-300 bg-white shadow-sm focus:border-green-500 focus:ring-green-500 px-4 py-2"
                            placeholder="Tekanan darah, suhu tubuh, pemeriksaan fisik, hasil laboratorium..."
                            required>{{ old('objective') }}</textarea>
                        <p class="text-xs text-green-700 mt-2">Data yang diukur dan diamati melalui pemeriksaan</p>
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
                            rows="4" 
                            class="block w-full rounded-lg border border-yellow-300 bg-white shadow-sm focus:border-yellow-500 focus:ring-yellow-500 px-4 py-2"
                            placeholder="Diagnosa penyakit, penilaian klinis, analisis kondisi pasien..."
                            required>{{ old('assessment') }}</textarea>
                        <p class="text-xs text-yellow-700 mt-2">Analisis dan kesimpulan berdasarkan S dan O</p>
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
                            rows="4" 
                            class="block w-full rounded-lg border border-purple-300 bg-white shadow-sm focus:border-purple-500 focus:ring-purple-500 px-4 py-2"
                            placeholder="Rencana pemeriksaan lanjutan, resep obat, tindakan medis..."
                            required>{{ old('plan') }}</textarea>
                        <p class="text-xs text-purple-700 mt-2">Rencana tindakan yang akan dilakukan ke depan</p>
                        <x-input-error :messages="$errors->get('plan')" class="mt-2" />
                    </div>
                </div>

                {{-- Terapi --}}
                <div>
                    <label for="terapi" class="block text-sm font-semibold text-slate-900 mb-2">
                        Terapi / Tindakan Lanjutan <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="terapi" 
                        name="terapi" 
                        rows="3" 
                        class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-4 py-2"
                        placeholder="Rencana terapi atau tindakan yang diberikan"
                        required>{{ old('terapi') }}</textarea>
                    <x-input-error :messages="$errors->get('terapi')" class="mt-2" />
                </div>

                {{-- Tarif --}}
                <div>
                    <label for="tarif" class="block text-sm font-semibold text-slate-900 mb-2">
                        Tarif Penanganan (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="tarif" 
                        name="tarif" 
                        min="0" 
                        step="1000"
                        class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-4 py-2"
                        placeholder="Contoh: 150000"
                        value="{{ old('tarif') }}"
                        required>
                    <x-input-error :messages="$errors->get('tarif')" class="mt-2" />
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">
                    <a href="{{ route('dokter.reservasi.show', $reservasi) }}" class="px-6 py-2 bg-slate-300 hover:bg-slate-400 text-slate-900 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
