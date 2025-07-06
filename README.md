# 🎓 Aplikasi Peminjaman Laboratorium — Politeknik Negeri Bengkalis

Repositori ini merupakan implementasi **Aplikasi Peminjaman Laboratorium** berbasis web yang dikembangkan sebagai **Tugas Akhir** oleh mahasiswa Politeknik Negeri Bengkalis. Sistem ini ditujukan untuk mendukung proses peminjaman laboratorium secara digital oleh mahasiswa, serta memudahkan kepala laboratorium dalam memantau dan memverifikasi permintaan peminjaman.

---

## ✨ Fitur Utama

1. 🔐 **Otentikasi Dua Role**  
   Sistem memiliki dua peran pengguna:
   - **Mahasiswa** — Mengajukan permohonan peminjaman lab.
   - **Kepala Laboratorium** — Menerima, menyetujui, atau menolak permohonan.

2. 📥 **Login menggunakan NIM dan Email**  
   Mahasiswa login cukup menggunakan kombinasi **NIM** dan **email terdaftar**.

3. 🛡️ **Laravel Fortify**  
   Sistem keamanan login dibangun dengan **Laravel Fortify** untuk otentikasi yang aman dan fleksibel.

4. ⚙️ **Sistem Peminjaman Sederhana & Fleksibel**  
   Mahasiswa dapat memilih tanggal, waktu, dan laboratorium yang diinginkan. Permintaan disusun dengan alur yang intuitif dan efisien.

5. 🔔 **Notifikasi Real-Time**  
   Baik mahasiswa maupun kepala laboratorium mendapatkan notifikasi secara langsung saat terjadi perubahan status permohonan (misal: disetujui atau ditolak).

---

## 🚀 Cara Clone & Menjalankan Project

Berikut adalah langkah-langkah untuk menjalankan aplikasi secara lokal:

### 1. Clone Repository

```bash
git clone -b Laboratorium-Polbeng https://github.com/BimaFdilana/project-app-web-laravel.git
cd project-app-web-laravel
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Konfigurasi .Env

```bash
cp .env.example .env
```
lalu sesuaikan .env dengan database yang akan digunakan
```bash
APP_NAME=LabApp
APP_URL=http://localhost:8000

DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_id
PUSHER_APP_KEY=your_key
PUSHER_APP_SECRET=your_secret
```

### 4. Generate Key

```bash
php artisan key:generate
```

### 5. Migrate Database

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 6. Run Development Server

```bash
php artisan serve
```

### 7. Akses Aplikasi

Buka browser dan akses aplikasi di `http://localhost:8000`.


# 👥 Akun Default (Untuk Pengujian)

## Mahasiswa
NIM: 1234567890
Email: budi@pinlab.com
Password: password12345

## Kepala Labor
NIM: 0000000001
Email: admin@pinlab.com
Password: password12345



