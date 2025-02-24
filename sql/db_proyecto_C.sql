-- --------------------------------------------------------------------------
-- Script de base de datos de Alertas de tu ciudad
-- Yii Framework - Proyecto C
-- (c) DAW2 - EPSZ - Universidad de Salamanca
-- --------------------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------------------------
-- CREACIÓN DE LA BASE DE DATOS "proyecto_C"
-- --------------------------------------------------------------------------
DROP DATABASE IF EXISTS `proyecto_C`;
CREATE DATABASE IF NOT EXISTS `proyecto_C` CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_general_ci';
USE `proyecto_C`;

-- --------------------------------------------------------------------------
-- Tabla: ETIQUETAS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT DEFAULT NULL,
    `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `actualizado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `etiquetas` (`nombre`, `descripcion`) VALUES
    ('Accidente de tráfico', 'Colisiones y siniestros en la vía pública.'),
    ('Manifestación', 'Concentraciones de personas que pueden alterar la circulación.'),
    ('Incendio', 'Incendios en zonas urbanas o rurales.'),
    ('Fallo eléctrico', 'Cortes de luz o problemas en la red eléctrica.'),
    ('Inundación', 'Desbordamientos de ríos o acumulaciones de agua tras lluvias intensas.'),
    ('Niebla densa', 'Reducción de visibilidad en carreteras y zonas urbanas.'),
    ('Derrumbe', 'Colapso de estructuras o deslizamientos de tierra.'),
    ('Hielo en calzadas', 'Peligro en la circulación debido a capas de hielo.'),
    ('Fuerte granizo', 'Tormentas de granizo que pueden causar daños materiales.'),
    ('Fuga de gas', 'Escapes de gas en infraestructuras o domicilios.'),
    ('Corte de agua', 'Interrupción del suministro de agua potable.'),
    ('Ola de calor', 'Temperaturas extremadamente altas con riesgo para la salud.'),
    ('Tormenta eléctrica', 'Riesgo de rayos y cortes eléctricos.'),
    ('Contaminación del aire', 'Alta concentración de contaminantes en el aire.'),
    ('Emergencia sanitaria', 'Alertas sobre brotes de enfermedades o pandemias.'),
    ('Viento extremo', 'Rachas de viento muy fuertes que pueden causar daños.'),
    ('Deslizamiento de tierra', 'Derrumbes o movimientos del suelo en zonas de riesgo.'),
    ('Cierre de túnel', 'Túneles cerrados por mantenimiento o incidentes.'),
    ('Accidente ferroviario', 'Incidentes en redes de tren o metro.'),
    ('Alerta nuclear', 'Incidente o fuga en instalaciones nucleares.'),
    ('Desabastecimiento', 'Escasez de bienes esenciales como alimentos o combustible.'),
    ('Crisis energética', 'Riesgos de apagones prolongados o racionamiento de energía.'),
    ('Robo masivo', 'Olas de saqueos o delitos organizados en ciudades.'),
    ('Tsunami', 'Olas gigantes generadas por terremotos o erupciones volcánicas.'),
    ('Explosión urbana', 'Explosiones en entornos urbanos por gas o materiales peligrosos.'),
    ('Corte de comunicaciones', 'Interrupción de redes móviles o de internet.'),
    ('Emergencia química', 'Derrames o contaminación por sustancias químicas peligrosas.'),
    ('Riesgo volcánico', 'Actividad sísmica que indica posible erupción volcánica.'),
    ('Cierre de aeropuerto', 'Interrupción de vuelos debido a emergencias climáticas o técnicas.'),
    ('Tormenta de nieve', 'Nieve intensa que afecta infraestructuras y transporte.'),
    ('Emergencia en presa', 'Riesgo de colapso o desbordamiento de una presa.');



