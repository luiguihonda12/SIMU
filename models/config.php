<?php
declare(strict_types=1);

$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        if (getenv(trim($key)) === false) putenv(trim($key) . '=' . trim($value, " \t\"'"));
    }
}

$host = getenv('SIMU_DB_HOST') ?: '127.0.0.1';
$port = getenv('SIMU_DB_PORT') ?: '3306';
$db = getenv('SIMU_DB_NAME') ?: 'movilidad_mer';
$user = getenv('SIMU_DB_USER') ?: 'root';
$pass = getenv('SIMU_DB_PASSWORD') ?: '';
