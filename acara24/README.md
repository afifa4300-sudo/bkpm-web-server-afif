# Dokumentasi & Panduan Praktikum Acara 24

**Pokok Bahasan**: Integrasi Frontend Dasar: JavaScript Fetch API, Async/Await & CORS  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Dasar & Arsitektur
Pada Acara 24, antarmuka web client dibangun menggunakan HTML & JavaScript murni yang mengonsumsi endpoint backend REST API secara asinkronus (`fetch()` dengan `async/await`), tanpa memuat ulang seluruh halaman (*no full-page reload*).

### A. Kebijakan Keamanan CORS (Cross-Origin Resource Sharing)
Browser menerapkan *Same-Origin Policy*. Agar request JavaScript client dapat berkomunikasi dengan backend, ditambahkan header CORS pada Front Controller (`public/index.php`):
```php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
```

---

## 2. Struktur Berkas Acara 24
```
acara24/
├── app/
│   ├── config/Database.php
│   ├── core/ (Auth.php, autoload.php, Response.php, Router.php)
│   ├── models/ (Mahasiswa.php, User.php)
│   └── controllers/ (AuthController.php, MahasiswaController.php)
├── database/db_workshop.sql
├── docs/ (API_DOCUMENTATION.md, openapi.yaml, TEST_CASE.md)
├── public/
│   ├── .htaccess
│   ├── index.php         # Front Controller dengan Header CORS aktif
│   └── views/
│       ├── index.html    # Tampilan Client HTML Bootstrap
│       └── app.js        # Script Fetch Data Asinkronus
└── README.md
```

---

## 3. Fitur Tugas Praktik Mandiri
1. **Indikator Teks "Memuat data..."**: Elemen loader dan spinner Bootstrap ditampilkan saat proses request berlangsung, dan otomatis disembunyikan setelah data selesai diambil.
2. **Penanganan Kondisi Data Kosong**: Jika data array dari API kosong, sistem menampilkan alert *"Belum ada data"* di antarmuka.

---

## 4. Cara Pengujian
Buka URL berkas statis di peramban web:
`http://localhost/bkpm-web-server-afif/acara24/public/views/index.html`
Amati Network tab pada Browser Developer Tools untuk memverifikasi request HTTP `GET /mahasiswa` berhasil dengan status `200 OK` tanpa blokir CORS.
