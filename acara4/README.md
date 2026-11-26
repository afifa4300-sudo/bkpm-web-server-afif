# Dokumentasi & Panduan Praktikum Acara 4

**Pokok Bahasan**: PHP Native View, Layout/Partials, dan Dasar Pemrograman Berorientasi Objek (OOP)  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 4, mahasiswa mengimplementasikan modularisasi antarmuka pengguna dengan memanfaatkan teknik *Layout & Partials* (`header`, `navbar`, `footer`) guna menerapkan prinsip **DRY (Don't Repeat Yourself)**. Selain itu, mahasiswa mulai membangun fondasi pemrograman berorientasi objek (*Object-Oriented Programming* / OOP) pada sisi *Model* melalui pembuatan class, enkapsulasi (*access modifier* `private`), *constructor*, serta *getter & setter*.

---

## 2. Struktur Berkas Acara 4
```
acara4/
├── app/
│   ├── Models/
│   │   └── Mahasiswa.php      # Class entitas Mahasiswa dengan prinsip enkapsulasi OOP
│   └── Views/
│       ├── layouts/
│       │   └── main.php       # Master layout utama
│       ├── partials/
│       │   ├── header.php     # Template header HTML & CSS
│       │   ├── navbar.php     # Navigasi sistem
│       │   └── footer.php     # Template footer & JavaScript Bootstrap
│       └── mahasiswa/
│           ├── index.php      # View daftar mahasiswa
│           └── create.php     # View form mahasiswa
├── public/
│   └── index.php          # Entry point aplikasi
└── README.md              # Panduan teknis dan pengujian
```

---

## 3. Implementasi Kode Sumber

### A. Class Model Mahasiswa (`app/Models/Mahasiswa.php`)
```php
<?php
namespace App\Models;

class Mahasiswa {
    private string $nim;
    private string $nama;
    private string $prodi;

    public function __construct(string $nim, string $nama, string $prodi) {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->prodi = $prodi;
    }

    // Getter methods
    public function getNim(): string {
        return $this->nim;
    }

    public function getNama(): string {
        return $this->nama;
    }

    public function getProdi(): string {
        return $this->prodi;
    }

    // Setter methods
    public function setNama(string $nama): void {
        $this->nama = $nama;
    }

    public function setProdi(string $prodi): void {
        $this->prodi = $prodi;
    }
}
```

### B. Master Layout Template (`app/Views/layouts/main.php`)
```php
<!DOCTYPE html>
<html lang="id">
<head>
    <?php require __DIR__ . '/../partials/header.php'; ?>
</head>
<body class="bg-light">
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <main class="container py-4">
        <!-- Injeksi konten spesifik halaman -->
        <?php require $contentView; ?>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
```

---

## 4. Analisis & Pembahasan Praktikum
1. **Keunggulan Modular Layout**: Dengan memisahkan `header.php`, `navbar.php`, dan `footer.php`, setiap pembaruan navigasi atau stylesheet CDN cukup dilakukan pada satu berkas, dan secara otomatis diterapkan di seluruh halaman aplikasi.
2. **Penerapan Enkapsulasi**: Properti pada class `Mahasiswa` dibuat `private` agar nilai atribut terlindungi dari manipulasi tidak sah di luar class. Akses terhadap nilai atribut hanya diizinkan melalui metode publik (*getter* dan *setter*).

---

## 5. Kesimpulan Praktikum
Penerapan arsitektur Layout/Partials berhasil mengeliminasi duplikasi kode antarmuka. Integrasi konsep dasar OOP pada class Model membiasakan pengembang mengorganisasikan data entitas secara terstruktur dan aman.
