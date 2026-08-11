<?php

/**
 * ============================================================
 * VISTA 17 - DASHBOARD CONDUCTOR
 * ============================================================
 */

require_once __DIR__ . '/../controllers/cdascon.php';


$controlador = new Cdascon();

$datos = $controlador->index();


$conductor = $datos["conductor"];

$resumen = $datos["resumen"];

$rutaActual = $datos["rutaActual"];

$proximasRutas = $datos["proximasRutas"];

$alertas = $datos["alertas"];

?>


<style>

/* ============================================================
   DASHBOARD CONDUCTOR
   ============================================================ */

.dashboard-conductor {

    width: 100%;

    padding: 25px;

    box-sizing: border-box;

}


/* ============================================================
   ENCABEZADO
   ============================================================ */

.dc-header {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 20px;

    margin-bottom: 24px;

    flex-wrap: wrap;

}


.dc-title {

    margin: 0;

    color: #102a43;

    font-size: 28px;

    font-weight: 800;

}


.dc-subtitle {

    margin: 5px 0 0;

    color: #607d8b;

    font-size: 14px;

}


.dc-driver {

    display: flex;

    align-items: center;

    gap: 12px;

    background: #ffffff;

    border: 1px solid #dcecf2;

    border-radius: 12px;

    padding: 10px 16px;

    box-shadow: 0 5px 18px rgba(0,0,0,.05);

}


.dc-avatar {

    width: 45px;

    height: 45px;

    border-radius: 50%;

    background: #e3f7fb;

    color: #009bbd;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 19px;

}


.dc-driver-name {

    color: #17324d;

    font-size: 14px;

    font-weight: 700;

}


.dc-driver-status {

    color: #2e7d32;

    font-size: 11px;

    margin-top: 2px;

}


/* ============================================================
   TARJETAS DE RESUMEN
   ============================================================ */

.dc-summary {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 15px;

    margin-bottom: 20px;

}


.dc-stat {

    background: #ffffff;

    border: 1px solid #dcecf2;

    border-radius: 13px;

    padding: 18px;

    box-shadow: 0 5px 18px rgba(0,0,0,.05);

    display: flex;

    align-items: center;

    gap: 13px;

}


.dc-stat-icon {

    width: 48px;

    height: 48px;

    border-radius: 11px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #e5f8fc;

    color: #009bbd;

    font-size: 19px;

}


.dc-stat-label {

    color: #78909c;

    font-size: 11px;

    display: block;

    text-transform: uppercase;

    font-weight: 700;

}


.dc-stat-value {

    color: #17324d;

    font-size: 21px;

    font-weight: 800;

    display: block;

    margin-top: 2px;

}


/* ============================================================
   GRID PRINCIPAL
   ============================================================ */

.dc-main-grid {

    display: grid;

    grid-template-columns:
        minmax(0, 1.7fr)
        minmax(280px, .8fr);

    gap: 20px;

    align-items: start;

}


/* ============================================================
   TARJETA GENERAL
   ============================================================ */

.dc-card {

    background: #ffffff;

    border: 1px solid #dcecf2;

    border-radius: 14px;

    box-shadow: 0 5px 18px rgba(0,0,0,.05);

    overflow: hidden;

}


.dc-card-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 17px 20px;

    border-bottom: 1px solid #edf3f5;

}


.dc-card-title {

    margin: 0;

    color: #17324d;

    font-size: 15px;

    font-weight: 800;

}


.dc-card-title i {

    color: #00a8c8;

    margin-right: 7px;

}


/* ============================================================
   ESTADO DE RUTA
   ============================================================ */

.dc-route-status {

    padding: 20px;

}


.dc-route-top {

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    margin-bottom: 18px;

}


.dc-route-name {

    margin: 0;

    color: #17324d;

    font-size: 20px;

    font-weight: 800;

}


.dc-route-vehicle {

    color: #78909c;

    font-size: 12px;

    margin-top: 4px;

}


