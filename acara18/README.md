# Dokumentasi & Panduan Praktikum Acara 18

**Pokok Bahasan**: Standarisasi Response Envelope JSON & HTTP Status Code  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Standardized Response Envelope
Pada arsitektur RESTful API yang profesional, setiap respon (baik berhasil maupun gagal) dikemas dalam satu struktur JSON seragam (*envelope*):
```json
{
    "success": true,
    "message": "Deskripsi pesan status",
    "data": { ... },
    "errors": { ... },
    "timestamp": "2026-11-21T11:20:00+07:00"
}
```

## 2. Fitur & Peningkatan pada Acara 18
1. **Class Core `Response` (`app/core/Response.php`)**: Mengenkapsulasi pengiriman HTTP status code, pengaturan header `application/json`, formatting JSON, penambahan timestamp ISO-8601, serta rincian validasi kesalahan.
2. **Refaktoring Controller & Router**: Seluruh pemanggilan respon langsung kini digantikan oleh `Response::json()`, sehingga Router (404/405) maupun Controller memiliki keseragaman format.
3. **Validasi Status Code 422 Unprocessable Entity**: Validasi format NIM 9 digit dan keunikan NIM di server mengembalikan HTTP 422 lengkap dengan rincian field yang bermasalah pada objek `errors`.
4. **Environment Switch `APP_ENV` (Tugas Mandiri)**: Mode `development` otomatis mengaktifkan `JSON_PRETTY_PRINT` agar mudah dibaca di Postman / browser, sedangkan `production` menghasilkan JSON terkompresi tanpa spasi/whitespace berlebih.

---

## 3. Matriks Kode Status HTTP yang Diterapkan

| Kode Status | Kategori | Contoh Penggunaan pada Aplikasi |
|---|---|---|
| `200 OK` | Success | Permintaan GET data mahasiswa, PUT update berhasil, DELETE data berhasil |
| `201 Created` | Success | Mahasiswa baru berhasil dibuat melalui POST |
| `400 Bad Request` | Client Error | Payload JSON rusak, atau field wajib (nim, nama, prodi) kosong |
| `404 Not Found` | Client Error | Endpoint tidak terdaftar di Router, atau ID mahasiswa tidak ditemukan |
| `405 Method Not Allowed` | Client Error | Mengirim HTTP Method selain GET/POST/PUT/DELETE |
| `422 Unprocessable Entity`| Client Error | Format NIM bukan 9 digit angka, atau NIM sudah terdaftar (duplikat) |
| `500 Server Error` | Server Error | Terjadi kegagalan koneksi PDO atau kegagalan query internal MySQL |

---

## 4. Pengujian dengan Postman

### A. Uji Sukses Tambah Data (201 Created)
- **POST**: `http://localhost/bkpm-web-server-afif/acara18/public/mahasiswa`
- **Body**:
```json
{
    "nim": "220100126",
    "nama": "Doni Pratama",
    "prodi": "Teknik Komputer"
}
```
- **Response**:
```json
{
    "success": true,
    "message": "Data berhasil ditambahkan",
    "data": {
        "id": 4
    },
    "timestamp": "2026-11-21T11:20:00+07:00"
}
```

### B. Uji Gagal Format NIM Tidak 9 Digit (422 Unprocessable Entity)
- **POST**: `http://localhost/bkpm-web-server-afif/acara18/public/mahasiswa`
- **Body**:
```json
{
    "nim": "123",
    "nama": "Doni Pratama",
    "prodi": "Teknik Komputer"
}
```
- **Response**:
```json
{
    "success": false,
    "message": "Format NIM tidak valid, harus 9 digit angka",
    "data": null,
    "timestamp": "2026-11-21T11:20:00+07:00",
    "errors": {
        "nim": "NIM harus berupa 9 digit numerik"
    }
}
```
