# Dokumentasi & Panduan Praktikum Acara 23

**Pokok Bahasan**: Pengujian Fungsional: Manual Testing, Blackbox Testing, Equivalence Partitioning  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Pengujian Fungsional
Pengujian *Blackbox* berfokus pada validasi input dan output tanpa melihat kode program internal. Menggunakan teknik *Equivalence Partitioning*, domain masukan dipartisi menjadi kelas valid dan kelas tidak valid guna menguji ketahanan API.

## 2. Struktur Berkas
- **Dokumen Matriks Pengujian**: `docs/TEST_CASE.md`
- **Cakupan Pengujian**:
  - Validasi keberhasilan dan penolakan pada endpoint `/register` dan `/login`.
  - Validasi CRUD `/mahasiswa` (GET, POST, PUT, DELETE).
  - Validasi Token JWT Stateless (401 Unauthorized jika tidak menyertakan token).
  - Validasi format dan keunikan NIM (422 Unprocessable Entity).
  - 5 Test case tambahan untuk `PUT` dan `DELETE` (*Tugas Praktik Mandiri*).
