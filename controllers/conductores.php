<?php
declare(strict_types=1);

function registrar_conductor(PDO $db): void
{
    require_role(ROLE_ADMIN, ROLE_OPERATOR);
    verify_csrf();
    $nombre = trim((string) ($_POST['nombre'] ?? ''));
    $licencia = strtoupper(trim((string) ($_POST['licencia'] ?? '')));
    $telefono = trim((string) ($_POST['telefono'] ?? ''));
    $idBuseta = filter_input(INPUT_POST, 'id_buseta', FILTER_VALIDATE_INT) ?: null;
    $errors = [];
    if (mb_strlen($nombre) < 3) $errors[] = 'El nombre del conductor es obligatorio.';
    if ($licencia === '') $errors[] = 'La licencia es obligatoria.';
    if ($telefono !== '' && !preg_match('/^[0-9+() -]{7,20}$/', $telefono)) $errors[] = 'El teléfono no tiene un formato válido.';
    if ($errors) {
        flash('danger', implode(' ', $errors));
        redirect('index.php?pg=conductores');
    }
    $stmt = $db->prepare('INSERT INTO conductor (nombre, licencia, telefono, id_buseta, id_empresa) VALUES (:nombre, :licencia, :telefono, :id_buseta, :id_empresa)');
    $stmt->execute(['nombre' => $nombre, 'licencia' => $licencia, 'telefono' => $telefono ?: null, 'id_buseta' => $idBuseta, 'id_empresa' => 1]);
    flash('success', 'Conductor registrado correctamente.');
    redirect('index.php?pg=conductores');
}

function eliminar_conductor(PDO $db): void
{
    require_role(ROLE_ADMIN);
    verify_csrf();
    $id = filter_input(INPUT_POST, 'id_conductor', FILTER_VALIDATE_INT);
    if (!$id) {
        flash('danger', 'Conductor no válido.');
        redirect('index.php?pg=conductores');
    }
    $statement = $db->prepare('DELETE FROM conductor WHERE id_conductor = :id');
    $statement->execute(['id' => $id]);
    flash('success', 'Conductor eliminado correctamente.');
    redirect('index.php?pg=conductores');
}