-- --------------------------------------------------------------------------
-- Tabla: USUARIO - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada usuario',
    `email` VARCHAR(255) NOT NULL UNIQUE COMMENT 'Correo electrónico único del usuario',
    `password` VARCHAR(255) NOT NULL COMMENT 'Contraseña encriptada del usuario',
    `auth_key` VARCHAR(255) DEFAULT NULL COMMENT 'Clave de autenticación',
    `nick` VARCHAR(100) NOT NULL COMMENT 'Apodo o nombre de usuario',
    `username` VARCHAR(100) NOT NULL COMMENT 'Nombre de usuario',
    `register_date` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro del usuario',
    `confirmed` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el usuario ha confirmado su registro',
    `role` ENUM('guest','usuario','moderator','admin','sysadmin') DEFAULT 'usuario' COMMENT 'Rol del usuario en el sistema',
    `attempts` INT(11) DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
    `locked` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el usuario está bloqueado',
    `phone` VARCHAR(15) DEFAULT NULL COMMENT 'Número de teléfono del usuario',
    `status` TINYINT(1) DEFAULT 0 COMMENT 'Estado del usuario',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuario` (`id`, `email`, `password`, `auth_key`, `nick`, `username`, `register_date`, `confirmed`, `role`, `attempts`, `locked`) VALUES
    (3, 'dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', 'djPiri', '2025-01-14 12:37:44', 1, 'usuario', 0, 0),
    (2, 'admin@domain.com', '$2y$13$Y3wzjJgRH5GqtpR3uN1qru0nmMEhDJ.8aE5Xoi0BvZQe7G5uBxM3G', NULL, 'admin', 'admin', '2025-02-20 08:00:00', 1, 'admin', 0, 0);



-- --------------------------------------------------------------------------
-- Tabla: COMENTARIOS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único del comentario',
    `contenido` TEXT NOT NULL COMMENT 'Contenido del comentario',
    `numero_denuncias` INT(11) DEFAULT 0 COMMENT 'Número de veces que el comentario ha sido denunciado',
    `es_denunciado` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el comentario ha sido marcado como denunciado',
    `es_visible` TINYINT(1) DEFAULT 1 COMMENT 'Indica si el comentario es visible para los usuarios',
    `es_cerrado` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el comentario ha sido cerrado por un moderador',
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del comentario',
    `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha y hora de la última actualización',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `comentarios` (`contenido`, `numero_denuncias`, `es_denunciado`, `es_visible`, `es_cerrado`) VALUES
    ('Primer comentario de prueba', 0, 0, 1, 0),
    ('Segundo comentario denunciado', 2, 1, 1, 0),
    ('Tercer comentario bloqueado', 0, 0, 0, 0),
    ('Cuarto comentario cerrado', 0, 0, 1, 1),
    ('Quinto comentario activo', 1, 0, 1, 0);



-- --------------------------------------------------------------------------
-- Tabla: INCIDENCIA - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `incidencia`;
CREATE TABLE IF NOT EXISTS `incidencia` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la incidencia',
    `titulo` VARCHAR(255) NOT NULL COMMENT 'Título de la incidencia',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción detallada de la incidencia',
    `fecha_creacion` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la incidencia',
    `fecha_revision` DATETIME DEFAULT NULL COMMENT 'Fecha y hora de la revisión de la incidencia',
    `estado` ENUM('pendiente', 'procesada') DEFAULT 'pendiente' COMMENT 'Estado actual de la incidencia',
    `prioridad` ENUM('alta', 'media', 'baja') DEFAULT 'media' COMMENT 'Nivel de prioridad de la incidencia',
    `respuesta` TEXT DEFAULT NULL COMMENT 'Respuesta dada a la incidencia una vez revisada',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `incidencia` (`titulo`, `descripcion`, `fecha_creacion`, `fecha_revision`, `estado`, `prioridad`, `respuesta`) VALUES
    ('Error de conexión', 'No se puede conectar al servidor de la base de datos.', '2025-01-23 10:00:00', NULL, 'pendiente', 'alta', NULL),
    ('API no responde', 'La API devuelve un error 500 al intentar obtener datos.', '2025-01-23 11:00:00', NULL, 'pendiente', 'media', NULL),
    ('Problema de inicio de sesión', 'Usuarios reportan que no pueden iniciar sesión.', '2025-01-23 12:00:00', NULL, 'pendiente', 'media', NULL),
    ('Carga lenta del sistema', 'El sistema tarda más de lo esperado en cargar datos.', '2025-01-23 13:00:00', NULL, 'pendiente', 'baja', NULL),
    ('Error desconocido en el servidor', 'Se produjo un error inesperado en el servidor.', '2025-01-23 14:00:00', NULL, 'pendiente', 'alta', NULL);



