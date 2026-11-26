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

        if (!$this->model->isValidEmail($email)) {
            Response::json(422, false, 'Format email tidak valid', null, [
                'email' => 'Format email yang dimasukkan tidak memenuhi standar'
            ]);
        }

        if ($this->model->findByUsername($username)) {
            Response::json(422, false, 'Username sudah terdaftar', null, [
                'username' => 'Silakan gunakan username lain'
            ]);
        }

        if ($this->model->findByEmail($email)) {
            Response::json(422, false, 'Email sudah terdaftar', null, [
                'email' => 'Email ini sudah memiliki akun'
            ]);
        }

        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $data['role']     = in_array($role, ['admin', 'user']) ? $role : 'user';

        $id = $this->model->create($data);
        Response::json(201, true, 'Registrasi berhasil', ['id' => (int)$id, 'username' => $username, 'role' => $data['role']]);
    }

    // Langkah 2 BKPM Acara 20: Aksi Login Pengguna & Penerbitan JWT Native
    public function login(): void {
        $raw = file_get_contents('php://input');
        $data = json_decode($raw, true);

        if (!$data || !is_array($data)) {
            Response::json(400, false, 'Payload JSON tidak valid');
        }

        $username = trim($data['username'] ?? '');
        $password = trim($data['password'] ?? '');

        if ($username === '' || $password === '') {
            Response::json(400, false, 'Username dan password wajib diisi');
        }

        $user = $this->model->findByUsername($username);
        if (!$user || !password_verify($password, $user['password'])) {
            Response::json(401, false, 'Username atau password salah');
        }

        // Tugas Mandiri 2 Acara 20: masa berlaku token bisa disesuaikan (default 3600 detik = 1 jam)
        $token = Auth::generateToken([
            'id'       => (int)$user['id'],
            'username' => $user['username'],
            'role'     => $user['role']
        ], 3600);

        Response::json(200, true, 'Login berhasil', [
            'token' => $token,
            'role'  => $user['role'],
            'user'  => [
                'id'       => (int)$user['id'],
                'username' => $user['username'],
                'email'    => $user['email']
            ]
        ]);
    }
}
