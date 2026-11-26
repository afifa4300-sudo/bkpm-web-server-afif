<?php
header('Content-Type: application/json');

// Konfigurasi Database PDO
$host    = 'localhost';
$dbname  = 'si_akademik';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Koneksi ke database gagal: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Mengambil parameter id baik dari URL rewriting / query string
$id = $_GET['id'] ?? null;
if (!$id) {
    $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $segments = explode('/', $path);
    $lastSegment = end($segments);
    if (is_numeric($lastSegment)) {
        $id = (int)$lastSegment;
    }
} else {
    $id = (int)$id;
}

switch ($method) {
    case 'GET':
        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $mahasiswa = $stmt->fetch();

            if ($mahasiswa) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Data mahasiswa berhasil ditemukan',
                    'data'    => $mahasiswa
                ], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Data mahasiswa dengan ID ' . $id . ' tidak ditemukan'
                ], JSON_PRETTY_PRINT);
            }
        } else {
            $stmt = $pdo->query('SELECT * FROM mahasiswa ORDER BY id ASC');
            $list = $stmt->fetchAll();

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Semua data mahasiswa berhasil diambil',
                'data'    => $list
            ], JSON_PRETTY_PRINT);
        }
        break;

    case 'POST':
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Payload JSON tidak valid atau kosong'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        $nim   = trim($data['nim'] ?? '');
        $nama  = trim($data['nama'] ?? '');
        $email = trim($data['email'] ?? '');

        if ($nim === '' || $nama === '' || $email === '') {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Field nim, nama, dan email wajib diisi'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Format email tidak valid'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        try {
            $stmt = $pdo->prepare('INSERT INTO mahasiswa (nim, nama, email) VALUES (:nim, :nama, :email)');
            $stmt->execute([
                ':nim'   => $nim,
                ':nama'  => $nama,
                ':email' => $email
            ]);
            $insertedId = (int)$pdo->lastInsertId();

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Data mahasiswa berhasil ditambahkan',
                'data'    => [
                    'id'    => $insertedId,
                    'nim'   => $nim,
                    'nama'  => $nama,
                    'email' => $email
                ]
            ], JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
        break;

    case 'PUT':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Parameter ID mahasiswa wajib disertakan pada URL (/api/mahasiswa/{id})'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        // Cek keberadaan data
        $checkStmt = $pdo->prepare('SELECT id FROM mahasiswa WHERE id = :id');
        $checkStmt->execute([':id' => $id]);
        if (!$checkStmt->fetch()) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Data mahasiswa dengan ID ' . $id . ' tidak ditemukan untuk diperbarui'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Payload JSON tidak valid atau kosong'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        $nim   = trim($data['nim'] ?? '');
        $nama  = trim($data['nama'] ?? '');
        $email = trim($data['email'] ?? '');

        if ($nim === '' || $nama === '' || $email === '') {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Field nim, nama, dan email wajib diisi'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        try {
            $stmt = $pdo->prepare('UPDATE mahasiswa SET nim = :nim, nama = :nama, email = :email WHERE id = :id');
            $stmt->execute([
                ':nim'   => $nim,
                ':nama'  => $nama,
                ':email' => $email,
                ':id'    => $id
            ]);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Data mahasiswa berhasil diperbarui',
                'data'    => [
                    'id'    => $id,
                    'nim'   => $nim,
                    'nama'  => $nama,
                    'email' => $email
                ]
            ], JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Parameter ID mahasiswa wajib disertakan pada URL (/api/mahasiswa/{id})'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        // Cek keberadaan data
        $checkStmt = $pdo->prepare('SELECT id FROM mahasiswa WHERE id = :id');
        $checkStmt->execute([':id' => $id]);
        if (!$checkStmt->fetch()) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Data mahasiswa dengan ID ' . $id . ' tidak ditemukan untuk dihapus'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        try {
            $stmt = $pdo->prepare('DELETE FROM mahasiswa WHERE id = :id');
            $stmt->execute([':id' => $id]);

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Data mahasiswa berhasil dihapus'
            ], JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => "HTTP Method $method tidak diizinkan"
        ], JSON_PRETTY_PRINT);
        break;
}
