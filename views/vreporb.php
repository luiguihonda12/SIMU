<div class="dashboard-container">

    <header class="dash-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="dash-title"><i class="fas fa-chart-bar"></i> Reporte de Busetas</h1>
            <p class="dash-subtitle">Filtra, visualiza e imprime el estado general de la flota</p>
        </div>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Imprimir Reporte
        </button>
    </header>

    <div class="dash-table-card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5 col-lg-4">
                    <label for="fEstado" class="form-label">Filtrar por estado</label>
                    <select id="fEstado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="activa">Activas</option>
                        <option value="inactiva">Inactivas</option>
                        <option value="mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                <div class="col-md-3 col-lg-2">
                    <button id="btnRep" class="btn btn-primary w-100">
                        <i class="fas fa-bolt"></i> Generar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="dash-table-card">
        <div class="dash-table-header">
            <h3><i class="fas fa-table"></i> Resultados del Reporte</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle" id="tablaRep">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Ruta</th>
                        <th>Empresa</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>


<script>

async function generarReporte() {

    const estado =
        encodeURIComponent(
            document.querySelector('#fEstado').value
        );


    const respuesta = await fetch(
        'controllers/creporb.php?estado=' + estado
    );


    const datos = await respuesta.json();


    const tbody =
        document.querySelector(
            '#tablaRep tbody'
        );


    if (!datos.ok) {

        tbody.innerHTML = `
            <tr>
                <td colspan="6">
                    ${datos.msg}
                </td>
            </tr>
        `;

        return;
    }


    tbody.innerHTML = '';


    datos.data.forEach(function(item) {

        tbody.innerHTML += `
            <tr>

                <td>${item.id_buseta}</td>

                <td>${item.placa}</td>

                <td>${item.capacidad}</td>

                <td>${item.estado}</td>

                <td>${item.ruta}</td>

                <td>${item.empresa}</td>

            </tr>
        `;

    });

}


document.querySelector('#btnRep')
.addEventListener(
    'click',
    generarReporte
);


generarReporte();

</script>