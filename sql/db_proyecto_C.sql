-- --------------------------------------------------------------------------
-- Esquema de la Base de Datos para un sistema de gestión de usuarios
-- --------------------------------------------------------------------------
SET
  FOREIGN_KEY_CHECKS = 0;

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET
  time_zone = "+00:00";

SET
  AUTOCOMMIT = 0;

START TRANSACTION;

-- --------------------------------------------------------
-- Base de datos: `daw_proyecto_C`
-- --------------------------------------------------------
DROP DATABASE IF EXISTS `proyecto_C`;

CREATE DATABASE IF NOT EXISTS `proyecto_C` CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

USE `proyecto_C`;

-- --------------------------------------------------------
-- Tabla: `usuario`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `usuario`;

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT AUTO_INCREMENT COMMENT 'ID único para cada usuario',
  `email` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Correo electrónico único del usuario',
  `password` VARCHAR(255) NOT NULL COMMENT 'Contraseña encriptada del usuario',
  `nick` VARCHAR(100) NOT NULL COMMENT 'Apodo o nombre de usuario',
  `register_date` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro del usuario',
  `confirmed` BOOLEAN DEFAULT FALSE COMMENT 'Indica si el usuario ha confirmado su registro',
  `role` ENUM(
    'guest',
    'normal',
    'moderator',
    'admin',
    'sysadmin'
  ) DEFAULT 'normal' COMMENT 'Rol del usuario en el sistema',
  `attempts` INT DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
  `locked` BOOLEAN DEFAULT FALSE COMMENT 'Indica si el usuario está bloqueado',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

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