# INSTALLATION CHECKLIST
# Sistem QR Menu Cafe - Panduan Step-by-Step

## ✅ PRE-INSTALLATION CHECKLIST

### Requirements
- [ ] XAMPP terinstall (atau WAMP/MAMP)
- [ ] PHP 8.2 atau lebih tinggi
- [ ] Composer terinstall
- [ ] MySQL running
- [ ] Text editor (VSCode, Sublime, dll)

### Verifikasi PHP & Composer
```bash
# Check PHP version
php -v

# Check Composer
composer -v
```

---

## 📦 INSTALLATION STEPS

### ✅ Step 1: Persiapan Project
- [ ] Project sudah ada di `c:\xampp\htdocs\cafe`
- [ ] Buka Command Prompt/Terminal di folder project
- [ ] Pastikan koneksi internet aktif (untuk composer)

### ✅ Step 2: Install Dependencies
```bash
cd c:\xampp\htdocs\cafe
composer install
```
**Tunggu sampai selesai (±2-5 menit)**

Checklist:
- [ ] Composer install berhasil
- [ ] Folder `vendor` terbuat
- [ ] Tidak ada error merah

### ✅ Step 3: Setup Environment File
```bash
# Copy .env.example ke .env
copy .env.example .env
```

Checklist:
- [ ] File `.env` terbuat di root folder
- [ ] Buka file `.env` dengan text editor

### ✅ Step 4: Generate Application Key
```bash
php artisan key:generate
```

Checklist:
- [ ] Muncul pesan "Application key set successfully"
- [ ] Di `.env`, `APP_KEY` sudah terisi

### ✅ Step 5: Setup Database

#### 5a. Buat Database
- [ ] Buka http://localhost/phpmyadmin
- [ ] Klik "New" atau "Database"
- [ ] Nama database: `cafe_db`
- [ ] Collation: `utf8mb4_unicode_ci`
- [ ] Klik "Create"

#### 5b. Konfigurasi .env
Edit file `.env`, sesuaikan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_db
DB_USERNAME=root
DB_PASSWORD=
```

Checklist:
- [ ] `DB_DATABASE` = cafe_db
- [ ] `DB_USERNAME` sesuai (default: root)
- [ ] `DB_PASSWORD` sesuai (default: kosong)

### ✅ Step 6: Run Migrations
```bash
php artisan migrate
```

Checklist:
- [ ] Muncul list tabel yang dibuat
- [ ] Tidak ada error
- [ ] Di phpMyAdmin, tabel-tabel sudah ada:
  - [ ] users
  - [ ] categories
  - [ ] menus
  - [ ] orders
  - [ ] order_items
  - [ ] stocks
  - [ ] stock_logs

### ✅ Step 7: Seed Sample Data
```bash
php artisan db:seed
```

Checklist:
- [ ] Muncul pesan seeding berhasil
- [ ] Di phpMyAdmin, data sudah ada:
  - [ ] 2 users (admin)
  - [ ] 5 categories
  - [ ] 12 menus

### ✅ Step 8: Create Upload Folder
```bash
# Windows
mkdir public\uploads
mkdir public\uploads\menus

