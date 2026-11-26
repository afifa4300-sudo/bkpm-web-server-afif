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
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// Handle GET Request (Ambil semua mahasiswa atau berdasarkan ?id=X)
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id !== null) {
        $stmt = $pdo->prepare('SELECT * FROM mahasiswa WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $mahasiswa = $stmt->fetch();

        if ($mahasiswa) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Data mahasiswa berhasil diambil',
                'data'    => $mahasiswa
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Data mahasiswa dengan ID tersebut tidak ditemukan',
                'data'    => null
            ], JSON_PRETTY_PRINT);
        }
    } else {
        $stmt = $pdo->query('SELECT * FROM mahasiswa ORDER BY id ASC');
        $data = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data'    => $data
        ], JSON_PRETTY_PRINT);
    }
    exit;
}

// Handle POST Request (Menambah data mahasiswa dari JSON input)
if ($method === 'POST') {
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);

    $nim   = trim($input['nim'] ?? '');
    $nama  = trim($input['nama'] ?? '');
    $email = trim($input['email'] ?? '');

    if ($nim === '' || $nama === '' || $email === '') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Field nim, nama, dan email wajib diisi'
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
        $idBaru = $pdo->lastInsertId();

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Data mahasiswa berhasil ditambahkan',
            'data'    => [
                'id'    => (int) $idBaru,
                'nim'   => $nim,
                'nama'  => $nama,
                'email' => $email
            ]
        ], JSON_PRETTY_PRINT);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal menyimpan data ke basis data: ' . $e->getMessage()
        ], JSON_PRETTY_PRINT);
    }
    exit;
}

// Jika request method selain GET atau POST
http_response_code(405);
echo json_encode([
    'success' => false,
    'message' => "Method $method tidak diizinkan pada endpoint ini"
], JSON_PRETTY_PRINT);
exit;
