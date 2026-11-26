# Dokumentasi & Panduan Praktikum Acara 26

**Pokok Bahasan**: Manajemen Konten: Upload Berkas Gambar, Validasi MIME Signature, & Backup/Restore Database  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Keamanan Upload Berkas pada PHP Native
Mengizinkan pengguna mengunggah berkas memiliki risiko keamanan tinggi (misal serangan RCE / Remote Code Execution melalui file PHP berekstensi samaran). Validasi keamanan yang diterapkan:
1. **Validasi MIME Signature Sebenarnya**: Menggunakan `exif_imagetype($file['tmp_name'])` untuk memeriksa signature biner gambar asli (magic bytes), bukan hanya membaca nama ekstensi atau header `$_FILES['type']`.
2. **Sanitasi Nama Berkas**: Mengganti nama berkas dengan ID acak unik via `uniqid('foto_', true)` untuk menghindari penimpaan file dan eksekusi skrip berbahaya.
3. **Pembatasan Ukuran**: Maksimal 2 Megabytes.
4. **Penghapusan Berkas Lama (Tugas Mandiri)**: Memanggil fungsi `unlink()` ketika foto profil diperbarui atau data mahasiswa dihapus, sehingga tidak terjadi penumpukan file sampah pada folder `public/uploads/`.

---

## 2. Backup & Restore Basis Data
- **File Backup SQL**: `database/db_workshop.sql`
- **Prosedur**:
  - Export: Melalui phpMyAdmin pilih database `db_workshop` -> Ekspor -> Format SQL.
  - Restore: Buat database baru -> Impor file `database/db_workshop.sql`.
