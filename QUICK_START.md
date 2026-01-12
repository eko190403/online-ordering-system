# QUICK START GUIDE
# Panduan Cepat Sistem QR Menu Cafe

## 🚀 INSTALASI CEPAT (5 MENIT)

### Step 1: Install Dependencies
```bash
cd c:\xampp\htdocs\cafe
composer install
```

### Step 2: Setup Environment
```bash
copy .env.example .env
php artisan key:generate
```

### Step 3: Setup Database
1. Buat database `cafe_db` di phpMyAdmin
2. Edit `.env`:
```
DB_DATABASE=cafe_db
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Migrate & Seed
```bash
php artisan migrate
php artisan db:seed
```

### Step 5: Jalankan Server
```bash
php artisan serve
```

✅ **SELESAI!** Buka: http://localhost:8000

---

## 🔑 LOGIN ADMIN

**URL**: http://localhost:8000/login

**Akun 1:**
- Email: `admin1@cafe.com`
- Password: `password`

**Akun 2:**
- Email: `admin2@cafe.com`
- Password: `password`

---

## 📱 TESTING FITUR

### Test Customer (QR Menu)
1. Buka: http://localhost:8000
2. Klik menu untuk add to cart
3. Klik icon keranjang (pojok kanan bawah)
4. Klik "Pesan Sekarang"
5. Dapat kode order

### Test Admin Panel
1. Login: http://localhost:8000/login
2. **Dashboard**: Lihat statistik
3. **Pesanan**: Ubah status pesanan
4. **Menu**: Tambah menu baru dengan foto
5. **Stok**: Update stok IN/OUT
6. **Laporan**: Export Excel/PDF
7. **QR Code**: Print QR untuk meja

---

## 🎯 FITUR UTAMA

✅ QR Menu untuk customer
✅ Keranjang belanja interaktif  
✅ Order tanpa payment
✅ Admin dashboard
✅ Kelola menu & kategori
✅ Manajemen pesanan (masuk/diproses/selesai)
✅ Manajemen stok (IN/OUT + logs)
✅ Laporan penjualan (Excel & PDF)
✅ Generate & print QR Code
✅ Multi user admin (2 akun)

---

## 📂 STRUKTUR PENTING

```
cafe/
├── app/Controllers/     # Semua controller
├── app/Models/          # Database models
├── resources/views/     # Tampilan Blade
│   ├── menu/           # Customer menu
│   ├── admin/          # Admin panel
│   └── auth/           # Login
├── routes/web.php      # Semua route
├── database/migrations/ # Database schema
├── database/seeders/   # Sample data
└── public/uploads/     # Upload folder
```

---

## 🔧 TROUBLESHOOTING CEPAT

**Error: Class not found**
```bash
composer dump-autoload
```

**QR Code tidak muncul**
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:cache
```

**Clear semua cache**
```bash
php artisan optimize:clear
```

**Reset database**
```bash
php artisan migrate:fresh --seed
```
⚠️ Hati-hati: Ini hapus semua data!

---

## 📖 DOKUMENTASI LENGKAP

- **README.md** - Overview & instalasi lengkap
- **SETUP.md** - Panduan setup detail
- **FEATURES.md** - Dokumentasi semua fitur
- **QUICK_START.md** - Guide ini (quick start)

---

## ✨ TIPS

1. **Production**: Ganti password admin & set `APP_DEBUG=false`
2. **Backup**: Backup database secara berkala
3. **Upload Folder**: Pastikan `public/uploads/menus` writeable
4. **QR Print**: Cetak QR dari menu admin, tempel di meja
5. **Stock**: Update stok secara rutin

---

## 📊 DATA SAMPEL

Setelah `php artisan db:seed`, akan ada:

**Admin (2 akun)**:
- admin1@cafe.com / password
- admin2@cafe.com / password

**Kategori (5)**:
- Kopi
- Teh  
- Jus
- Makanan
- Snack

**Menu (12)**:
- Espresso (Rp 15.000)
- Cappuccino (Rp 20.000)
- Latte (Rp 22.000)
- Dan 9 menu lainnya...

---

## 🎉 SIAP DIGUNAKAN!

Sistem sudah lengkap dan siap dipakai. 

**Next Steps:**
1. Tambah menu sesuai cafe Anda
2. Upload foto menu
3. Print QR Code
4. Tempel QR di meja
5. Mulai terima order!

---

**Happy Ordering! ☕**

Butuh bantuan? Baca file dokumentasi lain atau cek `storage/logs/laravel.log` untuk error details.
