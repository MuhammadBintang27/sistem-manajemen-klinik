<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi - Klinik Gigi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-green-600 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 2c-1.1 0-2 .9-2 2v3H4c-1.1 0-2 .9-2 2v4h2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6h2V9c0-1.1-.9-2-2-2h-3V4c0-1.1-.9-2-2-2H9zm0 2h6v3H9V4zm9 5v6H6v-6h12z"/>
                </svg>
                <h1 class="text-2xl font-bold">Klinik Gigi Sejahtera</h1>
            </div>
            <a href="{{ route('reservasi.index') }}" class="bg-white text-green-600 px-6 py-2 rounded-lg font-semibold hover:bg-green-50 transition">Kembali</a>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-12 px-6">
        <!-- Form Container -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-600 text-white py-8 px-6 text-center">
                <h1 class="text-3xl font-bold mb-2">Form Reservasi Klinik Gigi</h1>
                <p class="text-green-100">Isi data Anda untuk membuat janji temu dengan dokter gigi kami</p>
            </div>

            <form id="reservasiForm" method="POST" action="{{ route('reservasi.store') }}" class="p-8">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-semibold mb-2">⚠ Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Step 1: NIK Input -->
                <div id="step1" class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Langkah 1: Masukkan NIK Anda</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="nik" class="block text-sm font-semibold text-slate-700 mb-2">Nomor Identitas (NIK) *</label>
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    id="nik" 
                                    name="nik" 
                                    placeholder="Masukkan NIK Anda (16 digit)" 
                                    class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('nik') border-red-500 @enderror"
                                    value="{{ old('nik') }}"
                                    maxlength="16"
                                    pattern="\d{16}"
                                    inputmode="numeric"
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="checkNikBtn" 
                                    class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition"
                                >
                                    Cek Data
                                </button>
                            </div>
                            @error('nik')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Loading spinner -->
                        <div id="loadingSpinner" class="hidden flex items-center gap-2 text-green-600">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Mengecek data...</span>
                        </div>

                        <!-- Error message -->
                        <div id="errorMessage" class="hidden bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg"></div>
                    </div>
                </div>

                <!-- Step 2: Patient Data (Show if exists, or form if new) -->
                <div id="step2" class="hidden mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Langkah 2: Data Pasien</h2>
                    
                    <!-- Existing Patient Data (readonly) -->
                    <div id="existingPatientData" class="hidden bg-blue-50 border border-blue-300 rounded-lg p-6 mb-6">
                        <p class="text-sm font-semibold text-blue-900 mb-4">✓ Anda sudah terdaftar di klinik kami. Data berikut diambil dari sistem:</p>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nama</label>
                                <input type="text" id="displayNama" class="w-full px-4 py-2 bg-gray-200 text-slate-700 rounded-lg border border-gray-300" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">NIK</label>
                                <input type="text" id="displayNik" class="w-full px-4 py-2 bg-gray-200 text-slate-700 rounded-lg border border-gray-300" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin</label>
                                <input type="text" id="displayJenisKelamin" class="w-full px-4 py-2 bg-gray-200 text-slate-700 rounded-lg border border-gray-300" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor HP</label>
                                <input type="text" id="displayNoHp" class="w-full px-4 py-2 bg-gray-200 text-slate-700 rounded-lg border border-gray-300" readonly>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat</label>
                                <textarea id="displayAlamat" class="w-full px-4 py-2 bg-gray-200 text-slate-700 rounded-lg border border-gray-300" readonly rows="2"></textarea>
                            </div>
                        </div>
                        <button type="button" id="changeNikBtn" class="mt-4 text-blue-600 hover:text-blue-800 text-sm font-semibold">← Ubah NIK</button>
                    </div>

                    <!-- New Patient Form -->
                    <div id="newPatientForm" class="hidden bg-amber-50 border border-amber-300 rounded-lg p-6 mb-6 space-y-4">
                        <p class="text-sm font-semibold text-amber-900 mb-4">ℹ NIK belum terdaftar. Silakan isi data Anda:</p>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="nama" class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap *</label>
                                <input 
                                    type="text" 
                                    id="nama" 
                                    name="nama" 
                                    placeholder="Masukkan nama lengkap Anda" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('nama') border-red-500 @enderror"
                                    value="{{ old('nama') }}"
                                    maxlength="50"
                                >
                                @error('nama')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                                <select 
                                    id="jenis_kelamin" 
                                    name="jenis_kelamin" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('jenis_kelamin') border-red-500 @enderror"
                                >
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP</label>
                                <input 
                                    type="tel" 
                                    id="no_hp" 
                                    name="no_hp" 
                                    placeholder="Contoh: 081234567890" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('no_hp') border-red-500 @enderror"
                                    value="{{ old('no_hp') }}"
                                    maxlength="20"
                                >
                                @error('no_hp')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                                <textarea 
                                    id="alamat" 
                                    name="alamat" 
                                    placeholder="Masukkan alamat lengkap Anda" 
                                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('alamat') border-red-500 @enderror"
                                    rows="3"
                                    maxlength="100"
                                >{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Jadwal & Keluhan -->
                <div id="step3" class="hidden mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Langkah 3: Pilih Jadwal & Keluhan</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="id_jadwal" class="block text-sm font-semibold text-slate-700 mb-2">Pilih Jadwal Dokter *</label>
                            <select 
                                id="id_jadwal" 
                                name="id_jadwal" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('id_jadwal') border-red-500 @enderror"
                                required
                            >
                                <option value="">Pilih jadwal dokter...</option>
                                @foreach($jadwals as $jadwal)
                                    @php
                                        $tanggalFormat = \Carbon\Carbon::createFromFormat('Y-m-d', $jadwal->tanggal)->format('d M Y');
                                        $terisiKuota = $jadwal->reservasi->count();
                                        $sisaKuota = $jadwal->kuota - $terisiKuota;
                                    @endphp
                                    <option value="{{ $jadwal->id_jadwal }}" @selected(old('id_jadwal') == $jadwal->id_jadwal)>
                                        {{ $jadwal->dokter->name }} - {{ $tanggalFormat }} ({{ $sisaKuota }} antrian tersisa)
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jadwal')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="keluhan" class="block text-sm font-semibold text-slate-700 mb-2">Keluhan / Catatan (Opsional)</label>
                            <textarea 
                                id="keluhan" 
                                name="keluhan" 
                                placeholder="Jelaskan keluhan gigi Anda, misalnya: gigi berlubang di bagian kanan, gusi bengkak, dll" 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('keluhan') border-red-500 @enderror"
                                rows="4"
                                maxlength="255"
                            >{{ old('keluhan') }}</textarea>
                            @error('keluhan')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div id="actionButtons" class="hidden flex gap-4">
                    <button 
                        type="button" 
                        id="backBtn" 
                        class="flex-1 px-6 py-3 border-2 border-slate-300 text-slate-700 rounded-lg font-semibold hover:bg-slate-100 transition"
                    >
                        Kembali
                    </button>
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition"
                    >
                        Buat Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const nikInput = document.getElementById('nik');
        const checkNikBtn = document.getElementById('checkNikBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const errorMessage = document.getElementById('errorMessage');
        
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const actionButtons = document.getElementById('actionButtons');
        
        const existingPatientData = document.getElementById('existingPatientData');
        const newPatientForm = document.getElementById('newPatientForm');
        const changeNikBtn = document.getElementById('changeNikBtn');
        const backBtn = document.getElementById('backBtn');
        
        let patientFound = false;

        // Check NIK
        checkNikBtn.addEventListener('click', async () => {
            const nik = nikInput.value.trim();
            
            if (!nik) {
                showError('Silakan masukkan NIK terlebih dahulu');
                return;
            }

            loadingSpinner.classList.remove('hidden');
            errorMessage.classList.add('hidden');

            try {
                const response = await fetch('{{ route("reservasi.checkNik") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: JSON.stringify({ nik })
                });

                const data = await response.json();
                loadingSpinner.classList.add('hidden');

                if (data.found) {
                    patientFound = true;
                    showExistingPatientData(data.pasien);
                } else {
                    patientFound = false;
                    showNewPatientForm();
                }

                // Show step 2 and 3
                step1.classList.add('opacity-50');
                nikInput.readOnly = true;
                checkNikBtn.disabled = true;
                step2.classList.remove('hidden');
                step3.classList.remove('hidden');
                actionButtons.classList.remove('hidden');
            } catch (error) {
                loadingSpinner.classList.add('hidden');
                showError('Terjadi kesalahan: ' + error.message);
            }
        });

        function showExistingPatientData(pasien) {
            document.getElementById('displayNama').value = pasien.nama;
            document.getElementById('displayNik').value = pasien.nik;
            document.getElementById('displayJenisKelamin').value = pasien.jenis_kelamin || '-';
            document.getElementById('displayNoHp').value = pasien.no_hp || '-';
            document.getElementById('displayAlamat').value = pasien.alamat || '-';
            
            existingPatientData.classList.remove('hidden');
            newPatientForm.classList.add('hidden');
        }

        function showNewPatientForm() {
            existingPatientData.classList.add('hidden');
            newPatientForm.classList.remove('hidden');
        }

        changeNikBtn.addEventListener('click', () => {
            step1.classList.remove('opacity-50');
            nikInput.readOnly = false;
            checkNikBtn.disabled = false;
            step2.classList.add('hidden');
            step3.classList.add('hidden');
            actionButtons.classList.add('hidden');
            nikInput.value = '';
            nikInput.focus();
        });

        backBtn.addEventListener('click', changeNikBtn.click);

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
        }

        // Submit form validation
        document.getElementById('reservasiForm').addEventListener('submit', (e) => {
            const idJadwal = document.getElementById('id_jadwal').value.trim();
            if (!idJadwal) {
                e.preventDefault();
                showError('Silakan pilih jadwal dokter');
                return;
            }
            
            if (!patientFound) {
                const nama = document.getElementById('nama').value.trim();
                if (!nama) {
                    e.preventDefault();
                    showError('Nama lengkap harus diisi untuk pendaftar baru');
                    return;
                }
            }
            // Form will submit normally
        });
    </script>
</body>
</html>
