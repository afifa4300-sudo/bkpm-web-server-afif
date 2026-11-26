# Dokumentasi & Panduan Praktikum Acara 5

**Pokok Bahasan**: Routing Sederhana, URL Rewriting (.htaccess), Request & Response  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 5, mahasiswa mengimplementasikan pola **Front Controller** dengan memanfaatkan fitur **URL Rewriting Apache (`.htaccess`)**. Seluruh permintaan HTTP dari browser dialihkan secara terpusat ke `public/index.php`. Selanjutnya, skrip *Router* membaca *URI Path* dan *HTTP Method* untuk meneruskan eksekusi ke *Controller* dan metode aksi yang sesuai.

---

## 2. Struktur Berkas Acara 5
```
acara5/
├── app/
│   ├── Controllers/
│   │   ├── HomeController.php         # Menangani halaman utama / dashboard
│   │   └── MahasiswaController.php    # Menangani operasi resource mahasiswa
│   ├── Models/
│   │   └── Mahasiswa.php              # Model entitas mahasiswa
│   └── Views/
│       ├── layouts/main.php
│       ├── partials/
│       └── mahasiswa/
│           ├── index.php
│           ├── create.php
│           └── show.php
├── public/
│   ├── .htaccess                      # Aturan mod_rewrite Apache
│   └── index.php                      # Front Controller
├── routes/
│   └── web.php                        # Definisi tabel pemetaan rute
└── README.md                          # Panduan teknis dan pengujian
```

---

## 3. Implementasi Kode Sumber

### A. Aturan URL Rewriting (`public/.htaccess`)
```apache
RewriteEngine On
# Jika file atau direktori fisik ada, buka langsung
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
# Jika tidak ada, arahkan seluruh request ke index.php
RewriteRule ^ index.php [QSA,L]
```

### B. Pemetaan Rute dan Dispatcher (`public/index.php`)
```php
<?php
require_once __DIR__ . '/../routes/web.php';

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method     = $_SERVER['REQUEST_METHOD'];

// Normalisasi base path aplikasi
$basePath = '/bkpm-web-server-afif/acara5/public';
$uri      = str_replace($basePath, '', $requestUri);
$uri      = ($uri === '' || $uri === '/') ? '/' : rtrim($uri, '/');

// Pemeriksaan ketersediaan rute
if (isset($routes[$method][$uri])) {
    [$controllerClass, $action] = $routes[$method][$uri];
    $controller = new $controllerClass();
    $controller->$action();
} else {
    // 404 Not Found Handling
    http_response_code(404);
    echo "<h1>404 Halaman Tidak Ditemukan</h1>";
    echo "<p>Rute untuk URI [{$method}] <strong>{$uri}</strong> tidak terdaftar.</p>";
}
```

---

## 4. Analisis & Pembahasan Praktikum
1. **URL Menjadi Bersih (*Clean URLs*)**: Pengguna tidak lagi mengakses berkas PHP secara langsung (seperti `/mahasiswa/index.php?id=1`), melainkan melalui pola URL yang elegan dan ramah SEO seperti `/mahasiswa` atau `/mahasiswa/create`.
2. **Keamanan Struktur Direktori**: Dengan Front Controller, pengguna tidak dapat mengetahui struktur fisik folder di dalam server karena semua permintaan disaring melalui satu gerbang utama di `public/index.php`.

---

## 5. Kesimpulan Praktikum
Penerapan URL Rewriting dan mekanisme Routing Front Controller merupakan standar arsitektur web modern yang menjamin keamanan berkas backend serta memberikan kendali penuh dalam mengarahkan alur kerja request ke Controller yang tepat.
