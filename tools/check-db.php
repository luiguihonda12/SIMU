<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

try {
    $db = (new Conexion())->get_conexion();
    $info = $db->query('SELECT DATABASE() AS database_name, @@hostname AS server_host, @@port AS server_port, COUNT(*) AS users FROM usuario')->fetch();
    echo "DB_HOST_ENV=" . (getenv('SIMU_DB_HOST') ?: 'not-set') . PHP_EOL;
    echo "DB_PORT_ENV=" . (getenv('SIMU_DB_PORT') ?: 'not-set') . PHP_EOL;
    echo "DATABASE=" . $info['database_name'] . PHP_EOL;
    echo "SERVER_HOST=" . $info['server_host'] . PHP_EOL;
    echo "SERVER_PORT=" . $info['server_port'] . PHP_EOL;
    echo "USERS=" . $info['users'] . PHP_EOL;
} catch (Throwable $exception) {
    fwrite(STDERR, 'DB_ERROR=' . $exception->getMessage() . PHP_EOL);
    exit(1);
}
