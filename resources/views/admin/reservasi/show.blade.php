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
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
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
                            @if($reservasi->jadwal->status === 'aktif') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($reservasi->jadwal->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden col-span-1">
                <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Status Reservasi</h3>
                </div>
                <div class="px-6 py-4">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                        @if($reservasi->status === 'confirmed') bg-green-100 text-green-800
                        @elseif($reservasi->status === 'pending') bg-orange-100 text-orange-800
                        @elseif($reservasi->status === 'selesai') bg-blue-100 text-blue-800
                        @elseif($reservasi->status === 'batal') bg-red-100 text-red-800
                        @else bg-slate-100 text-slate-800 @endif">
                        {{ ucfirst($reservasi->status) }}
                    </span>
                    <p class="mt-3 text-xs text-slate-600">Dibuat: {{ $reservasi->created_at->format('d M Y H:i') }}</p>
                    <p class="text-xs text-slate-600">Diperbarui: {{ $reservasi->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Form Edit -->
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Edit Reservasi</h3>
            </div>
            <form method="POST" action="{{ route('admin.reservasi.update', $reservasi) }}" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-2 gap-6">
                    <!-- Keluhan -->
                    <div class="col-span-2">
                        <x-input-label for="keluhan" value="Keluhan" />
                        <textarea id="keluhan" name="keluhan" rows="4" class="block mt-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ $reservasi->keluhan }}</textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>

                    <!-- Pilih Jadwal -->
                    <div>
                        <x-input-label for="id_jadwal" value="Jadwal (Tanggal & Dokter)" />
                        <select id="id_jadwal" name="id_jadwal" class="block mt-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            @php
                                $allJadwals = \App\Models\Jadwal::with('dokter')
                                    ->where('status', 'aktif')
                                    ->orderBy('tanggal')
                                    ->get();
                            @endphp
                            @foreach ($allJadwals as $jadwal)
                                <option value="{{ $jadwal->id_jadwal }}" 
                                    @selected($reservasi->id_jadwal === $jadwal->id_jadwal)>
                                    {{ $jadwal->dokter->nama }} - {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('id_jadwal')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" class="block mt-2 w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            @foreach ($statusOptions as $option)
                                <option value="{{ $option }}" @selected($reservasi->status === $option)>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-slate-600">
                            @if($reservasi->status === 'pending')
                                <strong>Pending:</strong> Dapat diubah ke Confirmed atau Batal
                            @elseif($reservasi->status === 'confirmed')
                                <strong>Confirmed:</strong> Dapat diubah ke Selesai atau Batal
                            @elseif($reservasi->status === 'selesai')
                                <strong>Selesai:</strong> Status sudah final
                            @elseif($reservasi->status === 'batal')
                                <strong>Batal:</strong> Status sudah final
                            @endif
                        </p>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex gap-3 pt-4 justify-end">
                    <a href="{{ route('admin.reservasi.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
