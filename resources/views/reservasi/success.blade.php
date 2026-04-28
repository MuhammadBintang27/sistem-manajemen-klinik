<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Berhasil - Klinik Gigi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50">
    <!-- Navbar -->
    <nav class="bg-green-600 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 2c-1.1 0-2 .9-2 2v3H4c-1.1 0-2 .9-2 2v4h2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6h2V9c0-1.1-.9-2-2-2h-3V4c0-1.1-.9-2-2-2H9zm0 2h6v3H9V4zm9 5v6H6v-6h12z"/>
                </svg>
                <h1 class="text-2xl font-bold">Klinik Gigi Sejahtera</h1>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-12 px-6 flex items-center justify-center min-h-screen">
        <!-- Success Card -->
        <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-green-600 py-12 px-8 text-center text-white">
                <!-- Success Icon -->
                <div class="mb-6">
                    <svg class="w-20 h-20 mx-auto animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>

                <h1 class="text-4xl font-bold mb-3">Reservasi Berhasil!</h1>
                <p class="text-green-100 text-lg">Terima kasih telah melakukan reservasi di Klinik Gigi Sejahtera</p>
            </div>

            <div class="p-8">
                <!-- Success Message -->
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 mb-8">
                    <p class="text-green-900 font-semibold text-center">
                        ✓ Janji temu Anda telah berhasil dibuat dan sedang menunggu konfirmasi dari pihak klinik.
                    </p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">📋 Informasi Penting:</h2>
                    <ul class="space-y-3 text-slate-700">
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 font-bold mt-1">1.</span>
                            <span>Tim klinik akan menghubungi Anda untuk mengkonfirmasi janji temu dalam waktu 24 jam</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 font-bold mt-1">2.</span>
                            <span>Pastikan nomor telepon Anda dapat dihubungi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 font-bold mt-1">3.</span>
                            <span>Datang 10 menit lebih awal dari jadwal yang telah ditetapkan</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 font-bold mt-1">4.</span>
                            <span>Bawa kartu identitas dan asuransi (jika ada)</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-blue-600 font-bold mt-1">5.</span>
                            <span>Untuk membatalkan atau mengubah jadwal, hubungi klinik maksimal 24 jam sebelum jadwal</span>
                        </li>
                    </ul>
                </div>

                <!-- Next Steps -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-8">
                    <h3 class="font-bold text-amber-900 mb-3">💡 Langkah Selanjutnya:</h3>
                    <p class="text-amber-800 mb-3">
                        Klinik akan segera memproses reservasi Anda. Anda akan menerima notifikasi melalui:
                    </p>
                    <ul class="space-y-2 text-amber-800">
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                            </svg>
                            <span>Panggilan telepon dari klinik</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span>Email notifikasi konfirmasi</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Hubungi Klinik Kami</p>
                        <p class="text-2xl font-bold text-green-600">+62 123 456 789</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Email Klinik</p>
                        <p class="text-lg font-bold text-green-600">info@klinikklinik.com</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <a href="{{ route('reservasi.index') }}" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold text-center hover:bg-green-700 transition">
                        Kembali ke Beranda
                    </a>
                    <button onclick="window.print()" class="w-full border-2 border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Cetak Halaman Ini
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-6 px-6 text-center mt-12">
        <div class="max-w-6xl mx-auto">
            <p>&copy; 2026 Klinik Gigi Sejahtera. Semua hak dilindungi.</p>
        </div>
    </footer>
</body>
</html>
