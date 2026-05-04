<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Reservasi</h2>
                <p class="mt-1 text-sm text-slate-600">ID Reservasi: {{ $reservasi->id_reservasi }}</p>
            </div>
            <a href="{{ route('admin.reservasi.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

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

        <div class="grid grid-cols-3 gap-6">
            <!-- Info Pasien -->
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
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Tanggal Lahir</p>
                        <p class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($reservasi->pasien->tanggal_lahir)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">No. Telepon</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->pasien->no_telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Jadwal & Dokter -->
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Data Jadwal & Dokter</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Dokter</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->jadwal->dokter->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Tanggal Jadwal</p>
                        <p class="text-sm font-semibold text-slate-900">{{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Kuota Tersedia</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $reservasi->jadwal->kuota }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Status Jadwal</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                            @if($reservasi->jadwal->status === 'aktif') bg-secondary-100 text-primary-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($reservasi->jadwal->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Status Reservasi</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
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
                    </span>
                    <p class="mt-3 text-xs text-slate-600">Dibuat: {{ $reservasi->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs text-slate-600">Diperbarui: {{ $reservasi->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Rekam Medis -->
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

                            {{-- Foto Pemeriksaan --}}
                            @if($rm->fotoRekamMedis->count() > 0)
                                <div class="border-t border-slate-200 pt-3">
                                    <p class="text-xs text-slate-600 uppercase font-semibold mb-2">Foto Pemeriksaan ({{ $rm->fotoRekamMedis->count() }}/5)</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                                        @foreach($rm->fotoRekamMedis as $foto)
                                            <button type="button" onclick="openPhotoModal('{{ route('storage.private', ['path' => $foto->foto_path]) }}', '{{ basename($foto->foto_path) }}')" class="relative group">
                                                <img src="{{ route('storage.private', ['path' => $foto->foto_path]) }}" 
                                                     alt="Foto Pemeriksaan" 
                                                     class="w-full h-20 object-cover rounded border border-slate-300 hover:border-primary-500 transition-colors cursor-pointer">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded transition-all flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                    </svg>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600 italic">Belum ada rekam medis</p>
                @endforelse
            </div>
        </div>

        <!-- Form Edit -->
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Edit Reservasi</h3>
            </div>
            <form method="POST" action="{{ route('admin.reservasi.update', $reservasi) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-2 gap-6">
                    <!-- Keluhan -->
                    <div class="col-span-2">
                        <x-input-label for="keluhan" value="Keluhan" />
                        <textarea id="keluhan" name="keluhan" rows="4" class="block mt-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ $reservasi->keluhan }}</textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>

                    <!-- Pilih Jadwal dengan Date Picker -->
                    <div class="col-span-2">
                        <x-input-label for="jadwalTanggalAdmin" value="Pilih Jadwal" />
                        <div class="mt-2 mb-4">
                            <!-- Date Picker -->
                            <input 
                                type="date" 
                                id="jadwalTanggalAdmin"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-600"
                                value="{{ old('jadwal_tanggal', $reservasi->jadwal->tanggal) }}"
                            >
                        </div>

                        <!-- Available Schedules -->
                        <div class="border border-slate-200 rounded-lg bg-slate-50 p-4 mb-4">
                            <p class="text-xs font-semibold text-slate-600 mb-3">Jadwal Tersedia:</p>
                            <div id="jadwalContainerAdmin" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 min-h-32">
                                <p class="text-slate-500 text-sm col-span-full text-center py-8">Pilih tanggal untuk melihat jadwal tersedia</p>
                            </div>
                        </div>

                        <input type="hidden" id="id_jadwal_admin" name="id_jadwal" value="{{ $reservasi->id_jadwal }}">
                        <x-input-error :messages="$errors->get('id_jadwal')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="block mt-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                            @foreach ($statusOptions as $option)
                                <option value="{{ $option }}" @selected($reservasi->status === $option)>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-slate-600">
                            @if($reservasi->status === 'menunggu_konfirmasi')
                                <strong>Menunggu Konfirmasi:</strong> Dapat diubah ke Sudah Dikonfirmasi atau Dibatalkan
                            @elseif($reservasi->status === 'sudah_dikonfirmasi')
                                <strong>Sudah Dikonfirmasi:</strong> Dapat diubah ke Selesai atau Dibatalkan
                            @elseif($reservasi->status === 'selesai')
                                <strong>Selesai:</strong> Status sudah final
                            @elseif($reservasi->status === 'dibatalkan')
                                <strong>Dibatalkan:</strong> Status sudah final
                            @endif
                        </p>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex gap-3 pt-4 justify-end">
                    <a href="{{ route('admin.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Form Isi Rekam Medis -->
        @if ($reservasi->status === 'menunggu_konfirmasi' || $reservasi->status === 'sudah_dikonfirmasi')
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Isi Rekam Medis Baru & Selesaikan Penanganan</h3>
                </div>
                <form method="POST" action="{{ route('admin.rekam-medis.store', $reservasi) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Keluhan -->
                        <div class="col-span-2">
                            <label for="keluhan_rm" class="block text-sm font-semibold text-slate-900 mb-2">
                                Keluhan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="keluhan_rm" 
                                name="keluhan" 
                                rows="3" 
                                class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="Tuliskan keluhan pasien"
                                required></textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        <!-- DIAGNOSA (SOAP Format) -->
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-slate-900 mb-3">
                                Diagnosa (Format SOAP) <span class="text-red-500">*</span>
                            </label>
                            
                            <!-- S - Subjective -->
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

                            <!-- O - Objective -->
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

                            <!-- A - Assessment -->
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

                            <!-- P - Plan -->
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

                        <!-- Terapi -->
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

                        <!-- Tarif -->
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

                        {{-- Foto Rekam Medis --}}
                        <div class="col-span-2 border-t-2 pt-6">
                            <label class="block text-lg font-semibold text-slate-900 mb-4">
                                Foto Pemeriksaan (Opsional)
                                <span class="text-sm font-normal text-slate-600">— Maksimal 5 foto, format JPG/PNG, ukuran max 5MB per foto</span>
                            </label>

                            {{-- Upload Area --}}
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-primary-500 hover:bg-primary-50 transition-colors cursor-pointer" id="dropZoneAdmin">
                                <input 
                                    type="file" 
                                    id="fotoInputAdmin" 
                                    name="fotos[]" 
                                    multiple 
                                    accept="image/*"
                                    class="hidden"
                                    data-max-files="5"
                                    data-max-size="5242880">
                                
                                <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                
                                <p class="text-slate-600 font-medium">Drag foto ke sini atau klik untuk memilih</p>
                                <p class="text-xs text-slate-500 mt-1">Bisa upload beberapa foto sekaligus (maks 5 foto)</p>
                                <p id="fileCountAdmin" class="text-xs text-primary-600 font-semibold mt-2 hidden"></p>
                            </div>

                            {{-- Preview Area --}}
                            <div id="previewContainerAdmin" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-4">
                                {{-- Previews akan ditambah dengan JS --}}
                            </div>

                            <div id="uploadMessageAdmin" class="text-sm text-slate-600 mt-3 text-center hidden"></div>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 justify-end border-t border-slate-200">
                        <a href="{{ route('admin.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
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
                    <a href="{{ route('admin.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                        ← Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Data jadwal dari controller
        const jadwalsDataAdmin = @json($jadwals);

        const jadwalTanggalAdmin = document.getElementById('jadwalTanggalAdmin');
        const jadwalContainerAdmin = document.getElementById('jadwalContainerAdmin');

        function updateJadwalDisplayAdmin() {
            const selectedDate = jadwalTanggalAdmin.value;

            if (!selectedDate) {
                jadwalContainerAdmin.innerHTML = '<p class="text-slate-500 text-sm col-span-full text-center py-8">Pilih tanggal untuk melihat jadwal tersedia</p>';
                return;
            }

            // Filter jadwal berdasarkan tanggal
            const filteredJadwals = jadwalsDataAdmin.filter(jadwal => jadwal.tanggal === selectedDate);

            if (filteredJadwals.length === 0) {
                jadwalContainerAdmin.innerHTML = '<p class="text-slate-500 text-sm col-span-full text-center py-8">Tidak ada jadwal tersedia untuk tanggal yang dipilih</p>';
                return;
            }

            jadwalContainerAdmin.innerHTML = filteredJadwals.map(jadwal => {
                const terisiKuota = jadwal.reservasi.length;
                const sisaKuota = jadwal.kuota - terisiKuota;
                const isFull = sisaKuota <= 0;
                const selectedValue = document.getElementById('id_jadwal_admin').value;
                const isSelected = selectedValue == jadwal.id_jadwal;

                let badgeClass = 'bg-primary-500';
                if (isFull) badgeClass = 'bg-red-500';
                else if (sisaKuota <= 2) badgeClass = 'bg-orange-500';

                return `
                    <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all
                        ${isSelected ? 'border-primary-500 bg-secondary-50' : isFull ? 'border-red-200 bg-red-50 opacity-50 cursor-not-allowed' : 'border-slate-200 bg-white hover:border-primary-400 hover:bg-secondary-50'}">
                        <input 
                            type="radio" 
                            name="id_jadwal_radio" 
                            value="${jadwal.id_jadwal}"
                            class="w-4 h-4 text-primary-600 cursor-pointer"
                            ${isSelected ? 'checked' : ''}
                            ${isFull ? 'disabled' : ''}
                            onchange="document.getElementById('id_jadwal_admin').value = this.value"
                        >
                        <div class="ml-3 flex-1">
                            <div class="font-semibold text-slate-900">${jadwal.dokter.nama}</div>
                            <div class="text-xs mt-2 flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-white text-xs font-bold ${badgeClass}">
                                    ${sisaKuota}/${jadwal.kuota}
                                </span>
                                <span class="text-slate-500 text-xs">
                                    ${isFull ? '✗ Penuh' : sisaKuota === 1 ? '⚠ ' + sisaKuota + ' tempat tersisa' : sisaKuota + ' tempat tersisa'}
                                </span>
                            </div>
                        </div>
                    </label>
                `;
            }).join('');
        }

        jadwalTanggalAdmin.addEventListener('change', updateJadwalDisplayAdmin);

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateJadwalDisplayAdmin);
        
        function toggleDetail(rmId) {
            const detail = document.getElementById(`detail-${rmId}`);
            const arrow = document.getElementById(`arrow-${rmId}`);
            
            detail.classList.toggle('hidden');
            arrow.style.transform = detail.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

        // Photo upload preview
        const dropZoneAdmin = document.getElementById('dropZoneAdmin');
        const fotoInputAdmin = document.getElementById('fotoInputAdmin');
        const previewContainerAdmin = document.getElementById('previewContainerAdmin');
        const uploadMessageAdmin = document.getElementById('uploadMessageAdmin');
        const fileCountAdmin = document.getElementById('fileCountAdmin');

        if (dropZoneAdmin && fotoInputAdmin) {
            const maxFiles = parseInt(fotoInputAdmin.dataset.maxFiles);
            const maxSize = parseInt(fotoInputAdmin.dataset.maxSize);

            // Drag & drop events
            dropZoneAdmin.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZoneAdmin.classList.add('border-primary-500', 'bg-primary-50');
            });

            dropZoneAdmin.addEventListener('dragleave', () => {
                dropZoneAdmin.classList.remove('border-primary-500', 'bg-primary-50');
            });

            dropZoneAdmin.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZoneAdmin.classList.remove('border-primary-500', 'bg-primary-50');
                
                // Handle dropped files
                const droppedFiles = Array.from(e.dataTransfer.files);
                addFilesToInputAdmin(droppedFiles);
            });

            dropZoneAdmin.addEventListener('click', () => {
                fotoInputAdmin.click();
            });

            fotoInputAdmin.addEventListener('change', () => {
                updatePreviewAdmin();
            });

            function addFilesToInputAdmin(newFiles) {
                // Create DataTransfer to manage FileList
                const dataTransfer = new DataTransfer();
                
                // Add existing files
                for (const file of fotoInputAdmin.files) {
                    dataTransfer.items.add(file);
                }
                
                // Add new files
                for (const file of newFiles) {
                    if (dataTransfer.items.length < maxFiles) {
                        dataTransfer.items.add(file);
                    }
                }
                
                // Update file input
                fotoInputAdmin.files = dataTransfer.files;
                updatePreviewAdmin();
            }

            function updatePreviewAdmin() {
                previewContainerAdmin.innerHTML = '';
                uploadMessageAdmin.classList.add('hidden');
                
                const files = Array.from(fotoInputAdmin.files);
                const totalFiles = files.length;

                if (totalFiles === 0) {
                    fileCountAdmin.classList.add('hidden');
                    return;
                }

                // Show file count
                fileCountAdmin.textContent = `✓ ${totalFiles} file${totalFiles > 1 ? 's' : ''} dipilih${totalFiles >= maxFiles ? ' (maksimal tercapai)' : ''}`;
                fileCountAdmin.classList.remove('hidden');

                // Validate total files
                if (totalFiles > maxFiles) {
                    uploadMessageAdmin.textContent = `⚠️ Maksimal ${maxFiles} foto. ${totalFiles - maxFiles} file akan diabaikan.`;
                    uploadMessageAdmin.classList.remove('hidden');
                }

                // Process each file
                files.forEach((file, index) => {
                    if (index >= maxFiles) return; // Skip files beyond max

                    // Validate file size
                    if (file.size > maxSize) {
                        uploadMessageAdmin.textContent = `❌ File "${file.name}" terlalu besar (max 5MB)`;
                        uploadMessageAdmin.className = 'text-sm text-red-600 mt-3 text-center';
                        uploadMessageAdmin.classList.remove('hidden');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const preview = document.createElement('div');
                        preview.className = 'relative group';
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg border border-slate-200">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all flex items-center justify-center">
                                <p class="text-xs bg-slate-900 text-white px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">${file.name}</p>
                            </div>
                        `;
                        previewContainerAdmin.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        // Photo Modal Preview
        function openPhotoModal(imageUrl, fileName) {
            const modal = document.getElementById('photoModal');
            const image = document.getElementById('photoModalImage');
            const title = document.getElementById('photoModalTitle');
            const downloadBtn = document.getElementById('photoDownloadBtn');
            
            image.src = imageUrl;
            title.textContent = 'Pratinjau: ' + fileName;
            downloadBtn.href = imageUrl;
            downloadBtn.download = fileName;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePhotoModal();
            }
        });
    </script>

    {{-- Photo Modal Preview --}}
    <div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" onclick="if(event.target === this) closePhotoModal()">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-auto">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 sticky top-0 bg-white">
                <h3 id="photoModalTitle" class="text-lg font-semibold text-slate-900">Pratinjau Foto</h3>
                <button onclick="closePhotoModal()" class="text-slate-500 hover:text-slate-700 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 flex items-center justify-center bg-slate-50">
                <img id="photoModalImage" src="" alt="Foto Pemeriksaan" class="max-w-full max-h-[70vh] object-contain">
            </div>
            <div class="p-4 border-t border-slate-200 bg-white flex justify-end">
                <a id="photoDownloadBtn" href="" download class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
