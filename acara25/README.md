# Dokumentasi & Panduan Praktikum Acara 25

**Pokok Bahasan**: Pengendalian Akses: Role-Based Access Control (RBAC) & Dashboard Admin  
**Mata Kuliah**: Workshop Sistem Informasi Web Server  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  

---

## 1. Konsep Authentication vs Authorization
- **Authentication**: Memverifikasi identitas pengguna ("Siapa Anda") melalui verifikasi username dan password pada endpoint `/login`.
- **Authorization**: Menentukan hak akses yang dimiliki pengguna ("Apa hak/wewenang Anda") berdasarkan peran pengguna (`role: 'admin'` vs `role: 'user'`).

## 2. Implementasi RBAC di Backend & Frontend
1. **Lapisan Core (`Auth::requireAdmin()`)**:
   - Memeriksa keabsahan JWT.
   - Memeriksa claim `$payload['role'] === 'admin'`. Jika bukan admin, server seketika menolak dengan respon status `403 Forbidden` (`Akses ditolak, hanya admin yang diizinkan`).
2. **Lapisan Controller (`MahasiswaController`)**:
   - Method `store()`, `update()`, dan `destroy()` diproteksi oleh `Auth::requireAdmin()`.
3. **Lapisan Frontend (`login.html` & `dashboard.html`)**:
   - Token dan role disimpan pada `localStorage`.
   - Jika role adalah `user`, JavaScript menyembunyikan kolom tombol aksi manipulasi data (*Tugas Mandiri 2*).
   - Tombol **Logout** disediakan untuk menghapus token dan sesi lokal (*Tugas Mandiri 1*).
