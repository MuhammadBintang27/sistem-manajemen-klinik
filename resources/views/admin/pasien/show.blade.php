<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Detail Pasien</h2>
                <p class="mt-1 text-sm text-slate-600">ID Pasien: {{ $pasien->id_pasien }}</p>
            </div>
            <a href="{{ route('admin.pasien.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
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

        @if (session('success'))
            <div class="rounded-xl bg-secondary-50 border border-secondary-200 p-4 flex items-center gap-3">
                <svg class="h-5 w-5 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-primary-800">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Info Kartu -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Info Dasar -->
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Informasi Dasar</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">NIK</p>
                        <p class="text-sm font-semibold text-slate-900 font-mono tracking-widest">{{ $pasien->nik }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $pasien->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : ($pasien->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Kontak -->
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Informasi Kontak</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">No. HP</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $pasien->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Tanggal Lahir</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-600 uppercase font-semibold">Terdaftar Sejak</p>
                        <p class="text-sm font-semibold text-slate-900">{{ $pasien->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Edit -->
        <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Edit Data Pasien</h3>
                <p class="mt-1 text-sm text-slate-600">NIK tidak dapat diubah</p>
            </div>
            <form method="POST" action="{{ route('admin.pasien.update', $pasien) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-6">
                    <!-- NIK (Read Only) -->
                    <div>
                        <x-input-label for="nik" value="NIK (Tidak dapat diubah)" />
                        <input id="nik" class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm bg-gray-100 text-gray-600 cursor-not-allowed" type="text" value="{{ $pasien->nik }}" disabled />
                    </div>

                    <!-- Nama -->
                    <div>
                        <x-input-label for="nama" value="Nama Lengkap" />
                        <x-text-input id="nama" class="block mt-2 w-full" type="text" name="nama" value="{{ old('nama', $pasien->nama) }}" required />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" @selected(old('jenis_kelamin', $pasien->jenis_kelamin) === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin', $pasien->jenis_kelamin) === 'P')>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" class="block mt-2 w-full" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '') }}" />
                        <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                    </div>

                    <!-- No. HP -->
                    <div>
                        <x-input-label for="no_hp" value="No. HP" />
                        <x-text-input id="no_hp" class="block mt-2 w-full" type="text" name="no_hp" value="{{ old('no_hp', $pasien->no_hp) }}" />
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                    </div>

                    <!-- Alamat -->
                    <div class="col-span-2">
                        <x-input-label for="alamat" value="Alamat" />
                        <textarea id="alamat" name="alamat" rows="3" class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">{{ old('alamat', $pasien->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>
                </div>

                <div class="flex gap-3 pt-4 justify-end">
                    <a href="{{ route('admin.pasien.index') }}" class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Riwayat Reservasi -->
        @if($pasien->reservasi->count() > 0)
            <div class="rounded-2xl bg-white border border-secondary-100 shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-secondary-50 to-white border-b border-secondary-100 px-6 py-4">
                    <h3 class="text-lg font-bold text-slate-900">Riwayat Reservasi</h3>
                    <p class="mt-1 text-sm text-slate-600">Total: {{ $pasien->reservasi->count() }} reservasi</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-secondary-100">
                        <thead class="bg-gradient-to-r from-secondary-50 to-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-700">Dokter</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-700">Keluhan</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary-100">
                            @foreach($pasien->reservasi->take(10) as $reservasi)
                                <tr class="hover:bg-secondary-50">
                                    <td class="px-6 py-3 text-sm text-slate-900">{{ \Carbon\Carbon::parse($reservasi->jadwal->tanggal)->format('d M Y') }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-900">{{ $reservasi->jadwal->dokter->nama }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-700">{{ substr($reservasi->keluhan, 0, 30) }}{{ strlen($reservasi->keluhan) > 30 ? '...' : '' }}</td>
                                    <td class="px-6 py-3 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
