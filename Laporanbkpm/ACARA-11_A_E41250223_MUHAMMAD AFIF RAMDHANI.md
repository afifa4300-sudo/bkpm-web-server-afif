# Laporan Praktikum Acara 11: Git Dasar (Repository, Commit, Push, Pull, Clone)
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

### A. Pokok Bahasan
Git Dasar: Repository, Commit, Push, Pull, Clone pada Proyek Sistem Informasi Akademik.

### B. Dasar Teori
Git adalah sistem pengontrol versi terdistribusi (*Distributed Version Control System* / DVCS) yang digunakan untuk mencatat dan melacak setiap perubahan pada berkas kode sumber secara lokal. Dalam alur kerja Git, terdapat 3 tingkatan area kerja utama:
1. **Working Directory**: Folder lokal tempat berkas proyek dibuat dan disunting secara aktif.
2. **Staging Area (Index)**: Area persiapan untuk memilih dan menandai berkas perubahan mana saja yang akan dibungkus ke dalam titik simpan (*checkpoint*). Perintah yang digunakan adalah `git add`.
3. **Local Repository**: Basis data riwayat internal Git (`.git/`) yang menyimpan snapshot perubahan secara permanen melalui perintah `git commit`.

GitHub merupakan platform *cloud repository hosting* berbasis web yang digunakan untuk menyimpan repositori Git secara terpusat, mempermudah kolaborasi tim, dan mengamankan kode dari risiko kerusakan perangkat lokal. Sinkronisasi dilakukan menggunakan perintah `git push` (mengunggah dari lokal ke cloud), `git pull` (mengunduh perubahan dari cloud ke lokal), dan `git clone` (mengunduh repositori utuh untuk pertama kali).

Untuk mencegah berkas sensitif (seperti kredensial basis data pada `.env`) atau direktori pustaka yang berukuran besar (`vendor/`, `node_modules/`, serta berkas cache sistem operasi) terunggah ke repositori publik, digunakan berkas konfigurasi `.gitignore`.

### C. Hasil Praktikum & Implementasi Kode

#### 1. Konfigurasi File Pengabaian (.gitignore)
Berkas `.gitignore` diletakkan pada direktori akar proyek:
```gitignore
# Dependencies
/vendor/
/node_modules/

# Environment & Sensitive Credentials
.env
.env.backup
.env.production
config/credentials.php

# Storage, Uploads & Logs
/storage/logs/*
/storage/cache/*
*.log

# System & OS Files
.DS_Store
Thumbs.db
ehthumbs.db

# IDE & Editor Files
.vscode/
.idea/
```

#### 2. Inisialisasi dan Commit Pertama
Inisialisasi repositori Git dan perekaman struktur awal proyek SI-Akademik:
```bash
git init
git config user.name "Muhammad Afif Ramdhani"
git config user.email "afif@polije.ac.id"
git add .
git commit -m "Inisialisasi project si-akademik dan konfigurasi .gitignore"
git branch -M main
```

#### 3. Penambahan Fitur dan Commit Kedua
Melakukan modifikasi pada antarmuka dashboard (`app/Views/dashboard.php`) dengan menambahkan widget status version control:
```php
<!-- Informasi Status Sistem & Version Control Acara 11 -->
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-primary text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Status Version Control</h6>
      <h4 class="mb-0">Git & GitHub Terhubung</h4>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-success text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Branch Aktif</h6>
      <h4 class="mb-0">main (Produksi)</h4>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0 bg-info text-white p-3 rounded-3">
      <h6 class="text-white-50 text-uppercase mb-1">Repository</h6>
      <h4 class="mb-0">si-akademik</h4>
    </div>
  </div>
</div>
```
Merekam perubahan ke commit kedua:
```bash
git status
git add app/Views/dashboard.php
git commit -m "Menambahkan widget status version control dan update dashboard"
```

#### 4. Menghubungkan ke Remote Repository GitHub
```bash
git remote add origin https://github.com/afiframdhani/si-akademik.git
git remote -v
```

### D. Analisis dan Pembahasan
1. **Pentingnya Staging Area (`git add`)**: Perintah `git add` memisahkan proses pengeditan kode dari proses penyimpanan permanen. Hal ini memungkinkan pengembang untuk mengelompokkan perubahan secara modular berdasarkan fitur atau perbaikan tertentu sebelum dijadikan commit.
2. **Pesan Commit yang Informatif**: Pesan commit yang jelas (seperti *"Menambahkan widget status version control..."*) memudahkan pelacakan riwayat ketika terjadi regresi kode (*bug hunting*) melalui perintah `git log`.
3. **Keamanan Melalui `.gitignore`**: Berkas rahasia seperti kata sandi basis data tidak boleh berada di repositori daring. File `.gitignore` memastikan berkas tersebut tetap ada dan berjalan di komputer lokal tanpa terlacak oleh Git.
4. **Verifikasi Riwayat Commit**:
   Pemeriksaan dengan `git log --oneline` menunjukkan dua commit yang tersusun rapi:
   - `ad12502 Menambahkan widget status version control dan update dashboard`
   - `8a7b6f8 Inisialisasi project si-akademik dan konfigurasi .gitignore`

### E. Kesimpulan
Praktikum Acara 11 berhasil mengimplementasikan dasar-dasar Version Control System pada proyek Sistem Informasi Akademik. Mahasiswa telah menguasai alur kerja dasar Git (`git init`, `git status`, `git add`, `git commit`, `git remote`, `git push`, `git pull`, `git clone`), memahami fungsi perlindungan data melalui `.gitignore`, serta berhasil mendokumentasikan riwayat commit yang jelas dan terstruktur.
