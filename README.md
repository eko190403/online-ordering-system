# Online Ordering System (Sistem Order Menu Cafe)

Aplikasi berbasis web untuk manajemen pemesanan di cafe atau restoran. Sistem ini dirancang untuk mempermudah alur kerja mulai dari pelanggan memesan via QR Code, konfirmasi pembayaran, proses di dapur, hingga pelaporan keuangan.

## Fitur Utama

- **Pemesanan via QR Code (Self-Order)**: Pelanggan bisa scan QR di meja untuk melihat menu dan langsung memesan dari HP masing-masing.
- **Integrasi Pembayaran (Midtrans)**: Mendukung pembayaran otomatis via transfer bank, e-wallet, atau QRIS menggunakan Midtrans.
- **Kitchen Display System (KDS)**: Tampilan khusus untuk tim dapur memantau pesanan masuk secara real-time.
- **Live Order Tracking**: Pelanggan bisa melihat status pesanan mereka (Sedang Diproses, Selesai, dll).
- **Promo & Poin Pelanggan**: Sistem loyalitas pelanggan dengan fitur poin reward dan kode promo/diskon.
- **Manajemen Pengeluaran (Expenses)**: Pencatatan biaya operasional harian cafe.
- **Dashboard & Laporan**: Laporan penjualan lengkap, analitik pendapatan, dan rekap data transaksi untuk pemilik/admin.
- **Manajemen Stok & Menu**: Kelola ketersediaan menu, kategori menu, dan update harga dengan mudah.

## Teknologi yang Digunakan

- PHP 8.x
- Framework Laravel
- Database MySQL
- Midtrans Payment Gateway API

## Panduan Instalasi (Development)

1. Clone repositori ini ke folder server lokal Anda (misalnya `htdocs` jika menggunakan XAMPP).
   ```bash
   git clone https://github.com/eko190403/online-ordering-system.git
   cd online-ordering-system
   ```

2. Install dependency PHP menggunakan Composer.
   ```bash
   composer install
   ```

3. Duplikat file konfigurasi environment.
   ```bash
   copy .env.example .env
   ```
   *Buka file `.env` lalu sesuaikan konfigurasi koneksi database Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). Pastikan juga untuk mengisi kredensial API Midtrans Anda di file ini.*

4. Generate APP_KEY Laravel.
   ```bash
   php artisan key:generate
   ```

5. Jalankan migrasi beserta data awal (seeder).
   ```bash
   php artisan migrate --seed
   ```

6. Jalankan local server.
   ```bash
   php artisan serve
   ```
   Aplikasi siap diakses melalui browser di `http://localhost:8000`.

---

## Kontak & Layanan Pembuatan Aplikasi

Proyek ini dikembangkan oleh **Eko Saputra**. 
Jika Anda membutuhkan jasa pembuatan website, sistem informasi, e-commerce, atau aplikasi kasir (POS) custom sesuai kebutuhan bisnis Anda, silakan hubungi:

- **WhatsApp**: [085769363379](https://wa.me/6285769363379)
- **GitHub**: [@eko190403](https://github.com/eko190403)
