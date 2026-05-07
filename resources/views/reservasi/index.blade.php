@extends('layouts.pasien')

@section('title', 'Miss Dentist Meulaboh - Reservasi Online')

@push('styles')
<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .font-display {
        font-family: 'Playfair Display', serif;
    }

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

@section('navbar')
    <nav class="fixed top-0 left-0 right-0 z-[100] bg-primary/95 backdrop-blur-md border-b border-white/10">
        <div class="max-w-[1200px] mx-auto px-6 h-[68px] flex items-center justify-between">
            <a href="#" class="flex items-center gap-3 text-white no-underline">
                <div class="w-[38px] h-[38px] bg-white/20 rounded-xl border border-white/25 flex items-center justify-center">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="font-display text-[18px] font-semibold tracking-[0.3px] leading-none">Miss Dentist</div>
                    <div class="text-[10px] font-normal text-white/65 tracking-[1.5px] uppercase">Meulaboh</div>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-9">
                <a href="#layanan" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Layanan</a>
                <a href="#tentang" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Tentang</a>
                <a href="#galeri" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Galeri</a>
                <a href="#kontak" class="text-white/80 hover:text-white text-sm font-medium transition-colors">Kontak</a>
                <a href="{{ route('reservasi.create') }}" 
                   class="bg-white text-primary-900 px-6 py-2.5 rounded-full font-semibold text-sm tracking-wider shadow-md hover:shadow-lg hover:-translate-y-px transition-all">
                    Buat Reservasi
                </a>
            </nav>

            <button onclick="document.getElementById('mobileMenu').classList.toggle('open')" 
                    class="md:hidden text-white p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden flex-col px-6 py-4 border-t border-white/10 bg-primary/95 backdrop-blur-md">
            <a href="#layanan" class="block py-3 text-white/80 hover:text-white">Layanan</a>
            <a href="#tentang" class="block py-3 text-white/80 hover:text-white">Tentang</a>
            <a href="#galeri" class="block py-3 text-white/80 hover:text-white">Galeri</a>
            <a href="#kontak" class="block py-3 text-white/80 hover:text-white">Kontak</a>
            <a href="{{ route('reservasi.create') }}" class="block py-3 text-white font-semibold">Buat Reservasi</a>
        </div>
    </nav>
@endsection

