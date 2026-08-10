<?php
declare(strict_types=1);

function procesar_login(PDO $db): void
{
    verify_csrf();
    $correo = trim((string) ($_POST['correo'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || $password === '' || !login_user($db, $correo, $password)) {
        flash('danger', 'El correo o la contraseña no son correctos.');
        redirect('index.php?pg=login');
    }
    redirect('index.php?pg=inicio');
}

function procesar_logout(): void
{
    verify_csrf();
    logout_user();
    redirect('index.php?pg=login');
}
