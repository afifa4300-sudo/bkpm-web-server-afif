<?php
class Auth {
    const SECRET = 'kunci_rahasia_workshop_2026';

    private static function base64url(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function generateToken(array $payload, int $expirySeconds = 3600): string {
        $header = self::base64url(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload['exp'] = time() + $expirySeconds;
        $payload['iat'] = time();

        $payloadEnc = self::base64url(json_encode($payload));
        $signature = self::base64url(hash_hmac('sha256', "$header.$payloadEnc", self::SECRET, true));

        return "$header.$payloadEnc.$signature";
    }

    public static function validateToken(string $token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;

        [$header, $payload, $signature] = $parts;
        $validSignature = self::base64url(hash_hmac('sha256', "$header.$payload", self::SECRET, true));

        if (!hash_equals($validSignature, $signature)) return false;

        $decodedPayload = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
        if (!$decodedPayload || $decodedPayload['exp'] < time()) return false;

        return $decodedPayload;
    }

    public static function requireAuth(): array {
        $headers = function_exists('getallheaders') ? getallheaders() : [];
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? ($_SERVER['HTTP_AUTHORIZATION'] ?? '');

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Response::json(401, false, 'Token tidak ditemukan');
        }

        $payload = self::validateToken($matches[1]);
        if (!$payload) {
            Response::json(401, false, 'Token tidak valid atau kedaluwarsa');
        }

        return $payload;
    }

    // Langkah 1 BKPM Acara 25: Otorisasi Berbasis Peran (RBAC) Khusus Admin
    public static function requireAdmin(): array {
        $payload = self::requireAuth();
        if (($payload['role'] ?? '') !== 'admin') {
            Response::json(403, false, 'Akses ditolak, hanya admin yang diizinkan');
        }
        return $payload;
    }
}
