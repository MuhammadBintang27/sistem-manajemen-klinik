<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-900">Laporan Klinik</h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Success Alert --}}
        @if (session('success'))
            <div class="rounded-xl bg-secondary-100 border border-secondary-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-primary-800">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Error Alert --}}
        @if ($errors->any() || session('error'))
            <div class="rounded-xl bg-red-50 border border-red-200 p-4 flex items-start gap-3">
                <svg class="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-semibold text-red-800">{{ session('error') ?? 'Ada kesalahan:' }}</p>
                    @if ($errors->any())
                        <ul class="list-disc list-inside text-red-700 mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif

        {{-- Report Header Card --}}
        <div class="rounded-2xl bg-white border border-primary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                    </svg>
                    Export Laporan
                </h3>
                <p class="mt-1 text-sm text-primary-100">Unduh laporan reservasi dan keuangan dalam berbagai format (CSV, PDF, Excel)</p>
            </div>

            {{-- Tabs --}}
            <div>
                <div class="flex border-b border-primary-100" role="tablist">
                    <button
                        id="tab-reservasi"
                        onclick="switchTab('reservasi')"
                        role="tab"
                        aria-selected="true"
                        class="flex-1 px-6 py-4 font-semibold text-center border-b-2 border-primary-500 text-primary-700 bg-primary-50 transition-colors hover:bg-primary-100"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zm-6-7h-4v4h4v-4z"/>
                        </svg>
                        Laporan Reservasi
                    </button>
                    <button
                        id="tab-keuangan"
                        onclick="switchTab('keuangan')"
                        role="tab"
                        aria-selected="false"
                        class="flex-1 px-6 py-4 font-semibold text-center border-b-2 border-transparent text-slate-500 bg-white transition-colors hover:bg-primary-50 hover:text-primary-600"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.5 1H5c-1.11 0-2 .9-2 2v18c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-9.5h-11V1zm6.5 13h-4v4h4v-4zm0-5h-4v4h4v-4z"/>
                        </svg>
                        Laporan Keuangan
                    </button>
                </div>

                <div class="p-8">
                    {{-- Reservasi Tab --}}
                    <div id="content-reservasi" role="tabpanel" class="tab-content">
                        <form action="{{ auth()->user()->role === 'dokter' ? route('dokter.reports.export.reservasi') : route('admin.reports.export.reservasi') }}" method="POST" class="space-y-6">
                            @csrf

                            {{-- Period Selection --}}
                            <div class="rounded-xl bg-primary-50 border border-primary-100 p-6">
                                <h4 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                    </svg>
                                    Pilih Periode
                                </h4>

                                {{-- Quick Select Buttons --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('reservasi', 'minggu_ini')">
                                        Minggu Ini
                                    </button>
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('reservasi', 'bulan_ini')">
                                        Bulan Ini
                                    </button>
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('reservasi', 'tahun_ini')">
                                        Tahun Ini
                                    </button>
                                </div>

                                {{-- Date Range Picker --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Awal</label>
                                        <input type="date" name="start_date" id="reservasi_start_date" required
                                            class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white"
                                            value="{{ now()->startOfMonth()->toDateString() }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Akhir</label>
                                        <input type="date" name="end_date" id="reservasi_end_date" required
                                            class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white"
                                            value="{{ now()->endOfMonth()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Format Selection --}}
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-6">
                                <h4 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                    </svg>
                                    Format Export
                                </h4>

                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="csv" checked class="w-5 h-5 text-primary-500 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">CSV (Excel)</p>
                                            <p class="text-sm text-slate-500">Format paling ringan, bisa dibuka di Excel</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="pdf" class="w-5 h-5 text-primary-500 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">PDF (Siap Cetak)</p>
                                            <p class="text-sm text-slate-500">Format profesional untuk cetak</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="xlsx" class="w-5 h-5 text-primary-500 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">Excel (XLSX)</p>
                                            <p class="text-sm text-slate-500">Format Excel dengan multiple sheets</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div>
                                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Laporan Reservasi
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Keuangan Tab --}}
                    <div id="content-keuangan" role="tabpanel" class="tab-content hidden">
                        <form action="{{ auth()->user()->role === 'dokter' ? route('dokter.reports.export.keuangan') : route('admin.reports.export.keuangan') }}" method="POST" class="space-y-6">
                            @csrf

                            {{-- Period Selection --}}
                            <div class="rounded-xl bg-primary-50 border border-primary-100 p-6">
                                <h4 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                    </svg>
                                    Pilih Periode
                                </h4>

                                {{-- Quick Select Buttons --}}
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-6">
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('keuangan', 'minggu_ini')">
                                        Minggu Ini
                                    </button>
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('keuangan', 'bulan_ini')">
                                        Bulan Ini
                                    </button>
                                    <button type="button" class="quick-select-btn px-4 py-3 border-2 border-primary-200 bg-white rounded-lg hover:border-primary-500 hover:bg-primary-50 transition font-medium text-slate-700" onclick="setQuickRange('keuangan', 'tahun_ini')">
                                        Tahun Ini
                                    </button>
                                </div>

                                {{-- Date Range Picker --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Awal</label>
                                        <input type="date" name="start_date" id="keuangan_start_date" required
                                            class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white"
                                            value="{{ now()->startOfMonth()->toDateString() }}">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Akhir</label>
                                        <input type="date" name="end_date" id="keuangan_end_date" required
                                            class="w-full px-4 py-2 border border-primary-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white"
                                            value="{{ now()->endOfMonth()->toDateString() }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Format Selection --}}
                            <div class="rounded-xl bg-slate-50 border border-slate-200 p-6">
                                <h4 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                                    </svg>
                                    Format Export
                                </h4>

                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="csv" checked class="w-5 h-5 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">CSV (Excel)</p>
                                            <p class="text-sm text-slate-500">Format paling ringan, bisa dibuka di Excel</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="pdf" class="w-5 h-5 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">PDF (Siap Cetak)</p>
                                            <p class="text-sm text-slate-500">Format profesional untuk cetak</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center cursor-pointer p-4 border-2 border-slate-200 rounded-lg hover:border-primary-400 hover:bg-primary-50 transition">
                                        <input type="radio" name="format" value="xlsx" class="w-5 h-5 accent-primary-500">
                                        <div class="ml-4 flex-1">
                                            <p class="font-semibold text-slate-900">Excel (XLSX)</p>
                                            <p class="text-sm text-slate-500">Format Excel dengan multiple sheets</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- Submit Button --}}
                            <div>
                                <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-6 rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download Laporan Keuangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const quickRanges = {!! json_encode($quickSelectRanges) !!};

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));

            document.querySelectorAll('[role="tab"]').forEach(el => {
                el.classList.remove('border-primary-500', 'text-primary-700', 'bg-primary-50');
                el.classList.add('border-transparent', 'text-slate-500', 'bg-white');
            });

            document.getElementById('content-' + tabName).classList.remove('hidden');

            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('border-transparent', 'text-slate-500', 'bg-white');
            activeButton.classList.add('border-primary-500', 'text-primary-700', 'bg-primary-50');
        }

        function setQuickRange(tab, rangeKey) {
            const range = quickRanges[rangeKey];
            if (range) {
                document.getElementById(tab + '_start_date').value = range.start;
                document.getElementById(tab + '_end_date').value = range.end;
            }
        }
    </script>
</x-app-layout>