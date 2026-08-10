<?php
declare(strict_types=1);

const ROLE_ADMIN = 1;
const ROLE_OPERATOR = 2;
const ROLE_READONLY = 3;

function current_user(): ?array
{
    return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
}

function is_authenticated(): bool
{
    return current_user() !== null;
}

function user_has_role(int ...$roles): bool
{
    $user = current_user();
    return $user !== null && in_array((int) $user['id_rol'], $roles, true);
}

function can_create(): bool { return user_has_role(ROLE_ADMIN, ROLE_OPERATOR); }
function can_delete(): bool { return user_has_role(ROLE_ADMIN); }
function can_manage_users(): bool { return user_has_role(ROLE_ADMIN); }

function role_label(int $role): string
{
    return match ($role) {
        ROLE_ADMIN => 'Administrador',
        ROLE_OPERATOR => 'Operador',
        ROLE_READONLY => 'Solo lectura',
        default => 'Sin rol',
    };
}

function require_auth(): void
{
    if (!is_authenticated()) redirect('index.php?pg=login');
}

function require_role(int ...$roles): void
{
    require_auth();
    if (!user_has_role(...$roles)) {
        http_response_code(403);
        exit('No tienes permisos para realizar esta acción.');
    }
}

function password_matches(string $stored, string $provided): bool
{
    if (str_starts_with($stored, '$')) return password_verify($provided, $stored);
    return $stored !== '' && hash_equals($stored, $provided);
}

function login_user(PDO $db, string $correo, string $password): bool
{
    $statement = $db->prepare('SELECT id_usuario, nombre, correo, contrasena, id_rol FROM usuario WHERE correo = :correo LIMIT 1');
    $statement->execute(['correo' => strtolower(trim($correo))]);
    $user = $statement->fetch();
    if (!$user || !password_matches((string) $user['contrasena'], $password)) return false;

    if (!str_starts_with((string) $user['contrasena'], '$')) {
        $upgrade = $db->prepare('UPDATE usuario SET contrasena = :contrasena WHERE id_usuario = :id');
        $upgrade->execute(['contrasena' => password_hash($password, PASSWORD_DEFAULT), 'id' => $user['id_usuario']]);
    }
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id_usuario' => (int) $user['id_usuario'],
        'nombre' => (string) $user['nombre'],
        'correo' => (string) $user['correo'],
        'id_rol' => (int) $user['id_rol'],
        'rol' => role_label((int) $user['id_rol']),
    ];
    return true;
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
    }
    session_destroy();
}
