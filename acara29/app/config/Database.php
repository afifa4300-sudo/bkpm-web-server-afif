<?php
class Database {
    private static ?PDO $connection = null;

    private const HOST = 'localhost';
    private const NAME = 'db_workshop';
    private const USER = 'root';
    private const PASSWORD = '';
    private const CHARSET = 'utf8mb4';

    // Mode konfigurasi environment aplikasi: 'development' atau 'production'
    public const APP_ENV = 'development';

    public static function getConnection(): PDO {
        if (self::$connection === null) {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::NAME . ';charset=' . self::CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$connection = new PDO($dsn, self::USER, self::PASSWORD, $options);
            } catch (PDOException $e) {
                Response::json(500, false, 'Koneksi database gagal: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
