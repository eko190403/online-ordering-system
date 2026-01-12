# PANDUAN INSTALASI & SETUP
# Sistem QR Menu Cafe

## LANGKAH-LANGKAH INSTALASI

### 1. PERSIAPAN AWAL

Pastikan XAMPP sudah terinstall dan berjalan:
- Buka XAMPP Control Panel
- Start Apache
- Start MySQL

### 2. INSTALL COMPOSER DEPENDENCIES

Buka Command Prompt/Terminal di folder project:
```bash
cd c:\xampp\htdocs\cafe
composer install
```

Jika composer belum terinstall, download di: https://getcomposer.org/

### 3. SETUP FILE ENVIRONMENT

```bash
# Copy file .env.example menjadi .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. KONFIGURASI DATABASE

1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Buat database baru dengan nama: `cafe_db`
3. Edit file `.env` sesuaikan:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafe_db
DB_USERNAME=root
DB_PASSWORD=
```

### 5. MIGRASI DATABASE

Jalankan migrasi untuk membuat tabel-tabel:
```bash
php artisan migrate
```

### 6. SEED DATA AWAL

Isi database dengan data sampel (kategori, menu, admin):
```bash
php artisan db:seed
```

Data yang akan dibuat:
- 2 akun admin
- 5 kategori menu
- 12 menu sampel

### 7. BUAT FOLDER UPLOAD

```bash
# Untuk Windows
mkdir public\uploads
mkdir public\uploads\menus

# Untuk Linux/Mac
mkdir -p public/uploads/menus
```

### 8. JALANKAN SERVER

```bash
php artisan serve
```

Server akan berjalan di: http://localhost:8000

## LOGIN ADMIN

Setelah setup selesai, login dengan akun:

**Admin 1:**
- URL: http://localhost:8000/login
- Email: admin1@cafe.com
- Password: password

**Admin 2:**
- URL: http://localhost:8000/login
- Email: admin2@cafe.com
- Password: password

## TESTING FITUR

### 1. Test QR Menu (Customer)
- Buka: http://localhost:8000
- Klik menu untuk menambahkan ke keranjang
- Klik icon keranjang untuk checkout
- Pesan dan dapatkan kode order

### 2. Test Admin Panel
- Login ke: http://localhost:8000/login
- Dashboard: lihat statistik
- Pesanan: ubah status pesanan
- Menu: tambah/edit/hapus menu
- Kategori: kelola kategori
- Stok: update stok IN/OUT
- Laporan: lihat & export laporan
- QR Code: generate & print QR

## TROUBLESHOOTING

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Permission denied" (storage)
```bash
# Windows (Run as Administrator)
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### QR Code tidak muncul
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:cache
```

### Gambar menu tidak tampil
Pastikan folder `public/uploads/menus` ada dan memiliki permission write

### Error 500 setelah login
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database connection error
- Pastikan MySQL di XAMPP sudah running
- Cek konfigurasi `.env` sudah benar
- Pastikan database `cafe_db` sudah dibuat

## FITUR LENGKAP

✅ **QR Menu untuk Customer**
   - Scan QR Code via HP
   - Browse menu dengan foto
   - Filter kategori
   - Keranjang belanja
   - Checkout pesanan

✅ **Admin Panel**
   - Dashboard statistik
   - Kelola pesanan (masuk/diproses/selesai)
   - CRUD Menu dengan upload foto
   - CRUD Kategori
   - Manajemen stok (IN/OUT)
   - Laporan penjualan
   - Export Excel & PDF
   - Generate QR Code
   - Multi user/role (2 admin)

## STRUKTUR DATABASE

**users** - Akun admin
- id, name, email, password, role

**categories** - Kategori menu
- id, name

**menus** - Data menu
- id, name, price, description, category_id, image

**orders** - Pesanan
- id, order_code, total_price, status

**order_items** - Detail pesanan
- id, order_id, menu_id, qty, price, subtotal

**stocks** - Stok menu
- id, menu_id, quantity

**stock_logs** - Riwayat stok
- id, menu_id, type (IN/OUT), qty, note

## TIPS PENGGUNAAN

1. **Untuk Production:**
   - Ganti password admin default
   - Set `APP_DEBUG=false` di .env
   - Set `APP_ENV=production` di .env
   - Backup database secara berkala

2. **Menambah Admin Baru:**
   ```bash
   php artisan tinker
   ```
   ```php
   use App\Models\User;
   use Illuminate\Support\Facades\Hash;
   
   User::create([
       'name' => 'Admin Baru',
       'email' => 'adminbaru@cafe.com',
       'password' => Hash::make('password123'),
       'role' => 'admin',
   ]);
   ```

3. **Reset Database:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   ⚠️ Peringatan: Ini akan menghapus semua data!

4. **Maintenance Mode:**
   ```bash
   # Aktifkan
   php artisan down
   
   # Matikan
   php artisan up
   ```

## DUKUNGAN

Jika mengalami masalah:
1. Cek error log di `storage/logs/laravel.log`
2. Pastikan semua requirements terpenuhi
3. Ikuti troubleshooting di atas

---

Selamat menggunakan Sistem QR Menu Cafe! ☕
