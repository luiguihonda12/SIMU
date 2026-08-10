<?php
declare(strict_types=1);

function registrar_usuario(PDO $db): void
{
    verify_csrf();
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $apellidos = trim((string) ($_POST['apellidos'] ?? ''));
    $correo = strtolower(trim((string) ($_POST['correo'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    $confirm = (string) ($_POST['password_confirm'] ?? '');
    $errors = [];

    if (mb_strlen($nombre) < 2) $errors[] = 'El nombre debe tener al menos 2 caracteres.';
    if ($apellidos === '') $errors[] = 'Los apellidos son obligatorios.';
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errors[] = 'Ingresa un correo válido.';
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password)) $errors[] = 'La contraseña debe tener 8 caracteres, una mayúscula y un número.';
    if ($password !== $confirm) $errors[] = 'Las contraseñas no coinciden.';

    if ($errors) {
        flash('danger', implode(' ', $errors));
        redirect('index.php?pg=creaUsu');
    }

    try {
        $stmt = $db->prepare('INSERT INTO usuario (nombre, correo, contrasena, id_rol) VALUES (:nombre, :correo, :contrasena, :id_rol)');
        $stmt->execute(['nombre' => "$nombre $apellidos", 'correo' => $correo, 'contrasena' => password_hash($password, PASSWORD_DEFAULT), 'id_rol' => 3]);
        flash('success', 'Usuario creado correctamente con contraseña protegida.');
    } catch (PDOException $exception) {
        flash('danger', (($exception->errorInfo[1] ?? 0) === 1062) ? 'Ese correo ya está registrado.' : 'No fue posible crear el usuario.');
    }
    redirect('index.php?pg=creaUsu');
}
