# Dokumentasi & Panduan Praktikum Acara 20

**Pokok Bahasan**: Autentikasi API: Implementasi JSON Web Token (JWT) Native & Middleware  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Stateless Authentication (JWT Native)
RESTful API bersifat *stateless*, artinya server tidak menyimpan state sesi pengguna dalam session file di server. Sebagai gantinya, klien mengirimkan bukti login berupa **Bearer Token (JWT)** pada header HTTP setiap kali memanggil endpoint yang terproteksi:
- Struktur JWT: `Header.Payload.Signature`
- Algoritma Enkripsi: HMAC-SHA256 (`hash_hmac('sha256', ...)` + Base64URL encoding).

## 2. Struktur Token & Proteksi Endpoint
- **Class `Auth` (`app/core/Auth.php`)**:
  - `generateToken($payload, $expiry)`: Menerbitkan JWT dengan claim user dan masa kedaluwarsa.
  - `validateToken($token)`: Memvalidasi tanda tangan digital dan memeriksa apakah token belum expired.
  - `requireAuth()`: Middleware yang mengambil header `Authorization: Bearer <token>`, memvalidasinya, dan mengembalikan HTTP `401 Unauthorized` jika token salah/tidak ada.
- **Endpoint Terproteksi**:
  - `POST /mahasiswa` (Membutuhkan Bearer Token)
  - `PUT /mahasiswa?id=X` (Membutuhkan Bearer Token)
  - `DELETE /mahasiswa?id=X` (Membutuhkan Bearer Token)
  - `GET /mahasiswa` (Terbuka / Publik untuk keperluan membaca data)

---

## 3. Skenario Pengujian Postman

### A. POST /login (Mendapatkan Token)
- **URL**: `{{base_url}}/login`
- **Method**: `POST`
- **Body**:
```json
{
    "username": "afif_admin",
    "password": "PasswordKuat2026!"
}
```
- **Response**: `200 OK`
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
        "role": "admin"
    }
}
```

### B. POST /mahasiswa tanpa Header Authorization (Gagal)
- **Response**: `401 Unauthorized`
```json
{
    "success": false,
    "message": "Akses ditolak: Token autentikasi tidak ditemukan pada header Authorization",
    "data": null
}
```

### C. POST /mahasiswa dengan Header Authorization Valid (Sukses)
- **Header**: `Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...`
- **Response**: `201 Created`
```json
{
    "success": true,
    "message": "Data berhasil ditambahkan",
    "data": { "id": 5 }
}
```
