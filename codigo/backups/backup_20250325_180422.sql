-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: proyecto_c
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alertas`
--

DROP TABLE IF EXISTS `alertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada alerta',
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la alerta',
  `descripcion` text NOT NULL COMMENT 'Descripción de la alerta',
  `id_etiqueta` int(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
  `estado` enum('pendiente','completado') DEFAULT 'pendiente' COMMENT 'Estado de la alerta',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha de creación de la alerta',
  `fecha_expiracion` timestamp NULL DEFAULT NULL COMMENT 'Fecha de expiración de la alerta',
  `usuario_id` int(11) NOT NULL COMMENT 'numero id, para saber quién publicar las alertas',
  `completado_en` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la que se completó la alerta',
  PRIMARY KEY (`id`),
  KEY `id_etiqueta` (`id_etiqueta`),
  CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alertas`
--

LOCK TABLES `alertas` WRITE;
/*!40000 ALTER TABLE `alertas` DISABLE KEYS */;
INSERT INTO `alertas` VALUES (1,'Alerta 1','Descripción de la alerta 1',NULL,'pendiente','2025-03-24 17:18:26','2025-02-01 12:00:00',13,NULL),(2,'Alerta 2','Descripción de la alerta 2',NULL,'pendiente','2025-03-24 17:18:26','2025-02-02 12:00:00',13,NULL),(3,'Alerta 3','Descripción de la alerta 3',NULL,'pendiente','2025-03-24 17:18:26','2025-02-03 12:00:00',13,NULL),(4,'Alerta 4','Descripción de la alerta 4',NULL,'pendiente','2025-03-24 17:18:26','2025-02-04 12:00:00',13,NULL),(5,'Alerta 5','Descripción de la alerta 5',NULL,'pendiente','2025-03-24 17:18:26','2025-02-05 12:00:00',13,NULL),(6,'Alerta 6','Descripción de la alerta 6',NULL,'pendiente','2025-03-24 17:18:26','2025-02-06 12:00:00',7,NULL),(7,'Alerta 7','Descripción de la alerta 7',NULL,'pendiente','2025-03-24 17:18:26','2025-02-07 12:00:00',7,NULL),(8,'Alerta 8','Descripción de la alerta 8',NULL,'pendiente','2025-03-24 17:18:26','2025-02-08 12:00:00',7,NULL),(9,'Alerta de Tráfico','Accidente en la carretera principal',NULL,'pendiente','2025-03-24 17:18:26','2025-01-31 12:00:00',0,NULL),(10,'Alerta de Clima','Lluvias intensas en la región sur',NULL,'pendiente','2025-03-24 17:18:26','2025-01-25 15:00:00',0,NULL),(11,'Alerta de Seguridad','Robo en el centro comercial',NULL,'pendiente','2025-03-24 17:18:26','2025-01-28 18:00:00',0,NULL),(12,'Alerta de Emergencia','Incendio en el edificio central',NULL,'pendiente','2025-03-24 17:18:26','2025-01-29 20:00:00',0,NULL),(13,'Alerta de Salud','Brote de gripe en la ciudad',NULL,'pendiente','2025-03-24 17:18:26','2025-02-01 09:00:00',0,NULL);
/*!40000 ALTER TABLE `alertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alertas_creados`
--

DROP TABLE IF EXISTS `alertas_creados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alertas_creados` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Titulo` varchar(255) NOT NULL,
  `Descripcion` text DEFAULT NULL,
  `Fecha_de_Vencimiento` date DEFAULT NULL,
  `Acciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alertas_creados`
--

LOCK TABLES `alertas_creados` WRITE;
/*!40000 ALTER TABLE `alertas_creados` DISABLE KEYS */;
INSERT INTO `alertas_creados` VALUES (2,'Alerta 2','Segunda descripción de alerta','2025-03-05','Eliminar'),(3,'Alerta 3','Tercera descripción de alerta','2025-02-20','Eliminar'),(4,'Alerta 4','Cuarta descripción de alerta','2025-04-10','Eliminar'),(5,'Alerta 5','Quinta descripción de alerta','2025-05-15','Eliminar');
/*!40000 ALTER TABLE `alertas_creados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backups`
--

DROP TABLE IF EXISTS `backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backups`
--

LOCK TABLES `backups` WRITE;
/*!40000 ALTER TABLE `backups` DISABLE KEYS */;
INSERT INTO `backups` VALUES (1,'backup_20250325_175945.sql','2025-03-25 16:59:45'),(2,'backup_20250325_180009.sql','2025-03-25 17:00:09');
/*!40000 ALTER TABLE `backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada categoría',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la categoría',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción de la categoría',
  `id_padre` int(11) DEFAULT NULL COMMENT 'ID de la categoría padre (opcional)',
  `id_etiqueta` int(11) DEFAULT NULL COMMENT 'ID de la etiqueta relacionada',
  PRIMARY KEY (`id`),
  KEY `id_padre` (`id_padre`),
  KEY `id_etiqueta` (`id_etiqueta`),
  CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_padre`) REFERENCES `categorias` (`id`) ON DELETE SET NULL,
  CONSTRAINT `categorias_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiquetas` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` text NOT NULL,
  `numero_denuncias` int(11) DEFAULT 0,
  `es_denunciado` tinyint(1) DEFAULT 0,
  `es_visible` tinyint(1) DEFAULT 1,
  `es_cerrado` tinyint(1) DEFAULT 0,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,'Primer comentario de prueba',0,0,0,1,'2025-03-24 17:18:26','2025-03-24 17:18:59'),(2,'Segundo comentario denunciado',2,1,1,0,'2025-03-24 17:18:26','2025-03-24 17:18:26'),(3,'Tercer comentario bloqueado',0,0,0,0,'2025-03-24 17:18:26','2025-03-24 17:18:26'),(4,'Cuarto comentario cerrado',0,0,1,1,'2025-03-24 17:18:26','2025-03-24 17:18:26'),(5,'Quinto comentario activo',1,0,1,0,'2025-03-24 17:18:26','2025-03-24 17:18:26');
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configurations`
--

DROP TABLE IF EXISTS `configurations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configurations`
--

LOCK TABLES `configurations` WRITE;
/*!40000 ALTER TABLE `configurations` DISABLE KEYS */;
INSERT INTO `configurations` VALUES (1,'pagination_size','10','Número de elementos por página','2025-03-24 17:18:26','2025-03-24 17:18:26');
/*!40000 ALTER TABLE `configurations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etiquetas`
--

DROP TABLE IF EXISTS `etiquetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etiquetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada etiqueta',
  `nombre` varchar(255) NOT NULL COMMENT 'Nombre de la etiqueta',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción de la etiqueta',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora de creación',
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Fecha y hora de la última actualización',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etiquetas`
--

LOCK TABLES `etiquetas` WRITE;
/*!40000 ALTER TABLE `etiquetas` DISABLE KEYS */;
/*!40000 ALTER TABLE `etiquetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencia`
--

DROP TABLE IF EXISTS `incidencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único de la incidencia',
  `titulo` varchar(255) NOT NULL COMMENT 'Título de la incidencia',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción detallada de la incidencia',
  `fecha_creacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha de creación',
  `estado` enum('pendiente','procesada') DEFAULT 'pendiente' COMMENT 'Estado de la incidencia',
  `prioridad` enum('alta','media','baja') DEFAULT 'media' COMMENT 'Prioridad de la incidencia',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencia`
--

LOCK TABLES `incidencia` WRITE;
/*!40000 ALTER TABLE `incidencia` DISABLE KEYS */;
INSERT INTO `incidencia` VALUES (1,'Error de conexión','No se puede conectar al servidor de la base de datos.','2025-01-23 10:00:00','pendiente','alta'),(2,'API no responde','La API devuelve un error 500 al intentar obtener datos.','2025-01-23 11:00:00','pendiente','media'),(3,'Problema de inicio de sesión','Usuarios reportan que no pueden iniciar sesión.','2025-01-23 12:00:00','pendiente','media'),(4,'Carga lenta del sistema','El sistema tarda más de lo esperado en cargar datos.','2025-01-23 13:00:00','pendiente','baja'),(5,'Error desconocido en el servidor','Se produjo un error inesperado en el servidor.','2025-01-23 14:00:00','pendiente','alta');
/*!40000 ALTER TABLE `incidencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incidencias`
--

DROP TABLE IF EXISTS `incidencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incidencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `estado` varchar(50) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_revision` datetime DEFAULT NULL,
  `creado_por` int(11) DEFAULT NULL,
  `revisado_por` int(11) DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incidencias`
--

LOCK TABLES `incidencias` WRITE;
/*!40000 ALTER TABLE `incidencias` DISABLE KEYS */;
INSERT INTO `incidencias` VALUES (1,'Primera incidencia','revisada','2025-01-01 00:00:00','2025-03-24 18:18:43',NULL,NULL,NULL),(2,'Segunda incidencia','no revisada','2025-01-05 00:00:00',NULL,NULL,NULL,NULL),(3,'Tercera incidencia','revisada','2025-01-10 00:00:00','2025-01-11 00:00:00',NULL,NULL,NULL),(4,'Cuarta incidencia','no revisada','2025-01-12 00:00:00',NULL,NULL,NULL,NULL),(5,'Quinta incidencia','revisada','2025-01-15 00:00:00','2025-01-16 00:00:00',NULL,NULL,NULL),(6,'Sexta incidencia','no revisada','2025-01-18 00:00:00',NULL,NULL,NULL,NULL),(7,'Séptima incidencia','revisada','2025-01-20 00:00:00','2025-01-21 00:00:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `incidencias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacion`
--

DROP TABLE IF EXISTS `notificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacion`
--

LOCK TABLES `notificacion` WRITE;
/*!40000 ALTER TABLE `notificacion` DISABLE KEYS */;
INSERT INTO `notificacion` VALUES (2,1,'Alerta crítica: Fallo en la conexión con el servicio de base de datos.','2025-02-08 18:30:00'),(3,2,'Advertencia: Espacio de almacenamiento disponible al 90%.','2025-02-07 15:45:00'),(4,2,'Alerta: Se detectó un acceso no autorizado en el sistema.','2025-02-06 12:20:00'),(5,3,'Aviso: Reinicio programado del servidor para mantenimiento.','2025-02-05 08:10:00'),(6,1,'Notificación: Los backups automáticos se completaron exitosamente.','2025-02-04 14:50:00');
/*!40000 ALTER TABLE `notificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID único para cada usuario',
  `email` varchar(255) NOT NULL COMMENT 'Correo electrónico único del usuario',
  `password` varchar(255) NOT NULL COMMENT 'Contraseña encriptada del usuario',
  `auth_key` varchar(255) DEFAULT NULL,
  `nick` varchar(100) NOT NULL COMMENT 'Apodo o nombre de usuario',
  `username` varchar(100) NOT NULL,
  `register_date` datetime DEFAULT current_timestamp() COMMENT 'Fecha de registro del usuario',
  `confirmed` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario ha confirmado su registro',
  `role` enum('guest','normal','moderator','admin','sysadmin') DEFAULT 'normal' COMMENT 'Rol del usuario en el sistema',
  `attempts` int(11) DEFAULT 0 COMMENT 'Intentos fallidos de acceso',
  `locked` tinyint(1) DEFAULT 0 COMMENT 'Indica si el usuario está bloqueado',
  `phone` varchar(15) DEFAULT NULL COMMENT 'Número de teléfono del usuario',
  `status` tinyint(1) DEFAULT 0 COMMENT 'Estado del usuario',
  `failed_attempts` int(11) DEFAULT 0,
  `is_locked` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `estado_revisar` varchar(20) DEFAULT 'no revisada',
  `respuesta` varchar(255) DEFAULT NULL,
  `eliminar_razon` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (3,'dj@usal.es','$2y$13$IXRmKNxfNNMSd7DGQkFo3.aOUovcBEKYby3qojNLF761o4xXfX2.2','h5uq58uxdPNhFEmtStMDYoD2a8V60ebT','djPiri','djPiri','2025-01-14 12:37:44',1,'moderator',0,0,NULL,0,0,1,NULL,'2025-03-24 18:20:47','revisada','是',NULL),(11,'lei@usal.es','$2y$13$.dH9NwMh21kdBnfLcCxSY.aaDNgWo6oC/mB25BEGdFA9YqeWuZh9m','2RNzLCvRJVdbYJk3hPdQq2TeIqhhVLl5','','Lei','2025-03-24 18:19:21',1,'normal',0,0,NULL,0,0,0,'2025-03-24 18:19:21','2025-03-25 16:17:39','no revisada',NULL,'q');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-25 18:04:23
