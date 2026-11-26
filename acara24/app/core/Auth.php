<?php
class Auth {
    // Secret key HMAC-SHA256 untuk tanda tangan digital JWT Native
    const SECRET = 'kunci_rahasia_workshop_2026';

    /**
     * Konversi Base64 biasa menjadi Base64URL-safe (RFC 7519)
     */
    private static function base64url(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Membuat JSON Web Token (JWT) Native
     */
    public static function generateToken(array $payload, int $expirySeconds = 3600): string {
        $header = self::base64url(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        
        // Masa berlaku token (default 1 jam / 3600s, bisa diset 300s untuk uji kedaluwarsa)
        $payload['exp'] = time() + $expirySeconds;
        $payload['iat'] = time();

        $payloadEnc = self::base64url(json_encode($payload));
        $signature = self::base64url(hash_hmac('sha256', "$header.$payloadEnc", self::SECRET, true));

        return "$header.$payloadEnc.$signature";
    }

    /**
     * Memvalidasi keaslian dan masa berlaku token
     */
    public static function validateToken(string $token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        [$header, $payload, $signature] = $parts;
        $validSignature = self::base64url(hash_hmac('sha256', "$header.$payload", self::SECRET, true));

        // Membandingkan signature digital secara aman dari timing attacks
        if (!hash_equals($validSignature, $signature)) {
            return false;
        }

        $decodedPayload = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
        if (!$decodedPayload || !isset($decodedPayload['exp'])) {
            return false;
        }

        // Cek masa berlaku token
        if ($decodedPayload['exp'] < time()) {
            return false;
        }

        return $decodedPayload;
    }

    /**
     * Middleware Proteksi Endpoint (Memeriksa Header Authorization: Bearer <token>)
     */
    public static function requireAuth(): array {
        // Mendapatkan semua headers HTTP
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? ($_SERVER['HTTP_AUTHORIZATION'] ?? '');

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Response::json(401, false, 'Akses ditolak: Token autentikasi tidak ditemukan pada header Authorization');
        }

        $payload = self::validateToken($matches[1]);
        if (!$payload) {
            Response::json(401, false, 'Akses ditolak: Token autentikasi tidak valid atau telah kedaluwarsa');
        }

        return $payload;
    }
}
