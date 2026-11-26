<?php
class MahasiswaController {
    private Mahasiswa $model;

    public function __construct() {
        $this->model = new Mahasiswa();
    }

    public function index(): void {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $data = $this->model->find((int) $id);
            if (!$data) {
                Response::json(404, false, "Data mahasiswa dengan ID $id tidak ditemukan");
            }
            Response::json(200, true, 'Data berhasil diambil', $data);
        }
        Response::json(200, true, 'Data berhasil diambil', $this->model->getAll());
    }

    // Dilindungi autentikasi JWT (Langkah 4 BKPM Acara 20)
    public function store(): void {
        Auth::requireAuth();

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload JSON tidak valid');
        }

        $nim   = trim($data['nim'] ?? '');
        $nama  = trim($data['nama'] ?? '');
        $prodi = trim($data['prodi'] ?? '');

        $errors = [];
        if ($nim === '')   $errors['nim'] = 'Field nim wajib diisi';
        if ($nama === '')  $errors['nama'] = 'Field nama wajib diisi';
        if ($prodi === '') $errors['prodi'] = 'Field prodi wajib diisi';

        if (!empty($errors)) {
            Response::json(400, false, 'Field nim, nama, dan prodi wajib diisi', null, $errors);
        }

        if (strlen($nim) !== 9 || !ctype_digit($nim)) {
            Response::json(422, false, 'Format NIM tidak valid, harus 9 digit angka', null, [
                'nim' => 'NIM harus berupa 9 digit numerik'
            ]);
        }

        if ($this->model->existsByNim($nim)) {
            Response::json(422, false, 'NIM sudah terdaftar dalam sistem', null, [
                'nim' => 'NIM sudah terdaftar, silakan gunakan NIM yang lain'
            ]);
        }

        $insertData = [
            'nim'   => $nim,
            'nama'  => $nama,
            'prodi' => $prodi
        ];

        $id = $this->model->create($insertData);
        Response::json(201, true, 'Data berhasil ditambahkan', ['id' => (int)$id]);
    }

    // Dilindungi autentikasi JWT (Langkah 4 BKPM Acara 20)
    public function update($id): void {
        Auth::requireAuth();

        if (!$id) {
            Response::json(400, false, 'Parameter id wajib disertakan pada request');
        }

        $existing = $this->model->find((int)$id);
        if (!$existing) {
            Response::json(404, false, "Data mahasiswa dengan ID $id tidak ditemukan untuk diperbarui");
        }

        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload JSON tidak valid');
        }

        $nim   = trim($data['nim'] ?? '');
        $nama  = trim($data['nama'] ?? '');
        $prodi = trim($data['prodi'] ?? '');

        $errors = [];
        if ($nim === '')   $errors['nim'] = 'Field nim wajib diisi';
        if ($nama === '')  $errors['nama'] = 'Field nama wajib diisi';
        if ($prodi === '') $errors['prodi'] = 'Field prodi wajib diisi';

        if (!empty($errors)) {
            Response::json(400, false, 'Field nim, nama, dan prodi wajib diisi', null, $errors);
        }

        if (strlen($nim) !== 9 || !ctype_digit($nim)) {
            Response::json(422, false, 'Format NIM tidak valid, harus 9 digit angka', null, [
                'nim' => 'NIM harus berupa 9 digit numerik'
            ]);
        }

        if ($this->model->existsByNim($nim, (int)$id)) {
            Response::json(422, false, 'NIM sudah terdaftar pada mahasiswa lain', null, [
                'nim' => 'NIM ini sudah digunakan oleh data lain'
            ]);
        }

        $updateData = [
            'nim'   => $nim,
            'nama'  => $nama,
            'prodi' => $prodi
        ];

        $this->model->update((int)$id, $updateData);
        Response::json(200, true, 'Data berhasil diperbarui', [
            'id'    => (int)$id,
            'nim'   => $nim,
            'nama'  => $nama,
            'prodi' => $prodi
        ]);
    }

    // Dilindungi autentikasi JWT (Langkah 4 BKPM Acara 20)
    public function destroy($id): void {
        Auth::requireAuth();

        if (!$id) {
            Response::json(400, false, 'Parameter id wajib disertakan pada request');
        }

        $existing = $this->model->find((int)$id);
        if (!$existing) {
            Response::json(404, false, "Data mahasiswa dengan ID $id tidak ditemukan untuk dihapus");
        }

        $this->model->delete((int)$id);
        Response::json(200, true, 'Data berhasil dihapus');
    }
}