-- --------------------------------------------------------------------------
-- Tabla: UBICACION - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE `ubicacion` (
    `id` INT(12) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la ubicación',
    `ub_code` TINYINT(2) NOT NULL COMMENT 'Código de clase de ubicación: 1=Continente, 2=País, 3=Comunidad Autónoma, 4=Provincia, 6=Localidad, 7=Barrio/Zona',
    `nombre` VARCHAR(50) NOT NULL COMMENT 'Nombre de la ubicación',
    `code_iso` VARCHAR(10) DEFAULT NULL COMMENT 'Código internacional de país/estado si aplica',
    `ub_code_padre` INT(12) DEFAULT NULL COMMENT 'ID de la ubicación padre en la jerarquía',
    PRIMARY KEY (`id`),
    KEY `ub_code_padre` (`ub_code_padre`),
    CONSTRAINT `fk_ubicacion_padre` FOREIGN KEY (`ub_code_padre`) REFERENCES `ubicacion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ubicacion` (`id`, `ub_code`, `nombre`, `code_iso`, `ub_code_padre`) VALUES
    (0, 1, 'Tierra', NULL, NULL),
    (1, 1, 'Europa', 'EU', 0),
    (2, 2, 'España', 'ES', 1),
    (3, 3, 'Andalucía', 'ES-AN', 2),
    (4, 3, 'Aragón', 'ES-AR', 2),
    (5, 3, 'Asturias', 'ES-AS', 2),
    (6, 3, 'Islas Baleares', 'ES-IB', 2),
    (7, 3, 'Canarias', 'ES-CN', 2),
    (8, 3, 'Cantabria', 'ES-CB', 2),
    (9, 3, 'Castilla-La Mancha', 'ES-CM', 2),
    (10, 3, 'Castilla y León', 'ES-CL', 2),
    (11, 3, 'Cataluña', 'ES-CT', 2),
    (12, 3, 'Extremadura', 'ES-EX', 2),
    (13, 3, 'Galicia', 'ES-GA', 2),
    (14, 3, 'Madrid', 'ES-MD', 2),
    (15, 3, 'Murcia', 'ES-MC', 2),
    (16, 3, 'Navarra', 'ES-NC', 2),
    (17, 3, 'La Rioja', 'ES-RI', 2),
    (18, 3, 'País Vasco', 'ES-PV', 2),
    (19, 3, 'Comunidad Valenciana', 'ES-VC', 2),
    (20, 3, 'Ceuta', 'ES-CE', 2),
    (21, 3, 'Melilla', 'ES-ML', 2),
    (22, 4, 'Ávila', 'ES-AV', 10),
    (23, 4, 'Burgos', 'ES-BU', 10),
    (24, 4, 'León', 'ES-LE', 10),
    (25, 4, 'Palencia', 'ES-P', 10),
    (26, 4, 'Salamanca', 'ES-SA', 10),
    (27, 4, 'Segovia', 'ES-SG', 10),
    (28, 4, 'Soria', 'ES-SO', 10),
    (29, 4, 'Valladolid', 'ES-VA', 10),
    (30, 4, 'Zamora', 'ES-ZA', 10),
    (31, 6, 'Salamanca', 'ES-SA-SAL', 26),
    (32, 6, 'Béjar', 'ES-SA-BEJ', 26),
    (33, 6, 'Ciudad Rodrigo', 'ES-SA-CRO', 26),
    (34, 6, 'Vitigudino', 'ES-SA-VIT', 26),
    (35, 6, 'Peñaranda de Bracamonte', 'ES-SA-PEN', 26),
    (36, 6, 'Zamora', 'ES-ZA-ZAM', 30),
    (37, 6, 'Benavente', 'ES-ZA-BEN', 30),
    (38, 6, 'Toro', 'ES-ZA-TOR', 30),
    (39, 6, 'Fuentesaúco', 'ES-ZA-FUE', 30),
    (40, 6, 'Alcañices', 'ES-ZA-ALC', 30),
    -- Barrios Salamanca
    (41, 7, 'Plaza Mayor', NULL, 31),
    (42, 7, 'Garrido', NULL, 31),
    (43, 7, 'Cementerio', NULL, 31),
    (44, 7, 'Pizarrales', NULL, 31),
    (45, 7, 'San José', NULL, 31),
    -- Barrios Zamora
    (46, 7, 'Casco Antiguo', NULL, 36),
    (47, 7, 'San Lázaro', NULL, 36),
    (48, 7, 'San José Obrero', NULL, 36),
    (49, 7, 'Pinilla', NULL, 36),
    (50, 7, 'Los Bloques', NULL, 36),
    (51, 7, 'La Candelaria', NULL, 36),
    (52, 7, 'Cabañales', NULL, 36),
    (53, 7, 'Pantoja', NULL, 36),
    (54, 7, 'San Frontis', NULL, 36),
    (55, 7, 'Las Viñas', NULL, 36),
    (56, 7, 'San Isidro', NULL, 36),
    (57, 7, 'Vista Alegre', NULL, 36),
    (58, 7, 'Otero', NULL, 36),
    (59, 7, 'Siglo XXI', NULL, 36),
    (60, 7, 'Tres Cruces', NULL, 36),
    (61, 7, 'Alto de los Curas', NULL, 36),
    (62, 7, 'Peña Trevinca', NULL, 36),
    (63, 7, 'La Vaguada', NULL, 36),
    (64, 7, 'Los Almendros', NULL, 36),
    (65, 7, 'Candelaria', NULL, 36),
    (66, 7, 'San Blas', NULL, 36),
    (67, 7, 'San José', NULL, 36),
    (68, 7, 'Villagodio', NULL, 36),
    (69, 7, 'Rabiche', NULL, 36);



-- --------------------------------------------------------------------------
-- Tabla: CATEGORIAS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(255) NOT NULL,
    `descripcion` TEXT DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`nombre`, `descripcion`) VALUES
