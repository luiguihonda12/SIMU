<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/medib.php'
    );

    $m = new medib();


    // CONSULTAR
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $id = (int)(
            $_GET['id'] ?? 0
        );

        if ($id <= 0) {

            throw new Exception(
                'ID de buseta inválido.'
            );
        }

        echo json_encode([
            'ok' => true,
            'buseta' => $m->obtener($id),
            'rutas' => $m->rutas(),
            'empresas' => $m->empresas()
        ]);

        exit;
    }


    // ACTUALIZAR
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método no permitido.'
        );
    }


    $datos = [

        'id_buseta' => (int)(
            $_POST['id_buseta'] ?? 0
        ),

        'placa' => strtoupper(
            trim($_POST['placa'] ?? '')
        ),

        'capacidad' => (int)(
            $_POST['capacidad'] ?? 0
        ),

        'estado' =>
            $_POST['estado'] ?? '',

        'id_ruta' => (int)(
            $_POST['id_ruta'] ?? 0
        ),

        'id_empresa' => (int)(
            $_POST['id_empresa'] ?? 0
        )
    ];


    if (
        $datos['id_buseta'] <= 0 ||
        $datos['placa'] === '' ||
        $datos['capacidad'] <= 0 ||
        $datos['id_ruta'] <= 0 ||
        $datos['id_empresa'] <= 0
    ) {

        throw new Exception(
            'Completa todos los campos obligatorios.'
        );
    }


    if (
        !in_array(
            $datos['estado'],
            [
                'activa',
                'inactiva',
                'mantenimiento'
            ],
            true
        )
    ) {

        throw new Exception(
            'Estado no válido.'
        );
    }


    if (
        $m->existePlacaOtro(
            $datos['placa'],
            $datos['id_buseta']
        )
    ) {

        throw new Exception(
            'Otra buseta ya utiliza esa placa.'
        );
    }


    if (!$m->actualizar($datos)) {

        throw new Exception(
            'No fue posible actualizar la buseta.'
        );
    }


    echo json_encode([
        'ok' => true,
        'msg' =>
            'Buseta actualizada correctamente.'
    ]);


} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
}
?>