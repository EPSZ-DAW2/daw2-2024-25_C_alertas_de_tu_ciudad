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
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del usuario',
    `register_date` DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de registro del usuario',
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Última actualización del usuario',
    `confirmed` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el usuario ha confirmado su registro',
    `role` ENUM('guest','usuario','moderator','admin','sysadmin') DEFAULT 'usuario' COMMENT 'Rol del usuario en el sistema',
    `attempts` INT(11) DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
    `is_locked` TINYINT(1) DEFAULT 0 COMMENT 'Indica si el usuario está bloqueado',
    `phone` VARCHAR(15) DEFAULT NULL COMMENT 'Número de teléfono del usuario',
    `status` TINYINT(1) DEFAULT 0 COMMENT 'Estado del usuario',
    `profile_image` VARCHAR(255) DEFAULT NULL COMMENT 'Imagen de perfil del usuario',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserción de datos con imágenes de perfil
INSERT INTO `usuario` (`email`, `password`, `auth_key`, `nick`, `username`, `register_date`, `created_at`, `updated_at`, `confirmed`, `role`, `attempts`, `is_locked`, `profile_image`) VALUES
    ('dj@usal.es', '$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2', 'h5uq58uxdPNhFEmtStMDYoD2a8V60ebT', 'djPiri', 'djpiri', NOW(), NOW(), NOW(), 1, 'usuario', 0, 0, NULL),
    ('alba@mg.es', '$2y$13$ef9ObfZ.R7msNW9oCrvTlOMvFYupos5AXRmo2RahJzU7s2QzhCtyu', 'YswvC2pI-AXtqtcoi69oDHyJbwfhmy1N', 'alba', 'alba', NOW(), NOW(), NOW(), 1, 'usuario', 0, 0, 'alba.jpg'),
    ('mem@usal.es', '$2y$13$hqt.XD489dM.v9JGloiNLeyE.W4B1fqkFQ26pXWAcN4WtHyc354KW', 'RUwSX2LdFVBK0tx0mDsT0ZbBhUQla5v8', 'mem1', 'mem1' , NOW(), NOW(), NOW(), 1, 'usuario', 0, 0, NULL);

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
    `latitud` DECIMAL(10, 6) DEFAULT NULL COMMENT 'Latitud de la ubicación para búsqueda en el mapa',
    `longitud` DECIMAL(10, 6) DEFAULT NULL COMMENT 'Longitud de la ubicación para búsqueda en el mapa',
    PRIMARY KEY (`id`),
    KEY `ub_code_padre` (`ub_code_padre`),
    CONSTRAINT `fk_ubicacion_padre` FOREIGN KEY (`ub_code_padre`) REFERENCES `ubicacion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `ubicacion` (`id`, `ub_code`, `nombre`, `code_iso`, `ub_code_padre`, `latitud`, `longitud`) VALUES
    (0, 1, 'Tierra', NULL, NULL, NULL, NULL),
    (1, 1, 'Europa', 'EU', 0, 54.5260, 15.2551),
    (2, 2, 'España', 'ES', 1, 40.4637, -3.7492),
    (3, 3, 'Andalucía', 'ES-AN', 2, 37.5443, -4.7278),
    (4, 3, 'Aragón', 'ES-AR', 2, 41.5976, -0.9057),
    (5, 3, 'Asturias', 'ES-AS', 2, 43.3614, -5.8593),
    (6, 3, 'Islas Baleares', 'ES-IB', 2, 39.6953, 3.0176),
    (7, 3, 'Canarias', 'ES-CN', 2, 28.2916, -16.6291),
    (8, 3, 'Cantabria', 'ES-CB', 2, 43.1828, -3.9878),
    (9, 3, 'Castilla-La Mancha', 'ES-CM', 2, 39.2796, -3.0995),
    (10, 3, 'Castilla y León', 'ES-CL', 2, 41.8357, -4.3976),
    (11, 3, 'Cataluña', 'ES-CT', 2, 41.5912, 1.5209),
    (12, 3, 'Extremadura', 'ES-EX', 2, 39.1934, -6.0988),
    (13, 3, 'Galicia', 'ES-GA', 2, 42.5751, -8.1339),
    (14, 3, 'Madrid', 'ES-MD', 2, 40.4168, -3.7038),
    (15, 3, 'Murcia', 'ES-MC', 2, 37.9922, -1.1307),
    (16, 3, 'Navarra', 'ES-NC', 2, 42.6954, -1.6761),
    (17, 3, 'La Rioja', 'ES-RI', 2, 42.2871, -2.5396),
    (18, 3, 'País Vasco', 'ES-PV', 2, 43.0535, -2.6197),
    (19, 3, 'Comunidad Valenciana', 'ES-VC', 2, 39.4840, -0.7533),
    (20, 3, 'Ceuta', 'ES-CE', 2, 35.8894, -5.3213),
    (21, 3, 'Melilla', 'ES-ML', 2, 35.2923, -2.9381),
    (26, 4, 'Salamanca', 'ES-SA', 10, 40.9701, -5.6635),
    (30, 4, 'Zamora', 'ES-ZA', 10, 41.5030, -5.7440),
    (31, 6, 'Salamanca', 'ES-SA-SAL', 26, 40.9701, -5.6635),
    (36, 6, 'Zamora', 'ES-ZA-ZAM', 30, 41.5030, -5.7440),
    -- Barrios de Salamanca
    (41, 7, 'Plaza Mayor', NULL, 31, 40.9684, -5.6639),
    (42, 7, 'Garrido', NULL, 31, 40.9766, -5.6474),
    (43, 7, 'Cementerio', NULL, 31, 40.9498, -5.6525),
    (44, 7, 'Pizarrales', NULL, 31, 40.9629, -5.6784),
    (45, 7, 'San José', NULL, 31, 40.9564, -5.6651),
    -- Barrios de Zamora
    (46, 7, 'Casco Antiguo', NULL, 36, 41.5030, -5.7440),
    (47, 7, 'San Lázaro', NULL, 36, 41.5039, -5.7403),
    (48, 7, 'San José Obrero', NULL, 36, 41.5086, -5.7416),
    (49, 7, 'Pinilla', NULL, 36, 41.5042, -5.7256),
    (50, 7, 'Los Bloques', NULL, 36, 41.5061, -5.7477),
    (51, 7, 'La Candelaria', NULL, 36, 41.5050, -5.7428),
    (52, 7, 'Cabañales', NULL, 36, 41.5025, -5.7542),
    (53, 7, 'Pantoja', NULL, 36, 41.5008, -5.7467),
    (54, 7, 'San Frontis', NULL, 36, 41.5049, -5.7559),
    (55, 7, 'Las Viñas', NULL, 36, 41.5012, -5.7398),
    (56, 7, 'San Isidro', NULL, 36, 41.5031, -5.7483),
    (57, 7, 'Vista Alegre', NULL, 36, 41.5040, -5.7450),
    (58, 7, 'Otero', NULL, 36, 41.5035, -5.7390),
    (59, 7, 'Siglo XXI', NULL, 36, 41.5018, -5.7356),
    (60, 7, 'Tres Cruces', NULL, 36, 41.5007, -5.7409),
    (61, 6, 'Sevilla', 'ES-SE', 3, 37.3891, -5.9845),
    (62, 6, 'Málaga', 'ES-MA', 3, 36.7213, -4.4213),
    (63, 6, 'Alicante', 'ES-A', 19, 38.3452, -0.4810),
    (64, 6, 'Córdoba', 'ES-CO', 3, 37.8882, -4.7794),
    (65, 6, 'Vigo', 'ES-PO', 13, 42.2406, -8.7207),
    (66, 6, 'Toledo', 'ES-TO', 9, 39.8628, -4.0273),
    (67, 6, 'Santander', 'ES-S', 8, 43.4623, -3.8099),
    (68, 6, 'Gijón', 'ES-GI', 5, 43.5322, -5.6611),
    (69, 6, 'Badajoz', 'ES-BA', 12, 38.8786, -6.9706),
    (70, 6, 'Lleida', 'ES-L', 11, 41.6167, 0.6222),
    (71, 6, 'Benidorm', 'ES-BEN', 19, 38.5342, -0.1313),
    (72, 6, 'Torrevieja', 'ES-TOR', 19, 37.9774, -0.6822),
    (73, 6, 'Castellón de la Plana', 'ES-CS', 19, 39.9864, -0.0513),
    (74, 6, 'Huelva', 'ES-H', 3, 37.2614, -6.9447),
    (75, 6, 'Almería', 'ES-AL', 3, 36.8340, -2.4637),
    (76, 6, 'Ronda', 'ES-RON', 3, 36.7468, -5.1613),
    (77, 6, 'Cudillero', 'ES-CUD', 5, 43.5631, -6.1476),
    (78, 6, 'Albarracín', 'ES-ABR', 4, 40.4079, -1.4424),
    (79, 6, 'Peñíscola', 'ES-PEN', 19, 40.3598, 0.4067),
    (80, 6, 'Cadaqués', 'ES-CAD', 11, 42.2890, 3.2775);



-- --------------------------------------------------------------------------
-- Tabla: CATEGORIAS - Creación y volcado de datos
-- --------------------------------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único de la categoría',
    `nombre` VARCHAR(255) NOT NULL COMMENT 'Nombre de la categoría',
    `descripcion` TEXT DEFAULT NULL COMMENT 'Descripción detallada de la categoría',
    `id_padre` INT(11) DEFAULT NULL COMMENT 'ID de la categoría padre (subcategorias)',
    `id_etiqueta` INT(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
    PRIMARY KEY (`id`),
    KEY `id_padre` (`id_padre`),
    KEY `id_etiqueta` (`id_etiqueta`),
    CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
    CONSTRAINT `categorias_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categorias` (`nombre`, `descripcion`, `id_padre`, `id_etiqueta`) VALUES
    ('Tráfico y Transporte', 'Eventos relacionados con accidentes, cierres de vías, retrasos en transporte público y condiciones viales.', NULL, NULL),
    ('Clima y Medio Ambiente', 'Alertas meteorológicas, desastres naturales, fenómenos atmosféricos y problemas ambientales.', NULL, NULL),
    ('Emergencias y Seguridad', 'Situaciones de crisis como incendios, terremotos, robos, atentados y fugas de gas.', NULL, NULL),
    ('Infraestructura y Servicios', 'Eventos que afectan infraestructuras críticas como cortes de agua, luz, gas, aeropuertos y servicios públicos.', NULL, NULL),
    ('Salud y Bienestar', 'Alertas relacionadas con brotes de enfermedades, emergencias sanitarias y eventos de salud pública.', NULL, NULL),
    ('Tecnología y Comunicaciones', 'Fallos tecnológicos, ciberataques, interrupciones en servicios digitales y eventos de innovación.', NULL, NULL),
    ('Eventos y Cultura', 'Eventos culturales, deportivos, festivos, conciertos, ferias y actividades comunitarias.', NULL, NULL),
    ('Economía y Sociedad', 'Crisis económicas, desabastecimiento de productos, subidas de precios y eventos sociales o financieros.', NULL, NULL);


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
    `id_imagen` INT(11) NULL COMMENT 'Referencia a la tabla imagenes',
    PRIMARY KEY (`id`),
    KEY `id_ubicacion` (`id_ubicacion`),
    CONSTRAINT `alertas_fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
    CONSTRAINT `alertas_ibfk_2` FOREIGN KEY (`id_ubicacion`) REFERENCES `ubicacion` (`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `alertas` (`titulo`, `descripcion`, `id_categoria`, `estado`, `fecha_creacion`, `id_ubicacion`, `id_imagen`) VALUES
    ('Tormenta severa en Europa', 'Una tormenta severa afecta grandes áreas de Europa, con fuertes vientos que superan los 100 km/h y lluvias torrenciales que han causado inundaciones en varias regiones. Se han reportado cortes de electricidad, caída de árboles y daños en infraestructuras. Las autoridades han emitido alertas rojas en varias zonas y recomiendan evitar desplazamientos innecesarios.', 2, 'pendiente', '2025-02-25 15:11:45', 1, NULL),
    ('Inundaciones en España', 'Varios ríos en España se han desbordado debido a las intensas lluvias, causando inundaciones en zonas cercanas. Se han registrado cortes en carreteras principales, evacuaciones de viviendas y daños en cultivos. Los equipos de emergencia están trabajando para rescatar a personas atrapadas y proporcionar asistencia a los afectados.', 2, 'pendiente', '2025-02-25 15:11:45', 2, NULL),
    ('Incendio en Andalucía', 'Un gran incendio forestal se ha declarado en Andalucía, amenazando varias viviendas y áreas naturales protegidas. Las altas temperaturas y los fuertes vientos están dificultando las labores de extinción. Se han evacuado varias localidades y se ha solicitado ayuda aérea para controlar las llamas.', 2, 'pendiente', '2025-02-25 15:11:45', 3, NULL),
    ('Nevadas en Aragón', 'Una fuerte nevada ha afectado la región de Aragón, acumulando más de 50 cm de nieve en algunas zonas. Varias carreteras han quedado bloqueadas, y se han activado protocolos de emergencia para garantizar el suministro de alimentos y medicinas en las áreas más aisladas.', 2, 'pendiente', '2025-02-25 15:11:45', 4, NULL),
    ('Accidente de tráfico en Asturias', 'Una colisión múltiple en la autopista A-8 ha dejado varios heridos y ha causado retenciones de varios kilómetros. Los servicios de emergencia están atendiendo a las víctimas y desviando el tráfico para evitar mayores complicaciones.', 1, 'pendiente', '2025-02-25 15:11:45', 5, NULL),
    ('Temporal en Islas Baleares', 'Un temporal con vientos huracanados y lluvias intensas ha afectado las Islas Baleares, causando daños en infraestructuras y cortes de electricidad. Se han cancelado varios vuelos y servicios marítimos debido a las condiciones adversas.', 2, 'pendiente', '2025-02-25 15:11:45', 6, NULL),
    ('Emergencia volcánica en Canarias', 'Se ha detectado un aumento en la actividad volcánica en una de las islas Canarias, lo que ha llevado a las autoridades a activar un plan de emergencia. Se están realizando evacuaciones preventivas en las zonas de mayor riesgo.', 2, 'pendiente', '2025-02-25 15:11:45', 7, NULL),
    ('Cierre de carreteras en Cantabria', 'Varios derrumbes causados por las fuertes lluvias han bloqueado carreteras en Cantabria. Los equipos de mantenimiento están trabajando para despejar las vías, pero se recomienda evitar la zona hasta que se resuelva la situación.', 4, 'pendiente', '2025-02-25 15:11:45', 8, NULL),
    ('Ola de calor en Extremadura', 'Una ola de calor con temperaturas superiores a los 45°C está afectando Extremadura. Las autoridades han emitido alertas sanitarias y recomiendan hidratarse adecuadamente y evitar la exposición al sol durante las horas centrales del día.', 2, 'pendiente', '2025-02-25 15:11:45', 12, NULL),
    ('Temporal en Galicia', 'Lluvias intensas y vientos fuertes están afectando Galicia, causando inundaciones y cortes de electricidad. Se han registrado daños en viviendas y cultivos, y se recomienda precaución al circular por carreteras secundarias.', 2, 'pendiente', '2025-02-25 15:11:45', 13, NULL),
    ('Manifestación en Madrid', 'Una gran manifestación en el centro de Madrid ha provocado cortes de tráfico y afectado la movilidad en la zona. La policía está coordinando el tráfico y garantizando la seguridad de los manifestantes.', 1, 'pendiente', '2025-02-25 15:11:45', 14, NULL),
    ('Terremoto en Murcia', 'Un terremoto de magnitud 5.2 se ha registrado en Murcia, causando daños menores en edificios y cortes de electricidad en algunas zonas. No se han reportado heridos graves, pero las autoridades están evaluando los daños.', 3, 'pendiente', '2025-02-25 15:11:45', 15, NULL),
    ('Granizada en Navarra', 'Una fuerte granizada ha causado daños en viviendas y vehículos en Navarra. Las precipitaciones han sido tan intensas que han dejado calles cubiertas de hielo, dificultando la circulación.', 2, 'pendiente', '2025-02-25 15:11:45', 16, NULL),
    ('Tornado en La Rioja', 'Un tornado ha tocado tierra en La Rioja, causando daños estructurales en varias localidades. Los vientos extremadamente fuertes han derribado árboles y postes eléctricos, dejando a varias comunidades sin suministro.', 3, 'pendiente', '2025-02-25 15:11:45', 17, NULL),
    ('Explosión en el País Vasco', 'Una fuerte explosión en una zona industrial del País Vasco ha causado daños en edificios cercanos. Los equipos de emergencia están investigando las causas y atendiendo a los heridos.', 3, 'pendiente', '2025-02-25 15:11:45', 18, NULL),
    ('Robo masivo en la Comunidad Valenciana', 'Una ola de robos nocturnos ha afectado a varias tiendas en la Comunidad Valenciana. La policía está investigando los hechos y ha aumentado la presencia en la zona para prevenir nuevos incidentes.', 3, 'pendiente', '2025-02-25 15:11:45', 19, NULL),
    ('Emergencia sanitaria en Ceuta', 'Se ha detectado un brote de una enfermedad infecciosa en Ceuta. Las autoridades sanitarias están trabajando para contener la propagación y han activado un protocolo de emergencia.', 5, 'pendiente', '2025-02-25 15:11:45', 20, NULL),
    ('Cierre de puerto en Melilla', 'El fuerte oleaje ha obligado a cerrar el puerto de Melilla, suspendiendo todos los servicios marítimos. Se recomienda a los pasajeros consultar con las compañías antes de viajar.', 4, 'pendiente', '2025-02-25 15:11:45', 21, NULL),
    ('Incendio en Salamanca', 'Un incendio en una zona industrial de Salamanca ha provocado evacuaciones preventivas. Los bomberos están trabajando para controlar las llamas y evitar que se propague a áreas residenciales.', 2, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Corte de agua en Salamanca', 'Un mantenimiento programado ha interrumpido el suministro de agua en varias zonas de Salamanca. Se espera que el servicio se restablezca en las próximas horas.', 4, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Fallo en el transporte público', 'Problemas técnicos en los autobuses urbanos de Salamanca están causando retrasos en las rutas. La empresa de transporte está trabajando para solucionar la incidencia lo antes posible.', 1, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Concierto en el centro', 'Un gran concierto en la Plaza Mayor de Salamanca ha provocado cortes de tráfico en el centro de la ciudad. Se recomienda utilizar transporte público o rutas alternativas.', 7, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Feria del libro', 'La feria del libro en Salamanca ofrece actividades culturales y presentaciones de autores. El evento ha atraído a numerosos visitantes y ha generado un ambiente festivo en la ciudad.', 7, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Contaminación del aire', 'Se ha detectado un aumento en la concentración de partículas en suspensión en Salamanca, lo que ha llevado a las autoridades a emitir una alerta sanitaria. Se recomienda evitar actividades al aire libre.', 5, 'pendiente', '2025-02-25 15:11:45', 26, NULL),
    ('Manifestación en Plaza Mayor', 'Una manifestación pacífica en la Plaza Mayor de Salamanca ha afectado la movilidad en el centro. La policía está coordinando el tráfico para minimizar las molestias.', 1, 'pendiente', '2025-02-25 15:11:45', 41, NULL),
    ('Fuga de gas en Garrido', 'Una fuga de gas en una tubería principal ha obligado a evacuar varios edificios en el barrio de Garrido. Los equipos de emergencia están trabajando para reparar la avería.', 3, 'pendiente', '2025-02-25 15:11:45', 42, NULL),
    ('Accidente de tráfico en Cementerio', 'Una colisión múltiple en la avenida principal del barrio del Cementerio ha dejado varios heridos. Los servicios de emergencia están atendiendo a las víctimas y desviando el tráfico.', 1, 'pendiente', '2025-02-25 15:11:45', 43, NULL),
    ('Robo en Pizarrales', 'Un asalto en un comercio del barrio de Pizarrales ha terminado con un enfrentamiento policial. No se han reportado heridos graves, pero se ha aumentado la presencia policial en la zona.', 3, 'pendiente', '2025-02-25 15:11:45', 44, NULL),
    ('Corte eléctrico en San José', 'Un fallo en la red eléctrica ha dejado sin luz a varios hogares en el barrio de San José. La compañía eléctrica está trabajando para restablecer el suministro.', 4, 'pendiente', '2025-02-25 15:11:45', 45, NULL),
    ('Mercado medieval', 'Un mercado medieval en la Plaza Mayor de Salamanca ha atraído a numerosos visitantes. El evento incluye actividades recreativas y gastronomía tradicional.', 7, 'pendiente', '2025-02-25 15:11:45', 41, NULL),
    ('Corte de agua programado', 'Un mantenimiento de tuberías en Salamanca ha interrumpido el suministro de agua en varias zonas. Se espera que el servicio se restablezca en las próximas horas.', 4, 'pendiente', '2025-02-25 15:11:45', 41, NULL),
    ('Fuga de agua en Garrido', 'Una fuga de agua en una tubería principal ha afectado a varias calles del barrio de Garrido. Los equipos de mantenimiento están trabajando para reparar la avería.', 4, 'pendiente', '2025-02-25 15:11:45', 42, NULL),
    ('Actividad comunitaria', 'Una jornada de limpieza y actividades vecinales se está llevando a cabo en el barrio de Garrido. El evento promueve la convivencia y el cuidado del entorno.', 7, 'pendiente', '2025-02-25 15:11:45', 42, NULL),
    ('Corte de tráfico por obras', 'Obras de reparación en la avenida principal del barrio del Cementerio han provocado cortes de tráfico. Se recomienda utilizar rutas alternativas.', 1, 'pendiente', '2025-02-25 15:11:45', 43, NULL),
    ('Actividad cultural', 'Una exposición de arte en el centro cultural del barrio del Cementerio ha atraído a numerosos visitantes. El evento incluye obras de artistas locales.', 7, 'pendiente', '2025-02-25 15:11:45', 43, NULL),
    ('Robo en comercio local', 'Un asalto a un supermercado en el barrio de Pizarrales ha generado alarma entre los vecinos. La policía está investigando el incidente.', 3, 'pendiente', '2025-02-25 15:11:45', 44, NULL),
    ('Feria de barrio', 'Una feria local en el barrio de Pizarrales ofrece actividades para toda la familia, incluyendo juegos, talleres y puestos de comida tradicional. El evento ha generado un ambiente festivo y ha fortalecido la convivencia entre los vecinos.', 7, 'pendiente', '2025-02-25 15:11:45', 44, NULL),
    ('Corte de luz programado', 'Un mantenimiento programado de la red eléctrica en el barrio de San José ha dejado sin luz a varias viviendas. La compañía eléctrica ha informado que el suministro se restablecerá en las próximas horas.', 4, 'pendiente', '2025-02-25 15:11:45', 45, NULL),
    ('Evento deportivo', 'Un torneo de fútbol en el polideportivo del barrio de San José ha reunido a equipos locales. El evento promueve el deporte y la convivencia entre los vecinos.', 7, 'pendiente', '2025-02-25 15:11:45', 45, NULL),
    ('Oleaje extremo en Zamora', 'El fuerte oleaje en el río Duero ha causado inundaciones en zonas cercanas a Zamora. Las autoridades han emitido alertas y están monitoreando la situación para evitar daños mayores.', 2, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Corte de luz en Zamora', 'Un fallo en la red eléctrica ha dejado sin suministro a varios barrios de Zamora. Los equipos técnicos están trabajando para restablecer la electricidad lo antes posible.', 4, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Festival de música', 'Un festival de música en el casco antiguo de Zamora ha atraído a numerosos visitantes. El evento incluye actuaciones de artistas locales y nacionales, y ha generado cortes de tráfico en la zona.', 7, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Accidente de tráfico en la periferia', 'Una colisión entre dos vehículos en la carretera de acceso a Zamora ha dejado varios heridos. Los servicios de emergencia están atendiendo a las víctimas y desviando el tráfico.', 1, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Feria gastronómica', 'Una feria gastronómica en el centro de Zamora ofrece degustaciones de platos tradicionales y actividades culturales. El evento ha atraído a numerosos visitantes y ha generado un ambiente festivo.', 7, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Alerta por vientos fuertes', 'Rachas de viento de hasta 80 km/h están afectando la ciudad de Zamora. Las autoridades recomiendan precaución al circular y asegurar objetos que puedan ser arrastrados por el viento.', 3, 'pendiente', '2025-02-25 15:11:45', 30, NULL),
    ('Emergencia química en Casco Antiguo', 'Un derrame de sustancias químicas en un almacén industrial del Casco Antiguo ha provocado la evacuación de varias calles. Los equipos de emergencia están trabajando para contener el derrame y garantizar la seguridad de los vecinos.', 3, 'pendiente', '2025-02-25 15:11:45', 46, NULL),
    ('Desperfectos por tormenta en San Lázaro', 'Las fuertes lluvias en San Lázaro han causado daños en infraestructuras y cortes de electricidad. Los equipos de mantenimiento están trabajando para reparar los desperfectos.', 2, 'pendiente', '2025-02-25 15:11:45', 47, NULL),
    ('Explosión en San José Obrero', 'Una fuga de gas en un edificio residencial de San José Obrero ha provocado una explosión. Los servicios de emergencia están atendiendo a los heridos y evaluando los daños.', 3, 'pendiente', '2025-02-25 15:11:45', 48, NULL),
    ('Corte de comunicaciones en Pinilla', 'Un fallo en la red de comunicaciones ha dejado sin servicio de telefonía e internet a los residentes de Pinilla. Los técnicos están trabajando para resolver la incidencia.', 6, 'pendiente', '2025-02-25 15:11:45', 49, NULL),
    ('Derrumbe en Los Bloques', 'El colapso de una estructura antigua en Los Bloques ha dejado atrapadas a varias personas. Los equipos de rescate están trabajando para liberar a los afectados.', 4, 'pendiente', '2025-02-25 15:11:45', 50, NULL),
    ('Inundaciones en La Candelaria', 'Las fuertes lluvias han causado el desbordamiento del alcantarillado en La Candelaria, provocando inundaciones en varias calles. Los equipos de emergencia están bombeando el agua y ayudando a los afectados.', 2, 'pendiente', '2025-02-25 15:11:45', 51, NULL),
    ('Emergencia sanitaria en Cabañales', 'Un brote de virus estomacal en Cabañales ha llevado a las autoridades sanitarias a activar un protocolo de emergencia. Se recomienda a los residentes tomar precauciones y seguir las indicaciones de las autoridades.', 5, 'pendiente', '2025-02-25 15:11:45', 52, NULL),
    ('Fallo energético en Pantoja', 'Un corte de electricidad ha dejado sin suministro a toda la comunidad de Pantoja. Los técnicos están trabajando para restablecer la energía lo antes posible.', 4, 'pendiente', '2025-02-25 15:11:45', 53, NULL),
    ('Oleada de robos en San Frontis', 'Un incremento en los robos a comercios locales en San Frontis ha generado preocupación entre los vecinos. La policía ha aumentado la presencia en la zona para prevenir nuevos incidentes.', 3, 'pendiente', '2025-02-25 15:11:45', 54, NULL),
    ('Granizada en Las Viñas', 'Una tormenta de granizo ha causado daños en vehículos y tejados en Las Viñas. Las autoridades recomiendan precaución y revisar los seguros para cubrir los daños.', 2, 'pendiente', '2025-02-25 15:11:45', 55, NULL),
    ('Tornado en San Isidro', 'Un tornado ha tocado tierra en San Isidro, causando daños estructurales en varias viviendas. Los servicios de emergencia están evaluando los daños y ayudando a los afectados.', 3, 'pendiente', '2025-02-25 15:11:45', 56, NULL),
    ('Festival de cine', 'Un festival de cine al aire libre en el casco antiguo ha atraído a numerosos visitantes. El evento incluye proyecciones de películas independientes y actividades culturales.', 7, 'pendiente', '2025-02-25 15:11:45', 46, NULL),
    ('Corte de tráfico por evento', 'Un evento cultural en el centro de la ciudad ha provocado cortes de tráfico en varias calles. Se recomienda utilizar rutas alternativas para evitar retrasos.', 1, 'pendiente', '2025-02-25 15:11:45', 46, NULL),
    ('Fuga de gas en San Lázaro', 'Una fuga de gas en San Lázaro ha obligado a evacuar varios edificios. Los equipos de emergencia están trabajando para reparar la avería y garantizar la seguridad de los vecinos.', 3, 'pendiente', '2025-02-25 15:11:45', 47, NULL),
    ('Actividad vecinal', 'Una jornada de limpieza y actividades comunitarias en San Lázaro ha reunido a los vecinos para mejorar el entorno. El evento promueve la convivencia y el cuidado del barrio.', 7, 'pendiente', '2025-02-25 15:11:45', 47, NULL),
    ('Corte de agua programado', 'Un mantenimiento de tuberías en San José Obrero ha interrumpido el suministro de agua en varias calles. Se espera que el servicio se restablezca en las próximas horas.', 4, 'pendiente', '2025-02-25 15:11:45', 48, NULL),
    ('Evento cultural', 'Un concierto en el parque del barrio de San José Obrero ha atraído a numerosos visitantes. El evento incluye actuaciones de artistas locales y actividades para toda la familia.', 7, 'pendiente', '2025-02-25 15:11:45', 48, NULL),
    ('Robo en vivienda', 'Un asalto a una vivienda en Pinilla ha generado alarma entre los vecinos. La policía está investigando el incidente y ha aumentado la presencia en la zona.', 3, 'pendiente', '2025-02-25 15:11:45', 49, NULL),
    ('Feria de barrio', 'Una feria local en Pinilla ofrece actividades para toda la familia, incluyendo juegos, talleres y puestos de comida tradicional. El evento ha generado un ambiente festivo y ha fortalecido la convivencia entre los vecinos.', 7, 'pendiente', '2025-02-25 15:11:45', 49, NULL),
    ('Corte de luz por mantenimiento', 'Un mantenimiento de la red eléctrica en Los Bloques ha dejado sin luz a varias viviendas. La compañía eléctrica ha informado que el suministro se restablecerá en las próximas horas.', 4, 'pendiente', '2025-02-25 15:11:45', 50, NULL),
    ('Actividad deportiva', 'Un torneo de baloncesto en el polideportivo de Los Bloques ha reunido a equipos locales. El evento promueve el deporte y la convivencia entre los vecinos.', 7, 'pendiente', '2025-02-25 15:11:45', 50, NULL);


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
