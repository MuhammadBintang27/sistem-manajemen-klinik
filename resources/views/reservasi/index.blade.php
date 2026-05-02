<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Gigi Sejahtera - Reservasi Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }

        :root {
            --green-primary: #16a34a;
            --green-dark: #14532d;
            --green-light: #dcfce7;
            --green-mid: #166534;
        }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Navbar glass */
        .navbar-glass {
            background: rgba(20, 83, 45, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Hero mesh gradient */
        .hero-bg {
            background: linear-gradient(135deg, #14532d 0%, #166534 30%, #15803d 60%, #16a34a 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% 40%, rgba(134,239,172,0.18) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 40% at 20% 80%, rgba(20,83,45,0.5) 0%, transparent 60%);
        }
        .hero-bg::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; right: 0;
            height: 80px;
            background: white;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        /* Floating badge */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .float-anim { animation: float 4s ease-in-out infinite; }

        /* Service card hover */
        .service-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(22,101,52,0.15);
        }

        /* Stats section */
        .stat-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
        }

        /* CTA section */
        .cta-section {
            background: linear-gradient(135deg, #14532d, #16a34a);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(134,239,172,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* Pulse dot */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        /* Zigzag divider */
        .section-divider {
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #16a34a, #4ade80);
            border-radius: 2px;
        }

        /* Number counter styling */
        .counter-num {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(135deg, #16a34a, #4ade80);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Testimonial card */
        .testimonial-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
        }

        /* Mobile menu */
        #mobileMenu {
            transition: max-height 0.3s ease, opacity 0.3s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #mobileMenu.open {
            max-height: 300px;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white antialiased">

    <!-- Navbar -->
    <nav class="navbar-glass fixed top-0 left-0 right-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto px-5 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-18">
                <!-- Logo -->
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.5 2 6 4.1 6 7c0 2.5 1.5 4.5 3 5.5V19c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-6.5c1.5-1 3-3 3-5.5 0-2.9-2.5-5-6-5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-white font-bold text-base sm:text-lg leading-tight">Klinik Gigi</div>
                        <div class="text-green-300 text-xs font-medium leading-none hidden sm:block">Sejahtera</div>
                    </div>
                </div>

                <!-- Desktop nav links -->
                <div class="hidden md:flex items-center gap-7">
                    <a href="#layanan" class="text-green-200 hover:text-white text-sm font-medium transition">Layanan</a>
                    <a href="#tentang" class="text-green-200 hover:text-white text-sm font-medium transition">Tentang</a>
                    <a href="#kontak" class="text-green-200 hover:text-white text-sm font-medium transition">Kontak</a>
                </div>

                <!-- CTA + mobile menu button -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('reservasi.create') }}" class="bg-white text-green-700 px-4 sm:px-5 py-2 rounded-full text-sm font-bold hover:bg-green-50 transition shadow-sm">
                        <span class="hidden sm:inline">Buat </span>Reservasi
                    </a>
                    <!-- Mobile hamburger -->
                    <button id="menuBtn" class="md:hidden text-white p-1" onclick="document.getElementById('mobileMenu').classList.toggle('open')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu dropdown -->
            <div id="mobileMenu" class="md:hidden border-t border-white/10">
                <div class="py-3 space-y-1">
                    <a href="#layanan" class="block px-3 py-2 text-green-200 hover:text-white text-sm font-medium rounded-lg hover:bg-white/10 transition">Layanan</a>
                    <a href="#tentang" class="block px-3 py-2 text-green-200 hover:text-white text-sm font-medium rounded-lg hover:bg-white/10 transition">Tentang</a>
                    <a href="#kontak" class="block px-3 py-2 text-green-200 hover:text-white text-sm font-medium rounded-lg hover:bg-white/10 transition">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-bg pt-28 pb-28 sm:pt-32 sm:pb-36 px-5 sm:px-6">
        <div class="max-w-6xl mx-auto relative z-10">
            <div class="grid lg:grid-cols-2 gap-10 items-center">
                <!-- Left: Text -->
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/25 text-white text-xs sm:text-sm font-semibold px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-300 rounded-full" style="animation: pulse-dot 2s infinite;"></span>
                        Klinik Terpercaya Sejak 2010
                    </div>
                    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white leading-tight mb-5">
                        Senyum Sehat,<br>
                        <span class="text-green-300">Hidup Bahagia</span>
                    </h1>
                    <p class="text-green-100 text-base sm:text-lg leading-relaxed mb-8 max-w-lg">
                        Dapatkan perawatan gigi terbaik dari dokter profesional berpengalaman. Teknologi modern, suasana nyaman, hasil yang memuaskan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('reservasi.create') }}" class="bg-white text-green-700 px-7 py-3.5 rounded-full font-bold text-center hover:bg-green-50 transition shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
                            Buat Reservasi Sekarang →
                        </a>
                        <a href="#layanan" class="border-2 border-white/40 text-white px-7 py-3.5 rounded-full font-semibold text-center hover:bg-white/10 transition">
                            Lihat Layanan
                        </a>
                    </div>
                </div>

                <!-- Right: Stats cards -->
                <div class="hidden lg:grid grid-cols-2 gap-4 float-anim">
                    <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl p-5 text-white">
                        <div class="text-3xl font-display font-bold text-green-300 mb-1">5000+</div>
                        <div class="text-sm text-green-100 font-medium">Pasien Terlayani</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl p-5 text-white mt-6">
                        <div class="text-3xl font-display font-bold text-green-300 mb-1">10+</div>
                        <div class="text-sm text-green-100 font-medium">Dokter Spesialis</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl p-5 text-white -mt-6">
                        <div class="text-3xl font-display font-bold text-green-300 mb-1">15+</div>
                        <div class="text-sm text-green-100 font-medium">Tahun Pengalaman</div>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm border border-white/25 rounded-2xl p-5 text-white">
                        <div class="text-3xl font-display font-bold text-green-300 mb-1">98%</div>
                        <div class="text-sm text-green-100 font-medium">Kepuasan Pasien</div>
                    </div>
                </div>

                <!-- Mobile: stats row -->
                <div class="grid grid-cols-2 gap-3 lg:hidden">
                    <div class="bg-white/15 border border-white/25 rounded-xl p-4 text-white text-center">
                        <div class="text-2xl font-display font-bold text-green-300">5000+</div>
                        <div class="text-xs text-green-100 mt-0.5">Pasien Terlayani</div>
                    </div>
                    <div class="bg-white/15 border border-white/25 rounded-xl p-4 text-white text-center">
                        <div class="text-2xl font-display font-bold text-green-300">98%</div>
                        <div class="text-xs text-green-100 mt-0.5">Kepuasan Pasien</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="py-16 sm:py-24 px-5 sm:px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12 reveal">
                <div class="section-divider mx-auto mb-4"></div>
                <h2 class="font-display text-3xl sm:text-4xl text-slate-900 mb-3">Layanan Unggulan Kami</h2>
                <p class="text-slate-500 text-base max-w-xl mx-auto">Berbagai perawatan gigi profesional dengan standar medis tertinggi</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8 2 5 5 5 9c0 3 2 5.5 4 7v4c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-4c2-1.5 4-4 4-7 0-4-3-7-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pembersihan Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Pembersihan karang gigi dan plak secara profesional menggunakan ultrasonic scaler terkini.</p>
                    <div class="text-green-600 text-sm font-semibold">Mulai dari Rp 150.000</div>
                </div>

                <!-- Service 2 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Penambalan Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Penambalan gigi berlubang dengan bahan komposit sewarna gigi, tahan lama dan estetis.</p>
                    <div class="text-blue-600 text-sm font-semibold">Mulai dari Rp 200.000</div>
                </div>

                <!-- Service 3 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Whitening Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Pemutihan gigi profesional dengan teknologi laser untuk hasil lebih cerah dan tahan lama.</p>
                    <div class="text-purple-600 text-sm font-semibold">Mulai dari Rp 500.000</div>
                </div>

                <!-- Service 4 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 6h-2.18c.07-.44.18-.88.18-1.32C18 2.54 15.86.5 13.17.5c-1.6 0-3.08.8-4.04 2.05L8 4l-1.13-1.45C5.92 1.3 4.44.5 2.83.5.14.5-2 2.54-2 4.68c0 .44.11.88.18 1.32H-2c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h22c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Kawat Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Pemasangan kawat gigi konvensional dan transparan untuk merapikan susunan gigi.</p>
                    <div class="text-orange-600 text-sm font-semibold">Konsultasi Gratis</div>
                </div>

                <!-- Service 5 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pencabutan Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Tindakan pencabutan gigi yang aman, minim rasa sakit dengan anestesi lokal modern.</p>
                    <div class="text-red-500 text-sm font-semibold">Mulai dari Rp 100.000</div>
                </div>

                <!-- Service 6 -->
                <div class="service-card bg-white border border-slate-100 rounded-2xl p-7 shadow-sm reveal">
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-teal-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Implan Gigi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed mb-4">Solusi permanen mengganti gigi yang hilang dengan implan titanium berkualitas tinggi.</p>
                    <div class="text-teal-600 text-sm font-semibold">Konsultasi Gratis</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-16 sm:py-24 px-5 sm:px-6 bg-slate-50">
        <div class="max-w-6xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Image side -->
                <div class="reveal relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?w=600&q=80" alt="Klinik Gigi Sejahtera" class="w-full h-72 sm:h-96 object-cover">
                    </div>
                    <!-- Floating badge -->
                    <div class="absolute -bottom-5 -right-3 sm:-right-6 bg-white rounded-2xl shadow-xl p-4 sm:p-5 border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">Terakreditasi</div>
                                <div class="text-xs text-slate-500">Kemenkes RI</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Text side -->
                <div class="reveal">
                    <div class="section-divider mb-4"></div>
                    <h2 class="font-display text-3xl sm:text-4xl text-slate-900 mb-5">Mengapa Memilih<br>Klinik Gigi Sejahtera?</h2>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Sejak 2010, kami telah menjadi pilihan utama masyarakat untuk perawatan gigi yang komprehensif. Dengan tim dokter gigi berpengalaman dan fasilitas modern, kami berkomitmen memberikan pengalaman terbaik untuk setiap pasien.
                    </p>

                    <div class="space-y-4 mb-8">
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 mb-0.5">Dokter Berpengalaman & Tersertifikasi</div>
                                <div class="text-slate-500 text-sm">Tim dokter kami memiliki spesialisasi dan pengalaman luas di bidangnya.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 mb-0.5">Peralatan Medis Modern</div>
                                <div class="text-slate-500 text-sm">Teknologi digital X-ray, laser, dan peralatan canggih lainnya.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800 mb-0.5">Lingkungan Steril & Nyaman</div>
                                <div class="text-slate-500 text-sm">Standar kebersihan tinggi dan ruangan yang dirancang untuk kenyamanan Anda.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats row -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="stat-card rounded-xl p-4 text-center">
                            <div class="counter-num text-2xl font-bold">5K+</div>
                            <div class="text-xs text-slate-600 mt-1">Pasien</div>
                        </div>
                        <div class="stat-card rounded-xl p-4 text-center">
                            <div class="counter-num text-2xl font-bold">10+</div>
                            <div class="text-xs text-slate-600 mt-1">Dokter</div>
                        </div>
                        <div class="stat-card rounded-xl p-4 text-center">
                            <div class="counter-num text-2xl font-bold">15+</div>
                            <div class="text-xs text-slate-600 mt-1">Tahun</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-16 sm:py-20 px-5 sm:px-6">
        <div class="max-w-4xl mx-auto text-center relative z-10 reveal">
            <div class="inline-flex items-center gap-2 bg-white/15 border border-white/25 text-white text-xs font-semibold px-4 py-2 rounded-full mb-6">
                📅 Reservasi Online 24/7
            </div>
            <h2 class="font-display text-3xl sm:text-4xl lg:text-5xl text-white mb-5">Jadwalkan Kunjungan Anda<br>Sekarang</h2>
            <p class="text-green-100 text-base sm:text-lg mb-8 max-w-xl mx-auto">Proses reservasi mudah dan cepat. Pilih jadwal yang sesuai dan dokter yang Anda inginkan.</p>
            <a href="{{ route('reservasi.create') }}" class="inline-block bg-white text-green-700 px-8 py-4 rounded-full font-bold text-lg hover:bg-green-50 transition shadow-xl hover:-translate-y-1 transform">
                Buat Reservasi Gratis →
            </a>
            <p class="text-green-200 text-sm mt-4">Tidak dipungut biaya pendaftaran. Konfirmasi via telepon dalam 24 jam.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="kontak" class="py-16 sm:py-20 px-5 sm:px-6 bg-slate-900">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10 reveal">
                <h2 class="font-display text-3xl sm:text-4xl text-white mb-3">Hubungi Kami</h2>
                <p class="text-slate-400 text-base">Kami siap melayani Anda Senin–Sabtu, 08.00–20.00 WIB</p>
            </div>
            <div class="grid sm:grid-cols-3 gap-5 reveal">
                <div class="bg-slate-800 rounded-2xl p-6 text-center border border-slate-700 hover:border-green-600/50 transition group">
                    <div class="w-12 h-12 bg-green-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-700/50 transition">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 text-xs mb-1 uppercase tracking-wide">Telepon</p>
                    <p class="text-white font-bold text-lg">+62 123 456 789</p>
                    <p class="text-slate-500 text-xs mt-1">Senin–Sabtu, 08–20 WIB</p>
                </div>
                <div class="bg-slate-800 rounded-2xl p-6 text-center border border-slate-700 hover:border-green-600/50 transition group">
                    <div class="w-12 h-12 bg-green-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-700/50 transition">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 text-xs mb-1 uppercase tracking-wide">Email</p>
                    <p class="text-white font-bold text-base break-all">info@klinikklinik.com</p>
                    <p class="text-slate-500 text-xs mt-1">Respon dalam 24 jam</p>
                </div>
                <div class="bg-slate-800 rounded-2xl p-6 text-center border border-slate-700 hover:border-green-600/50 transition group">
                    <div class="w-12 h-12 bg-green-900/50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-green-700/50 transition">
                        <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <p class="text-slate-400 text-xs mb-1 uppercase tracking-wide">Alamat</p>
                    <p class="text-white font-bold text-base">Jl. Kesehatan No. 123</p>
                    <p class="text-slate-500 text-xs mt-1">Jakarta Pusat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-500 py-6 px-5 sm:px-6 text-center">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-slate-400">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.5 2 6 4.1 6 7c0 2.5 1.5 4.5 3 5.5V19c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-6.5c1.5-1 3-3 3-5.5 0-2.9-2.5-5-6-5z"/>
                </svg>
                <span class="font-semibold text-sm">Klinik Gigi Sejahtera</span>
            </div>
            <p class="text-xs">&copy; 2026 Klinik Gigi Sejahtera. Semua hak dilindungi.</p>
            <div class="flex gap-4 text-xs">
                <a href="#" class="hover:text-slate-300 transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-slate-300 transition">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

    <script>
        // Scroll reveal
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        reveals.forEach(el => observer.observe(el));

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const id = a.getAttribute('href');
                if (id === '#') return;
                const el = document.querySelector(id);
                if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
                // Close mobile menu
                document.getElementById('mobileMenu').classList.remove('open');
            });
        });
    </script>
</body>
</html>