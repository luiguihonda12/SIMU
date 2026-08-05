CREATE DATABASE IF NOT EXISTS movilidad_mer;
USE movilidad_mer;

CREATE TABLE `buseta` (
  `id_buseta` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `capacidad` int(11) DEFAULT 0,
  `estado` enum('activa','inactiva','mantenimiento') DEFAULT 'activa',
  `id_ruta` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `buseta` (`id_buseta`, `placa`, `capacidad`, `estado`, `id_ruta`, `id_empresa`) VALUES
(1, 'ABC123', 20, 'activa', 1, 1),
(2, 'XYZ789', 18, 'activa', 2, 1);


CREATE TABLE `conductor` (
  `id_conductor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `licencia` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `id_buseta` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `conductor` (`id_conductor`, `nombre`, `licencia`, `telefono`, `id_buseta`, `id_empresa`) VALUES
(1, 'Pedro Gomez', 'LIC12345', '3111111111', 1, 1),
(2, 'Maria Lopez', 'LIC67890', '3222222222', 2, 1);



CREATE TABLE `conductor_ruta` (
  `id_conductor` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



INSERT INTO `conductor_ruta` (`id_conductor`, `id_ruta`) VALUES
(1, 1),
(2, 2);


CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `nit` varchar(30) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `empresa` (`id_empresa`, `nombre`, `nit`, `direccion`, `telefono`) VALUES
(1, 'TransMovil Chia', '900123456', 'Calle 10 # 5-20', '3100000000');



CREATE TABLE `empresa_ruta` (
  `id_empresa` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `empresa_ruta` (`id_empresa`, `id_ruta`) VALUES
(1, 1),
(1, 2);


CREATE TABLE `pago` (
  `id_pago` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ruta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `pago` (`id_pago`, `fecha`, `monto`, `metodo_pago`, `id_usuario`, `id_ruta`) VALUES
(1, '2026-04-14', 3500.00, 'Nequi', 3, 1),
(2, '2026-04-14', 3500.00, 'Daviplata', 3, 2);

CREATE TABLE `paradero` (
  `id_paradero` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `id_ruta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paradero` (`id_paradero`, `nombre`, `ubicacion`, `id_ruta`) VALUES
(1, 'Paradero Principal', 'Parque Central', 1),
(2, 'Paradero Norte', 'Av. Pradilla', 2);


CREATE TABLE `pqrs` (
  `id_pqrs` int(11) NOT NULL,
  `tipo_pqrs` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pqrs` (`id_pqrs`, `tipo_pqrs`, `descripcion`, `fecha`, `id_usuario`) VALUES
(1, 'Queja', 'Retraso en la ruta centro', '2026-04-14', 3),
(2, 'Sugerencia', 'Agregar mas horarios en la mañana', '2026-04-14', 3);

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_del_rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rol` (`id_rol`, `nombre_del_rol`) VALUES
(1, 'Administrador'),
(2, 'Conductor'),
(3, 'Cliente');

CREATE TABLE `rol_empresa` (
  `id_rol` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `rol_empresa` (`id_rol`, `id_empresa`) VALUES
(1, 1);



CREATE TABLE `ruta` (
  `id_ruta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `origen` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `ruta` (`id_ruta`, `nombre`, `origen`, `destino`, `horario`) VALUES
(1, 'Ruta Centro', 'Centro', 'Universidad', '08:00:00'),
(2, 'Ruta Norte', 'Terminal', 'Centro', '09:30:00');


CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `contrasena`, `id_rol`) VALUES
(1, 'Luis Mateus', 'luis@email.com', '123456', 1),
(2, 'Carlos Ruiz', 'carlos@email.com', '123456', 2),
(3, 'Ana Torres', 'ana@email.com', '123456', 3);

ALTER TABLE `buseta`
  ADD PRIMARY KEY (`id_buseta`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `fk_buseta_ruta` (`id_ruta`),
  ADD KEY `fk_buseta_empresa` (`id_empresa`);

ALTER TABLE `conductor`
  ADD PRIMARY KEY (`id_conductor`),
  ADD KEY `fk_conductor_buseta` (`id_buseta`),
  ADD KEY `fk_conductor_empresa` (`id_empresa`);


ALTER TABLE `conductor_ruta`
  ADD PRIMARY KEY (`id_conductor`,`id_ruta`),
  ADD KEY `fk_conductor_ruta_ruta` (`id_ruta`);


ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD UNIQUE KEY `nit` (`nit`);


ALTER TABLE `empresa_ruta`
  ADD PRIMARY KEY (`id_empresa`,`id_ruta`),
  ADD KEY `fk_empresa_ruta_ruta` (`id_ruta`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_usuario` (`id_usuario`),
  ADD KEY `fk_pago_ruta` (`id_ruta`);

--
-- Indices de la tabla `paradero`
--
ALTER TABLE `paradero`
  ADD PRIMARY KEY (`id_paradero`),
  ADD KEY `fk_paradero_ruta` (`id_ruta`);

--
-- Indices de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  ADD PRIMARY KEY (`id_pqrs`),
  ADD KEY `fk_pqrs_usuario` (`id_usuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rol_empresa`
--
ALTER TABLE `rol_empresa`
  ADD PRIMARY KEY (`id_rol`,`id_empresa`),
  ADD KEY `fk_rol_empresa_empresa` (`id_empresa`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`id_ruta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_usuario_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `buseta`
--
ALTER TABLE `buseta`
  MODIFY `id_buseta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `conductor`
--
ALTER TABLE `conductor`
  MODIFY `id_conductor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `paradero`
--
ALTER TABLE `paradero`
  MODIFY `id_paradero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pqrs`
--
ALTER TABLE `pqrs`
  MODIFY `id_pqrs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `buseta`
--
ALTER TABLE `buseta`
  ADD CONSTRAINT `fk_buseta_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_buseta_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `conductor`
--
ALTER TABLE `conductor`
  ADD CONSTRAINT `fk_conductor_buseta` FOREIGN KEY (`id_buseta`) REFERENCES `buseta` (`id_buseta`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_conductor_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `conductor_ruta`
  ADD CONSTRAINT `fk_conductor_ruta_conductor` FOREIGN KEY (`id_conductor`) REFERENCES `conductor` (`id_conductor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_conductor_ruta_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `empresa_ruta`
  ADD CONSTRAINT `fk_empresa_ruta_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_empresa_ruta_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pago_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

ALTER TABLE `paradero`
  ADD CONSTRAINT `fk_paradero_ruta` FOREIGN KEY (`id_ruta`) REFERENCES `ruta` (`id_ruta`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `pqrs`
  ADD CONSTRAINT `fk_pqrs_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE;

ALTER TABLE `rol_empresa`
  ADD CONSTRAINT `fk_rol_empresa_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rol_empresa_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON UPDATE CASCADE;
COMMIT;