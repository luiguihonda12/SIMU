<?php
declare(strict_types=1);

function registrar_usuario(PDO $db): void
{
    require_role(ROLE_ADMIN);
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
        $idRol = (int) ($_POST['id_rol'] ?? ROLE_READONLY);
        if (!in_array($idRol, [ROLE_ADMIN, ROLE_OPERATOR, ROLE_READONLY], true)) $idRol = ROLE_READONLY;
        $stmt->execute(['nombre' => "$nombre $apellidos", 'correo' => $correo, 'contrasena' => password_hash($password, PASSWORD_DEFAULT), 'id_rol' => $idRol]);
        flash('success', 'Usuario creado correctamente con contraseña protegida.');
    } catch (PDOException $exception) {
        flash('danger', (($exception->errorInfo[1] ?? 0) === 1062) ? 'Ese correo ya está registrado.' : 'No fue posible crear el usuario.');
    }
    redirect('index.php?pg=creaUsu');
}

function eliminar_usuario(PDO $db): void
{
    require_role(ROLE_ADMIN);
    verify_csrf();
    $id = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
    $current = current_user();
    if (!$id || !$current || $id === (int) $current['id_usuario']) {
        flash('danger', 'No puedes eliminar tu propia cuenta.');
        redirect('index.php?pg=creaUsu');
    }
    $statement = $db->prepare('DELETE FROM usuario WHERE id_usuario = :id');
    $statement->execute(['id' => $id]);
    flash('success', 'Usuario eliminado correctamente.');
    redirect('index.php?pg=creaUsu');
}
