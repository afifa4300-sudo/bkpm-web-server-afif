PROJECT ACARA 13 - SERVICE LAYER, VALIDASI, SESSION, DAN BUSINESS LOGIC

Folder ini merupakan salinan project Sistem Informasi Akademik dari acara10
yang telah disesuaikan untuk memenuhi langkah praktikum Acara 13 pada BKPM.

PERUBAHAN UTAMA
1. app/Services/MahasiswaService.php
   - Menangani validasi data mahasiswa.
   - Menangani proses create() dan update().
   - Menggunakan MahasiswaRepository dan ProdiRepository melalui constructor.
2. app/Repositories/ProdiRepository.php
   - Menyediakan daftar program studi dan pemeriksaan keberadaan prodi.
3. app/Controllers/MahasiswaController.php
   - Mengirim request tambah/ubah ke MahasiswaService.
   - Tidak lagi menjalankan validasi data mahasiswa.
4. app/Views/layouts/main.php
   - Menampilkan Flash Message dan menghapusnya setelah ditampilkan.
5. public/index.php
   - Memuat class baru dan membuat dependency MahasiswaService.

CARA MENJALANKAN
1. Salin folder acara13 ke htdocs (XAMPP) atau folder web server lokal.
2. Jalankan Apache dan MySQL.
3. Buat/import database dengan menjalankan database/schema.sql pada phpMyAdmin.
   Database yang digunakan bernama si_akademik.
4. Pastikan konfigurasi koneksi pada app/Core/Database.php sesuai komputer:
   host 127.0.0.1, database si_akademik, username root, password kosong
   (sesuaikan jika konfigurasi MySQL berbeda).
5. Buka melalui browser, misalnya:
   http://localhost/acara13/public/
6. Login menggunakan akun yang telah disiapkan pada database/project.
7. Uji tambah mahasiswa, ubah mahasiswa, NIM duplikat, email tidak valid,
   serta Flash Message berhasil/gagal.

CATATAN
- Folder acara sebelumnya tidak diubah.
- Struktur tabel mengikuti database/schema.sql yang ada pada project yang diberikan.
- Seluruh file PHP telah diperiksa menggunakan php -l (tidak ada syntax error).
- Pengujian interaksi browser dan database tetap perlu dilakukan di komputer lokal
  karena koneksi MySQL lokal pengguna tidak tersedia pada lingkungan pengerjaan.
