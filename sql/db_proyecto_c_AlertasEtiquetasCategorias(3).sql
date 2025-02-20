


--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `contenido` TEXT NOT NULL,
    `numero_denuncias` INT DEFAULT 0,
    `es_denunciado` TINYINT(1) DEFAULT 0,
    `es_visible` TINYINT(1) DEFAULT 1,
    `es_cerrado` TINYINT(1) DEFAULT 0,
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

--
-- Estructura de tabla para la tabla `incidencia`
--
CREATE TABLE `incidencia`(
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador único de la incidencia', -- 事件ID
    titulo VARCHAR(255) NOT NULL COMMENT 'Título de la incidencia', -- 事件标题
    descripcion TEXT COMMENT 'Descripción detallada de la incidencia', -- 事件描述
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación', -- 创建时间
    estado ENUM('pendiente', 'procesada') DEFAULT 'pendiente' COMMENT 'Estado de la incidencia', -- 事件状态
    prioridad ENUM('alta', 'media', 'baja') DEFAULT 'media' COMMENT 'Prioridad de la incidencia' -- 事件优先级
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO incidencia (titulo, descripcion, fecha_creacion, estado, prioridad) VALUES
    ('Error de conexión', 'No se puede conectar al servidor de la base de datos.', '2025-01-23 10:00:00', 'pendiente', 'alta'),
    ('API no responde', 'La API devuelve un error 500 al intentar obtener datos.', '2025-01-23 11:00:00', 'pendiente', 'media'),
    ('Problema de inicio de sesión', 'Usuarios reportan que no pueden iniciar sesión.', '2025-01-23 12:00:00', 'pendiente', 'media'),
    ('Carga lenta del sistema', 'El sistema tarda más de lo esperado en cargar datos.', '2025-01-23 13:00:00', 'pendiente', 'baja'),
    ('Error desconocido en el servidor', 'Se produjo un error inesperado en el servidor.', '2025-01-23 14:00:00', 'pendiente', 'alta');



--
-- Estructura de tabla para la tabla `alertas`
--
CREATE TABLE `alertas` (
  `id` int(11) NOT NULL COMMENT 'ID único para cada alerta',
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la alerta',
  `descripcion` text NOT NULL COMMENT 'Descripción de la alerta',
  `id_etiqueta` int(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
  `estado` enum('pendiente', 'completado') DEFAULT 'pendiente' COMMENT 'Estado de la alerta', -- estado de alerta
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación de la alerta', -- tiempo de creacion
  `fecha_expiracion` timestamp NULL DEFAULT NULL COMMENT 'Fecha de expiración de la alerta',
  `completado_en` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la que se completó la alerta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


ALTER TABLE alertas
    ADD COLUMN usuario_id INT NOT NULL COMMENT 'numero id, para saber quién publicar las alertas';


-- creacion 5 alertas para user id 13
INSERT INTO alertas (titulo, descripcion, id_etiqueta, estado, fecha_expiracion, usuario_id)
VALUES
    ('Alerta 1', 'Descripción de la alerta 1', NULL, 'pendiente', '2025-02-01 12:00:00', 13),
    ('Alerta 2', 'Descripción de la alerta 2', NULL, 'pendiente', '2025-02-02 12:00:00', 13),
    ('Alerta 3', 'Descripción de la alerta 3', NULL, 'pendiente', '2025-02-03 12:00:00', 13),
    ('Alerta 4', 'Descripción de la alerta 4', NULL, 'pendiente', '2025-02-04 12:00:00', 13),
    ('Alerta 5', 'Descripción de la alerta 5', NULL, 'pendiente', '2025-02-05 12:00:00', 13);

-- creacion 3 alertas para user id 7
INSERT INTO alertas (titulo, descripcion, id_etiqueta, estado, fecha_expiracion, usuario_id)
VALUES
    ('Alerta 6', 'Descripción de la alerta 6', NULL, 'pendiente', '2025-02-06 12:00:00', 7),
    ('Alerta 7', 'Descripción de la alerta 7', NULL, 'pendiente', '2025-02-07 12:00:00', 7),
    ('Alerta 8', 'Descripción de la alerta 8', NULL, 'pendiente', '2025-02-08 12:00:00', 7);




-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL COMMENT 'ID único para cada categoría',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la categoría',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción de la categoría',
  `id_padre` int(11) DEFAULT NULL COMMENT 'ID de la categoría padre (opcional)',
  `id_etiqueta` int(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiquetas`
--

CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL COMMENT 'ID único para cada etiqueta',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la etiqueta',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción de la etiqueta',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de creación',
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Fecha y hora de la última actualización'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL COMMENT 'ID único para cada usuario',
  `email` varchar(255) NOT NULL COMMENT 'Correo electrónico único del usuario',
  `password` varchar(255) NOT NULL COMMENT 'Contraseña encriptada del usuario',
  `auth_key` varchar(255) DEFAULT NULL,
  `nick` varchar(100) NOT NULL COMMENT 'Apodo o nombre de usuario',
  `username` varchar(100) NOT NULL,
  `register_date` datetime DEFAULT current_timestamp() COMMENT 'Fecha de registro del usuario',
  `confirmed` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario ha confirmado su registro',
  `role` enum('guest','normal','moderator','admin','sysadmin') DEFAULT 'normal' COMMENT 'Rol del usuario en el sistema',
  `attempts` int(11) DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
  `locked` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario está bloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE configurations (
   id INT AUTO_INCREMENT PRIMARY KEY, -- ID único para cada configuración
   key_name VARCHAR(100) NOT NULL,    -- Clave única de la configuración (ejemplo: "site_title")
   value TEXT NOT NULL,               -- Valor de la configuración (ejemplo: "Mi Aplicación")
   description TEXT,                  -- Descripción de la configuración
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Fecha de creación
   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Fecha de actualización
);


--
-- Estructura de tabla para la tabla `backup`
--
CREATE TABLE backups (
  id INT AUTO_INCREMENT PRIMARY KEY, -- ID único para cada archivo de respaldo
  file_name VARCHAR(255) NOT NULL,  -- Nombre del archivo de respaldo
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Fecha de creación del respaldo
);


-- Insertar configuraciones iniciales
INSERT INTO configurations (key_name, value, description)
VALUES
    ('pagination_size', '10', 'Número de elementos por página');



--
-- Índices para tablas comentarios
--
INSERT INTO comentarios (contenido, numero_denuncias, es_denunciado, es_visible, es_cerrado)
VALUES
    ('Primer comentario de prueba', 0, 0, 1, 0),
    ('Segundo comentario denunciado', 2, 1, 1, 0),
    ('Tercer comentario bloqueado', 0, 0, 0, 0),
    ('Cuarto comentario cerrado', 0, 0, 1, 1),
    ('Quinto comentario activo', 1, 0, 1, 0);

--
-- Índices para tablas comentarios
--
INSERT INTO `alertas` (`titulo`, `descripcion`, `estado`, `fecha_expiracion`)
VALUES
    ('Alerta de Tráfico', 'Accidente en la carretera principal', 'pendiente', '2025-01-31 12:00:00'),
    ('Alerta de Clima', 'Lluvias intensas en la región sur', 'pendiente', '2025-01-25 15:00:00'),
    ('Alerta de Seguridad', 'Robo en el centro comercial', 'pendiente', '2025-01-28 18:00:00'),
    ('Alerta de Emergencia', 'Incendio en el edificio central', 'pendiente', '2025-01-29 20:00:00'),
    ('Alerta de Salud', 'Brote de gripe en la ciudad', 'pendiente', '2025-02-01 09:00:00');




--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_etiqueta` (`id_etiqueta`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_padre` (`id_padre`),
  ADD KEY `id_etiqueta` (`id_etiqueta`);

--
-- Indices de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alertas`
--
ALTER TABLE `alertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta';

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada categoría';

--
-- AUTO_INCREMENT de la tabla `etiquetas`
--
ALTER TABLE `etiquetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada etiqueta', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada usuario', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `categorias_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL;
COMMIT;





ALTER TABLE `incidencia` ADD COLUMN `fecha_revision` DATETIME;

ALTER TABLE `incidencia` ADD COLUMN `respuesta` TEXT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
