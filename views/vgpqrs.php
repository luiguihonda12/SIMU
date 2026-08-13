<?php

require_once __DIR__ . '/../controllers/cgpqrs.php';

$controlador = new Cgpqrs();

$pqrs = $controlador->listar();

$resumen = $controlador->resumen();

?>


<div class="gpqrs-container">

    <!-- // Encabezado -->
    <div class="gpqrs-header">

        <div>

            <h1 class="gpqrs-title">
                <i class="fas fa-comments me-2"></i>
                Gestión PQRS
            </h1>

            <p class="gpqrs-subtitle">
                Consulta, seguimiento y gestión de las solicitudes ciudadanas.
            </p>

        </div>

        <div
            class="gpqrs-header-actions"
        >

            <a
                href="index.php?pg=nuevaPQRS"
                class="gpqrs-refresh"
            >
                <i class="fas fa-plus me-1"></i>
                Nueva PQRS
            </a>

            <a
                href="index.php?pg=gestionPQRS"
                class="gpqrs-refresh gpqrs-refresh-secondary"
            >
                <i class="fas fa-rotate me-1"></i>
                Actualizar
            </a>

        </div>

    </div>


    <!-- // Resumen -->
    <div class="gpqrs-summary">


        <div class="gpqrs-stat">

            <div class="gpqrs-stat-icon">
                <i class="fas fa-folder-open"></i>
            </div>

            <div>

                <div class="gpqrs-stat-number">
                    <?= $resumen['total']; ?>
                </div>

                <div class="gpqrs-stat-label">
                    Total PQRS
                </div>

            </div>

        </div>


        <div class="gpqrs-stat">

            <div class="gpqrs-stat-icon">
                <i class="fas fa-clock"></i>
            </div>

            <div>

                <div class="gpqrs-stat-number">
                    <?= $resumen['revision']; ?>
                </div>

                <div class="gpqrs-stat-label">
                    En revisión
                </div>

            </div>

        </div>


        <div class="gpqrs-stat">

            <div class="gpqrs-stat-icon">
                <i class="fas fa-spinner"></i>
            </div>

            <div>

                <div class="gpqrs-stat-number">
                    <?= $resumen['proceso']; ?>
                </div>

                <div class="gpqrs-stat-label">
                    En proceso
                </div>

            </div>

        </div>


        <div class="gpqrs-stat">

            <div class="gpqrs-stat-icon">
                <i class="fas fa-circle-check"></i>
            </div>

            <div>

                <div class="gpqrs-stat-number">
                    <?= $resumen['resueltas']; ?>
                </div>

                <div class="gpqrs-stat-label">
                    Resueltas
                </div>

            </div>

        </div>

    </div>


    <!-- // Tabla -->
    <div class="gpqrs-card">

        <div class="gpqrs-card-header">

            <h2 class="gpqrs-card-title">

                <i class="fas fa-list"></i>

                Solicitudes recibidas

            </h2>

            <span class="gpqrs-count">

                <?= count($pqrs); ?> registros

            </span>

        </div>


        <div class="gpqrs-table-wrap">

            <table class="gpqrs-table">

                <thead>

                    <tr>

                        <th>
                            Código
                        </th>

                        <th>
                            Ciudadano
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Categoría
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Prioridad
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (!empty($pqrs)) { ?>

                        <?php foreach ($pqrs as $item) { ?>


                            <?php

                            $estadoClase = 'gpqrs-review';
                            $estadoIcono = 'fa-clock';

                            if ($item['estado'] === 'En proceso') {
                                $estadoClase = 'gpqrs-process';
                                $estadoIcono = 'fa-spinner';
                            }

                            if ($item['estado'] === 'Resuelta') {
                                $estadoClase = 'gpqrs-success';
                                $estadoIcono = 'fa-circle-check';
                            }

                            if ($item['estado'] === 'Rechazada') {
                                $estadoClase = 'gpqrs-danger';
                                $estadoIcono = 'fa-circle-xmark';
                            }


                            $prioridadClase = 'gpqrs-medium';

                            if ($item['prioridad'] === 'Alta') {
                                $prioridadClase = 'gpqrs-high';
                            }

                            if ($item['prioridad'] === 'Baja') {
                                $prioridadClase = 'gpqrs-low';
                            }

                            ?>


                            <tr>

                                <td>

                                    <span class="gpqrs-code">

                                        <?= htmlspecialchars($item['id']); ?>

                                    </span>

                                </td>


                                <td>

                                    <span class="gpqrs-citizen">

                                        <?= htmlspecialchars($item['ciudadano']); ?>

                                    </span>

                                </td>


                                <td>

                                    <span class="gpqrs-type">

                                        <?= htmlspecialchars($item['tipo']); ?>

                                    </span>

                                </td>


                                <td>

                                    <?= htmlspecialchars($item['categoria']); ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars($item['fecha']); ?>

                                </td>


                                <td>

                                    <span class="gpqrs-priority <?= $prioridadClase; ?>">

                                        <?= htmlspecialchars($item['prioridad']); ?>

                                    </span>

                                </td>


                                <td>

                                    <span class="gpqrs-status <?= $estadoClase; ?>">

                                        <i class="fas <?= $estadoIcono; ?>"></i>

                                        <?= htmlspecialchars($item['estado']); ?>

                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="index.php?pg=detallePQRS&id=<?= urlencode($item['id']); ?>"
                                        class="gpqrs-action"
                                        title="Ver detalle"
                                    >

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>


                        <?php } ?>

                    <?php } else { ?>

                        <tr>

                            <td
                                colspan="8"
                                class="gpqrs-empty"
                            >

                                <i
                                    class="fas fa-inbox gpqrs-empty-icon"
                                ></i>

                                <br>

                                No hay PQRS registradas.

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>