<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Manajemen Jadwal Dokter</h2>
        </div>
    </x-slot>

    <div class="space-y-6" id="jadwal-app">

        {{-- Toast Notification --}}
        <div id="toast-notification" class="fixed top-6 right-6 z-50 transform translate-x-full transition-transform duration-500 ease-out">
            <div id="toast-content" class="flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl border backdrop-blur-sm">
                <div id="toast-icon" class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <p id="toast-title" class="text-sm font-bold"></p>
                    <p id="toast-message" class="text-sm"></p>
                </div>
                <button onclick="hideToast()" class="ml-4 text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl bg-green-50 border border-green-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Doctor Selection + Month Navigation --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Kalender Jadwal Praktik per Tanggal
                </h3>
                <p class="mt-1 text-sm text-green-100">Kelola kuota dan status hari praktik dokter</p>
            </div>

            <div class="p-6 border-b border-green-100 bg-gradient-to-r from-green-50/50 to-white">
                <form method="GET" action="{{ route('admin.jadwal.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[250px]">
                        <label for="dokter" class="block text-sm font-semibold text-slate-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Pilih Dokter
                        </label>
                        <select name="dokter" id="dokter"
                            class="w-full rounded-xl border-green-200 bg-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-3 px-4 transition-all hover:border-green-300">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach ($dokters as $dokter)
                                <option value="{{ $dokter->id_user }}" @selected($selectedDokter == $dokter->id_user)>
                                    {{ $dokter->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 10-.7.7l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        Tampilkan
                    </button>
                </form>
            </div>

            @if ($selectedDokter)
                {{-- Month Navigation --}}
                @php
                    $prevMonth = $month - 1;
                    $prevYear = $year;
                    if ($prevMonth < 1) { $prevMonth = 12; $prevYear--; }

                    $nextMonth = $month + 1;
                    $nextYear = $year;
                    if ($nextMonth > 12) { $nextMonth = 1; $nextYear++; }

                    $monthNames = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                @endphp

                <div class="flex items-center justify-between px-8 py-5 border-b border-green-100 bg-white">
                    <a href="{{ route('admin.jadwal.index', ['dokter' => $selectedDokter, 'month' => $prevMonth, 'year' => $prevYear]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-50 hover:bg-green-100 text-green-700 font-medium transition-all border border-green-200 hover:border-green-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                        </svg>
                        Sebelumnya
                    </a>
                    <div class="text-center">
                        <h4 class="text-xl font-bold text-slate-900">{{ $monthNames[$month] }} {{ $year }}</h4>
                        <p class="text-sm text-slate-500 mt-0.5">
                            dr. {{ $dokters->firstWhere('id_user', $selectedDokter)?->nama ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('admin.jadwal.index', ['dokter' => $selectedDokter, 'month' => $nextMonth, 'year' => $nextYear]) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-50 hover:bg-green-100 text-green-700 font-medium transition-all border border-green-200 hover:border-green-300">
                        Berikutnya
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                        </svg>
                    </a>
                </div>

                {{-- Legend --}}
                <div class="flex flex-wrap items-center gap-6 px-8 py-4 border-b border-green-100 bg-slate-50/50">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Keterangan:</span>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="text-sm text-slate-600">Aktif</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                        <span class="text-sm text-slate-600">Nonaktif</span>
                    </div>
                </div>

                {{-- Calendar Grid --}}
                <div class="p-6">
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                            <div class="text-center text-xs font-bold text-slate-500 uppercase tracking-wider py-3">{{ $day }}</div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-7 gap-1">
                        @php
                            $dayOfWeek = $startOfMonth->dayOfWeekIso; // 1=Monday
                            $daysInMonth = $startOfMonth->daysInMonth;
                            $today = \Carbon\Carbon::today()->toDateString();
                        @endphp

                        {{-- Empty cells before the first day --}}
                        @for ($i = 1; $i < $dayOfWeek; $i++)
                            <div class="aspect-square"></div>
                        @endfor

                        {{-- Days --}}
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                                $jadwal = \App\Models\Jadwal::where('id_user', $selectedDokter)
                                    ->where('tanggal', $dateStr)
                                    ->first();
                                $isToday = $dateStr === $today;
                            @endphp
                            <button type="button"
                                onclick="openJadwalModal('{{ $dateStr }}')"
                                data-date="{{ $dateStr }}"
                                class="calendar-day aspect-square rounded-xl border-2 p-2 flex flex-col items-center justify-center gap-1 transition-all duration-200 cursor-pointer hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500/50 relative group
                                    {{ $isToday ? 'border-green-500 bg-green-50 ring-2 ring-green-200' : 'border-slate-100 bg-white hover:border-green-300 hover:bg-green-50/50' }}">

                                <span class="text-sm font-bold {{ $isToday ? 'text-green-700' : 'text-slate-700 group-hover:text-green-700' }} transition-colors">{{ $day }}</span>

                                @if ($jadwal)
                                    <div class="flex items-center gap-1 flex-wrap justify-center">
                                        <span class="inline-flex items-center justify-center min-w-[18px] h-[18px] rounded-full 
                                            {{ $jadwal->status === 'aktif' ? 'bg-emerald-500' : 'bg-slate-400' }} 
                                            text-white text-[10px] font-bold px-1">{{ $jadwal->reservasi->count() }}</span>
                                        <span class="text-[10px] text-slate-500">/{{ $jadwal->kuota }}</span>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-300">—</span>
                                @endif

                                @if ($isToday)
                                    <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                                @endif
                            </button>
                        @endfor
                    </div>
                </div>
            @else
                {{-- No Doctor Selected State --}}
                <div class="p-16 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-700 mb-2">Pilih Dokter Terlebih Dahulu</h4>
                    <p class="text-sm text-slate-500 max-w-md mx-auto">Pilih dokter dari menu di atas untuk melihat dan mengelola kalender jadwal praktik.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Jadwal Detail Modal --}}
    <div id="jadwal-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 overflow-hidden transform transition-all max-h-[90vh] flex flex-col">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-5 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-100" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                        <div>
                            <h3 class="text-lg font-bold text-white" id="modal-date-label"></h3>
                            <p class="text-sm text-green-100 mt-0.5">Detail Jadwal Praktik</p>
                        </div>
                    </div>
                    <button onclick="closeJadwalModal()" class="text-green-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
                {{-- Status & Kuota Section --}}
                <div id="jadwal-loading" class="hidden text-center py-8">
                    <div class="inline-flex items-center gap-3 text-green-600">
                        <svg class="animate-spin w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"/>
                            <path class="opacity-75" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" fill="currentColor"/>
                        </svg>
                        <span class="font-medium">Memuat data...</span>
                    </div>
                </div>

                <div id="jadwal-content" class="hidden space-y-6">
                    {{-- Status & Info --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs text-blue-600 font-semibold uppercase mb-1">Status</p>
                            <div class="flex items-center gap-2">
                                <span id="status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-emerald-500"></span>
                                <span id="status-text" class="text-xl font-bold text-blue-700"></span>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                            <p class="text-xs text-purple-600 font-semibold uppercase mb-1">Kuota</p>
                            <p id="kuota-text" class="text-3xl font-bold text-purple-700">5</p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 border border-amber-200">
                            <p class="text-xs text-amber-600 font-semibold uppercase mb-1">Terisi / Tersedia</p>
                            <p id="kapasitas-text" class="text-3xl font-bold text-amber-700">0/5</p>
                        </div>
                    </div>

                    {{-- Control Section --}}
                    <div class="space-y-3">
                        {{-- Adjust Kuota --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Ubah Kuota</label>
                            <div class="flex items-center gap-2">
                                <input type="number" id="new-kuota" min="1" max="100" class="flex-1 rounded-xl border-green-200 text-sm py-2 px-4 focus:border-green-500 focus:ring-green-500" value="5">
                                <button onclick="updateKuota()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-all">Perbarui</button>
                            </div>
                        </div>

                        {{-- Toggle Status --}}
                        <div>
                            <button id="toggle-status-btn" onclick="toggleStatus()" class="w-full py-3 px-4 rounded-xl font-semibold transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                </svg>
                                <span id="toggle-status-text">Nonaktifkan Hari Ini</span>
                            </button>
                        </div>
                    </div>

                    {{-- Reservasi List --}}
                    <div class="border-t pt-6">
                        <h4 class="text-lg font-bold text-slate-900 mb-4">Daftar Reservasi Hari Ini</h4>
                        <div id="reservasi-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                        <div id="reservasi-empty" class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="mt-2 text-sm text-slate-500 font-medium">Belum ada reservasi pada hari ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const dokterId = '{{ $selectedDokter }}';
        let currentJadwalId = null;
        let currentDate = null;
        let toastTimeout = null;

        // === Toast ===
        function showToast(title, message, type = 'success') {
            const toast = document.getElementById('toast-notification');
            const content = document.getElementById('toast-content');
            const icon = document.getElementById('toast-icon');
            const titleEl = document.getElementById('toast-title');
            const messageEl = document.getElementById('toast-message');

            if (type === 'success') {
                content.className = 'flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl border bg-white border-green-200';
                icon.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-green-500';
                titleEl.className = 'text-sm font-bold text-green-800';
                messageEl.className = 'text-sm text-green-600';
            } else {
                content.className = 'flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl border bg-white border-red-200';
                icon.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500';
                titleEl.className = 'text-sm font-bold text-red-800';
                messageEl.className = 'text-sm text-red-600';
            }

            titleEl.textContent = title;
            messageEl.textContent = message;

            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');

            if (toastTimeout) clearTimeout(toastTimeout);
            toastTimeout = setTimeout(hideToast, 4000);
        }

        function hideToast() {
            const toast = document.getElementById('toast-notification');
            toast.classList.add('translate-x-full');
            toast.classList.remove('translate-x-0');
        }

        // === Modal ===
        function openJadwalModal(dateStr) {
            if (!dokterId) return;
            
            currentDate = dateStr;
            const modal = document.getElementById('jadwal-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Format date label
            const d = new Date(dateStr + 'T00:00:00');
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            document.getElementById('modal-date-label').textContent = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;

            fetchJadwalDetail(dateStr);
        }

        function closeJadwalModal() {
            const modal = document.getElementById('jadwal-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentJadwalId = null;
        }

        async function fetchJadwalDetail(dateStr) {
            const loading = document.getElementById('jadwal-loading');
            const content = document.getElementById('jadwal-content');

            loading.classList.remove('hidden');
            content.classList.add('hidden');

            try {
                const res = await fetch('{{ route("admin.jadwal.getSlots") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ dokter: dokterId, tanggal: dateStr }),
                });

                const data = await res.json();

                loading.classList.add('hidden');
                content.classList.remove('hidden');

                if (data.jadwal) {
                    currentJadwalId = data.jadwal.id;
                    renderJadwalDetail(data.jadwal);
                } else {
                    // No jadwal yet, create new one
                    createNewJadwal(dateStr);
                }
            } catch (e) {
                loading.classList.add('hidden');
                content.classList.remove('hidden');
                showToast('Error', 'Gagal memuat data jadwal.', 'error');
            }
        }

        function renderJadwalDetail(jadwal) {
            // Status
            const statusBg = jadwal.status === 'aktif' ? 'bg-emerald-500' : 'bg-slate-400';
            const statusText = jadwal.status === 'aktif' ? 'Aktif' : 'Nonaktif';
            document.getElementById('status-badge').className = `inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white ${statusBg}`;
            document.getElementById('status-badge').textContent = statusText;
            document.getElementById('status-text').textContent = statusText;

            // Kuota & Kapasitas
            document.getElementById('kuota-text').textContent = jadwal.kuota;
            document.getElementById('new-kuota').value = jadwal.kuota;
            document.getElementById('kapasitas-text').textContent = `${jadwal.reservasi_count}/${jadwal.kuota}`;

            // Toggle button
            const toggleBtn = document.getElementById('toggle-status-btn');
            if (jadwal.status === 'aktif') {
                toggleBtn.className = 'w-full py-3 px-4 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 bg-slate-200 hover:bg-slate-300 text-slate-700';
                document.getElementById('toggle-status-text').textContent = 'Nonaktifkan Hari Ini';
            } else {
                toggleBtn.className = 'w-full py-3 px-4 rounded-xl font-semibold transition-all flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white';
                document.getElementById('toggle-status-text').textContent = 'Aktifkan Hari Ini';
            }

            // Reservasi list
            renderReservasiList(jadwal.reservasi);
        }

        function renderReservasiList(reservasi) {
            const list = document.getElementById('reservasi-list');
            const empty = document.getElementById('reservasi-empty');

            list.innerHTML = '';

            if (reservasi.length === 0) {
                list.parentElement.style.display = 'none';
                empty.style.display = 'block';
            } else {
                list.parentElement.style.display = 'block';
                empty.style.display = 'none';

                reservasi.forEach((r) => {
                    const card = document.createElement('div');
                    card.className = 'bg-slate-50 rounded-lg p-4 border border-slate-200';
                    card.innerHTML = `
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-600 text-white text-xs font-bold">${r.urutan}</span>
                                    <div>
                                        <p class="font-semibold text-slate-900">${r.nama_pasien}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">${r.created_at}</p>
                                    </div>
                                </div>
                                ${r.keluhan ? `<p class="text-sm text-slate-600 mt-2">Keluhan: ${r.keluhan}</p>` : ''}
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                ${r.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : r.status === 'confirmed' ? 'bg-blue-100 text-blue-800' : r.status === 'selesai' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${r.status === 'pending' ? 'Pending' : r.status === 'confirmed' ? 'Confirmed' : r.status === 'selesai' ? 'Selesai' : 'Batal'}
                            </span>
                        </div>
                    `;
                    list.appendChild(card);
                });
            }
        }

        async function createNewJadwal(dateStr) {
            try {
                const res = await fetch('{{ route("admin.jadwal.generateSlots") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ dokter: dokterId, tanggal: dateStr, kuota: 5 }),
                });

                const data = await res.json();

                if (data.success) {
                    currentJadwalId = data.jadwal.id;
                    fetchJadwalDetail(dateStr);
                }
            } catch (e) {
                showToast('Error', 'Gagal membuat jadwal baru.', 'error');
            }
        }

        async function updateKuota() {
            if (!currentJadwalId) return;

            const newKuota = parseInt(document.getElementById('new-kuota').value);

            if (isNaN(newKuota) || newKuota < 1) {
                showToast('Error', 'Kuota harus berupa angka positif.', 'error');
                return;
            }

            try {
                const res = await fetch('{{ route("admin.jadwal.update", ":id") }}'.replace(':id', currentJadwalId), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ 
                        id_user: dokterId, 
                        tanggal: currentDate, 
                        kuota: newKuota 
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    showToast('Berhasil!', 'Kuota berhasil diperbarui.', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    showToast('Error', data.message || 'Gagal memperbarui kuota.', 'error');
                }
            } catch (e) {
                console.error('Error:', e);
                showToast('Error', 'Terjadi kesalahan: ' + e.message, 'error');
            }
        }

        async function toggleStatus() {
            if (!currentJadwalId) return;

            const currentStatus = document.getElementById('status-text').textContent.trim();
            const newStatus = currentStatus === 'Aktif' ? 'nonaktif' : 'aktif';

            try {
                const res = await fetch('{{ route("admin.jadwal.update", ":id") }}'.replace(':id', currentJadwalId), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ 
                        id_user: dokterId, 
                        tanggal: currentDate, 
                        kuota: parseInt(document.getElementById('kuota-text').textContent),
                        status: newStatus
                    }),
                });

                const data = await res.json();

                if (data.success) {
                    showToast('Berhasil!', `Status berhasil diubah menjadi ${newStatus}.`, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 800);
                } else {
                    showToast('Error', data.message || 'Gagal mengubah status.', 'error');
                }
            } catch (e) {
                console.error('Error:', e);
                showToast('Error', 'Terjadi kesalahan: ' + e.message, 'error');
            }
        }

        // Close modal on backdrop click
        document.getElementById('jadwal-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeJadwalModal();
        });
    </script>
</x-app-layout>
