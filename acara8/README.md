# Dokumentasi & Panduan Praktikum Acara 8

**Pokok Bahasan**: PDO Singleton, Prepared Statement, Relasi Table & CRUD Lengkap  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 8, mahasiswa membangun fungsionalitas **CRUD Penuh (Create, Read, Update, Delete)** yang terhubung langsung ke basis data MySQL. Fokus utama ditekankan pada aspek **keamanan siber** dengan menerapkan **Prepared Statements** guna mencegah serangan celah keamanan **SQL Injection**, serta pemanfaatan pola perancangan **Singleton Pattern** pada koneksi PDO agar hemat penggunaan memori server.

---

## 2. Struktur Berkas Acara 8
```
acara8/
├── app/
│   ├── Controllers/
│   │   ├── MahasiswaController.php    # Aksi CRUD mahasiswa (index, create, store, edit, update, delete)
│   │   ├── MatakuliahController.php   # Resource kedua (matakuliah)
│   │   └── ProdiController.php        # Resource ketiga (prodi)
│   ├── Core/
│   │   └── Database.php               # PDO Singleton Connection
│   ├── Models/
│   │   ├── Mahasiswa.php              # Prepared Statement queries
│   │   ├── Matakuliah.php
│   │   └── Prodi.php
│   └── Views/
│       ├── mahasiswa/                 # Antarmuka create, edit, index, show
│       ├── matakuliah/
│       └── prodi/
├── config/database.php
├── database/schema.sql
├── public/index.php
├── routes/web.php
└── README.md                          # Panduan teknis dan pengujian CRUD
```

---

## 3. Implementasi Kode Sumber

### A. Pola Singleton Koneksi PDO (`app/Core/Database.php`)
```php
<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $instance = null;

    private function __construct() {} // Mencegah instansiasi langsung

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $cfg = require __DIR__ . '/../../config/database.php';
            $dsn = "mysql:host={$cfg['host']};dbname={$cfg['database']};charset={$cfg['charset']}";
            self::$instance = new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]);
        }
        return self::$instance;
    }
}
```

### B. Mitigasi SQL Injection dengan Prepared Statements (`app/Models/Mahasiswa.php`)
```php
<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Mahasiswa {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function all(): array {
        $sql = "SELECT m.*, p.nama_prodi 
                FROM mahasiswa m 
                LEFT JOIN prodi p ON m.prodi_id = p.id 
                ORDER BY m.id DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create(array $data): bool {
        // Prepared statement memisahkan instruksi SQL dari parameter pengguna
        $stmt = $this->db->prepare("INSERT INTO mahasiswa (nim, nama, prodi_id) VALUES (:nim, :nama, :prodi_id)");
        return $stmt->execute([
            ':nim'      => $data['nim'],
            ':nama'     => $data['nama'],
            ':prodi_id' => $data['prodi_id']
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
```

---

## 4. Analisis & Uji Keamanan SQL Injection
- **Skenario Serangan**: Pengguna menginputkan string manipulatif pada form nama:  
  `Afif'; DROP TABLE mahasiswa; --`
- **Hasil Proteksi**: Driver PDO memperlakukan string tersebut murni sebagai data tekstual (*literal value*), bukan sebagai instruksi eksekusi SQL. Tabel tetap aman dan tidak dapat disusupi perintah jahat.

---

## 5. Kesimpulan Praktikum
Melalui Acara 8, mahasiswa berhasil menghasilkan aplikasi MVC fungsional penuh dengan operasi CRUD yang andal, aman dari celah eksploitasi SQL Injection, dan efisien dalam pengelolaan koneksi basis data menggunakan pola Singleton.
