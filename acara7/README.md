# Dokumentasi & Panduan Praktikum Acara 7

**Pokok Bahasan**: Perancangan Database Relasional, CREATE TABLE, dan Model Dasar  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 7, mahasiswa mempelajari perancangan basis data relasional (*Relational Database Management System* / RDBMS) menggunakan **MySQL**. Mahasiswa merancang skema tabel dengan batasan integritas data (*Foreign Key Constraints*), menyiapkan berkas konfigurasi koneksi PDO, serta mengawali pembuatan class Model terstruktur.

---

## 2. Struktur Berkas Acara 7
```
acara7/
├── app/
│   ├── Controllers/
│   ├── Core/
│   │   ├── Database.php               # Class konfigurasi PDO MySQL
│   │   └── Middleware/
│   ├── Models/
│   │   └── Mahasiswa.php              # Model awal yang terhubung dengan tabel mahasiswa
│   └── Views/
├── config/
│   └── database.php                   # Kredensial koneksi database
├── database/
│   └── status.sql                     # Skrip DDL tabel dan data awalan
├── public/
├── routes/
└── README.md                          # Panduan teknis dan eksekusi database
```

---

## 3. Implementasi Kode Sumber

### A. Skema Basis Data Relasional (`database/status.sql`)
```sql
CREATE DATABASE IF NOT EXISTS si_akademik;
USE si_akademik;

-- Tabel Master Program Studi
CREATE TABLE IF NOT EXISTS prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_prodi VARCHAR(10) NOT NULL UNIQUE,
    nama_prodi VARCHAR(100) NOT NULL
);

-- Tabel Master Mahasiswa dengan Relasi Foreign Key
CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    prodi_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_mahasiswa_prodi 
        FOREIGN KEY (prodi_id) REFERENCES prodi(id)
        ON UPDATE CASCADE 
        ON DELETE RESTRICT
);

-- Seeding Data Awal
INSERT INTO prodi (kode_prodi, nama_prodi) VALUES 
('TIF', 'D4 Teknik Informatika'),
('MIF', 'D3 Manajemen Informatika'),
('TKK', 'D4 Teknik Komputer')
ON DUPLICATE KEY UPDATE nama_prodi=VALUES(nama_prodi);
```

### B. Konfigurasi Koneksi PDO (`app/Core/Database.php`)
```php
<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    public static function connect(): PDO {
        $config = require __DIR__ . '/../../config/database.php';

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            return new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
}
```

---

## 4. Analisis & Pembahasan Praktikum
1. **Integritas Referensial (`FOREIGN KEY`)**: Dengan menambahkan `CONSTRAINT fk_mahasiswa_prodi`, sistem menjamin tidak ada data mahasiswa yang terhubung ke ID program studi yang tidak terdaftar.
2. **Klausul `ON DELETE RESTRICT`**: Mencegah data Program Studi terhapus apabila masih terdapat data mahasiswa yang terikat pada prodi tersebut, sehingga integritas data akademik tetap terjaga.

---

## 5. Kesimpulan Praktikum
Perancangan skema relasional yang tepat merupakan prasyarat mutlak sistem enterprise. Dengan dukungan driver PDO dan konfigurasi terisolasi, aplikasi siap melakukan transaksi data dinamis secara aman.
