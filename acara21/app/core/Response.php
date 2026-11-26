<?php
class Response {
    /**
     * Mengirimkan Standardized JSON Response Envelope
     *
     * @param int $httpCode Status code HTTP (200, 201, 400, 404, 422, 500, dll)
     * @param bool $success Status keberhasilan operasi (true/false)
     * @param string $message Pesan deskriptif hasil operasi
     * @param mixed $data Data payload utama
     * @param array|null $errors Daftar pesan kesalahan per field (Tugas Mandiri 1)
     */
    public static function json(int $httpCode, bool $success, string $message, $data = null, ?array $errors = null): void {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=utf-8');

        $payload = [
            'success'   => $success,
            'message'   => $message,
            'data'      => $data,
            'timestamp' => date('c'),
        ];

        // Jika terdapat rincian errors validasi (Tugas Mandiri 1)
        if ($errors !== null && !empty($errors)) {
            $payload['errors'] = $errors;
        }

        // Penentuan flag JSON berdasarkan APP_ENV (Tugas Mandiri 2)
        $isDevelopment = defined('Database::APP_ENV') && Database::APP_ENV === 'development';

        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        if ($isDevelopment) {
            $flags |= JSON_PRETTY_PRINT;
        }

        echo json_encode($payload, $flags);
        exit;
    }
}
