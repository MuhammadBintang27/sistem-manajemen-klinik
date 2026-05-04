<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Pasien</h2>
                <p class="mt-1 text-sm text-slate-600">Riwayat Rekam Medis: {{ $pasien->nama }}</p>
            </div>
            <a href="{{ route('admin.rekam-medis.list-pasien') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
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
                                <a href="{{ route('admin.rekam-medis.edit', $rm) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 font-medium rounded-lg text-xs transition-colors">
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

                                {{-- Foto Pemeriksaan --}}
                                @if($rm->fotoRekamMedis->count() > 0)
                                    <div class="border-t border-slate-200 pt-3">
                                        <p class="text-xs text-slate-600 uppercase font-semibold mb-2">Foto Pemeriksaan ({{ $rm->fotoRekamMedis->count() }}/5)</p>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                                            @foreach($rm->fotoRekamMedis as $foto)
                                                <button type="button" onclick="openPhotoModal('{{ route('storage.private', ['path' => $foto->foto_path]) }}', '{{ basename($foto->foto_path) }}')" class="relative group">
                                                    <img src="{{ route('storage.private', ['path' => $foto->foto_path]) }}" 
                                                         alt="Foto Pemeriksaan" 
                                                         class="w-full h-16 object-cover rounded border border-slate-300 hover:border-primary-500 transition-colors cursor-pointer">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded transition-all flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    <script>
        function toggleDetail(id) {
            const detail = document.getElementById('detail-' + id);
            const arrow = document.getElementById('arrow-' + id);
            detail.classList.toggle('hidden');
            arrow.style.transform = detail.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
        }

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
</x-app-layout>
