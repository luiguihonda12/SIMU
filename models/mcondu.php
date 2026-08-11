<?php

/**
 * ============================================================
 * MODELO: CONDUCTOR
 * Vista 16 - Conductor
 * ============================================================
 */

class Mcondu
{
    /**
     * Datos temporales del conductor.
     *
     * Más adelante estos datos pueden venir
     * directamente desde MySQL.
     */
    public function obtenerConductor()
    {
        return [
            "id" => 1,
            "nombre" => "Juan Bernal",
            "documento" => "1.000.000.001",
            "telefono" => "300 000 0000",
            "licencia" => "C1",
            "estado" => "Activo"
        ];
    }


    /**
     * Rutas disponibles para el conductor.
     */
    public function obtenerRutas()
    {
        return [
            [
                "id" => 1,
                "nombre" => "Ruta 01: Centro - Chía",
                "vehiculo" => "BUS-7892",
                "estado" => "Activo"
            ],

            [
                "id" => 2,
                "nombre" => "Ruta 02: Chía - Centro",
                "vehiculo" => "BUS-4567",
                "estado" => "Activo"
            ],

            [
                "id" => 3,
                "nombre" => "Ruta 03: Chía - Cajicá",
                "vehiculo" => "BUS-3210",
                "estado" => "Activo"
            ]
        ];
    }


    /**
     * Iniciar una ruta.
     *
     * Por ahora solamente devuelve el estado.
     * Después podemos conectarlo a la BD.
     */
    public function iniciarRuta($rutaId)
    {
        return [
            "success" => true,
            "estado" => "EN RUTA",
            "mensaje" => "La ruta ha sido iniciada correctamente."
        ];
    }


    /**
     * Finalizar una ruta.
     */
    public function finalizarRuta($rutaId)
    {
        return [
            "success" => true,
            "estado" => "FINALIZADA",
            "mensaje" => "La ruta ha sido finalizada correctamente."
        ];
    }
}