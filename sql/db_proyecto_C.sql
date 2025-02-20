-- --------------------------------------------------------------------------
-- Script de base de datos de Alertas de tu ciudad
-- Yii Framework - Proyecto C
-- (c) DAW2 - EPSZ - Universidad de Salamanca
-- --------------------------------------------------------------------------


SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
DROP DATABASE IF EXISTS `proyecto_C`;

CREATE DATABASE IF NOT EXISTS `proyecto_C` CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

USE `proyecto_C`;

-- --------------------------------------------------------
-- TABLA: USUARIO
-- --------------------------------------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
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
    phone VARCHAR(15) DEFAULT NULL COMMENT 'Número de teléfono del usuario'
    status TINYINT(1) DEFAULT 0 COMMENT 'Estado del usuario'
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: USUARIO
-- --------------------------------------------------------
INSERT INTO `usuario` (`id`, `email`, `password`, `auth_key`, `nick`, `username`, `register_date`, `confirmed`, `role`, `attempts`, `locked`) VALUES
    (3, 'dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', 'djPiri', '2025-01-14 12:37:44', 1, '', 0, 0);

-- --------------------------------------------------------
-- Tabla: `area`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `area`;

CREATE TABLE `area` (
  `id` INT AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL,
  `parent_id` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`parent_id`) REFERENCES `area`(`id`) ON DELETE
  SET
    NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `lugar`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `lugar`;

CREATE TABLE `lugar` (
  `id` INT AUTO_INCREMENT,
  `direccion` VARCHAR(255) NOT NULL,
  `notas` TEXT,
  `area_id` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`area_id`) REFERENCES `area`(`id`) ON DELETE
  SET
    NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `alerta`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `alerta`;

CREATE TABLE `alerta` (
  `id` INT AUTO_INCREMENT,
  `titulo` VARCHAR(255) NOT NULL,
  `descripcion` TEXT NOT NULL,
  `fecha_inicio` DATETIME NOT NULL,
  `duracion_estimada` INT,
  `id_lugar` INT,
  `detalles` TEXT,
  `notas` TEXT,
  `url_externa` TEXT,
  `estado` VARCHAR(50) NOT NULL,
  `id_usuario` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_lugar`) REFERENCES `lugar`(`id`) ON DELETE
  SET
    NULL,
    FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `comentario`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `comentario`;

CREATE TABLE `comentario` (
  `id` INT AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `id_alerta` INT NOT NULL,
  `id_usuario` INT NOT NULL,
  `estado_cierre` TINYINT DEFAULT 0,
  `num_denuncias` INT DEFAULT 0,
  `bloqueado` BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_alerta`) REFERENCES `alerta`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `etiqueta`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `etiqueta`;

CREATE TABLE `etiqueta` (
  `id` INT AUTO_INCREMENT,
  `nombre` VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `alerta_etiqueta`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `alerta_etiqueta`;

CREATE TABLE `alerta_etiqueta` (
  `id_alerta` INT,
  `id_etiqueta` INT,
  PRIMARY KEY (`id_alerta`, `id_etiqueta`),
  FOREIGN KEY (`id_alerta`) REFERENCES `alerta`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_etiqueta`) REFERENCES `etiqueta`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

-- --------------------------------------------------------
-- Tabla: `incidencia`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `incidencia`;

CREATE TABLE `incidencia` (
  `id` INT AUTO_INCREMENT,
  `texto` TEXT NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_alerta` INT,
  `id_comentario` INT,
  `fecha_lectura` DATETIME,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuario`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`id_alerta`) REFERENCES `alerta`(`id`) ON DELETE
  SET
    NULL,
    FOREIGN KEY (`id_comentario`) REFERENCES `comentario`(`id`) ON DELETE
  SET
    NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

COMMIT;