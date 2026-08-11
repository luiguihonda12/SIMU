<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

try {

    require_once(
        __DIR__ . '/../models/mgesr.php'
    );

    $m = new mgesr();


    // LISTAR
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        echo json_encode([
            'ok' => true,
            'data' => $m->listar()
        ]);

        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Método no permitido.'
        );
    }


    $accion =
        $_POST['accion'] ?? '';

    $id = (int)(
        $_POST['id_rol'] ?? 0
    );

    $nombre =
        trim(
            $_POST['nombre_del_rol'] ?? ''
        );


    // CREAR
    if ($accion === 'crear') {

        if ($nombre === '') {

            throw new Exception(
                'Escribe el nombre del rol.'
            );
        }


        if ($m->existe($nombre)) {

            throw new Exception(
                'Ese rol ya existe.'
            );
        }


        if (!$m->crear($nombre)) {

            throw new Exception(
                'No fue posible crear el rol.'
            );
        }


        echo json_encode([
            'ok' => true,
            'msg' =>
                'Rol creado correctamente.'
        ]);

        exit;
    }


    // EDITAR
    if ($accion === 'editar') {

        if (
            $id <= 0 ||
            $nombre === ''
        ) {

            throw new Exception(
                'Datos incompletos.'
            );
        }


        if (
            $m->existe(
                $nombre,
                $id
            )
        ) {

            throw new Exception(
                'Ese rol ya existe.'
            );
        }


        if (
            !$m->actualizar(
                $id,
                $nombre
            )
        ) {

            throw new Exception(
                'No fue posible actualizar el rol.'
            );
        }


        echo json_encode([
            'ok' => true,
            'msg' =>
                'Rol actualizado correctamente.'
        ]);

        exit;
    }


    // ELIMINAR
    if ($accion === 'eliminar') {

        if ($id <= 0) {

            throw new Exception(
                'Rol inválido.'
            );
        }


        if ($m->enUso($id)) {

            throw new Exception(
                'No se puede eliminar el rol porque está asignado a uno o más usuarios.'
            );
        }

        if (!$m->eliminar($id)) {

            throw new Exception(
                'No fue posible eliminar el rol.'
            );
        }


        echo json_encode([
            'ok' => true,
            'msg' =>
                'Rol eliminado correctamente.'
        ]);

        exit;
    }


    throw new Exception(
        'Acción no válida.'
    );


} catch (Throwable $e) {

    echo json_encode([
        'ok' => false,
        'msg' => $e->getMessage()
    ]);
}
?>