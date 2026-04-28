<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Jadwal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal) }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="id_user" value="Dokter" />
                            <select id="id_user" name="id_user" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                <option value="">-- pilih dokter --</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id_user }}" @selected(old('id_user', $jadwal->id_user) == $dokter->id_user)>
                                        {{ $dokter->nama }} ({{ $dokter->email }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="tanggal" value="Tanggal" />
                            <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" :value="old('tanggal', $jadwal->tanggal)" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="kuota" value="Kuota" />
                            <x-text-input id="kuota" class="block mt-1 w-full" type="number" name="kuota" min="1" max="100" :value="old('kuota', $jadwal->kuota)" required />
                            <x-input-error :messages="$errors->get('kuota')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Jumlah kuota yang tersedia untuk tanggal ini</p>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.jadwal.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400">Kembali</a>
                            <x-primary-button>
                                Simpan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
