<?php
// File: index.php
echo "<h1>Selamat datang di SI Akademik</h1>";
echo "<ul>";
echo "<li><a href='form-get.html'>Form pencarian (GET)</a></li>";
echo "<li><a href='form-post.html'>Form login (POST)</a></li>";
echo "<li><a href='cek-method.php'>Cek method request</a></li>";
echo "</ul>";

$keyword = $_GET['keyword'] ?? '';
echo "Anda mencari: " . htmlspecialchars($keyword);

// File: login.php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
// Jangan echo password di production!
echo "Username yang dikirim: " . htmlspecialchars($username);
?>


<!-- form-get.html -->
<form action="proses.php" method="GET">
  <label>Cari Mahasiswa:</label>
  <input type="text" name="keyword" value="Budi">
  <button type="submit">Cari</button>
</form>

<!-- form-post.html -->
<form action="login.php" method="POST">
  <label>Username:</label>
  <input type="text" name="username">
  <label>Password:</label>
  <input type="password" name="password">
  <button type="submit">Login</button>
</form>
