# Dokumentasi & Panduan Praktikum Acara 1

**Pokok Bahasan**: Konsep Frontend, Backend, dan Arsitektur Client-Server  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 1, mahasiswa mempelajari arsitektur dasar web, perbedaan peran antara antarmuka pengguna (*frontend*) dan logika pemrosesan di sisi server (*backend*), siklus pertukaran pesan HTTP (*Request - Response*), serta pengujian eksekusi berkas PHP melalui Web Server lokal (Apache) versus membukanya secara langsung sebagai berkas statis (*direct file*).

---

## 2. Struktur Berkas Acara 1
```
acara1/
├── info.php          # Skrip PHP pengujian eksekusi server, waktu, dan informasi lingkungan
└── README.md         # Dokumentasi panduan dan analisis praktikum
```

---

## 3. Implementasi Kode Sumber (`info.php`)
```php
<?php
// info.php - Pengujian lingkungan kerja server lokal
$nama = "Muhammad Afif Ramdhani";
$nim = "E41250223";
$golongan = "A";
$prodi = "D4 Teknik Informatika PSDKU Nganjuk";

$waktuServer = date("Y-m-d H:i:s");
$versiPHP = phpversion();
$sistemOperasi = PHP_OS;
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/XAMPP';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Server - Acara 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container">
    <div class="card shadow-sm border-0 rounded-3 p-4">
        <h2 class="text-primary mb-3">Sistem Informasi Lingkungan Server</h2>
        <p><strong>Nama:</strong> <?= $nama ?> | <strong>NIM:</strong> <?= $nim ?> | <strong>Golongan:</strong> <?= $golongan ?></p>
        <hr>
        <ul class="list-group">
            <li class="list-group-item"><strong>Waktu Server:</strong> <?= $waktuServer ?></li>
            <li class="list-group-item"><strong>Versi PHP:</strong> <?= $versiPHP ?></li>
            <li class="list-group-item"><strong>Sistem Operasi Server:</strong> <?= $sistemOperasi ?></li>
            <li class="list-group-item"><strong>Web Server Software:</strong> <?= $serverSoftware ?></li>
        </ul>
    </div>
</div>
</body>
</html>
```

---

## 4. Pengujian & Analisis Eksekusi
1. **Pengujian Direct File (`file:///C:/xampp/htdocs/.../info.php`)**:
   - Saat berkas dibuka langsung di browser tanpa melalui server, browser tidak memiliki parser/interpreter PHP.
   - Hasilnya, browser hanya menampilkan teks mentah kode program atau menawarkan opsi unduh berkas.
2. **Pengujian Melalui Web Server (`http://localhost/bkpm-web-server-afif/acara1/info.php`)**:
   - Permintaan HTTP GET diterima oleh Apache Web Server.
   - Modul PHP mengompilasi dan mengeksekusi instruksi backend, mengambil informasi waktu dinamis dan spesifikasi runtime, kemudian menghasilkan HTML bersih yang dikirimkan kembali ke browser pengguna.

---

## 5. Kesimpulan Praktikum
PHP merupakan bahasa pemrograman *server-side*. Kode PHP tidak dieksekusi di peramban web (*browser*), melainkan diselesaikan sepenuhnya di sisi server. Arsitektur Client-Server memisahkan tanggung jawab antarmuka presentasi dari data dan logika komputasi server.
