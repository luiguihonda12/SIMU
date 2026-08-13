<?php

/**
 * ============================================================
 * VISTA 16 - CONDUCTOR
 * ============================================================
 */

require_once __DIR__ . '/../controllers/ccondu.php';


$controladorConductor = new Ccondu();

$datosConductor = $controladorConductor->index();


$conductor = $datosConductor["conductor"];

$rutas = $datosConductor["rutas"];

$rutaSeleccionada = $datosConductor["rutaSeleccionada"];

$rutaActiva = $datosConductor["rutaActiva"];

$estadoRuta = $datosConductor["estadoRuta"];

?>

<style>

    /* ========================================================
       CONTENEDOR PRINCIPAL
       ======================================================== */

    .conductor-page {

        width: 100%;

        padding: 25px;

        box-sizing: border-box;

    }


    /* ========================================================
       ENCABEZADO
       ======================================================== */

    .conductor-header {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 22px;

        flex-wrap: wrap;

        gap: 15px;

    }


    .conductor-title {

        margin: 0;

        font-size: 28px;

        font-weight: 700;

        color: #102a43;

    }


    .conductor-subtitle {

        margin: 5px 0 0;

        color: #607d8b;

        font-size: 14px;

    }


    /* ========================================================
       TARJETA DEL CONDUCTOR
       ======================================================== */

    .conductor-info {

        background: #ffffff;

        border-radius: 14px;

        padding: 18px 20px;

        border: 1px solid #dcecf2;

        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);

        display: flex;

        align-items: center;

        gap: 15px;

    }


    .conductor-avatar {

        width: 52px;

        height: 52px;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #e5f7fb;

        color: #009bbd;

        font-size: 22px;

    }


    .conductor-info strong {

        display: block;

        font-size: 15px;

        color: #102a43;

    }


    .conductor-info span {

        display: block;

        margin-top: 4px;

        font-size: 13px;

        color: #78909c;

    }


    /* ========================================================
       SELECCIÓN DE RUTA
       ======================================================== */

    .route-selector-card {

        background: #ffffff;

        border-radius: 14px;

        padding: 20px;

        border: 1px solid #dcecf2;

        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);

        margin-bottom: 20px;

    }


    .route-label {

        display: block;

        font-size: 12px;

        text-transform: uppercase;

        letter-spacing: .06em;

        font-weight: 700;

        color: #607d8b;

        margin-bottom: 8px;

    }


    .route-select {

        width: 100%;

        max-width: 420px;

        height: 48px;

        border: 1px solid #c9e4eb;

        border-radius: 9px;

        background: #f8fcfd;

        color: #253b53;

        padding: 0 14px;

        font-size: 15px;

        font-weight: 600;

        outline: none;

    }


    .route-select:focus {

        border-color: #00a8c8;

        box-shadow: 0 0 0 3px rgba(0, 168, 200, .12);

    }


    .vehicle-info {

        margin-top: 10px;

        color: #607d8b;

        font-size: 13px;

    }


    /* ========================================================
       GRID PRINCIPAL
       ======================================================== */

    .conductor-grid {

        display: grid;

        grid-template-columns: minmax(0, 1fr) 290px;

        gap: 20px;

        align-items: start;

    }


    /* ========================================================
       MAPA
       ======================================================== */

    .map-card {

        background: #ffffff;

        border-radius: 14px;

        border: 1px solid #dcecf2;

        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);

        overflow: hidden;

    }


    .map-placeholder {

        height: 390px;

        background:
            linear-gradient(
                135deg,
                #e5e5e5,
                #d9d9d9
            );

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        color: #89939b;

        position: relative;

    }


    .map-placeholder i {

        font-size: 45px;

        margin-bottom: 10px;

        color: #8b9297;

    }


    .map-placeholder strong {

        font-size: 14px;

        font-weight: 600;

    }


    .map-placeholder span {

        margin-top: 5px;

        font-size: 12px;

    }


    /* ========================================================
       PROGRESO
       ======================================================== */

    .route-progress {

        padding: 18px 20px;

    }


    .route-progress-title {

        background: #ffbf00;

        color: #17202a;

        border-radius: 6px;

        padding: 9px 12px;

        font-size: 12px;

        font-weight: 700;

        margin-bottom: 14px;

    }


    .progress-label {

        font-size: 11px;

        color: #78909c;

        text-transform: uppercase;

        font-weight: 700;

    }


    .current-stop {

        margin-top: 4px;

        font-size: 16px;

        color: #17324d;

        font-weight: 700;

    }


    .time-remaining {

        color: #009bbd;

        font-weight: 700;

        margin-left: 4px;

    }


    .progress-bar-container {

        width: 100%;

        height: 8px;

        background: #edf1f3;

        border-radius: 10px;

        overflow: hidden;

        margin-top: 12px;

    }


    .progress-bar-value {

        height: 100%;

        width: 18%;

        background: #00b8d4;

        border-radius: 10px;

    }


    /* ========================================================
       PANEL DERECHO
       ======================================================== */

    .side-card {

        background: #ffffff;

        border-radius: 14px;

        padding: 14px;

        border: 1px solid #dcecf2;

        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.06);

        margin-bottom: 15px;

    }


    /* ========================================================
       BOTÓN DE RUTA
       ======================================================== */

    .route-action {

        width: 100%;

        border: 0;

        border-radius: 9px;

        padding: 14px;

        color: #ffffff;

        font-size: 14px;

        font-weight: 700;

        cursor: pointer;

        transition: .2s ease;

    }


    .route-action.start {

        background: #00a8c8;

        box-shadow: 0 5px 13px rgba(0, 168, 200, .25);

    }


    .route-action.start:hover {

        background: #008cab;

        transform: translateY(-1px);

    }


    .route-action.finish {

        background: #f44336;

        box-shadow: 0 5px 13px rgba(244, 67, 54, .22);

    }


    .route-action.finish:hover {

        background: #d93227;

        transform: translateY(-1px);

    }


    /* ========================================================
       ESTADO
       ======================================================== */

    .route-status {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        margin-top: 10px;

        padding: 4px 9px;

        border-radius: 20px;

        font-size: 11px;

        font-weight: 700;

        background: #e7f7eb;

        color: #2e7d32;

    }


    .route-status.active {

        background: #fff0ee;

        color: #d32f2f;

    }


    /* ========================================================
       TELEMETRÍA
       ======================================================== */

    .side-title {

        margin: 0 0 12px;

        color: #253b53;

        font-size: 15px;

        font-weight: 700;

    }


    .telemetry-grid {

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 8px;

    }


    .telemetry-item {

        background: #e9f9fc;

        border-radius: 8px;

        padding: 12px 8px;

        text-align: center;

    }


    .telemetry-label {

        display: block;

        color: #607d8b;

        font-size: 10px;

    }


    .telemetry-value {

        display: block;

        margin-top: 3px;

        color: #173b83;

        font-size: 14px;

        font-weight: 800;

    }


    /* ========================================================
       ALERTAS
       ======================================================== */

    .alert-box {

        border-radius: 8px;

        background: #f8fafb;

        padding: 11px;

        font-size: 12px;

        color: #455a64;

        line-height: 1.45;

    }


    .alert-box i {

        color: #f39c12;

        margin-right: 5px;

    }


    /* ========================================================
       RESPONSIVE
       ======================================================== */

    @media (max-width: 1000px) {

        .conductor-grid {

            grid-template-columns: 1fr;

        }

    }


    @media (max-width: 600px) {

        .conductor-page {

            padding: 15px;

        }


        .conductor-title {

            font-size: 23px;

        }


        .map-placeholder {

            height: 280px;

        }

    }

