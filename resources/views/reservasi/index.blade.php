<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klinik Gigi - Reservasi Online</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="bg-green-600 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 2c-1.1 0-2 .9-2 2v3H4c-1.1 0-2 .9-2 2v4h2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6h2V9c0-1.1-.9-2-2-2h-3V4c0-1.1-.9-2-2-2H9zm0 2h6v3H9V4zm9 5v6H6v-6h12z"/>
                </svg>
                <h1 class="text-2xl font-bold">Klinik Gigi Sejahtera</h1>
            </div>
            <a href="#reservasi" class="bg-white text-green-600 px-6 py-2 rounded-lg font-semibold hover:bg-green-50 transition">Reservasi</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-600 to-green-700 text-white py-16 px-6">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-5xl font-bold mb-4">Kesehatan Gigi Anda, Prioritas Kami</h2>
            <p class="text-xl text-green-100 mb-8">Dapatkan perawatan gigi terbaik dengan dokter gigi profesional dan berpengalaman</p>
            <a href="#reservasi" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                Buat Reservasi Sekarang
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 px-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-slate-900 mb-12">Tentang Klinik Kami</h2>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1631217314997-dc3edf4bdf12?w=500" alt="Klinik" class="rounded-lg shadow-lg w-full">
                </div>
                <div class="space-y-6">
                    <p class="text-lg text-slate-700">
                        Klinik Gigi Sejahtera telah melayani masyarakat dengan dedikasi selama bertahun-tahun. Kami berkomitmen memberikan perawatan gigi berkualitas tinggi dengan menggunakan teknologi terkini.
                    </p>
                    <p class="text-lg text-slate-700">
                        Tim dokter gigi kami yang berpengalaman siap membantu Anda mencapai senyum yang indah dan sehat.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-slate-700">Dokter gigi berpengalaman dan tersertifikasi</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-slate-700">Peralatan medis modern dan lengkap</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-slate-700">Kenyamanan pasien adalah prioritas utama</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-slate-900 mb-12">Layanan Kami</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-green-50 rounded-lg p-8 border border-green-200 hover:shadow-lg transition">
                    <svg class="w-12 h-12 text-green-600 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 2c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2h-6zm0 10c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2v-4c0-1.1-.9-2-2-2h-6z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Pembersihan Gigi</h3>
                    <p class="text-slate-600">Pembersihan gigi profesional untuk menghilangkan karang gigi dan plak yang membandel.</p>
                </div>

                <!-- Service 2 -->
                <div class="bg-blue-50 rounded-lg p-8 border border-blue-200 hover:shadow-lg transition">
                    <svg class="w-12 h-12 text-blue-600 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Penambalan Gigi</h3>
                    <p class="text-slate-600">Penambalan gigi dengan material terbaik untuk gigi yang berlubang atau rusak.</p>
                </div>

                <!-- Service 3 -->
                <div class="bg-purple-50 rounded-lg p-8 border border-purple-200 hover:shadow-lg transition">
                    <svg class="w-12 h-12 text-purple-600 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Whitening Gigi</h3>
                    <p class="text-slate-600">Pemutihan gigi profesional untuk gigi yang lebih putih dan bersinar alami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservasi" class="py-16 px-6 bg-slate-100">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-slate-900 mb-4">Buat Reservasi Sekarang</h2>
            <p class="text-center text-slate-600 mb-8">Pilih jadwal yang sesuai dengan kebutuhan Anda dan dapatkan nomor antrian</p>
            <a href="{{ route('reservasi.create') }}" class="block w-full bg-green-600 text-white py-4 rounded-lg font-bold text-center hover:bg-green-700 transition">
                Lanjut ke Form Reservasi
            </a>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 px-6 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12">Hubungi Kami</h2>
            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div>
                    <svg class="w-8 h-8 mx-auto mb-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    <p class="text-gray-300">Telepon</p>
                    <p class="font-semibold">+62 123 456 789</p>
                </div>
                <div>
                    <svg class="w-8 h-8 mx-auto mb-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                    <p class="text-gray-300">Email</p>
                    <p class="font-semibold">info@klinikklinik.com</p>
                </div>
                <div>
                    <svg class="w-8 h-8 mx-auto mb-4 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                    <p class="text-gray-300">Alamat</p>
                    <p class="font-semibold">Jl. Kesehatan No. 123, Jakarta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-400 py-6 px-6 text-center">
        <div class="max-w-6xl mx-auto">
            <p>&copy; 2026 Klinik Gigi Sejahtera. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
