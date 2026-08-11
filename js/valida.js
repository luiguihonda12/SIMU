
document.addEventListener('DOMContentLoaded', function() {

    const toggleIcon = document.getElementById('toggleIcon');
    const passInput = document.getElementById('pass');
    
    if (toggleIcon && passInput) {
        toggleIcon.addEventListener('click', function() {
            const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        passInput.addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('strengthBar');
            const text = document.getElementById('strengthText');
            
            if (!bar || !text) return;

            let score = 0;
            if (val.length >= 6) score += 25;
            if (val.match(/[A-Z]/)) score += 25;
            if (val.match(/[0-9]/)) score += 25;
            if (val.match(/[^a-zA-Z0-9]/)) score += 25;

            bar.style.width = score + '%';

            if (score <= 25) {
                bar.style.backgroundColor = '#ef4444';
                text.textContent = 'Seguridad: Baja';
            } else if (score <= 50) {
                bar.style.backgroundColor = '#f59e0b';
                text.textContent = 'Seguridad: Media';
            } else if (score <= 75) {
                bar.style.backgroundColor = '#3b82f6';
                text.textContent = 'Seguridad: Buena';
            } else {
                bar.style.backgroundColor = '#22c55e';
                text.textContent = 'Seguridad: Fuerte';
            }
        });
    }

    /* ======================================================
       CÓDIGO DE VERIFICACIÓN: autofoco entre cajas de 6 dígitos
       ====================================================== */
    const codeInputs = document.querySelectorAll('.code-input');

    codeInputs.forEach(function(input, index) {
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 1 && index < codeInputs.length - 1) {
                codeInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', function(event) {
            if (event.key === 'Backspace' && this.value === '' && index > 0) {
                codeInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', function(event) {
            event.preventDefault();
            const texto = (event.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, codeInputs.length);
            texto.split('').forEach(function(ch, i) {
                codeInputs[i].value = ch;
            });
            if (texto.length > 0) {
                codeInputs[Math.min(texto.length, codeInputs.length) - 1].focus();
            }
        });
    });

});

/* ======================================================
   Utilidades de mensajes
   ====================================================== */
function mostrarMensaje(elmId, msg, tipo) {
    const box = document.getElementById(elmId);
    if (!box) return;
    box.className = 'alert alert-' + (tipo || 'danger') + ' text-center py-2 small';
    box.textContent = msg;
    box.style.display = 'block';
}

function ocultarMensaje(elmId) {
    const box = document.getElementById(elmId);
    if (!box) return;
    box.style.display = 'none';
}

/* ======================================================
   REGISTRO GUIADO
   ====================================================== */

/*
 * Avanza el flujo guiado de registro.
 * En el Paso 1 redirige al formulario completo de creación de usuario.
 */
function siguientePaso() {
    window.location.href = 'index.php?pg=creaUsu';
}

/**
 * Cambia el paso del formulario paso a paso en el módulo de crear usuario
 * @param {number} step
 */
function nextStep(step) {
    const steps = document.querySelectorAll('.reg-step');
    steps.forEach(s => s.classList.remove('active'));

    const targetStep = document.getElementById('step' + step);
    if (targetStep) {
        targetStep.classList.add('active');
    }

    const regTitle = document.getElementById('regTitle');
    if (regTitle) {
        if (step === 1) regTitle.textContent = 'Crear cuenta';
        else if (step === 2) regTitle.textContent = 'Verificación de perfil';
        else if (step === 3) regTitle.textContent = 'Confirmación';
    }
}

/**
 * Envía los datos del formulario al controlador cUsuario para
 * crear el usuario en la base de datos (arquitectura MVC).
 */
