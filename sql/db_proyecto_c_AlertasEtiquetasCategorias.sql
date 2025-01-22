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
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `id` int(11) NOT NULL COMMENT 'ID único para cada alerta',
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la alerta',
  `descripcion` text NOT NULL COMMENT 'Descripción de la alerta',
  `id_etiqueta` int(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
