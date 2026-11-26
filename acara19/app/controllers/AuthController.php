<?php
class AuthController {
    private User $model;

    public function __construct() {
        $this->model = new User();
    }

    public function register(): void {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload JSON tidak valid');
        }

        $username = trim($data['username'] ?? '');
        $email    = trim($data['email'] ?? '');
        $password = trim($data['password'] ?? '');
        $role     = trim($data['role'] ?? 'user');

        $errors = [];
        if ($username === '') $errors['username'] = 'Field username wajib diisi';
        if ($email === '')    $errors['email']    = 'Field email wajib diisi';
        if ($password === '') $errors['password'] = 'Field password wajib diisi';

        if (!empty($errors)) {
            Response::json(400, false, 'Username, email, dan password wajib diisi', null, $errors);
        }

        // Tugas Praktik Mandiri Acara 19: Validasi format email menggunakan filter_var
        if (!$this->model->isValidEmail($email)) {
            Response::json(422, false, 'Format email tidak valid', null, [
                'email' => 'Format email yang dimasukkan tidak memenuhi standar'
            ]);
        }

        // Cek apakah username sudah digunakan
        if ($this->model->findByUsername($username)) {
            Response::json(422, false, 'Username sudah terdaftar', null, [
                'username' => 'Silakan gunakan username lain'
            ]);
        }

        // Cek apakah email sudah digunakan
        if ($this->model->findByEmail($email)) {
            Response::json(422, false, 'Email sudah terdaftar', null, [
                'email' => 'Email ini sudah memiliki akun'
            ]);
        }

        // Enkripsi kata sandi menggunakan hash yang aman
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $data['role']     = in_array($role, ['admin', 'user']) ? $role : 'user';

        $id = $this->model->create($data);
        Response::json(201, true, 'Registrasi berhasil', ['id' => (int)$id, 'username' => $username, 'role' => $data['role']]);
    }
}
