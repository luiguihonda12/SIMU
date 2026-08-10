-- Ejecutar una sola vez sobre movilidad_mer.
-- Los permisos se aplican en la aplicación mediante el id_rol.
USE movilidad_mer;

UPDATE rol SET nombre_del_rol = CASE id_rol
    WHEN 1 THEN 'Administrador'
    WHEN 2 THEN 'Operador'
    WHEN 3 THEN 'Solo lectura'
    ELSE nombre_del_rol
END
WHERE id_rol IN (1, 2, 3);
