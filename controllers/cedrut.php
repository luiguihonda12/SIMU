<?php
require_once __DIR__ . '/../models/medrut.php';

/**
 * ============================================================
 * CONTROLADOR: EDITAR RUTAS
 * Vista 6 - Editar Rutas
 * ope: 0 = mostrar, 2 = cargar ruta, 3 = actualizar
 * ============================================================
 */
class Cedrut
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Medrut();
    }

    public function index()
    {
        $ope     = $_REQUEST['ope'] ?? 0;
        $idRuta  = $_REQUEST['id_ruta'] ?? '';
        $mensaje = '';
        $tipo    = '';
        $ruta    = null;

        if ($ope == 3) {
            $datos = [
                'id_ruta' => $idRuta,
                'nombre'  => trim($_REQUEST['nombre'] ?? ''),
                'origen'  => trim($_REQUEST['origen'] ?? ''),
                'destino' => trim($_REQUEST['destino'] ?? ''),
                'horario' => trim($_REQUEST['horario'] ?? '')
            ];

            if ($datos['id_ruta'] == '' || $datos['nombre'] == '' || $datos['origen'] == '' || $datos['destino'] == '' || $datos['horario'] == '') {
                $mensaje = 'Todos los campos son obligatorios.';
                $tipo    = 'danger';
            } elseif ($this->modelo->existeNombre($datos['nombre'], $datos['id_ruta'])) {
                $mensaje = 'Ya existe otra ruta registrada con ese nombre.';
                $tipo    = 'danger';
            } elseif ($this->modelo->actualizar($datos)) {
                $mensaje = 'La ruta fue actualizada correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible actualizar la ruta.';
                $tipo    = 'danger';
            }
        }

        if ($idRuta != '') {
            $ruta = $this->modelo->obtener($idRuta);
        }

        return [
            'rutas'   => $this->modelo->listar(),
            'ruta'    => $ruta,
            'idRuta'  => $idRuta,
            'mensaje' => $mensaje,
            'tipo'    => $tipo
        ];
    }
}