<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

$db = (new Conexion())->get_conexion();
$tables = $db->query("SELECT TABLE_NAME, ENGINE, TABLE_COLLATION, TABLE_ROWS FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME")->fetchAll();

echo "TABLAS\n======\n";
foreach ($tables as $table) {
    echo sprintf("%-18s %-8s filas_aprox=%s\n", $table['TABLE_NAME'], $table['ENGINE'], $table['TABLE_ROWS']);
}

echo "\nCOLUMNAS\n========\n";
$columns = $db->query("SELECT TABLE_NAME, COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_KEY, COLUMN_DEFAULT, EXTRA FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME, ORDINAL_POSITION")->fetchAll();
foreach ($columns as $column) {
    echo sprintf("%-18s %-18s %-20s NULL=%-3s KEY=%-3s DEFAULT=%s %s\n", $column['TABLE_NAME'], $column['COLUMN_NAME'], $column['COLUMN_TYPE'], $column['IS_NULLABLE'], $column['COLUMN_KEY'], $column['COLUMN_DEFAULT'] ?? 'NULL', $column['EXTRA']);
}

echo "\nRELACIONES\n==========\n";
$foreignKeys = $db->query("SELECT TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND REFERENCED_TABLE_NAME IS NOT NULL ORDER BY TABLE_NAME, COLUMN_NAME")->fetchAll();
foreach ($foreignKeys as $foreignKey) {
    echo sprintf("%s.%s -> %s.%s\n", $foreignKey['TABLE_NAME'], $foreignKey['COLUMN_NAME'], $foreignKey['REFERENCED_TABLE_NAME'], $foreignKey['REFERENCED_COLUMN_NAME']);
}

echo "\nCALIDAD DE DATOS\n================\n";
$users = $db->query('SELECT id_usuario, nombre, correo, LEFT(contrasena, 4) AS formato_password FROM usuario ORDER BY id_usuario')->fetchAll();
foreach ($users as $user) echo sprintf("usuario #%d %-25s %-30s password=%s\n", $user['id_usuario'], $user['nombre'], $user['correo'], $user['formato_password']);
$orphanDrivers = $db->query('SELECT COUNT(*) FROM conductor c LEFT JOIN empresa e ON e.id_empresa = c.id_empresa WHERE c.id_empresa IS NOT NULL AND e.id_empresa IS NULL')->fetchColumn();
$orphanVehicles = $db->query('SELECT COUNT(*) FROM buseta b LEFT JOIN empresa e ON e.id_empresa = b.id_empresa WHERE b.id_empresa IS NOT NULL AND e.id_empresa IS NULL')->fetchColumn();
$orphanRoutes = $db->query('SELECT COUNT(*) FROM paradero p LEFT JOIN ruta r ON r.id_ruta = p.id_ruta WHERE p.id_ruta IS NOT NULL AND r.id_ruta IS NULL')->fetchColumn();
echo "conductores_huerfanos_empresa={$orphanDrivers}\n";
echo "vehiculos_huerfanos_empresa={$orphanVehicles}\n";
echo "paraderos_huerfanos_ruta={$orphanRoutes}\n";
