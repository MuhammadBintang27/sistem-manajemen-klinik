# Sistem Manajemen Klinik

Sebuah aplikasi web sederhana untuk membantu operasional klinik dalam mengelola data pasien, jadwal pemeriksaan, reservasi, serta rekam medis.

## Deskripsi Umum

Sistem ini dirancang untuk mendigitalisasi dan menyederhanakan proses administrasi di sebuah klinik. Dengan tiga jenis pengguna utama (Admin, Dokter, Pasien), aplikasi ini mencakup alur kerja mulai dari pendaftaran pasien, reservasi jadwal, pemeriksaan oleh dokter, hingga pencatatan rekam medis.

## Peran Pengguna & Fitur

Sistem ini memiliki tiga peran utama:

### 1. Admin
Bertugas mengelola data operasional dan administratif.
- **Manajemen Pasien**: Membuat, membaca, memperbarui, dan menghapus (CRUD) data pasien.
- **Manajemen Jadwal Praktik**: Mengatur jadwal praktik dokter, termasuk mengaktifkan atau menonaktifkan slot waktu tertentu.
- **Manajemen Reservasi**: Memantau dan mengelola reservasi yang masuk dari pasien.
- **Melihat Laporan**: (Fitur masa depan) Melihat laporan operasional klinik.

### 2. Dokter
Berfokus pada pelayanan medis dan pencatatan data klinis.
- **Melihat Jadwal**: Mengakses jadwal praktik dan daftar pasien yang telah melakukan reservasi.
- **Mengisi Rekam Medis**: Mencatat hasil pemeriksaan pasien yang mencakup keluhan, diagnosa, dan terapi. Data rekam medis ini bersifat *read-only* setelah disimpan untuk menjaga integritas data.

### 3. Pasien
Pasien tidak memerlukan akun untuk menggunakan sistem.
- **Reservasi Jadwal**: Melakukan reservasi jadwal pemeriksaan dengan memasukkan Nomor Induk Kependudukan (NIK). Jika NIK sudah terdaftar, data diri akan terisi otomatis. Jika belum, pasien akan diminta melengkapi data diri terlebih dahulu.

## Struktur Basis Data

Basis data dirancang untuk menjaga konsistensi dan menghindari redundansi data. Terdiri dari beberapa tabel utama:

- `users`: Menyimpan data login untuk **Admin** dan **Dokter**.
- `pasien`: Menyimpan data identitas pasien.
- `jadwal`: Mengatur jadwal praktik dokter, termasuk slot waktu dan kuota.
- `reservasi`: Menghubungkan antara pasien dan jadwal yang dipilih, serta mencatat status reservasi.
- `rekam_medis`: Mencatat riwayat hasil pemeriksaan pasien oleh dokter.

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Basis Data**: MySQL (atau sesuai konfigurasi)
- **Autentikasi**: Manual Laravel auth

## Panduan Instalasi

1.  **Clone Repositori**
    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd sistem-manajemen-klinik
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    - Salin file `.env.example` menjadi `.env`.
      ```bash
      cp .env.example .env
      ```
    - Buat kunci aplikasi baru.
      ```bash
      php artisan key:generate
      ```
    - Atur koneksi basis data Anda di dalam file `.env`.
      ```
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=manajemen_klinik
      DB_USERNAME=root
      DB_PASSWORD=
      ```

4.  **Migrasi Basis Data**
    Jalankan migrasi untuk membuat semua tabel yang diperlukan.
    ```bash
    php artisan migrate
    ```

5.  **Compile Aset Frontend**
    ```bash
    npm run dev
    ```

6.  **Jalankan Server Pengembangan**
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di `http://127.0.0.1:8000`.

7.  **Membuat Akun Awal**
    - Jalankan `php artisan tinker`.
    - Buat akun admin:
      ```php
      \App\Models\User::create(['nama' => 'Admin', 'email' => 'admin@klinik.com', 'password' => bcrypt('password'), 'role' => 'admin']);
      ```
    - Buat akun dokter:
      ```php
      \App\Models\User::create(['nama' => 'Dokter', 'email' => 'dokter@klinik.com', 'password' => bcrypt('password'), 'role' => 'dokter']);
      ```
    - Keluar dari tinker dengan `exit`.
    - Anda sekarang bisa login menggunakan akun `admin@klinik.com` atau `dokter@klinik.com` dengan password `password`.

