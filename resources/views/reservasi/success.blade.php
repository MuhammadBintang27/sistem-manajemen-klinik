<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Klinik Gigi Sejahtera</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #eff6ff 100%);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-glass {
            background: rgba(20, 83, 45, 0.96);
            backdrop-filter: blur(12px);
        }

        /* Success icon animation */
        @keyframes popIn {
            0% { transform: scale(0) rotate(-10deg); opacity: 0; }
            60% { transform: scale(1.1) rotate(3deg); }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        .success-icon { animation: popIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both; }

        /* Checkmark path animation */
        @keyframes drawCheck {
            from { stroke-dashoffset: 100; }
            to { stroke-dashoffset: 0; }
        }

        /* Card slide up */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-up { animation: slideUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        /* Confetti dot */
        @keyframes confetti-fall {
            0% { transform: translateY(-20px) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100px) rotate(720deg); opacity: 0; }
        }
        .confetti-dot {
            position: absolute;
            width: 8px; height: 8px;
            border-radius: 2px;
            animation: confetti-fall 2s ease forwards;
        }

        /* Hero section */
        .success-hero {
            background: linear-gradient(135deg, #14532d 0%, #16a34a 100%);
            position: relative;
            overflow: hidden;
        }
        .success-hero::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -10%;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(134,239,172,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        .success-hero::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0; right: 0;
            height: 40px;
            background: #ffffff;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        /* Info cards */
        .info-card {
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
        }
        .info-card-blue {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
        }
        .info-card-amber {
            background: #fffbeb;
            border: 1px solid #fde68a;
        }
        .info-card-green {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        /* Step item */
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
        }
        .step-num {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            flex-shrink: 0;
        }

        /* Print styles */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .success-hero { print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-glass text-white shadow-md no-print">
        <div class="max-w-5xl mx-auto px-5 sm:px-6 py-3.5 flex items-center">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.5 2 6 4.1 6 7c0 2.5 1.5 4.5 3 5.5V19c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2v-6.5c1.5-1 3-3 3-5.5 0-2.9-2.5-5-6-5z"/>
                    </svg>
                </div>
                <span class="font-bold text-base">Klinik Gigi Sejahtera</span>
            </div>
        </div>
    </nav>

    <div class="max-w-xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <!-- Success Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            
            <!-- Hero Section -->
            <div class="success-hero py-12 px-8 text-center relative">
                <!-- Confetti (decorative) -->
                <div class="confetti-dot bg-yellow-300" style="top:20%;left:15%;animation-delay:0.1s;animation-duration:1.8s;"></div>
                <div class="confetti-dot bg-blue-300 rounded-full" style="top:30%;left:30%;animation-delay:0.3s;animation-duration:2.1s;"></div>
                <div class="confetti-dot bg-pink-300" style="top:15%;right:20%;animation-delay:0.2s;animation-duration:1.9s;"></div>
                <div class="confetti-dot bg-green-300 rounded-full" style="top:25%;right:35%;animation-delay:0.5s;animation-duration:2.2s;"></div>
                <div class="confetti-dot bg-amber-300" style="top:40%;left:10%;animation-delay:0.4s;animation-duration:1.7s;"></div>

                <!-- Success Icon -->
                <div class="success-icon w-20 h-20 mx-auto mb-5 relative z-10">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/40">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" 
                                  stroke-dasharray="100" stroke-dashoffset="100"
                                  style="animation: drawCheck 0.6s ease 0.7s forwards;"/>
                        </svg>
                    </div>
                </div>

                <h1 class="font-display text-3xl sm:text-4xl text-white mb-2 relative z-10">Reservasi Berhasil!</h1>
                <p class="text-green-100 text-sm sm:text-base relative z-10">Terima kasih telah memilih Klinik Gigi Sejahtera</p>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8 space-y-5">

                <!-- Confirmation badge -->
                <div class="info-card info-card-green slide-up delay-1 flex items-start gap-3">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-green-800 text-sm">Janji temu berhasil dibuat</p>
                        <p class="text-green-600 text-xs mt-0.5">Konfirmasi akan dikirim dalam 24 jam kerja. Pastikan nomor telepon Anda dapat dihubungi.</p>
                    </div>
                </div>

                <!-- Important info -->
                <div class="info-card info-card-blue slide-up delay-2">
                    <h3 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-2">
                        <span>📋</span> Informasi Penting
                    </h3>
                    <div class="space-y-0.5 divide-y divide-blue-100">
                        <div class="step-item">
                            <div class="step-num">1</div>
                            <p class="text-slate-600 text-sm">Tim klinik akan menghubungi Anda untuk konfirmasi dalam <strong class="text-slate-800">24 jam kerja</strong></p>
                        </div>
                        <div class="step-item">
                            <div class="step-num">2</div>
                            <p class="text-slate-600 text-sm">Pastikan nomor telepon yang Anda daftarkan dapat dihubungi</p>
                        </div>
                        <div class="step-item">
                            <div class="step-num">3</div>
                            <p class="text-slate-600 text-sm">Hadir <strong class="text-slate-800">10 menit lebih awal</strong> dari jadwal yang telah ditetapkan</p>
                        </div>
                        <div class="step-item">
                            <div class="step-num">4</div>
                            <p class="text-slate-600 text-sm">Bawa <strong class="text-slate-800">kartu identitas</strong> dan kartu asuransi (jika ada)</p>
                        </div>
                        <div class="step-item">
                            <div class="step-num">5</div>
                            <p class="text-slate-600 text-sm">Pembatalan maksimal <strong class="text-slate-800">24 jam sebelum</strong> jadwal. Hubungi kami jika ada perubahan.</p>
                        </div>
                    </div>
                </div>

                <!-- Next steps -->
                <div class="info-card info-card-amber slide-up delay-3">
                    <h3 class="font-bold text-amber-800 text-sm mb-3 flex items-center gap-2">
                        <span>💡</span> Anda akan dihubungi melalui:
                    </h3>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex items-center gap-2.5 bg-white rounded-xl p-3 flex-1 border border-amber-100">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-xs">Panggilan Telepon</p>
                                <p class="text-slate-500 text-xs">Dari nomor klinik kami</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 bg-white rounded-xl p-3 flex-1 border border-amber-100">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 text-xs">Email Konfirmasi</p>
                                <p class="text-slate-500 text-xs">Notifikasi otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact info -->
                <div class="grid grid-cols-2 gap-3 slide-up delay-4">
                    <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                        <p class="text-xs text-slate-400 mb-0.5">Hubungi Kami</p>
                        <p class="font-bold text-green-600 text-base sm:text-lg leading-tight">+62 123 456 789</p>
                        <p class="text-xs text-slate-400 mt-0.5">Senin–Sabtu, 08–20</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                        <p class="text-xs text-slate-400 mb-0.5">Email Klinik</p>
                        <p class="font-bold text-green-600 text-sm leading-tight break-all">info@klinikklinik.com</p>
                        <p class="text-xs text-slate-400 mt-0.5">Respon 24 jam</p>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="space-y-3 slide-up delay-4 no-print">
                    <a href="{{ route('reservasi.index') }}" class="block w-full text-center bg-green-600 text-white py-3.5 rounded-2xl font-bold hover:bg-green-700 transition hover:shadow-lg hover:-translate-y-0.5 transform">
                        Kembali ke Beranda
                    </a>
                    <button onclick="window.print()" class="w-full border-2 border-slate-200 text-slate-600 py-3 rounded-2xl font-semibold hover:bg-slate-50 hover:border-slate-300 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                        </svg>
                        Cetak Halaman
                    </button>
                </div>
            </div>
        </div>

        <!-- Tips below card -->
        <div class="mt-5 text-center no-print">
            <p class="text-xs text-slate-400">Simpan nomor klinik kami: <strong class="text-slate-600">+62 123 456 789</strong></p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 px-5 text-center no-print">
        <p class="text-xs text-slate-400">&copy; 2026 Klinik Gigi Sejahtera. Semua hak dilindungi.</p>
    </footer>
</body>
</html>