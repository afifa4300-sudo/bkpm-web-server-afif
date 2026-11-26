<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use App\Services\MahasiswaService;

class MahasiswaController extends BaseController
{
    // Acara 13: controller menerima repository untuk data tampilan dan service untuk proses bisnis.
    public function __construct(
        private MahasiswaRepository $repository,
        private ProdiRepository $prodiRepository,
        private MahasiswaService $service
    ) {
    }

    // Menampilkan daftar mahasiswa.
    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $total = $this->repository->count($search);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;
        $mahasiswa = $this->repository->all($search, $perPage, $offset);

        $title = 'Data Mahasiswa | SI Akademik';
        $content = __DIR__ . '/../Views/mahasiswa/index.php';
        $this->view($content, get_defined_vars());
    }

    // Menampilkan formulir tambah mahasiswa.
    public function create(): void
    {
        $prodi = $this->prodiRepository->all();
        $formData = $_SESSION['old_input'] ?? [];
        unset($_SESSION['old_input']);

        $title = 'Tambah Mahasiswa | SI Akademik';
        $content = __DIR__ . '/../Views/mahasiswa/create.php';
        $this->view($content, get_defined_vars());
    }

    // Menampilkan formulir edit mahasiswa.
    public function edit(int $id): void
    {
        $item = $this->repository->find($id);

        if ($item === null) {
            http_response_code(404);
            echo '404 - Data mahasiswa tidak ditemukan';
            return;
        }

        $item = array_merge($item, $_SESSION['old_input'] ?? []);
        unset($_SESSION['old_input']);
        $prodi = $this->prodiRepository->all();

        $title = 'Edit Mahasiswa | SI Akademik';
        $content = __DIR__ . '/../Views/mahasiswa/edit.php';
        $this->view($content, get_defined_vars());
    }

    // Menampilkan detail mahasiswa.
    public function show(int $id): void
    {
        $item = $this->repository->find($id);

        if ($item === null) {
            http_response_code(404);
            echo '404 - Data mahasiswa tidak ditemukan';
            return;
        }

        $title = 'Detail Mahasiswa | SI Akademik';
        $content = __DIR__ . '/../Views/mahasiswa/show.php';
        $this->view($content, get_defined_vars());
    }

    // Acara 13: menerima request tambah dan menyerahkan validasi serta proses ke Service.
    public function store(): void
    {
        $result = $this->service->create($_POST);

        if (!$result['success']) {
            $_SESSION['old_input'] = $_POST;
            $errors = $result['errors'];
            $message = $errors['nim'] ?? $errors['general'] ?? reset($errors);
            $this->setFlash('danger', $message ?: 'Data gagal disimpan.');
            $this->redirect('/mahasiswa/create');
        }

        $this->setFlash('success', 'Data mahasiswa berhasil ditambahkan.');
        $this->redirect('/mahasiswa');
    }

    // Acara 13: menerima request ubah dan menyerahkan validasi serta proses ke Service.
    public function update(int $id): void
    {
        $item = $this->repository->find($id);

        if ($item === null) {
            http_response_code(404);
            echo '404 - Data mahasiswa tidak ditemukan';
            return;
        }

        $result = $this->service->update($id, $_POST, $item['status']);

        if (!$result['success']) {
            $_SESSION['old_input'] = $_POST;
            $errors = $result['errors'];
            $message = $errors['nim'] ?? $errors['general'] ?? reset($errors);
            $this->setFlash('danger', $message ?: 'Data gagal disimpan.');
            $this->redirect('/mahasiswa/' . $id . '/edit');
        }

        $this->setFlash('success', 'Data mahasiswa berhasil diubah.');
        $this->redirect('/mahasiswa');
    }

    // Menghapus data mahasiswa.
    public function destroy(int $id): void
    {
        $this->repository->delete($id);
        $this->setFlash('success', 'Data mahasiswa berhasil dihapus.');
        $this->redirect('/mahasiswa');
    }

    // Acara 13: menyimpan Flash Message satu kali melalui session.
    private function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }
}
