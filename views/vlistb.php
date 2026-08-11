<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>
            Listado de Busetas
        </h4>

        <a
            href="index.php?pg=regisb"
            class="btn btn-primary"
        >
            Registrar Buseta
        </a>

    </div>


    <div class="input-group mb-3">

        <input
            type="text"
            id="buscarB"
            class="form-control"
            placeholder="Buscar por placa, estado, ruta o empresa"
        >

        <button
            id="btnBuscarB"
            class="btn btn-secondary"
        >
            Buscar
        </button>

    </div>


    <div id="lbMsg"></div>


    <div class="table-responsive">

        <table
            class="table table-bordered table-hover"
            id="tablaB"
        >

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