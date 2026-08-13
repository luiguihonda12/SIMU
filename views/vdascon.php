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

                    <small class="dc-hint">
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

                    <small class="dc-hint">
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

                        <div class="dc-progress-value" style="--dc-progreso: <?= (int)$rutaActual["progreso"]; ?>%;"></div>

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
                class="dc-card dc-mt20"
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
                class="dc-card dc-mt20"
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
                        class="dc-day-note"
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
                class="dc-card dc-mt20"
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