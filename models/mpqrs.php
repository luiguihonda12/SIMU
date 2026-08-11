<?php

class Mpqrs
{
    // Datos de ejemplo de una PQRS
    private $pqrs = [
        'id' => 'PQRS-00026',
        'tipo' => 'Petición',
        'categoria' => 'Servicio de transporte',
        'estado' => 'En revisión',
        'prioridad' => 'Media',
        'fecha' => '10/08/2026',
        'hora' => '09:35 AM',
        'nombre' => 'María González',
        'documento' => '1.023.456.789',
        'correo' => 'maria.gonzalez@email.com',
        'telefono' => '315 456 7890',
        'asunto' => 'Retraso frecuente de la ruta 01',
        'descripcion' => 'Quiero reportar que la ruta 01 presenta retrasos frecuentes durante las horas de la mañana. El día de hoy la buseta llegó aproximadamente 25 minutos después del horario establecido.',
        'respuesta' => '',
        'funcionario' => 'Sin asignar'
    ];

    // Obtener PQRS
    public function obtenerPQRS($id = null)
    {
        return $this->pqrs;
    }

    // Actualizar PQRS
    public function actualizarPQRS($datos)
    {
        $this->pqrs = array_merge($this->pqrs, $datos);

        return true;
    }
}