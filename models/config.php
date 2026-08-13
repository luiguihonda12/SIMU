<?php
// Local: usa los valores por defecto.
// Railway: inyecta las variables del servicio MySQL (MYSQLHOST, MYSQLPORT,
// MYSQLUSER, MYSQLPASSWORD, MYSQLDATABASE o la URL MYSQL_URL).
function simu_env($nombres, $default = '') {
    foreach ($nombres as $n) {
        $v = getenv($n);
        if ($v !== false && $v !== '') {
            return $v;
        }
    }
    return $default;
}

$host = simu_env(['MYSQLHOST', 'MYSQL_HOST'], 'localhost');
$db   = simu_env(['MYSQLDATABASE', 'MYSQL_DATABASE'], 'movilidad_mer');
$user = simu_env(['MYSQLUSER', 'MYSQL_USER'], 'root');
$pass = simu_env(['MYSQLPASSWORD', 'MYSQL_PASSWORD'], '');
$port = simu_env(['MYSQLPORT', 'MYSQL_PORT'], '3306');

/* Si la plataforma solo entrega una URL completa de MySQL, se extraen los datos. */
$url = simu_env(['MYSQL_URL', 'DATABASE_URL', 'JAWSDB_URL', 'CLEARDB_DATABASE_URL']);
if ($url !== '') {
    $partes = parse_url($url);
    if ($partes !== false && isset($partes['host'])) {
        $host = $partes['host'];
        $port = (string)($partes['port'] ?? $port);
        $user = $partes['user'] ?? $user;
        $pass = $partes['pass'] ?? $pass;
        $ruta = ltrim($partes['path'] ?? '', '/');
        if ($ruta !== '') {
            $db = $ruta;
        }
    }
}
?>
