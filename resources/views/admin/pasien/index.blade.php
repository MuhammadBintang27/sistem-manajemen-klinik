<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-bold text-2xl text-slate-900 text-left">
                Manajemen Pasien
            </h2>

            <a href="{{ route('admin.pasien.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Tambah Pasien
            </a>    
        </div>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-secondary-100 border border-secondary-200 p-4 flex items-center gap-3 animate-fade-in">
                <svg class="h-5 w-5 text-primary-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-semibold text-primary-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="rounded-2xl bg-white border border-primary-100 shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    Daftar Pasien
                </h3>
            </div>

            

            <div class="overflow-x-auto">
                <table class="w-full divide-y divide-secondary-100">
                    <thead class="bg-gradient-to-r from-secondary-50 to-white">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">NIK</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Nama Pasien</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Nomor HP</th>
                            <th class="px-8 py-4 text-left text-xs font-semibold uppercase text-slate-700 tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-secondary-100">
                        @foreach ($pasiens as $pasien)
                            <tr class="hover:bg-secondary-50 transition-colors">
                                <td class="px-8 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ $pasien->nik }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-700">{{ $pasien->nama }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-slate-700">{{ $pasien->no_hp }}</td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('admin.pasien.show', $pasien) }}" class="inline-flex items-center gap-1 px-4 py-2 bg-secondary-100 hover:bg-secondary-200 text-primary-700 font-medium rounded-xl transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Detail
                                        </a>
                                        <form action="{{ route('admin.pasien.destroy', $pasien) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien ini? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-xl transition-colors">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($pasiens->count() === 0)
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-secondary-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-sm text-slate-600">Belum ada data pasien. Mulai dengan <a href="{{ route('admin.pasien.create') }}" class="text-primary-600 font-semibold hover:text-primary-700">menambah pasien baru</a>.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $pasiens->links() }}
        </div>
    </div>
</x-app-layout>

