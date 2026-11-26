# Dokumentasi & Panduan Praktikum Acara 29

**Pokok Bahasan**: Migrasi Database Produksi, Manajemen Izin Berkas (File Permissions), dan Pengujian Integrasi Cloud  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 29, mahasiswa melakukan manajemen lanjutan pada server hosting produksi:
1. **Migrasi Database Relasional**: Mengelola eksport dan impor skema tabel `users` dan `mahasiswa` pada phpMyAdmin cPanel, serta memastikan integritas relasi foreign key berjalan tanpa kendala.
2. **Manajemen Izin Berkas (File & Directory Permissions)**: Mengatur hak akses Linux (CHMOD) di cPanel File Manager:
   - Direktori biasa: `755` (`rwxr-xr-x`)
   - Berkas PHP & skrip: `644` (`rw-r--r--`)
   - Direktori upload dinamis (`public/uploads/`): `755` atau `775` agar proses penyimpanan citra oleh server Apache (*user `nobody` / `daemon`*) diizinkan.
3. **Pengujian Integrasi Cloud End-to-End**:
   - Uji login pengguna (`POST /login`).
   - Uji pemuatan daftar mahasiswa secara asinkronus (`GET /mahasiswa`).
   - Uji upload foto profil mahasiswa ke direktori cloud hosting.

---

## 2. Struktur Berkas Acara 29
```
acara29/
├── app/
│   ├── config/
│   │   └── Database.php
│   ├── controllers/
│   ├── core/
│   └── models/
├── database/
│   └── db_workshop.sql
├── public/
│   ├── .htaccess
│   ├── index.php
│   ├── uploads/               # Direktori penyimpanan media (CHMOD 755)
│   └── views/
│       ├── dashboard.html
│       ├── login.html
│       └── login.js
└── README.md                  # Panduan migrasi & pengujian integrasi hosting
```

---

## 3. Konfigurasi Izin Akses (Permissions) di cPanel
Melalui File Manager cPanel, lakukan verifikasi atribut permission:
- `app/` -> `0755`
- `app/config/Database.php` -> `0644` (mencegah penulisan dari luar)
- `public/uploads/` -> `0755` (mengizinkan penulisan berkas citra via HTTP multipart POST)
- `public/.htaccess` -> `0644`

---

## 4. Pengujian Asinkronus pada Live Domain
Pengujian dilakukan langsung pada peramban web:
- **URL Login**: `https://alwiyaa.my.id/Afif/public/views/login.html`
- **URL Dashboard**: `https://alwiyaa.my.id/Afif/public/views/dashboard.html`
- **Uji Coba**:
  1. Masuk menggunakan akun `admin` / `admin123`.
  2. Buka tab Developer Tools (F12) -> Console & Network.
  3. Verifikasi HTTP Header:
     - `Status Code: 200 OK`
     - `Content-Type: application/json`
     - `Access-Control-Allow-Origin: *`
  4. Tambah data mahasiswa dan unggah file foto. Foto profil harus berhasil tersimpan ke folder `uploads/` di cPanel dan muncul pada tabel dengan thumbnail yang benar.

---

## 5. Kesimpulan Praktikum
Migrasi basis data dan penyesuaian hak akses berkas di hosting produksi merupakan tahap krusial dalam siklus rilis web server. Dengan konfigurasi izin yang tepat, aplikasi mampu menjalankan operasi I/O file citra secara stabil dan aman.
