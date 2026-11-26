# Checklist Pengujian Acara 14


## Security dan validasi
- [ ] Login dan logout berhasil.
- [ ] Halaman terlindungi tidak dapat dibuka saat belum login.
- [ ] Mahasiswa dengan NIM kosong ditolak.
- [ ] NIM duplikat ditolak.
- [ ] Email invalid ditolak.
- [ ] Input tidak valid tidak membuat record baru.
- [ ] Query repository menggunakan prepared statement.

## Exception dan Logging
- [ ] Simulasikan MySQL mati/tidak dapat terhubung.
- [ ] Pengguna mendapat pesan error aman, bukan stack trace/SQL.
- [ ] `storage/logs/app.log` bertambah dengan waktu dan detail error.
- [ ] Tidak ada kredensial database di log.

## PRG dan CRUD
- [ ] Create mahasiswa berhasil.
- [ ] Refresh setelah create tidak mengulang POST.
- [ ] Update mahasiswa berhasil.
- [ ] Delete mahasiswa berhasil.
- [ ] CRUD Prodi berjalan.
- [ ] CRUD Matakuliah berjalan.
- [ ] Relasi mahasiswa/matakuliah terhadap prodi tetap valid.
- [ ] Flash message hanya tampil sekali.
- [ ] Search dan pagination tetap berjalan.
