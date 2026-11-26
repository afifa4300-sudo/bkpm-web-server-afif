# Dokumentasi & Panduan Praktikum Acara 27

**Pokok Bahasan**: Sinkronisasi Penuh Antarmuka Frontend & Backend API CRUD (Single Page Experience)  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Single Page Experience (SPA-Like CRUD)
Pada Acara 27, antarmuka frontend berbasis HTML, Bootstrap 5, dan JavaScript diintegrasikan secara menyeluruh dengan backend REST API:
- **Operasi CREATE**: Menggunakan Modal Form Bootstrap dengan objek `FormData` (mendukung upload berkas foto profil).
- **Operasi READ**: Memuat data tabel secara asinkronus dan merender thumbnail foto mahasiswa dari `public/uploads/`.
- **Operasi UPDATE**: Memuat data spesifik mahasiswa ke dalam Modal Edit tanpa refresh halaman, lalu mengirim perubahan via method spoofing `PUT`.
- **Operasi DELETE**: Konfirmasi interaktif JavaScript `confirm()`, lalu memanggil HTTP method `DELETE` dengan Bearer Token.

---

## 2. Fitur Tugas Praktik Mandiri
1. **Notifikasi Visual Operasi (Tugas Mandiri 1)**: Alert visual Bootstrap yang informatif muncul di atas tabel setiap kali operasi berhasil atau gagal, dan otomatis menghilang setelah 5 detik.
2. **Validasi Sisi View (Tugas Mandiri 2)**: Pemeriksaan masukan langsung pada antarmuka (NIM wajib numerik 9 digit, nama minimal 3 karakter, pemilihan dropdown prodi, dan pembatasan tipe file `.png`/`.jpg`).
