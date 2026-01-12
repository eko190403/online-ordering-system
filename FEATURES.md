# DOKUMENTASI FITUR
# Sistem QR Menu Cafe

## 🎯 RINGKASAN SISTEM

Aplikasi web untuk manajemen cafe yang memungkinkan pelanggan memesan via QR Menu dan admin mengelola operasional cafe.

---

## 📱 FITUR CUSTOMER (QR MENU)

### 1. QR Menu Scanner
- **Akses via QR Code**: Pelanggan scan QR Code untuk buka menu
- **Responsive Design**: Tampilan optimal di HP
- **URL**: http://localhost:8000/

### 2. Browse Menu
- **Tampilan Grid**: Menu ditampilkan dalam bentuk card
- **Informasi Lengkap**:
  - Nama menu
  - Harga
  - Deskripsi
  - Foto menu
  - Kategori
- **Filter Kategori**: Filter menu berdasarkan kategori

### 3. Keranjang Belanja
- **Add to Cart**: Klik menu untuk tambahkan ke keranjang
- **Floating Cart Button**: Icon keranjang di pojok kanan bawah
- **Cart Badge**: Jumlah item di keranjang
- **Manage Cart**:
  - Tambah/kurangi quantity
  - Hapus item
  - Lihat subtotal per item
  - Total keseluruhan

### 4. Checkout Pesanan
- **Tanpa Pembayaran Online**: Sistem hanya catat pesanan
- **Konfirmasi Order**: 
  - Generate kode order otomatis (ORD + timestamp)
  - Tampilkan kode order ke pelanggan
  - Modal konfirmasi sukses
- **Auto Calculate**: Total harga dihitung otomatis

---

## 👨‍💼 FITUR ADMIN PANEL

### 1. Dashboard
**URL**: `/admin`

**Statistik Real-time**:
- Total pesanan keseluruhan
- Pesanan masuk (belum diproses)
- Pesanan diproses
- Pesanan selesai
- Total menu
- Total kategori

**Widget Cards**: Dengan icon dan color coding

### 2. Kelola Pesanan
**URL**: `/admin/orders`

**Fitur**:
- Lihat semua pesanan dengan detail:
  - Kode order
  - Tanggal & waktu
  - List item pesanan
  - Total harga
  - Status order
- **Update Status Order**:
  - Masuk (badge kuning)
  - Diproses (badge biru) 
  - Selesai (badge hijau)
- Status flow: Masuk → Diproses → Selesai
- Urutan: Terbaru di atas

### 3. Kelola Menu
**URL**: `/admin/menu`

**Fitur CRUD Menu**:
- **Tambah Menu**:
  - Nama menu
  - Kategori (dropdown)
  - Harga
  - Deskripsi
  - Upload foto (max 2MB)
- **Edit Menu**:
  - Update semua field
  - Ganti foto (opsional)
  - Auto delete foto lama saat ganti
- **Hapus Menu**:
  - Konfirmasi delete
  - Auto delete foto terkait
- **Tampilan Table**:
  - Preview foto
  - Semua info menu
  - Action buttons (Edit & Delete)

### 4. Kelola Kategori
**URL**: `/admin/categories`

**Fitur CRUD Kategori**:
- **Tambah Kategori**: Input nama kategori
- **Edit Kategori**: Update nama
- **Hapus Kategori**: Dengan konfirmasi
- **Info Tambahan**: Jumlah menu per kategori

### 5. Manajemen Stok
**URL**: `/admin/stock`

**Fitur Stock Management**:
- **View Stock**: 
  - List semua menu
  - Jumlah stok tersedia
  - Color badge:
    - Hijau: > 10 unit
    - Kuning: 1-10 unit
    - Merah: 0 unit
- **Update Stock IN** (Tambah Stok):
  - Input jumlah
  - Catatan/keterangan
- **Update Stock OUT** (Kurangi Stok):
  - Input jumlah
  - Validasi stok cukup
  - Catatan/keterangan
- **Stock Logs** (`/admin/stock/logs`):
  - Riwayat semua perubahan stok
  - Tanggal & waktu
  - Menu
  - Type (IN/OUT)
  - Jumlah
  - Catatan
  - Pagination (50 per halaman)

### 6. Laporan Penjualan
**URL**: `/admin/reports/sales`

**Fitur Reporting**:
- **Summary Cards**:
  - Total pesanan
  - Pesanan selesai
  - Total pendapatan (hanya dari order selesai)
- **Detail Table**:
  - Semua data pesanan
  - Filter by status
  - Total keseluruhan
- **Export Excel** (`/admin/reports/sales/excel`):
  - Format .xlsx
  - Include semua data order
- **Export PDF** (`/admin/reports/sales/pdf`):
  - Format .pdf
  - Print-ready report

### 7. Generate QR Code
**URL**: `/admin/qrcode`

**Fitur QR**:
- **Generate QR Code**: 
  - QR berisi URL menu customer
  - Size 300x300 pixel
- **Display**:
  - Tampilkan QR code
  - Show URL text
- **Print QR Code**: 
  - Button print
  - Print-friendly CSS
  - Untuk ditempel di meja cafe

### 8. Authentication
**URL**: `/login`

**Fitur Auth**:
- **Login Form**:
  - Email
  - Password
  - Validation
- **Session Management**:
  - Remember token
  - Auto regenerate session
