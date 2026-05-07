@extends('layouts.pasien')

@section('title', 'Miss Dentist Sultan Care - Reservasi Online')

{{-- Desktop nav links --}}
@section('navbar-links')
    <a href="#layanan" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Layanan</a>
    <a href="#tentang" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Tentang</a>
    <a href="#kontak"  class="text-white/80 hover:text-white text-sm font-medium transition-colors">Kontak</a>
@endsection

{{-- Desktop right CTA --}}
@section('navbar-right')
    <a href="{{ route('reservasi.create') }}"
       class="bg-white text-primary-600 px-5 py-2.5 rounded-full font-semibold text-sm tracking-wide shadow-md hover:shadow-lg hover:-translate-y-px transition-all">
        Buat Reservasi
    </a>
@endsection

{{-- Mobile dropdown links --}}
@section('navbar-mobile-links')
    <a href="#layanan" class="block py-3 text-white/80 hover:text-white text-sm font-medium border-b border-white/10">Layanan</a>
    <a href="#tentang" class="block py-3 text-white/80 hover:text-white text-sm font-medium border-b border-white/10">Tentang</a>
    <a href="#kontak"  class="block py-3 text-white/80 hover:text-white text-sm font-medium">Kontak</a>
@endsection

@section('navbar-mobile-right')
    <a href="{{ route('reservasi.create') }}"
       class="block w-full text-center bg-white text-primary-600 px-5 py-3 rounded-xl font-semibold text-sm">
        Buat Reservasi
    </a>
@endsection

