<?php
/* =========================================================
   SIMU - Reglas de seguridad de la contraseña
   Devuelve '' si la clave es válida, o el mensaje de error.
   ========================================================= */

if (!function_exists('validarClaveSimu')) {

    function validarClaveSimu($pass) {

        if (strlen($pass) < 6) {
            return 'La contraseña debe tener al menos 6 caracteres.';
        }

        if (!preg_match('/[A-ZÁÉÍÓÚÜÑ]/u', $pass)) {
            return 'La contraseña debe incluir al menos una letra mayúscula.';
        }

        if (preg_match_all('/\d/', $pass) < 2) {
            return 'La contraseña debe incluir al menos 2 números.';
        }

        if (!preg_match('/[^\p{L}\p{N}]/u', $pass)) {
            return 'La contraseña debe incluir al menos un símbolo.';
        }

        return '';
    }
}