('Tráfico', 'Eventos relacionados con accidentes, manifestaciones y condiciones viales.'),
('Clima', 'Alertas meteorológicas como tormentas, temperaturas extremas y desastres naturales.'),
('Emergencias', 'Situaciones de crisis como incendios, terremotos y fallos en servicios esenciales.'),
('Seguridad', 'Incidentes de seguridad pública como robos, atentados o fugas de gas.'),
('Infraestructura', 'Eventos que afectan infraestructuras críticas como cortes de agua, luz o aeropuertos.');


-- --------------------------------------------------------------------------
-- Tabla: ALERTAS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `alertas`;
CREATE TABLE IF NOT EXISTS `alertas` (
     `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta',
    `titulo` VARCHAR(255) NOT NULL COMMENT 'Título de la alerta',
    `descripcion` TEXT NOT NULL COMMENT 'Descripción detallada de la alerta',
    `id_etiqueta` INT(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada con la alerta',
    `id_categoria` INT(11) DEFAULT NULL COMMENT 'ID de la categoria relacionada',
    `estado` ENUM('pendiente', 'completado') DEFAULT 'pendiente' COMMENT 'Estado actual de la alerta',
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la alerta',
    `fecha_expiracion` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora de expiración de la alerta',
    `completado_en` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora en la que se completó la alerta',
    `usuario_id` INT(11) DEFAULT NULL COMMENT 'ID del usuario que publicó la alerta',
    `id_ubicacion` INT(11) NULL COMMENT 'Referencia a la tabla ubicacion',
    PRIMARY KEY (`id`),
    KEY `id_etiqueta` (`id_etiqueta`),
    KEY `id_ubicacion` (`id_ubicacion`),
    CONSTRAINT `alertas_fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
    CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL,
    CONSTRAINT `alertas_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `alertas` (`titulo`, `descripcion`, `id_etiqueta`, `estado`, `fecha_expiracion`, `usuario_id`, `id_ubicacion`) VALUES
    ('Tormenta severa en Tierra', 'Fuertes vientos y lluvias afectan grandes áreas.', 12, 'pendiente', '2025-03-01 10:00:00', NULL, 0),
    ('Actividad sísmica inusual', 'Se detecta un aumento en la actividad sísmica global.', 28, 'pendiente', '2025-03-02 12:00:00', NULL, 0),
    ('Nevada intensa en Europa', 'Acumulaciones de nieve superiores a 50 cm en varias regiones.', 31, 'pendiente', '2025-03-03 14:00:00', NULL, 1),
    ('Ola de calor en Europa', 'Temperaturas extremas ponen en riesgo la salud de la población.', 12, 'pendiente', '2025-03-04 18:00:00', NULL, 1),
    ('Inundaciones en España', 'Ríos desbordados causan cortes de carreteras y evacuaciones.', 5, 'pendiente', '2025-03-05 20:00:00', NULL, 2),
    ('Fallo eléctrico en España', 'Apagón masivo afecta a varias ciudades y zonas rurales.', 4, 'pendiente', '2025-03-06 21:00:00', NULL, 2),
    ('Incendio en Andalucía', 'Un gran incendio forestal amenaza viviendas en la región.', 3, 'pendiente', '2025-03-07 15:00:00', NULL, 3),
    ('Vientos fuertes en Andalucía', 'Rachas de viento de hasta 100 km/h generan riesgo de caída de árboles.', 17, 'pendiente', '2025-03-08 10:00:00', NULL, 3),
    ('Nevadas en Aragón', 'Acumulación de nieve bloquea carreteras en la región.', 31, 'pendiente', '2025-03-09 08:00:00', NULL, 4),
    ('Inundaciones en Aragón', 'Fuertes lluvias provocan desbordamientos de ríos.', 5, 'pendiente', '2025-03-10 11:00:00', NULL, 4),
    ('Accidente de tráfico en Asturias', 'Colisión múltiple en la autopista A-8.', 1, 'pendiente', '2025-03-11 13:00:00', NULL, 5),
    ('Fuga de gas en Asturias', 'Evacuaciones en un barrio debido a una fuga de gas.', 10, 'pendiente', '2025-03-12 16:00:00', NULL, 5),
    ('Temporal en Islas Baleares', 'Vientos huracanados y fuertes lluvias afectan la región.', 12, 'pendiente', '2025-03-13 18:00:00', NULL, 6),
    ('Corte eléctrico en Islas Baleares', 'Apagón masivo en varias localidades.', 4, 'pendiente', '2025-03-14 20:00:00', NULL, 6),
    ('Mareas altas en Canarias', 'Oleaje extremo pone en riesgo las zonas costeras.', 5, 'pendiente', '2025-03-15 09:00:00', NULL, 7),
    ('Emergencia volcánica en Canarias', 'Actividad volcánica detectada en la isla.', 28, 'pendiente', '2025-03-16 22:00:00', NULL, 7),
    ('Cierre de carreteras en Cantabria', 'Derrumbes bloquean varias vías.', 7, 'pendiente', '2025-03-17 06:00:00', NULL, 8),
    ('Contaminación del aire en Cantabria', 'Niveles altos de polución registrados.', 14, 'pendiente', '2025-03-18 14:00:00', NULL, 8),
    ('Ola de calor en Extremadura', 'Temperaturas por encima de los 45°C afectan la región.', 12, 'pendiente', '2025-03-23 14:00:00', NULL, 12),
    ('Incendio forestal en Extremadura', 'Un incendio de gran magnitud avanza hacia zonas residenciales.', 3, 'pendiente', '2025-03-24 17:00:00', NULL, 12),
    ('Temporal en Galicia', 'Lluvias intensas y fuertes vientos afectan la comunidad.', 12, 'pendiente', '2025-03-25 09:00:00', NULL, 13),
    ('Marea alta en Galicia', 'Oleaje extremo pone en riesgo los puertos de la región.', 5, 'pendiente', '2025-03-26 11:00:00', NULL, 13),
    ('Manifestación en Madrid', 'Gran protesta en el centro de la ciudad afecta la movilidad.', 2, 'pendiente', '2025-03-27 16:00:00', NULL, 14),
    ('Accidente vial en Madrid', 'Colisión múltiple en la M-30 con tráfico detenido.', 1, 'pendiente', '2025-03-28 08:00:00', NULL, 14),
    ('Terremoto en Murcia', 'Sismo de magnitud 5.2 se siente en varias localidades.', 28, 'pendiente', '2025-03-29 22:00:00', NULL, 15),
    ('Corte eléctrico en Murcia', 'Interrupción del suministro eléctrico en varios distritos.', 4, 'pendiente', '2025-03-30 12:00:00', NULL, 15),
    ('Granizada en Navarra', 'Fuertes precipitaciones de granizo causan daños en viviendas.', 9, 'pendiente', '2025-03-31 15:00:00', NULL, 16),
    ('Fuga de gas en Navarra', 'Evacuación de edificios por una fuga de gas en el centro.', 10, 'pendiente', '2025-04-01 18:00:00', NULL, 16),
    ('Tornado en La Rioja', 'Vientos extremadamente fuertes generan daños en la ciudad.', 17, 'pendiente', '2025-04-02 14:00:00', NULL, 17),
    ('Derrumbe en La Rioja', 'Colapso de un edificio deja varias personas atrapadas.', 7, 'pendiente', '2025-04-03 10:00:00', NULL, 17),
    ('Explosión en el País Vasco', 'Una fuerte explosión sacude una zona industrial.', 26, 'pendiente', '2025-04-04 20:00:00', NULL, 18),
    ('Corte de comunicaciones en el País Vasco', 'Interrupción total de telefonía e internet en varias ciudades.', 25, 'pendiente', '2025-04-05 07:00:00', NULL, 18),
    ('Robo masivo en la Comunidad Valenciana', 'Varias tiendas saqueadas en una ola de robos nocturnos.', 23, 'pendiente', '2025-04-06 02:00:00', NULL, 19),
    ('Tsunami en la Comunidad Valenciana', 'Alerta por posible tsunami tras un fuerte terremoto en el mar.', 24, 'pendiente', '2025-04-07 19:00:00', NULL, 19),
    ('Emergencia sanitaria en Ceuta', 'Brote de enfermedad infecciosa detectado en la ciudad.', 15, 'pendiente', '2025-04-08 12:00:00', NULL, 20),
    ('Cierre de aeropuerto en Ceuta', 'Cancelaciones masivas de vuelos debido a condiciones meteorológicas.', 29, 'pendiente', '2025-04-09 06:00:00', NULL, 20),
    ('Cierre de puerto en Melilla', 'Fuerte oleaje obliga a la suspensión de ferris y tráfico marítimo.', 5, 'pendiente', '2025-04-10 15:00:00', NULL, 21),
    ('Fallo energético en Melilla', 'Cortes de luz intermitentes afectan el funcionamiento de la ciudad.', 22, 'pendiente', '2025-04-11 08:00:00', NULL, 21),
    ('Incendio en Salamanca', 'Un incendio afecta una zona industrial con riesgo de propagación.', 3, 'pendiente', '2025-04-12 14:00:00', NULL, 26),
    ('Corte de agua en Salamanca', 'Mantenimiento programado interrumpe el suministro de agua potable.', 10, 'pendiente', '2025-04-13 08:00:00', NULL, 26),
    ('Manifestación en Plaza Mayor', 'Protesta pacífica en el centro de la ciudad afecta la movilidad.', 2, 'pendiente', '2025-04-14 11:00:00', NULL, 41),
    ('Fuga de gas en Garrido', 'Evacuación de varios edificios por escape de gas en una tubería principal.', 10, 'pendiente', '2025-04-15 16:00:00', NULL, 42),
    ('Accidente de tráfico en Cementerio', 'Colisión múltiple en la avenida principal con varios heridos.', 1, 'pendiente', '2025-04-16 09:00:00', NULL, 43),
    ('Robo en Pizarrales', 'Asalto en un comercio con enfrentamiento policial.', 23, 'pendiente', '2025-04-17 22:00:00', NULL, 44),
    ('Corte eléctrico en San José', 'Fallo en la red eléctrica deja sin luz a varios hogares.', 4, 'pendiente', '2025-04-18 07:00:00', NULL, 45),
    ('Oleaje extremo en Zamora', 'Riesgo de inundaciones en zonas cercanas al río.', 5, 'pendiente', '2025-04-19 13:00:00', NULL, 30),
    ('Emergencia química en Casco Antiguo', 'Derrame de sustancias peligrosas en un almacén industrial.', 27, 'pendiente', '2025-04-20 15:00:00', NULL, 46),
    ('Desperfectos por tormenta en San Lázaro', 'Fuertes lluvias causan daños en infraestructuras.', 12, 'pendiente', '2025-04-21 17:00:00', NULL, 47),
    ('Explosión en San José Obrero', 'Una fuga de gas provoca una explosión en un edificio residencial.', 26, 'pendiente', '2025-04-22 19:00:00', NULL, 48),
    ('Corte de comunicaciones en Pinilla', 'Interrupción del servicio de telefonía e internet en la zona.', 25, 'pendiente', '2025-04-23 08:00:00', NULL, 49),
    ('Derrumbe en Los Bloques', 'Colapso de una estructura antigua deja atrapadas a varias personas.', 7, 'pendiente', '2025-04-24 12:00:00', NULL, 50),
    ('Inundaciones en La Candelaria', 'Fuertes lluvias causan desbordamiento del alcantarillado.', 5, 'pendiente', '2025-04-25 14:00:00', NULL, 51),
    ('Emergencia sanitaria en Cabañales', 'Se reporta un brote de virus estomacal en la comunidad.', 15, 'pendiente', '2025-04-26 10:00:00', NULL, 52),
    ('Fallo energético en Pantoja', 'Corte de electricidad afecta a toda la comunidad.', 22, 'pendiente', '2025-04-27 06:00:00', NULL, 53),
    ('Oleada de robos en San Frontis', 'Incremento de asaltos en comercios locales.', 23, 'pendiente', '2025-04-28 02:00:00', NULL, 54),
    ('Granizada en Las Viñas', 'Tormenta de granizo daña vehículos y tejados.', 9, 'pendiente', '2025-04-29 18:00:00', NULL, 55),
    ('Tornado en San Isidro', 'Rachas de viento extremadamente fuertes causan daños estructurales.', 17, 'pendiente', '2025-04-30 21:00:00', NULL, 56);



-- --------------------------------------------------------------------------
-- Tabla: CONFIGURATIONS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `configurations`;
CREATE TABLE IF NOT EXISTS `configurations` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada configuración',
    `key_name` VARCHAR(100) NOT NULL COMMENT 'Clave única de la configuración (ejemplo: "site_title")',
    `value` TEXT NOT NULL COMMENT 'Valor de la configuración (ejemplo: "Mi Aplicación")',
    `description` TEXT DEFAULT NULL COMMENT 'Descripción de la configuración',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha y hora de la última actualización',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `configurations` (`key_name`, `value`, `description`) VALUES
    ('pagination_size', '10', 'Número de elementos por página');



-- --------------------------------------------------------------------------
-- Tabla: BACKUPS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada archivo de respaldo',
    `file_name` VARCHAR(255) NOT NULL COMMENT 'Nombre del archivo de respaldo',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del respaldo',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



-- --------------------------------------------------------------------------
-- Tabla: CATEGORIA_ETIQUETA - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `categoria_etiqueta`;
CREATE TABLE `categoria_etiqueta` (
    `id_categoria` INT(11) NOT NULL,
    `id_etiqueta` INT(11) NOT NULL,
    PRIMARY KEY (`id_categoria`,`id_etiqueta`),
    KEY `id_etiqueta` (`id_etiqueta`),
    CONSTRAINT `categoria_etiqueta_fk1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
    CONSTRAINT `categoria_etiqueta_fk2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categoria_etiqueta` (`id_categoria`, `id_etiqueta`) VALUES
    (1, 3),
    (1, 4),
    (3, 5);



SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
