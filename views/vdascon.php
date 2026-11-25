<?php
require_once __DIR__ . '/../controllers/cdascon.php';

$controlador = new Cdascon();
$datos = $controlador->index();

$conductor = $datos["conductor"];
$listaConductores = $datos["listaConductores"];
$resumen = $datos["resumen"];
$rutaActual = $datos["rutaActual"];
$proximasRutas = $datos["proximasRutas"];
$alertas = $datos["alertas"];
$idSeleccionado = $datos["idSeleccionado"];
?>

<div class="container-fluid px-0">

    <!-- Selector de Conductor para el Dashboard -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-3">
                    <label for="selectorDashboardConductor" class="form-label fw-bold text-dark mb-1 mb-md-0">
                        <i class="fas fa-gauge text-primary me-1"></i> Seleccionar Conductor:
                    </label>
                </div>
                <div class="col-12 col-md-9">
                    <select id="selectorDashboardConductor" class="form-select" onchange="if(this.value) { window.location.href='index.php?pg=dashboardConductor&id='+this.value; } else { window.location.href='index.php?pg=dashboardConductor'; }">
                        <option value="">-- Seleccione un conductor para ver su dashboard --</option>
                        <?php foreach ($listaConductores as $c) { ?>
                            <option value="<?= $c['id']; ?>" <?= (string)$c['id'] === (string)$idSeleccionado ? 'selected' : ''; ?>>
                                [ID: <?= $c['id']; ?>] <?= htmlspecialchars($c['nombre']); ?> (Licencia: <?= htmlspecialchars($c['licencia']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <?php if (!$conductor) { ?>
        <!-- Mensaje cuando no hay conductor seleccionado en el dashboard -->
        <div class="card shadow-sm border-0 text-center p-5 bg-white">
            <div class="card-body">
                <div class="text-primary mb-3">
                    <i class="fas fa-chart-line fa-3x"></i>
                </div>
                <h4 class="fw-bold text-dark">Ningún conductor seleccionado</h4>
                <p class="text-muted">Por favor, seleccione un conductor en el menú superior para visualizar sus estadísticas, jornada actual, telemetría y rutas programadas.</p>
            </div>
        </div>
    <?php } else { ?>

        <!-- Encabezado con datos del conductor seleccionado -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 bg-white p-4 rounded shadow-sm border">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1">
                    <i class="fas fa-gauge-high me-2 text-primary"></i> Dashboard Conductor
                </h1>
                <p class="text-muted small mb-0">Resumen de jornada y seguimiento para <strong><?= htmlspecialchars($conductor["nombre"]); ?></strong>.</p>
            </div>
            <div class="d-flex align-items-center bg-light p-2 rounded border">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 38px; height: 38px;">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <strong class="d-block text-dark small"><?= htmlspecialchars($conductor["nombre"]); ?></strong>
                    <span class="text-muted" style="font-size: 0.75rem;"><span class="badge bg-success"><?= htmlspecialchars($conductor["estado"]); ?></span> · Jornada <?= htmlspecialchars($conductor["jornada"]); ?></span>
                </div>
            </div>
        </div>

        <!-- Tarjetas de Resumen -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 bg-white h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded p-3 me-3"><i class="fas fa-route fa-lg"></i></div>
                        <div>
                            <span class="text-muted d-block small">Rutas completadas</span>
                            <strong class="fs-4 text-dark"><?= $resumen["rutasCompletadas"]; ?></strong> <small class="text-muted">/ <?= $resumen["rutasProgramadas"]; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 bg-white h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-success text-white rounded p-3 me-3"><i class="fas fa-location-dot fa-lg"></i></div>
                        <div>
                            <span class="text-muted d-block small">Paradas realizadas</span>
                            <strong class="fs-4 text-dark"><?= $resumen["paradasRealizadas"]; ?></strong> <small class="text-muted">/ <?= $resumen["paradasTotales"]; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 bg-white h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-info text-white rounded p-3 me-3"><i class="fas fa-clock fa-lg"></i></div>
                        <div>
                            <span class="text-muted d-block small">Tiempo conducción</span>
                            <strong class="fs-4 text-dark"><?= htmlspecialchars($resumen["tiempoConduccion"]); ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card shadow-sm border-0 bg-white h-100 p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-dark rounded p-3 me-3"><i class="fas fa-road fa-lg"></i></div>
                        <div>
                            <span class="text-muted d-block small">Distancia recorrida</span>
                            <strong class="fs-4 text-dark"><?= htmlspecialchars($resumen["kilometros"]); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <!-- Ruta Actual -->
                <div class="card shadow-sm border-0 mb-4 bg-white">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-location-arrow text-primary me-2"></i> Ruta actual</h5>
                        <span class="badge bg-success"><?= htmlspecialchars($rutaActual["estado"]); ?></span>
                    </div>
                    <div class="card-body">
                        <h4 class="fw-bold text-dark"><?= htmlspecialchars($rutaActual["nombre"]); ?></h4>
                        <p class="text-muted small"><i class="fas fa-bus me-1"></i> Vehículo: <strong><?= htmlspecialchars($rutaActual["vehiculo"]); ?></strong></p>

                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Progreso de ruta</span>
                            <span><?= (int)$rutaActual["progreso"]; ?>%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: <?= (int)$rutaActual["progreso"]; ?>%;"></div>
                        </div>

                        <div class="row g-3 text-center bg-light p-3 rounded mb-3">
                            <div class="col-6 col-md-3 border-end">
                                <span class="text-muted d-block small">Parada actual</span>
                                <strong class="text-dark small"><?= htmlspecialchars($rutaActual["paradaActual"]); ?></strong>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <span class="text-muted d-block small">Velocidad</span>
                                <strong class="text-dark small"><?= htmlspecialchars($rutaActual["velocidad"]); ?></strong>
                            </div>
                            <div class="col-6 col-md-3 border-end">
                                <span class="text-muted d-block small">Tiempo ruta</span>
                                <strong class="text-dark small"><?= htmlspecialchars($rutaActual["tiempoRuta"]); ?></strong>
                            </div>
                            <div class="col-6 col-md-3">
                                <span class="text-muted d-block small">Inicio</span>
                                <strong class="text-dark small"><?= htmlspecialchars($rutaActual["horaInicio"]); ?></strong>
                            </div>
                        </div>

                        <div class="alert alert-warning py-2 mb-0">
                            <i class="fas fa-bell me-1"></i> <strong>Próxima parada:</strong> <?= htmlspecialchars($rutaActual["proximaParada"]); ?> (Llegada estimada: <?= htmlspecialchars($rutaActual["tiempoProximaParada"]); ?>)
                        </div>
                    </div>
                </div>

                <!-- Próximas Rutas -->
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-calendar-days text-primary me-2"></i> Próximas rutas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($proximasRutas as $r) { ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <span class="badge bg-secondary me-2"><?= htmlspecialchars($r["hora"]); ?></span>
                                        <strong class="text-dark"><?= htmlspecialchars($r["ruta"]); ?></strong>
                                        <div class="text-muted small"><i class="fas fa-bus me-1"></i> <?= htmlspecialchars($r["vehiculo"]); ?></div>
                                    </div>
                                    <span class="badge bg-info text-dark"><?= htmlspecialchars($r["estado"]); ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <!-- Jornada de hoy -->
                <div class="card shadow-sm border-0 mb-4 bg-white">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-chart-simple text-primary me-2"></i> Jornada de hoy</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Rutas realizadas</span>
                            <span><?= $resumen["rutasCompletadas"]; ?> / <?= $resumen["rutasProgramadas"]; ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 66%;"></div>
                        </div>
                        <p class="text-muted small mb-0">Has completado buena parte de tu jornada. Mantén el cumplimiento de los horarios establecidos.</p>
                    </div>
                </div>

                <!-- Alertas -->
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-triangle-exclamation text-warning me-2"></i> Alertas</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($alertas as $alerta) { ?>
                            <div class="d-flex mb-3 pb-3 border-bottom last-border-0">
                                <div class="text-warning me-3 pt-1"><i class="fas fa-info-circle fa-lg"></i></div>
                                <div>
                                    <strong class="d-block text-dark small"><?= htmlspecialchars($alerta["titulo"]); ?></strong>
                                    <span class="text-muted small"><?= htmlspecialchars($alerta["descripcion"]); ?></span>
                                    <small class="text-muted d-block mt-1"><?= htmlspecialchars($alerta["hora"]); ?></small>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>