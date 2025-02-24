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
-- TABLA: ETIQUETAS
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `etiquetas`;
CREATE TABLE IF NOT EXISTS `etiquetas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada etiqueta',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre de la etiqueta',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción de la etiqueta',
    `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación',
    `actualizado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha y hora de la última actualización',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------------------------
-- TABLA: USUARIO
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

-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: USUARIO
-- --------------------------------------------------------------------------
INSERT INTO `usuario` (`id`, `email`, `password`, `auth_key`, `nick`, `username`, `register_date`, `confirmed`, `role`, `attempts`, `locked`) VALUES
    (3, 'dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', 'djPiri', '2025-01-14 12:37:44', 1, 'usuario', 0, 0),
    (2, 'admin@domain.com', '$2y$13$Y3wzjJgRH5GqtpR3uN1qru0nmMEhDJ.8aE5Xoi0BvZQe7G5uBxM3G', NULL, 'admin', 'admin', '2025-02-20 08:00:00', 1, 'admin', 0, 0);

-- --------------------------------------------------------------------------
-- TABLA: COMENTARIOS
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

-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: COMENTARIOS
-- --------------------------------------------------------------------------
INSERT INTO `comentarios` (`contenido`, `numero_denuncias`, `es_denunciado`, `es_visible`, `es_cerrado`) VALUES
    ('Primer comentario de prueba', 0, 0, 1, 0),
    ('Segundo comentario denunciado', 2, 1, 1, 0),
    ('Tercer comentario bloqueado', 0, 0, 0, 0),
    ('Cuarto comentario cerrado', 0, 0, 1, 1),
    ('Quinto comentario activo', 1, 0, 1, 0);

-- --------------------------------------------------------------------------
-- TABLA: INCIDENCIA
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

-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: INCIDENCIA
-- --------------------------------------------------------------------------
INSERT INTO `incidencia` (`titulo`, `descripcion`, `fecha_creacion`, `fecha_revision`, `estado`, `prioridad`, `respuesta`) VALUES
    ('Error de conexión', 'No se puede conectar al servidor de la base de datos.', '2025-01-23 10:00:00', NULL, 'pendiente', 'alta', NULL),
    ('API no responde', 'La API devuelve un error 500 al intentar obtener datos.', '2025-01-23 11:00:00', NULL, 'pendiente', 'media', NULL),
    ('Problema de inicio de sesión', 'Usuarios reportan que no pueden iniciar sesión.', '2025-01-23 12:00:00', NULL, 'pendiente', 'media', NULL),
    ('Carga lenta del sistema', 'El sistema tarda más de lo esperado en cargar datos.', '2025-01-23 13:00:00', NULL, 'pendiente', 'baja', NULL),
    ('Error desconocido en el servidor', 'Se produjo un error inesperado en el servidor.', '2025-01-23 14:00:00', NULL, 'pendiente', 'alta', NULL);

-- --------------------------------------------------------------------------
-- TABLA: UBICACION
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


-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: UBICACION
-- --------------------------------------------------------------------------

INSERT INTO `ubicacion` (`ub_code`, `nombre`, `code_iso`, `ub_code_padre`) VALUES
    (2, 'España', 'ES', NULL),
    (3, 'Andalucía', 'ES-AN', 1),
    (3, 'Aragón', 'ES-AR', 1),
    (3, 'Asturias', 'ES-AS', 1),
    (3, 'Islas Baleares', 'ES-IB', 1),
    (3, 'Canarias', 'ES-CN', 1),
    (3, 'Cantabria', 'ES-CB', 1),
    (3, 'Castilla-La Mancha', 'ES-CM', 1),
    (3, 'Castilla y León', 'ES-CL', 1),
    (3, 'Cataluña', 'ES-CT', 1),
    (3, 'Extremadura', 'ES-EX', 1),
    (3, 'Galicia', 'ES-GA', 1),
    (3, 'Madrid', 'ES-MD', 1),
    (3, 'Murcia', 'ES-MC', 1),
    (3, 'Navarra', 'ES-NC', 1),
    (3, 'La Rioja', 'ES-RI', 1),
    (3, 'País Vasco', 'ES-PV', 1),
    (3, 'Comunidad Valenciana', 'ES-VC', 1),
    (3, 'Ceuta', 'ES-CE', 1),
    (3, 'Melilla', 'ES-ML', 1),
    (4, 'Ávila', 'ES-AV', 8),
    (4, 'Burgos', 'ES-BU', 8),
    (4, 'León', 'ES-LE', 8),
    (4, 'Palencia', 'ES-P', 8),
    (4, 'Salamanca', 'ES-SA', 8),
    (4, 'Segovia', 'ES-SG', 8),
    (4, 'Soria', 'ES-SO', 8),
    (4, 'Valladolid', 'ES-VA', 8),
    (4, 'Zamora', 'ES-ZA', 8),
    (6, 'Salamanca', 'ES-SA-SAL', 13),
    (6, 'Béjar', 'ES-SA-BEJ', 13),
    (6, 'Ciudad Rodrigo', 'ES-SA-CRO', 13),
    (6, 'Vitigudino', 'ES-SA-VIT', 13),
    (6, 'Peñaranda de Bracamonte', 'ES-SA-PEN', 13),
    (6, 'Zamora', 'ES-ZA-ZAM', 17),
    (6, 'Benavente', 'ES-ZA-BEN', 17),
    (6, 'Toro', 'ES-ZA-TOR', 17),
    (6, 'Fuentesaúco', 'ES-ZA-FUE', 17),
    (6, 'Alcañices', 'ES-ZA-ALC', 17),
    (7, 'Plaza Mayor', NULL, 22),
    (7, 'Garrido', NULL, 22),
    (7, 'Cementerio', NULL, 22),
    (7, 'Pizarrales', NULL, 22),
    (7, 'San José', NULL, 22),
    (7, 'Casco Antiguo', NULL, 27),
    (7, 'San Lázaro', NULL, 27),
    (7, 'San José Obrero', NULL, 27),
    (7, 'Pinilla', NULL, 27),
    (7, 'Los Bloques', NULL, 27),
    (7, 'La Candelaria', NULL, 27),
    (7, 'Cabañales', NULL, 27),
    (7, 'Pantoja', NULL, 27),
    (7, 'San Frontis', NULL, 27),
    (7, 'Las Viñas', NULL, 27),
    (7, 'San Isidro', NULL, 27),
    (7, 'Vista Alegre', NULL, 27),
    (7, 'Otero', NULL, 27),
    (7, 'Siglo XXI', NULL, 27),
    (7, 'Tres Cruces', NULL, 27),
    (7, 'Alto de los Curas', NULL, 27),
    (7, 'Peña Trevinca', NULL, 27),
    (7, 'La Vaguada', NULL, 27),
    (7, 'Los Almendros', NULL, 27),
    (7, 'Candelaria', NULL, 27),
    (7, 'San Blas', NULL, 27),
    (7, 'San José', NULL, 27),
    (7, 'Villagodio', NULL, 27),
    (7, 'Rabiche', NULL, 27);





-- --------------------------------------------------------------------------
-- TABLA: ALERTAS
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `alertas`;
CREATE TABLE IF NOT EXISTS `alertas` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta',
    `titulo` VARCHAR(255) NOT NULL COMMENT 'Título de la alerta',
    `descripcion` TEXT NOT NULL COMMENT 'Descripción detallada de la alerta',
    `id_etiqueta` INT(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada con la alerta',
    `estado` ENUM('pendiente', 'completado') DEFAULT 'pendiente' COMMENT 'Estado actual de la alerta',
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la alerta',
    `fecha_expiracion` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora de expiración de la alerta',
    `completado_en` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora en la que se completó la alerta',
    `usuario_id` INT(11) NOT NULL COMMENT 'ID del usuario que publicó la alerta',
    `id_ubicacion` INT(11) NULL COMMENT 'Referencia a la tabla ubicaciones',
    PRIMARY KEY (`id`),
    KEY `id_etiqueta` (`id_etiqueta`),
    KEY `id_ubicacion` (`id_ubicacion`),
    CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL,
    CONSTRAINT `alertas_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicaciones` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: ALERTAS
-- --------------------------------------------------------------------------
INSERT INTO `alertas` (`titulo`, `descripcion`, `id_etiqueta`, `estado`, `fecha_expiracion`, `usuario_id`, `id_ubicacion`) VALUES
    ('Accidente de tráfico en la M-30', 'Colisión múltiple en la M-30 sentido norte, se recomienda tomar rutas alternativas.', 1, 'pendiente', '2025-02-01 12:00:00', 13, 3),
    ('Manifestación en Plaza Sol', 'Concentración de manifestantes en el centro de Madrid. Posibles cortes de tráfico.', 2, 'pendiente', '2025-02-02 14:00:00', 13, 3),
    ('Incendio en edificio residencial', 'Bomberos trabajando en la extinción de un incendio en el barrio de Arganzuela.', 3, 'pendiente', '2025-02-03 16:00:00', 13, 3),
    ('Fallo en la red eléctrica', 'Varias zonas de la ciudad sin suministro eléctrico debido a una sobrecarga.', 4, 'pendiente', '2025-02-04 18:00:00', 13, 5),
    ('Torrencial de lluvias', 'Se prevén lluvias intensas y posibilidad de inundaciones en la zona del Besòs.', 5, 'pendiente', '2025-02-05 20:00:00', 13, 5),
    ('Alta contaminación del aire', 'Los niveles de contaminación superan los límites permitidos. Se recomienda evitar esfuerzos al aire libre.', 6, 'pendiente', '2025-02-06 09:00:00', 7, 6),
    ('Feria de abril', 'El tráfico estará restringido en la zona de la feria hasta el final del evento.', 7, 'pendiente', '2025-02-07 22:00:00', 7, 6),
    ('Oleaje extremo en la Malvarrosa', 'Precaución en la costa debido a fuertes vientos y oleaje elevado.', 8, 'pendiente', '2025-02-08 11:00:00', 7, 7),
    ('Cortes de agua en el centro', 'Trabajos de mantenimiento dejarán sin suministro algunas zonas del casco histórico.', 9, 'pendiente', '2025-02-09 15:00:00', NULL, 7),
    ('Nevada intensa en Burgos', 'Carreteras cubiertas de nieve. Se recomienda el uso de cadenas.', 10, 'pendiente', '2025-02-10 08:00:00', NULL, 8),
    ('Cierre del puerto de Pajares', 'El puerto se encuentra intransitable debido a la acumulación de nieve.', 11, 'pendiente', '2025-02-11 10:00:00', NULL, 9),
    ('Viento fuerte en Salamanca', 'Rachas de viento de hasta 100 km/h. Se recomienda precaución en la vía pública.', 12, 'pendiente', '2025-02-12 12:00:00', NULL, 10),
    ('Accidente ferroviario en Segovia', 'Retrasos en la línea Madrid-Segovia debido a un incidente en las vías.', 13, 'pendiente', '2025-02-13 13:00:00', NULL, 11),
    ('Cierre del casco histórico de Valladolid', 'Zona peatonalizada por evento cultural. Acceso restringido a vehículos.', 14, 'pendiente', '2025-02-14 16:00:00', NULL, 12),
    ('Rotura de tubería en Zamora', 'Inundaciones en la calle principal por una tubería rota. Equipos de emergencia en la zona.', 15, 'pendiente', '2025-02-15 19:00:00', NULL, 13),
    ('Cierre de colegios en Ávila', 'Clases suspendidas debido a alerta por nevadas.', 16, 'pendiente', '2025-02-16 08:00:00', NULL, 14),
    ('Aviso de frío extremo en Soria', 'Temperaturas bajo cero. Se recomienda precaución en las carreteras.', 17, 'pendiente', '2025-02-17 07:00:00', NULL, 15),
    ('Caída de árboles en Palencia', 'Varios árboles caídos tras fuertes vientos. Servicios de emergencia trabajan en la zona.', 18, 'pendiente', '2025-02-18 09:00:00', NULL, 16),
    ('Manifestación en Burgos', 'Cortes de tráfico en la Plaza Mayor debido a una protesta.', 2, 'pendiente', '2025-02-19 17:00:00', NULL, 8),
    ('Incendio forestal en León', 'Equipos de emergencia trabajan en la extinción de un fuego en la sierra.', 3, 'pendiente', '2025-02-20 14:00:00', NULL, 9),
    ('Fuga de gas en Salamanca', 'Se ha evacuado un edificio en el centro de la ciudad por precaución.', 19, 'pendiente', '2025-02-21 12:00:00', NULL, 10),
    ('Derrumbe de edificio en Segovia', 'Bomberos han evacuado a los residentes tras un derrumbe parcial.', 20, 'pendiente', '2025-02-22 18:00:00', NULL, 11),
    ('Alerta por heladas en Valladolid', 'Carreteras con placas de hielo. Se recomienda circular con precaución.', 21, 'pendiente', '2025-02-23 06:00:00', NULL, 12),
    ('Cierre de túnel en Zamora', 'Mantenimiento en el túnel principal. Se habilitan rutas alternativas.', 22, 'pendiente', '2025-02-24 13:00:00', NULL, 13),
    ('Feria de ganado en Ávila', 'Desvíos de tráfico por la feria anual en las afueras de la ciudad.', 23, 'pendiente', '2025-02-25 15:00:00', NULL, 14),
    ('Corte de electricidad en Soria', 'Corte programado por trabajos en la red eléctrica.', 24, 'pendiente', '2025-02-26 09:00:00', NULL, 15),
    ('Aumento de caudal del río en Palencia', 'Precaución en las zonas ribereñas por riesgo de desbordamiento.', 25, 'pendiente', '2025-02-27 11:00:00', NULL, 16),
    ('Fuga de gas en el casco antiguo', 'Se ha detectado una fuga de gas en un edificio histórico. Precaución en la zona.', 19, 'pendiente', '2025-03-01 10:00:00', NULL, 13),
    ('Accidente en el Puente de Piedra', 'Un choque múltiple ha bloqueado el tráfico en el puente principal.', 1, 'pendiente', '2025-03-02 12:30:00', NULL, 13),
    ('Corte de agua en el centro', 'Trabajos de reparación dejarán sin agua varias calles del casco antiguo.', 9, 'pendiente', '2025-03-03 08:00:00', NULL, 13),
    ('Manifestación en la Plaza Mayor', 'Concentración ciudadana en protesta por la subida del precio de la luz.', 2, 'pendiente', '2025-03-04 18:00:00', NULL, 13),
    ('Inundaciones en la zona del río Duero', 'Aumento del caudal ha provocado desbordamientos en algunas calles cercanas.', 25, 'pendiente', '2025-03-05 14:00:00', NULL, 13),
    ('Incendio en una nave industrial', 'Bomberos trabajan en la extinción de un fuego en el polígono industrial.', 3, 'pendiente', '2025-03-06 21:00:00', NULL, 13),
    ('Viento fuerte en Zamora', 'Rachas de viento de hasta 90 km/h pueden provocar caídas de árboles.', 12, 'pendiente', '2025-03-07 11:00:00', NULL, 13),
    ('Cierre de parques por temporal', 'El ayuntamiento ha decidido cerrar parques y jardines por riesgo de caída de ramas.', 17, 'pendiente', '2025-03-08 16:00:00', NULL, 13),
    ('Obras en la Calle San Torcuato', 'Desvíos de tráfico debido a trabajos de asfaltado.', 14, 'pendiente', '2025-03-09 09:00:00', NULL, 13),
    ('Desperfectos en la Muralla de Zamora', 'Parte de la muralla ha sufrido desprendimientos tras las lluvias.', 15, 'pendiente', '2025-03-10 13:30:00', NULL, 13),
    ('Rotura de tubería en San José Obrero', 'Se ha reportado una gran fuga de agua en la calle principal.', 9, 'pendiente', '2025-03-11 07:00:00', NULL, 17),
    ('Corte de electricidad en Pinilla', 'Vecinos sin suministro eléctrico debido a un fallo en la subestación.', 24, 'pendiente', '2025-03-12 12:00:00', NULL, 18),
    ('Robos en la zona de Los Bloques', 'Aumento de denuncias por robos en viviendas en el barrio.', 19, 'pendiente', '2025-03-13 20:00:00', NULL, 19),
    ('Asfaltado en Candelaria', 'Trabajos en la avenida principal, acceso restringido.', 14, 'pendiente', '2025-03-14 10:00:00', NULL, 20),
    ('Feria en La Horta', 'Actividades programadas para el fin de semana, cortes de tráfico previstos.', 7, 'pendiente', '2025-03-15 15:00:00', NULL, 21),
    ('Ola de calor en Olivares', 'Temperaturas superiores a los 40°C, se recomienda hidratarse.', 5, 'pendiente', '2025-03-16 14:00:00', NULL, 22),
    ('Desperfectos por tormenta en San Lázaro', 'Varias calles han quedado anegadas tras una intensa tormenta.', 25, 'pendiente', '2025-03-17 22:00:00', NULL, 23),
    ('Accidente en Cabañales', 'Moto colisiona con un turismo, hay un herido.', 1, 'pendiente', '2025-03-18 09:00:00', NULL, 24),
    ('Avería en el alumbrado público en San Frontis', 'Calles sin iluminación por una avería en el tendido eléctrico.', 24, 'pendiente', '2025-03-19 21:30:00', NULL, 25),
    ('Acto cultural en Peña Trevinca', 'Evento musical al aire libre este fin de semana.', 7, 'pendiente', '2025-03-20 19:00:00', NULL, 26),
    ('Atraco en Garrido', 'Se reporta un asalto en un establecimiento comercial.', 19, 'pendiente', '2025-03-21 12:30:00', NULL, 27),
    ('Fuga de gas en el barrio del Oeste', 'Varios edificios evacuados por precaución.', 19, 'pendiente', '2025-03-22 08:00:00', NULL, 28),
    ('Manifestación en el barrio de San José', 'Vecinos protestan contra la subida del IBI.', 2, 'pendiente', '2025-03-23 17:00:00', NULL, 29),
    ('Incendio en un edificio de Capuchinos', 'Los bomberos han logrado controlar el fuego sin víctimas.', 3, 'pendiente', '2025-03-24 06:00:00', NULL, 30),
    ('Cierre de calles en Pizarrales', 'Obras de mantenimiento afectarán el tráfico durante toda la semana.', 14, 'pendiente', '2025-03-25 15:00:00', NULL, 31);

-- --------------------------------------------------------------------------
-- TABLA: CATEGORÍAS
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada categoría',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre de la categoría',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción de la categoría',
    `id_padre` INT(11) DEFAULT NULL COMMENT 'ID de la categoría padre (opcional)',
    `id_etiqueta` INT(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
    PRIMARY KEY (`id`),
    KEY `id_padre` (`id_padre`),
    KEY `id_etiqueta` (`id_etiqueta`),
    CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
    CONSTRAINT `categorias_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------------------------
-- TABLA: CONFIGURATIONS
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

-- --------------------------------------------------------------------------
-- VOLCADO DE DATOS DE TABLA: CONFIGURATIONS
-- --------------------------------------------------------------------------
INSERT INTO `configurations` (`key_name`, `value`, `description`) VALUES
    ('pagination_size', '10', 'Número de elementos por página');

-- --------------------------------------------------------------------------
-- TABLA: BACKUPS
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `backups`;
CREATE TABLE IF NOT EXISTS `backups` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada archivo de respaldo',
    `file_name` VARCHAR(255) NOT NULL COMMENT 'Nombre del archivo de respaldo',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación del respaldo',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


SET FOREIGN_KEY_CHECKS = 1;