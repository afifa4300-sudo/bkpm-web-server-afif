# Dokumentasi & Panduan Praktikum Acara 17

**Pokok Bahasan**: Rekayasa Arsitektur MVC untuk Layanan API CRUD Native
**Mata Kuliah**: Workshop Sistem Informasi Web Server
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember

---

## 1. Konsep Arsitektur MVC pada REST API Native

Arsitektur MVC pada layanan backend memisahkan tugas ke dalam lapisan:

1. **Model** (`app/models/`): Mengelola interaksi basis data menggunakan PDO prepared statement.
2. **Controller** (`app/controllers/`): Mengatur alur logika endpoint, menerima JSON payload, dan mengembalikan JSON response.
3. **Core / Router** (`app/core/`): Menyediakan autoloader otomatis (`spl_autoload_register`) dan Router yang mendisposisi request ke Controller terkait.
4. **Front Controller** (`public/index.php`): Satu-satunya titik masuk publik (entry point) yang didukung URL rewriting via `.htaccess`.

---

## 2. Diagram Alur Sistem

```
Client (Postman / Browser)
         │
         ▼ (HTTP Request)
public/index.php (Front Controller)
         │
         ▼
app/core/Router.php (Pencocokan URI Resource & Method)
         │
         ▼
app/controllers/MahasiswaController.php / BukuController.php
         │
         ▼
app/models/Mahasiswa.php / Buku.php
         │
         ▼ (PDO Prepared Statements)
MySQL Database (db_workshop)
```

---

## 3. Struktur Direktori Acara 17

```
acara17/
├── app/
│   ├── config/
│   │   └── Database.php
│   ├── core/
│   │   ├── autoload.php
│   │   └── Router.php
│   ├── models/
│   │   ├── Mahasiswa.php
│   │   └── Buku.php
│   └── controllers/
│       ├── MahasiswaController.php
│       └── BukuController.php
├── database/
│   └── db_workshop.sql
├── public/
│   ├── .htaccess
│   └── index.php
└── README.md
```

---

## 4. Pengujian Endpoint dengan Postman

| Method     | Endpoint                           | Fungsi                 | Payload / Query                                                                                     | Status Expected                         |
| ---------- | ---------------------------------- | ---------------------- | --------------------------------------------------------------------------------------------------- | --------------------------------------- |
| `GET`    | `/acara17/public/mahasiswa`      | Ambil semua mahasiswa  | -                                                                                                   | `200 OK`                              |
| `GET`    | `/acara17/public/mahasiswa?id=1` | Ambil detail mahasiswa | `?id=1`                                                                                           | `200 OK` / `404`                    |
| `POST`   | `/acara17/public/mahasiswa`      | Tambah mahasiswa baru  | `{ "nim": "2201001", "nama": "Andi Saputra", "prodi": "Teknik Informatika" }`                     | `201 Created` / `422 Unprocessable` |
| `PUT`    | `/acara17/public/mahasiswa?id=1` | Update data mahasiswa  | `{ "nim": "2201001", "nama": "Andi Saputra, S.Kom", "prodi": "Teknik Informatika" }`              | `200 OK` / `404`                    |
| `DELETE` | `/acara17/public/mahasiswa?id=1` | Hapus mahasiswa        | `?id=1`                                                                                           | `200 OK` / `404`                    |
| `GET`    | `/acara17/public/buku`           | Ambil semua buku       | -                                                                                                   | `200 OK`                              |
| `POST`   | `/acara17/public/buku`           | Tambah buku            | `{ "judul": "Belajar PHP MVC", "penulis": "Raditya", "penerbit": "Polije Press", "tahun": 2026 }` | `201 Created`                         |
