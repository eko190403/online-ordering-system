# 🍽️ Sistem QR Menu Cafe - Online Ordering System

Aplikasi web modern untuk manajemen cafe dengan fitur QR Menu, pemesanan online real-time, tracking pesanan, dan laporan penjualan lengkap.

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)

## 📸 Screenshots

### Customer Interface
![menu](public/picture/user_menu.png)
*tampilan menu user*

![Cart Checkout](public/picture/cart-checkout.png)
*Keranjang belanja & checkout dengan pilihan pembayaran*

![Order Tracking](public/picture/order-tracking.png)
*Real-time order tracking untuk customer*

### Admin Panel
![Dashboard](public/picture/dashboard_admin.png)
*Dashboard analytics dengan grafik revenue & menu terlaris*

![Menu Management](public/picture/kelola_menu.png)
*Kelola menu dengan upload foto*

---

## 🎯 Fitur Utama

### Customer (QR Menu)
- ✅ Scan QR Code untuk akses menu via HP
- ✅ Tampilan daftar menu dengan foto HD, harga, dan deskripsi
- ✅ Filter menu berdasarkan kategori
- ✅ Pencarian menu real-time
- ✅ Sistem pemesanan dengan keranjang belanja
- ✅ Pilih metode pembayaran (Cash/QRIS/Transfer)
- ✅ Catatan pesanan (level pedas, tanpa bawang, dll)
- ✅ **Real-time Order Tracking** - Floating button "Lihat Pesanan"
- ✅ **Auto-notification** saat pesanan selesai
- ✅ Konfirmasi pesanan dengan kode order unik

### Admin Panel
- ✅ **Dashboard Analytics**
  - Total revenue (harian & keseluruhan)
  - Menu terlaris (Top 5)
  - Peak hours analysis
  - Grafik revenue 7 hari dengan Chart.js
- ✅ **Kelola Menu** - CRUD menu dengan upload foto (max 2MB, JPG/PNG)
- ✅ **Kelola Kategori** - Manajemen kategori menu
- ✅ **Kelola Pesanan**
  - Status flow: Masuk → Diproses → Selesai
  - Konfirmasi pembayaran transfer/QRIS
  - Print struk thermal-friendly
  - Payment status tracking (Pending/Lunas)
- ✅ **Manajemen Stok**
  - Auto stock deduction saat order
  - Stock IN/OUT logging
  - Low stock alert
- ✅ **Laporan Penjualan**
  - Filter: Harian, Bulanan, Tahunan
  - Export Excel (XLSX) & PDF
  - Detail per transaksi
- ✅ **Generate QR Code** - Untuk akses menu customer
- ✅ **Database Backup** - Auto backup dengan command
- ✅ **Multi User/Role** - Admin dengan 2 akun

### Security Features 🔐
- ✅ Rate limiting (anti brute force - max 10 login/5 menit)
- ✅ Secure order code (UUID - tidak bisa ditebak)
- ✅ Session timeout (2 jam auto logout)
- ✅ XSS protection (auto-escape output)
- ✅ File upload validation (mime type + size)
- ✅ CSRF protection
- ✅ Password hashing (bcrypt)

### Modern UI/UX ✨
- ✅ SweetAlert2 notifications
- ✅ Loading states & progress indicators
- ✅ Confirmation dialogs
- ✅ Responsive mobile-first design
- ✅ Gradient color scheme
- ✅ Font Awesome icons
- ✅ Google Fonts (Poppins & Playfair Display)

## 📋 Requirements

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL/MariaDB
- Web Server (Apache/Nginx)
- Node.js & NPM (untuk asset building)

## 🚀 Instalasi

### 1. Clone atau Extract Project
```bash
cd c:\xampp\htdocs\cafe
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
# Copy file .env.example ke .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database
Buat database baru dengan nama `cafe_db` melalui phpMyAdmin atau command line:
```sql
CREATE DATABASE cafe_db;
```

### 6. Jalankan Migrasi dan Seeder
```bash
# Migrasi database
php artisan migrate

# Seed data awal (kategori, menu, admin)
php artisan db:seed
```

### 7. Buat Folder Upload
```bash
# Buat folder untuk menyimpan gambar menu
mkdir public\uploads
mkdir public\uploads\menus
```

### 8. Install QR Code Package (Jika diperlukan)
```bash
composer require simplesoftwareio/simple-qrcode
```

### 9. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 👥 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

**Admin 1:**
- Email: `admin1@cafe.com`
- Password: `password`

**Admin 2:**
- Email: `admin2@cafe.com`
- Password: `password`

## 📱 Cara Penggunaan

### Customer (Pelanggan)

1. **Scan QR Code**
   - Buka kamera HP dan scan QR Code yang tersedia di meja
   - Atau akses langsung: `http://localhost:8000`

2. **Pilih Menu**
   - Browse menu berdasarkan kategori
   - Klik menu untuk menambahkan ke keranjang

3. **Checkout**
   - Klik icon keranjang di pojok kanan bawah
   - Review pesanan
   - Klik "Pesan Sekarang"
   - Simpan kode order untuk tracking

### Admin

1. **Login**
   - Akses: `http://localhost:8000/login`
   - Masukkan email dan password admin