@push('styles')
<style>
    .reveal {
        opacity: 0;
        transform: translateY(32px);
        transition: opacity 0.8s cubic-bezier(0.22,1,0.36,1), transform 0.8s cubic-bezier(0.22,1,0.36,1);
    }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    .hero-bg {
        background: linear-gradient(150deg, #A8316D 0%, #D94A8C 35%, #E899B8 65%, #B93876 100%);
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #D94A8C, #E899B8);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
    }
    .service-card:hover::before { transform: scaleX(1); }
</style>
@endpush

@section('content')

    @php
        $tahunMulai = 2020;
        $lamaMelayani = now()->year - $tahunMulai;
    @endphp

    <!-- HERO — no top padding needed, layout spacer handles nav offset -->
    <section class="hero-bg min-h-[calc(100vh-68px)] relative overflow-hidden flex items-center">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_75%_35%,rgba(255,255,255,0.12)_0%,transparent_65%),radial-gradient(ellipse_40%_60%_at_10%_70%,rgba(151,38,100,0.4)_0%,transparent_55%)]"></div>

        <div class="max-w-[1200px] mx-auto px-5 sm:px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center py-16 lg:py-12">

            <!-- TEXT -->
            <div class="reveal text-center lg:text-left">
                <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-semibold text-white leading-tight">
                    Senyum Sehat,<br>
                    <em class="text-white/75 font-normal">Mulai Dari Sini</em>
                </h1>

                <p class="mt-5 text-white/80 text-sm sm:text-base md:text-lg max-w-md mx-auto lg:mx-0">
                    Pelayanan dokter gigi yang ramah dengan perawatan terbaik untuk kesehatan senyum Anda.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                    <a href="{{ route('reservasi.create') }}"
                       class="bg-white text-primary-600 px-6 py-3 sm:px-8 sm:py-4 rounded-full font-semibold hover:-translate-y-1 transition-all shadow-xl text-sm sm:text-base">
                        Buat Reservasi
                    </a>
                    <a href="#layanan"
                       class="border border-white/50 text-white px-6 py-3 sm:px-8 sm:py-4 rounded-full font-medium hover:bg-white/10 transition-all text-sm sm:text-base">
                        Lihat Layanan
                    </a>
                </div>
            </div>

            <!-- IMAGE -->
            <div class="reveal flex justify-center lg:justify-end">
                <img src="{{ asset('image/hero.webp') }}"
                     alt="Hero"
                     class="w-[85%] sm:w-[70%] md:w-[60%] lg:w-full max-w-[520px] h-auto object-contain">
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 h-16 sm:h-20 bg-white"
             style="clip-path: ellipse(55% 100% at 50% 100%);"></div>
    </section>

    <!-- LAYANAN -->
    <section id="layanan" class="py-20 sm:py-24 bg-secondary-50">
        <div class="max-w-[1200px] mx-auto px-5 sm:px-6">
            <div class="text-center mb-12 sm:mb-16 reveal">
                <span class="inline-block bg-secondary-100 text-primary-500 px-5 py-2 rounded-full text-xs font-semibold tracking-widest border border-secondary-200">LAYANAN KAMI</span>
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 mt-4">Perawatan Lengkap<br>untuk Senyum Sempurna</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach (['Pembersihan Gigi','Penambalan Gigi','Whitening Gigi','Kawat Gigi','Pencabutan Gigi','Implan Gigi'] as $service)
                <div class="service-card group bg-white border border-primary-100 rounded-3xl p-7 sm:p-8 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 relative overflow-hidden reveal">
                    <h3 class="font-display text-xl sm:text-2xl font-semibold text-primary-500 mb-3">{{ $service }}</h3>
                    <p class="text-gray-600 text-[15px] leading-relaxed">
                        Layanan profesional dengan standar medis tinggi dan teknologi terkini.
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="py-20 sm:py-24 bg-white">
        <div class="max-w-[1200px] mx-auto px-5 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <!-- Gambar klinik (kiri) -->
                <div class="relative reveal">
                    <div class="absolute -inset-4 sm:-inset-5 bg-secondary-100 rounded-3xl -z-10"></div>
                    <div class="rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{ asset('image/klinik.jpg') }}" alt="Klinik Miss Dentist Sultan Care"
                             class="w-full h-[300px] sm:h-[380px] lg:h-[420px] object-cover">
                    </div>
                </div>

                <!-- Teks + stats (kanan) -->
                <div class="reveal">
                    <span class="inline-block bg-secondary-100 text-primary-500 px-5 py-2 rounded-full text-xs font-semibold tracking-widest border border-secondary-200">TENTANG KAMI</span>
                    <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-900 mt-4 leading-tight">Klinik Gigi Terpercaya di Meulaboh</h2>
                    <p class="mt-5 text-gray-600 leading-relaxed">
                        Miss Dentist Sultan Care hadir sejak {{ $tahunMulai }} dengan komitmen penuh untuk memberikan layanan kesehatan gigi yang profesional, nyaman, dan terjangkau bagi seluruh masyarakat Aceh Barat.
                    </p>

                    <div class="mt-8 space-y-5">
                        @foreach ([
                            ['Pelayanan Profesional', 'Perawatan gigi dengan penanganan yang nyaman dan terpercaya'],
                            ['Teknologi Modern',      'Menggunakan peralatan modern untuk hasil perawatan yang optimal'],
                            ['Sterilisasi Terjamin',  'Kebersihan alat dan ruangan selalu menjadi prioritas utama'],
                        ] as [$title, $desc])
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center mt-1">
                                <svg class="h-4 w-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-3 sm:gap-4 mt-10">
                        @foreach ([
                            [$lamaMelayani . '+', 'Tahun Melayani'],
                            ['100%', 'Alat Steril'],
                            ['Ramah', 'Pelayanan Nyaman']
                        ] as [$num, $label])

                        <div class="bg-secondary-50 rounded-2xl p-4 sm:p-6 text-center border border-secondary-200">
                            <div class="text-2xl sm:text-4xl font-display font-bold text-primary-500">
                                {{ $num }}
                            </div>

                            <div class="text-xs sm:text-sm text-gray-600 mt-2">
                                {{ $label }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-20 sm:py-24 bg-gradient-to-br from-primary-800 via-primary-500 to-primary-400 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_60%_at_50%_50%,rgba(255,255,255,0.07)_0%,transparent_70%)]"></div>
        <div class="max-w-2xl mx-auto text-center px-5 sm:px-6 relative z-10">
            <span class="bg-white/20 text-white text-xs tracking-widest font-semibold px-6 py-2 rounded-full border border-white/30">Reservasi Online 24/7</span>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl text-white font-semibold mt-6">Jadwalkan Kunjungan Anda Sekarang</h2>
            <p class="text-white/80 mt-4 text-base sm:text-lg">Proses cepat, mudah, dan aman.</p>
            <a href="{{ route('reservasi.create') }}"
               class="mt-8 inline-block bg-white text-primary-600 px-8 py-4 sm:px-10 sm:py-5 rounded-full font-semibold text-base sm:text-lg hover:-translate-y-1 transition-all shadow-2xl">
                Buat Reservasi Gratis
            </a>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="py-20 sm:py-24 bg-secondary-50">
        <div class="max-w-[1200px] mx-auto px-5 sm:px-6">
            <div class="text-center mb-12 sm:mb-16 reveal">
                <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl text-gray-900 font-semibold">Hubungi Kami</h2>
                <p class="text-gray-600 mt-4 text-base sm:text-lg">Kami siap melayani Anda Senin–Sabtu, 08.00–20.00 WIB</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-16">
                @foreach ([
                    ['TELEPON','+6282214813130','Senin-Sabtu, 08–20 WIB','M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
                    ['EMAIL','info@missdentist.com','Respon dalam 24 jam','M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['ALAMAT','Jl. Kesehatan No. 123','Meulaboh, Aceh Barat','M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                ] as [$label, $main, $sub, $path])
                <div class="group bg-white border border-secondary-200 hover:border-primary-400 rounded-3xl p-7 sm:p-8 transition-all duration-300 reveal shadow-sm hover:shadow-md">
                    <div class="flex justify-center mb-5 sm:mb-6">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 bg-primary-50 rounded-2xl flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-primary-500 text-xs font-semibold tracking-widest mb-3">{{ $label }}</p>
                        <p class="font-display text-gray-900 text-xl sm:text-2xl lg:text-3xl font-semibold mb-2 break-words">{{ $main }}</p>
                        <p class="text-gray-600 text-sm">{{ $sub }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            if (this.getAttribute('href') === '#') return;
            const target = document.querySelector(this.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
        });
    });
</script>
@endpush