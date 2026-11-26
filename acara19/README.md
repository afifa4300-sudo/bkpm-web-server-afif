# Dokumentasi & Panduan Praktikum Acara 19

**Pokok Bahasan**: Postman Environment, Pengujian Lanjutan, dan Registrasi Pengguna (Password Hashing)  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Dasar & Fitur Baru
Pada Acara 19, dilakukan penguatan arsitektur autentikasi awal dan pengujian Postman:
1. **Perancangan Tabel `users`**: Menampung kredensial pengguna (`username`, `email`, `password`, `role`).
2. **Password Hashing**: Kata sandi wajib dienkripsi sebelum disimpan ke basis data menggunakan algoritma bawaan PHP `password_hash($password, PASSWORD_DEFAULT)`.
3. **Validasi Email (Tugas Mandiri)**: Memastikan format email valid secara sintaksis menggunakan `filter_var($email, FILTER_VALIDATE_EMAIL)` pada level Model / Controller.
4. **Postman Environment Simulation**:
   - Environment `Local`: `{{base_url}} = http://localhost/bkpm-web-server-afif/acara19/public`
   - Environment `Staging`: `{{base_url}} = http://staging.kampus.ac.id/public`

---

## 2. Pengujian Endpoint Registrasi dengan Postman

### A. POST /register (Sukses)
- **URL**: `{{base_url}}/register`
- **Method**: `POST`
- **Headers**: `Content-Type: application/json`
- **Body**:
```json
{
    "username": "afif_admin",
    "email": "afif@polije.ac.id",
    "password": "PasswordKuat2026!",
    "role": "admin"
}
```
- **Response**: `201 Created`
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

### B. POST /register (Gagal - Format Email Tidak Valid)
- **Body**:
```json
{
    "username": "afif_user",
    "email": "bukan-email-valid",
    "password": "Password123"
}
```
- **Response**: `422 Unprocessable Entity`
```json
{
    "success": false,
    "message": "Format email tidak valid",
    "data": null,
    "timestamp": "2026-11-21T12:00:00+07:00",
    "errors": {
        "email": "Format email yang dimasukkan tidak memenuhi standar"
    }
}
```
