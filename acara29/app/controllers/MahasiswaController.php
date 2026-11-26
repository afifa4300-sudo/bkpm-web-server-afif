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

    // Langkah 4 BKPM Acara 26: Upload Berkas Gambar dengan Validasi Ketat
    public function store(): void {
        Auth::requireAdmin();

        // Mendukung request FormData (multipart) maupun raw JSON
        $isMultipart = !empty($_POST) || !empty($_FILES);
        $data = $isMultipart ? $_POST : json_decode(file_get_contents('php://input'), true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload tidak valid');
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
            'prodi' => $prodi,
            'foto'  => null
        ];

        // Validasi dan pemindahan file foto jika diunggah
        if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['foto'];
            $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ekstensi, ['jpg', 'jpeg', 'png']) || !exif_imagetype($file['tmp_name'])) {
                Response::json(422, false, 'Berkas harus berupa gambar JPG/PNG yang valid');
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                Response::json(422, false, 'Ukuran berkas maksimal 2MB');
            }

            $namaBaru = uniqid('foto_', true) . '.' . $ekstensi;
            $tujuan = __DIR__ . '/../../public/uploads/' . $namaBaru;

            if (move_uploaded_file($file['tmp_name'], $tujuan)) {
                $insertData['foto'] = $namaBaru;
            }
        }

        $id = $this->model->create($insertData);
        Response::json(201, true, 'Data berhasil ditambahkan', ['id' => (int)$id, 'foto' => $insertData['foto']]);
    }

    public function update($id): void {
        Auth::requireAdmin();

        if (!$id) {
            Response::json(400, false, 'Parameter id wajib disertakan pada request');
        }

        $existing = $this->model->find((int)$id);
        if (!$existing) {
            Response::json(404, false, "Data mahasiswa dengan ID $id tidak ditemukan untuk diperbarui");
        }

        $isMultipart = !empty($_POST) || !empty($_FILES);
        $data = $isMultipart ? $_POST : json_decode(file_get_contents('php://input'), true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload tidak valid');
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
            'prodi' => $prodi,
        ];

        // Tugas Mandiri 1 Acara 26: Hapus foto lama menggunakan unlink jika foto baru diunggah
        if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['foto'];
            $ekstensi = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ekstensi, ['jpg', 'jpeg', 'png']) || !exif_imagetype($file['tmp_name'])) {
                Response::json(422, false, 'Berkas harus berupa gambar JPG/PNG yang valid');
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                Response::json(422, false, 'Ukuran berkas maksimal 2MB');
            }

            $namaBaru = uniqid('foto_', true) . '.' . $ekstensi;
            $tujuan = __DIR__ . '/../../public/uploads/' . $namaBaru;

            if (move_uploaded_file($file['tmp_name'], $tujuan)) {
                // Hapus berkas lama jika ada
                if (!empty($existing['foto'])) {
                    $fotoLamaPath = __DIR__ . '/../../public/uploads/' . $existing['foto'];
                    if (file_exists($fotoLamaPath)) {
                        @unlink($fotoLamaPath);
                    }
                }
                $updateData['foto'] = $namaBaru;
            }
        }

        $this->model->update((int)$id, $updateData);
        Response::json(200, true, 'Data berhasil diperbarui', [
            'id'    => (int)$id,
            'nim'   => $nim,
            'nama'  => $nama,
            'prodi' => $prodi,
            'foto'  => $updateData['foto'] ?? $existing['foto']
        ]);
    }

    public function destroy($id): void {
        Auth::requireAdmin();

        if (!$id) {
            Response::json(400, false, 'Parameter id wajib disertakan pada request');
        }

        $existing = $this->model->find((int)$id);
        if (!$existing) {
            Response::json(404, false, "Data mahasiswa dengan ID $id tidak ditemukan untuk dihapus");
        }

        // Hapus foto terkait jika ada
        if (!empty($existing['foto'])) {
            $fotoPath = __DIR__ . '/../../public/uploads/' . $existing['foto'];
            if (file_exists($fotoPath)) {
                @unlink($fotoPath);
            }
        }

        $this->model->delete((int)$id);
        Response::json(200, true, 'Data berhasil dihapus');
    }
}
