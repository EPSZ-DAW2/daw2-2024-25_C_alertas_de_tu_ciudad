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

CREATE TABLE `alerta` (
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

CREATE TABLE `usuario` (
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
(7, 'mem@usal.es', '$2y$13$hqt.XD489dM.v9JGloiNLeyE.W4B1fqkFQ26pXWAcN4WtHyc354KW', 'RUwSX2LdFVBK0tx0mDsT0ZbBhUQla5v8', 'mem1', '2025-01-15 19:39:22', 1, 'normal', 0, 0);

--
-- Índices para tablas volcadas
--

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada usuario', AUTO_INCREMENT=8;

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
