# Panduan Penggunaan Postman Collection & Environment BKPM (Acara 15 - 27)

Folder ini berisi seluruh berkas **Postman Collection (v2.1.0)** dan **Postman Environment** yang telah disesuaikan secara presisi dengan **Silabus dan Buku Petunjuk Praktikum (BKPM) Workshop Sistem Informasi Web Server**.

---

## 📌 Ketentuan Penggunaan URL & Environment Sesuai BKPM

Sesuai silabus BKPM, materi **Postman Environment & Variabel Global/Lokal baru resmi diperkenalkan pada Acara 19**. Oleh karena itu:

1. **Acara 15 s.d Acara 18 (Tanpa `{{base_url}}`)**:
   - Belum mengenal environment variables.
   - URL request ditulis **langsung / hardcoded secara lengkap**, contoh:
     - `http://localhost/bkpm-web-server-afif/acara15/api/mahasiswa.php`
     - `http://localhost/bkpm-web-server-afif/acara16/api/mahasiswa.php?id=1`
     - `http://localhost/bkpm-web-server-afif/acara17/public/mahasiswa`
     - `http://localhost/bkpm-web-server-afif/acara18/public/mahasiswa`
   - **Kelebihan**: Anda dapat langsung menekan tombol **Send** tanpa perlu memilih environment apapun di Postman.

2. **Acara 19 s.d Acara 27 (Resmi Memakai `{{base_url}}`)**:
   - Memanfaatkan fitur **Postman Environment** sesuai materi praktikum Acara 19 (*Postman Environment & User Registration*).
   - URL request menggunakan format variabel dinamis:
     - `{{base_url}}/register`
     - `{{base_url}}/login`
     - `{{base_url}}/mahasiswa`
   - Telah disediakan berkas environment per acara maupun environment global:
     - `Acara-19_Local.postman_environment.json` (`base_url`: `http://localhost/bkpm-web-server-afif/acara19/public`)
     - `Acara-20_Local.postman_environment.json` (`base_url`: `http://localhost/bkpm-web-server-afif/acara20/public`)
     - `Acara-23_Local.postman_environment.json` (`base_url`: `http://localhost/bkpm-web-server-afif/acara23/public`)
     - `Acara-25_Local.postman_environment.json` (`base_url`: `http://localhost/bkpm-web-server-afif/acara25/public`)
     - `BKPM_Environment.postman_environment.json` (Default untuk Acara 27 / Proyek Terpadu)

---

## 📁 Daftar Berkas Collection & Environment

| Berkas | Jenis | Target Acara | Format URL | Keterangan |
| :--- | :--- | :--- | :--- | :--- |
| `Acara-15_Collection.postman_collection.json` | Collection | Acara 15 | `http://localhost/.../acara15/api/mahasiswa.php` | Langsung klik Send |
| `Acara-16_Collection.postman_collection.json` | Collection | Acara 16 | `http://localhost/.../acara16/api/mahasiswa.php` | Langsung klik Send |
| `Acara-17_Collection.postman_collection.json` | Collection | Acara 17 | `http://localhost/.../acara17/public/...` | Langsung klik Send |
| `Acara-18_Collection.postman_collection.json` | Collection | Acara 18 | `http://localhost/.../acara18/public/...` | Langsung klik Send |
| `Acara-19_Collection.postman_collection.json` | Collection | Acara 19 | `{{base_url}}/register` | Gunakan `Acara-19_Local` |
| `Acara-20_Collection.postman_collection.json` | Collection | Acara 20 | `{{base_url}}/login`, `/mahasiswa` | Gunakan `Acara-20_Local` |
| `Acara-21-22_Collection.postman_collection.json`| Collection | Acara 21 & 22 | `{{base_url}}/...` | Skenario OpenAPI 3.0 |
| `Acara-23_Collection.postman_collection.json` | Collection | Acara 23 | `{{base_url}}/...` (15 Test Cases) | Gunakan `Acara-23_Local` |
| `Acara-24-25_Collection.postman_collection.json`| Collection | Acara 24 & 25 | `{{base_url}}/...` (Admin vs User) | Gunakan `Acara-25_Local` |
| `Acara-26-27_Collection.postman_collection.json`| Collection | Acara 26 & 27 | `{{base_url}}/...` (Upload Citra) | Gunakan `BKPM_Environment` |
| `BKPM_Master_Acara15-27.postman_collection.json` | Master Col | Acara 15-27 | Terpadu (Fase 1 URL Penuh, Fase 2 Base URL) | Koleksi komprehensif |

> **Salinan Lokal**: Setiap folder acara (mulai dari `acara15/` hingga `acara27/`) juga telah dilengkapi berkas `.json` collection dan environment-nya masing-masing.

---

## 🚀 Cara Import dan Menjalankan di Postman

### Untuk Acara 15 s.d 18:
1. Klik **Import** di Postman (atau `Ctrl + O`).
2. Pilih file `Acara-15_Collection.postman_collection.json` (atau 16, 17, 18).
3. Buka request yang ingin diuji, klik **Send**. Request akan langsung berjalan sukses tanpa konfigurasi tambahan.

### Untuk Acara 19 s.d 27:
1. Klik **Import** di Postman.
2. Import file **Collection** (misal `Acara-19_Collection.postman_collection.json`) DAN file **Environment** terkait (misal `Acara-19_Local.postman_environment.json`).
3. Pada dropdown Environment di pojok kanan atas Postman, pilih environment yang baru di-import (misal: **Acara 19 Environment (Local)**).
4. Klik **Send**. Jika menjalankan login/register, token JWT akan tersimpan secara otomatis ke environment.
