# Dokumentasi & Panduan Praktikum Acara 6

**Pokok Bahasan**: Middleware, Autentikasi Sederhana, dan Struktur Folder Lengkap  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 6, mahasiswa mengimplementasikan lapisan **Middleware** sebagai penyaring (*filter/gatekeeper*) sebelum suatu permintaan HTTP diizinkan mencapai Controller tujuan. Praktikum ini juga mencakup mekanisme autentikasi sesi pengguna (**Login berbasis Session**) dan proteksi halaman penting dari akses tanpa izin.

---

## 2. Struktur Berkas Acara 6
```
acara6/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php         # Menangani login, validasi sesi, dan logout
│   │   ├── HomeController.php         # Menangani dashboard terproteksi
│   │   └── MahasiswaController.php    # Menangani kelola data mahasiswa
│   ├── Core/
│   │   └── Middleware/
│   │       └── AuthMiddleware.php     # Filter gerbang sesi login
│   ├── Models/
│   │   └── Mahasiswa.php
│   └── Views/
│       ├── auth/login.php             # Form login sistem
│       ├── dashboard.php              # Halaman terproteksi
│       └── layouts/
├── public/
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── web.php
└── README.md                          # Panduan teknis dan pengujian
```

---

## 3. Implementasi Kode Sumber

### A. Auth Middleware (`app/Core/Middleware/AuthMiddleware.php`)
```php
<?php
namespace App\Core\Middleware;

class AuthMiddleware {
    public static function handle(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Memeriksa apakah session login pengguna aktif
        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            // Simpan flash message jika belum terautentikasi
            $_SESSION['flash_error'] = 'Silakan masuk terlebih dahulu untuk mengakses sistem.';
            
            // Redirect ke halaman login
            header('Location: /bkpm-web-server-afif/acara6/public/login');
            exit;
        }
    }
}
```

### B. Controller Autentikasi (`app/Controllers/AuthController.php`)
```php
<?php
namespace App\Controllers;

class AuthController {
    public function showLoginForm(): void {
        require __DIR__ . '/../Views/auth/login.php';
    }

    public function login(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Kredensial default praktikum Acara 6
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_name'] = 'Administrator Afif';
            header('Location: /bkpm-web-server-afif/acara6/public/dashboard');
            exit;
        } else {
            $_SESSION['flash_error'] = 'Kombinasi username atau password salah!';
            header('Location: /bkpm-web-server-afif/acara6/public/login');
            exit;
        }
    }

    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header('Location: /bkpm-web-server-afif/acara6/public/login');
        exit;
    }
}
```

---

## 4. Analisis & Pengujian Proteksi Rute
1. **Pengujian Akses Rute Terproteksi (`/dashboard` atau `/mahasiswa`)**:
   - Jika pengguna membuka halaman tersebut tanpa login, `AuthMiddleware::handle()` mencegat request, membatalkan rendering Controller, dan secara otomatis mengalihkan browser ke `/login`.
2. **Pengujian Login Sukses**:
   - Mengisi `admin / admin123` menginisialisasi variabel `$_SESSION['logged_in'] = true`, dan browser diarahkan ke dashboard.
3. **Pembersihan Sesi Logout**:
   - Menekan tombol Logout memanggil `session_destroy()`, sehingga token sesi dihapus dari server dan halaman kembali terproteksi.

---

## 5. Kesimpulan Praktikum
Lapisan Middleware merupakan solusi elegan dalam mengisolasi otorisasi dan validasi pra-eksekusi. Logika pengecekan otentikasi tidak perlu ditulis berulang kali di setiap controller (*anti-pattern*), melainkan cukup dipanggil sekali pada router melalui Middleware.
