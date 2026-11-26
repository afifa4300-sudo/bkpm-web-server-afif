# Laporan Praktikum Acara 12: Branch, Merge, Pull Request, dan Conflict
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

### A. Pokok Bahasan
Manajemen Percabangan (*Branch*), Penggabungan (*Merge*), Pengajuan Perubahan (*Pull Request*), dan Resolusi Konflik (*Conflict Resolution*) pada Git & GitHub.

### B. Dasar Teori
Dalam pengembangan perangkat lunak modern, beberapa pengembang sering kali bekerja secara simultan pada aplikasi yang sama. Git menyediakan fitur **Branching** untuk memfasilitasi kebutuhan ini:
1. **Branch**: Garis pengembangan independen. Branch utama (`main`) umumnya merepresentasikan kode yang stabil dan siap produksi. Pembuatan branch baru (misal: `git checkout -b fitur-login`) memungkinkan pengembang menulis dan menguji fitur baru tanpa memengaruhi branch utama.
2. **Merge**: Perintah untuk menyatukan riwayat commit dari satu branch ke branch lainnya (misal: `git merge fitur-login`). Apabila branch utama tidak mengalami perubahan sejak branch fitur dibuat, Git menerapkan penggabungan *Fast-Forward*.
3. **Merge Conflict**: Terjadi apabila dua branch berbeda mengubah baris kode yang sama pada berkas yang sama secara berlainan. Ketika di-merge, Git tidak dapat memutuskan secara otomatis mana perubahan yang benar, sehingga proses merge dihentikan sementara dan Git menambahkan penanda konflik (`<<<<<<< HEAD`, `=======`, `>>>>>>>`). Pengembang diwajibkan menyunting berkas tersebut secara manual, menghapus penanda konflik, dan membuat commit penyelesaian.
4. **Pull Request (PR)**: Mekanisme pada platform kolaborasi daring (GitHub) yang memungkinkan pengembang mempublikasikan branch fiturnya dan meminta pengembang lain untuk memeriksa kode (*Code Review*) sebelum disetujui (*Approve*) dan digabungkan ke branch `main`.

### C. Hasil Praktikum & Implementasi Kode

#### 1. Pembuatan dan Penggabungan Branch Fitur Baru
Membuat branch khusus untuk pembaruan fitur login:
```bash
git checkout -b fitur-login
```
Melakukan perbaikan dan penyempurnaan pada antarmuka login (`app/Views/auth/login.php`):
```php
<div class="row justify-content-center">
  <div class="col-md-6 col-lg-5">
    <div class="text-center mb-4">
      <h1 class="h2">Login Portal SI-Akademik</h1>
      <p class="text-secondary mb-0">Portal Resmi Masuk Mahasiswa & Tenaga Pendidik Polije.</p>
    </div>
    ...
```
Menyimpan commit dan menggabungkannya ke branch `main`:
```bash
git add app/Views/auth/login.php
git commit -m "Menambahkan fitur login"
git checkout main
git merge fitur-login
```

#### 2. Simulasi dan Penanganan Merge Conflict
Membuat situasi konflik dengan mengubah baris judul pada `app/Views/dashboard.php` di dua branch berbeda:

**Langkah pada branch-a:**
```bash
git checkout -b branch-a
# Modifikasi baris judul:
# <h1 class="h2 mb-1">Selamat datang di Sistem Informasi Akademik Polije (Versi Branch A)</h1>
git add app/Views/dashboard.php
git commit -m "Update judul dashboard di branch-a"
```

**Langkah pada branch main:**
```bash
git checkout main
# Modifikasi baris judul yang sama:
# <h1 class="h2 mb-1">Portal Layanan Akademik Terpadu Polije (Versi Main Branch)</h1>
git add app/Views/dashboard.php
git commit -m "Update judul dashboard di main"
```

**Memicu Conflict dan Analisis Penanda Konflik:**
```bash
git merge branch-a
# Output Git:
# Auto-merging app/Views/dashboard.php
# CONFLICT (content): Merge conflict in app/Views/dashboard.php
# Automatic merge failed; fix conflicts and then commit the result.
```
Penanda konflik yang dihasilkan oleh Git:
```php
<<<<<<< HEAD
    <h1 class="h2 mb-1">Portal Layanan Akademik Terpadu Polije (Versi Main Branch)</h1>
=======
    <h1 class="h2 mb-1">Selamat datang di Sistem Informasi Akademik Polije (Versi Branch A)</h1>
>>>>>>> branch-a
```

**Resolusi Konflik Manual:**
Menggabungkan kedua ide judul menjadi satu judul resmi dan menghapus penanda konflik:
```php
    <h1 class="h2 mb-1">Portal Sistem Informasi Akademik Terpadu Polije</h1>
```
Menyelesaikan merge:
```bash
git add app/Views/dashboard.php
git commit -m "Menyelesaikan merge conflict"
```

#### 3. Log Riwayat Percabangan (Git Graph)
Hasil eksekusi `git log --oneline --graph` menunjukkan percabangan dan penggabungan secara visual:
```
*   0935442 (HEAD -> main) Menyelesaikan merge conflict
|\  
| * 0c950d5 (branch-a) Update judul dashboard di branch-a
* | 6ea38af Update judul dashboard di main
|/  
* 0906d20 (fitur-login) Menambahkan fitur login
* aba6d11 Initial commit on main branch
```

### D. Analisis dan Pembahasan
1. **Isolasi Fitur Menggunakan Branch**: Pengerjaan fitur baru di branch terpisah menjamin bahwa branch produksi (`main`) selalu dalam keadaan bersih (*clean state*) dan siap di-deploy kapan pun tanpa terpengaruh oleh fitur yang belum selesai diuji.
2. **Mekanisme Konflik Bukan Kesalahan Sistem**: Terjadinya conflict merupakan salah satu keunggulan Git dalam menjaga integritas data. Tanpa fitur ini, kode yang ditulis oleh salah satu pihak akan tertimpa (*overwrite*) secara diam-diam dan menyebabkan hilangnya logika program.
3. **Pentingnya Pull Request**: Melalui Pull Request di GitHub, tim pengembang dapat memanfaatkan fitur *diff inspection*, memberikan komentar baris demi baris, serta menjalankan otomatisasi pengujian sebelum kode benar-benar diizinkan masuk ke `main`.

### E. Kesimpulan
Praktikum Acara 12 berhasil membekali mahasiswa dengan keterampilan esensial kolaborasi perangkat lunak menggunakan Git dan GitHub. Mahasiswa telah mampu mengoperasikan siklus pembuatan branch (`git checkout -b`), penggabungan kode (`git merge`), mendiagnosis dan menyelesaikan insiden merge conflict secara manual, serta memahami konsep pengajuan fitur melalui mekanisme Pull Request.
