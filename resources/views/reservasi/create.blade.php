<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reservasi - Klinik Gigi Sejahtera</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #eff6ff 100%);
            min-height: 100vh;
        }

        /* Stepper */
        .step-line {
            height: 2px;
            background: #e2e8f0;
            flex: 1;
            transition: background 0.4s ease;
        }
        .step-line.active { background: #16a34a; }

        .step-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            background: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700;
            color: #94a3b8;
            transition: all 0.4s ease;
            flex-shrink: 0;
        }
        .step-circle.active {
            border-color: #16a34a;
            background: #16a34a;
            color: white;
            box-shadow: 0 0 0 4px rgba(22,163,74,0.15);
        }
        .step-circle.done {
            border-color: #16a34a;
            background: #16a34a;
            color: white;
        }

        /* Form inputs */
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.925rem;
            color: #1e293b;
            background: #fafafa;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
            background: white;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input.error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }
        .form-input[readonly] { background: #f1f5f9; color: #64748b; cursor: default; }

        /* Section cards */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
        }

        /* Jadwal card */
        .jadwal-card {
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }
        .jadwal-card:hover { border-color: #16a34a; background: #f0fdf4; }
        .jadwal-card.selected { border-color: #16a34a; background: #f0fdf4; box-shadow: 0 0 0 3px rgba(22,163,74,0.15); }
        .jadwal-card.full { opacity: 0.5; cursor: not-allowed; border-color: #fca5a5; background: #fef2f2; }

        /* Quota badge */
        .quota-badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 11px; font-weight: 700;
            color: white;
        }

        /* Slide transition for steps */
        .step-content { 
            animation: slideIn 0.4s ease; 
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Loading spinner */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; }

        /* Flatpickr overrides */
        .flatpickr-calendar { border-radius: 12px !important; box-shadow: 0 10px 40px rgba(0,0,0,0.12) !important; }
        .flatpickr-day.selected { background: #16a34a !important; border-color: #16a34a !important; }
        .flatpickr-day:hover { background: #dcfce7 !important; }

        /* Primary button */
        .btn-primary {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            font-weight: 700;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            font-size: 0.975rem;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(22,163,74,0.35); }
        .btn-primary:disabled { opacity: 0.6; cursor: default; transform: none; box-shadow: none; }

        .btn-secondary {
            background: white;
            color: #475569;
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            font-size: 0.975rem;
        }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }

        /* Label */
        .form-label {
            display: block;
            font-size: 0.825rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 0.375rem;
            letter-spacing: 0.01em;
        }

        /* Alert boxes */
        .alert-info { background: #eff6ff; border: 1px solid #bfdbfe; border-left: 3px solid #3b82f6; border-radius: 12px; }
        .alert-amber { background: #fffbeb; border: 1px solid #fde68a; border-left: 3px solid #f59e0b; border-radius: 12px; }
        .alert-red { background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; }
        .alert-green { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; }

        /* Sticky nav */
        .navbar-glass {
            background: rgba(20, 83, 45, 0.96);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-glass text-white shadow-md sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-5 sm:px-6 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.5 2 6 4.1 6 7c0 2.5 1.5 4.5 3 5.5V19c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-6.5c1.5-1 3-3 3-5.5 0-2.9-2.5-5-6-5z"/>
                    </svg>
                </div>
                <span class="font-bold text-base">Klinik Gigi Sejahtera</span>
            </div>
            <a href="{{ route('reservasi.index') }}" class="flex items-center gap-1.5 text-green-200 hover:text-white text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="font-display text-3xl sm:text-4xl text-slate-900 mb-2">Form Reservasi</h1>
            <p class="text-slate-500 text-sm sm:text-base">Isi data Anda untuk membuat janji temu dengan dokter gigi kami</p>
        </div>

        <!-- Stepper -->
        <div class="flex items-center mb-8 px-2">
            <div class="flex flex-col items-center">
                <div id="stepCircle1" class="step-circle active">1</div>
                <span class="text-xs font-semibold mt-1.5 text-green-600 whitespace-nowrap">Identitas</span>
            </div>
            <div id="stepLine1" class="step-line mx-2 mt-[-14px]"></div>
            <div class="flex flex-col items-center">
                <div id="stepCircle2" class="step-circle">2</div>
                <span class="text-xs font-medium mt-1.5 text-slate-400 whitespace-nowrap">Data Pasien</span>
            </div>
            <div id="stepLine2" class="step-line mx-2 mt-[-14px]"></div>
            <div class="flex flex-col items-center">
                <div id="stepCircle3" class="step-circle">3</div>
                <span class="text-xs font-medium mt-1.5 text-slate-400 whitespace-nowrap">Jadwal</span>
            </div>
        </div>

        <!-- Form -->
        <form id="reservasiForm" method="POST" action="{{ route('reservasi.store') }}">
            @csrf

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert-red p-4 mb-6">
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

            <!-- STEP 1: NIK -->
            <div id="step1" class="form-card mb-5 step-content">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-9 4h2v2h-2V8zm0 3h2v6h-2v-6zm-4-3h2v8H7V8zm10 8h-2v-4h2v4zm0-5h-2V8h2v3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">Langkah 1: Verifikasi Identitas</h2>
                        <p class="text-xs text-slate-400">Masukkan NIK untuk memeriksa data Anda</p>
                    </div>
                </div>

                <label for="nik" class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                <div class="flex gap-2.5">
                    <input 
                        type="text" 
                        id="nik" 
                        name="nik" 
                        placeholder="Masukkan 16 digit NIK Anda"
                        class="form-input flex-1 @error('nik') error @enderror"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        inputmode="numeric"
                        required
                    >
                    <button type="button" id="checkNikBtn" class="px-5 py-3 bg-green-600 text-white rounded-xl font-bold text-sm hover:bg-green-700 transition flex-shrink-0 flex items-center gap-2">
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

                <!-- Loading -->
                <div id="loadingSpinner" class="hidden mt-3 flex items-center gap-2 text-green-600">
                    <svg class="spinner w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span class="text-sm font-medium">Memeriksa data...</span>
                </div>

                <!-- Error message -->
                <div id="errorMessage" class="hidden mt-3 alert-red p-3 text-red-600 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span id="errorText"></span>
                </div>
            </div>

            <!-- STEP 2: Patient Data -->
            <div id="step2" class="hidden mb-5 step-content">
                <div class="form-card">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-900">Langkah 2: Data Pasien</h2>
                            <p class="text-xs text-slate-400">Lengkapi informasi diri Anda</p>
                        </div>
                    </div>

                    <!-- Existing patient -->
                    <div id="existingPatientData" class="hidden">
                        <div class="alert-info p-3 mb-4 flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                            <p class="text-blue-700 text-xs font-medium">Anda sudah terdaftar. Data berikut diambil dari sistem kami.</p>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="displayNama" class="form-input" readonly>
                            </div>
                            <div>
                                <label class="form-label">NIK</label>
                                <input type="text" id="displayNik" class="form-input" readonly>
                            </div>
                            <div>
                                <label class="form-label">Jenis Kelamin</label>
                                <input type="text" id="displayJenisKelamin" class="form-input" readonly>
                            </div>
                            <div>
                                <label class="form-label">Nomor HP</label>
                                <input type="text" id="displayNoHp" class="form-input" readonly>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Alamat</label>
                                <textarea id="displayAlamat" class="form-input resize-none" readonly rows="2"></textarea>
                            </div>
                        </div>
                        <button type="button" id="changeNikBtn" class="mt-4 text-green-600 hover:text-green-800 text-sm font-semibold flex items-center gap-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Ubah NIK
                        </button>
                    </div>

                    <!-- New patient form -->
                    <div id="newPatientForm" class="hidden">
                        <div class="alert-amber p-3 mb-4 flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                            <p class="text-amber-700 text-xs font-medium">NIK belum terdaftar. Silakan lengkapi data Anda sebagai pasien baru.</p>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="sm:col-span-2">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda"
                                    class="form-input @error('nama') error @enderror"
                                    value="{{ old('nama') }}" maxlength="50">
                                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-input @error('jenis_kelamin') error @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" @selected(old('jenis_kelamin') == 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin') == 'P')>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="tel" id="no_hp" name="no_hp" placeholder="081234567890"
                                    class="form-input @error('no_hp') error @enderror"
                                    value="{{ old('no_hp') }}" maxlength="20">
                                @error('no_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap Anda"
                                    class="form-input resize-none @error('alamat') error @enderror"
                                    rows="3" maxlength="100">{{ old('alamat') }}</textarea>
                                @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <button type="button" id="changeNikBtn2" class="mt-4 text-green-600 hover:text-green-800 text-sm font-semibold flex items-center gap-1.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Ubah NIK
                        </button>
                    </div>
                </div>
            </div>

            <!-- STEP 3: Jadwal & Keluhan -->
            <div id="step3" class="hidden mb-5 step-content">
                <div class="form-card">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-900">Langkah 3: Pilih Jadwal</h2>
                            <p class="text-xs text-slate-400">Pilih tanggal dan dokter yang tersedia</p>
                        </div>
                    </div>

                    <!-- Date picker -->
                    <div class="mb-5">
                        <label class="form-label">Pilih Tanggal Kunjungan <span class="text-red-500">*</span></label>
                        <input 
                            type="date" 
                            id="jadwalTanggal"
                            class="form-input"
                            min="{{ \Carbon\Carbon::today()->toDateString() }}"
                            max="{{ \Carbon\Carbon::today()->addMonths(3)->toDateString() }}"
                        >
                    </div>

                    <!-- Available schedules -->
                    <div class="mb-5">
                        <label class="form-label mb-2">Jadwal Tersedia</label>
                        <div id="jadwalContainer" class="grid grid-cols-1 sm:grid-cols-2 gap-3 min-h-[100px]">
                            <div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-slate-400">
                                <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/>
                                </svg>
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

                    <!-- Keluhan -->
                    <div>
                        <label for="keluhan" class="form-label">Keluhan / Catatan <span class="text-slate-400 font-normal">(opsional)</span></label>
                        <textarea 
                            id="keluhan" 
                            name="keluhan" 
                            placeholder="Ceritakan keluhan gigi Anda, misalnya: gigi berlubang bagian kanan atas, gusi bengkak, dll..." 
                            class="form-input resize-none @error('keluhan') error @enderror"
                            rows="4"
                            maxlength="255"
                        >{{ old('keluhan') }}</textarea>
                        <div class="flex justify-between mt-1">
                            @error('keluhan')
                                <p class="text-red-500 text-xs">{{ $message }}</p>
                            @else
                                <span></span>
                            @enderror
                            <p class="text-xs text-slate-400 ml-auto" id="keluhanCount">0/255 karakter</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div id="actionButtons" class="hidden space-y-3">
                <!-- Error message for submit -->
                <div id="submitError" class="hidden alert-red p-3 text-red-600 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <span id="submitErrorText"></span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button type="button" id="backBtn" class="btn-secondary">← Kembali</button>
                    <button type="submit" class="btn-primary">Buat Reservasi →</button>
                </div>
                <p class="text-center text-xs text-slate-400">Data Anda aman dan terlindungi sesuai kebijakan privasi kami</p>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="py-5 px-5 text-center">
        <p class="text-xs text-slate-400">&copy; 2026 Klinik Gigi Sejahtera. Semua hak dilindungi.</p>
    </footer>

    <script>
        const jadwalsData = @json($jadwals);

        const nikInput = document.getElementById('nik');
        const checkNikBtn = document.getElementById('checkNikBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');

        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const actionButtons = document.getElementById('actionButtons');

        const existingPatientData = document.getElementById('existingPatientData');
        const newPatientForm = document.getElementById('newPatientForm');
        const changeNikBtn = document.getElementById('changeNikBtn');
        const changeNikBtn2 = document.getElementById('changeNikBtn2');
        const backBtn = document.getElementById('backBtn');

        const jadwalTanggal = document.getElementById('jadwalTanggal');
        const jadwalContainer = document.getElementById('jadwalContainer');

        let patientFound = false;

        // Stepper helpers
        function setStepActive(n) {
            for (let i = 1; i <= 3; i++) {
                const c = document.getElementById('stepCircle' + i);
                const l = document.getElementById('stepLine' + i);
                if (i < n) { c.className = 'step-circle done'; c.innerHTML = '✓'; }
                else if (i === n) { c.className = 'step-circle active'; c.innerHTML = i; }
                else { c.className = 'step-circle'; c.innerHTML = i; }
                if (l) l.className = 'step-line mx-2 mt-[-14px]' + (i < n ? ' active' : '');
            }
            // Update label colors
            ['Identitas','Data Pasien','Jadwal'].forEach((label, idx) => {
                const span = document.querySelectorAll('.flex.items-center.mb-8 span.text-xs')[idx];
                if (span) span.className = 'text-xs font-' + (idx + 1 <= n ? 'semibold' : 'medium') + ' mt-1.5 ' + (idx + 1 === n ? 'text-green-600' : idx + 1 < n ? 'text-green-700' : 'text-slate-400') + ' whitespace-nowrap';
            });
        }

        // Flatpickr
        flatpickr(jadwalTanggal, {
            minDate: new Date(),
            maxDate: new Date(new Date().setMonth(new Date().getMonth() + 3)),
            dateFormat: 'Y-m-d',
            locale: 'id',
            onChange: updateJadwalDisplay
        });
        jadwalTanggal.addEventListener('change', updateJadwalDisplay);

        function updateJadwalDisplay() {
            const selectedDate = jadwalTanggal.value;
            if (!selectedDate) {
                jadwalContainer.innerHTML = `<div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-slate-400">
                    <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    <p class="text-sm">Pilih tanggal untuk melihat jadwal</p></div>`;
                return;
            }

            const filteredJadwals = jadwalsData.filter(j => j.tanggal === selectedDate);
            if (filteredJadwals.length === 0) {
                jadwalContainer.innerHTML = `<div class="sm:col-span-2 flex flex-col items-center justify-center py-10 text-slate-400">
                    <svg class="w-10 h-10 mb-2 opacity-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    <p class="text-sm font-medium">Tidak ada jadwal untuk tanggal ini</p>
                    <p class="text-xs mt-1">Coba pilih tanggal lain</p></div>`;
                return;
            }

            jadwalContainer.innerHTML = filteredJadwals.map(jadwal => {
                const terisi = jadwal.reservasi.length;
                const sisa = jadwal.kuota - terisi;
                const isFull = sisa <= 0;
                const jadwalValue = jadwal.id_jadwal || (jadwal.id_user + '_' + jadwal.tanggal);
                const isSelected = document.getElementById('id_jadwal').value === String(jadwalValue);

                let badgeColor = '#16a34a';
                let badgeText = sisa + ' slot';
                if (isFull) { badgeColor = '#ef4444'; badgeText = 'Penuh'; }
                else if (sisa <= 2) { badgeColor = '#f59e0b'; badgeText = sisa + ' tersisa'; }

                return `
                    <label class="jadwal-card ${isSelected ? 'selected' : ''} ${isFull ? 'full' : ''}">
                        <input type="radio" name="id_jadwal" value="${jadwalValue}" class="sr-only"
                            ${isSelected ? 'checked' : ''} ${isFull ? 'disabled' : ''}
                            onchange="document.getElementById('id_jadwal').value = this.value; document.querySelectorAll('.jadwal-card').forEach(c => c.classList.remove('selected')); this.closest('.jadwal-card').classList.add('selected');">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800 text-sm">${jadwal.dokter.nama}</div>
                                    <div class="text-xs text-slate-400">Dokter Gigi</div>
                                </div>
                            </div>
                            <span class="quota-badge text-white" style="background:${badgeColor}">${badgeText}</span>
                        </div>
                        ${isSelected ? `<div class="mt-2 pt-2 border-t border-green-200 text-xs text-green-600 font-semibold flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                            Dipilih
                        </div>` : ''}
                    </label>
                `;
            }).join('');
        }

        // Keluhan character counter
        const keluhanField = document.getElementById('keluhan');
        const keluhanCount = document.getElementById('keluhanCount');
        keluhanField.addEventListener('input', () => {
            keluhanCount.textContent = keluhanField.value.length + '/255 karakter';
        });

        // Check NIK
        checkNikBtn.addEventListener('click', async () => {
            const nik = nikInput.value.trim();
            if (!nik || nik.length !== 16) {
                showError('NIK harus 16 digit angka');
                return;
            }
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

                if (data.found) {
                    patientFound = true;
                    showExistingPatientData(data.pasien);
                } else {
                    patientFound = false;
                    showNewPatientForm();
                }

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
            document.getElementById('displayNama').value = pasien.nama;
            document.getElementById('displayNik').value = pasien.nik;
            document.getElementById('displayJenisKelamin').value = pasien.jenis_kelamin === 'L' ? 'Laki-laki' : pasien.jenis_kelamin === 'P' ? 'Perempuan' : '-';
            document.getElementById('displayNoHp').value = pasien.no_hp || '-';
            document.getElementById('displayAlamat').value = pasien.alamat || '-';
            existingPatientData.classList.remove('hidden');
            newPatientForm.classList.add('hidden');
        }

        function showNewPatientForm() {
            existingPatientData.classList.add('hidden');
            newPatientForm.classList.remove('hidden');
        }

        function resetToStep1() {
            step1.style.opacity = '1';
            nikInput.readOnly = false;
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
            const submitError = document.getElementById('submitError');
            const submitErrorText = document.getElementById('submitErrorText');
            const selectedJadwal = document.querySelector('input[name="id_jadwal"]:checked');

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
</body>
</html>