<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

$base = 'http://127.0.0.1:8000/index.php';
$cookie = tempnam(sys_get_temp_dir(), 'simu-cookie-');
$request = static function (string $url, ?array $post = null) use ($cookie): array {
    $handle = curl_init($url);
    curl_setopt_array($handle, [CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => true, CURLOPT_COOKIEJAR => $cookie, CURLOPT_COOKIEFILE => $cookie, CURLOPT_FOLLOWLOCATION => false]);
    if ($post !== null) { curl_setopt($handle, CURLOPT_POST, true); curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($post)); }
    $raw = curl_exec($handle);
    $status = curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
    curl_close($handle);
    return [$status, is_string($raw) ? $raw : ''];
};

[$homeStatus, $home] = $request($base . '?pg=inicio');
[$formStatus, $form] = $request($base . '?pg=creaUsu');
preg_match('/name="csrf_token" value="([^"]+)"/', $form, $match);
$token = $match[1] ?? '';
$email = 'qa.' . time() . '@simu.local';
[$postStatus] = $request($base . '?pg=creaUsu', ['csrf_token' => $token, 'action' => 'crear_usuario', 'nombre' => 'QA', 'apellidos' => 'SIMU', 'correo' => $email, 'password' => 'SimuTest9', 'password_confirm' => 'SimuTest9']);

$db = (new Conexion())->get_conexion();
$statement = $db->prepare('SELECT contrasena FROM usuario WHERE correo = ?');
$statement->execute([$email]);
$hash = (string) $statement->fetchColumn();
$db->prepare('DELETE FROM usuario WHERE correo = ?')->execute([$email]);
$driver = $request($base . '?pg=conductores');
preg_match('/name="csrf_token" value="([^"]+)"/', $driver[1], $driverMatch);
$driverToken = $driverMatch[1] ?? '';
$driverPost = $request($base . '?pg=conductores', ['csrf_token' => $driverToken, 'action' => 'crear_conductor', 'nombre' => 'QA Conductor', 'licencia' => 'QA-' . time(), 'telefono' => '3001234567', 'id_buseta' => '1']);
$driverHash = $db->query("SELECT COUNT(*) FROM conductor WHERE nombre = 'QA Conductor'")->fetchColumn();
$db->exec("DELETE FROM conductor WHERE nombre = 'QA Conductor'");
@unlink($cookie);

printf("home=%d form=%d user_post=%d driver_post=%d csrf=%s password_hash=%s driver_saved=%s\n", $homeStatus, $formStatus, $postStatus, $driverPost[0], $token !== '' && $driverToken !== '' ? 'yes' : 'no', str_starts_with($hash, '$2y$') ? 'yes' : 'no', $driverHash > 0 ? 'yes' : 'no');
exit($homeStatus === 200 && $formStatus === 200 && $postStatus === 302 && $driverPost[0] === 302 && $token !== '' && $driverToken !== '' && str_starts_with($hash, '$2y$') && $driverHash > 0 ? 0 : 1);
