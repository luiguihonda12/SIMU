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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

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

                >

                    <?= htmlspecialchars($ruta["nombre"]); ?>

                </option>

            <?php } ?>

        </select>


        <select

            id="paradaConductor"

            class="route-select stop-select"

        >

            <option value="">

                Seleccione destino...

            </option>

        </select>


        <div class="vehicle-info">

            <i class="fas fa-bus me-1"></i>

            Vehículo:

            <strong id="vehiculoRuta">

                <?= htmlspecialchars($rutas[0]["vehiculo"] ?? '-'); ?>

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


            <div id="map"></div>


            <div class="route-progress">


                <div class="route-progress-title">

                    <i class="fas fa-location-arrow me-1"></i>

                    <span id="llegando">Seleccione una ruta</span>

                </div>


                <div class="progress-label">

                    Progreso de ruta

                </div>


                <div class="current-stop">

                    <span id="paradaActual">Punto de inicio</span>

                    <span class="time-remaining" id="eta">ETA: --:--</span>

                </div>


                <div class="progress-bar-container">

                    <div class="progress-bar-value" id="progressBar"></div>

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

                    <i class="fas fa-play me-1"></i>

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

                        <span class="telemetry-value" id="velocidad">

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


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

document.addEventListener("DOMContentLoaded", () => {

    const rutas = <?= json_encode($rutas, JSON_UNESCAPED_UNICODE); ?>;
    const rutaSel = document.getElementById("rutaConductor");
    const paradaSel = document.getElementById("paradaConductor");
    const btn = document.getElementById("btnRuta");
    const map = L.map("map").setView([4.8617, -74.0539], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap"
    }).addTo(map);

    let bus = null, linea = null, timer = null, activo = false;

    const busIcon = L.divIcon({
        html: '<i class="fas fa-bus"></i>',
        className: "bus-icon",
        iconSize: [38, 38],
        iconAnchor: [19, 19]
    });

    const stopIcon = L.divIcon({
        html: '<i class="fas fa-location-dot"></i>',
        className: "stop-icon",
        iconSize: [30, 30],
        iconAnchor: [15, 15]
    });

    async function lugar(texto) {
        try {
            const r = await fetch(
                "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=" +
                encodeURIComponent(texto + ", Chía, Cundinamarca, Colombia")
            );
            const d = await r.json();
            return d.length ? [+d[0].lat, +d[0].lon] : null;
        } catch (e) {
            return null;
        }
    }

    async function carretera(origen, destino) {
        const url = "https://router.project-osrm.org/route/v1/driving/" +
            origen[1] + "," + origen[0] + ";" + destino[1] + "," + destino[0] +
            "?overview=full&geometries=geojson";

        const r = await fetch(url);
        const d = await r.json();

        if (!d.routes?.length) return null;
        return d.routes[0].geometry.coordinates.map(p => [p[1], p[0]]);
    }

    function limpiar() {
        if (timer) clearInterval(timer);
        if (linea) map.removeLayer(linea);
        if (bus) map.removeLayer(bus);
        timer = null;
        linea = null;
        bus = null;
        activo = false;
        document.getElementById("progressBar").style.width = "0%";
        document.getElementById("eta").textContent = "ETA: --:--";
        document.getElementById("velocidad").textContent = "0 km/h";
        btn.className = "route-action start";
        btn.innerHTML = '<i class="fas fa-play me-1"></i> INICIAR RUTA';
    }

    async function cargar() {

        limpiar();

        const ruta = rutas.find(r => String(r.id) === String(rutaSel.value));
        if (!ruta) return;

        document.getElementById("vehiculoRuta").textContent = ruta.vehiculo || "Sin asignar";
        document.getElementById("llegando").textContent = ruta.origen + " → " + ruta.destino;

        paradaSel.innerHTML = '<option value="destino">Destino: ' + ruta.destino + "</option>";

        if (ruta.paradas?.length)
            ruta.paradas.forEach((p, i) => {
                const o = document.createElement("option");
                o.value = i;
                o.textContent = "Paradero: " + p.nombre;
                paradaSel.appendChild(o);
            });

        const inicio = await lugar(ruta.origen);
        const destino = await lugar(ruta.destino);

        if (!inicio || !destino) return;

        ruta.inicioCoords = inicio;
        ruta.destinoCoords = destino;

        bus = L.marker(inicio, { icon: busIcon }).addTo(map);
        map.fitBounds(L.latLngBounds([inicio, destino]), { padding: [40, 40] });

        if (ruta.paradas?.length)
            for (const p of ruta.paradas) {
                const c = await lugar(p.ubicacion);
                if (c) {
                    p.coords = c;
                    L.marker(c, { icon: stopIcon }).addTo(map).bindTooltip(p.nombre);
                }
            }
    }

    async function iniciar() {

        const ruta = rutas.find(r => String(r.id) === String(rutaSel.value));
        if (!ruta) return;

        let destino = ruta.destinoCoords;
        let nombre = ruta.destino;

        if (paradaSel.value !== "destino") {
            const p = ruta.paradas[paradaSel.value];
            if (p?.coords) {
                destino = p.coords;
                nombre = p.nombre;
            }
        }

        if (!destino) return alert("No se pudo localizar el destino.");

        const origen = bus.getLatLng();
        const puntos = await carretera(
            [origen.lat, origen.lng],
            destino
        );

        if (!puntos) return alert("No se pudo calcular la ruta por carretera.");

        if (linea) map.removeLayer(linea);

        linea = L.polyline(puntos, {
            color: "#00a4c4",
            weight: 5,
            opacity: .8
        }).addTo(map);

        activo = true;
        rutaSel.disabled = true;
        paradaSel.disabled = true;
        btn.className = "route-action finish";
        btn.innerHTML = '<i class="fas fa-stop me-1"></i> FINALIZAR RUTA';

        document.getElementById("estadoRuta").innerHTML =
            '<i class="fas fa-circle"></i><span>EN RUTA</span>';
        document.getElementById("llegando").textContent = "LLEGANDO A: " + nombre;

        let i = 0;
        const total = puntos.length;

        timer = setInterval(() => {

            if (i >= total) {
                clearInterval(timer);
                document.getElementById("progressBar").style.width = "100%";
                document.getElementById("eta").textContent = "ETA: 0:00";
                document.getElementById("velocidad").textContent = "0 km/h";
                return;
            }

            bus.setLatLng(puntos[i]);

            const progreso = Math.round(i / (total - 1) * 100);
            document.getElementById("progressBar").style.width = progreso + "%";

            const segundos = Math.round(60 * (1 - progreso / 100));
            document.getElementById("eta").textContent =
                "ETA: " + Math.floor(segundos / 60) + ":" +
                String(segundos % 60).padStart(2, "0");

            document.getElementById("velocidad").textContent = "25 km/h";
            document.getElementById("paradaActual").textContent = "En recorrido";

            i++;

        }, 1000);
    }

    function finalizar() {
        if (timer) clearInterval(timer);
        timer = null;
        activo = false;
        rutaSel.disabled = false;
        paradaSel.disabled = false;
        btn.className = "route-action start";
        btn.innerHTML = '<i class="fas fa-play me-1"></i> INICIAR RUTA';
        document.getElementById("velocidad").textContent = "0 km/h";
        document.getElementById("estadoRuta").innerHTML =
            '<i class="fas fa-circle"></i><span>FINALIZADA</span>';
    }

    btn.addEventListener("click", () => activo ? finalizar() : iniciar());
    rutaSel.addEventListener("change", cargar);

    cargar();

});
</script>
