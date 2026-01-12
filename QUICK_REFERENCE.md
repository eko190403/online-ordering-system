# 📝 QUICK REFERENCE CARD
# Sistem QR Menu Cafe - Daily Operations

## 🔗 IMPORTANT URLS

### Customer/Public
- **QR Menu**: http://localhost:8000/

### Admin Panel
- **Login**: http://localhost:8000/login
- **Dashboard**: http://localhost:8000/admin
- **Orders**: http://localhost:8000/admin/orders
- **Menu**: http://localhost:8000/admin/menu
- **Categories**: http://localhost:8000/admin/categories
- **Stock**: http://localhost:8000/admin/stock
- **Reports**: http://localhost:8000/admin/reports/sales
- **QR Code**: http://localhost:8000/admin/qrcode

---

## 👤 DEFAULT LOGIN

**Admin 1:**
- Email: `admin1@cafe.com`
- Password: `password`

**Admin 2:**
- Email: `admin2@cafe.com`
- Password: `password`

⚠️ **PENTING**: Ganti password sebelum production!

---

## 🚀 START/STOP SERVER

### Start Server
```bash
cd c:\xampp\htdocs\cafe
php artisan serve
```
Server: http://localhost:8000

### Stop Server
Press: `Ctrl + C`

### Alternative Port
```bash
php artisan serve --port=8080
```

---

## 📋 COMMON COMMANDS

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Or Clear All:
```bash
php artisan optimize:clear
```

### Database
```bash
# Run migrations
php artisan migrate

# Reset & seed database (⚠️ HAPUS SEMUA DATA!)
php artisan migrate:fresh --seed

# Seed only
php artisan db:seed
```

### Composer
```bash
# Install packages
composer install

# Update packages
composer update

# Rebuild autoload
composer dump-autoload
```

---

## 🛠️ TROUBLESHOOTING

### Server won't start
```bash
# Check if port 8000 busy
netstat -ano | findstr :8000

# Use different port
php artisan serve --port=8080
```

### Permission errors
```bash
# Windows (Run as Admin)
icacls storage /grant Everyone:(OI)(CI)F /T
icacls bootstrap\cache /grant Everyone:(OI)(CI)F /T
```

### Database connection error
1. Check XAMPP MySQL is running
2. Verify .env database settings
3. Test connection in phpMyAdmin

### QR Code not showing
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:cache
```

### Images not displaying
1. Check folder exists: `public/uploads/menus`
2. Check permissions (must be writable)
3. Clear browser cache

---

## 📱 DAILY WORKFLOW

### 1. Opening (Pagi)
```bash
# Start XAMPP
- Start Apache
- Start MySQL

# Start Laravel
cd c:\xampp\htdocs\cafe
php artisan serve
```

### 2. Login Admin
- Buka: http://localhost:8000/login
- Login dengan akun admin

### 3. Check Orders
- Buka menu "Pesanan"
- Lihat order baru (status: Masuk)
- Update status → Diproses → Selesai

### 4. Update Stock
- Buka menu "Stok"
- Update stok yang habis (Stock IN)
- Monitor stok rendah (badge kuning/merah)

### 5. View Reports
- Buka menu "Laporan"
- Check penjualan hari ini
- Export Excel/PDF untuk arsip

### 6. Closing (Malam)
- Export laporan hari ini
- Backup database (opsional)
- Stop server (Ctrl+C)
- Stop XAMPP services

---

## 📊 ORDER STATUS FLOW

```
MASUK (Kuning)
    ↓ [Klik: Proses]
DIPROSES (Biru)
    ↓ [Klik: Selesai]
