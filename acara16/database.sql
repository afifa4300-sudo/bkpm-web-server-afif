CREATE DATABASE IF NOT EXISTS si_akademik;
USE si_akademik;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
);

INSERT INTO mahasiswa (nim, nama, email) VALUES
('23001', 'Budi', 'budi@gmail.com'),
('23002', 'Siti', 'siti@gmail.com'),
('23003', 'Andi', 'andi@gmail.com')
ON DUPLICATE KEY UPDATE nama=VALUES(nama);
