<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/mdeleb.php'
    );

    $m = new mdeleb();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método no permitido.'
        );
    }

    $id = (int)(
        $_POST['id_buseta'] ?? 0
    );

    if ($id <= 0) {

        throw new Exception(
            'ID de buseta inválido.'
        );
    }

    if (!$m->eliminar($id)) {

        throw new Exception(
            'No fue posible eliminar la buseta.'
        );
    }

    echo json_encode([
        'ok' => true,
        'msg' =>
            'Buseta eliminada correctamente.'
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
}
?>
