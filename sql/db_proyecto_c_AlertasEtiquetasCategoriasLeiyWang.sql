-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2025 a las 20:44:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_c`
--

DROP DATABASE IF EXISTS `proyecto_c`;
CREATE DATABASE IF NOT EXISTS `proyecto_c`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `proyecto_c`;
-- --------------------------------------------------------



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
CREATE TABLE `incidencia` (
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
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta',
    `titulo` VARCHAR(255) NOT NULL COMMENT 'Título de la alerta',
    `descripcion` TEXT NOT NULL COMMENT 'Descripción de la alerta',
    `id_etiqueta` INT(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
    `estado` ENUM('pendiente', 'completado') DEFAULT 'pendiente' COMMENT 'Estado de la alerta', -- estado de alerta
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación de la alerta', -- tiempo de creacion
    `fecha_expiracion` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha de expiración de la alerta',
    `usuario_id`  INT NOT NULL COMMENT 'numero id, para saber quién publicar las alertas',
    `completado_en` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha en la que se completó la alerta',
    PRIMARY KEY (`id`),  -- Establece `id` como clave primaria
    KEY `id_etiqueta` (`id_etiqueta`)  -- Índice para mejorar consultas por `id_etiqueta`
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



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


INSERT INTO `alertas` (titulo, descripcion, estado, fecha_expiracion)
VALUES
    ('Alerta de Tráfico', 'Accidente en la carretera principal', 'pendiente', '2025-01-31 12:00:00'),
    ('Alerta de Clima', 'Lluvias intensas en la región sur', 'pendiente', '2025-01-25 15:00:00'),
    ('Alerta de Seguridad', 'Robo en el centro comercial', 'pendiente', '2025-01-28 18:00:00'),
    ('Alerta de Emergencia', 'Incendio en el edificio central', 'pendiente', '2025-01-29 20:00:00'),
    ('Alerta de Salud', 'Brote de gripe en la ciudad', 'pendiente', '2025-02-01 09:00:00');


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


ALTER TABLE usuario
    ADD COLUMN phone VARCHAR(15) DEFAULT NULL COMMENT 'Número de teléfono del usuario';

ALTER TABLE usuario
    ADD COLUMN status TINYINT(1) DEFAULT 0 COMMENT 'Estado del usuario'; -- 默认值为 0，表示未确认


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
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `auth_key`, `nick`, `username`, `register_date`, `confirmed`, `role`, `attempts`, `locked`) VALUES
(3, 'dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', 'djPiri', '2025-01-14 12:37:44', 1, '', 0, 0);

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





--
-- Índices para tablas volcadas
--
CREATE TABLE `incidencias` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,       -- 主键
    `descripcion` TEXT NOT NULL,               -- 事件描述
    `estado` VARCHAR(50) NOT NULL,             -- 状态字段，例如 'nueva', 'revisada'
    `fecha_creacion` DATETIME NOT NULL,        -- 创建时间
    `fecha_revision` DATETIME DEFAULT NULL,    -- 审核时间（可为空）
    `creado_por` INT DEFAULT NULL,             -- 创建者ID
    `revisado_por` INT DEFAULT NULL            -- 审核者ID
);

INSERT INTO `incidencias` (`descripcion`, `estado`, `fecha_creacion`, `fecha_revision`) VALUES
('Primera incidencia', 'revisada', '2025-01-01', '2025-01-02'),
('Segunda incidencia', 'no revisada', '2025-01-05', NULL),
('Tercera incidencia', 'revisada', '2025-01-10', '2025-01-11'),
('Cuarta incidencia', 'no revisada', '2025-01-12', NULL),
('Quinta incidencia', 'revisada', '2025-01-15', '2025-01-16'),
('Sexta incidencia', 'no revisada', '2025-01-18', NULL),
('Séptima incidencia', 'revisada', '2025-01-20', '2025-01-21');



--
-- Indices de la tabla `usuario`
--

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alerta`
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada usuario', AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alerta`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



ALTER TABLE `usuario`
ADD COLUMN `failed_attempts` INT DEFAULT 0, 
ADD COLUMN `is_locked` TINYINT(1) DEFAULT 0; 

ALTER TABLE `usuario`
ADD COLUMN `created_at` DATETIME NULL;


ALTER TABLE `usuario`
MODIFY COLUMN `failed_attempts` INT DEFAULT 0;

ALTER TABLE `usuario`
ADD COLUMN `updated_at` DATETIME NULL;




ALTER TABLE `incidencias`
ADD COLUMN `respuesta` TEXT NULL;



ALTER TABLE `incidencias` MODIFY COLUMN `respuesta` TEXT NULL;




CREATE TABLE `notificacion` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO `notificacion` (usuario_id, mensaje, fecha) VALUES
(1, 'Alerta: El servidor principal ha superado el límite de uso de CPU.', '2025-02-09 09:00:00'),
(1, 'Alerta crítica: Fallo en la conexión con el servicio de base de datos.', '2025-02-08 18:30:00'),
(2, 'Advertencia: Espacio de almacenamiento disponible al 90%.', '2025-02-07 15:45:00'),
(2, 'Alerta: Se detectó un acceso no autorizado en el sistema.', '2025-02-06 12:20:00'),
(3, 'Aviso: Reinicio programado del servidor para mantenimiento.', '2025-02-05 08:10:00'),
(1, 'Notificación: Los backups automáticos se completaron exitosamente.', '2025-02-04 14:50:00');


CREATE TABLE `Alertas_Creados` (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Fecha_de_Vencimiento DATE,
    Acciones VARCHAR(255)
);


INSERT INTO `Alertas_Creados` (Titulo, Descripcion, Fecha_de_Vencimiento, Acciones)
VALUES 
('Alerta 1', 'Primera descripción de alerta', '2025-03-01', 'Eliminar'),
('Alerta 2', 'Segunda descripción de alerta', '2025-03-05', 'Eliminar'),
('Alerta 3', 'Tercera descripción de alerta', '2025-02-20', 'Eliminar'),
('Alerta 4', 'Cuarta descripción de alerta', '2025-04-10', 'Eliminar'),
('Alerta 5', 'Quinta descripción de alerta', '2025-05-15', 'Eliminar');



ALTER TABLE `usuario` ADD COLUMN `estado_revisar` VARCHAR(20) DEFAULT 'no revisada';

ALTER TABLE `usuario` ADD COLUMN `respuesta` VARCHAR(255) DEFAULT NULL;

ALTER TABLE `usuario` ADD COLUMN `eliminar_razon` TEXT NULL;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
