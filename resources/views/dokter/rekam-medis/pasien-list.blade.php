<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-900">Daftar Pasien</h2>
                <p class="mt-1 text-sm text-slate-600">Lihat riwayat rekam medis per pasien</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        {{-- Search Bar --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">Cari Pasien</h3>
            </div>
            <div class="px-6 py-6">
                <form method="GET" action="{{ route('dokter.rekam-medis.list-pasien') }}" class="flex gap-3">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}" 
                            placeholder="Cari berdasarkan nama atau NIK..."
                            class="block w-full rounded-lg border border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-4 py-2">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    @if ($search)
                        <a href="{{ route('dokter.rekam-medis.list-pasien') }}" class="px-6 py-2 bg-slate-300 hover:bg-slate-400 text-slate-900 font-medium rounded-lg transition-colors">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Daftar Pasien --}}
        <div class="rounded-2xl bg-white border border-green-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-white border-b border-green-100 px-6 py-4">
                <h3 class="text-lg font-bold text-slate-900">
                    Pasien Saya
                    @if ($pasiens->total() > 0)
                        <span class="text-sm font-normal text-slate-600">({{ $pasiens->total() }} pasien)</span>
                    @endif
                </h3>
            </div>

            @if ($pasiens->count() > 0)
                <div class="divide-y divide-slate-200">
                    @foreach ($pasiens as $pasien)
                        <a href="{{ route('dokter.rekam-medis.pasien.show', $pasien) }}" class="block px-6 py-4 hover:bg-green-50 transition-colors border-b border-slate-100 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-1">
                                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold">
                                            {{ substr($pasien->nama, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-slate-900">{{ $pasien->nama }}</h4>
                                            <p class="text-xs text-slate-600">NIK: {{ $pasien->nik }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $pasien->rekam_medis_count }} rekam medis
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $pasiens->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                    <p class="text-slate-600 font-medium">Tidak ada pasien ditemukan</p>
                    <p class="text-sm text-slate-500 mt-1">Anda belum memiliki rekam medis untuk pasien apapun</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
