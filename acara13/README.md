# Dokumentasi & Panduan Praktikum Acara 13

**Pokok Bahasan**: Service Layer, Validasi, Session Flash Message, dan Business Logic  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 13, arsitektur aplikasi disempurnakan dengan memperkenalkan **Service Layer** sebagai lapisan pemisah antara *Controller* dan *Repository*. Dengan Service Layer, logika bisnis (*Business Logic*) serta aturan validasi data dipusatkan di dalam Service, sehingga Controller tetap bersih (*lean controller*) dan hanya bertugas mengatur alur HTTP request dan response.

---

## 2. Struktur Berkas Acara 13
```
acara13/
├── app/
│   ├── Controllers/
│   │   └── MahasiswaController.php    # Menerima request dan mendelegasikannya ke Service
│   ├── Services/
│   │   └── MahasiswaService.php       # Logika bisnis, validasi NIM duplikat & format email
│   ├── Repositories/
│   │   ├── MahasiswaRepository.php    # Akses data mahasiswa ke database
│   │   └── ProdiRepository.php        # Akses data program studi
│   ├── Models/
│   ├── Core/
│   └── Views/
│       └── layouts/main.php           # Komponen Flash Message (success/danger)
├── config/database.php
├── database/schema.sql
├── public/index.php
├── routes/web.php
└── README.md                          # Panduan praktikum dan alur Service Layer
```

---

## 3. Fitur Utama & Logika Bisnis
1. **Pemisahan Validasi ke `MahasiswaService`**:
   - Pengecekan kolom wajib (NIM, Nama, Prodi).
   - Validasi format keunikan NIM (mencegah duplikasi data mahasiswa).
   - Validasi sintaks format email menggunakan filter PHP.
2. **Flash Message Berbasis Session**:
   - Pemberitahuan visual interaktif (alert hijau untuk berhasil, merah untuk gagal) yang otomatis terhapus dari session begitu halaman selesai ditampilkan.
3. **Penerapan Dependency Injection**:
   - `MahasiswaService` disuntikkan ke dalam `MahasiswaController` via Constructor Injection.

---

## 4. Alur Kerja Aplikasi (Workflow)
```
User Form Submit (POST) 
   -> Route /mahasiswa/store 
   -> MahasiswaController::store() 
   -> MahasiswaService::create($data) [Validasi & Business Logic] 
   -> MahasiswaRepository::create($data) [Eksekusi SQL via PDO] 
   -> Set Session Flash Message 
   -> Redirect ke /mahasiswa
```

---

## 5. Kesimpulan Praktikum
Melalui implementasi Service Layer pada Acara 13, kode program menjadi jauh lebih mudah diuji (*testable*), memiliki batas pemisahan tanggung jawab yang tegas (*separation of concerns*), dan menghindarkan Controller dari penumpukan logika SQL maupun validasi yang rumit (*fat controller anti-pattern*).
