<?php
require_once __DIR__ . '/../models/mregru.php';

/**
 * ============================================================
 * CONTROLADOR: REGISTRO DE RUTAS
 * Vista 10 - Registro de Rutas
 * ope: 0 = mostrar, 1 = guardar, 4 = eliminar
 * ============================================================
 */
class Cregru
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mregru();
    }

    public function index()
    {
        $ope     = $_REQUEST['ope'] ?? 0;
        $mensaje = '';
        $tipo    = '';

        if ($ope == 1) {
            $datos = [
                'nombre'  => trim($_REQUEST['nombre'] ?? ''),
                'origen'  => trim($_REQUEST['origen'] ?? ''),
                'destino' => trim($_REQUEST['destino'] ?? ''),
                'horario' => trim($_REQUEST['horario'] ?? '')
            ];

            if ($datos['nombre'] == '' || $datos['origen'] == '' || $datos['destino'] == '' || $datos['horario'] == '') {
                $mensaje = 'Debe diligenciar el nombre, el origen, el destino y el horario de la ruta.';
                $tipo    = 'danger';
            } elseif ($this->modelo->existeNombre($datos['nombre'])) {
                $mensaje = 'Ya existe una ruta registrada con ese nombre.';
                $tipo    = 'danger';
            } elseif ($this->modelo->registrar($datos)) {
                $mensaje = 'La ruta fue registrada correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible registrar la ruta.';
                $tipo    = 'danger';
            }
        }

        if ($ope == 4) {
            $idRuta = $_REQUEST['id_ruta'] ?? '';

            if ($idRuta == '') {
                $mensaje = 'No se recibio la ruta que desea eliminar.';
                $tipo    = 'danger';
            } elseif ($this->modelo->tienePagos($idRuta)) {
                $mensaje = 'La ruta tiene pagos asociados y no puede eliminarse.';
                $tipo    = 'danger';
            } elseif ($this->modelo->eliminar($idRuta)) {
                $mensaje = 'La ruta fue eliminada correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible eliminar la ruta.';
                $tipo    = 'danger';
            }
        }

        return [
            'rutas'   => $this->modelo->listar(),
            'mensaje' => $mensaje,
            'tipo'    => $tipo
        ];
    }
}
