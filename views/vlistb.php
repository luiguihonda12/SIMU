<div class="dashboard-container">

    <header class="dash-header d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="dash-title"><i class="fas fa-bus"></i> Listado de Busetas</h1>
            <p class="dash-subtitle">Administra la flota de vehículos, su estado operativo, ruta y empresa asignada</p>
        </div>
        <a href="index.php?pg=regisb" class="btn btn-primary">
            <i class="fas fa-plus"></i> Registrar Buseta
        </a>
    </header>

    <div class="dash-table-card mb-4">
        <div class="card-body">
            <div class="input-group">
                <input
                    type="text"
                    id="buscarB"
                    class="form-control"
                    placeholder="Buscar por placa, estado, ruta o empresa..."
                >
                <button
                    id="btnBuscarB"
                    class="btn btn-primary"
                >
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </div>
    </div>

    <div id="lbMsg" class="mb-3"></div>

    <div class="dash-table-card">
        <div class="dash-table-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-table"></i> Flota Registrada</h3>
        </div>
        <div class="table-responsive">
            <table class="table align-middle" id="tablaB">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Ruta</th>
                        <th>Empresa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

</div>


<script>

async function cargarBusetas() {

    const buscar =
        encodeURIComponent(
            document.querySelector('#buscarB').value
        );

    const respuesta = await fetch(
        'controllers/clistb.php?buscar=' + buscar
    );

    const datos = await respuesta.json();

    const tbody =
        document.querySelector('#tablaB tbody');

    if (!datos.ok) {

        tbody.innerHTML = '';

        document.querySelector('#lbMsg').innerHTML = `
            <div class="alert alert-danger">
                ${datos.msg}
            </div>
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

                <td>

                    <a
                        href="index.php?pg=edib&id=${item.id_buseta}"
                        class="btn btn-sm btn-warning"
                    >
                        Editar
                    </a>

                    <a
                        href="index.php?pg=cameb&id=${item.id_buseta}"
                        class="btn btn-sm btn-secondary"
                    >
                        Estado
                    </a>

                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        onclick="eliminarBuseta(${item.id_buseta})"
                    >
                        Eliminar
                    </button>

                </td>

            </tr>
        `;

    });

}


async function eliminarBuseta(id) {

    if (
        !confirm(
            '¿Deseas eliminar esta buseta?'
        )
    ) {

        return;
    }

    const formulario =
        new FormData();

    formulario.append(
        'id_buseta',
        id
    );

    const respuesta = await fetch(
        'controllers/cdeleb.php',
        {
            method: 'POST',
            body: formulario
        }
    );

    const datos =
        await respuesta.json();

    document.querySelector('#lbMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;

    if (datos.ok) {

        cargarBusetas();

    }

}


document.querySelector('#btnBuscarB')
.addEventListener('click', cargarBusetas);


document.querySelector('#buscarB')
.addEventListener('keyup', function(e) {

    if (e.key === 'Enter') {

        cargarBusetas();

    }

});


cargarBusetas();

</script>