- **Logout**: Clear session
- **Middleware Protected**: Semua route admin butuh login

---

## 🗄️ DATABASE SCHEMA

### users
```
- id (PK)
- name
- email (unique)
- password (hashed)
- role (enum: 'admin', 'kasir')
- timestamps
```

### categories
```
- id (PK)
- name
- timestamps
```

### menus
```
- id (PK)
- name
- price (decimal)
- description (text, nullable)
- category_id (FK → categories)
- image (string, nullable)
- timestamps
```

### orders
```
- id (PK)
- order_code (string, unique)
- total_price (decimal)
- status (enum: 'masuk', 'diproses', 'selesai')
- timestamps
```

### order_items
```
- id (PK)
- order_id (FK → orders)
- menu_id (FK → menus)
- qty (integer)
- price (decimal)
- subtotal (decimal)
- timestamps
```

### stocks
```
- id (PK)
- menu_id (FK → menus, unique)
- quantity (integer, default: 0)
- timestamps
```

### stock_logs
```
- id (PK)
- menu_id (FK → menus)
- type (enum: 'IN', 'OUT')
- qty (integer)
- note (string, nullable)
- timestamps
```

---

## 🔐 KEAMANAN

### Authentication
- Laravel built-in auth
- Bcrypt password hashing
- Session-based authentication

### Authorization
- Middleware: `auth` untuk semua admin routes
- Role-based access (prepared for future)

### Security Features
- CSRF protection (semua form)
- SQL injection protection (Eloquent ORM)
- XSS protection (Blade templating)
- Input validation (semua form)
- File upload validation (type & size)

---

## 🎨 UI/UX FEATURES

### Customer Side
- **Bootstrap 5**: Modern & responsive
- **Font Awesome Icons**: Rich iconography
- **Color Scheme**: Fresh & appetizing
- **Mobile First**: Optimized untuk HP
- **Smooth Animations**: Card hover effects
- **Modal Popups**: Cart & confirmation
- **jQuery**: Interactive features

### Admin Side
- **Sidebar Navigation**: Easy access
- **Dashboard Cards**: Color-coded stats
- **Data Tables**: Clean & readable
- **Modal Forms**: Add/edit inline
- **Alert Messages**: Success/error feedback
- **Responsive**: Works on tablet/desktop
- **Print Styles**: QR code printing

---

## 📊 DATA FLOW

### Customer Order Flow
```
1. Customer scan QR → Load menu
2. Browse & select menu → Add to cart
3. Review cart → Checkout
4. Order created → Get order code
5. Status: MASUK
```

### Admin Order Processing
```
1. View new orders (MASUK)
2. Click "Proses" → Status: DIPROSES
3. Prepare order
4. Click "Selesai" → Status: SELESAI
5. Order completed
```

### Stock Management Flow
```
1. View current stock
2. Add stock (IN):
   - Stock += qty
   - Log created
3. Reduce stock (OUT):
   - Validate qty
   - Stock -= qty
   - Log created
4. View history in logs
```

---

## 🚀 TEKNOLOGI

### Backend
- **Laravel 12**: PHP Framework
- **PHP 8.2+**: Programming language
- **MySQL**: Database
- **Eloquent ORM**: Database abstraction

### Frontend
- **Blade**: Templating engine
- **Bootstrap 5**: CSS framework
- **jQuery**: JavaScript library
- **Font Awesome**: Icons

### Libraries
- **Maatwebsite Excel**: Excel export
- **DomPDF**: PDF generation
- **Simple QR Code**: QR generation

---

## 📈 SCALABILITY

### Future Enhancements Siap:
- Multi-role (admin, kasir, manajer)
- Customer accounts
- Payment gateway integration
- Real-time order notifications
- Kitchen display system
- Inventory management
- Customer loyalty program
- Order history tracking
- Analytics dashboard

### Database Design:
- Normalized structure
- Foreign key constraints
- Scalable relationships
- Index optimization ready

---

## ✅ CHECKLIST FITUR

**Customer:**
- [x] QR Menu Scanner
- [x] Tampilan daftar menu (nama, harga, deskripsi, foto)
- [x] Kategori menu
- [x] Sistem pemesanan tanpa pembayaran online
- [x] Keranjang belanja interaktif
- [x] Status pesanan: masuk, diproses, selesai

**Admin:**
- [x] Login multi user (2 akun admin)
- [x] Dashboard dengan statistik
- [x] Kelola menu (tambah, edit, hapus)
- [x] Kelola kategori
- [x] Lihat pesanan
- [x] Ubah status pesanan
- [x] Laporan penjualan
- [x] Export Excel & PDF
- [x] Manajemen stok (IN/OUT)
- [x] Riwayat stok
- [x] Generate QR Code
- [x] Multi user/multi role

**Bonus Features:**
- [x] Responsive design
- [x] Image upload untuk menu
- [x] Real-time cart calculation
- [x] Order code generation
- [x] Stock validation
- [x] Beautiful UI/UX
- [x] Print QR Code
- [x] Complete documentation

---

## 📞 SUPPORT

Untuk bantuan teknis atau pertanyaan:
1. Baca README.md
2. Baca SETUP.md untuk instalasi
3. Check troubleshooting section
4. Review error logs: `storage/logs/laravel.log`

---

**Status: COMPLETE & READY TO USE** ✅

Semua fitur sudah diimplementasi dan siap digunakan!
