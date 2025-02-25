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
                                           `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la etiqueta',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre de la etiqueta',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción detallada de la etiqueta',
    `creado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la etiqueta',
    `actualizado_en` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha y hora de la última actualización de la etiqueta',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `etiquetas` (`nombre`, `descripcion`) VALUES
                                                      -- Etiquetas asociadas a la categoría "Clima y Medio Ambiente"
                                                      ('Alerta meteorológica', 'Situaciones relacionadas con fenómenos meteorológicos extremos.'),
                                                      ('Desastre natural', 'Eventos naturales que causan daños significativos, como terremotos o inundaciones.'),
                                                      ('Inundación', 'Acumulación de agua en zonas que normalmente están secas.'),
                                                      ('Tsunami', 'Olas gigantes generadas por terremotos o erupciones volcánicas.'),
                                                      ('Crecida de cauce', 'Aumento del nivel de agua en ríos o arroyos que puede causar inundaciones.'),
                                                      ('Sequía', 'Falta prolongada de lluvia que afecta el suministro de agua y la agricultura.'),
                                                      ('Incendio forestal', 'Fuego que se propaga sin control en zonas boscosas o de vegetación.'),
                                                      ('Ola de calor', 'Período prolongado de temperaturas extremadamente altas.'),
                                                      ('Tormenta eléctrica', 'Tormentas acompañadas de rayos y truenos que pueden causar cortes de energía.'),
                                                      ('Nevada intensa', 'Acumulación de nieve que puede afectar el transporte y las infraestructuras.'),
                                                      -- Etiquetas asociadas a la categoría "Emergencias y Seguridad"
                                                      ('Incendio', 'Fuego que se propaga y puede causar daños a propiedades o personas.'),
                                                      ('Terremoto', 'Movimiento sísmico que puede causar daños estructurales.'),
                                                      ('Robo', 'Actos delictivos que implican el hurto de bienes.'),
                                                      ('Atentado', 'Ataque intencional que pone en riesgo la seguridad pública.'),
                                                      ('Fuga de gas', 'Escape de gas que puede provocar explosiones o intoxicaciones.'),
                                                      -- Etiquetas asociadas a la categoría "Tráfico y Transporte"
                                                      ('Accidente de tráfico', 'Colisión o siniestro en la vía pública.'),
                                                      ('Cierre de carretera', 'Bloqueo de una vía debido a obras, accidentes o eventos.'),
                                                      ('Retraso en transporte', 'Demoras en el servicio de transporte público.'),
                                                      ('Manifestación', 'Concentración de personas que puede afectar la circulación.'),
                                                      -- Etiquetas asociadas a la categoría "Infraestructura y Servicios"
                                                      ('Corte de agua', 'Interrupción del suministro de agua potable.'),
                                                      ('Corte de luz', 'Interrupción del suministro eléctrico.'),
                                                      ('Corte de gas', 'Interrupción del suministro de gas.'),
                                                      ('Cierre de aeropuerto', 'Suspensión de operaciones en un aeropuerto.'),
                                                      ('Fallo en carreteras', 'Problemas en la infraestructura vial que afectan la circulación.'),
                                                      -- Etiquetas asociadas a la categoría "Salud y Bienestar"
                                                      ('Brote de enfermedad', 'Aparición de casos de una enfermedad en una zona específica.'),
                                                      ('Emergencia sanitaria', 'Situación crítica que requiere atención médica inmediata.'),
                                                      ('Campaña de vacunación', 'Iniciativa para vacunar a la población contra una enfermedad.'),
                                                      ('Contaminación del aire', 'Alta concentración de contaminantes en el aire que afecta la salud.'),
                                                      -- Etiquetas asociadas a la categoría "Tecnología y Comunicaciones"
                                                      ('Corte de internet', 'Interrupción del servicio de internet.'),
                                                      ('Corte de telefonía', 'Interrupción del servicio de telefonía móvil o fija.'),
                                                      ('Ciberataque', 'Ataque informático que afecta sistemas o servicios digitales.'),
                                                      ('Fallo tecnológico', 'Problema técnico que interrumpe servicios o sistemas.'),
                                                      -- Etiquetas asociadas a la categoría "Eventos y Cultura"
                                                      ('Concierto', 'Evento musical en vivo.'),
                                                      ('Festival', 'Celebración cultural o artística que puede incluir música, comida y actividades.'),
                                                      ('Evento deportivo', 'Competición o partido de interés público.'),
                                                      ('Feria', 'Evento comercial o cultural con stands y actividades.'),
                                                      -- Etiquetas asociadas a la categoría "Economía y Sociedad"
                                                      ('Crisis económica', 'Situación de inestabilidad financiera o recesión.'),
                                                      ('Desabastecimiento', 'Escasez de productos esenciales como alimentos o medicinas.'),
                                                      ('Subida de precios', 'Aumento significativo en el costo de bienes o servicios.'),
                                                      ('Huelga', 'Paro laboral organizado que puede afectar servicios o empresas.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
                                            `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la categoría',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre de la categoría',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción detallada de la categoría',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`nombre`, `descripcion`) VALUES
    ('Tráfico y Transporte', 'Eventos relacionados con accidentes, cierres de vías, retrasos en transporte público y condiciones viales.'),
    ('Clima y Medio Ambiente', 'Alertas meteorológicas, desastres naturales, fenómenos atmosféricos y problemas ambientales.'),
    ('Emergencias y Seguridad', 'Situaciones de crisis como incendios, terremotos, robos, atentados y fugas de gas.'),
    ('Infraestructura y Servicios', 'Eventos que afectan infraestructuras críticas como cortes de agua, luz, gas, aeropuertos y servicios públicos.'),
    ('Salud y Bienestar', 'Alertas relacionadas con brotes de enfermedades, emergencias sanitarias y eventos de salud pública.'),
    ('Tecnología y Comunicaciones', 'Fallos tecnológicos, ciberataques, interrupciones en servicios digitales y eventos de innovación.'),
    ('Eventos y Cultura', 'Eventos culturales, deportivos, festivos, conciertos, ferias y actividades comunitarias.'),
    ('Economía y Sociedad', 'Crisis económicas, desabastecimiento de productos, subidas de precios y eventos sociales o financieros.');

-- --------------------------------------------------------------------------
-- Tabla: ALERTAS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `alertas`;
CREATE TABLE IF NOT EXISTS `alertas` (
     `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta',
    `titulo` VARCHAR(255) NOT NULL COMMENT 'Título de la alerta',
    `descripcion` TEXT NOT NULL COMMENT 'Descripción detallada de la alerta',
    `id_categoria` INT(11) DEFAULT NULL COMMENT 'ID de la categoria relacionada',
    `estado` ENUM('pendiente', 'completado') DEFAULT 'pendiente' COMMENT 'Estado actual de la alerta',
    `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha y hora de creación de la alerta',
    `fecha_expiracion` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora de expiración de la alerta',
    `completado_en` TIMESTAMP NULL DEFAULT NULL COMMENT 'Fecha y hora en la que se completó la alerta',
    `usuario_id` INT(11) DEFAULT NULL COMMENT 'ID del usuario que publicó la alerta',
    `id_ubicacion` INT(11) NULL COMMENT 'Referencia a la tabla ubicacion',
    PRIMARY KEY (`id`),
    KEY `id_ubicacion` (`id_ubicacion`),
    CONSTRAINT `alertas_fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
    CONSTRAINT `alertas_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `alertas` (`titulo`, `descripcion`, `id_categoria`, `estado`, `fecha_expiracion`, `id_ubicacion`) VALUES
    ('Tormenta severa en Europa', 'Fuertes vientos y lluvias afectan grandes áreas del continente.', 2, 'pendiente', '2025-02-25 15:11:45', 1),
    ('Inundaciones en España', 'Ríos desbordados causan cortes de carreteras y evacuaciones.', 2, 'pendiente', '2025-02-25 15:11:45', 2),
    ('Incendio en Andalucía', 'Un gran incendio forestal amenaza viviendas en la región.', 2, 'pendiente', '2025-02-25 15:11:45', 3),
    ('Nevadas en Aragón', 'Acumulación de nieve bloquea carreteras en la región.', 2, 'pendiente', '2025-02-25 15:11:45', 4),
    ('Accidente de tráfico en Asturias', 'Colisión múltiple en la autopista A-8.', 1, 'pendiente', '2025-02-25 15:11:45', 5),
    ('Temporal en Islas Baleares', 'Vientos huracanados y fuertes lluvias afectan la región.', 2, 'pendiente', '2025-02-25 15:11:45', 6),
    ('Emergencia volcánica en Canarias', 'Actividad volcánica detectada en la isla.', 2, 'pendiente', '2025-02-25 15:11:45', 7),
    ('Cierre de carreteras en Cantabria', 'Derrumbes bloquean varias vías.', 4, 'pendiente', '2025-02-25 15:11:45', 8),
    ('Ola de calor en Extremadura', 'Temperaturas por encima de los 45°C afectan la región.', 2, 'pendiente', '2025-02-25 15:11:45', 12),
    ('Temporal en Galicia', 'Lluvias intensas y fuertes vientos afectan la comunidad.', 2, 'pendiente', '2025-02-25 15:11:45', 13),
    ('Manifestación en Madrid', 'Gran protesta en el centro de la ciudad afecta la movilidad.', 1, 'pendiente', '2025-02-25 15:11:45', 14),
    ('Terremoto en Murcia', 'Sismo de magnitud 5.2 se siente en varias localidades.', 3, 'pendiente', '2025-02-25 15:11:45', 15),
    ('Granizada en Navarra', 'Fuertes precipitaciones de granizo causan daños en viviendas.', 2, 'pendiente', '2025-02-25 15:11:45', 16),
    ('Tornado en La Rioja', 'Vientos extremadamente fuertes generan daños en la ciudad.', 3, 'pendiente', '2025-02-25 15:11:45', 17),
    ('Explosión en el País Vasco', 'Una fuerte explosión sacude una zona industrial.', 3, 'pendiente', '2025-02-25 15:11:45', 18),
    ('Robo masivo en la Comunidad Valenciana', 'Varias tiendas saqueadas en una ola de robos nocturnos.', 3, 'pendiente', '2025-02-25 15:11:45', 19),
    ('Emergencia sanitaria en Ceuta', 'Brote de enfermedad infecciosa detectado en la ciudad.', 5, 'pendiente', '2025-02-25 15:11:45', 20),
    ('Cierre de puerto en Melilla', 'Fuerte oleaje obliga a la suspensión de ferris y tráfico marítimo.', 4, 'pendiente', '2025-02-25 15:11:45', 21),
    ('Incendio en Salamanca', 'Un incendio afecta una zona industrial con riesgo de propagación.', 2, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Corte de agua en Salamanca', 'Mantenimiento programado interrumpe el suministro de agua potable.', 4, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Fallo en el transporte público', 'Problemas técnicos causan retrasos en los autobuses urbanos.', 1, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Concierto en el centro', 'Gran concierto en la Plaza Mayor con cortes de tráfico.', 7, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Feria del libro', 'Feria del libro en el centro de la ciudad con actividades culturales.', 7, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Contaminación del aire', 'Alta concentración de partículas en suspensión en la ciudad.', 5, 'pendiente', '2025-02-25 15:11:45', 26),
    ('Manifestación en Plaza Mayor', 'Protesta pacífica en el centro de la ciudad afecta la movilidad.', 1, 'pendiente', '2025-02-25 15:11:45', 41),
    ('Fuga de gas en Garrido', 'Evacuación de varios edificios por escape de gas en una tubería principal.', 3, 'pendiente', '2025-02-25 15:11:45', 42),
    ('Accidente de tráfico en Cementerio', 'Colisión múltiple en la avenida principal con varios heridos.', 1, 'pendiente', '2025-02-25 15:11:45', 43),
    ('Robo en Pizarrales', 'Asalto en un comercio con enfrentamiento policial.', 3, 'pendiente', '2025-02-25 15:11:45', 44),
    ('Corte eléctrico en San José', 'Fallo en la red eléctrica deja sin luz a varios hogares.', 4, 'pendiente', '2025-02-25 15:11:45', 45),
    ('Mercado medieval', 'Mercado medieval en la Plaza Mayor con cortes de tráfico.', 7, 'pendiente', '2025-02-25 15:11:45', 41),
    ('Corte de agua programado', 'Mantenimiento de tuberías afectará el suministro de agua.', 4, 'pendiente', '2025-02-25 15:11:45', 41),
    ('Fuga de agua en Garrido', 'Fuga de agua en una tubería principal afecta a varias calles.', 4, 'pendiente', '2025-02-25 15:11:45', 42),
    ('Actividad comunitaria', 'Jornada de limpieza y actividades vecinales en el barrio.', 7, 'pendiente', '2025-02-25 15:11:45', 42),
    ('Corte de tráfico por obras', 'Obras de reparación en la avenida principal.', 1, 'pendiente', '2025-02-25 15:11:45', 43),
    ('Actividad cultural', 'Exposición de arte en el centro cultural del barrio.', 7, 'pendiente', '2025-02-25 15:11:45', 43),
    ('Robo en comercio local', 'Asalto a un supermercado en el barrio.', 3, 'pendiente', '2025-02-25 15:11:45', 44),
    ('Feria de barrio', 'Feria local con actividades para toda la familia.', 7, 'pendiente', '2025-02-25 15:11:45', 44),
    ('Corte de luz programado', 'Mantenimiento de la red eléctrica en el barrio.', 4, 'pendiente', '2025-02-25 15:11:45', 45),
    ('Evento deportivo', 'Torneo de fútbol en el polideportivo del barrio.', 7, 'pendiente', '2025-02-25 15:11:45', 45),
    ('Oleaje extremo en Zamora', 'Riesgo de inundaciones en zonas cercanas al río.', 2, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Corte de luz en Zamora', 'Fallo en la red eléctrica deja sin luz a varios barrios.', 4, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Festival de música', 'Festival de música en el casco antiguo con cortes de tráfico.', 7, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Accidente de tráfico en la periferia', 'Colisión entre dos vehículos en la carretera de acceso a la ciudad.', 1, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Feria gastronómica', 'Feria gastronómica en el centro con degustaciones y actividades.', 7, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Alerta por vientos fuertes', 'Rachas de viento de hasta 80 km/h afectan la ciudad.', 3, 'pendiente', '2025-02-25 15:11:45', 30),
    ('Emergencia química en Casco Antiguo', 'Derrame de sustancias peligrosas en un almacén industrial.', 3, 'pendiente', '2025-02-25 15:11:45', 46),
    ('Desperfectos por tormenta en San Lázaro', 'Fuertes lluvias causan daños en infraestructuras.', 2, 'pendiente', '2025-02-25 15:11:45', 47),
    ('Explosión en San José Obrero', 'Una fuga de gas provoca una explosión en un edificio residencial.', 3, 'pendiente', '2025-02-25 15:11:45', 48),
    ('Corte de comunicaciones en Pinilla', 'Interrupción del servicio de telefonía e internet en la zona.', 6, 'pendiente', '2025-02-25 15:11:45', 49),
    ('Derrumbe en Los Bloques', 'Colapso de una estructura antigua deja atrapadas a varias personas.', 4, 'pendiente', '2025-02-25 15:11:45', 50),
    ('Inundaciones en La Candelaria', 'Fuertes lluvias causan desbordamiento del alcantarillado.', 2, 'pendiente', '2025-02-25 15:11:45', 51),
    ('Emergencia sanitaria en Cabañales', 'Se reporta un brote de virus estomacal en la comunidad.', 5, 'pendiente', '2025-02-25 15:11:45', 52),
    ('Fallo energético en Pantoja', 'Corte de electricidad afecta a toda la comunidad.', 4, 'pendiente', '2025-02-25 15:11:45', 53),
    ('Oleada de robos en San Frontis', 'Incremento de asaltos en comercios locales.', 3, 'pendiente', '2025-02-25 15:11:45', 54),
    ('Granizada en Las Viñas', 'Tormenta de granizo daña vehículos y tejados.', 2, 'pendiente', '2025-02-25 15:11:45', 55),
    ('Tornado en San Isidro', 'Rachas de viento extremadamente fuertes causan daños estructurales.', 3, 'pendiente', '2025-02-25 15:11:45', 56),
    ('Festival de cine', 'Proyección de películas al aire libre en el casco antiguo.', 7, 'pendiente', '2025-02-25 15:11:45', 46),
    ('Corte de tráfico por evento', 'Corte de tráfico debido a un evento cultural.', 1, 'pendiente', '2025-02-25 15:11:45', 46),
    ('Fuga de gas en San Lázaro', 'Evacuación de edificios por una fuga de gas.', 3, 'pendiente', '2025-02-25 15:11:45', 47),
    ('Actividad vecinal', 'Jornada de limpieza y actividades comunitarias.', 7, 'pendiente', '2025-02-25 15:11:45', 47),
    ('Corte de agua programado', 'Mantenimiento de tuberías en el barrio.', 4, 'pendiente', '2025-02-25 15:11:45', 48),
    ('Evento cultural', 'Concierto en el parque del barrio.', 7, 'pendiente', '2025-02-25 15:11:45', 48),
    ('Robo en vivienda', 'Asalto a una vivienda en el barrio.', 3, 'pendiente', '2025-02-25 15:11:45', 49),
    ('Feria de barrio', 'Feria local con actividades para toda la familia.', 7, 'pendiente', '2025-02-25 15:11:45', 49),
    ('Corte de luz por mantenimiento', 'Mantenimiento de la red eléctrica en el barrio.', 4, 'pendiente', '2025-02-25 15:11:45', 50),
    ('Actividad deportiva', 'Torneo de baloncesto en el polideportivo.', 7, 'pendiente', '2025-02-25 15:11:45', 50);



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
-- Tabla: ALERTA_ETIQUETA - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `alerta_etiqueta`;
CREATE TABLE IF NOT EXISTS `alerta_etiqueta` (
    `id_alerta` INT(11) NOT NULL COMMENT 'ID de la alerta',
    `id_etiqueta` INT(11) NOT NULL COMMENT 'ID de la etiqueta',
    PRIMARY KEY (`id_alerta`,`id_etiqueta`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `alerta_etiqueta` (`id_alerta`, `id_etiqueta`) VALUES
    (1, 1),
    (1, 3),
    (1, 5),
    (1, 9),
    (2, 3),
    (2, 5),
    (3, 2),
    (3, 7),
    (4, 1),
    (4, 10),
    (5, 16),
    (5, 17),
    (6, 1),
    (6, 9),
    (7, 2),
    (7, 4),
    (8, 17),
    (8, 24),
    (9, 1),
    (9, 8),
    (10, 1),
    (10, 9),
    (11, 17),
    (11, 19),
    (12, 2),
    (12, 12),
    (13, 9),
    (13, 10),
    (14, 2),
    (14, 17),
    (15, 15),
    (15, 26),
    (16, 13),
    (16, 23),
    (17, 25),
    (17, 26),
    (18, 5),
    (18, 24),
    (19, 2),
    (19, 7),
    (20, 20),
    (20, 22),
    (21, 17),
    (21, 18),
    (22, 33),
    (22, 36),
    (23, 34),
    (23, 36),
    (24, 14),
    (24, 28),
    (25, 17),
    (25, 19),
    (26, 15),
    (26, 26),
    (27, 16),
    (27, 17),
    (28, 13),
    (28, 23),
    (29, 21),
    (29, 22),
    (30, 34),
    (30, 36),
    (31, 20),
    (31, 22),
    (32, 20),
    (32, 22),
    (33, 34),
    (33, 36),
    (34, 17),
    (34, 24),
    (35, 34),
    (35, 36),
    (36, 13),
    (36, 23),
    (37, 34),
    (37, 36),
    (38, 21),
    (38, 22),
    (39, 35),
    (39, 36),
    (40, 3),
    (40, 5),
    (41, 21),
    (41, 22),
    (42, 33),
    (42, 34),
    (43, 16),
    (43, 17),
    (44, 34),
    (44, 36),
    (45, 1),
    (45, 17),
    (46, 15),
    (46, 27),
    (47, 1),
    (47, 9),
    (48, 15),
    (48, 26),
    (49, 29),
    (49, 30),
    (50, 7),
    (50, 24),
    (51, 3),
    (51, 5),
    (52, 25),
    (52, 26),
    (53, 21),
    (53, 22),
    (54, 13),
    (54, 23),
    (55, 9),
    (55, 10),
    (56, 2),
    (56, 17),
    (57, 34),
    (57, 36),
    (58, 17),
    (58, 24),
    (59, 15),
    (59, 26),
    (60, 34),
    (60, 36),
    (61, 20),
    (61, 22),
    (62, 33),
    (62, 34),
    (63, 13),
    (63, 23),
    (64, 34),
    (64, 36),
    (65, 21),
    (65, 22),
    (66, 35),
    (66, 36);

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
    (1, 16),
    (1, 17),
    (1, 18),
    (1, 19),
    (2, 1),
    (2, 2),
    (2, 3),
    (2, 4),
    (2, 5),
    (2, 6),
    (2, 7),
    (2, 8),
    (2, 9),
    (2, 10),
    (3, 11),
    (3, 12),
    (3, 13),
    (3, 14),
    (3, 15),
    (4, 20),
    (4, 21),
    (4, 22),
    (4, 23),
    (4, 24),
    (5, 25),
    (5, 26),
    (5, 27),
    (5, 28),
    (6, 29),
    (6, 30),
    (6, 31),
    (6, 32),
    (7, 33),
    (7, 34),
    (7, 35),
    (7, 36),
    (8, 37),
    (8, 38),
    (8, 39),
    (8, 40);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