SELESAI (Hijau)
```

**Tips**: Update status secara real-time agar customer tahu progress pesanan

---

## 📦 STOCK MANAGEMENT

### Stock IN (Tambah Stok)
1. Buka menu "Stok"
2. Klik "Tambah" pada menu
3. Input jumlah masuk
4. Isi catatan (opsional)
5. Submit

### Stock OUT (Kurangi Stok)
1. Buka menu "Stok"
2. Klik "Kurangi" pada menu
3. Input jumlah keluar
4. Isi catatan (opsional)
5. Submit

### Check Stock Logs
- Menu "Stok" → "Riwayat Stok"
- Lihat history semua perubahan

---

## 🍽️ MENU MANAGEMENT

### Add New Menu
1. Menu "Menu" → "Tambah Menu"
2. Isi form:
   - Nama menu
   - Pilih kategori
   - Harga (angka saja, tanpa Rp)
   - Deskripsi
   - Upload foto (max 2MB)
3. Submit

### Edit Menu
1. Klik icon "Edit" (kuning)
2. Update data
3. Upload foto baru (opsional)
4. Submit

### Delete Menu
1. Klik icon "Delete" (merah)
2. Konfirmasi
3. Menu & foto terhapus

---

## 🏷️ CATEGORY MANAGEMENT

### Add Category
1. Menu "Kategori" → "Tambah Kategori"
2. Input nama kategori
3. Submit

### Edit/Delete
- Edit: icon kuning
- Delete: icon merah (dengan konfirmasi)

---

## 📈 REPORTS

### View Report
- Menu "Laporan"
- Lihat summary cards (total order, revenue)
- Scroll untuk detail table

### Export Excel
- Klik "Export Excel"
- File .xlsx akan download
- Buka di Microsoft Excel

### Export PDF
- Klik "Export PDF"
- File .pdf akan download
- Siap untuk print

---

## 🎯 QR CODE

### Generate QR
1. Menu "QR Code"
2. QR otomatis generate
3. Berisi URL: http://localhost:8000

### Print QR
1. Klik "Print QR Code"
2. Print dialog muncul
3. Print ke printer atau PDF
4. Laminating (opsional)
5. Tempel di meja cafe

**Tips**: Print beberapa QR untuk backup

---

## 🔒 SECURITY REMINDERS

### Do's ✅
- Ganti password default
- Logout setelah selesai
- Backup database rutin
- Update software reguler
- Monitor access logs

### Don'ts ❌
- Jangan share password
- Jangan login di PC umum
- Jangan skip logout
- Jangan expose database credentials
- Jangan delete backup

---

## 📞 EMERGENCY CONTACTS

### If System Down:
1. Check XAMPP services
2. Check error log: `storage/logs/laravel.log`
3. Restart server
4. Clear cache
5. Contact IT support

### Critical Issues:
- Database crash → Restore backup
- File corrupted → Re-deploy
- Hacked → Change passwords, check logs

---

## 💾 BACKUP STRATEGY

### Daily Backup (Recommended):
```bash
# Backup database
mysqldump -u root cafe_db > backup_2026-01-11.sql

# Backup uploads
copy public\uploads\* backup\uploads\
```

### Weekly Backup:
- Full database export
- Files backup (uploads folder)
- Store in external drive

---

## 🎓 TRAINING CHECKLIST

### New Admin Training:
- [ ] Login process
- [ ] Dashboard overview
- [ ] View orders
- [ ] Update order status
- [ ] Add/edit menu
- [ ] Manage categories
- [ ] Update stock
- [ ] View reports
- [ ] Export data
- [ ] Generate QR code
- [ ] Logout properly

---

## 📱 CUSTOMER GUIDE (QR Menu)

### For Staff to Explain:
1. **Scan QR** di meja dengan kamera HP
2. **Browse menu** - scroll atau filter kategori
3. **Pilih menu** - klik untuk add to cart
4. **Buka cart** - klik icon keranjang
5. **Review** - cek item & total
6. **Checkout** - klik "Pesan Sekarang"
7. **Save kode** - simpan kode order
8. **Wait** - tunggu pesanan diproses

---

## 🔢 KEYBOARD SHORTCUTS

### Browser:
- `Ctrl + R` - Refresh page
- `Ctrl + F5` - Hard refresh (clear cache)
- `Ctrl + Shift + Del` - Clear browser data

### Terminal:
- `Ctrl + C` - Stop server
- `Arrow Up` - Previous command
- `Tab` - Auto-complete

---

## 📝 DAILY CHECKLIST

### Morning:
- [ ] Start XAMPP
- [ ] Start server
- [ ] Login admin
- [ ] Check pending orders

### During Operation:
- [ ] Monitor new orders
- [ ] Update order status
- [ ] Check stock levels
- [ ] Respond to issues

### Evening:
- [ ] Export daily report
- [ ] Check all orders processed
- [ ] Update low stock
- [ ] Backup data (opsional)
- [ ] Logout
- [ ] Stop server

---

## 🌟 QUICK TIPS

1. **Keep browser open** on admin dashboard
2. **Refresh regularly** to see new orders
3. **Update status immediately** untuk customer satisfaction
4. **Monitor stock** agar tidak oversell
5. **Backup data** untuk keamanan
6. **Print multiple QR codes** untuk backup
7. **Train all staff** on basic operations
8. **Keep manual backup** process
9. **Check reports** untuk insights
10. **Maintain clean database** secara berkala

---

## ✅ SYSTEM STATUS

### Check System Health:
- [ ] Server running?
- [ ] Database connected?
- [ ] Orders processing?
- [ ] Stock updating?
- [ ] Reports generating?
- [ ] QR codes working?

**If all yes → System is healthy! ✅**

---

## 📞 CONTACT INFO

**System Admin**: [Your Contact]
**IT Support**: [Support Contact]
**Developer**: [Developer Contact]

---

**Sistem QR Menu Cafe - Quick Reference**
Version: 1.0 | Updated: January 2026

Keep this card handy for daily operations! 📌
