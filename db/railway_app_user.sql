-- Ejecutar en Railway con el usuario administrativo de la base.
-- Sustituye la contraseña antes de ejecutar y no subas ese valor al repositorio.
CREATE USER IF NOT EXISTS 'simu_app'@'%' IDENTIFIED BY 'CAMBIA_ESTA_PASSWORD';
GRANT SELECT, INSERT, UPDATE, DELETE ON movilidad_mer.* TO 'simu_app'@'%';
CREATE USER IF NOT EXISTS 'simu_dev_friend'@'%' IDENTIFIED BY 'CAMBIA_PASSWORD_DE_TU_AMIGO';
GRANT SELECT, INSERT, UPDATE, DELETE ON movilidad_mer.* TO 'simu_dev_friend'@'%';
FLUSH PRIVILEGES;
