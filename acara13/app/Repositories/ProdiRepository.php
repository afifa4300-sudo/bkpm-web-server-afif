<?php

namespace App\Repositories;

use App\Core\BaseModel;
use App\Core\Database;
use PDO;

class ProdiRepository extends BaseModel
{
    public function __construct(Database $database)
    {
        parent::__construct($database->getConnection());
    }

    // Acara 13: mengambil daftar program studi untuk pilihan formulir.
    public function all(): array
    {
        $statement = $this->db->query(
            'SELECT id, kode, nama FROM prodi ORDER BY nama ASC'
        );

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Acara 13: memeriksa apakah program studi tersedia.
    public function exists(int $id): bool
    {
        $statement = $this->db->prepare(
            'SELECT 1 FROM prodi WHERE id = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);

        return $statement->fetchColumn() !== false;
    }
}
