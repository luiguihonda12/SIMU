<?php

require_once __DIR__ . '/../controllers/cgpqrs.php';

$controlador = new Cgpqrs();

$pqrs = $controlador->listar();

$resumen = $controlador->resumen();

?>

<style>

.gpqrs-container {
    padding: 25px;
    width: 100%;
}

.gpqrs-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
    gap: 15px;
    flex-wrap: wrap;
}

.gpqrs-title {
    margin: 0;
    color: #102a43;
    font-size: 27px;
    font-weight: 800;
}

.gpqrs-subtitle {
    margin: 5px 0 0;
    color: #78909c;
    font-size: 13px;
}

.gpqrs-refresh {
    background: #00a4c4;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 11px;
    font-weight: 800;
}

.gpqrs-refresh:hover {
    background: #008da9;
    color: #fff;
}

.gpqrs-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.gpqrs-stat {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 12px;
    padding: 17px;
    box-shadow: 0 4px 15px rgba(0,0,0,.04);
    display: flex;
    align-items: center;
    gap: 13px;
}

.gpqrs-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #e7f8fb;
    color: #00a4c4;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
}

.gpqrs-stat-number {
    color: #17324d;
    font-size: 21px;
    font-weight: 800;
    line-height: 1;
}

.gpqrs-stat-label {
    color: #90a4ae;
    font-size: 10px;
    font-weight: 700;
    margin-top: 4px;
}

.gpqrs-card {
    background: #fff;
    border: 1px solid #dcecf2;
    border-radius: 14px;
    box-shadow: 0 5px 18px rgba(0,0,0,.05);
    overflow: hidden;
}

.gpqrs-card-header {
    padding: 17px 20px;
    border-bottom: 1px solid #edf3f5;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.gpqrs-card-title {
    margin: 0;
    color: #17324d;
    font-size: 15px;
    font-weight: 800;
}

.gpqrs-card-title i {
    color: #00a4c4;
    margin-right: 7px;
}

.gpqrs-count {
    background: #e7f8fb;
    color: #008ba8;
    padding: 5px 9px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: 800;
}

.gpqrs-table-wrap {
    overflow-x: auto;
}

.gpqrs-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 850px;
}

.gpqrs-table th {
    background: #f6fafb;
    color: #78909c;
    padding: 12px 15px;
    font-size: 10px;
    text-transform: uppercase;
    font-weight: 800;
    text-align: left;
    border-bottom: 1px solid #e6eef1;
}

.gpqrs-table td {
    padding: 14px 15px;
    color: #4e6576;
    font-size: 11px;
    font-weight: 600;
    border-bottom: 1px solid #edf3f5;
}

.gpqrs-table tr:last-child td {
    border-bottom: 0;
}

.gpqrs-table tr:hover td {
    background: #fbfdfe;
}

.gpqrs-code {
    color: #008da9;
    font-weight: 800;
}

.gpqrs-citizen {
    color: #17324d;
    font-weight: 800;
}

.gpqrs-type {
    display: inline-block;
    background: #eef7fa;
    color: #417080;
    border-radius: 5px;
    padding: 5px 7px;
    font-size: 10px;
}

.gpqrs-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border-radius: 15px;
    padding: 6px 9px;
    font-size: 9px;
    font-weight: 800;
    white-space: nowrap;
}

.gpqrs-review {
    background: #fff3d5;
    color: #8b6800;
}

.gpqrs-process {
    background: #e4f5fb;
    color: #087b9c;
}

.gpqrs-success {
    background: #e5f6e8;
    color: #287a34;
}

.gpqrs-danger {
    background: #fde8e8;
    color: #a22c2c;
}

.gpqrs-priority {
    font-weight: 800;
}

.gpqrs-high {
    color: #d04444;
}

.gpqrs-medium {
    color: #c18a00;
}

.gpqrs-low {
    color: #41934a;
}

.gpqrs-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 7px;
    background: #e8f8fb;
    color: #009bbd;
    text-decoration: none;
    transition: .2s;
}

.gpqrs-action:hover {
    background: #00a4c4;
    color: #fff;
}

.gpqrs-empty {
    text-align: center;
    padding: 40px;
    color: #90a4ae;
}

@media (max-width: 900px) {

    .gpqrs-summary {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .gpqrs-container {
        padding: 15px;
    }

    .gpqrs-summary {
        grid-template-columns: 1fr;
    }

    .gpqrs-title {
        font-size: 22px;
    }

}

</style>


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
            style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;"
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
                class="gpqrs-refresh"
                style="background:#edf2f4;color:#607d8b;"
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
                                    class="fas fa-inbox"
                                    style="font-size:2rem;margin-bottom:10px;"
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