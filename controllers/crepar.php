<?php
require_once __DIR__ . '/../models/mrepar.php';

/**
 * ============================================================
 * CONTROLADOR: REGISTRAR PARADEROS
 * Vista 7 - Registrar Paraderos
 * ope: 0 = mostrar, 1 = guardar, 4 = eliminar
 * ============================================================
 */
class Crepar
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Mrepar();
    }

    public function index()
    {
        $ope     = $_REQUEST['ope'] ?? 0;
        $mensaje = '';
        $tipo    = '';

        if ($ope == 1) {
            $datos = [
                'nombre'    => trim($_REQUEST['nombre'] ?? ''),
                'ubicacion' => trim($_REQUEST['ubicacion'] ?? ''),
                'id_ruta'   => $_REQUEST['id_ruta'] ?? ''
            ];

            if ($datos['nombre'] == '' || $datos['ubicacion'] == '' || $datos['id_ruta'] == '') {
                $mensaje = 'Debe diligenciar el nombre, la ubicacion y la ruta del paradero.';
                $tipo    = 'danger';
            } elseif ($this->modelo->existe($datos['nombre'], $datos['id_ruta'])) {
                $mensaje = 'Ese paradero ya se encuentra registrado en la ruta seleccionada.';
                $tipo    = 'danger';
            } elseif ($this->modelo->registrar($datos)) {
                $mensaje = 'El paradero fue registrado correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible registrar el paradero.';
                $tipo    = 'danger';
            }
        }

        if ($ope == 4) {
            $idParadero = $_REQUEST['id_paradero'] ?? '';

            if ($idParadero != '' && $this->modelo->eliminar($idParadero)) {
                $mensaje = 'El paradero fue eliminado correctamente.';
                $tipo    = 'success';
            } else {
                $mensaje = 'No fue posible eliminar el paradero.';
                $tipo    = 'danger';
            }
        }

        return [
            'rutas'      => $this->modelo->listarRutas(),
            'paraderos'  => $this->modelo->listar(),
            'mensaje'    => $mensaje,
            'tipo'       => $tipo
        ];
    }
}