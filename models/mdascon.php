<?php

/**
 * ============================================================
 * MODELO: DASHBOARD CONDUCTOR
 * Vista 17
 * ============================================================
 */

class Mdascon
{
    /**
     * Información general del conductor.
     */
    public function obtenerConductor()
    {
        return [
            "id" => 1,
            "nombre" => "Juan Bernal",
            "documento" => "1.000.000.001",
            "licencia" => "C1",
            "estado" => "Activo",
            "jornada" => "Mañana"
        ];
    }


    /**
     * Resumen de la jornada actual.
     */
    public function obtenerResumen()
    {
        return [
            "rutasCompletadas" => 4,
            "rutasProgramadas" => 6,
            "paradasRealizadas" => 18,
            "paradasTotales" => 25,
            "tiempoConduccion" => "04h 35m",
            "kilometros" => "86.4 km"
        ];
    }


    /**
     * Información de la ruta actual.
     */
    public function obtenerRutaActual()
    {
        return [
            "nombre" => "Ruta 01: Centro - Chía",
            "vehiculo" => "BUS-7892",
            "estado" => "En ruta",
            "progreso" => 68,
            "paradaActual" => "Centro Comercial Sabana",
            "proximaParada" => "Parque Principal de Chía",
            "tiempoProximaParada" => "08 min",
            "velocidad" => "42 km/h",
            "tiempoRuta" => "01h 18m",
            "horaInicio" => "07:30 AM"
        ];
    }


    /**
     * Próximas rutas programadas.
     */
    public function obtenerProximasRutas()
    {
        return [
            [
                "hora" => "10:30 AM",
                "ruta" => "Ruta 02: Chía - Centro",
                "vehiculo" => "BUS-7892",
                "estado" => "Programada"
            ],

            [
                "hora" => "12:15 PM",
                "ruta" => "Ruta 03: Chía - Cajicá",
                "vehiculo" => "BUS-7892",
                "estado" => "Programada"
            ],

            [
                "hora" => "02:00 PM",
                "ruta" => "Ruta 01: Centro - Chía",
                "vehiculo" => "BUS-7892",
                "estado" => "Programada"
            ]
        ];
    }


    /**
     * Alertas del conductor.
     */
    public function obtenerAlertas()
    {
        return [
            [
                "tipo" => "trafico",
                "titulo" => "Tráfico moderado",
                "descripcion" => "Se presenta congestión en el sector Centro de Chía.",
                "hora" => "09:42 AM"
            ],

            [
                "tipo" => "informacion",
                "titulo" => "Próxima parada",
                "descripcion" => "Recuerde realizar parada en el Parque Principal.",
                "hora" => "09:38 AM"
            ]
        ];
    }
}