@section('content')

    <!-- HERO -->
    <section class="hero-bg min-h-screen relative overflow-hidden flex items-center">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_75%_35%,rgba(255,255,255,0.12)_0%,transparent_65%),radial-gradient(ellipse_40%_60%_at_10%_70%,rgba(151,38,100,0.4)_0%,transparent_55%)]"></div>

    <div class="max-w-[1200px] mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center py-20 lg:py-16">
        
        <!-- TEXT -->
        <div class="reveal text-center lg:text-left">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 text-white text-[10px] sm:text-xs font-medium tracking-widest px-4 py-2 rounded-full mb-5">
                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                Klinik Terpercaya Sejak 2010
            </div>

            <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-semibold text-white leading-tight">
                Senyum Sehat,<br>
                <em class="text-white/75 font-normal">Hidup Bahagia</em>
            </h1>

            <p class="mt-5 text-white/80 text-sm sm:text-base md:text-lg max-w-md mx-auto lg:mx-0">
                Perawatan gigi profesional oleh dokter berpengalaman dengan teknologi modern.
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                <a href="{{ route('reservasi.create') }}" 
                   class="bg-white text-primary-900 px-6 py-3 sm:px-8 sm:py-4 rounded-full font-semibold hover:-translate-y-1 transition-all shadow-xl text-sm sm:text-base">
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
    <section id="layanan" class="py-24 bg-secondary-50">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="text-center mb-16 reveal">
                <span class="inline-block bg-secondary-100 text-primary px-5 py-2 rounded-full text-xs font-semibold tracking-widest border border-secondary-200">LAYANAN KAMI</span>
                <h2 class="font-display text-4xl lg:text-5xl font-semibold text-gray-900 mt-4">Perawatan Lengkap<br>untuk Senyum Sempurna</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (['Pembersihan Gigi','Penambalan Gigi','Whitening Gigi','Kawat Gigi','Pencabutan Gigi','Implan Gigi'] as $service)
                <div class="service-card group bg-white border border-primary/10 rounded-3xl p-8 hover:-translate-y-2 hover:shadow-xl transition-all duration-300 relative overflow-hidden reveal">
                    <h3 class="font-display text-2xl font-semibold text-primary mb-3">{{ $service }}</h3>
                    <p class="text-gray-600 text-[15px] leading-relaxed">
                        Layanan profesional dengan standar medis tinggi dan teknologi terkini.
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- TENTANG -->
    <section id="tentang" class="py-24 bg-white">
        <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative reveal">
                <div class="absolute -inset-5 bg-secondary-100 rounded-3xl -z-10"></div>
                <div class="rounded-3xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('image/klinik.jpg') }}" alt="Klinik" class="w-full h-[420px] object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white border border-secondary-200 rounded-2xl p-5 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 bg-secondary-100 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 8.944 11.922.42.095.858.143 1.295.143a3 3 0 01.435-.008" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Terakreditasi</div>
                        <div class="text-sm text-gray-500">Kemenkes RI</div>
                    </div>
                </div>
            </div>

            <div class="reveal">
                <span class="inline-block bg-secondary-100 text-primary px-5 py-2 rounded-full text-xs font-semibold tracking-widest border border-secondary-200">TENTANG KAMI</span>
                <h2 class="font-display text-4xl lg:text-5xl font-semibold text-gray-900 mt-4 leading-tight">Klinik Gigi Terpercaya di Meulaboh</h2>
                <p class="mt-6 text-gray-600 leading-relaxed">Miss Dentist Meulaboh hadir sejak 2010 dengan komitmen penuh untuk memberikan layanan kesehatan gigi yang profesional, nyaman, dan terjangkau bagi seluruh masyarakat Aceh Barat.</p>

                <!-- Check items -->
                <div class="mt-10 space-y-5">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary/20 text-primary mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Dokter Berpengalaman</h3>
                            <p class="text-gray-600 text-sm mt-1">Tim dokter gigi spesialis dengan pengalaman lebih dari 10 tahun</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary/20 text-primary mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Peralatan Modern</h3>
                            <p class="text-gray-600 text-sm mt-1">Teknologi dental terkini untuk diagnosa dan perawatan yang akurat</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-primary/20 text-primary mt-1">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sterilisasi Standar RS</h3>
                            <p class="text-gray-600 text-sm mt-1">Protokol kebersihan dan sterilisasi mengikuti standar rumah sakit</p>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mt-12">
                    <div class="bg-secondary-50 rounded-2xl p-6 text-center border border-secondary-200">
                        <div class="text-4xl font-display font-bold text-primary">13+</div>
                        <div class="text-sm text-gray-600 mt-2">Tahun Berpengalaman</div>
                    </div>
                    <div class="bg-secondary-50 rounded-2xl p-6 text-center border border-secondary-200">
                        <div class="text-4xl font-display font-bold text-primary">5K+</div>
                        <div class="text-sm text-gray-600 mt-2">Pasien Terlayani</div>
                    </div>
                    <div class="bg-secondary-50 rounded-2xl p-6 text-center border border-secondary-200">
                        <div class="text-4xl font-display font-bold text-primary">8</div>
                        <div class="text-sm text-gray-600 mt-2">Dokter Spesialis</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-24 bg-gradient-to-br from-primary-800 via-primary-600 to-pink-600 relative overflow-hidden">
        <div class="max-w-2xl mx-auto text-center px-6 relative z-10">
            <span class="bg-white/20 text-white text-xs tracking-widest font-semibold px-6 py-2 rounded-full border border-white/30">Reservasi Online 24/7</span>
            <h2 class="font-display text-4xl lg:text-5xl text-white font-semibold mt-6">Jadwalkan Kunjungan Anda Sekarang</h2>
            <p class="text-white/80 mt-4 text-lg">Proses cepat, mudah, dan aman.</p>
            <a href="{{ route('reservasi.create') }}" 
               class="mt-10 inline-block bg-white text-primary-900 px-10 py-5 rounded-full font-semibold text-lg hover:-translate-y-1 transition-all shadow-2xl">
                Buat Reservasi Gratis
            </a>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="py-24 bg-secondary-50">
        <div class="max-w-[1200px] mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="font-display text-5xl lg:text-6xl text-gray-900 font-semibold">Hubungi Kami</h2>
                <p class="text-gray-600 mt-4 text-lg">Kami siap melayani Anda Senin-Sabtu, 08.00-20.00 WIB</p>
            </div>

            <!-- Contact Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Telepon -->
                <div class="group bg-white border border-secondary-200 hover:border-primary/50 rounded-3xl p-8 transition-all duration-300 reveal shadow-sm hover:shadow-md">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-primary text-xs font-semibold tracking-widest mb-3">TELEPON</p>
                        <p class="font-display text-gray-900 text-3xl font-semibold mb-2">+62 123 456 789</p>
                        <p class="text-gray-600 text-sm">Senin-Sabtu, 08-20 WIB</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="group bg-white border border-secondary-200 hover:border-primary/50 rounded-3xl p-8 transition-all duration-300 reveal shadow-sm hover:shadow-md">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-primary text-xs font-semibold tracking-widest mb-3">EMAIL</p>
                        <p class="font-display text-gray-900 text-3xl font-semibold mb-2">info@missdentist.com</p>
                        <p class="text-gray-600 text-sm">Respon dalam 24 jam</p>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="group bg-white border border-secondary-200 hover:border-primary/50 rounded-3xl p-8 transition-all duration-300 reveal shadow-sm hover:shadow-md">
                    <div class="flex justify-center mb-6">
                        <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-primary text-xs font-semibold tracking-widest mb-3">ALAMAT</p>
                        <p class="font-display text-gray-900 text-3xl font-semibold mb-2">Jl. Kesehatan No. 123</p>
                        <p class="text-gray-600 text-sm">Meulaboh, Aceh Barat</p>
                    </div>
                </div>
            </div>

            
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Scroll Reveal
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    // Smooth scroll + mobile menu
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') return;
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
            document.getElementById('mobileMenu').classList.remove('open');
        });
    });
</script>
@endpush