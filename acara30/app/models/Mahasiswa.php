<?php
class Mahasiswa {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll(): array {
        return $this->db->query('SELECT * FROM mahasiswa ORDER BY id DESC')->fetchAll();
    }

    public function find(int $id) {
        $stmt = $this->db->prepare('SELECT * FROM mahasiswa WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function existsByNim(string $nim, ?int $excludeId = null): bool {
        if ($excludeId !== null) {
            $stmt = $this->db->prepare('SELECT id FROM mahasiswa WHERE nim = :nim AND id != :id LIMIT 1');
            $stmt->execute([':nim' => $nim, ':id' => $excludeId]);
        } else {
            $stmt = $this->db->prepare('SELECT id FROM mahasiswa WHERE nim = :nim LIMIT 1');
            $stmt->execute([':nim' => $nim]);
        }
        return $stmt->fetch() !== false;
    }

    // Langkah 3 BKPM Acara 26: Menerima kolom foto
    public function create(array $data): string {
        $stmt = $this->db->prepare(
            'INSERT INTO mahasiswa (nim, nama, prodi, foto) VALUES (:nim, :nama, :prodi, :foto)'
        );
        $stmt->execute([
            ':nim'   => $data['nim'],
            ':nama'  => $data['nama'],
            ':prodi' => $data['prodi'],
            ':foto'  => $data['foto'] ?? null,
        ]);
        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void {
        $fields = 'nim = :nim, nama = :nama, prodi = :prodi';
        $params = [
            ':nim'   => $data['nim'],
            ':nama'  => $data['nama'],
            ':prodi' => $data['prodi'],
            ':id'    => $id
        ];

        if (array_key_exists('foto', $data)) {
            $fields .= ', foto = :foto';
            $params[':foto'] = $data['foto'];
        }

        $stmt = $this->db->prepare("UPDATE mahasiswa SET $fields WHERE id = :id");
        $stmt->execute($params);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare('DELETE FROM mahasiswa WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
