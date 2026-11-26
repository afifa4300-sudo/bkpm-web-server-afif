<?php
// File: info.php
date_default_timezone_set("Asia/Jakarta");
$nama = "Muhammad Afif Ramdhani";
$nim = "E41250223";
$waktu = date("Y-m-d H:i:s");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Info Server</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 8px;
        }

        th {
            background: #e8e8e8;
        }
    </style>
</head>

<body>
    <h1>Informasi Server</h1>
    <table>
        <tr>
            <th>Item</th>
            <th>Nilai</th>
        </tr>
        <tr>
            <td>Nama</td>
            <td><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td>NIM</td>
            <td><?php echo $nim; ?></td>
        </tr>
        <tr>
            <td>Waktu server</td>
            <td><?php echo $waktu; ?></td>
        </tr>
        <tr>
            <td>Versi PHP</td>
            <td><?php echo phpversion(); ?></td>
        </tr>
        <tr>
            <td>Sistem operasi server</td>
            <td><?php echo PHP_OS; ?></td>
        </tr>
    </table>
</body>

</html>
