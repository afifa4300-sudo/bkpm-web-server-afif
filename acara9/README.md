# Dokumentasi & Panduan Praktikum Acara 9

**Pokok Bahasan**: OOP MVC Lanjutan: Dependency Injection, Object Composition, Getter-Setter
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A

---

## 1. Deskripsi Praktikum

Pada Acara 9, arsitektur kode aplikasi direfaktor ke tingkat lanjutan dengan menerapkan prinsip-prinsip desain berorientasi objek modern:

1. **Dependency Injection (DI)**: Objek ketergantungan (seperti Repository atau Model) diinjeksikan secara eksplisit melalui konstruktor (*Constructor Injection*), bukan diinstansiasi secara kaku (*tightly coupled*) di dalam Controller.
2. **Repository Pattern**: Lapisan pemisah antara Controller dan Model untuk memfasilitasi abstraksi akses basis data.
3. **Object Composition**: Hubungan antar objek dimodelkan menggunakan komposisi objek (*has-a relationship*), misalnya objek `Mahasiswa` yang memiliki referensi ke objek `Prodi`.

---

## 2. Struktur Berkas Acara 9

```
acara9/
├── app/
│   ├── Controllers/
│   │   └── MahasiswaController.php    # Menerima MahasiswaRepository via Constructor Injection
│   ├── Repositories/
│   │   └── MahasiswaRepository.php    # Abstraksi query & manipulasi data
│   ├── Models/
│   │   ├── Mahasiswa.php              # Entitas data murni
│   │   └── Prodi.php
│   ├── Core/
│   └── Views/
├── config/database.php
├── database/schema.sql
├── public/index.php
├── routes/web.php
└── README.md                          # Panduan arsitektur dan pengujian
```

---

## 3. Implementasi Kode Sumber

### A. Pola Repository (`app/Repositories/MahasiswaRepository.php`)

```php
<?php
namespace App\Repositories;

use App\Core\Database;
use App\Models\Mahasiswa;
use PDO;

class MahasiswaRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM mahasiswa ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById(int $id) {
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
```

### B. Dependency Injection pada Controller (`app/Controllers/MahasiswaController.php`)

```php
<?php
namespace App\Controllers;

use App\Repositories\MahasiswaRepository;

class MahasiswaController {
    private MahasiswaRepository $repository;

    // Dependency Injection melalui Constructor
    public function __construct(MahasiswaRepository $repository) {
        $this->repository = $repository;
    }

    public function index(): void {
        $data = $this->repository->getAll();
        require __DIR__ . '/../Views/mahasiswa/index.php';
    }
}
```

---

## 4. Analisis & Pembahasan Praktikum

1. **Peningkatan Kualitas Pengujian (*Testability*)**: Dengan Dependency Injection, Controller tidak terikat mati dengan basis data fisik. Saat pengujian otomatis (*Unit Testing*), objek `MahasiswaRepository` dapat dengan mudah digantikan oleh *Mock Repository*.
2. **Kopling Longgar (*Loose Coupling*)**: Modifikasi pada mekanisme penyimpanan data (misalnya migrasi dari MySQL ke PostgreSQL atau REST API eksternal) hanya memerlukan perubahan di lapisan Repository tanpa perlu merombak Controller.

---

## 5. Kesimpulan Praktikum

Penerapan Dependency Injection dan Repository Pattern mentransformasi aplikasi dari skrip prosedural-monolitik menjadi arsitektur modular enterprise yang fleksibel, mudah dirawat (*maintainable*), dan siap untuk pengujian otomatis.