# Linux/Mac
mkdir -p public/uploads/menus
```

Checklist:
- [ ] Folder `public/uploads` ada
- [ ] Folder `public/uploads/menus` ada
- [ ] File `.gitkeep` ada di folder menus

### ✅ Step 9: Install QR Code Package (Optional)
```bash
composer require simplesoftwareio/simple-qrcode
```

Checklist:
- [ ] Package terinstall
- [ ] Atau skip jika sudah ada di composer.json

### ✅ Step 10: Clear Cache
```bash
php artisan config:cache
php artisan route:cache
```

Checklist:
- [ ] Config cached
- [ ] Routes cached
- [ ] Tidak ada error

---

## 🚀 RUNNING THE APPLICATION

### ✅ Step 11: Start Server
```bash
php artisan serve
```

Checklist:
- [ ] Server running di http://localhost:8000
- [ ] Tidak ada error
- [ ] Browser bisa akses URL

---

## 🧪 TESTING

### ✅ Test 1: Customer Menu (QR Menu)
**URL**: http://localhost:8000

Checklist:
- [ ] Halaman menu terbuka
- [ ] Menu-menu tampil
- [ ] Kategori filter berfungsi
- [ ] Klik menu → masuk keranjang
- [ ] Icon keranjang muncul badge
- [ ] Buka keranjang → list benar
- [ ] Qty +/- berfungsi
- [ ] Total harga benar
- [ ] Checkout berhasil
- [ ] Dapat kode order
- [ ] Modal konfirmasi muncul

### ✅ Test 2: Admin Login
**URL**: http://localhost:8000/login

Login dengan:
- Email: `admin1@cafe.com`
- Password: `password`

Checklist:
- [ ] Halaman login tampil
- [ ] Input email & password
- [ ] Login berhasil
- [ ] Redirect ke dashboard

### ✅ Test 3: Admin Dashboard
**URL**: http://localhost:8000/admin

Checklist:
- [ ] Dashboard tampil
- [ ] Sidebar navigation ada
- [ ] Statistik cards muncul
- [ ] Total pesanan benar
- [ ] Menu counts benar

### ✅ Test 4: Manage Orders
**URL**: http://localhost:8000/admin/orders

Checklist:
- [ ] List pesanan tampil
- [ ] Order yang dibuat tadi ada
- [ ] Status "Masuk" (badge kuning)
- [ ] Klik "Proses" → status jadi "Diproses"
- [ ] Klik "Selesai" → status jadi "Selesai"

### ✅ Test 5: Manage Menu
**URL**: http://localhost:8000/admin/menu

Checklist:
- [ ] List menu tampil
- [ ] Klik "Tambah Menu"
- [ ] Form modal muncul
- [ ] Isi form & upload foto
- [ ] Submit berhasil
- [ ] Menu baru muncul di list
- [ ] Edit menu berfungsi
- [ ] Delete menu (dengan konfirmasi)

### ✅ Test 6: Manage Categories
**URL**: http://localhost:8000/admin/categories

Checklist:
- [ ] List kategori tampil
- [ ] Tambah kategori baru
- [ ] Edit kategori
- [ ] Delete kategori

### ✅ Test 7: Stock Management
**URL**: http://localhost:8000/admin/stock

Checklist:
- [ ] List menu & stok tampil
- [ ] Klik "Tambah" (IN)
- [ ] Input qty & note
- [ ] Submit → stok bertambah
- [ ] Klik "Kurangi" (OUT)
- [ ] Submit → stok berkurang
- [ ] Validasi stok cukup
- [ ] View logs → riwayat muncul

### ✅ Test 8: Sales Report
**URL**: http://localhost:8000/admin/reports/sales

Checklist:
- [ ] Summary cards tampil
- [ ] List pesanan tampil
- [ ] Total benar
- [ ] Klik "Export Excel" → download .xlsx
- [ ] Klik "Export PDF" → download .pdf

### ✅ Test 9: QR Code
**URL**: http://localhost:8000/admin/qrcode

Checklist:
- [ ] QR Code tampil
- [ ] URL ditampilkan
- [ ] Scan QR → buka menu
- [ ] Print button berfungsi

### ✅ Test 10: Logout
Checklist:
- [ ] Klik "Logout"
- [ ] Redirect ke login
- [ ] Session cleared
- [ ] Akses admin → redirect login

---

## 🐛 TROUBLESHOOTING CHECKLIST

### If Migration Fails:
- [ ] Database `cafe_db` sudah dibuat?
- [ ] Kredensial `.env` benar?
- [ ] MySQL service running?
- [ ] Port 3306 tidak bentrok?

### If Composer Install Fails:
- [ ] Koneksi internet aktif?
- [ ] Composer update: `composer self-update`
- [ ] Clear composer cache: `composer clear-cache`
- [ ] Coba lagi: `composer install`

### If Server Won't Start:
- [ ] Port 8000 kosong?
- [ ] Apache di XAMPP tidak running?
- [ ] Coba port lain: `php artisan serve --port=8080`

### If Login Fails:
- [ ] Email & password benar?
- [ ] Database seeded?
- [ ] Check users table di phpMyAdmin
- [ ] Password: "password" (tanpa quotes)

### If Images Not Showing:
- [ ] Folder `public/uploads/menus` ada?
- [ ] Folder writeable?
- [ ] Windows: `icacls public\uploads /grant Everyone:(OI)(CI)F /T`

### If QR Code Error:
- [ ] Install package: `composer require simplesoftwareio/simple-qrcode`
- [ ] Clear cache: `php artisan config:cache`
- [ ] Restart server

### General Issues:
```bash
# Clear all cache
php artisan optimize:clear

# Rebuild autoload
composer dump-autoload

# Check logs
tail -f storage/logs/laravel.log
```

---

## ✅ FINAL CHECKLIST

### Installation Complete When:
- [ ] Composer dependencies installed
- [ ] Database created & migrated
- [ ] Sample data seeded
- [ ] Upload folders created
- [ ] Server running successfully
- [ ] Customer menu accessible
- [ ] Admin login works
- [ ] All admin features working
- [ ] QR Code generates
- [ ] Reports export working

### Ready for Production When:
- [ ] Change admin passwords
- [ ] Set `APP_ENV=production` in .env
- [ ] Set `APP_DEBUG=false` in .env
- [ ] Configure proper database
- [ ] Setup backup strategy
- [ ] Test all features thoroughly
- [ ] Print QR codes for tables
- [ ] Train staff on system

---

## 📚 NEXT STEPS

After installation complete:

1. **Customize Menu**
   - [ ] Hapus menu sampel
   - [ ] Tambah menu cafe Anda
   - [ ] Upload foto real menu

2. **Setup Categories**
   - [ ] Sesuaikan kategori
   - [ ] Hapus yang tidak perlu

3. **Test Ordering**
   - [ ] Test dari HP
   - [ ] Scan QR Code
   - [ ] Process test order

4. **Print QR Codes**
   - [ ] Generate QR di admin
   - [ ] Print & laminating
   - [ ] Pasang di meja

5. **Train Staff**
   - [ ] Demo sistem ke staff
   - [ ] Latih update status order
   - [ ] Latih stock management

---

## 🎉 SUCCESS!

Jika semua checklist tercentang, instalasi BERHASIL!

**Sistem siap digunakan untuk:**
✅ Terima pesanan via QR Menu
✅ Kelola menu & stok
✅ Monitor pesanan
✅ Generate laporan

---

## 📞 NEED HELP?

Jika ada masalah:
1. ☑️ Baca file ini lagi dengan teliti
2. ☑️ Check SETUP.md untuk detail
3. ☑️ Lihat TROUBLESHOOTING section
4. ☑️ Check error log: `storage/logs/laravel.log`
5. ☑️ Pastikan requirements terpenuhi
6. ☑️ Google error message
7. ☑️ Ask for technical support

---

**Good Luck & Happy Coding! ☕**

Installation checklist by: Cafe QR Menu System
Version: 1.0
Date: 2026
