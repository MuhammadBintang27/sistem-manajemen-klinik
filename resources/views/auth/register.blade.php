<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h2>
        <p class="mt-1 text-sm text-slate-600">Silakan isi data di bawah untuk membuat akun baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="nama" value="Nama Lengkap" />
            <x-text-input id="nama" class="block mt-2 w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email Address" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" value="Daftar Sebagai" />
            <select id="role" name="role" class="block mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 pt-4">
            <x-primary-button class="w-full justify-center">
                Daftar
            </x-primary-button>

            <p class="text-sm text-center text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
