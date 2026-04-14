# CalpingCoffee — Simple POS & Menu Digital

Sistem Point of Sale (POS) sederhana yang dibangun khusus untuk operasional kafe. Fokus pada kemudahan penggunaan bagi kasir dan pengalaman digital bagi pelanggan lewat fitur scan QR meja.

## Fitur Utama
- **Dashboard Kasir & Barista**: Kelola pesanan masuk secara real-time.
- **Scan QR Toko**: Pelanggan bisa langsung pesan dari meja tanpa nunggu antre.
- **Auto "Menu Favorit"**: Halaman depan otomatis nampilin 3 menu paling laku dalam 30 hari terakhir (biar gak perlu edit manual tiap ada tren baru).
- **Desain Neobrutalisme**: Look & feel retro dengan kontras tinggi, terinspirasi dari estetika kopi lokal.

## Tech Stack
- **Framework**: Laravel 11
- **Styling**: Tailwind CSS (Custom Color Palette)
- **Interaktivitas**: Alpine.js & GSAP (untuk animasi hero)
- **Database**: MySQL

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM

## Cara Instalasi

1. **Clone repository ini:**
   ```bash
   git clone https://github.com/kdpras00/Calpingcoffe.git
   cd Calpingcoffe
   ```

2. **Instal dependensi:**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment:**
   Salin file `.env.example` ke `.env` lalu sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi database & seeding (opsional):**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalankan aplikasi:**
   ```bash
   npm run dev
   # dan di terminal terpisah:
   php artisan serve
   ```

## Folder Utama
- `app/Http/Controllers`: Logika bisnis (Admin, Cashier, Customer).
- `resources/views`: Semua tampilan (Blade templates).
- `public/img`: Aset gambar dan *image sequence* untuk hero section.

---
Dikembangkan oleh [kdpras00](https://github.com/kdpras00)
