<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Isi Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6 space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold">Data Pasien</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $reservasi->pasien?->nama ?? '-' }} • NIK: {{ $reservasi->pasien?->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Jadwal</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $reservasi->jadwal?->tanggal ?? '-' }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('dokter.rekam-medis.store', $reservasi) }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="keluhan" value="Keluhan" />
                            <textarea id="keluhan" name="keluhan" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" rows="3">{{ old('keluhan') }}</textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="diagnosa" value="Diagnosa" />
                            <textarea id="diagnosa" name="diagnosa" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" rows="3">{{ old('diagnosa') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosa')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="terapi" value="Terapi" />
                            <textarea id="terapi" name="terapi" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300" rows="3">{{ old('terapi') }}</textarea>
                            <x-input-error :messages="$errors->get('terapi')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>Simpan Rekam Medis</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
