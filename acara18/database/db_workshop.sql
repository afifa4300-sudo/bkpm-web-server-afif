CREATE DATABASE IF NOT EXISTS db_workshop;
USE db_workshop;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa (nim, nama, prodi) VALUES
('220100123', 'Andi Saputra', 'Teknik Informatika'),
('220100124', 'Budi Santoso', 'Teknik Informatika'),
('220200125', 'Citra Lestari', 'Sistem Informasi')
ON DUPLICATE KEY UPDATE nama=VALUES(nama);