.dc-status-badge {

    background: #e5f7e9;

    color: #2e7d32;

    padding: 6px 11px;

    border-radius: 20px;

    font-size: 11px;

    font-weight: 800;

    white-space: nowrap;

}


.dc-progress-label {

    display: flex;

    justify-content: space-between;

    color: #607d8b;

    font-size: 11px;

    font-weight: 700;

    margin-bottom: 7px;

}


.dc-progress {

    width: 100%;

    height: 11px;

    background: #edf1f3;

    border-radius: 20px;

    overflow: hidden;

}


.dc-progress-value {

    height: 100%;

    width: <?= (int)$rutaActual["progreso"]; ?>%;

    background: #00abc7;

    border-radius: 20px;

}


.dc-route-details {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 10px;

    margin-top: 20px;

}


.dc-route-detail {

    background: #f7fbfc;

    border-radius: 9px;

    padding: 12px;

}


.dc-detail-label {

    display: block;

    color: #90a4ae;

    font-size: 10px;

    text-transform: uppercase;

    font-weight: 700;

}


.dc-detail-value {

    display: block;

    color: #17324d;

    font-size: 13px;

    font-weight: 800;

    margin-top: 4px;

}


/* ============================================================
   PRÓXIMA PARADA
   ============================================================ */

.dc-next-stop {

    margin-top: 18px;

    padding: 15px;

    background: #fff9e8;

    border-left: 4px solid #ffbd00;

    border-radius: 7px;

}


.dc-next-stop-title {

    color: #8a6500;

    font-size: 10px;

    text-transform: uppercase;

    font-weight: 800;

}


.dc-next-stop-name {

    color: #3d4650;

    font-size: 15px;

    font-weight: 800;

    margin-top: 3px;

}


.dc-next-stop-time {

    color: #8a6500;

    font-size: 12px;

    margin-top: 2px;

}


/* ============================================================
   TELEMETRÍA
   ============================================================ */

.dc-telemetry {

    display: grid;

    grid-template-columns:
        1fr 1fr;

    gap: 10px;

    padding: 18px 20px;

}


.dc-telemetry-item {

    text-align: center;

    background: #eaf9fc;

    border-radius: 10px;

    padding: 16px 8px;

}


.dc-telemetry-icon {

    color: #009bbd;

    font-size: 18px;

}


.dc-telemetry-label {

    display: block;

    color: #78909c;

    font-size: 10px;

    margin-top: 6px;

}


.dc-telemetry-value {

    display: block;

    color: #173b83;

    font-size: 17px;

    font-weight: 800;

    margin-top: 2px;

}


/* ============================================================
   ALERTAS
   ============================================================ */

.dc-alert-list {

    padding: 5px 20px 18px;

}


.dc-alert {

    display: flex;

    gap: 11px;

    padding: 12px 0;

    border-bottom: 1px solid #edf3f5;

}


.dc-alert:last-child {

    border-bottom: 0;

}


.dc-alert-icon {

    width: 34px;

    height: 34px;

    border-radius: 8px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #fff3dc;

    color: #e49b00;

    flex-shrink: 0;

}


.dc-alert-title {

    color: #30485d;

    font-size: 12px;

    font-weight: 800;

}


.dc-alert-description {

    color: #78909c;

    font-size: 11px;

    line-height: 1.4;

    margin-top: 2px;

}


.dc-alert-time {

    color: #a0adb5;

    font-size: 10px;

    margin-top: 3px;

}


/* ============================================================
   PRÓXIMAS RUTAS
   ============================================================ */

.dc-routes-list {

    padding: 5px 20px 18px;

}


.dc-route-item {

    display: flex;

    align-items: center;

    gap: 12px;

    padding: 12px 0;

    border-bottom: 1px solid #edf3f5;

}


.dc-route-item:last-child {

    border-bottom: 0;

}


.dc-route-time {

    min-width: 65px;

    color: #009bbd;

    font-size: 12px;

    font-weight: 800;

}


.dc-route-info {

    flex: 1;

}


.dc-route-info-name {

    color: #30485d;

    font-size: 12px;

    font-weight: 800;

}


