# Acara 14 — Implementasi

Berbasis Acara 13; struktur dan fitur lama dipertahankan.

## Materi Acara 14

- [X] Security: validasi input pada Service, query repository menggunakan PDO prepared statement, session authentication.
- [X] Exception handling: exception handler global, pesan pengguna aman, error detail hanya dicatat.
- [X] Logging: `App\Core\Logger` menulis log INFO/WARNING/ERROR ke `storage/logs/app.log`.
- [X] PRG: alur POST mahasiswa menggunakan flash message dan redirect untuk hasil validasi/proses.
- [X] Integrasi CRUD: fitur Mahasiswa, Prodi, dan Matakuliah dari baseline Acara 13 tetap tersedia.
- [X] Database: schema/seed dipertahankan, audit tidak memaksakan perubahan tabel.
- [ ] Uji browser dan MySQL lokal: harus dijalankan di komputer pengguna.

## Batas verifikasi

Build ini menjalani pemeriksaan sintaks PHP. Uji fungsional menggunakan web browser dan server MySQL lokal tidak tersedia di lingkungan build, sehingga tidak diklaim telah lolos.
