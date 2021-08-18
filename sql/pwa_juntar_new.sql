use yii2advanced;
--
-- Estructura de tabla para la tabla `categoria_evento`
--

CREATE TABLE `categoria_evento` (
  `idCategoriaEvento` tinyint(4) NOT NULL,
  `descripcionCategoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_evento`
--

CREATE TABLE `estado_evento` (
  `idEstadoEvento` tinyint(4) NOT NULL,
  `descripcionEstado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad_evento`
--

CREATE TABLE `modalidad_evento` (
  `idModalidadEvento` tinyint(4) NOT NULL,
  `descripcionModalidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE evento (
  idEvento bigint(20) NOT NULL,
  idUsuario bigint(20) NOT NULL,
  idCategoriaEvento tinyint(4) NOT NULL,
  idEstadoEvento tinyint(4) NOT NULL,
  idModalidadEvento tinyint(4) NOT NULL,
  nombreEvento varchar(200) NOT NULL,
  nombreCortoEvento varchar(100) NOT NULL,
  descripcionEvento varchar(2000) NOT NULL,
  lugar varchar(200) NOT NULL,
  fechaInicioEvento date NOT NULL,
  fechaFinEvento date NOT NULL,
  avalado tinyint(4) NOT NULL DEFAULT 0,
  eventoToken varchar(255) DEFAULT NULL,
  imgFlyer varchar(200) DEFAULT NULL,
  imgLogo varchar(200) DEFAULT NULL,
  capacidad smallint(6) NULL,
  preInscripcion tinyint(1) NOT NULL,
  fechaLimiteInscripcion date DEFAULT NULL,
  codigoAcreditacion varchar(100) DEFAULT NULL,
  fechaCreacionEvento date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `idInscripcion` bigint(20) NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `fechaPreInscripcion` date NOT NULL,
  `fechaInscripcion` date DEFAULT NULL,
  `acreditacion` tinyint(1) DEFAULT NULL,
  `certificado` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regla`
--

CREATE TABLE `regla` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso_rol`
--

CREATE TABLE `permiso_rol` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `idPresentacion` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `tituloPresentacion` varchar(200) NOT NULL,
  `descripcionPresentacion` varchar(2000) NOT NULL,
  `diaPresentacion` date NOT NULL,
  `horaInicioPresentacion` time NOT NULL,
  `horaFinPresentacion` time NOT NULL,
  `linkARecursos` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_expositor`
--

CREATE TABLE `presentacion_expositor` (
  `idExpositor` bigint(20) NOT NULL,
  `idPresentacion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dni` int(11) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `pais` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `provincia` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barrio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `otro_barrio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 9,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_perfil`
--

CREATE TABLE `imagen_perfil` (
  `idUsuario` bigint(20) NOT NULL,
  `rutaImagenPerfil` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `item_name` varchar(64) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_aval`
--

CREATE TABLE `solicitud_aval` (
  `idSolicitudAval` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `fechaSolicitud` datetime NOT NULL,
  `tokenSolicitud` varchar(200) NOT NULL,
  `fechaRevision` datetime DEFAULT NULL,
  `avalado` tinyint(1) DEFAULT NULL,
  `validador` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` bigint(20) NOT NULL,
  `idevento` bigint(20) NOT NULL,
  `tipo` enum('1','2','3') NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` bigint(20) NOT NULL,
  `idpregunta` bigint(20) NOT NULL,
  `idinscripcion` bigint(20) NOT NULL,
  `respuesta` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_evento`
--

CREATE TABLE `imagen_evento` (
  `idImagenEvento` bigint(20) NOT NULL,
  `idEvento` bigint(20) NOT NULL,
  `categoriaImagen` tinyint(4) NOT NULL,
  `rutaArchivoImagen` varchar(200) NOT NULL,
  `fechaCreacionImagen` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- #######################################################################################################################
-- #######################################################################################################################
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  ADD PRIMARY KEY (`idCategoriaEvento`);

--
-- Indices de la tabla `estado_evento`
--
ALTER TABLE `estado_evento`
  ADD PRIMARY KEY (`idEstadoEvento`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idCategoria` (`idCategoriaEvento`),
  ADD KEY `idEstadoEvento` (`idEstadoEvento`),
  ADD KEY `idModalidadEvento` (`idModalidadEvento`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`idInscripcion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `modalidad_evento`
--
ALTER TABLE `modalidad_evento`
  ADD PRIMARY KEY (`idModalidadEvento`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indices de la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`idPresentacion`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indices de la tabla `presentacion_expositor`
--
ALTER TABLE `presentacion_expositor`
  ADD PRIMARY KEY (`idExpositor`,`idPresentacion`),
  ADD KEY `idExpositor` (`idExpositor`),
  ADD KEY `idPresentacion` (`idPresentacion`);

--
-- Indices de la tabla `regla`
--
ALTER TABLE `regla`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indices de la tabla `imagen_perfil`
--
ALTER TABLE `imagen_perfil`
  ADD PRIMARY KEY (`idUsuario`,`rutaImagenPerfil`),
  ADD UNIQUE KEY `rutaImagenPerfil` (`rutaImagenPerfil`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `usuario_rol_usuario_id_idx` (`user_id`),
  ADD KEY `item_name` (`item_name`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idevento` (`idevento`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpregunta` (`idpregunta`),
  ADD KEY `idinscripcion` (`idinscripcion`);

--
-- Indices de la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  ADD PRIMARY KEY (`idSolicitudAval`) USING BTREE,
  ADD UNIQUE KEY `idEvento` (`idEvento`) USING BTREE,
  ADD KEY `validador` (`validador`) USING BTREE;

--
-- Indices de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD PRIMARY KEY (`idImagenEvento`),
  ADD KEY `idEvento` (`idEvento`);


-- #######################################################################################################################
-- #######################################################################################################################
--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_evento`
--
ALTER TABLE `categoria_evento`
  MODIFY `idCategoriaEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_evento`
--
ALTER TABLE `estado_evento`
  MODIFY `idEstadoEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `idInscripcion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modalidad_evento`
--
ALTER TABLE `modalidad_evento`
  MODIFY `idModalidadEvento` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `idPresentacion` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  MODIFY `idSolicitudAval` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  MODIFY `idImagenEvento` bigint(20) NOT NULL AUTO_INCREMENT;


-- #######################################################################################################################
-- #######################################################################################################################
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`idCategoriaEvento`) REFERENCES `categoria_evento` (`idCategoriaEvento`),
  ADD CONSTRAINT `evento_ibfk_3` FOREIGN KEY (`idModalidadEvento`) REFERENCES `modalidad_evento` (`idModalidadEvento`),
  ADD CONSTRAINT `evento_ibfk_4` FOREIGN KEY (`idEstadoEvento`) REFERENCES `estado_evento` (`idEstadoEvento`);

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `regla` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `permiso_rol`
--
ALTER TABLE `permiso_rol`
  ADD CONSTRAINT `permiso_rol_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permiso_rol_ibfk_2` FOREIGN KEY (`child`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD CONSTRAINT `presentacion_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `presentacion_expositor`
--
ALTER TABLE `presentacion_expositor`
  ADD CONSTRAINT `presentacion_expositor_ibfk_1` FOREIGN KEY (`idExpositor`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presentacion_expositor_ibfk_2` FOREIGN KEY (`idPresentacion`) REFERENCES `presentacion` (`idPresentacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagen_perfil`
--
ALTER TABLE `imagen_perfil`
  ADD CONSTRAINT `imagen_perfil_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `usuario_rol_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `permiso` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_rol_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `pregunta_ibfk_1` FOREIGN KEY (`idevento`) REFERENCES `evento` (`idEvento`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `respuesta_ibfk_1` FOREIGN KEY (`idpregunta`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `respuesta_ibfk_2` FOREIGN KEY (`idinscripcion`) REFERENCES `inscripcion` (`idInscripcion`);

--
-- Filtros para la tabla `solicitud_aval`
--
ALTER TABLE `solicitud_aval`
  ADD CONSTRAINT `solicitud_aval_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  ADD CONSTRAINT `solicitud_aval_ibfk_2` FOREIGN KEY (`validador`) REFERENCES `usuario` (`idUsuario`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `imagen_evento`
--
ALTER TABLE `imagen_evento`
  ADD CONSTRAINT `imagen_evento_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`) ON DELETE NO ACTION ON UPDATE CASCADE;

-- #######################################################################################################################
-- #######################################################################################################################
--
-- Volcado de datos para las tablas
--

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('acreditacion/acreditacion', 2, 'FRONTEND [Registrado] - Permite a un usuario acreditarse a un evento', NULL, NULL, 1593652530, 1593652530),
('Administrador', 1, 'Rol - Superusuario Administrador', NULL, NULL, 1590382997, 1590382997),
('categoria-evento/create', 2, 'BACKEND [Administrador] - Permite crear una nueva categoria de evento', NULL, NULL, 1593809771, 1593809771),
('categoria-evento/delete', 2, 'BACKEND [Administrador] - Permite borrar una categoria de evento', NULL, NULL, 1593809828, 1593809828),
('categoria-evento/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todas las categorias de evento', NULL, NULL, 1593809495, 1593809495),
('categoria-evento/update', 2, 'BACKEND [Administrador] - Permite modificar una categoria de evento', NULL, NULL, 1593809816, 1593809816),
('categoria-evento/view', 2, 'BACKEND [Administrador] - Permite visualizar la información de una categoria de evento', NULL, NULL, 1593809519, 1593809519),
('certificado/index', 2, 'FRONTEND [Registrado] - Permite visualizar el menú de certificados', NULL, NULL, 1593652754, 1593652754),
('certificado/preview-attendance', 2, 'FRONTEND [Registrado] - Permite visualizar el certificado de asistencia a un evento', NULL, NULL, 1593652801, 1593652801),
('certificado/preview-organizer', 2, 'FRONTEND [Organizador] - Permite visualizar el certificado de Organizador del evento', NULL, NULL, 1593652824, 1593652824),
('cuenta/cambiar-email', 2, 'FRONTEND [Registrado] - Permite cambiar el email de la cuenta a partir del token enviado al correo', NULL, NULL, 1593652391, 1593652391),
('cuenta/cambiar-email-request', 2, 'FRONTEND [Registrado] - Permite solicitar un cambio de email para la cuenta', NULL, NULL, 1593652372, 1593652372),
('cuenta/cambiar-password', 2, 'FRONTEND [Registrado] - Permite cambiar la contraseña de la cuenta', NULL, NULL, 1593652358, 1593652358),
('cuenta/desactivar-cuenta', 2, 'FRONTEND [Registrado] - Permite desactivar la cuenta de usuario', NULL, NULL, 1593652344, 1593652344),
('cuenta/editprofile', 2, 'FRONTEND [Registrado] - Permite editar la información de la cuenta', NULL, NULL, 1593652258, 1593652258),
('cuenta/mis-eventos-gestionados', 2, 'FRONTEND [Organizador] - Permite visualizar todos los eventos gestionados', NULL, NULL, 1593652294, 1593652294),
('cuenta/mis-inscripciones-a-eventos', 2, 'FRONTEND [Registrado] - Permite visualizar todos los eventos a los que se inscribió el usuario', NULL, NULL, 1593652313, 1593652313),
('cuenta/profile', 2, 'FRONTEND [Registrado] - Permite acceder al perfil de usuario para visualizar tus datos', NULL, NULL, 1593652158, 1593652158),
('cuenta/upload-profile-image', 2, 'FRONTEND [Registrado] - Permite subir una imagen de perfil', NULL, NULL, 1593652328, 1593652328),
('evento/cargar-evento', 2, 'FRONTEND [Organizador] - Permite cargar un evento a la plataforma', NULL, NULL, 1593660608, 1593660608),
('evento/cargar-expositor', 2, 'FRONTEND [Organizador] - Permite cargar expositores a las presentaciones de un evento', NULL, NULL, 1593660742, 1593660742),
('evento/confirmar-solicitud', 2, 'FRONTEND [Validador] - Permite conceder el aval de la FAI a un evento que lo haya solicitado', NULL, NULL, 1593674263, 1593674263),
('evento/crear-email', 2, 'FRONTEND [Organizador] - Permite crear un email para el evento', NULL, NULL, 1593671564, 1593671564),
('evento/crear-formulario-dinamico', 2, 'FRONTEND [Organizador] - Permite a un organizador crear un formulario dinámico para la preinscripcion', NULL, NULL, 1593661609, 1593661609),
('evento/create', 2, 'BACKEND [Administrador] - Permite crear un nuevo evento, desde el backend, en la plataforma', NULL, NULL, 1593648747, 1593648747),
('evento/denegar-solicitud', 2, 'FRONTEND [Validador] - Permite denegar el aval de la FAI a un evento que lo haya solicitado', NULL, NULL, 1593674285, 1593674285),
('evento/deshabilitar', 2, 'BACKEND [Administrador] - Permite deshabilitar un evento en la plataforma', NULL, NULL, 1593648786, 1593648786),
('evento/editar-evento', 2, 'FRONTEND [Organizador] - Permite editar un evento cargado en la plataforma', NULL, NULL, 1593660626, 1593660626),
('evento/enviar-email', 2, 'FRONTEND [Organizador] - Permite enviar un email a los participantes del evento', NULL, NULL, 1593671582, 1593671582),
('evento/enviar-email-inscriptos', 2, 'FRONTEND [Organizador] - Permite enviar un email a todos los usuarios inscriptos al evento', NULL, NULL, 1593671537, 1593671537),
('evento/enviar-solicitud-evento', 2, 'FRONTEND [Organizador] - Permite enviar una solicitud para recibir el aval de la Facultad de informática para el evento gestionado', NULL, NULL, 1593674101, 1593674101),
('evento/evento-email', 2, 'FRONTEND [Organizador] - Permite enviar un email a todos los usuarios inscriptos a un evento', NULL, NULL, 1593674897, 1593674897),
('evento/evento-form', 2, 'zzz', NULL, NULL, 1593831576, 1593831576),
('evento/finalizar-evento', 2, 'FRONTEND [Organizador] - Permite finalizar un evento cargado en la plataforma', NULL, NULL, 1593660674, 1593660674),
('evento/habilitar', 2, 'BACKEND [Administrador] - Permite habilitar un evento en la plataforma', NULL, NULL, 1593648799, 1593648799),
('evento/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los eventos registrados en la plataforma', NULL, NULL, 1593648690, 1593648690),
('evento/lista-participantes', 2, 'FRONTEND [Organizador] - Permite bajar un archivo con el listado de participantes del evento', NULL, NULL, 1593671508, 1593671508),
('evento/modificar-organizador', 2, 'BACKEND [Administrador] - Permite modificar al organizador de un evento', NULL, NULL, 1593837548, 1593837548),
('evento/mostrar-acreditaciones', 2, 'FRONTEND [Registrado] - Permite a un usuario registrado acceder a los codigos QR propios del evento en que se encuentre', NULL, NULL, 1593937919, 1593937919),
('evento/mostrar-qr-evento', 2, 'FRONTEND [Registrado] - Permite a un usuario acceder a los codigos QR generados para el evento que esté viendo', NULL, NULL, 1593938041, 1593938041),
('evento/no-js', 2, 'FRONTEND [Registrado] - Permite a un usuario saber si tiene Javascript activado', NULL, NULL, 1593674990, 1593674990),
('evento/obtener-expositores', 2, 'FRONTEND [Organizador] - Permite obtener todos los usuarios expositores del evento', NULL, NULL, 1593671741, 1593671741),
('evento/obtener-inscriptos', 2, 'FRONTEND [Organizador] - Permite obtener el listado de todos los usuarios inscriptos del evento', NULL, NULL, 1593671642, 1593671642),
('evento/obtener-prinscriptos', 2, 'FRONTEND [Organizador] - Permite obtener todos los usuarios preinscriptos al evento', NULL, NULL, 1593671612, 1593671612),
('evento/organizar-eventos', 2, 'FRONTEND [Organizador] - Permite a un usuario visualizar todos sus eventos organizados', NULL, NULL, 1593672671, 1593672671),
('evento/publicar-evento', 2, 'FRONTEND [Organizador] - Permite publicar un evento en la plataforma (hacerlo visible al público)', NULL, NULL, 1593660644, 1593660644),
('evento/responder-formulario', 2, 'FRONTEND [Registrado] - Permite responder el formulario de un evento', NULL, NULL, 1593672611, 1593672611),
('evento/respuestas-formulario', 2, 'FRONTEND [Organizador] - Permite visualizar las respuestas del formulario de preinscripcion', NULL, NULL, 1593661580, 1593661580),
('evento/suspender-evento', 2, 'FRONTEND [Organizador] - Permite suspender un evento cargado', NULL, NULL, 1593660661, 1593660661),
('evento/update', 2, 'BACKEND [Administrador] - Permite actualizar los datos de un evento registrado', NULL, NULL, 1593648763, 1593648763),
('evento/ver-evento', 2, 'FRONTEND [Registrado] - Permite visualizar un evento', NULL, NULL, 1593672598, 1593672598),
('evento/verificar-solicitud', 2, 'FRONTEND [Validador] - Permite verificar una solicitud para obtener el aval de la FAI', NULL, NULL, 1593674239, 1593674239),
('evento/view', 2, 'BACKEND [Administrador] - Permite visualizar los datos de un evento particular', NULL, NULL, 1593648718, 1593648718),
('inscripcion/anular-inscripcion', 2, 'FRONTEND [Organizador] - Permite anular la inscripción de un usuario a su evento', NULL, NULL, 1593658776, 1593658776),
('inscripcion/eliminar-inscripcion', 2, 'FRONTEND [Registrado] - Permite al usuario anular su inscripción a un evento', NULL, NULL, 1593658850, 1593658850),
('inscripcion/inscribir-a-usuario', 2, 'FRONTEND [Organizador] - Permite inscribir un usuario a su evento', NULL, NULL, 1593658793, 1593658793),
('inscripcion/preinscripcion', 2, 'FRONTEND [Registrado] - Permite preinscribirse a un evento', NULL, NULL, 1593658820, 1593658820),
('modalidad-evento/create', 2, 'BACKEND [Administrador] - Permite crear una nueva modalidad de evento', NULL, NULL, 1593651768, 1593651768),
('modalidad-evento/delete', 2, 'BACKEND [Administrador] - Permite eliminar una modalidad de evento', NULL, NULL, 1593651795, 1593651795),
('modalidad-evento/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todas las modalidades de evento que existen', NULL, NULL, 1593651738, 1593651738),
('modalidad-evento/update', 2, 'BACKEND [Administrador] - Permite actualizar los datos de una modalidad de evento', NULL, NULL, 1593651784, 1593651784),
('modalidad-evento/view', 2, 'BACKEND [Administrador] - Permite visualizar la información de una modalidad de evento', NULL, NULL, 1593651756, 1593651756),
('Organizador', 1, 'Rol - Usuario gestor de eventos', NULL, NULL, 1590382997, 1590382997),
('permission/asignar-permiso-a-rol', 2, 'BACKEND [Administrador] - Permite asignar un permiso a un rol seleccionado', NULL, NULL, 1592304078, 1592304078),
('permission/asignar-permisos', 2, 'BACKEND [Administrador] - Permite acceder a la UI para la asignación de permisos', NULL, NULL, 1592303862, 1592303862),
('permission/create-permiso', 2, 'BACKEND [Administrador] - Permite registrar un nuevo permiso', NULL, NULL, 1592304105, 1592304105),
('permission/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los permisos registrados', NULL, NULL, 1593651654, 1593651654),
('permission/remove-permiso', 2, 'BACKEND [Administrador] - Permite eliminar un permiso', NULL, NULL, 1593651640, 1593651640),
('permission/ver-permiso', 2, 'BACKEND [Administrador] - Permite visualizar la información de un permiso', NULL, NULL, 1593651626, 1593651626),
('pregunta/create', 2, 'FRONTEND [Organizador] - Permite crear una pregunta para formulario de preinscripcion', NULL, NULL, 1593656131, 1593656131),
('pregunta/delete', 2, 'FRONTEND [Organizador] - Permite borrar una pregunta del formulario de preinscripcion', NULL, NULL, 1593656169, 1593656169),
('pregunta/update', 2, 'FRONTEND [Organizador] - Permite modificar una pregunta del formulario de preinscripcion', NULL, NULL, 1593656155, 1593656155),
('presentacion-expositor/delete', 2, 'FRONTEND [Organizador] - Permite eliminar un expositor de una presentación de un evento', NULL, NULL, 1593673397, 1593673397),
('presentacion-expositor/update', 2, 'BACKEND [Administrador] - Permite actualizar los expositores de una presentación de un evento', NULL, NULL, 1593931211, 1593931211),
('presentacion-expositor/ver-expositores', 2, 'FRONTEND [Registrado] - Permite visualizar los expositores designados para una presentación de un evento', NULL, NULL, 1593674591, 1593674591),
('presentacion/borrar', 2, 'FRONTEND [Organizador] - Permite borrar una presentacion de la agenda del evento', NULL, NULL, 1593673164, 1593673164),
('presentacion/cargar-presentacion', 2, 'FRONTEND [Organizador] - Permite cargar una presentación a la agenda del evento', NULL, NULL, 1593673353, 1593673353),
('presentacion/create', 2, 'FRONTEND [Organizador] - Permite definir una presentación para un evento', NULL, NULL, 1593673276, 1593673276),
('presentacion/delete', 2, 'FRONTEND [Organizador] - Permite eliminar la presentación de la agenda de un evento', NULL, NULL, 1593673329, 1593673329),
('presentacion/list-of-presentation', 2, 'BACKEND [Administrador] - Permite ver la lista de presentaciones de un evento particular', NULL, NULL, 1593930751, 1593930751),
('presentacion/update', 2, 'FRONTEND [Organizador] - Permite actualizar los datos de una presentación de un evento', NULL, NULL, 1593673301, 1593673301),
('presentacion/view', 2, 'FRONTEND [Registrado] - Permite visualizar la información completa de una presentación de un evento', NULL, NULL, 1593674553, 1593674553),
('Registrado', 1, 'Rol - Usuario registrado en la plataforma', NULL, NULL, NULL, NULL),
('respuesta/create', 2, 'FRONTEND [Registrado] - Permite a un usuario registrar una respuesta a una pregunta de formulario de preinscripcion', NULL, NULL, 1593656949, 1593656949),
('respuesta/ver', 2, 'FRONTEND [Registrado] - Permite a un usuario ver su respuesta a una pregunta', NULL, NULL, 1593656916, 1593656916),
('rol/create-rol', 2, 'BACKEND [Administrador] - Permite crear un nuevo rol', NULL, NULL, 1593651459, 1593651459),
('rol/index', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todos los roles registrados en la plataforma', NULL, NULL, 1593651438, 1593651438),
('rol/remove-rol', 2, 'BACKEND [Administrador] - Permite eliminar un rol', NULL, NULL, 1593651506, 1593651506),
('rol/ver-rol', 2, 'BACKEND [Administrador] - Permite visualizar la información de un rol', NULL, NULL, 1593651450, 1593651450),
('site/index', 2, 'Permite al usuario acceder al home de la plataforma', NULL, NULL, 1593649035, 1593649035),
('site/login', 2, 'Permite a un usuario iniciar sesión en la plataforma', NULL, NULL, 1593650681, 1593650681),
('site/logout', 2, 'Permite a un usuario cerrar sesión en la plataforma', NULL, NULL, 1593650703, 1593650703),
('solicitud-aval/conceder-aval', 2, 'BACKEND [Administrador] - Permite conceder el aval de la FAI a un evento', NULL, NULL, 1593651320, 1593651320),
('solicitud-aval/quitar-aval', 2, 'BACKEND [Administrador] - Permite quitar el aval de la FAI a un evento', NULL, NULL, 1593651333, 1593651333),
('solicitud-aval/solicitudes-de-aval', 2, 'BACKEND [Administrador] - Permite visualizar el listado de todas las solicitudes de aval de los eventos en Juntar', NULL, NULL, 1593651291, 1593651291),
('solicitud-aval/view', 2, 'BACKEND [Administrador] - Permite visualizar una solicitud de aval', NULL, NULL, 1593651307, 1593651307),
('usuario/assign', 2, 'BACKEND [Administrador] - Permite asignarle un rol a un usuario', NULL, NULL, 1593647871, 1593647871),
('usuario/cambiar-password', 2, 'BACKEND [Administrador] - Permite asignar una nueva contraseña, sin restricciones, a un usuario', NULL, NULL, 1593846148, 1593846148),
('usuario/crear-usuario', 2, 'BACKEND [Administrador] - Permite crear una nueva cuenta de usuario desde el backend', NULL, NULL, 1593647896, 1593647896),
('usuario/deshabilitar', 2, 'BACKEND [Administrador] - Permite deshabilitar un usuario', NULL, NULL, 1593647937, 1593647937),
('usuario/habilitar', 2, 'BACKEND [Administrador] - Permite habilitar un usuario deshabilitado', NULL, NULL, 1593647956, 1593647956),
('usuario/index', 2, 'BACKEND [Administrador] - Permite ver el listado de todos los usuarios registrados en la plataforma', NULL, NULL, 1593647819, 1593647819),
('usuario/restore-password', 2, 'BACKEND [Administrador] - Permite enviarle a un usuario una solicitud para que pueda modificar su contraseña', NULL, NULL, 1593846186, 1593846186),
('usuario/update', 2, 'BACKEND [Administrador] - Permite modificar los datos de un usuario registrado', NULL, NULL, 1593647918, 1593647918),
('usuario/view', 2, 'BACKEND [Administrador] - Permite visualizar los datos de un usuario particular', NULL, NULL, 1593647847, 1593647847),
('Validador', 1, 'Rol - Encargado de validar eventos para dar el aval de la Facultad de Informática', NULL, NULL, 1593673992, 1593673992);

--
-- Volcado de datos para la tabla `permiso_rol`
--

INSERT INTO `permiso_rol` (`parent`, `child`) VALUES
('Administrador', 'evento/create'),
('Administrador', 'evento/deshabilitar'),
('Administrador', 'evento/habilitar'),
('Administrador', 'evento/index'),
('Administrador', 'evento/update'),
('Administrador', 'evento/view'),
('Administrador', 'modalidad-evento/create'),
('Administrador', 'modalidad-evento/delete'),
('Administrador', 'modalidad-evento/index'),
('Administrador', 'modalidad-evento/update'),
('Administrador', 'modalidad-evento/view'),
('Administrador', 'Organizador'),
('Administrador', 'permission/asignar-permiso-a-rol'),
('Administrador', 'permission/asignar-permisos'),
('Administrador', 'permission/create-permiso'),
('Administrador', 'permission/index'),
('Administrador', 'permission/remove-permiso'),
('Administrador', 'permission/ver-permiso'),
('Administrador', 'Registrado'),
('Administrador', 'rol/create-rol'),
('Administrador', 'rol/index'),
('Administrador', 'rol/remove-rol'),
('Administrador', 'rol/ver-rol'),
('Administrador', 'site/login'),
('Administrador', 'solicitud-aval/conceder-aval'),
('Administrador', 'solicitud-aval/quitar-aval'),
('Administrador', 'solicitud-aval/solicitudes-de-aval'),
('Administrador', 'solicitud-aval/view'),
('Administrador', 'usuario/assign'),
('Administrador', 'usuario/crear-usuario'),
('Administrador', 'usuario/deshabilitar'),
('Administrador', 'usuario/habilitar'),
('Administrador', 'usuario/index'),
('Administrador', 'usuario/update'),
('Administrador', 'usuario/view'),
('Administrador', 'Validador'),
('Organizador', 'certificado/preview-organizer'),
('Organizador', 'cuenta/mis-eventos-gestionados'),
('Organizador', 'evento/cargar-evento'),
('Organizador', 'evento/cargar-expositor'),
('Organizador', 'evento/crear-email'),
('Organizador', 'evento/mostrar-qr-evento'),
('Organizador', 'evento/crear-formulario-dinamico'),
('Organizador', 'evento/editar-evento'),
('Organizador', 'evento/enviar-email'),
('Organizador', 'evento/enviar-email-inscriptos'),
('Organizador', 'evento/enviar-solicitud-evento'),
('Organizador', 'evento/evento-email'),
('Organizador', 'evento/finalizar-evento'),
('Organizador', 'evento/lista-participantes'),
('Organizador', 'evento/obtener-expositores'),
('Organizador', 'evento/obtener-inscriptos'),
('Organizador', 'evento/obtener-prinscriptos'),
('Organizador', 'evento/organizar-eventos'),
('Organizador', 'evento/publicar-evento'),
('Organizador', 'evento/respuestas-formulario'),
('Organizador', 'evento/suspender-evento'),
('Organizador', 'inscripcion/anular-inscripcion'),
('Organizador', 'inscripcion/inscribir-a-usuario'),
('Organizador', 'pregunta/create'),
('Organizador', 'pregunta/delete'),
('Organizador', 'pregunta/update'),
('Organizador', 'presentacion-expositor/delete'),
('Organizador', 'presentacion/borrar'),
('Organizador', 'presentacion/cargar-presentacion'),
('Organizador', 'presentacion/create'),
('Organizador', 'presentacion/delete'),
('Organizador', 'presentacion/update'),
('Organizador', 'Registrado'),
('Registrado', 'acreditacion/acreditacion'),
('Registrado', 'certificado/index'),
('Registrado', 'certificado/preview-attendance'),
('Registrado', 'cuenta/cambiar-email'),
('Registrado', 'cuenta/cambiar-email-request'),
('Registrado', 'cuenta/cambiar-password'),
('Registrado', 'cuenta/desactivar-cuenta'),
('Registrado', 'cuenta/editprofile'),
('Registrado', 'cuenta/mis-inscripciones-a-eventos'),
('Registrado', 'cuenta/profile'),
('Registrado', 'cuenta/upload-profile-image'),
('Registrado', 'evento/no-js'),
('Registrado', 'evento/responder-formulario'),
('Registrado', 'evento/ver-evento'),
('Registrado', 'inscripcion/eliminar-inscripcion'),
('Registrado', 'inscripcion/preinscripcion'),
('Registrado', 'presentacion-expositor/ver-expositores'),
('Registrado', 'presentacion/view'),
('Registrado', 'respuesta/create'),
('Registrado', 'respuesta/ver'),
('Registrado', 'site/index'),
('Registrado', 'site/login'),
('Registrado', 'site/logout'),
('Validador', 'evento/confirmar-solicitud'),
('Validador', 'evento/denegar-solicitud'),
('Validador', 'evento/verificar-solicitud'),
('Validador', 'Organizador'),
('Validador', 'Registrado');

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombre`, `apellido`, `dni`, `pais`, `provincia`, `localidad`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'Administrador', 'Administrador', 20332183, '', NULL, 'Neuquén', 'admin01@test.com', 'OmzVKGUJExEJuN4e_yJnso6tNabdoF09', '$2y$13$hkfdaAZgIQEaZTrHRNsnje0otnGEzHo.BIoaXbsWqEbb51si.PR3e', NULL, 10, 1590994328, 1590994328, 'FAcDt5Ki0rSn5JLg9aMtCaV4F-LeTGUY_1590994328'),
(2, 'Rodrigo', 'Lazo', 20332183, '', NULL, 'Neuquén', 'organizador01@test.com', 'RfIaQzvchcC1zfRlAo2C7OpT04tNwcxF', '$2y$13$atb/agLp5ViXD20KG91yRefE0SN73JLrNOaJnD6UVcN64DQkTyrze', NULL, 10, 1590994729, 1590994729, '4i0PgyPBBD-1zt0DlQEVo8PP9MLtFAAN_1590994729'),
(3, 'Sabrina', 'Casas', 18664055, '', NULL, 'Centenario', 'organizador02@test.com', 'o546IVKZ0Vc1tnzfYruu3jTq1AEQl5XY', '$2y$13$OdLxghAQtDLB4WS7aIpWrOd7WR12ZuzfPfu/g23E.T8l06e8ALuWq', NULL, 10, 1590994776, 1590994776, 'zBU1IGmB733ix97W1n4GwVWVXQZhNemm_1590994776'),
(4, 'Alejandro', 'Medario', 32976700, '', NULL, 'Neuquén', 'registrado01@test.com', 'nE1auJs4ex8KmM7mo5UEtvrkFtSt94FI', '$2y$13$TkAsHr/QXEWKXR0OAxCm/.9ij2nod5iBibpk6ly0ZkTz9YeHmrEha', NULL, 10, 1590994878, 1590994878, 'vucICXx57O0zJv3LkAK7ueInqv9vrF1I_1590994878'),
(5, 'Matias', 'Contreras', 31179842, '', NULL, 'Cipolletti', 'registrado02@test.com', '5pjZV8xixJkfcspDznsGCq3QuIbU05da', '$2y$13$gc42YUd7Qsp2vrJACHZYLOn3b.Mh9JmS1N/ZOLIf7ayyFhKre7rgW', NULL, 10, 1590994958, 1590994958, 'GApav7SolKFCdriU-_NNYnTleAfenZyz_1590994958');

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`item_name`, `user_id`, `created_at`) VALUES 
('Administrador', 1, NULL),
('Organizador', 2, NULL),
('Organizador', 3, NULL),
('Registrado', 4, NULL),
('Registrado', 5, NULL);


--
-- Volcado de datos para la tabla `categoria_evento`
--

INSERT INTO categoria_evento (idCategoriaEvento, descripcionCategoria) VALUES
(1, 'Seminario'),
(2, 'Congreso'),
(3, 'Diplomatura'),
(4, 'Otra');

--
-- Volcado de datos para la tabla `estado_evento`
--

INSERT INTO estado_evento (idEstadoEvento, descripcionEstado) VALUES
(1, 'Activo'),
(2, 'inhabilitado'),
(3, 'Finalizado'),
(4, 'Borrador');

--
-- Volcado de datos para la tabla `modalidad_evento`
--

INSERT INTO modalidad_evento (idModalidadEvento, descripcionModalidad) VALUES
(1, 'Presencial'),
(2, 'Online'),
(3, 'Presencial y Online'),
(4, 'Otra');
COMMIT;