</style>


<div class="conductor-page">


    <!-- =====================================================
         ENCABEZADO
         ===================================================== -->

    <div class="conductor-header">

        <div>

            <h1 class="conductor-title">

                <i class="fas fa-id-card me-2"></i>

                Conductor

            </h1>

            <p class="conductor-subtitle">

                Gestión y seguimiento de la ruta del conductor.

            </p>

        </div>


        <!-- INFORMACIÓN DEL CONDUCTOR -->

        <div class="conductor-info">

            <div class="conductor-avatar">

                <i class="fas fa-user"></i>

            </div>


            <div>

                <strong>

                    <?= htmlspecialchars($conductor["nombre"]); ?>

                </strong>

                <span>

                    Licencia <?= htmlspecialchars($conductor["licencia"]); ?>

                    ·

                    <?= htmlspecialchars($conductor["estado"]); ?>

                    <?php if (!empty($conductor["usuario"])) { ?>

                        ·
                        <i class="fas fa-user-check me-1"></i>
                        Usuario: <?= htmlspecialchars($conductor["usuario"]); ?>

                    <?php } ?>

                </span>

            </div>

        </div>

    </div>



    <!-- =====================================================
         SELECCIONAR RUTA
         ===================================================== -->

    <div class="route-selector-card">

        <label
            for="rutaConductor"
            class="route-label"
        >

            Seleccionar trayecto:

        </label>


        <select
            id="rutaConductor"
            class="route-select"
        >

            <?php foreach ($rutas as $ruta) { ?>

                <option
                    value="<?= $ruta["id"]; ?>"
                    data-vehiculo="<?= htmlspecialchars($ruta["vehiculo"]); ?>"
                >

                    <?= htmlspecialchars($ruta["nombre"]); ?>

                </option>

            <?php } ?>

        </select>


        <div class="vehicle-info">

            <i class="fas fa-bus me-1"></i>

            Vehículo:

            <strong id="vehiculoRuta">

                <?= htmlspecialchars($rutaSeleccionada["vehiculo"]); ?>

            </strong>

        </div>

    </div>



    <!-- =====================================================
         CONTENIDO
         ===================================================== -->

    <div class="conductor-grid">


        <!-- =================================================
             MAPA Y PROGRESO
             ================================================= -->

        <div class="map-card">


            <div class="map-placeholder">

                <i class="fas fa-map-marked-alt"></i>

                <strong>
                    Mapa de Navegación en Tiempo Real
                </strong>

                <span>
                    La integración del mapa se puede conectar posteriormente.
                </span>

            </div>


            <div class="route-progress">


                <div class="route-progress-title">

                    <i class="fas fa-bell me-1"></i>

                    LLEGANDO A: Centro Comercial Sabana

                </div>


                <div class="progress-label">

                    Progreso de ruta

                </div>


                <div class="current-stop">

                    Parada Actual: Punto de Inicio

                    <span class="time-remaining">
                        12 min
                    </span>

                </div>


                <div class="progress-bar-container">

                    <div class="progress-bar-value"></div>

                </div>


            </div>

        </div>



        <!-- =================================================
             PANEL DERECHO
             ================================================= -->

        <div>


            <!-- =============================================
                 INICIAR / FINALIZAR
                 ============================================= -->

            <div class="side-card">


                <button
                    type="button"
                    id="btnRuta"
                    class="route-action start"
                >

                    <i
                        id="iconoRuta"
                        class="fas fa-play me-1"
                    ></i>

                    <span id="textoRuta">
                        INICIAR RUTA
                    </span>

                </button>


                <div
                    id="estadoRuta"
                    class="route-status"
                >

                    <i class="fas fa-circle"></i>

                    <span>
                        LISTA PARA INICIAR
                    </span>

                </div>

            </div>



            <!-- =============================================
                 TELEMETRÍA
                 ============================================= -->

            <div class="side-card">

                <h3 class="side-title">

                    Telemetría en Vivo

                </h3>


                <div class="telemetry-grid">


                    <div class="telemetry-item">

                        <span class="telemetry-label">
                            Velocidad
                        </span>

                        <span class="telemetry-value">
                            0 km/h
                        </span>

                    </div>


                    <div class="telemetry-item">

                        <span class="telemetry-label">
                            Estado
                        </span>

                        <span
                            class="telemetry-value"
                            id="estadoTiempo"
                        >
                            A tiempo
                        </span>

                    </div>


                </div>

            </div>



            <!-- =============================================
                 ALERTAS
                 ============================================= -->

            <div class="side-card">

                <h3 class="side-title">

                    Alertas de Tráfico

                </h3>


                <div class="alert-box">

                    <i class="fas fa-info-circle"></i>

                    No hay alertas de tráfico registradas.

                </div>

            </div>


        </div>

    </div>

