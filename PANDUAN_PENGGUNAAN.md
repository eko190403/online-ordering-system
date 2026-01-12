# 📱 PANDUAN PENGGUNAAN SISTEM QR MENU
## Cafe D.Villa Lampung

---

## 🎯 **APA ITU SISTEM INI?**

Sistem QR Menu adalah aplikasi web yang memudahkan customer memesan makanan/minuman langsung dari HP mereka dengan scan QR Code, tanpa perlu antri ke kasir.

**Mudahnya:**
1. Customer scan QR Code → Buka menu di HP
2. Pilih menu → Masukkan keranjang → Checkout
3. Pesanan langsung masuk ke dapur → Selesai!

---

## 👥 **UNTUK CUSTOMER (Pembeli)**

### **Cara Pesan:**

**1. Scan QR Code**
   - Scan QR Code di meja cafe pakai kamera HP
   - Atau buka link: http://192.168.1.9:8000

**2. Pilih Menu**
   - Lihat-lihat menu yang tersedia
   - Cari menu pakai kotak pencarian
   - Filter berdasarkan kategori (Makanan/Minuman/Snack)
   - Klik menu untuk lihat detail & foto

**3. Tambah ke Keranjang**
   - Klik tombol hijau "Tambah ke Keranjang"
   - Atur jumlah pesanan (+ atau -)
   - Lihat total harga di keranjang

**4. Checkout**
   - Klik tombol keranjang hijau (kanan bawah)
   - Isi:
     - Nama Anda
     - Nomor Meja (lihat di meja)
     - Pilih Pembayaran: Cash atau Transfer
     - Tulis catatan (opsional): "Pedas sedang" atau "Tanpa es"
   - Klik "Pesan Sekarang"

**5. Bayar (jika pilih Transfer/QRIS)**
   - Muncul nomor rekening SeaBank
   - Scan QR Code atau salin nomor: 901567615382
   - Transfer sesuai jumlah total
   - Simpan bukti transfer
   - Tunjukkan bukti ke kasir

**6. Lihat Status Pesanan**
   - Tombol ungu "Lihat Pesanan" muncul di kanan bawah
   - Klik untuk cek status real-time:
     - 🟢 **Diterima** - Pesanan masuk sistem
     - 🔵 **Diproses** - Dapur sedang masak
     - ✅ **Selesai** - Silakan ambil pesanan!

### **Fitur Customer:**
- ✅ Menu lengkap dengan foto & harga
- ✅ Pencarian cepat
- ✅ Keranjang belanja
- ✅ Catatan pesanan (minta level pedas, dll)
- ✅ Pilih pembayaran Cash/Transfer
- ✅ Tracking pesanan real-time
- ✅ Notifikasi otomatis saat selesai

---

## 👨‍💼 **UNTUK ADMIN (Pemilik/Kasir Cafe)**

### **Login Admin:**
1. Buka: http://192.168.1.9:8000/login
2. Masukkan email & password
3. Klik "Login"

### **Menu Admin:**

#### **📊 1. DASHBOARD**
Halaman utama yang menampilkan:
- Total pesanan (masuk, diproses, selesai)
- Pendapatan hari ini & total
- Menu terlaris (top 5)
- Jam tersibuk (kapan customer paling banyak)
- Grafik pendapatan 7 hari terakhir

**Gunanya:** Pantau performa bisnis secara real-time

---

#### **📋 2. KELOLA PESANAN**
Melihat semua pesanan yang masuk:

**Informasi yang ditampilkan:**
- Kode pesanan (ORD12345)
- Nama customer
- Nomor meja
- Menu yang dipesan
- Total harga
- Status pembayaran (Lunas/Pending)
- Status pesanan (Masuk/Diproses/Selesai)

**Aksi yang bisa dilakukan:**
- ✅ **Proses** - Ubah status jadi "Diproses" (dapur mulai masak)
- ✅ **Selesai** - Ubah status jadi "Selesai" (pesanan siap diambil)
- 💰 **Konfirmasi Bayar** - Konfirmasi pembayaran transfer (cek bukti dulu)
- 🖨️ **Print** - Cetak struk untuk kasir/dapur

**Cara Kerja:**
1. Pesanan baru masuk → Status "Diproses" otomatis
2. Klik "Selesai" → Customer dapat notifikasi
3. Jika transfer → Cek bukti → Klik "Konfirmasi Bayar"

---

#### **🍽️ 3. KELOLA MENU**
Mengatur menu makanan/minuman:

**Yang bisa dilakukan:**
- ➕ **Tambah Menu Baru**
  - Nama menu
  - Kategori (Makanan/Minuman/Snack)
  - Harga
  - Deskripsi
  - Upload foto (max 2MB, hanya JPG/PNG)

- ✏️ **Edit Menu**
  - Ubah harga, nama, foto, dll
  
- 🗑️ **Hapus Menu**
  - Hapus menu yang tidak dijual lagi
  - Konfirmasi dulu sebelum hapus

**Tips:** Upload foto yang menarik agar customer tertarik pesan!

---

#### **📦 4. KELOLA STOK**
Mengatur ketersediaan menu:

**Fitur:**
- Set stok tersedia/habis
- Update jumlah stok
- Stok otomatis berkurang saat ada pesanan
- Log history stok masuk/keluar

**Cara Kerja:**
- Customer pesan Nasi Goreng (stok 10) → Otomatis jadi 9
- Stok habis → Menu muncul "HABIS" di customer
- Tambah stok baru → Customer bisa pesan lagi

---

