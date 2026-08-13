<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/melusu.php'
    );

    $m = new melusu();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método no permitido.'
        );
    }

    $id = (int)(
        $_POST['id_usuario'] ?? 0
    );

    if ($id <= 0) {

        throw new Exception(
            'ID de usuario inválido.'
        );
    }

    if (!$m->existe($id)) {

        throw new Exception(
            'El usuario no existe.'
        );
    }

    if (!$m->eliminar($id)) {

        throw new Exception(
            'No fue posible eliminar el usuario. ' .
            'Verifica que no tenga registros asociados ' .
            '(pagos o PQRS).'
        );
    }

    echo json_encode([
        'ok' => true,
        'msg' =>
            'Usuario eliminado correctamente.'
    ]);

} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
}
?>
