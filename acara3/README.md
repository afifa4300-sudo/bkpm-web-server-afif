# Dokumentasi & Panduan Praktikum Acara 3

**Pokok Bahasan**: Pengenalan Arsitektur MVC & Integrasi Form dengan Bootstrap 5  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 3, mahasiswa diperkenalkan dengan pola arsitektur **Model-View-Controller (MVC)** untuk menerapkan prinsip *Separation of Concerns* (pemisahan tanggung jawab kode). Pada tahap awal ini, mahasiswa merancang antarmuka antarmuka pengguna (*View*) yang bersih dan responsif menggunakan pustaka **Bootstrap 5 CDN**, meliputi tabel daftar mahasiswa dan form input data mahasiswa.

---

## 2. Struktur Berkas Acara 3
```
acara3/
├── app/
│   └── Views/
│       └── mahasiswa/
│           ├── index.php      # View tabel data mahasiswa dengan Bootstrap 5
│           └── create.php     # View form penambahan data mahasiswa
├── public/
│   └── index.php          # Titik masuk publik (Front Controller sederhana)
└── README.md              # Dokumentasi teknis dan alur praktikum
```

---

## 3. Implementasi Kode Sumber

### A. Titik Masuk Utama (`public/index.php`)
```php
<?php
// Inisialisasi data simulasi mahasiswa (mock data)
$mahasiswa = [
    ['nim' => 'E41250223', 'nama' => 'Muhammad Afif Ramdhani', 'prodi' => 'Teknik Informatika'],
    ['nim' => 'E41250001', 'nama' => 'Budi Santoso', 'prodi' => 'Teknik Informatika'],
    ['nim' => 'E41250002', 'nama' => 'Siti Aminah', 'prodi' => 'Manajemen Informatika']
];

// Menentukan tampilan berdasarkan query parameter
$action = $_GET['action'] ?? 'index';

if ($action === 'create') {
    require __DIR__ . '/../app/Views/mahasiswa/create.php';
} else {
    require __DIR__ . '/../app/Views/mahasiswa/index.php';
}
```

### B. Form Tambah Mahasiswa (`app/Views/mahasiswa/create.php`)
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa - Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-4">
<div class="container">
    <div class="card shadow-sm border-0 rounded-3 p-4 col-md-8 mx-auto">
        <h3 class="mb-3 text-primary">Form Tambah Mahasiswa</h3>
        <form action="index.php" method="POST">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required placeholder="Contoh: E41250223">
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama">
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Program Studi</label>
                <select class="form-select" id="prodi" name="prodi" required>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Manajemen Informatika">Manajemen Informatika</option>
                    <option value="Teknik Komputer">Teknik Komputer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Data</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
```

---

## 4. Analisis & Prinsip MVC
- **Pemisahan Logika**: Berkas *View* tidak boleh berisi logika pemrosesan yang rumit atau instruksi koneksi basis data mentah. Tanggung jawab *View* hanya memformat data menjadi representasi HTML yang mudah dibaca oleh pengguna.
- **Responsivitas Antarmuka**: Grid system Bootstrap 5 (`container`, `row`, `col-md-8`, `card`, `table-responsive`) memastikan tampilan aplikasi dapat menyesuaikan diri secara mulus di berbagai resolusi layar peramban (desktop maupun mobile).

---

## 5. Kesimpulan Praktikum
Melalui Acara 3, mahasiswa berhasil meletakkan pondasi antarmuka untuk aplikasi Sistem Informasi Akademik yang rapi dan terstruktur, serta memahami peran esensial *View* dalam arsitektur Model-View-Controller.
