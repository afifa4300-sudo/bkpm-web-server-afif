# Dokumentasi & Panduan Praktikum Acara 16

**Pokok Bahasan**: RESTful API + Endpoint Request / Response & Testing Postman
**Mata Kuliah**: Workshop Sistem Informasi Web Server
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember

---

## 1. Konsep RESTful API

RESTful API memanfaatkan kata kerja HTTP (HTTP Verbs) untuk menentukan operasi manipulasi resource data, didukung kode status HTTP standar:

- `GET` : Mengambil satu / semua data (`200 OK`)
- `POST` : Menambahkan data baru (`201 Created`)
- `PUT` : Memperbarui data secara menyeluruh (`200 OK`)
- `DELETE` : Menghapus data (`200 OK`)

## 2. Struktur Berkas Acara 16

```
acara16/
├── .htaccess           # URL Rewrite agar mendukung /api/mahasiswa/{id}
├── api/
│   └── mahasiswa.php   # Endpoint RESTful lengkap (GET, POST, PUT, DELETE)
├── database.sql        # Skrip database si_akademik
└── README.md           # Panduan & Postman Test Collection
```

## 3. Spesifikasi Endpoint CRUD RESTful

| Method           | Endpoint             | Fungsi                | Status Berhasil | Skenario Error                         |
| ---------------- | -------------------- | --------------------- | --------------- | -------------------------------------- |
| **GET**    | `/api/mahasiswa`   | Ambil semua mahasiswa | `200 OK`      | `500 Internal Error`                 |
| **GET**    | `/api/mahasiswa/1` | Ambil mahasiswa ID 1  | `200 OK`      | `404 Not Found`                      |
| **POST**   | `/api/mahasiswa`   | Tambah mahasiswa baru | `201 Created` | `400 Bad Request`                    |
| **PUT**    | `/api/mahasiswa/1` | Ubah mahasiswa ID 1   | `200 OK`      | `404 Not Found`, `400 Bad Request` |
| **DELETE** | `/api/mahasiswa/1` | Hapus mahasiswa ID 1  | `200 OK`      | `404 Not Found`                      |

---

## 4. Contoh Pengujian dengan Postman

### A. PUT (Update Mahasiswa ID 1)

- **URL**: `http://localhost/bkpm-web-server-afif/acara16/api/mahasiswa/1` (atau `api/mahasiswa.php?id=1`)
- **Method**: `PUT`
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
    "nim": "23001",
    "nama": "Budi Santoso, S.Kom",
    "email": "budi.santoso@gmail.com"
}
```

- **Response**: `200 OK`

```json
{
    "success": true,
    "message": "Data mahasiswa berhasil diperbarui",
    "data": {
        "id": 1,
        "nim": "23001",
        "nama": "Budi Santoso, S.Kom",
        "email": "budi.santoso@gmail.com"
    }
}
```

### B. DELETE (Hapus Mahasiswa ID 1)

- **URL**: `http://localhost/bkpm-web-server-afif/acara16/api/mahasiswa/1`
- **Method**: `DELETE`
- **Response**: `200 OK`

```json
{
    "success": true,
    "message": "Data mahasiswa berhasil dihapus"
}
```
