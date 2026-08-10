<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

$apply = in_array('--apply', $argv ?? [], true);
$db = (new Conexion())->get_conexion();
$users = $db->query('SELECT id_usuario, correo, contrasena FROM usuario')->fetchAll();
$pending = array_values(array_filter($users, static fn (array $user): bool => !str_starts_with((string) $user['contrasena'], '$')));

echo 'Usuarios revisados: ' . count($users) . PHP_EOL;
echo 'Contraseñas pendientes de hash: ' . count($pending) . PHP_EOL;

if (!$apply) {
    echo 'Modo revisión. Ejecuta nuevamente con --apply para actualizar.' . PHP_EOL;
    exit(0);
}

$update = $db->prepare('UPDATE usuario SET contrasena = :contrasena WHERE id_usuario = :id');
$db->beginTransaction();
try {
    foreach ($pending as $user) {
        // El valor legado se usa solo en memoria y nunca se imprime.
        $update->execute([
            'contrasena' => password_hash((string) $user['contrasena'], PASSWORD_DEFAULT),
            'id' => (int) $user['id_usuario'],
        ]);
    }
    $db->commit();
    echo 'Contraseñas convertidas a password_hash correctamente.' . PHP_EOL;
} catch (Throwable $exception) {
    if ($db->inTransaction()) $db->rollBack();
    fwrite(STDERR, 'No se pudo completar la migración.' . PHP_EOL);
    exit(1);
}