2. **Dashboard**
   - Lihat statistik pesanan (masuk, diproses, selesai)
   - Monitor total menu dan kategori

3. **Kelola Pesanan**
   - Lihat daftar pesanan
   - Ubah status: Masuk → Diproses → Selesai

4. **Kelola Menu**
   - Tambah menu baru dengan foto
   - Edit informasi menu
   - Hapus menu

5. **Kelola Kategori**
   - Tambah/edit/hapus kategori menu

6. **Manajemen Stok**
   - Update stok masuk (IN)
   - Update stok keluar (OUT)
   - Lihat riwayat stok

7. **Laporan Penjualan**
   - Lihat laporan penjualan
   - Export ke Excel
   - Export ke PDF

8. **QR Code**
   - Generate QR Code untuk menu
   - Print QR Code

## 🗂️ Struktur Project

```
cafe/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php       # Dashboard & Orders
│   │   ├── AdminMenuController.php   # Menu & Category Management
│   │   ├── MenuController.php        # Customer Menu Display
│   │   ├── OrderController.php       # Order Processing
│   │   ├── ReportController.php      # Sales Reports
│   │   ├── StockController.php       # Stock Management
│   │   └── UserController.php        # Authentication
│   ├── Models/
│   │   ├── Category.php
│   │   ├── Menu.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Stock.php
│   │   ├── StockLog.php
│   │   └── User.php
│   └── Exports/
│       └── SalesExport.php           # Excel Export
├── database/
│   ├── migrations/                   # Database Migrations
│   └── seeders/
│       └── DatabaseSeeder.php        # Sample Data
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php            # Customer Layout
│   │   └── admin.blade.php          # Admin Layout
│   ├── menu/
│   │   └── index.blade.php          # QR Menu Display
│   ├── admin/
│   │   ├── dashboard.blade.php
│   │   ├── orders/index.blade.php
│   │   ├── menu/index.blade.php
│   │   ├── categories/index.blade.php
│   │   ├── stock/
│   │   ├── reports/sales.blade.php
│   │   └── qrcode.blade.php
│   └── auth/
│       └── login.blade.php
└── routes/
    └── web.php                       # All Routes
```

## 🔐 Keamanan

- Semua route admin dilindungi middleware `auth`
- Password di-hash menggunakan bcrypt
- CSRF protection pada semua form
- Input validation pada semua form

## 📊 Database Schema

### Tables:
- `users` - Admin accounts dengan role
- `categories` - Kategori menu
- `menus` - Data menu (nama, harga, deskripsi, foto)
- `orders` - Data pesanan
- `order_items` - Item dalam pesanan
- `stocks` - Stok menu
- `stock_logs` - Riwayat perubahan stok

## 🛠️ Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Permission Error (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

### QR Code tidak muncul
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:cache
```

### Gambar tidak tampil
Pastikan folder `public/uploads/menus` memiliki permission write

## 📝 Development Notes

### Menambah Admin Baru
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin Name',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 'admin',
]);
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 📄 License

MIT License - Aplikasi ini dibuat untuk keperluan project cafe management system.

---

## 👨‍💻 Developer & Contact

**Eko Saputra**  
🎓 S1 Teknik Informatika  
📱 WhatsApp: [085769363379](https://wa.me/6285769363379)  
💼 GitHub: [@eko190403](https://github.com/eko190403)

### 💻 Layanan Pembuatan Website & Aplikasi

Menerima jasa pembuatan:
- ✅ **Website Company Profile** - Profesional & Responsif
- ✅ **Sistem Informasi** - Sekolah, Inventory, HRD, dll
- ✅ **E-Commerce / Toko Online** - Multi vendor & Payment gateway
- ✅ **Aplikasi Kasir (POS)** - Desktop & Web based
- ✅ **Landing Page** - Conversion optimized
- ✅ **Website Sekolah/Kampus** - Lengkap dengan portal siswa
- ✅ **Aplikasi Android/iOS** - React Native / Flutter
- ✅ **API Development** - RESTful API untuk integrasi
- ✅ **Custom Web Application** - Sesuai kebutuhan bisnis Anda

**Tech Stack:**
- Laravel, CodeIgniter, Node.js
- React, Vue.js, Next.js
- MySQL, PostgreSQL, MongoDB
- Bootstrap, Tailwind CSS
- Payment Gateway: Midtrans, Xendit
- WhatsApp API Integration

**Portfolio & Demo:**
- 🔗 Online Ordering System (QR Menu): [Demo](https://github.com/eko190403/online-ordering-system)
- 🔗 Dan project lainnya di [GitHub](https://github.com/eko190403)

**Harga Terjangkau & Kualitas Profesional!**  
📞 Hubungi untuk konsultasi & quotation GRATIS

---

## 🌟 Testimonial

> *"Sistem QR Menu ini sangat membantu operasional cafe kami. Customer bisa pesan langsung tanpa antri, dan admin panel nya mudah digunakan!"*  
> — **Cafe D.Villa Lampung**

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!  
Feel free to check [issues page](https://github.com/eko190403/online-ordering-system/issues).

## ⭐ Show your support

Give a ⭐️ if this project helped you!

---

**Happy Coding! ☕**

*Developed with ❤️ by Eko Saputra*
