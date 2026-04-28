<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Masuk ke Akun</h2>
        <p class="mt-1 text-sm text-slate-600">Silakan masukkan email dan password Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-2 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-green-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col gap-3 pt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            @if (Route::has('register'))
                <p class="text-sm text-center text-slate-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold">
                        Daftar di sini
                    </a>
                </p>
            @endif
        </div>
    </form>
</x-guest-layout>
