CREATE DATABASE IF NOT EXISTS db_workshop;
USE db_workshop;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    foto VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@polije.ac.id', '$2y$10$eA0E2Q7nF6jL5j9P0jH1yea6H7m6N.sQk1n7o1L0M4E5C6Z7Y8X9W', 'admin')
ON DUPLICATE KEY UPDATE role=VALUES(role);

INSERT INTO mahasiswa (nim, nama, prodi, foto) VALUES
('220100123', 'Andi Saputra', 'Teknik Informatika', NULL),
('220100124', 'Budi Santoso', 'Teknik Informatika', NULL),
('220200125', 'Citra Lestari', 'Sistem Informasi', NULL)
ON DUPLICATE KEY UPDATE nama=VALUES(nama);
