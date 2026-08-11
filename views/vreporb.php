<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>
            Reporte de Busetas
        </h4>

        <button
            onclick="window.print()"
            class="btn btn-secondary"
        >
            Imprimir
        </button>

    </div>


    <div class="row mb-3">

        <div class="col-md-4">

            <select
                id="fEstado"
                class="form-select"
            >

                <option value="">
                    Todos los estados
                </option>

                <option value="activa">
                    Activas
                </option>

                <option value="inactiva">
                    Inactivas
                </option>

                <option value="mantenimiento">
                    Mantenimiento
                </option>

            </select>

        </div>


        <div class="col-md-2">

            <button
                id="btnRep"
                class="btn btn-primary"
            >
                Generar
            </button>

        </div>

    </div>


    <div class="table-responsive">

        <table
            class="table table-bordered"
            id="tablaRep"
        >

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