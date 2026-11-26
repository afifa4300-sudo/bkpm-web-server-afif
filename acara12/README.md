# Dokumentasi & Panduan Praktikum Acara 12

**Pokok Bahasan**: Branch, Merge, Pull Request, dan Conflict  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 12, dipelajari manajemen percabangan (*branching*), penggabungan fitur (*merging*), penanganan konflik (*conflict resolution*), serta alur pengajuan kode (*Pull Request*) pada Git dan GitHub:
1. **Branch**: Cabang independen dari basis kode utama yang memungkinkan pengembang membangun fitur baru tanpa mengganggu stabilitas branch `main`.
2. **Merge**: Proses penggabungan riwayat perubahan dari suatu branch fitur kembali ke branch utama.
3. **Conflict**: Kondisi saat dua branch memodifikasi baris kode yang sama pada berkas yang sama, sehingga Git meminta intervensi manual pengembang untuk menentukan baris kode akhir.
4. **Pull Request (PR)**: Fitur GitHub untuk mengusulkan perubahan kode, memfasilitasi *code review*, dan mendiskusikan implementasi sebelum digabungkan ke branch utama.

---

## 2. Struktur Berkas Acara 12
```
acara12/
├── .git/                      # Repositori Git lokal dengan multi-branch
├── .gitignore                 # Konfigurasi pengabaian berkas sensitif
├── app/                       # MVC SI-Akademik
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   ├── Repositories/
│   └── Views/
│       ├── auth/
│       │   └── login.php      # Fitur baru yang dikembangkan pada branch fitur-login
│       └── dashboard.php      # Berkas simulasi dan resolusi merge conflict
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── public/
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── web.php
└── README.md                  # Panduan pengujian & log praktikum Acara 12
```

---

## 3. Langkah-Langkah Praktikum yang Telah Dilakukan

### A. Membuat Branch Fitur Baru (`fitur-login`)
Membuat branch terpisah untuk menambahkan form login yang lebih interaktif:
```bash
git checkout -b fitur-login
```
Setelah melakukan perbaikan pada `app/Views/auth/login.php`, perubahan di-commit:
```bash
git add app/Views/auth/login.php
git commit -m "Menambahkan fitur login"
```

### B. Menggabungkan Branch ke `main` (Fast-Forward Merge)
Kembali ke branch utama dan menggabungkan branch `fitur-login`:
```bash
git checkout main
git merge fitur-login
```

### C. Simulasi dan Penanganan Merge Conflict
1. Membuat branch `branch-a` dan mengedit judul di `app/Views/dashboard.php`:
   ```bash
   git checkout -b branch-a
   # Edit dashboard.php menjadi "Selamat datang di Sistem Informasi Akademik Polije (Versi Branch A)"
   git add app/Views/dashboard.php
   git commit -m "Update judul dashboard di branch-a"
   ```
2. Kembali ke `main` dan mengedit baris yang sama:
   ```bash
   git checkout main
   # Edit dashboard.php menjadi "Portal Layanan Akademik Terpadu Polije (Versi Main Branch)"
   git add app/Views/dashboard.php
   git commit -m "Update judul dashboard di main"
   ```
3. Menggabungkan `branch-a` ke `main` hingga muncul **Merge Conflict**:
   ```bash
   git merge branch-a
   # Output: CONFLICT (content): Merge conflict in app/Views/dashboard.php
   ```
4. Mengamati penanda konflik (*conflict markers*):
   ```php
   <<<<<<< HEAD
       <h1 class="h2 mb-1">Portal Layanan Akademik Terpadu Polije (Versi Main Branch)</h1>
   =======
       <h1 class="h2 mb-1">Selamat datang di Sistem Informasi Akademik Polije (Versi Branch A)</h1>
   >>>>>>> branch-a
   ```
5. Menyelesaikan konflik secara manual dengan menentukan teks gabungan yang tepat:
   ```php
       <h1 class="h2 mb-1">Portal Sistem Informasi Akademik Terpadu Polije</h1>
   ```
6. Menyimpan hasil resolusi dan menyelesaikan merge:
   ```bash
   git add app/Views/dashboard.php
   git commit -m "Menyelesaikan merge conflict"
   ```

### D. Menghubungkan ke GitHub & Alur Pull Request
```bash
git remote add origin https://github.com/afiframdhani/si-akademik.git
# Mengunggah branch fitur dan main
git push -u origin main
git push -u origin fitur-login
```
Pada GitHub Web UI, dibuat **Pull Request** dari branch `fitur-login` menuju `main` untuk proses penelaahan kode (*Code Review*).

---

## 4. Log Graph Riwayat Percabangan Acara 12
Berikut adalah pohon percabangan (*git log --graph*) yang membuktikan keberhasilan penggabungan dan penyelesaian konflik:
```
*   0935442 (HEAD -> main) Menyelesaikan merge conflict
|\  
| * 0c950d5 (branch-a) Update judul dashboard di branch-a
* | 6ea38af Update judul dashboard di main
|/  
* 0906d20 (fitur-login) Menambahkan fitur login
* aba6d11 Initial commit on main branch
```

---

## 5. Kesimpulan Praktikum
Melalui Acara 12, dipahami bahwa percabangan (*branching*) merupakan pilar utama pengembangan kolaboratif modern. Terjadinya *conflict* bukan merupakan kesalahan (*bug*), melainkan mekanisme proteksi Git untuk mencegah hilangnya kode anggota tim secara tidak sengaja.
