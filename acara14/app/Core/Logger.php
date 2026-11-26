<?php
namespace App\Core;

/** File logger used by Acara 14. Never log credentials or raw user input. */
final class Logger
{
    private static function write(string $level, string $message, ?\Throwable $exception = null): void
    {
        $directory = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($directory)) { @mkdir($directory, 0750, true); }
        $entry = '[' . date('Y-m-d H:i:s') . '] ' . strtoupper($level) . ' ' . $message;
        if ($exception !== null) {
            $entry .= ' | ' . get_class($exception) . ': ' . $exception->getMessage()
                . ' | ' . $exception->getFile() . ':' . $exception->getLine();
        }
        @file_put_contents($directory . '/app.log', $entry . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
    public static function info(string $message): void { self::write('INFO', $message); }
    public static function warning(string $message, ?\Throwable $e = null): void { self::write('WARNING', $message, $e); }
    public static function error(string $message, ?\Throwable $e = null): void { self::write('ERROR', $message, $e); }
}
