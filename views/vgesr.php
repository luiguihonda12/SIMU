<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4>
                Gestión de Roles
            </h4>

        </div>


        <div class="card-body">

            <form
                id="frmRol"
                class="row g-2 mb-4"
            >

                <input
                    type="hidden"
                    name="accion"
                    id="rolAccion"
                    value="crear"
                >

                <input
                    type="hidden"
                    name="id_rol"
                    id="rolId"
                >


                <div class="col-md-8">

                    <input
                        type="text"
                        name="nombre_del_rol"
                        id="rolNombre"
                        class="form-control"
                        placeholder="Nombre del rol"
                        required
                    >

                </div>


                <div class="col-md-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                        id="btnRol"
                    >
                        Crear rol
                    </button>


                    <button
                        type="button"
                        class="btn btn-secondary d-none"
                        id="btnCancelar"
                    >
                        Cancelar
                    </button>

                </div>

            </form>


            <div id="rolMsg"></div>


            <div class="table-responsive">

                <table
                    class="table table-bordered"
                    id="tablaRol"
                >

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody></tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<script>

async function cargarRoles() {

    const respuesta = await fetch(
        'controllers/cgesr.php'
    );

    const datos = await respuesta.json();


    if (!datos.ok) {

        document.querySelector('#rolMsg').innerHTML =
            `<div class="alert alert-danger">
                ${datos.msg}
            </div>`;

        return;
    }


    const tbody =
        document.querySelector(
            '#tablaRol tbody'
        );


    tbody.innerHTML = '';


    datos.data.forEach(function(item) {

        tbody.innerHTML += `
            <tr>

                <td>
                    ${item.id_rol}
                </td>

                <td>
                    ${item.nombre_del_rol}
                </td>

                <td>

                    <button
                        class="btn btn-sm btn-warning"
                        onclick="editarRol(
                            ${item.id_rol},
                            '${item.nombre_del_rol.replace(/'/g, "\\'")}'
                        )"
                    >
                        Editar
                    </button>


                    <button
                        class="btn btn-sm btn-danger"
                        onclick="eliminarRol(
                            ${item.id_rol}
                        )"
                    >
                        Eliminar
                    </button>

                </td>

            </tr>
        `;

    });

}


function editarRol(
    id,
    nombre
) {

    document.querySelector('#rolId').value =
        id;

    document.querySelector('#rolNombre').value =
        nombre;

    document.querySelector('#rolAccion').value =
        'editar';

    document.querySelector('#btnRol').textContent =
        'Guardar cambios';

    document.querySelector('#btnCancelar')
        .classList.remove('d-none');
}


document.querySelector('#btnCancelar')
.addEventListener('click', function() {

    document.querySelector('#frmRol').reset();

    document.querySelector('#rolId').value =
        '';

    document.querySelector('#rolAccion').value =
        'crear';

    document.querySelector('#btnRol').textContent =
        'Crear rol';

    this.classList.add('d-none');

});


async function eliminarRol(id) {

    if (
        !confirm(
            '¿Deseas eliminar este rol?'
        )
    ) {

        return;
    }


    const formulario =
        new FormData();

    formulario.append(
        'accion',
        'eliminar'
    );

    formulario.append(
        'id_rol',
        id
    );


    const respuesta = await fetch(
        'controllers/cgesr.php',
        {
            method: 'POST',
            body: formulario
        }
    );


    const datos =
        await respuesta.json();


    document.querySelector('#rolMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;


    if (datos.ok) {

        cargarRoles();

    }

}


document.querySelector('#frmRol')
.addEventListener('submit', async function(e) {

    e.preventDefault();


    const respuesta = await fetch(
        'controllers/cgesr.php',
        {
            method: 'POST',
            body: new FormData(this)
        }
    );


    const datos =
        await respuesta.json();


    document.querySelector('#rolMsg').innerHTML = `
        <div class="alert alert-${datos.ok ? 'success' : 'danger'}">
            ${datos.msg}
        </div>
    `;


    if (datos.ok) {

        document.querySelector('#btnCancelar')
            .click();

        cargarRoles();

    }

});


cargarRoles();

</script>