# Dokumentasi & Panduan Praktikum Acara 2

**Pokok Bahasan**: HTTP, Instalasi XAMPP, dan Tools Pengembangan  
**Mata Kuliah**: Workshop Sistem Informasi Web Server (TIF330805)  
**Program Studi**: D4 Teknik Informatika PSDKU Nganjuk - Politeknik Negeri Jember  
**Praktikan**: Muhammad Afif Ramdhani (NIM: E41250223) / Golongan A  

---

## 1. Deskripsi Praktikum
Pada Acara 2, mahasiswa memahami sifat dasar protokol HTTP (*stateless*), perbedaan metode pengiriman data HTTP (khususnya `GET` versus `POST`), konfigurasi *environment* pengembangan menggunakan XAMPP (Apache, MySQL, PHP), serta pengenalan dasar struktur proyek web `si-akademik`.

---

## 2. Struktur Berkas Acara 2
```
acara2/
├── si-akademik/
│   ├── index.php          # Form antarmuka pencarian (GET) dan autentikasi login (POST)
│   └── cek-method.php     # Skrip penerima dan pemeriksa request method $_SERVER['REQUEST_METHOD']
└── README.md              # Dokumentasi teknis dan panduan pengujian
```

---

## 3. Implementasi Kode Sumber

### A. Deteksi Method dan Parameter (`cek-method.php`)
```php
<?php
// Deteksi HTTP Request Method
$method = $_SERVER['REQUEST_METHOD'];

echo "<h2>Deteksi HTTP Method: $method</h2>";

if ($method === 'GET') {
    $keyword = htmlspecialchars($_GET['keyword'] ?? '', ENT_QUOTES, 'UTF-8');
    echo "<p>Metode GET terdeteksi. Data terlihat di URL.</p>";
    echo "<p>Kata kunci pencarian: <strong>$keyword</strong></p>";
} elseif ($method === 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'] ?? '';
    echo "<p>Metode POST terdeteksi. Data dikirim melalui Request Body (aman/tersembunyi dari URL).</p>";
    echo "<p>Username: <strong>$username</strong> | Panjang Password: " . strlen($password) . " karakter</p>";
}
```

---

## 4. Pengujian & Perbedaan HTTP GET vs POST

| Karakteristik | HTTP GET | HTTP POST |
| :--- | :--- | :--- |
| **Lokasi Data** | Tersemat pada URL (*Query String*, misal: `?keyword=afif`) | Berada pada *HTTP Request Body* |
| **Visibilitas** | Terlihat jelas pada bilah alamat browser dan riwayat (*history*) | Tidak terlihat pada URL browser |
| **Keamanan** | Tidak aman untuk data sensitif (password, token) | Lebih aman untuk kredensial dan manipulasi data |
| **Batas Ukuran** | Terbatas (umumnya maksimum 2048 karakter) | Lebih fleksibel (bisa megabyte hingga gigabyte) |
| **Tujuan Penggunaan** | Mengambil/mencari/memfilter data (*idempotent*) | Mengirimkan data baru, update, dan autentikasi |

---

## 5. Kesimpulan Praktikum
Protokol HTTP bersifat *stateless* di mana setiap request dianggap berdiri sendiri tanpa mengingat request sebelumnya. Penggunaan metode `GET` sangat ideal untuk operasi filter data yang dapat dibagikan (*bookmarkable*), sedangkan metode `POST` wajib digunakan untuk transaksi data sensitif dan perubahan status pada server.
