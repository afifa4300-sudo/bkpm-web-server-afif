# Dokumentasi & Panduan Praktikum Acara 22

**Pokok Bahasan**: Standarisasi Dokumentasi dengan OpenAPI Specification 3.0 & Swagger UI  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep OpenAPI Specification 3.0
OpenAPI 3.0 adalah format standar industri yang dapat dibaca manusia maupun mesin untuk mendeskripsikan antarmuka REST API. Dibandingkan dokumentasi manual Markdown, spesifikasi OpenAPI memungkinkan pengujian interaktif secara langsung (*Try It Out*) melalui Swagger UI.

## 2. Struktur Berkas
- **Lokasi Spesifikasi OpenAPI**: `docs/openapi.yaml`
- **Fitur Utama pada Berkas**:
  - `info`: Metadata judul, versi, dan deskripsi sistem.
  - `servers`: Base URL endpoint.
  - `paths`: Definisi endpoint `/register`, `/login`, dan CRUD `/mahasiswa` (GET, POST, PUT, DELETE).
  - `components.securitySchemes`: Skema autentikasi `bearerAuth` bertipe `http/bearer` (*Tugas Praktik Mandiri*).

## 3. Visualisasi dengan Swagger
1. Buka [https://editor.swagger.io](https://editor.swagger.io) di peramban web.
2. Salin isi berkas `docs/openapi.yaml` ke panel editor sisi kiri.
3. Panel kanan akan secara otomatis merender dokumentasi interaktif Swagger UI lengkap dengan tombol *Try It Out* dan tombol *Authorize* (Bearer Token).
