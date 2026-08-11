<?php

header('Content-Type: application/json; charset=utf-8');

$res = [
    'ok' => false,
    'msg' => ''
];

try {

    require_once(__DIR__ . '/../models/mregisb.php');

    $m = new mregisb();

    // Cargar rutas y empresas
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        $res['ok'] = true;
        $res['rutas'] = $m->listarRutas();
        $res['empresas'] = $m->listarEmpresas();

        echo json_encode($res);
        exit;
    }

    // Solo permitir POST para registrar
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception('Método no permitido.');
    }

    $placa = strtoupper(
        trim($_POST['placa'] ?? '')
    );

    $capacidad = (int)(
        $_POST['capacidad'] ?? 0
    );

    $estado = $_POST['estado'] ?? 'activa';

    $id_ruta = (int)(
        $_POST['id_ruta'] ?? 0
    );

    $id_empresa = (int)(
        $_POST['id_empresa'] ?? 0
    );

    // Validaciones
    if (
        $placa === '' ||
        $capacidad <= 0 ||
        $id_ruta <= 0 ||
        $id_empresa <= 0
    ) {

        throw new Exception(
            'Completa todos los campos obligatorios.'
        );
    }

    if (!preg_match('/^[A-Z0-9-]{3,20}$/', $placa)) {

        throw new Exception(
            'La placa no tiene un formato válido.'
        );
    }

    if (
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
            'Estado no válido.'
        );
    }

    // Verificar placa
    if ($m->existePlaca($placa)) {

        throw new Exception(
            'Ya existe una buseta registrada con esa placa.'
        );
    }

    // Registrar
    $ok = $m->registrar([
        'placa' => $placa,
        'capacidad' => $capacidad,
        'estado' => $estado,
        'id_ruta' => $id_ruta,
        'id_empresa' => $id_empresa
    ]);

    if (!$ok) {

        throw new Exception(
            'No fue posible registrar la buseta.'
        );
    }

    $res = [
        'ok' => true,
        'msg' => 'Buseta registrada correctamente.'
    ];

} catch (Throwable $e) {

    $res['msg'] = $e->getMessage();
}

echo json_encode($res);
?>