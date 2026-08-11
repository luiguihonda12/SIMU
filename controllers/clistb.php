<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/mlistb.php'
    );

    $m = new mlistb();

    $buscar = trim(
        $_GET['buscar'] ?? ''
    );

    echo json_encode([
        'ok' => true,
        'data' => $m->listar($buscar)
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage(),
        'data' => []
    ]);
}
?>