.dc-route-info-bus {

    color: #90a4ae;

    font-size: 10px;

    margin-top: 3px;

}


.dc-route-tag {

    background: #eef7fa;

    color: #0089a7;

    padding: 4px 7px;

    border-radius: 6px;

    font-size: 9px;

    font-weight: 800;

}


/* ============================================================
   JORNADA
   ============================================================ */

.dc-day-progress {

    padding: 18px 20px;

}


.dc-day-progress-bar {

    width: 100%;

    height: 8px;

    background: #edf1f3;

    border-radius: 20px;

    overflow: hidden;

    margin-top: 8px;

}


.dc-day-progress-value {

    width: 66%;

    height: 100%;

    background: #00abc7;

    border-radius: 20px;

}


.dc-day-text {

    display: flex;

    justify-content: space-between;

    color: #607d8b;

    font-size: 11px;

    font-weight: 700;

}


/* ============================================================
   RESPONSIVE
   ============================================================ */

@media (max-width: 1100px) {

    .dc-summary {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }


    .dc-main-grid {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 700px) {

    .dashboard-conductor {

        padding: 15px;

    }


    .dc-summary {

        grid-template-columns: 1fr;

    }


    .dc-route-details {

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

    }


    .dc-route-top {

        align-items: flex-start;

        flex-direction: column;

    }

}

</style>


<div class="dashboard-conductor">


    <!-- ========================================================
         ENCABEZADO
         ======================================================== -->

    <div class="dc-header">

        <div>

            <h1 class="dc-title">

                <i class="fas fa-gauge-high me-2"></i>

                Dashboard Conductor

            </h1>

            <p class="dc-subtitle">

                Resumen de tu jornada y seguimiento de rutas.

            </p>

        </div>


        <div class="dc-driver">

            <div class="dc-avatar">

                <i class="fas fa-user"></i>

            </div>

            <div>

                <div class="dc-driver-name">

                    <?= htmlspecialchars($conductor["nombre"]); ?>

                </div>

                <div class="dc-driver-status">

                    <i class="fas fa-circle me-1"></i>

                    <?= htmlspecialchars($conductor["estado"]); ?>

                    · Jornada <?= htmlspecialchars($conductor["jornada"]); ?>

                </div>

            </div>

        </div>

    </div>



    <!-- ========================================================
         TARJETAS DE RESUMEN
         ======================================================== -->

    <div class="dc-summary">


        <!-- RUTAS -->

        <div class="dc-stat">

            <div class="dc-stat-icon">

                <i class="fas fa-route"></i>

            </div>

            <div>

                <span class="dc-stat-label">
                    Rutas completadas
                </span>

                <span class="dc-stat-value">

                    <?= $resumen["rutasCompletadas"]; ?>

                    <small style="font-size:12px;color:#90a4ae;">
                        / <?= $resumen["rutasProgramadas"]; ?>
                    </small>

                </span>

            </div>

        </div>


        <!-- PARADAS -->

        <div class="dc-stat">

            <div class="dc-stat-icon">

                <i class="fas fa-location-dot"></i>

            </div>

            <div>

                <span class="dc-stat-label">
                    Paradas realizadas
                </span>

                <span class="dc-stat-value">

                    <?= $resumen["paradasRealizadas"]; ?>

                    <small style="font-size:12px;color:#90a4ae;">
                        / <?= $resumen["paradasTotales"]; ?>
                    </small>

                </span>

            </div>

        </div>


        <!-- TIEMPO -->

        <div class="dc-stat">

            <div class="dc-stat-icon">

                <i class="fas fa-clock"></i>

            </div>

            <div>

                <span class="dc-stat-label">
                    Tiempo conducción
                </span>

                <span class="dc-stat-value">

                    <?= htmlspecialchars($resumen["tiempoConduccion"]); ?>

                </span>

            </div>

        </div>


        <!-- KILÓMETROS -->

        <div class="dc-stat">

            <div class="dc-stat-icon">

                <i class="fas fa-road"></i>

            </div>

            <div>

                <span class="dc-stat-label">
                    Distancia recorrida
                </span>

                <span class="dc-stat-value">

                    <?= htmlspecialchars($resumen["kilometros"]); ?>

                </span>

            </div>

        </div>

    </div>



    <!-- ========================================================
         CONTENIDO PRINCIPAL
         ======================================================== -->

    <div class="dc-main-grid">


        <!-- ====================================================
             COLUMNA PRINCIPAL
             ==================================================== -->

        <div>


            <!-- =================================================
                 RUTA ACTUAL
                 ================================================= -->

            <div class="dc-card">

                <div class="dc-card-header">

                    <h2 class="dc-card-title">

                        <i class="fas fa-location-arrow"></i>

                        Ruta actual

                    </h2>

                    <span class="dc-status-badge">

                        <i class="fas fa-circle me-1"></i>

                        <?= htmlspecialchars($rutaActual["estado"]); ?>

                    </span>

                </div>


                <div class="dc-route-status">


                    <div class="dc-route-top">

                        <div>

                            <h3 class="dc-route-name">

                                <?= htmlspecialchars($rutaActual["nombre"]); ?>

                            </h3>

                            <div class="dc-route-vehicle">

                                <i class="fas fa-bus me-1"></i>

                                Vehículo:

                                <strong>
                                    <?= htmlspecialchars($rutaActual["vehiculo"]); ?>
                                </strong>

                            </div>

                        </div>

                    </div>


                    <!-- PROGRESO -->

                    <div class="dc-progress-label">

                        <span>
                            Progreso de ruta
                        </span>

                        <span>
                            <?= (int)$rutaActual["progreso"]; ?>%
                        </span>

                    </div>


                    <div class="dc-progress">

                        <div class="dc-progress-value"></div>

                    </div>


                    <!-- DATOS -->

                    <div class="dc-route-details">


                        <div class="dc-route-detail">

                            <span class="dc-detail-label">
                                Parada actual
                            </span>

                            <span class="dc-detail-value">
                                <?= htmlspecialchars($rutaActual["paradaActual"]); ?>
                            </span>

                        </div>


                        <div class="dc-route-detail">

                            <span class="dc-detail-label">
                                Velocidad
                            </span>

                            <span class="dc-detail-value">
                                <?= htmlspecialchars($rutaActual["velocidad"]); ?>
                            </span>

                        </div>


                        <div class="dc-route-detail">

                            <span class="dc-detail-label">
                                Tiempo ruta
                            </span>

                            <span class="dc-detail-value">
                                <?= htmlspecialchars($rutaActual["tiempoRuta"]); ?>
                            </span>

                        </div>


                        <div class="dc-route-detail">

                            <span class="dc-detail-label">
                                Inicio
                            </span>

                            <span class="dc-detail-value">
                                <?= htmlspecialchars($rutaActual["horaInicio"]); ?>
                            </span>

                        </div>

                    </div>


                    <!-- PRÓXIMA PARADA -->

                    <div class="dc-next-stop">

                        <div class="dc-next-stop-title">

                            <i class="fas fa-bell me-1"></i>

                            Próxima parada

                        </div>

                        <div class="dc-next-stop-name">

                            <?= htmlspecialchars($rutaActual["proximaParada"]); ?>

                        </div>

                        <div class="dc-next-stop-time">

                            Llegada estimada:
                            <?= htmlspecialchars($rutaActual["tiempoProximaParada"]); ?>

                        </div>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 TELEMETRÍA
                 ================================================= -->

            <div
                class="dc-card"
                style="margin-top:20px;"
            >

                <div class="dc-card-header">

                    <h2 class="dc-card-title">

                        <i class="fas fa-satellite-dish"></i>

                        Telemetría en vivo

                    </h2>

                </div>


                <div class="dc-telemetry">


                    <div class="dc-telemetry-item">

                        <i class="fas fa-gauge-high dc-telemetry-icon"></i>

                        <span class="dc-telemetry-label">
                            Velocidad
                        </span>

                        <span class="dc-telemetry-value">
                            <?= htmlspecialchars($rutaActual["velocidad"]); ?>
                        </span>

                    </div>


                    <div class="dc-telemetry-item">

                        <i class="fas fa-clock dc-telemetry-icon"></i>

                        <span class="dc-telemetry-label">
                            Tiempo de ruta
                        </span>

                        <span class="dc-telemetry-value">
                            <?= htmlspecialchars($rutaActual["tiempoRuta"]); ?>
                        </span>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 PRÓXIMAS RUTAS
                 ================================================= -->

            <div
                class="dc-card"
                style="margin-top:20px;"
            >

                <div class="dc-card-header">

                    <h2 class="dc-card-title">

                        <i class="fas fa-calendar-days"></i>

                        Próximas rutas

                    </h2>

                </div>


                <div class="dc-routes-list">

                    <?php foreach ($proximasRutas as $ruta) { ?>

                        <div class="dc-route-item">


                            <div class="dc-route-time">

                                <?= htmlspecialchars($ruta["hora"]); ?>

                            </div>


                            <div class="dc-route-info">

                                <div class="dc-route-info-name">

                                    <?= htmlspecialchars($ruta["ruta"]); ?>

                                </div>

                                <div class="dc-route-info-bus">

                                    <i class="fas fa-bus me-1"></i>

                                    <?= htmlspecialchars($ruta["vehiculo"]); ?>

                                </div>

                            </div>


                            <span class="dc-route-tag">

                                <?= htmlspecialchars($ruta["estado"]); ?>

                            </span>


                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>



        <!-- ====================================================
             COLUMNA DERECHA
             ==================================================== -->

        <div>


            <!-- =================================================
                 ESTADO DE JORNADA
                 ================================================= -->

            <div class="dc-card">

                <div class="dc-card-header">

                    <h2 class="dc-card-title">

                        <i class="fas fa-chart-simple"></i>

                        Jornada de hoy

                    </h2>

                </div>


                <div class="dc-day-progress">

                    <div class="dc-day-text">

                        <span>
                            Rutas realizadas
                        </span>

                        <span>
                            <?= $resumen["rutasCompletadas"]; ?>
                            /
                            <?= $resumen["rutasProgramadas"]; ?>
                        </span>

                    </div>


                    <div class="dc-day-progress-bar">

                        <div class="dc-day-progress-value"></div>

                    </div>


                    <div
                        style="
                            margin-top:12px;
                            color:#607d8b;
                            font-size:11px;
                            line-height:1.5;
                        "
                    >

                        Has completado buena parte de tu jornada.
                        Mantén el cumplimiento de los horarios
                        establecidos.

                    </div>

                </div>

            </div>



            <!-- =================================================
                 ALERTAS
                 ================================================= -->

            <div
                class="dc-card"
                style="margin-top:20px;"
            >

                <div class="dc-card-header">

                    <h2 class="dc-card-title">

                        <i class="fas fa-triangle-exclamation"></i>

                        Alertas

                    </h2>

                </div>


                <div class="dc-alert-list">

                    <?php foreach ($alertas as $alerta) { ?>

                        <div class="dc-alert">


                            <div class="dc-alert-icon">

                                <?php if ($alerta["tipo"] == "trafico") { ?>

                                    <i class="fas fa-car"></i>

                                <?php } else { ?>

                                    <i class="fas fa-info"></i>

                                <?php } ?>

                            </div>


                            <div>

                                <div class="dc-alert-title">

                                    <?= htmlspecialchars($alerta["titulo"]); ?>

                                </div>


                                <div class="dc-alert-description">

                                    <?= htmlspecialchars($alerta["descripcion"]); ?>

                                </div>


                                <div class="dc-alert-time">

                                    <?= htmlspecialchars($alerta["hora"]); ?>

                                </div>

                            </div>


                        </div>

                    <?php } ?>

                </div>

            </div>


        </div>

    </div>

</div>