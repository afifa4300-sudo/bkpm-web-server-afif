# Dokumentasi & Panduan Praktikum Acara 10

**Pokok Bahasan**: Refaktorisasi Arsitektur OOP: Inheritance, Abstract Class, dan Interface  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 10, arsitektur OOP disempurnakan dengan menerapkan prinsip **Polimorfisme**, **Pewarisan (*Inheritance*)**, dan **Abstraksi**:
1. **BaseController (`Abstract Class`)**: Menyediakan kerangka dasar bagi seluruh Controller, termasuk metode pembantu render View (`render()`) dan pengalihan halaman (`redirect()`).
2. **BaseModel (`Abstract Class`)**: Menyediakan fungsi-fungsi dasar ORM/Active Record seperti `find()`, `all()`, dan `delete()`.
3. **Pewarisan (*Inheritance*)**: Menghilangkan duplikasi logika antar Controller dan Model melalui kata kunci `extends`.

---

## 2. Struktur Berkas Acara 10
```
acara10/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php         # Mewarisi BaseController
│   │   ├── HomeController.php
│   │   ├── MahasiswaController.php
│   │   ├── MatakuliahController.php
│   │   └── ProdiController.php
│   ├── Core/
│   │   ├── BaseController.php         # Abstract Class induk Controller
│   │   ├── BaseModel.php              # Abstract Class induk Model
│   │   └── Database.php
│   ├── Models/
│   │   ├── Mahasiswa.php              # Mewarisi BaseModel
│   │   ├── Matakuliah.php
│   │   └── Prodi.php
│   ├── Repositories/
│   └── Views/
├── config/database.php
├── database/schema.sql
├── public/index.php
├── routes/web.php
└── README.md                          # Panduan arsitektur dan refaktorisasi
```

---

## 3. Implementasi Kode Sumber

### A. Abstract BaseController (`app/Core/BaseController.php`)
```php
<?php
namespace App\Core;

abstract class BaseController {
    /**
     * Helper untuk merender view ke dalam layout master
     */
    protected function render(string $viewPath, array $data = []): void {
        extract($data);
        $content = __DIR__ . '/../Views/' . $viewPath . '.php';
        require __DIR__ . '/../Views/layouts/main.php';
    }

    /**
     * Helper untuk HTTP redirect
     */
    protected function redirect(string $path): void {
        header("Location: " . BASE_URL . $path);
        exit;
    }
}
```

### B. Implementasi Inheritance pada Controller (`app/Controllers/MahasiswaController.php`)
```php
<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Repositories\MahasiswaRepository;

class MahasiswaController extends BaseController {
    private MahasiswaRepository $repository;

    public function __construct(MahasiswaRepository $repository) {
        $this->repository = $repository;
    }

    public function index(): void {
        $mahasiswaList = $this->repository->getAll();
        
        // Memanfaatkan method turunan dari BaseController
        $this->render('mahasiswa/index', [
            'mahasiswa' => $mahasiswaList,
            'title'     => 'Daftar Mahasiswa Polije'
        ]);
    }
}
```

---

## 4. Analisis & Pembahasan Praktikum
1. **Penerapan Polimorfisme & Abstraksi**: Class abstract `BaseController` tidak dapat diinstansiasi secara langsung (`new BaseController()` akan memicu error), melainkan hanya berfungsi sebagai kontrak fondasi bagi class-class turunannya.
2. **Efisiensi Kode (DRY)**: Semua controller kini tidak perlu lagi menuliskan baris `extract($data)` atau `require layouts/main.php` secara berulang-ulang, cukup memanggil `$this->render()`.

---

## 5. Kesimpulan Praktikum
Refaktorisasi pada Acara 10 melengkapi transformasi arsitektur OOP Sistem Informasi Akademik menjadi standar kerangka kerja (*framework*) modern mandiri (*custom micro-framework*) yang elegan, konsisten, dan mematuhi prinsip SOLID.
