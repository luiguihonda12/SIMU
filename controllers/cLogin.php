<?php
session_start();

require_once(__DIR__ . '/../models/mlogin.php');

$correo = trim($_POST['correo'] ?? '');
$clave  = $_POST['clave'] ?? '';

if ($correo === '' || $clave === '') {
    header("Location: ../index.php?pg=login&error=campos_vacios");
    exit();
}

$usuarioValido = Mlogin::validarUsuario($correo, $clave);

if ($usuarioValido) {
    if ((int)$usuarioValido['estado'] === 0) {
        header("Location: ../index.php?pg=login&error=no_verificado");
        exit();
    }

    session_regenerate_id(true);
    $_SESSION['usuario']    = $usuarioValido['nombre'];
    $_SESSION['correo']     = $usuarioValido['correo'];
    $_SESSION['id_usuario'] = $usuarioValido['id_usuario'];

    header("Location: ../index.php?pg=dashboard");
    exit();
}

header("Location: ../index.php?pg=login&error=datos_erroneos");
exit();