# Dokumentasi & Panduan Praktikum Acara 14

**Pokok Bahasan**: Pengujian Unit (Unit Testing), Exception Handling, dan Logging  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 14, kualitas perangkat lunak ditingkatkan melalui penerapan **Automated Unit Testing** menggunakan pengujian mandiri (*custom assertion test runner*), penanganan galat (*Exception Handling*), serta pencatatan jejak kesalahan sistem (*Error Logging*) ke direktori penyimpanan berkas (`storage/logs/`).

---

## 2. Struktur Berkas Acara 14
```
acara14/
├── app/
│   ├── Controllers/
│   ├── Services/
│   ├── Repositories/
│   ├── Models/
│   └── Core/
├── config/database.php
├── database/schema.sql
├── docs/
│   ├── ROADMAP_ACARA14.md
│   └── TESTING_ACARA14.md
├── public/index.php
├── storage/
│   └── logs/                          # Berkas log pencatatan runtime exception
├── tests/
│   ├── MahasiswaServiceTest.php       # Pengujian unit logic validasi dan data
│   └── run.php                        # CLI Test Runner
└── README.md                          # Panduan praktikum dan instruksi pengujian
```

---

## 3. Fitur Utama & Pengujian Perangkat Lunak
1. **Unit Testing Framework**:
   - Menjalankan pengujian otomatis untuk memverifikasi kebenaran logika `MahasiswaService` tanpa memerlukan browser atau server web aktif.
   - Menguji skenario positif (input valid) dan skenario negatif (NIM duplikat, email rusak, kolom kosong).
2. **Centralized Exception Handling**:
   - Menangkap kesalahan runtime menggunakan blok `try-catch` terpusat sehingga sistem tidak menampilkan *raw stack trace* yang membocorkan kredensial ke layar pengguna.
3. **Pencatatan Log Sistem (`storage/logs/`)**:
   - Setiap error yang terjadi secara otomatis dicatat lengkap dengan timestamp, kode kesalahan, dan pesan error ke dalam berkas log teks harian.

---

## 4. Cara Menjalankan Pengujian Unit (CLI)
Buka terminal pada direktori `acara14/` dan jalankan perintah:
```bash
php tests/run.php
```
Hasil pengujian akan menampilkan status pengujian seluruh *test cases* (PASS / FAIL) beserta ringkasan eksekusinya.

---

## 5. Kesimpulan Praktikum
Praktikum Acara 14 membekali mahasiswa dengan disiplin penjaminan mutu perangkat lunak (*Software Quality Assurance*). Penerapan pengujian unit dan logging memastikan setiap bug dapat terdeteksi sejak dini sebelum aplikasi dipublikasikan ke lingkungan produksi.
