# Laporan Hasil Pengujian Fungsional (Blackbox Testing & Equivalence Partitioning)

**Proyek**: RESTful API Sistem Informasi Akademik  
**Metode Pengujian**: Blackbox Testing & Equivalence Partitioning  
**Lingkungan Uji**: Postman (Local Environment)  
**Waktu Eksekusi**: 2026-11-21  

---

## 1. Matriks Rencana dan Hasil Pengujian (Test Case Matrix)

| ID Test Case | Modul / Method | Skenario Pengujian | Data Uji (Input) | Hasil yang Diharapkan | Hasil Aktual (HTTP Status) | Status |
|:---:|:---:|---|---|---|:---:|:---:|
| **TC-01** | `POST /mahasiswa` | Tambah mahasiswa data valid & lengkap | `nim=220100123`, `nama="Andi"`, `prodi="TI"` (Header Bearer Token) | HTTP 201 Created | HTTP 201 Created | **PASS** |
| **TC-02** | `POST /mahasiswa` | Tambah mahasiswa NIM kosong (partisi tidak valid) | `nim=""`, `nama="Budi"`, `prodi="TI"` | HTTP 400 Bad Request | HTTP 400 Bad Request | **PASS** |
| **TC-03** | `POST /mahasiswa` | Tambah mahasiswa NIM kurang dari 9 digit | `nim="123"`, `nama="Budi"`, `prodi="TI"` | HTTP 422 Unprocessable | HTTP 422 Unprocessable | **PASS** |
| **TC-04** | `POST /mahasiswa` | Tambah mahasiswa NIM duplikat (sudah terdaftar) | `nim="220100123"` | HTTP 422 Unprocessable | HTTP 422 Unprocessable | **PASS** |
| **TC-05** | `POST /mahasiswa` | Akses simpan mahasiswa tanpa Token Bearer | Tanpa header Authorization | HTTP 401 Unauthorized | HTTP 401 Unauthorized | **PASS** |
| **TC-06** | `POST /login` | Login dengan kredensial benar | `username="afif_admin"`, `password="PasswordKuat2026!"` | HTTP 200 OK + JWT Token | HTTP 200 OK + JWT Token | **PASS** |
| **TC-07** | `POST /login` | Login dengan password salah | `username="afif_admin"`, `password="SalahPassword"` | HTTP 401 Unauthorized | HTTP 401 Unauthorized | **PASS** |
| **TC-08** | `POST /register` | Registrasi dengan format email salah | `email="bukan-email-valid"` | HTTP 422 Unprocessable | HTTP 422 Unprocessable | **PASS** |
| **TC-09** | `GET /mahasiswa` | Mengambil seluruh data mahasiswa | Parameter kosong | HTTP 200 OK + Array Data | HTTP 200 OK + Array Data | **PASS** |
| **TC-10** | `GET /mahasiswa` | Mengambil data mahasiswa ID tidak ditemukan | `?id=9999` | HTTP 404 Not Found | HTTP 404 Not Found | **PASS** |
| **TC-11** | `PUT /mahasiswa` | Update data dengan ID valid & token sah *(Tugas Mandiri)* | `?id=1`, `nim="220100123"`, `nama="Andi Saputra, S.Kom"` | HTTP 200 OK | HTTP 200 OK | **PASS** |
| **TC-12** | `PUT /mahasiswa` | Update data mahasiswa ID tidak ditemukan *(Tugas Mandiri)* | `?id=9999`, data lengkap | HTTP 404 Not Found | HTTP 404 Not Found | **PASS** |
| **TC-13** | `PUT /mahasiswa` | Update data tanpa menyertakan ID *(Tugas Mandiri)* | URL tanpa query `?id=X` | HTTP 400 Bad Request | HTTP 400 Bad Request | **PASS** |
| **TC-14** | `DELETE /mahasiswa`| Hapus data mahasiswa dengan ID valid & token sah *(Tugas Mandiri)* | `?id=1` (Header Bearer Token) | HTTP 200 OK | HTTP 200 OK | **PASS** |
| **TC-15** | `DELETE /mahasiswa`| Hapus data mahasiswa tanpa header token *(Tugas Mandiri)* | `?id=1` tanpa Authorization | HTTP 401 Unauthorized | HTTP 401 Unauthorized | **PASS** |

---

## 2. Kesimpulan Pengujian
Berdasarkan 15 skenario pengujian ekuivalen di atas, seluruh endpoint menunjukkan tingkat keberhasilan **100% (Pass)**. Sistem backend mampu merespon secara presisi baik pada jalur normal (*success path*) maupun penanganan kesalahan (*error handling*) sesuai spesifikasi kode status HTTP.
