-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2025 a las 12:23:40
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta`
--
DROP TABLE IF EXISTS `alerta`;
CREATE TABLE IF NOT EXISTS `alerta`(
  `id` int(11) NOT NULL COMMENT 'ID único de la alerta',
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la alerta',
  `descripcion` text NOT NULL COMMENT 'Descripción detallada de la alerta',
  `usuario_id` int(11) NOT NULL COMMENT 'Referencia al usuario creador de la alerta',
  `fecha_creacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha de creación de la alerta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabla para almacenar alertas';

--
-- Volcado de datos para la tabla `alerta`
--

INSERT INTO `alerta` (`id`, `titulo`, `descripcion`, `usuario_id`, `fecha_creacion`) VALUES
(1, 'Alerta de Fisión', 'Homer J. Simpson ha derramado el cafe en el panel de control del reactor.', 7, '2025-01-16 12:07:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario`(
  `id` int(11) NOT NULL COMMENT 'ID único para cada usuario',
  `email` varchar(255) NOT NULL COMMENT 'Correo electrónico único del usuario',
  `password` varchar(255) NOT NULL COMMENT 'Contraseña encriptada del usuario',
  `auth_key` varchar(255) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `register_date` datetime DEFAULT current_timestamp() COMMENT 'Fecha de registro del usuario',
  `confirmed` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario ha confirmado su registro',
  `role` enum('guest','normal','moderator','admin','sysadmin') DEFAULT 'normal',
  `attempts` int(11) DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
  `locked` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario está bloqueado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `auth_key`, `username`, `register_date`, `confirmed`, `role`, `attempts`, `locked`) VALUES
(3, 'dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', '2025-01-14 12:37:44', 1, 'normal', 0, 0),
(7, 'mem@usal.es', '$2y$13$hqt.XD489dM.v9JGloiNLeyE.W4B1fqkFQ26pXWAcN4WtHyc354KW', 'RUwSX2LdFVBK0tx0mDsT0ZbBhUQla5v8', 'mem1', '2025-01-15 19:39:22', 1, 'normal', 0, 0),
(8, 'moderator@example.com', '$2y$13$MXcf66AJlWJvFKek7WcZxeeGnkILvm/OCniMrPeJGr9Gxei1Cve8i', 'wMHOAxYIHIwbD0B3CpRqjBTM5', 'moderator_user', NOW(), 1, 'moderator', 0, 0),
(9, 'admin@example.com', '$2y$13$MXcf66AJlWJvFKek7WcZxeeGnkILvm/OCniMrPeJGr9Gxei1Cve8i', 'wMHOAxYIHIwbD0B3CpRqjBTM5', 'admin_user', NOW(), 1, 'admin', 0, 0),
(10, 'sysadmin@example.com', '$2y$13$MXcf66AJlWJvFKek7WcZxeeGnkILvm/OCniMrPeJGr9Gxei1Cve8i', 'wMHOAxYIHIwbD0B3CpRqjBTM5', 'sysadmin_user', NOW(), 1, 'sysadmin', 0, 0);

--
-- Índices para tablas volcadas
--


INSERT INTO `incidencias` (`descripcion`, `estado`, `fecha_creacion`, `fecha_revision`) VALUES
('Primera incidencia', 'revisada', '2025-01-01', '2025-01-02'),
('Segunda incidencia', 'no revisada', '2025-01-05', NULL),
('Tercera incidencia', 'revisada', '2025-01-10', '2025-01-11'),
('Cuarta incidencia', 'no revisada', '2025-01-12', NULL),
('Quinta incidencia', 'revisada', '2025-01-15', '2025-01-16'),
('Sexta incidencia', 'no revisada', '2025-01-18', NULL),
('Séptima incidencia', 'revisada', '2025-01-20', '2025-01-21');

--
-- Indices de la tabla `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alerta_usuario` (`usuario_id`);

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
-- AUTO_INCREMENT de la tabla `alerta`
--
ALTER TABLE `alerta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la alerta', AUTO_INCREMENT=2;

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
ALTER TABLE `alerta`
  ADD CONSTRAINT `fk_alerta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



ALTER TABLE usuario
ADD COLUMN failed_attempts INT DEFAULT 0, 
ADD COLUMN is_locked TINYINT(1) DEFAULT 0; 

ALTER TABLE usuario
ADD COLUMN created_at DATETIME NULL;


ALTER TABLE usuario
MODIFY COLUMN failed_attempts INT DEFAULT 0;

ALTER TABLE usuario
ADD COLUMN updated_at DATETIME NULL;


ALTER TABLE usuario
ADD COLUMN is_locked TINYINT(1) DEFAULT 0;

ALTER TABLE usuario ADD COLUMN nick VARCHAR(255) DEFAULT NULL;


ALTER TABLE incidencias MODIFY COLUMN respuesta TEXT NULL;

ALTER TABLE incidencias
ADD COLUMN respuesta TEXT NULL;


CREATE TABLE `incidencia` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,       -- 主键
    `descripcion` TEXT NOT NULL,               -- 事件描述
    `estado` VARCHAR(50) NOT NULL,             -- 状态字段，例如 'nueva', 'revisada'
    `fecha_creacion` DATETIME NOT NULL,        -- 创建时间
    `fecha_revision` DATETIME DEFAULT NULL,    -- 审核时间（可为空）
    `creado_por` INT DEFAULT NULL,             -- 创建者ID
    `revisado_por` INT DEFAULT NULL            -- 审核者ID
);
CREATE TABLE notificacion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO notificacion (usuario_id, mensaje, fecha) VALUES
(1, 'Alerta: El servidor principal ha superado el límite de uso de CPU.', '2025-02-09 09:00:00'),
(1, 'Alerta crítica: Fallo en la conexión con el servicio de base de datos.', '2025-02-08 18:30:00'),
(2, 'Advertencia: Espacio de almacenamiento disponible al 90%.', '2025-02-07 15:45:00'),
(2, 'Alerta: Se detectó un acceso no autorizado en el sistema.', '2025-02-06 12:20:00'),
(3, 'Aviso: Reinicio programado del servidor para mantenimiento.', '2025-02-05 08:10:00'),
(1, 'Notificación: Los backups automáticos se completaron exitosamente.', '2025-02-04 14:50:00');


CREATE TABLE Alertas_Creados (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Titulo VARCHAR(255) NOT NULL,
    Descripcion TEXT,
    Fecha_de_Vencimiento DATE,
    Acciones VARCHAR(255)
);


INSERT INTO Alertas_Creados (Titulo, Descripcion, Fecha_de_Vencimiento, Acciones)
VALUES 
('Alerta 1', 'Primera descripción de alerta', '2025-03-01', 'Eliminar'),
('Alerta 2', 'Segunda descripción de alerta', '2025-03-05', 'Eliminar'),
('Alerta 3', 'Tercera descripción de alerta', '2025-02-20', 'Eliminar'),
('Alerta 4', 'Cuarta descripción de alerta', '2025-04-10', 'Eliminar'),
('Alerta 5', 'Quinta descripción de alerta', '2025-05-15', 'Eliminar');



ALTER TABLE usuario ADD COLUMN estado_revisar VARCHAR(20) DEFAULT 'no revisada';

ALTER TABLE usuario ADD COLUMN respuesta VARCHAR(255) DEFAULT NULL;

ALTER TABLE usuario ADD COLUMN eliminarrazon TEXT NULL;


