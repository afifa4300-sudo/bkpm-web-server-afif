# Dokumentasi & Panduan Praktikum Acara 30

**Pokok Bahasan**: Penguatan Keamanan Web Server (Hardening), Proteksi Berkas, dan Finalisasi Deployment  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 30 (puncak praktikum Workshop Sistem Informasi Web Server), mahasiswa melakukan **Web Server Hardening** (penguatan sistem keamanan) pada lingkungan produksi di cPanel Rumahweb:
1. **Disable Directory Browsing**: Mencegah pengunjung melihat struktur direktori saat berkas `index` tidak ditemukan melalui opsi `Options -Indexes` pada berkas `.htaccess`.
2. **Proteksi Berkas Sensitif**: Mencegah akses langsung dari peramban ke berkas konfigurasi, database dump (`.sql`), berkas log (`.log`), dan berkas tersembunyi (`.git`, `.env`).
3. **Penyembunyian Informasi Server (*Information Disclosure*)**: Menonaktifkan *Server Signature* dan menyamarkan error detail PHP di lingkungan *production* (`display_errors = Off`) agar potensi eksploitasi oleh penyerang dapat diminimalkan.
4. **Enkripsi Komunikasi (HTTPS & SSL Enforcement)**: Memastikan seluruh lalu lintas HTTP secara otomatis dialihkan ke koneksi aman terenkripsi (HTTPS).

---

## 2. Struktur Berkas Acara 30
```
acara30/
├── app/
│   ├── config/
│   │   └── Database.php       # Mode APP_ENV = 'production'
│   ├── controllers/
│   ├── core/
│   └── models/
├── database/
│   └── db_workshop.sql
├── public/
│   ├── .htaccess              # Skrip Hardening & Rewrite Rules
│   ├── index.php
│   ├── uploads/
│   │   └── .htaccess          # Pencegahan eksekusi skrip PHP di folder upload
│   └── views/
│       ├── dashboard.html
│       ├── login.html
│       └── login.js
└── README.md                  # Panduan penguatan keamanan & evaluasi rilis
```

---

## 3. Implementasi Web Server Hardening (`public/.htaccess`)
```apache
# Aktifkan Rewrite Engine
RewriteEngine On

# 1. Nonaktifkan Directory Browsing (Listing Folder)
Options -Indexes

# 2. Blokir Akses Langsung ke Berkas Sensitif (.env, .sql, .log, .git)
<FilesMatch "(\.env|\.sql|\.log|\.git)">
    Order allow,deny
    Deny from all
</FilesMatch>

# 3. Paksa Penggunaan HTTPS (SSL Redirection)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# 4. Front Controller Routing
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
```

### Proteksi Folder Uploads (`public/uploads/.htaccess`)
Mencegah penyerang mengeksekusi skrip PHP jahat yang disamarkan sebagai gambar:
```apache
# Nonaktifkan eksekusi PHP pada direktori upload
php_flag engine off
RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .phps
```

---

## 4. Evaluasi Akhir Sistem Produksi
- **URL Publik Terproteksi**: `https://alwiyaa.my.id/Afif/public/views/login.html`
- **Uji Directory Listing**: Membuka direktori tanpa index mengembalikan status `403 Forbidden`.
- **Uji Proteksi SQL**: Mengakses `database/db_workshop.sql` langsung dari URL browser mengembalikan pesan penolakan akses.
- **Uji SSL**: URL otomatis dialihkan ke protokol terenkripsi `https://`.

---

## 5. Kesimpulan Praktikum
Melalui Acara 30, mahasiswa telah menyelesaikan seluruh tahapan siklus hidup rekayasa web server (*Web Server Engineering Lifecycle*): mulai dari konsep dasar HTTP & OOP, arsitektur MVC, RESTful API, otentikasi JWT, pengujian Blackbox, hingga proses deployment, migrasi cloud hosting, dan penguatan keamanan (*Server Hardening*) di Rumahweb cPanel.
