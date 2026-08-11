<?php

class Medicon
{
    // Datos de ejemplo del conductor
    private $conductor = [
        'id' => 1,
        'nombre' => 'Juan Bernal',
        'documento' => '1.000.000.001',
        'telefono' => '300 456 7890',
        'correo' => 'juan.bernal@simu.com',
        'licencia' => 'C1',
        'tipoLicencia' => 'Servicio Público',
        'estado' => 'Activo',
        'jornada' => 'Mañana'
    ];

    // Obtener conductor
    public function obtenerConductor($id = 1)
    {
        return $this->conductor;
    }

    // Actualizar conductor
    public function actualizarConductor($datos)
    {
        $this->conductor = array_merge(
            $this->conductor,
            $datos
        );

        return true;
    }
}