async function registrarUsuario() {
    const nombre    = document.getElementById('nombre').value.trim();
    const apellidos = document.getElementById('apellidos').value.trim();
    const email     = document.getElementById('email').value.trim();
    const telefono  = document.getElementById('telefono').value.trim();
    const pass      = document.getElementById('pass').value;
    const rol       = document.getElementById('rol').value;
    const btn       = document.getElementById('btnRegistrar');

    if (!nombre || !apellidos || !email || !pass) {
        mostrarError('Todos los campos obligatorios deben estar diligenciados.');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarError();

    try {
        const resp = await fetch('controllers/cUsuario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ nombre, apellidos, email, telefono, pass, rol }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            const correoHidden = document.getElementById('regCorreo');
            if (correoHidden) correoHidden.value = json.correo || email;

            const hint = document.getElementById('regCodeHint');
            if (hint) {
                if (json.codigo_debug) {
                    hint.textContent = 'Modo de prueba: tu código es ' + json.codigo_debug + ' (configura PHPMailer para el envío real).';
                    hint.style.display = 'block';
                } else {
                    hint.style.display = 'none';
                }
            }

            nextStep(2);
            const codeInputs = document.querySelectorAll('#step2 .code-input');
            if (codeInputs.length > 0) codeInputs[0].focus();
        } else {
            mostrarError(json.msg || 'No se pudo crear el usuario.');
        }
    } catch (e) {
        mostrarError('Error de conexión con el servidor.');
    } finally {
        if (btn) btn.disabled = false;
    }
}

/**
 * Recolecta el código de 6 dígitos de las cajas dentro de un contenedor.
 */
function colectarCodigo(contenedor) {
    let codigo = '';
    contenedor.querySelectorAll('.code-input').forEach(function(i) {
        codigo += i.value.trim();
    });
    return codigo;
}

/**
 * Verifica el código de activación de la cuenta recién creada.
 */
async function verificarCodigo() {
    const correo = document.getElementById('regCorreo').value;
    const codigo = colectarCodigo(document.getElementById('step2'));
    const btn    = document.getElementById('btnVerificar');

    if (codigo.length !== 6) {
        const err = document.getElementById('regCodeError');
        if (err) { err.style.display = 'flex'; document.getElementById('regCodeErrorText').textContent = 'Ingresa los 6 dígitos del código.'; }
        return;
    }

    if (btn) btn.disabled = true;

    const errBox = document.getElementById('regCodeError');
    if (errBox) errBox.style.display = 'none';

    try {
        const resp = await fetch('controllers/ccoder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo, codigo }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            nextStep(3);
        } else {
            if (errBox) {
                errBox.style.display = 'flex';
                document.getElementById('regCodeErrorText').textContent = json.msg || 'El código no es válido.';
            }
        }
    } catch (e) {
        if (errBox) {
            errBox.style.display = 'flex';
            document.getElementById('regCodeErrorText').textContent = 'Error de conexión con el servidor.';
        }
    } finally {
        if (btn) btn.disabled = false;
    }
}

/* ======================================================
   OLVIDÓ SU CONTRASEÑA
   ====================================================== */

/**
 * Solicita el código de recuperación de contraseña.
 */
async function enviarInstrucciones(event) {
    event.preventDefault();

    const correo = document.getElementById('olvCorreo').value.trim();
    const btn    = document.getElementById('btnOlvido');

    if (!correo) {
        mostrarMensaje('olvMsg', 'Ingresa tu correo electrónico registrado.', 'danger');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarMensaje('olvMsg');

    try {
        const resp = await fetch('controllers/colvid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            window.location.href = 'index.php?pg=vcoder&correo=' + encodeURIComponent(json.correo || correo);
        } else {
            mostrarMensaje('olvMsg', json.msg || 'No fue posible procesar la solicitud.', 'danger');
        }
    } catch (e) {
        mostrarMensaje('olvMsg', 'Error de conexión con el servidor.', 'danger');
    } finally {
        if (btn) btn.disabled = false;
    }
}

/**
 * Verifica el código de recuperación y continúa al cambio de contraseña.
 */
async function verificarCodigoRecuperacion(event) {
    event.preventDefault();

    const correo = document.getElementById('codCorreo').value.trim();
    const codigo = colectarCodigo(document.getElementById('formCodigo'));
    const btn    = document.getElementById('btnCodigo');

    if (!correo || codigo.length !== 6) {
        mostrarMensaje('codMsg', 'Ingresa tu correo y los 6 dígitos del código.', 'danger');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarMensaje('codMsg');

    try {
        const resp = await fetch('controllers/ccoder.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ correo, codigo }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            if (json.contexto === 'recuperacion' && json.token) {
                window.location.href = 'index.php?pg=vreset&token=' + encodeURIComponent(json.token);
            } else {
                mostrarMensaje('codMsg', json.msg || 'Cuenta verificada correctamente.', 'success');
            }
        } else {
            mostrarMensaje('codMsg', json.msg || 'El código no es válido.', 'danger');
        }
    } catch (e) {
        mostrarMensaje('codMsg', 'Error de conexión con el servidor.', 'danger');
    } finally {
        if (btn) btn.disabled = false;
    }
}

/* ======================================================
   CONFIRMACIÓN FINAL (NUEVA CONTRASEÑA)
   ====================================================== */

/**
 * Guarda la nueva contraseña y redirige al login.
 */
async function guardarNuevaPassword(event) {
    event.preventDefault();

    const token    = document.getElementById('resToken').value.trim();
    const password = document.getElementById('resPassword').value;
    const confirm  = document.getElementById('resConfirm').value;
    const btn      = document.getElementById('btnReset');

    if (!token) {
        mostrarMensaje('resMsg', 'Enlace de recuperación inválido.', 'danger');
        return;
    }

    if (password.length < 6) {
        mostrarMensaje('resMsg', 'La contraseña debe tener al menos 6 caracteres.', 'danger');
        return;
    }

    if (password !== confirm) {
        mostrarMensaje('resMsg', 'Las contraseñas no coinciden.', 'danger');
        return;
    }

    if (btn) btn.disabled = true;
    ocultarMensaje('resMsg');

    try {
        const resp = await fetch('controllers/creset.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ token, password, confirm_password: confirm }).toString()
        });
        const json = await resp.json();

        if (json.ok) {
            window.location.href = 'index.php?pg=login&msg=password_reset';
        } else {
            mostrarMensaje('resMsg', json.msg || 'No fue posible cambiar la contraseña.', 'danger');
        }
    } catch (e) {
        mostrarMensaje('resMsg', 'Error de conexión con el servidor.', 'danger');
    } finally {
        if (btn) btn.disabled = false;
    }
}

function mostrarError(msg) {
    const errBox = document.getElementById('regError');
    const errText = document.getElementById('regErrorText');
    if (errBox) errBox.style.display = 'flex';
    if (errText) errText.textContent = msg;
}

function ocultarError() {
    const errBox = document.getElementById('regError');
    if (errBox) errBox.style.display = 'none';
}
