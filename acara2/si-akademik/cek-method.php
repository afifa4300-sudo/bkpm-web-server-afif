<?php
// File: cek-method.php
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $pesan = "Request ini dikirim dengan method POST. Data tidak muncul di URL.";
    $nama  = $_POST['nama'] ?? '';
} else {
    $pesan = "Request ini dikirim dengan method GET. Data (jika ada) terlihat di URL.";
    $nama  = $_GET['nama'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Method</title>
</head>
<body>
  <h1>Deteksi Method Request</h1>
  <p>Method terdeteksi: <strong><?php echo $method; ?></strong></p>
  <p><?php echo $pesan; ?></p>
  <p>Nama yang diterima: <?php echo htmlspecialchars($nama); ?></p>
 
  <form action="cek-method.php" method="GET">
    <input type="text" name="nama">
    <button type="submit">Kirim lewat GET</button>
  </form>
  <form action="cek-method.php" method="POST">
    <input type="text" name="nama">
    <button type="submit">Kirim lewat POST</button>
  </form>
</body>
</html>
