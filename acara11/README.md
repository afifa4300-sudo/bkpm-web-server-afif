# Dokumentasi & Panduan Praktikum Acara 11

**Pokok Bahasan**: Git Dasar: Repository, Commit, Push, Pull, Clone
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A

---

## 1. Deskripsi Praktikum

Pada Acara 11, dipelajari konsep dasar *Distributed Version Control System* (VCS) menggunakan **Git** dan platform repositori daring **GitHub**. Praktikum ini berfokus pada:

1. Memahami perbedaan mendasar antara **Git** (pencatat riwayat perubahan lokal) dan **GitHub** (layanan *cloud hosting* repositori Git).
2. Memahami siklus hidup kerja Git: `Working Directory` -> `Staging Area (git add)` -> `Local Repository (git commit)` -> `Remote Repository (git push)`.
3. Mengonfigurasi berkas `.gitignore` untuk menyaring berkas-berkas sensitif (seperti kredensial `.env`) dan berkas pustaka (*dependency* seperti `vendor/` dan `node_modules/`).
4. Mengelola riwayat *commit* dan sinkronisasi antara repositori lokal dan repositori *remote*.

---

## 2. Struktur Berkas Acara 11

```
acara11/
├── .git/                      # Direktori basis data internal Git (dibuat via git init)
├── .gitignore                 # Konfigurasi pengabaian file sensitif & cache
├── app/                       # Source code MVC SI-Akademik
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Repositories/
│   └── Views/
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── public/
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── web.php
└── README.md                  # Panduan pengujian & log praktikum
```

---

## 3. Konfigurasi Berkas `.gitignore`

Berkas `.gitignore` berfungsi memberitahu Git agar berkas dan direktori tertentu tidak dilacak (*untracked*):

```gitignore
# Dependencies
/vendor/
/node_modules/

# Environment & Sensitive Credentials
.env
.env.backup
.env.production
config/credentials.php

# Storage & Logs
/storage/logs/*
*.log

# System & OS Files
.DS_Store
Thumbs.db
```

---

## 4. Perintah Dasar Git yang Dipraktikkan

### A. Inisialisasi Repositori Lokal

```bash
git init
git config user.name "Muhammad Afif Ramdhani"
git config user.email "afif@polije.ac.id"
```

### B. Memeriksa Status & Menambahkan Perubahan ke Staging Area

```bash
# Memeriksa file yang belum ditrack atau dimodifikasi
git status

# Menambahkan seluruh file project ke Staging Area
git add .
```

### C. Mgenyimpan Riwayat Perubahan (Commit)

```bash
# Commit Pertama: Inisialisasi dasar
git commit -m "Inisialisasi project si-akademik dan konfigurasi .gitignore"

# Mengubah nama branch default menjadi main
git branch -M main

# Commit Kedua: Penambahan widget dan pembaruan antarmuka dashboard
git commit -m "Menambahkan widget status version control dan update dashboard"
```

### D. Menghubungkan Repositori Lokal ke GitHub (Remote Origin)

```bash
# Menambahkan remote origin
git remote add origin https://github.com/afiframdhani/si-akademik.git

# Memeriksa daftar remote
git remote -v
```

### E. Perintah Sinkronisasi Remote (Push, Pull, Clone)

- **`git push -u origin main`**: Mengunggah *commit* lokal dari branch `main` ke repositori GitHub.
- **`git pull origin main`**: Mengunduh dan menggabungkan perubahan terbaru dari GitHub ke komputer lokal.
- **`git clone <url-repo>`**: Mengunduh seluruh repositori project dari GitHub untuk pertama kali ke komputer baru.

---

## 5. Log Riwayat Commit Acara 11

Berikut adalah riwayat commit (*Git Commit History*) yang telah terbentuk pada repositori lokal Acara 11:

```
ad12502 (HEAD -> main) Menambahkan widget status version control dan update dashboard
8a7b6f8 Inisialisasi project si-akademik dan konfigurasi .gitignore
```

---

## 6. Kesimpulan Praktikum

Melalui Acara 11, mahasiswa memahami pentingnya Version Control System dalam menjamin keamanan kode sumber, melacak histori perkembangan fitur dari waktu ke waktu, dan memastikan berkas rahasia seperti password database tidak bocor ke publik berkat penerapan `.gitignore`.
