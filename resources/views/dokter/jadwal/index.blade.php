<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Jadwal Praktik Saya</h2>
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

        {{-- Kalender Jadwal --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden mx-6">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Kalender Jadwal Praktik
                </h3>
                <p class="mt-1 text-sm text-green-100">Lihat jumlah booking per tanggal</p>
            </div>

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
                <a href="{{ route('dokter.jadwal.index', ['month' => $prevMonth, 'year' => $prevYear]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12l4.58-4.59z"/>
                    </svg>
                    Sebelumnya
                </a>

                <div class="text-center">
                    <h4 class="text-2xl font-bold text-slate-900">{{ $monthNames[$month] }} {{ $year }}</h4>
                </div>

                <a href="{{ route('dokter.jadwal.index', ['month' => $nextMonth, 'year' => $nextYear]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-lg transition-all">
                    Selanjutnya
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                    </svg>
                </a>
            </div>

            {{-- Legend --}}
            <div class="flex flex-wrap items-center gap-6 px-8 py-4 border-b border-green-100 bg-slate-50/50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Keterangan:</span>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-green-500"></div>
                    <span class="text-sm text-slate-600">Ada Booking</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-slate-200"></div>
                    <span class="text-sm text-slate-600">Tidak Ada Jadwal</span>
                </div>
            </div>

            {{-- Calendar Grid --}}
            <div class="p-6">
                <div class="grid grid-cols-7 gap-2 mb-3">
                    @foreach (['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                        <div class="h-10 flex items-center justify-center font-bold text-slate-900 text-sm border-b-2 border-slate-300">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @php
                        $firstDay = \Carbon\Carbon::createFromDate($year, $month, 1);
                        $startOfCalendar = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                        $endOfCalendar = $firstDay->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SUNDAY);

                        // Get all jadwals for this month
                        $jadwals = \App\Models\Jadwal::where('id_user', auth()->id())
                            ->whereBetween('tanggal', [$startOfCalendar->toDateString(), $endOfCalendar->toDateString()])
                            ->with('reservasi')
                            ->get()
                            ->groupBy('tanggal');
                    @endphp

                    @while ($startOfCalendar <= $endOfCalendar)
                        @php
                            $dateStr = $startOfCalendar->toDateString();
                            $jadwal = $jadwals->get($dateStr)?->first();
                            $bookingCount = $jadwal?->reservasi()->count() ?? 0;
                            $isCurrentMonth = $startOfCalendar->month == $month;
                        @endphp

                        <div class="min-h-28 p-3 rounded-lg border-2 transition-all {{ !$isCurrentMonth ? 'bg-slate-100 border-slate-200 text-slate-400' : ($jadwal ? 'bg-green-50 border-green-400 cursor-pointer hover:shadow-lg' : 'bg-white border-slate-300') }}"
                             @if($isCurrentMonth && $jadwal) onclick="openJadwalModal('{{ $dateStr }}')" @endif>
                            <div class="font-bold text-lg mb-2">{{ $startOfCalendar->day }}</div>
                            @if ($isCurrentMonth && $jadwal)
                                <div class="text-center pt-2 border-t border-green-200">
                                    <div class="text-2xl font-bold text-green-600">{{ $bookingCount }}</div>
                                    <div class="text-xs text-green-700 font-semibold">booking</div>
                                </div>
                            @elseif(!$isCurrentMonth)
                                <div class="text-xs text-slate-400">-</div>
                            @endif
                        </div>

                        @php $startOfCalendar->addDay(); @endphp
                    @endwhile
                </div>
            </div>
        </div>
    </div>

    {{-- Jadwal Detail Modal --}}
    <div id="jadwal-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 overflow-hidden transform transition-all">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-100" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-green-100">Jadwal Praktik</p>
                            <p id="modal-date-label" class="text-lg font-bold text-white"></p>
                        </div>
                    </div>
                    <button onclick="closeJadwalModal()" class="text-green-100 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 space-y-6">
                {{-- Status & Kuota Section --}}
                <div id="jadwal-loading" class="hidden text-center py-8">
                    <div class="inline-flex items-center gap-3 text-green-600">
                        <svg class="animate-spin w-6 h-6" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-medium">Memuat data...</span>
                    </div>
                </div>

                <div id="jadwal-content" class="hidden space-y-6">
                    {{-- Status & Info --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <p class="text-xs text-blue-600 font-semibold uppercase mb-1">Status</p>
                            <p id="status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold text-white bg-emerald-500">Aktif</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                            <p class="text-xs text-purple-600 font-semibold uppercase mb-1">Kuota</p>
                            <p id="kuota-text" class="text-3xl font-bold text-purple-700">5</p>
                        </div>
                    </div>

                    {{-- Reservasi List --}}
                    <div class="border-t pt-6">
                        <h4 class="text-lg font-bold text-slate-900 mb-4">Daftar Reservasi</h4>
                        <div id="reservasi-list" class="space-y-3">
                            {{-- Populated by JS --}}
                        </div>
                        <div id="reservasi-empty" class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
        }

        async function fetchJadwalDetail(dateStr) {
            const loading = document.getElementById('jadwal-loading');
            const content = document.getElementById('jadwal-content');

            loading.classList.remove('hidden');
            content.classList.add('hidden');

            try {
                const res = await fetch('{{ route("dokter.jadwal.getSlots") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ tanggal: dateStr }),
                });

                const data = await res.json();

                loading.classList.add('hidden');
                content.classList.remove('hidden');

                if (data.jadwal) {
                    renderJadwalDetail(data.jadwal);
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

            // Kuota
            document.getElementById('kuota-text').textContent = jadwal.kuota;

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
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-600 text-white text-xs font-bold">${reservasi.indexOf(r) + 1}</span>
                                    <div>
                                        <p class="font-semibold text-slate-900">${r.nama_pasien}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">${r.created_at}</p>
                                    </div>
                                </div>
                                ${r.keluhan ? `<p class="text-sm text-slate-600 mt-2">Keluhan: ${r.keluhan}</p>` : ''}
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold 
                                ${r.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'}">
                                ${r.status === 'pending' ? 'Pending' : 'Confirmed'}
                            </span>
                        </div>
                    `;
                    list.appendChild(card);
                });
            }
        }

        // Close modal on backdrop click
        document.getElementById('jadwal-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeJadwalModal();
        });
    </script>
</x-app-layout>
