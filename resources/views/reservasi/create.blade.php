@extends('layouts.pasien')

@section('title', 'Form Reservasi - Miss Dentist Meulaboh')

@push('styles')
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        .step-content { animation: slideIn 0.4s ease; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; }

        /* Date picker tint */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0.5;
            cursor: pointer;
            filter: invert(30%) sepia(60%) saturate(500%) hue-rotate(290deg);
        }
        input[type="date"]:not([value]):not(:focus) { color: #c9a0b8; }

        /* Jadwal card selected/full states */
        .jadwal-card { transition: all 0.2s ease; }
        .jadwal-card:not(.full):hover { border-color: #D94A8C; background: #FDF0F6; }
        .jadwal-card.selected { border-color: #D94A8C !important; background: #FDF0F6 !important; box-shadow: 0 0 0 3px rgba(217,74,140,0.15); }
        .jadwal-card.full { opacity: 0.5; cursor: not-allowed; }
    </style>
@endpush

@section('navbar-right')
    <a href="{{ route('reservasi.index') }}"
       class="flex items-center gap-1.5 text-sm font-medium text-secondary-200 hover:text-white transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-secondary-50 via-white to-secondary-50 py-8 sm:py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="font-display text-3xl sm:text-4xl mb-2 text-primary-800">Form Reservasi</h1>
                <p class="text-sm sm:text-base text-secondary-400">Isi data Anda untuk membuat janji temu dengan dokter gigi kami</p>
            </div>

            {{-- Stepper --}}
            <div class="flex items-center mb-8 px-2">
                {{-- Step 1 --}}
                <div class="flex flex-col items-center">
                    <div id="stepCircle1"
                         class="w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-primary-500 bg-primary-500 text-white shadow-[0_0_0_4px_rgba(217,74,140,0.15)]">
                        1
                    </div>
                    <span class="text-xs font-semibold mt-1.5 whitespace-nowrap text-primary-500">Identitas</span>
                </div>
                <div id="stepLine1" class="h-0.5 flex-1 mx-2 -mt-3.5 bg-secondary-200 transition-all duration-300"></div>
                {{-- Step 2 --}}
                <div class="flex flex-col items-center">
                    <div id="stepCircle2"
                         class="w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-secondary-200 bg-white text-secondary-400">
                        2
                    </div>
                    <span class="text-xs font-medium mt-1.5 text-slate-400 whitespace-nowrap">Data Pasien</span>
                </div>
                <div id="stepLine2" class="h-0.5 flex-1 mx-2 -mt-3.5 bg-secondary-200 transition-all duration-300"></div>
                {{-- Step 3 --}}
                <div class="flex flex-col items-center">
                    <div id="stepCircle3"
                         class="w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-secondary-200 bg-white text-secondary-400">
                        3
                    </div>
                    <span class="text-xs font-medium mt-1.5 text-slate-400 whitespace-nowrap">Jadwal</span>
                </div>
            </div>

            {{-- Form --}}
            <form id="reservasiForm" method="POST" action="{{ route('reservasi.store') }}">
                @csrf

                {{-- Laravel validation errors --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                        <p class="font-semibold text-red-700 text-sm mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            Terjadi kesalahan, silakan periksa kembali:
                        </p>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-red-600 text-sm flex items-center gap-2">
                                    <span class="w-1 h-1 bg-red-400 rounded-full flex-shrink-0"></span>{{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- STEP 1: NIK --}}
                <div id="step1" class="bg-white rounded-2xl p-7 border border-secondary-100 shadow-sm mb-5 step-content">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 bg-secondary-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-9 4h2v2h-2V8zm0 3h2v6h-2v-6zm-4-3h2v8H7V8zm10 8h-2v-4h2v4zm0-5h-2V8h2v3z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-900">Langkah 1: Verifikasi Identitas</h2>
                            <p class="text-xs text-slate-400">Masukkan NIK untuk memeriksa data Anda</p>
                        </div>
                    </div>

                    <label for="nik" class="block text-xs font-semibold text-primary-800 mb-1.5 tracking-wide">
                        Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2.5">
                        <input type="text" id="nik" name="nik"
                            placeholder="Masukkan 16 digit NIK Anda"
                            class="flex-1 px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 placeholder-secondary-400 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white @error('nik') border-red-400 ring-2 ring-red-100 @else border-secondary-200 @enderror"
                            value="{{ old('nik') }}"
                            maxlength="16" inputmode="numeric" required>
                        <button type="button" id="checkNikBtn"
                                class="flex-shrink-0 flex items-center gap-2 px-4 py-3 rounded-xl font-bold text-sm text-white transition hover:-translate-y-0.5 hover:shadow-md disabled:opacity-60 disabled:cursor-default disabled:transform-none"
                                style="background: linear-gradient(135deg, #D94A8C, #C63F7F);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Cek
                        </button>
                    </div>
                    @error('nik')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror

                    <div id="loadingSpinner" class="hidden mt-3 flex items-center gap-2 text-primary-500">
                        <svg class="spinner w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span class="text-sm font-medium">Memeriksa data...</span>
                    </div>
                    <div id="errorMessage" class="hidden mt-3 bg-red-50 border border-red-200 rounded-xl p-3 text-red-600 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        <span id="errorText"></span>
                    </div>
                </div>

                {{-- STEP 2: Patient Data --}}
                <div id="step2" class="hidden mb-5 step-content">
                    <div class="bg-white rounded-2xl p-7 border border-secondary-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-secondary-50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-900">Langkah 2: Data Pasien</h2>
                                <p class="text-xs text-slate-400">Lengkapi informasi diri Anda</p>
                            </div>
                        </div>

                        {{-- Existing patient --}}
                        <div id="existingPatientData" class="hidden">
                            <div class="bg-secondary-50 border-l-4 border-primary-500 border border-secondary-200 rounded-xl p-3 mb-4 flex items-start gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-primary-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                                <p class="text-sm font-medium text-primary-900">Anda sudah terdaftar. Data berikut diambil dari sistem kami.</p>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-primary-800 mb-1.5">Nama Lengkap</label>
                                    <input type="text" id="displayNama" class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm bg-pink-50 text-primary-700 cursor-default" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-primary-800 mb-1.5">NIK</label>
                                    <input type="text" id="displayNik" class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm bg-pink-50 text-primary-700 cursor-default" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-primary-800 mb-1.5">Jenis Kelamin</label>
                                    <input type="text" id="displayJenisKelamin" class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm bg-pink-50 text-primary-700 cursor-default" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-primary-800 mb-1.5">Nomor HP</label>
                                    <input type="text" id="displayNoHp" class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm bg-pink-50 text-primary-700 cursor-default" readonly>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-semibold text-primary-800 mb-1.5">Alamat</label>
                                    <textarea id="displayAlamat" class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm bg-pink-50 text-primary-700 cursor-default resize-none" readonly rows="2"></textarea>
                                </div>
                            </div>
                            <button type="button" id="changeNikBtn"
                                    class="mt-4 text-sm font-semibold flex items-center gap-1.5 text-primary-500 hover:text-primary-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Ubah NIK
                            </button>
                        </div>

                        {{-- New patient form --}}
                        <div id="newPatientForm" class="hidden">
                            <div class="bg-amber-50 border border-amber-200 border-l-4 border-l-amber-400 rounded-xl p-3 mb-4 flex items-start gap-2">
                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                                <p class="text-amber-700 text-xs font-medium">NIK belum terdaftar. Silakan lengkapi data Anda sebagai pasien baru.</p>
                            </div>
                            <div class="grid sm:grid-cols-2 gap-3">
                                <div class="sm:col-span-2">
                                    <label for="nama" class="block text-xs font-semibold text-primary-800 mb-1.5">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda"
                                        class="w-full px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 placeholder-secondary-400 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white @error('nama') border-red-400 @else border-secondary-200 @enderror"
                                        value="{{ old('nama') }}" maxlength="50">
                                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="jenis_kelamin" class="block text-xs font-semibold text-primary-800 mb-1.5">Jenis Kelamin</label>
                                    <select id="jenis_kelamin" name="jenis_kelamin"
                                            class="w-full px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white @error('jenis_kelamin') border-red-400 @else border-secondary-200 @enderror">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                                        <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="no_hp" class="block text-xs font-semibold text-primary-800 mb-1.5">Nomor HP</label>
                                    <input type="tel" id="no_hp" name="no_hp" placeholder="081234567890"
                                        class="w-full px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 placeholder-secondary-400 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white @error('no_hp') border-red-400 @else border-secondary-200 @enderror"
                                        value="{{ old('no_hp') }}" maxlength="20">
                                    @error('no_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="alamat" class="block text-xs font-semibold text-primary-800 mb-1.5">Alamat</label>
                                    <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda"
                                        class="w-full px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 placeholder-secondary-400 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white resize-none @error('alamat') border-red-400 @else border-secondary-200 @enderror"
                                        rows="3" maxlength="100">{{ old('alamat') }}</textarea>
                                    @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <button type="button" id="changeNikBtn2"
                                    class="mt-4 text-sm font-semibold flex items-center gap-1.5 text-primary-500 hover:text-primary-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Ubah NIK
                            </button>
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Jadwal & Keluhan --}}
                <div id="step3" class="hidden mb-5 step-content">
                    <div class="bg-white rounded-2xl p-7 border border-secondary-100 shadow-sm">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 bg-secondary-50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-slate-900">Langkah 3: Pilih Jadwal</h2>
                                <p class="text-xs text-slate-400">Pilih tanggal dan dokter yang tersedia</p>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label for="jadwalTanggal" class="block text-xs font-semibold text-primary-800 mb-1.5">
                                Pilih Tanggal Kunjungan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="jadwalTanggal"
                                class="w-full px-4 py-3 border-2 border-secondary-200 rounded-xl text-sm text-slate-800 bg-secondary-50 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white cursor-pointer"
                                min="{{ \Carbon\Carbon::today()->toDateString() }}"
                                max="{{ \Carbon\Carbon::today()->addMonths(3)->toDateString() }}"
                                value="{{ old('tanggal') }}">
                        </div>

                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-primary-800 mb-2">Jadwal Tersedia</label>
                            <div id="jadwalContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-3 min-h-[100px]">
                                <div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-secondary-400">
                                    <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                                    <p class="text-sm">Pilih tanggal untuk melihat jadwal</p>
                                </div>
                            </div>
                            <input type="hidden" id="id_jadwal" name="id_jadwal" value="{{ old('id_jadwal') }}">
                            @error('id_jadwal')
                                <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="keluhan" class="block text-xs font-semibold text-primary-800 mb-1.5">
                                Keluhan / Catatan <span class="text-slate-400 font-normal">(opsional)</span>
                            </label>
                            <textarea id="keluhan" name="keluhan"
                                placeholder="Ceritakan keluhan gigi Anda, misalnya: gigi berlubang bagian kanan atas, gusi bengkak, dll..."
                                class="w-full px-4 py-3 border-2 rounded-xl text-sm text-slate-800 bg-secondary-50 placeholder-secondary-400 outline-none transition focus:border-primary-500 focus:ring-2 focus:ring-primary-500/10 focus:bg-white resize-none @error('keluhan') border-red-400 @else border-secondary-200 @enderror"
                                rows="4" maxlength="255">{{ old('keluhan') }}</textarea>
                            <div class="flex justify-between mt-1">
                                @error('keluhan')
                                    <p class="text-red-500 text-xs">{{ $message }}</p>
                                @else
                                    <span></span>
                                @enderror
                                <p class="text-xs ml-auto text-secondary-400" id="keluhanCount">0/255 karakter</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div id="actionButtons" class="hidden space-y-3">
                    <div id="submitError" class="hidden bg-red-50 border border-red-200 rounded-xl p-3 text-red-600 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        <span id="submitErrorText"></span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" id="backBtn"
                                class="w-full bg-white text-primary-800 font-semibold py-3.5 rounded-xl border-2 border-secondary-200 hover:bg-secondary-50 hover:border-primary-400 transition text-sm">
                            ← Kembali
                        </button>
                        <button type="submit"
                                class="w-full text-white font-bold py-3.5 rounded-xl transition hover:-translate-y-0.5 hover:shadow-lg disabled:opacity-60 disabled:cursor-default text-sm"
                                style="background: linear-gradient(135deg, #D94A8C, #C63F7F);">
                            Buat Reservasi →
                        </button>
                    </div>
                    <p class="text-center text-xs text-secondary-400">Data Anda aman dan terlindungi sesuai kebijakan privasi kami</p>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const jadwalsData = @json($jadwals);

        const nikInput            = document.getElementById('nik');
        const checkNikBtn         = document.getElementById('checkNikBtn');
        const loadingSpinner      = document.getElementById('loadingSpinner');
        const errorMessage        = document.getElementById('errorMessage');
        const errorText           = document.getElementById('errorText');
        const step1               = document.getElementById('step1');
        const step2               = document.getElementById('step2');
        const step3               = document.getElementById('step3');
        const actionButtons       = document.getElementById('actionButtons');
        const existingPatientData = document.getElementById('existingPatientData');
        const newPatientForm      = document.getElementById('newPatientForm');
        const changeNikBtn        = document.getElementById('changeNikBtn');
        const changeNikBtn2       = document.getElementById('changeNikBtn2');
        const backBtn             = document.getElementById('backBtn');
        const jadwalTanggal       = document.getElementById('jadwalTanggal');
        const jadwalContainer     = document.getElementById('jadwalContainer');

        let patientFound = false;

        // Stepper
        function setStepActive(n) {
            for (let i = 1; i <= 3; i++) {
                const c = document.getElementById('stepCircle' + i);
                const l = document.getElementById('stepLine' + i);
                if (i < n) {
                    c.className = 'w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-primary-500 bg-primary-500 text-white';
                    c.innerHTML = '✓';
                } else if (i === n) {
                    c.className = 'w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-primary-500 bg-primary-500 text-white shadow-[0_0_0_4px_rgba(217,74,140,0.15)]';
                    c.innerHTML = i;
                } else {
                    c.className = 'w-9 h-9 rounded-full border-2 flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 border-secondary-200 bg-white text-secondary-400';
                    c.innerHTML = i;
                }
                if (l) {
                    l.className = 'h-0.5 flex-1 mx-2 -mt-3.5 transition-all duration-300 ' + (i < n ? 'bg-primary-500' : 'bg-secondary-200');
                }
            }
            const labels = ['Identitas', 'Data Pasien', 'Jadwal'];
            document.querySelectorAll('.flex.items-center.mb-8 span.text-xs').forEach((span, idx) => {
                if (idx + 1 <= n) {
                    span.className = 'text-xs font-semibold mt-1.5 whitespace-nowrap text-primary-500';
                } else {
                    span.className = 'text-xs font-medium mt-1.5 whitespace-nowrap text-slate-400';
                }
            });
        }

        jadwalTanggal.addEventListener('change', updateJadwalDisplay);

        function updateJadwalDisplay() {
            const selectedDate = jadwalTanggal.value;

            if (!selectedDate) {
                jadwalContainer.innerHTML = `<div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-secondary-400">
                    <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    <p class="text-sm">Pilih tanggal untuk melihat jadwal</p></div>`;
                return;
            }

            const filteredJadwals = jadwalsData.filter(j => j.tanggal === selectedDate);
            if (filteredJadwals.length === 0) {
                jadwalContainer.innerHTML = `<div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-secondary-400">
                    <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <p class="text-sm font-medium">Tidak ada jadwal untuk tanggal ini</p>
                    <p class="text-xs mt-1">Coba pilih tanggal lain</p></div>`;
                return;
            }

            jadwalContainer.innerHTML = filteredJadwals.map(jadwal => {
                const terisi      = jadwal.reservasi.length;
                const sisa        = jadwal.kuota - terisi;
                const isFull      = sisa <= 0;
                const jadwalValue = jadwal.id_jadwal || (jadwal.id_user + '_' + jadwal.tanggal);
                const isSelected  = document.getElementById('id_jadwal').value === String(jadwalValue);

                let badgeColor = '#D94A8C', badgeText = sisa + ' slot';
                if (isFull)         { badgeColor = '#ef4444'; badgeText = 'Penuh'; }
                else if (sisa <= 2) { badgeColor = '#f59e0b'; badgeText = sisa + ' tersisa'; }

                return `
                    <label class="jadwal-card cursor-pointer border-2 rounded-xl p-4 bg-white border-secondary-200 ${isSelected ? 'selected' : ''} ${isFull ? 'full border-red-200 bg-red-50' : ''}">
                        <input type="radio" name="id_jadwal" value="${jadwalValue}" class="sr-only"
                            ${isSelected ? 'checked' : ''} ${isFull ? 'disabled' : ''}
                            onchange="document.getElementById('id_jadwal').value = this.value; document.querySelectorAll('.jadwal-card').forEach(c => c.classList.remove('selected')); this.closest('.jadwal-card').classList.add('selected');">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 bg-secondary-50">
                                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">${jadwal.dokter.nama}</div>
                                    <div class="text-xs text-slate-400">Dokter Gigi</div>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold text-white" style="background:${badgeColor}">${badgeText}</span>
                        </div>
                        ${isSelected ? `<div class="mt-2 pt-2 border-t border-secondary-200 text-xs font-semibold flex items-center gap-1 text-primary-500">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            Dipilih
                        </div>` : ''}
                    </label>`;
            }).join('');
        }

        // Keluhan counter
        const keluhanField = document.getElementById('keluhan');
        const keluhanCount = document.getElementById('keluhanCount');
        keluhanField.addEventListener('input', () => {
            keluhanCount.textContent = keluhanField.value.length + '/255 karakter';
        });

        // Check NIK
        checkNikBtn.addEventListener('click', async () => {
            const nik = nikInput.value.trim();
            if (!nik || nik.length !== 16) { showError('NIK harus 16 digit angka'); return; }
            loadingSpinner.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            checkNikBtn.disabled = true;

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
                if (data.found) { patientFound = true; showExistingPatientData(data.pasien); }
                else            { patientFound = false; showNewPatientForm(); }
                step1.style.opacity = '0.65';
                nikInput.readOnly = true;
                step2.classList.remove('hidden');
                step3.classList.remove('hidden');
                actionButtons.classList.remove('hidden');
                step2.scrollIntoView({ behavior: 'smooth', block: 'start' });
                setStepActive(3);
            } catch (error) {
                loadingSpinner.classList.add('hidden');
                checkNikBtn.disabled = false;
                showError('Terjadi kesalahan koneksi. Silakan coba lagi.');
            }
        });

        function showExistingPatientData(pasien) {
            document.getElementById('displayNama').value         = pasien.nama;
            document.getElementById('displayNik').value          = pasien.nik;
            document.getElementById('displayJenisKelamin').value = pasien.jenis_kelamin === 'L' ? 'Laki-laki' : pasien.jenis_kelamin === 'P' ? 'Perempuan' : '-';
            document.getElementById('displayNoHp').value         = pasien.no_hp   || '-';
            document.getElementById('displayAlamat').value       = pasien.alamat  || '-';
            existingPatientData.classList.remove('hidden');
            newPatientForm.classList.add('hidden');
        }

        function showNewPatientForm() {
            existingPatientData.classList.add('hidden');
            newPatientForm.classList.remove('hidden');
        }

        function resetToStep1() {
            step1.style.opacity  = '1';
            nikInput.readOnly    = false;
            checkNikBtn.disabled = false;
            step2.classList.add('hidden');
            step3.classList.add('hidden');
            actionButtons.classList.add('hidden');
            nikInput.value = '';
            nikInput.focus();
            setStepActive(1);
            step1.scrollIntoView({ behavior: 'smooth' });
        }

        changeNikBtn.addEventListener('click', resetToStep1);
        if (changeNikBtn2) changeNikBtn2.addEventListener('click', resetToStep1);
        backBtn.addEventListener('click', resetToStep1);

        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
        }

        // Submit validation
        document.getElementById('reservasiForm').addEventListener('submit', e => {
            const submitError     = document.getElementById('submitError');
            const submitErrorText = document.getElementById('submitErrorText');
            const selectedJadwal  = document.querySelector('input[name="id_jadwal"]:checked');

            if (!selectedJadwal || !selectedJadwal.value) {
                e.preventDefault();
                submitErrorText.textContent = 'Silakan pilih jadwal dokter terlebih dahulu';
                submitError.classList.remove('hidden');
                step3.scrollIntoView({ behavior: 'smooth', block: 'start' });
                return;
            }
            if (!patientFound) {
                const nama = document.getElementById('nama').value.trim();
                if (!nama) {
                    e.preventDefault();
                    submitErrorText.textContent = 'Nama lengkap harus diisi untuk pendaftar baru';
                    submitError.classList.remove('hidden');
                    document.getElementById('nama').focus();
                    return;
                }
            }
            submitError.classList.add('hidden');
        });
    </script>
@endpush