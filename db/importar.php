<?php
/* =========================================================
   SIMU - Importador de base de datos (despliegue en Railway)
   Uso: php db/importar.php
   Idempotente: solo importa si la BD todavía no tiene tablas.
   ========================================================= */

$host = getenv('MYSQLHOST') ?: 'localhost';
$db   = getenv('MYSQLDATABASE') ?: 'movilidad_mer';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = getenv('MYSQLPORT') ?: '3306';

$sqlFile = __DIR__ . '/movilidad_mer.sql';

$maxIntentos = 30;
$intento = 0;

while ($intento < $maxIntentos) {
    $intento++;
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE                => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT                => 10,
                PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
            ]
        );

        // Si la tabla principal ya existe, la BD ya está importada.
        $tablaClave = 'usuario';
        $existe = $pdo->query(
            "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = " . $pdo->quote($db) . " AND table_name = " . $pdo->quote($tablaClave)
        )->fetchColumn();

        if ($existe > 0) {
            echo "[importar] La base de datos '$db' ya contiene la tabla '$tablaClave'. No se importa.\n";
            exit(0);
        }

        echo "[importar] Conectado a MySQL. Importando $sqlFile ...\n";
        $sql = file_get_contents($sqlFile);
        if ($sql === false) {
            echo "[importar] ERROR: no se pudo leer $sqlFile\n";
            exit(1);
        }

        // La BD ya existe en Railway: se eliminan las líneas CREATE DATABASE y USE.
        $sql = preg_replace('/CREATE DATABASE[^;]*;/i', '', $sql);
        $sql = preg_replace('/^USE\s+[^;]*;/im', '', $sql);

        $pdo->exec($sql);
        echo "[importar] Importación completada.\n";
        exit(0);
    } catch (Exception $e) {
        echo "[importar] Intento $intento falló: " . $e->getMessage() . "\n";
        sleep(5);
    }
}

echo "[importar] ERROR: no se pudo conectar/importar después de $maxIntentos intentos.\n";
exit(1);
