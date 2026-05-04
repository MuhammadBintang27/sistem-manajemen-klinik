<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Edit Pasien</h2>
            <a href="{{ route('admin.pasien.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Form Edit Pasien</h3>
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

                    <!-- No HP -->
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
    </div>
</x-app-layout>
