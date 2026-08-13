<?php
/* =========================================================
   SIMU - Importador de base de datos (despliegue en Railway)
   Uso: php db/importar.php
   Reanudable: ejecuta cada sentencia por separado y omite las
   que ya existen (tablas, índices o claves), de modo que una
   importación parcial no deja la BD a medias.
   ========================================================= */

$host = getenv('MYSQLHOST') ?: 'localhost';
$db   = getenv('MYSQLDATABASE') ?: 'movilidad_mer';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = getenv('MYSQLPORT') ?: '3306';

$sqlFile = __DIR__ . '/movilidad_mer.sql';

/* Códigos de error MySQL "ya existe": tabla (1050), índice (1061),
   clave primaria (1068), columna (1060), entrada duplicada (1062),
   clave duplicada (1022), clave foránea (1826). */
$yaExiste = [1050, 1061, 1068, 1060, 1062, 1022, 1826];

/* ---------------------------------------------------------
   1. CONEXIÓN CON REINTENTOS (solo problemas de red/arranque)
   --------------------------------------------------------- */
$maxIntentos = 30;
$pdo = null;

for ($intento = 1; $intento <= $maxIntentos; $intento++) {
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
            $user,
            $pass,
            [
                PDO::ATTR_ERRMODE                => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT                => 10,
                PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
            ]
        );
        break;
    } catch (PDOException $e) {
        if ($intento === $maxIntentos) {
            echo "[importar] ERROR: no se pudo conectar a MySQL tras $maxIntentos intentos: " . $e->getMessage() . "\n";
            exit(1);
        }
        echo "[importar] Conexión no disponible (intento $intento): " . $e->getMessage() . "\n";
        sleep(5);
    }
}

/* ---------------------------------------------------------
   2. IMPORTACIÓN REANUDABLE
   --------------------------------------------------------- */
echo "[importar] Conectado a MySQL. Importando $sqlFile ...\n";
$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "[importar] ERROR: no se pudo leer $sqlFile\n";
    exit(1);
}

// La BD ya existe en Railway: se eliminan las líneas CREATE DATABASE y USE.
$sql = preg_replace('/CREATE DATABASE[^;]*;/i', '', $sql);
$sql = preg_replace('/^USE\s+[^;]*;/im', '', $sql);

$importadas = 0;
$omitidas   = 0;

foreach (preg_split('/;\s*\r?\n/', $sql) as $bloque) {
    // Quita líneas de comentario y espacios para evaluar la sentencia.
    $sentencia = trim(preg_replace('/^--.*$/m', '', $bloque));
    if ($sentencia === '') {
        continue;
    }

    try {
        $pdo->exec($sentencia);
        $importadas++;
    } catch (PDOException $e) {
        $codigoMysql = isset($e->errorInfo[1]) ? (int)$e->errorInfo[1] : 0;
        $mensaje     = $e->getMessage();
        // MySQL 8/MariaDB a veces reportan una FK existente como
        // "1005 Can't create table (errno: 121 Duplicate key)".
        $esExistente = in_array($codigoMysql, $yaExiste, true)
            || stripos($mensaje, 'errno: 121') !== false
            || stripos($mensaje, 'errno 121') !== false;
        if ($esExistente) {
            $omitidas++;
            continue;
        }
        echo "[importar] ERROR al ejecutar sentencia: " . $e->getMessage() . "\n";
        echo "[importar] Sentencia: " . mb_substr($sentencia, 0, 300) . "\n";
        exit(1);
    }
}

echo "[importar] Listo: $importadas sentencias aplicadas, $omitidas omitidas (ya existían).\n";
exit(0);