</div>



<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =================================================
           ELEMENTOS
           ================================================= */

        const botonRuta =
            document.getElementById("btnRuta");


        const textoRuta =
            document.getElementById("textoRuta");


        const iconoRuta =
            document.getElementById("iconoRuta");


        const estadoRuta =
            document.getElementById("estadoRuta");


        const selectorRuta =
            document.getElementById("rutaConductor");


        const vehiculoRuta =
            document.getElementById("vehiculoRuta");


        let rutaActiva = false;



        /* =================================================
           CAMBIAR VEHÍCULO SEGÚN RUTA
           ================================================= */

        if (selectorRuta) {

            selectorRuta.addEventListener(
                "change",
                function () {

                    const opcion =
                        this.options[this.selectedIndex];


                    const vehiculo =
                        opcion.getAttribute(
                            "data-vehiculo"
                        );


                    vehiculoRuta.textContent =
                        vehiculo;

                }
            );

        }



        /* =================================================
           INICIAR / FINALIZAR RUTA
           ================================================= */

        if (botonRuta) {

            botonRuta.addEventListener(
                "click",
                function () {


                    const rutaId =
                        selectorRuta.value;


                    if (!rutaActiva) {


                        /* =========================
                           INICIAR
                           ========================= */

                        rutaActiva = true;


                        textoRuta.textContent =
                            "FINALIZAR RUTA";


                        iconoRuta.className =
                            "fas fa-stop me-1";


                        botonRuta.classList.remove(
                            "start"
                        );


                        botonRuta.classList.add(
                            "finish"
                        );


                        estadoRuta.classList.add(
                            "active"
                        );


                        estadoRuta.innerHTML =
                            '<i class="fas fa-circle"></i> EN RUTA';


                        console.log(
                            "Ruta iniciada:",
                            rutaId
                        );


                    } else {


                        /* =========================
                           FINALIZAR
                           ========================= */

                        rutaActiva = false;


                        textoRuta.textContent =
                            "INICIAR RUTA";


                        iconoRuta.className =
                            "fas fa-play me-1";


                        botonRuta.classList.remove(
                            "finish"
                        );


                        botonRuta.classList.add(
                            "start"
                        );


                        estadoRuta.classList.remove(
                            "active"
                        );


                        estadoRuta.innerHTML =
                            '<i class="fas fa-circle"></i> FINALIZADA';


                        console.log(
                            "Ruta finalizada:",
                            rutaId
                        );

                    }

                }
            );

        }


    }
);

</script>