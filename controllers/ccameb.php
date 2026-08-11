<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/mcameb.php'
    );

    $m = new mcameb();


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $id = (int)(
            $_GET['id'] ?? 0
        );

        if ($id <= 0) {

            throw new Exception(
                'ID inválido.'
            );
        }

        echo json_encode([
            'ok' => true,
            'buseta' => $m->obtener($id)
        ]);

        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método no permitido.'
        );
    }


    $id = (int)(
        $_POST['id_buseta'] ?? 0
    );

    $estado =
        $_POST['estado'] ?? '';


    if (
        $id <= 0 ||
        !in_array(
            $estado,
            [
                'activa',
                'inactiva',
                'mantenimiento'
            ],
            true
        )
    ) {

        throw new Exception(
            'Datos inválidos.'
        );
    }


    if (!$m->cambiar($id, $estado)) {

        throw new Exception(
            'No fue posible cambiar el estado.'
        );
    }


    echo json_encode([
        'ok' => true,
        'msg' =>
            'Estado cambiado correctamente.'
    ]);


} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
}
?>