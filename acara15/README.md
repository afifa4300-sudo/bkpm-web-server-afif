# Dokumentasi & Panduan Praktikum Acara 15

**Pokok Bahasan**: Konsep API dan JSON
**Mata Kuliah**: Workshop Sistem Informasi Web Server
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember

---

## 1. Deskripsi Praktikum

Pada Acara 15, mahasiswa mempelajari dasar-dasar REST API (Application Programming Interface) dan format data JSON (JavaScript Object Notation). API bertindak sebagai saluran komunikasi antara antarmuka klien dan penyedia data di server tanpa menghasilkan tampilan HTML.

## 2. Struktur Berkas

```
acara15/
├── api/
│   └── mahasiswa.php   # Endpoint API pertama (GET & POST)
├── database.sql        # Skrip database & tabel mahasiswa
└── README.md           # Panduan dan dokumentasi pengujian
```

## 3. Database Setup

Eksekusi perintah SQL pada `database.sql` di phpMyAdmin atau terminal MySQL:

- Nama Database: `si_akademik`
- Tabel: `mahasiswa` (id, nim, nama, email)
- Data Awal:
  - 23001 - Budi (budi@gmail.com)
  - 23002 - Siti (siti@gmail.com)
  - 23003 - Andi (andi@gmail.com)

## 4. Pengujian Endpoint API dengan Postman

### A. GET Semua Mahasiswa

- **URL**: `http://localhost/bkpm-web-server-afif/acara15/api/mahasiswa.php`
- **Method**: `GET`
- **Response**: `200 OK`

```json
{
    "success": true,
    "message": "Data berhasil diambil",
    "data": [
        {
            "id": 1,
            "nim": "23001",
            "nama": "Budi",
            "email": "budi@gmail.com"
        },
        ...
    ]
}
```

### B. GET Mahasiswa Berdasarkan ID

- **URL**: `http://localhost/bkpm-web-server-afif/acara15/api/mahasiswa.php?id=1`
- **Method**: `GET`
- **Response**: `200 OK`

```json
{
    "success": true,
    "message": "Data mahasiswa berhasil diambil",
    "data": {
        "id": 1,
        "nim": "23001",
        "nama": "Budi",
        "email": "budi@gmail.com"
    }
}
```

### C. POST Tambah Mahasiswa Baru

- **URL**: `http://localhost/bkpm-web-server-afif/acara15/api/mahasiswa.php`
- **Method**: `POST`
- **Headers**: `Content-Type: application/json`
- **Body (raw JSON)**:

```json
{
    "nim": "23004",
    "nama": "Dewi",
    "email": "dewi@gmail.com"
}
```

- **Response**: `201 Created`

```json
{
    "success": true,
    "message": "Data mahasiswa berhasil ditambahkan",
    "data": {
        "id": 4,
        "nim": "23004",
        "nama": "Dewi",
        "email": "dewi@gmail.com"
    }
}
```
