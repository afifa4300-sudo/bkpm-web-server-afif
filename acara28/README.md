# Dokumentasi & Panduan Praktikum Acara 28

**Pokok Bahasan**: Pengantar Deployment, Manajemen Hosting (Clientzone Rumahweb), dan Konfigurasi Domain
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A

---

## 1. Deskripsi Praktikum

Pada Acara 28, mahasiswa mempelajari siklus transisi aplikasi web dari lingkungan lokal (*local development environment / localhost*) menuju lingkungan produksi (*production hosting environment*):

1. **Layanan Cloud Hosting & Domain**: Memahami pemilihan paket hosting, pengelolaan DNS (*Domain Name System*), Nameserver, dan aktivasi sertifikat SSL (*Secure Sockets Layer*) melalui Clientzone Rumahweb.
2. **Domain & Direktori Kerja Publik**: Aplikasi Sistem Informasi Akademik dikonfigurasi dan diarahkan ke domain publik:
   - **Live URL**: `https://alwiyaa.my.id/Afif/public/views/login.html`
3. **Persiapan Berkas Produksi**:
   - Menghapus berkas cache dan pengujian lokal sementara.
   - Memastikan struktur perizinan direktori (*permissions*) dan arsitektur case-sensitive pada lingkungan sistem operasi Linux/cPanel.

---

## 2. Struktur Berkas Acara 28

```
acara28/
├── app/
│   ├── config/
│   │   └── Database.php       # Konfigurasi koneksi MySQL cPanel (Production)
│   ├── controllers/
│   │   ├── AuthController.php
│   │   └── MahasiswaController.php
│   ├── core/
│   │   ├── Auth.php
│   │   ├── Response.php
│   │   └── Router.php
│   └── models/
│       ├── Mahasiswa.php
│       └── User.php
├── database/
│   └── db_workshop.sql        # Skema database & data seeding untuk phpMyAdmin cPanel
├── public/
│   ├── .htaccess              # Konfigurasi rewrite engine Apache di hosting
│   ├── index.php              # Front Controller & CORS Headers
│   ├── uploads/               # Direktori citra mahasiswa (Permission: 755)
│   └── views/
│       ├── app.js
│       ├── dashboard.html     # Dashboard SPA interaktif
│       ├── login.html         # Form autentikasi
│       └── login.js
└── README.md                  # Panduan deployment & hosting Acara 28
```

---

## 3. Langkah-Langkah Deployment ke Rumahweb & cPanel

### A. Pengelolaan Clientzone & cPanel

1. Akses portal **Clientzone Rumahweb** dan masuk ke **cPanel Hosting**.
2. Buka menu **File Manager** -> arahkan ke `public_html/`.
3. Buat subfolder proyek (misal: `Afif/`).
4. Unggah arsip berkas zip proyek Sistem Informasi Akademik dan ekstrak di dalam folder tersebut.

### B. Konfigurasi Basis Data di cPanel

1. Masuk ke menu **cPanel > MySQL® Databases**.
2. Buat database baru (misal: `alwiyaam_dbworkshop`).
3. Buat pengguna MySQL baru dan generate kata sandi yang kuat.
4. Tambahkan pengguna ke database dengan mencentang **ALL PRIVILEGES**.
5. Buka **phpMyAdmin** di cPanel -> pilih database baru -> klik tab **Import** -> pilih berkas `database/db_workshop.sql` -> klik **Go**.

### C. Penyesuaian `app/config/Database.php`

Perbarui konstanta database sesuai kredensial cPanel:

```php
private const HOST = 'localhost';
private const NAME = 'alwiyaam_dbworkshop';
private const USER = 'alwiyaam_dbuser';
private const PASSWORD = 'Password_Database_cPanel!';
private const CHARSET = 'utf8mb4';

public const APP_ENV = 'production';
```

---

## 4. Pengujian & Verifikasi Live Deployment

1. Buka browser dan akses alamat live:
   - c
2. Protokol HTTPS (Gembok Hijau / Aman) membuktikan sertifikat SSL telah aktif dengan sempurna.
3. Form login terhubung ke backend cPanel, menerbitkan JWT token, dan menyimpan sesi ke `localStorage`.

---

## 5. Kesimpulan Praktikum

Praktikum Acara 28 membuktikan bahwa aplikasi Sistem Informasi Akademik yang dibangun secara lokal berhasil dipublikasikan ke infrastruktur hosting berbasis cloud (Rumahweb cPanel) dengan konfigurasi database produksi, domain, dan sertifikat enkripsi SSL.
