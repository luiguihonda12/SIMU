<?php
require_once __DIR__ . '/../controllers/ccondu.php';
require_once __DIR__ . '/../controllers/cedicon.php';

$controladorConductor = new Ccondu();$controladorEditar = new Cedicon();

$datosConductor =$controladorConductor->index();
$rutas =$datosConductor["rutas"];
$listaConductores =$controladorEditar->listarConductores();
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<div class="container-fluid px-0">

    <!-- Selector de Conductor -->
    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-12 col-md-3">
                    <label for="selectorConductorPrincipal" class="form-label fw-bold text-dark mb-1 mb-md-0">
                        <i class="fas fa-user-check text-primary me-1"></i> Conductor a cargo:
                    </label>
                </div>
                <div class="col-12 col-md-9">
                    <select id="selectorConductorPrincipal" class="form-select">
                        <option value="">-- Seleccione o busque un conductor --</option>
                        <?php foreach ($listaConductores as$c) { ?>
                            <option value="<?= $c['id']; ?>">
                                <?= htmlspecialchars($c['nombre']); ?> (Licencia: <?= htmlspecialchars($c['licencia']); ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Selector de Trayecto y Destino -->
    <div class="bg-white p-4 rounded shadow-sm border mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <label for="rutaConductor" class="form-label fw-bold small text-secondary">Seleccionar trayecto:</label>
                <select id="rutaConductor" class="form-select">
                    <?php foreach ($rutas as$ruta) { ?>
                        <option value="<?= $ruta["id"]; ?>"><?= htmlspecialchars($ruta["nombre"]); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label for="paradaConductor" class="form-label fw-bold small text-secondary">Parada de destino:</label>
                <select id="paradaConductor" class="form-select">
                    <option value="destino">Seleccione destino...</option>
                </select>
            </div>
            <div class="col-12 col-md-4 text-md-end pt-md-3">
                <div class="alert alert-info py-2 mb-0 d-inline-block w-100 text-center">
                    <i class="fas fa-bus me-1"></i> Vehículo: <strong id="vehiculoRuta"><?= htmlspecialchars($rutas[0]["vehiculo"] ?? '-'); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa y Panel Operativo -->
    <div class="row g-4">
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div id="map" class="w-100 rounded-top" style="min-height: 400px;"></div>
                <div class="card-body bg-light">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-dark small" id="llegando"><i class="fas fa-location-arrow me-1 text-primary"></i> Seleccione una ruta</span>
                        <span class="badge bg-secondary" id="eta">ETA: --:--</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted small mb-1">
                        <span id="paradaActual">Punto de inicio</span>
                        <span id="progresoPorcentaje">0%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="progressBar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 mb-3 text-center p-3 bg-white">
                <button type="button" id="btnRuta" class="btn btn-success btn-lg w-100 mb-2 shadow-sm py-3 fw-bold">
                    <i class="fas fa-play me-1"></i> <span id="textoRuta">INICIAR RUTA</span>
                </button>
                <div id="estadoRuta" class="text-muted small fw-bold mt-2">
                    <i class="fas fa-circle text-secondary me-1"></i> <span>LISTA PARA INICIAR</span>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3 bg-white">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-dark mb-3"><i class="fas fa-satellite-dish me-1 text-primary"></i> Telemetría en Vivo</h6>
                    <div class="row text-center g-2">
                        <div class="col-6 border-end">
                            <span class="text-muted d-block small">Velocidad</span>
                            <strong class="text-dark fs-4" id="velocidad">0 km/h</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-muted d-block small">Estado</span>
                            <strong class="text-success fs-5" id="estadoTiempo">A tiempo</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body">
                    <h6 class="card-title fw-bold text-dark mb-2"><i class="fas fa-triangle-exclamation me-1 text-warning"></i> Alertas de Tráfico</h6>
                    <p class="text-muted small mb-0">No hay alertas de tráfico registradas en este momento.</p>
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
    const selectorConductor = document.getElementById("selectorConductorPrincipal");
    const btn = document.getElementById("btnRuta");
    const map = L.map("map").setView([4.8617, -74.0539], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { attribution: "&copy; OpenStreetMap" }).addTo(map);

    let bus = null, linea = null, timer = null, activo = false;

    const busIcon = L.divIcon({
        html: '<i class="fas fa-bus text-primary fs-4"></i>',
        className: "",
        iconSize: [30, 30]
    });

    const stopIcon = L.divIcon({
        html: '<i class="fas fa-location-dot text-danger fs-5"></i>',
        className: "",
        iconSize: [25, 25]
    });

    async function lugar(texto) {
        try {
            const r = await fetch("https://nominatim.openstreetmap.org/search?format=json&limit=1&q=" + encodeURIComponent(texto + ", Chía, Cundinamarca, Colombia"));
            const d = await r.json();
            return d.length ? [+d[0].lat, +d[0].lon] : null;
        } catch (e) {
            return null;
        }
    }

    async function carretera(origen, destino) {
        try {
            const url = `https://router.project-osrm.org/route/v1/driving/${origen[1]},${origen[0]};${destino[1]},${destino[0]}?overview=full&geometries=geojson`;
            const r = await fetch(url);
            const d = await r.json();
            if (!d.routes?.length) return null;
            return d.routes[0].geometry.coordinates.map(p => [p[1], p[0]]);
        } catch (e) {
            return null;
        }
    }

    function limpiar() {
        if (timer) clearInterval(timer);
        if (linea) map.removeLayer(linea);
        if (bus) map.removeLayer(bus);
        timer = null; linea = null; bus = null; activo = false;
        document.getElementById("progressBar").style.width = "0%";
        document.getElementById("progresoPorcentaje").textContent = "0%";
        document.getElementById("eta").textContent = "ETA: --:--";
        document.getElementById("velocidad").textContent = "0 km/h";
        btn.className = "btn btn-success btn-lg w-100 mb-2 shadow-sm py-3 fw-bold";
        btn.innerHTML = '<i class="fas fa-play me-1"></i> <span id="textoRuta">INICIAR RUTA</span>';
    }

    async function cargar() {
        limpiar();
        const ruta = rutas.find(r => String(r.id) === String(rutaSel.value));
        if (!ruta) return;
        document.getElementById("vehiculoRuta").textContent = ruta.vehiculo || "Sin asignar";
        document.getElementById("llegando").innerHTML = `<i class="fas fa-location-arrow me-1 text-primary"></i> ${ruta.origen} → ${ruta.destino}`;
        
        paradaSel.innerHTML = '<option value="destino">Destino: ' + ruta.destino + "</option>";
        if (ruta.paradas?.length) {
            ruta.paradas.forEach((p, i) => {
                const o = document.createElement("option");
                o.value = i;
                o.textContent = "Paradero: " + p.nombre;
                paradaSel.appendChild(o);
            });
        }

        const inicio = await lugar(ruta.origen);
        const destino = await lugar(ruta.destino);

        if (!inicio || !destino) return;

        ruta.inicioCoords = inicio;
        ruta.destinoCoords = destino;

        bus = L.marker(inicio, { icon: busIcon }).addTo(map);
        map.fitBounds(L.latLngBounds([inicio, destino]), { padding: [40, 40] });

        if (ruta.paradas?.length) {
            for (const p of ruta.paradas) {
                const c = await lugar(p.ubicacion);
                if (c) {
                    p.coords = c;
                    L.marker(c, { icon: stopIcon }).addTo(map).bindTooltip(p.nombre);
                }
            }
        }
    }

    async function iniciar() {
        if (!selectorConductor.value) {
            alert("¡Atención! Debe seleccionar un conductor antes de iniciar el recorrido.");
            selectorConductor.focus();
            return;
        }

        const ruta = rutas.find(r => String(r.id) === String(rutaSel.value));
        if (!ruta || !ruta.inicioCoords || !ruta.destinoCoords) return;

        let destino = ruta.destinoCoords;
        let nombre = ruta.destino;

        if (paradaSel.value !== "destino" && paradaSel.value !== "") {
            const p = ruta.paradas[paradaSel.value];
            if (p?.coords) {
                destino = p.coords;
                nombre = p.nombre;
            }
        }

        const origen = bus ? bus.getLatLng() : { lat: ruta.inicioCoords[0], lng: ruta.inicioCoords[1] };
        const puntos = await carretera([origen.lat, origen.lng], destino);

        if (!puntos) return alert("No se pudo calcular la ruta por carretera.");

        if (linea) map.removeLayer(linea);

        linea = L.polyline(puntos, { color: "#0d6efd", weight: 5, opacity: 0.8 }).addTo(map);

        activo = true;
        rutaSel.disabled = true;
        paradaSel.disabled = true;
        selectorConductor.disabled = true;

        btn.className = "btn btn-danger btn-lg w-100 mb-2 shadow-sm py-3 fw-bold";
        btn.innerHTML = '<i class="fas fa-stop me-1"></i> <span>FINALIZAR RUTA</span>';

        document.getElementById("estadoRuta").innerHTML = '<i class="fas fa-circle text-success me-1"></i><span>EN RUTA</span>';
        document.getElementById("llegando").innerHTML = `<i class="fas fa-location-arrow me-1 text-primary"></i> LLEGANDO A: ${nombre}`;

        let i = 0;
        const total = puntos.length;

        timer = setInterval(() => {
            if (i >= total) {
                clearInterval(timer);
                document.getElementById("progressBar").style.width = "100%";
                document.getElementById("progresoPorcentaje").textContent = "100%";
                document.getElementById("eta").textContent = "ETA: 0:00";
                document.getElementById("velocidad").textContent = "0 km/h";
                document.getElementById("estadoRuta").innerHTML = '<i class="fas fa-circle text-secondary me-1"></i><span>FINALIZADA</span>';
                return;
            }

            bus.setLatLng(puntos[i]);
            map.panTo(puntos[i]);

            const progreso = Math.round((i / (total - 1)) * 100);
            document.getElementById("progressBar").style.width = progreso + "%";
            document.getElementById("progresoPorcentaje").textContent = progreso + "%";

            const segundos = Math.round(60 * (1 - progreso / 100));
            document.getElementById("eta").textContent = `ETA: ${Math.floor(segundos / 60)}:${String(segundos % 60).padStart(2, "0")}`;
            document.getElementById("velocidad").textContent = "25 km/h";
            document.getElementById("paradaActual").textContent = "En recorrido...";

            i++;
        }, 1000);
    }

    function finalizar() {
        if (timer) clearInterval(timer);
        timer = null;
        activo = false;
        rutaSel.disabled = false;
        paradaSel.disabled = false;
        selectorConductor.disabled = false;
        btn.className = "btn btn-success btn-lg w-100 mb-2 shadow-sm py-3 fw-bold";
        btn.innerHTML = '<i class="fas fa-play me-1"></i> <span id="textoRuta">INICIAR RUTA</span>';
        document.getElementById("velocidad").textContent = "0 km/h";
        document.getElementById("estadoRuta").innerHTML = '<i class="fas fa-circle text-secondary me-1"></i><span>FINALIZADA</span>';
        cargar();
    }

    btn.addEventListener("click", () => activo ? finalizar() : iniciar());
    rutaSel.addEventListener("change", cargar);
    if(rutas.length > 0) cargar();
});
</script>