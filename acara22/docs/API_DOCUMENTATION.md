# Dokumentasi Spesifikasi Teknis RESTful API (Sistem Informasi Akademik)

**Dokumentasi Resmi**: Acara 21 - Dokumentasi Endpoint REST API  
**Base URL**: `http://localhost/bkpm-web-server-afif/acara21/public`  
**Format Komunikasi**: `application/json` (Encoding UTF-8)  
**Skema Autentikasi**: Bearer Token (JWT Native HS256)

---

## 1. Tabel Ringkasan Endpoint

| No | Method | URL / Path | Keterangan | Autentikasi | Controller & Method |
|:---:|:---:|---|---|:---:|---|
| 1 | `POST` | `/register` | Pendaftaran pengguna baru | Publik | `AuthController::register()` |
| 2 | `POST` | `/login` | Autentikasi user & penerbitan token JWT | Publik | `AuthController::login()` |
| 3 | `GET` | `/mahasiswa` | Mengambil seluruh data mahasiswa | Publik | `MahasiswaController::index()` |
| 4 | `GET` | `/mahasiswa?id={id}` | Mengambil detail satu mahasiswa | Publik | `MahasiswaController::index()` |
| 5 | `POST` | `/mahasiswa` | Menambahkan data mahasiswa baru | **Bearer Token** | `MahasiswaController::store()` |
| 6 | `PUT` | `/mahasiswa?id={id}` | Memperbarui data mahasiswa | **Bearer Token** | `MahasiswaController::update()` |
| 7 | `DELETE`| `/mahasiswa?id={id}` | Menghapus data mahasiswa | **Bearer Token** | `MahasiswaController::destroy()` |

---

## 2. Rincian Dokumentasi Teknis Tiap Endpoint

### A. Autentikasi & Pengguna

#### 1. POST `/register`
- **Tujuan**: Mendaftarkan akun baru ke dalam tabel `users`.
- **Headers**: `Content-Type: application/json`
- **Request Body**:
```json
{
  "username": "afif_admin",
  "email": "afif@polije.ac.id",
  "password": "PasswordRahasia2026!",
  "role": "admin"
}
```
- **Responses**:
  - `201 Created`
  ```json
  {
    "success": true,
    "message": "Registrasi berhasil",
    "data": {
      "id": 1,
      "username": "afif_admin",
      "role": "admin"
    },
    "timestamp": "2026-11-21T12:00:00+07:00"
  }
  ```
  - `400 Bad Request`: Jika username/email/password kosong.
  - `422 Unprocessable Entity`: Jika format email tidak valid atau username/email sudah digunakan.

#### 2. POST `/login`
- **Tujuan**: Memvalidasi kredensial pengguna dan mengembalikan token JWT untuk autentikasi request berikutnya.
- **Headers**: `Content-Type: application/json`
- **Request Body**:
```json
{
  "username": "afif_admin",
  "password": "PasswordRahasia2026!"
}
```
- **Responses**:
  - `200 OK`
  ```json
  {
    "success": true,
    "message": "Login berhasil",
    "data": {
      "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
      "role": "admin",
      "user": {
        "id": 1,
        "username": "afif_admin",
        "email": "afif@polije.ac.id"
      }
    },
    "timestamp": "2026-11-21T12:00:00+07:00"
  }
  ```
  - `401 Unauthorized`: Jika username tidak ditemukan atau password salah.

---

### B. Pengelolaan Resource Mahasiswa

#### 3. GET `/mahasiswa`
- **Tujuan**: Mengambil semua daftar mahasiswa.
- **Headers**: `Accept: application/json`
- **Responses**:
  - `200 OK`
  ```json
  {
    "success": true,
    "message": "Data berhasil diambil",
    "data": [
      {
        "id": 1,
        "nim": "220100123",
        "nama": "Andi Saputra",
        "prodi": "Teknik Informatika",
        "created_at": "2026-11-21 10:00:00"
      }
    ],
    "timestamp": "2026-11-21T12:00:00+07:00"
  }
  ```

#### 4. GET `/mahasiswa?id={id}`
- **Tujuan**: Mengambil data spesifik mahasiswa berdasarkan parameter `id`.
- **Query Parameter**: `id` (integer, required)
- **Responses**:
  - `200 OK`: Data ditemukan.
  - `404 Not Found`:
  ```json
  {
    "success": false,
    "message": "Data mahasiswa dengan ID 99 tidak ditemukan",
    "data": null,
    "timestamp": "2026-11-21T12:00:00+07:00"
  }
  ```

#### 5. POST `/mahasiswa`
- **Tujuan**: Menambahkan record mahasiswa baru.
- **Headers**: 
  - `Content-Type: application/json`
  - `Authorization: Bearer <token_jwt>`
- **Request Body**:
```json
{
  "nim": "220100129",
  "nama": "Farhan Kurniawan",
  "prodi": "Teknik Informatika"
}
```
- **Responses**:
  - `201 Created`
  ```json
  {
    "success": true,
    "message": "Data berhasil ditambahkan",
    "data": { "id": 4 },
    "timestamp": "2026-11-21T12:00:00+07:00"
  }
  ```
  - `401 Unauthorized`: Jika header Authorization tidak disertakan atau token kadaluarsa.
  - `422 Unprocessable Entity`: Jika format NIM tidak 9 digit angka atau NIM sudah terdaftar.

#### 6. PUT `/mahasiswa?id={id}`
- **Tujuan**: Memperbarui data profil mahasiswa.
- **Headers**: 
  - `Content-Type: application/json`
  - `Authorization: Bearer <token_jwt>`
- **Request Body**:
```json
{
  "nim": "220100129",
  "nama": "Farhan Kurniawan, S.Tr.Kom",
  "prodi": "Teknik Informatika"
}
```
- **Responses**:
  - `200 OK`: Data berhasil diperbarui.
  - `401 Unauthorized`: Token tidak valid.
  - `404 Not Found`: ID mahasiswa tidak ditemukan.

#### 7. DELETE `/mahasiswa?id={id}`
- **Tujuan**: Menghapus data mahasiswa secara permanen.
- **Headers**: `Authorization: Bearer <token_jwt>`
- **Responses**:
  - `200 OK`: Data berhasil dihapus.
  - `401 Unauthorized`: Token tidak valid.
  - `404 Not Found`: ID tidak ditemukan.
