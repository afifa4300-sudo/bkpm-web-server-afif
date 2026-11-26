<?php

namespace App\Services;

use App\Repositories\MahasiswaRepository;
use App\Repositories\ProdiRepository;
use App\Core\Logger;

class MahasiswaService
{
    // Acara 13: dependency injection repository untuk logika bisnis mahasiswa.
    public function __construct(
        private MahasiswaRepository $repository,
        private ProdiRepository $prodiRepository
    ) {
    }

    // Acara 13: memvalidasi input dan menjalankan proses penambahan mahasiswa.
    public function create(array $input): array
    {
        $data = $this->validatedData($input);
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        if ($this->repository->nimExists($data['nim'])) {
            return [
                'success' => false,
                'errors' => ['nim' => 'NIM sudah terdaftar. Gunakan NIM lain.'],
            ];
        }

        $data['status'] = 'aktif';

        try {
            $created = $this->repository->create($data);
        } catch (\Throwable $exception) {
            Logger::error('Mahasiswa create failed', $exception);
            return [
                'success' => false,
                'errors' => ['general' => 'Data gagal disimpan. Periksa kembali data yang dimasukkan.'],
            ];
        }

        return $created
            ? ['success' => true]
            : ['success' => false, 'errors' => ['general' => 'Data gagal disimpan.']];
    }

    // Acara 13: memvalidasi input dan menjalankan proses perubahan mahasiswa.
    public function update(int $id, array $input, string $currentStatus): array
    {
        $data = $this->validatedData($input);
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        if ($this->repository->nimExists($data['nim'], $id)) {
            return [
                'success' => false,
                'errors' => ['nim' => 'NIM sudah terdaftar pada mahasiswa lain.'],
            ];
        }

        $allowedStatus = ['aktif', 'cuti', 'lulus'];
        $status = $input['status'] ?? $currentStatus;
        $data['status'] = in_array($status, $allowedStatus, true)
            ? $status
            : $currentStatus;

        try {
            $updated = $this->repository->update($id, $data);
        } catch (\Throwable $exception) {
            Logger::error('Mahasiswa update failed', $exception);
            return [
                'success' => false,
                'errors' => ['general' => 'Data gagal disimpan. Periksa kembali data yang dimasukkan.'],
            ];
        }

        return $updated
            ? ['success' => true]
            : ['success' => false, 'errors' => ['general' => 'Data gagal disimpan.']];
    }

    // Acara 13: menyiapkan format data dan menjalankan seluruh validasi bisnis.
    private function validatedData(array $input): array
    {
        return [
            'nim' => trim((string) ($input['nim'] ?? '')),
            'nama' => trim((string) ($input['nama'] ?? '')),
            'email' => trim((string) ($input['email'] ?? '')),
            'prodi_id' => (int) ($input['prodi_id'] ?? 0),
            'angkatan' => (int) ($input['angkatan'] ?? 0),
        ];
    }

    // Acara 13: memeriksa kelengkapan dan validitas data sebelum disimpan.
    private function validate(array $data): array
    {
        $errors = [];

        if ($data['nim'] === '') {
            $errors['nim'] = 'NIM wajib diisi.';
        } elseif (!preg_match('/^[0-9]+$/', $data['nim'])) {
            $errors['nim'] = 'NIM hanya boleh berisi angka.';
        }

        if ($data['nama'] === '') {
            $errors['nama'] = 'Nama wajib diisi.';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format email tidak valid.';
        }

        if ($data['prodi_id'] <= 0 || !$this->prodiRepository->exists($data['prodi_id'])) {
            $errors['prodi_id'] = 'Program studi tidak tersedia.';
        }

        if ($data['angkatan'] < 2000 || $data['angkatan'] > 2100) {
            $errors['angkatan'] = 'Angkatan harus berada pada rentang 2000–2100.';
        }

        return $errors;
    }
}
