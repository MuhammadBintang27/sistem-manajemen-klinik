<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Edit Rekam Medis</h2>
                <p class="mt-1 text-sm text-slate-600">Pasien: {{ $pasien->nama }}</p>
            </div>
            <a href="{{ route('admin.rekam-medis.pasien.show', $pasien) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
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

        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-xl bg-secondary-50 border border-secondary-200 p-4">
                <p class="text-sm font-semibold text-green-800">✓ {{ session('success') }}</p>
            </div>
        @endif

        {{-- Form Edit --}}
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Data Rekam Medis - {{ \Carbon\Carbon::parse($rekamMedis->tanggal)->format('d M Y') }}</h3>
            </div>

            <form method="POST" action="{{ route('admin.rekam-medis.update', $rekamMedis) }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    {{-- Keluhan --}}
                    <div>
                        <label for="keluhan" class="block text-sm font-semibold text-slate-900 mb-2">
                            Keluhan
                        </label>
                        <textarea 
                            id="keluhan" 
                            name="keluhan" 
                            rows="3" 
                            class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2"
                            placeholder="Tuliskan keluhan pasien">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>

                    {{-- DIAGNOSA (SOAP Format) --}}
                    <div class="border-t-2 pt-6">
                        <label class="block text-lg font-semibold text-slate-900 mb-4">
                            Diagnosa (Format SOAP)
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
                                required>{{ old('subjective', $rekamMedis->subjective) }}</textarea>
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
                                class="block w-full rounded-lg border border-primary-300 bg-white shadow-sm focus:border-primary-500 focus:ring-primary-500 px-4 py-2"
                                placeholder="Tekanan darah, suhu tubuh, pemeriksaan fisik, hasil laboratorium..."
                                required>{{ old('objective', $rekamMedis->objective) }}</textarea>
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
                                required>{{ old('assessment', $rekamMedis->assessment) }}</textarea>
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
                                required>{{ old('plan', $rekamMedis->plan) }}</textarea>
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
                            required>{{ old('terapi', $rekamMedis->terapi) }}</textarea>
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
                            value="{{ old('tarif', $rekamMedis->tarif) }}"
                            required>
                        <x-input-error :messages="$errors->get('tarif')" class="mt-2" />
                    </div>
                </div>

                {{-- Foto Rekam Medis --}}
                <div class="border-t-2 pt-6">
                    <label class="block text-lg font-semibold text-slate-900 mb-4">
                        Foto Pemeriksaan
                        <span class="text-sm font-normal text-slate-600">— Maksimal 5 foto total</span>
                    </label>

                    {{-- Existing Photos --}}
                    @if($rekamMedis->fotoRekamMedis->count() > 0)
                        <div class="mb-6">
                            <p class="text-sm font-semibold text-slate-700 mb-3">Foto yang sudah ada ({{ $rekamMedis->fotoRekamMedis->count() }}/5)</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                                @foreach($rekamMedis->fotoRekamMedis as $foto)
                                    <div class="relative group foto-item" data-foto-id="{{ $foto->id_foto }}">
                                        <img 
                                            src="{{ route('storage.private', ['path' => $foto->foto_path]) }}" 
                                            alt="Foto Rekam Medis" 
                                            class="w-full h-32 object-cover rounded-lg border border-slate-200">
                                        <button 
                                            type="button"
                                            class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity delete-foto-btn"
                                            data-foto-id="{{ $foto->id_foto }}"
                                            title="Hapus foto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Add More Photos --}}
                    @if($rekamMedis->fotoRekamMedis->count() < 5)
                        <div>
                            <p class="text-sm font-semibold text-slate-700 mb-3">Tambah Foto Baru</p>
                            <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-primary-500 hover:bg-primary-50 transition-colors cursor-pointer" id="dropZone">
                                <input 
                                    type="file" 
                                    id="fotoInput" 
                                    name="fotos_baru[]" 
                                    multiple 
                                    accept="image/*"
                                    class="hidden"
                                    data-max-files="{{ 5 - $rekamMedis->fotoRekamMedis->count() }}"
                                    data-max-size="5242880">
                                
                                <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                
                                <p class="text-slate-600 font-medium">Drag foto ke sini atau klik untuk memilih</p>
                                <p class="text-xs text-slate-500 mt-1">Masih bisa menambah {{ 5 - $rekamMedis->fotoRekamMedis->count() }} foto</p>
                            </div>
                        </div>

                        {{-- Preview Area for New Photos --}}
                        <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-4">
                            {{-- Previews akan ditambah dengan JS --}}
                        </div>

                        <div id="uploadMessage" class="text-sm text-slate-600 mt-3 text-center hidden"></div>
                        <div id="uploadProgress" class="text-sm text-slate-600 mt-3 text-center hidden">
                            <span class="inline-flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span id="uploadProgressText">Mengunggah foto...</span>
                            </span>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <p class="text-sm text-blue-700">✓ Sudah mencapai maksimal 5 foto</p>
                        </div>
                    @endif
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6">
                    <a href="{{ route('admin.rekam-medis.pasien.show', $pasien) }}" class="px-6 py-2 bg-slate-300 hover:bg-slate-400 text-slate-900 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('dropZone');
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('previewContainer');
        const uploadMessage = document.getElementById('uploadMessage');
        const uploadProgress = document.getElementById('uploadProgress');
        const maxFiles = parseInt(fotoInput?.dataset.maxFiles || 5);
        const maxSize = parseInt(fotoInput?.dataset.maxSize || 5242880);
        const rekamMedisId = {{ $rekamMedis->id_rekam_medis }};

        if (dropZone) {
            // Drag & drop events
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('border-primary-500', 'bg-primary-50');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('border-primary-500', 'bg-primary-50');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-primary-500', 'bg-primary-50');
                fotoInput.files = e.dataTransfer.files;
                handleFileSelection();
            });

            dropZone.addEventListener('click', () => {
                fotoInput.click();
            });
        }

        if (fotoInput) {
            fotoInput.addEventListener('change', handleFileSelection);
        }

        function handleFileSelection() {
            if (!previewContainer) return;
            
            previewContainer.innerHTML = '';
            uploadMessage.classList.add('hidden');
            
            let totalFiles = fotoInput.files.length;
            const filesToUpload = [];

            if (totalFiles > maxFiles) {
                uploadMessage.textContent = `⚠️ Maksimal ${maxFiles} foto. Hanya ${maxFiles} foto pertama yang akan diupload.`;
                uploadMessage.classList.remove('hidden');
                totalFiles = maxFiles;
            }

            for (let i = 0; i < totalFiles; i++) {
                const file = fotoInput.files[i];
                
                // Validasi ukuran
                if (file.size > maxSize) {
                    uploadMessage.textContent = `❌ File "${file.name}" terlalu besar (max 5MB)`;
                    uploadMessage.classList.remove('hidden');
                    continue;
                }

                filesToUpload.push(file);

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
                    previewContainer.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }

            // Upload files immediately
            if (filesToUpload.length > 0) {
                uploadPhotos(filesToUpload);
            }
        }

        function uploadPhotos(files) {
            uploadProgress.classList.remove('hidden');
            const formData = new FormData();
            files.forEach(file => {
                formData.append('fotos[]', file);
            });

            fetch(`/admin/rekam-medis/${rekamMedisId}/foto`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                uploadProgress.classList.add('hidden');
                if (data.success) {
                    uploadMessage.textContent = `✓ ${files.length} foto berhasil diupload`;
                    uploadMessage.className = 'text-sm text-green-600 mt-3 text-center';
                    uploadMessage.classList.remove('hidden');
                    
                    // Clear input
                    fotoInput.value = '';
                    previewContainer.innerHTML = '';
                    
                    // Refresh page after 2 seconds to show new photos
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    uploadMessage.textContent = `❌ Gagal upload: ${data.message || 'Coba lagi'}`;
                    uploadMessage.className = 'text-sm text-red-600 mt-3 text-center';
                    uploadMessage.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                uploadProgress.classList.add('hidden');
                uploadMessage.textContent = '❌ Terjadi kesalahan saat upload foto';
                uploadMessage.className = 'text-sm text-red-600 mt-3 text-center';
                uploadMessage.classList.remove('hidden');
            });
        }

        // Delete existing foto
        document.querySelectorAll('.delete-foto-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Hapus foto ini?')) return;

                const fotoId = this.dataset.fotoId;
                const fotoItem = this.closest('.foto-item');

                fetch(`/admin/rekam-medis/{{ $rekamMedis->id_rekam_medis }}/foto/${fotoId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fotoItem.classList.add('opacity-50');
                        setTimeout(() => {
                            fotoItem.remove();
                            // Refresh page to show updated count
                            location.reload();
                        }, 300);
                    } else {
                        alert('Gagal menghapus foto: ' + (data.message || 'Coba lagi'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat menghapus foto');
                });
            });
        });
    </script>
</x-app-layout>
