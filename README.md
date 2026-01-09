# Aplikasi Gudang Berbasis Web

Aplikasi Gudang adalah sistem informasi berbasis web yang digunakan untuk mengelola persediaan barang di gudang secara terintegrasi. Sistem ini mendukung pengelolaan master data, transaksi barang, pengendalian stok, serta penyusunan laporan dan analisis.

Aplikasi dikembangkan menggunakan **Laravel Framework** dengan arsitektur **MVC (Model–View–Controller)** dan basis data **MySQL**.

---

## ✨ Fitur Utama

### 🔐 Autentikasi Pengguna
- Login menggunakan email dan password
- Akses dashboard sesuai peran pengguna (Admin / Staff)

### 📦 Master Data
- Kategori Produk
- Produk
- Varian Produk (SKU)
- Stok Barang

### 🔄 Transaksi
- Transaksi Barang Masuk
- Transaksi Barang Keluar
- Transaksi Retur Barang

### 📊 Manajemen Stok
- Kartu Stok (riwayat pergerakan stok)
- Stok Opname berbasis periode
- Penyesuaian stok otomatis

### 📑 Laporan
- Laporan transaksi
- Laporan kartu stok
- Analisis kenaikan harga
- Export laporan berdasarkan periode

---

## 🧭 User Flow Sistem

### Autentikasi
1. Pengguna mengakses aplikasi
2. Sistem menampilkan halaman login
3. Pengguna memasukkan kredensial
4. Sistem memvalidasi data
5. Pengguna diarahkan ke dashboard

### Master Data
- Pengguna memilih menu master data
- Sistem menampilkan data
- Pengguna dapat menambah, mengubah, atau menghapus data
- Perubahan disimpan ke database

### Transaksi Barang Masuk
- Input data transaksi dan item
- Sistem menyimpan transaksi
- Stok varian bertambah
- Kartu stok dicatat

### Transaksi Barang Keluar
- Input transaksi
- Sistem memvalidasi ketersediaan stok
- Stok varian berkurang
- Kartu stok dicatat

### Transaksi Retur
- Input data retur
- Sistem menyesuaikan stok
- Kartu stok dicatat

### Stok Opname
- Admin membuat periode opname
- Pengguna menginput stok fisik
- Sistem membandingkan stok sistem dan fisik
- Penyesuaian stok dilakukan otomatis

### Laporan
- Pengguna memilih periode
- Sistem menampilkan laporan
- Laporan dapat diekspor

---

## 🔄 Activity Diagram (Deskripsi Proses)

- **Login**  
  Mulai → Input kredensial → Validasi → Dashboard → Selesai

- **Transaksi Masuk**  
  Mulai → Input transaksi → Simpan item → Update stok → Catat kartu stok → Selesai

- **Transaksi Keluar**  
  Mulai → Input transaksi → Validasi stok → Update stok → Catat kartu stok → Selesai

- **Stok Opname**  
  Mulai → Buat periode → Input stok fisik → Penyesuaian stok → Selesai

---

## 📐 Data Flow Diagram (DFD)

### Context Diagram
**Entitas Eksternal**
- Pengguna (Admin / Staff)

**Sistem**
- Aplikasi Gudang

**Aliran Data**
- Data login
- Data master
- Data transaksi
- Data laporan

### DFD Level 0
**Proses Utama**
- Autentikasi Pengguna
- Pengelolaan Master Data
- Pengelolaan Transaksi
- Pengelolaan Stok
- Penyusunan Laporan

**Data Store**
- User
- Produk
- Varian Produk
- Transaksi
- Transaksi Item
- Kartu Stok
- Stok Opname

---

## 🗂 Entity Relationship Diagram (ERD)

### Entitas
- `users`
- `kategori_produks`
- `produks`
- `varian_produks`
- `transaksis`
- `transaksi_items`
- `kartu_stoks`
- `priode_stok_opnames`
- `item_stok_opnames`
- `transaksi_returs`
- `transaksi_retur_items`

### Relasi
- Kategori Produk **1..*** Produk
- Produk **1..*** Varian Produk
- Transaksi **1..*** Transaksi Item
- Varian Produk **1..*** Transaksi Item
- Varian Produk **1..*** Kartu Stok
- Priode Stok Opname **1..*** Item Stok Opname

---

## 🏗 Arsitektur Sistem

### Arsitektur Umum
- **Client**: Web Browser
- **Server Aplikasi**: Laravel
- **Database**: MySQL

### Pola Arsitektur
- MVC (Model–View–Controller)
- AJAX untuk data dinamis
- Export laporan melalui controller khusus

---

## 📌 Tujuan Dokumentasi

Dokumen dan README ini disusun untuk:
- Dokumentasi teknis proyek GitHub
- Memudahkan pengembangan lanjutan
- Mendukung proses pengujian
- Mempermudah audit sistem

---

## 👨‍💻 Teknologi yang Digunakan

- Laravel
- PHP
- MySQL
- HTML, CSS, JavaScript
- AJAX

---