#### **📈 5. LAPORAN PENJUALAN**
Melihat laporan detail penjualan:

**Filter Laporan:**
- Semua waktu
- Hari ini
- Per bulan (pilih bulan & tahun)
- Per tahun

**Informasi yang ditampilkan:**
- Total pendapatan
- Total pesanan
- Rata-rata per pesanan
- Detail setiap transaksi (tanggal, customer, menu, harga, meja, pembayaran)

**Export Data:**
- 📊 **Excel** - Download file .xlsx (bisa dibuka di Microsoft Excel)
- 📄 **PDF** - Download file PDF (bisa di-print)

**Gunanya:** Untuk laporan keuangan bulanan/tahunan

---

#### **🔐 6. KEAMANAN**
Sistem sudah dilengkapi:
- ✅ Login wajib untuk admin
- ✅ Session timeout (auto logout 2 jam)
- ✅ Rate limiting (anti brute force)
- ✅ Validasi input (anti hacker)
- ✅ File upload aman (hanya gambar)

---

#### **💾 7. BACKUP DATABASE**
Backup otomatis data penting:

**Cara Manual Backup:**
```
Buka Command Prompt (CMD) di folder cafe
Ketik: php artisan db:backup
Enter
```

**Hasil:**
- File backup tersimpan di: `storage/app/backups/`
- Format: `backup_cafe_2026-01-10_213008.sql`
- Auto delete backup lebih dari 7 hari

**Tips:** Backup setiap hari atau seminggu sekali!

---

## 🎨 **FITUR TAMBAHAN**

### **Untuk Customer:**
1. **Jam Operasional**
   - Sistem cek jam buka/tutup otomatis
   - Customer tidak bisa pesan saat tutup

2. **Catatan Pesanan**
   - Bisa tulis permintaan khusus
   - "Pedas level 5", "Tanpa bawang", dll

3. **Tracking Pesanan**
   - Tombol "Lihat Pesanan" tetap ada meskipun tutup HP
   - Auto update status real-time
   - Notifikasi saat pesanan selesai

### **Untuk Admin:**
1. **Dashboard Analytics**
   - Menu terlaris (jualan paling laku)
   - Jam tersibuk (kapan ramai)
   - Grafik pendapatan mingguan

2. **Print Struk**
   - Format thermal printer (58mm/80mm)
   - Otomatis buka dialog print
   - Bisa print untuk dapur & customer

3. **Konfirmasi Pembayaran**
   - Cek bukti transfer customer
   - Klik "Konfirmasi Bayar" → Status jadi Lunas

---

## ❓ **TANYA JAWAB (FAQ)**

### **Customer:**

**Q: QR Code tidak bisa dibuka?**
A: Pastikan HP terhubung ke WiFi cafe atau tanya WiFi password

**Q: Menu yang saya mau HABIS, kapan ready?**
A: Tanya langsung ke kasir, biasanya restok hari berikutnya

**Q: Saya sudah transfer tapi status masih Pending?**
A: Tunjukkan bukti transfer ke kasir untuk dikonfirmasi

**Q: Bisa cancel pesanan?**
A: Hubungi kasir langsung, sistem belum ada fitur cancel otomatis

### **Admin:**

**Q: Lupa password admin?**
A: Hubungi developer atau reset via database langsung

**Q: Stok tidak berkurang otomatis?**
A: Pastikan menu sudah ada di menu "Kelola Stok", jika belum tambahkan dulu

**Q: Export laporan error?**
A: Cek koneksi internet & pastikan ada data di periode yang dipilih

**Q: Customer komplain pesanan tidak masuk?**
A: Cek di menu "Kelola Pesanan", mungkin customer tidak klik "Pesan Sekarang"

---

## 📞 **KONTAK SUPPORT**

Jika ada masalah teknis atau butuh bantuan:
- 📧 Email: admin@cafe-dvilla.com
- 📱 WhatsApp: 0821-xxxx-xxxx
- 🕐 Jam kerja: Senin-Jumat 08:00-17:00

---

## 🎯 **KEUNTUNGAN SISTEM INI**

### **Untuk Bisnis:**
- ✅ **Efisien** - Customer pesan sendiri, kasir fokus pada pembayaran
- ✅ **Cepat** - Pesanan langsung ke dapur, tidak perlu tulis manual
- ✅ **Akurat** - Tidak ada salah catat pesanan
- ✅ **Modern** - Image profesional dengan teknologi QR
- ✅ **Laporan** - Data penjualan tercatat rapi untuk analisa

### **Untuk Customer:**
- ✅ **Praktis** - Pesan dari meja, tidak perlu antri
- ✅ **Jelas** - Lihat foto & harga sebelum pesan
- ✅ **Transparansi** - Tracking pesanan real-time
- ✅ **Fleksibel** - Bisa tambah catatan khusus

---

## 🚀 **TIPS MAKSIMALKAN SISTEM**

1. **Pasang QR Code di setiap meja** - Buat sticker/standing banner
2. **Update foto menu** - Foto menarik = lebih banyak pesanan
3. **Cek laporan rutin** - Tahu menu laris & jam ramai
4. **Backup data berkala** - Jaga keamanan data bisnis
5. **Pantau stok harian** - Update stok sebelum buka cafe
6. **Konfirmasi transfer cepat** - Customer happy, repeat order naik

---

**🎉 Selamat menggunakan Sistem QR Menu Cafe D.Villa Lampung!**

*Sistem ini dibuat untuk mempermudah operasional cafe dan meningkatkan kepuasan customer. Semoga bisnis semakin lancar!* ☕✨
