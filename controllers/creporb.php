<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/mreporb.php'
    );

    $m = new mreporb();

    $estado =
        $_GET['estado'] ?? '';

    echo json_encode([
        'ok' => true,
        'data' => $m->reporte($estado)
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage(),
        'data' => []
    ]);
}
?>