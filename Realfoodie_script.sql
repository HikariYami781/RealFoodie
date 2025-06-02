-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: realfoodie
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Platos Principales','Segundos platos, carnes, pescados y platos principales',NULL,NULL),(2,'Entrantes y Aperitivos','Tapas, pinchos, ensaladas y primeros platos',NULL,NULL),(3,'Postres','Dulces, tartas, helados y postres caseros',NULL,NULL),(4,'Sopas y Cremas','Sopas calientes, gazpachos y cremas',NULL,NULL),(5,'Arroces y Pasta','Paellas, risottos, pasta italiana y arroces',NULL,NULL),(6,'Legumbres','Lentejas, garbanzos, alubias y platos de cuchara',NULL,NULL),(7,'Verduras y Hortalizas','Platos vegetarianos y con verduras como protagonistas',NULL,NULL),(8,'Bebidas','Cócteles, zumos, infusiones y bebidas refrescantes',NULL,NULL),(9,'Vegana','Recetas 100% vegetales, sin ingredientes de origen animal',NULL,NULL),(10,'Vegetariana','Recetas sin carne ni pescado, pueden incluir huevos y lácteos',NULL,NULL),(11,'Sin Gluten','Recetas aptas para celíacos, sin trigo, avena, cebada ni centeno',NULL,NULL),(13,'Postres Veganos','Dulces y postres sin ingredientes de origen animal',NULL,NULL),(14,'Ensaladas','Ensaladas frescas y nutritivas',NULL,NULL),(15,'Hamburguesas Vegetales','Hamburguesas de origen vegetal',NULL,NULL),(16,'Aperitivos','Entrantes y aperitivos saludables',NULL,NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coleccion_receta`
--

DROP TABLE IF EXISTS `coleccion_receta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coleccion_receta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `coleccion_id` bigint(20) unsigned NOT NULL,
  `receta_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coleccion_receta_coleccion_id_receta_id_unique` (`coleccion_id`,`receta_id`),
  KEY `coleccion_receta_receta_id_foreign` (`receta_id`),
  CONSTRAINT `coleccion_receta_coleccion_id_foreign` FOREIGN KEY (`coleccion_id`) REFERENCES `colecciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `coleccion_receta_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coleccion_receta`
--

LOCK TABLES `coleccion_receta` WRITE;
/*!40000 ALTER TABLE `coleccion_receta` DISABLE KEYS */;
INSERT INTO `coleccion_receta` VALUES (1,1,1,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(2,1,3,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(3,1,9,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(4,1,11,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(5,2,2,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(6,2,5,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(7,2,12,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(8,3,3,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(9,3,11,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(10,3,17,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(11,4,4,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(12,4,12,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(13,4,15,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(14,5,7,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(15,5,13,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(16,5,19,'2025-06-02 19:21:03','2025-06-02 19:21:03'),(17,6,21,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(18,6,22,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(19,6,23,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(20,7,26,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(21,7,27,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(22,8,31,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(23,8,32,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(24,9,35,'2025-06-02 19:22:15','2025-06-02 19:22:15'),(25,9,37,'2025-06-02 19:22:15','2025-06-02 19:22:15');
/*!40000 ALTER TABLE `coleccion_receta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `colecciones`
--

DROP TABLE IF EXISTS `colecciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colecciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `colecciones_user_id_foreign` (`user_id`),
  CONSTRAINT `colecciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colecciones`
--

LOCK TABLES `colecciones` WRITE;
/*!40000 ALTER TABLE `colecciones` DISABLE KEYS */;
INSERT INTO `colecciones` VALUES (1,1,'Recetas de la Abuela','Las recetas tradicionales que nos enseñaron nuestras abuelas','2025-06-02 19:12:44','2025-06-02 19:12:44'),(2,2,'Cocina Mediterránea','Los mejores platos del Mediterráneo español','2025-06-02 19:12:44','2025-06-02 19:12:44'),(3,3,'Postres Caseros','Dulces tradicionales para toda la familia','2025-06-02 19:12:44','2025-06-02 19:12:44'),(4,4,'Cocina Vegetariana','Platos saludables sin carne','2025-06-02 19:12:44','2025-06-02 19:12:44'),(5,5,'Tapas Españolas','Las mejores tapas para compartir','2025-06-02 19:12:44','2025-06-02 19:12:44'),(6,9,'Mis Recetas Veganas Favoritas','Las mejores recetas veganas que he probado','2025-06-02 19:12:44','2025-06-02 19:12:44'),(7,10,'Sin Gluten Imprescindibles','Recetas sin gluten que no pueden faltar','2025-06-02 19:12:44','2025-06-02 19:12:44'),(8,11,'Bebidas para el Verano','Refrescantes bebidas para los días calurosos','2025-06-02 19:12:44','2025-06-02 19:12:44'),(9,12,'Postres Veganos Especiales','Dulces veganos para ocasiones especiales','2025-06-02 19:12:44','2025-06-02 19:12:44');
/*!40000 ALTER TABLE `colecciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `receta_id` bigint(20) unsigned NOT NULL,
  `contenido` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comentarios_user_id_foreign` (`user_id`),
  KEY `comentarios_receta_id_foreign` (`receta_id`),
  CONSTRAINT `comentarios_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
INSERT INTO `comentarios` VALUES (1,2,1,'¡Increíble! La tortilla me quedó perfecta siguiendo tus instrucciones. El truco está en el punto de las patatas.','2025-06-01 08:30:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(2,3,1,'Hice esta tortilla para la cena familiar y fue todo un éxito. Muchas gracias por compartir la receta.','2025-06-01 16:45:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(3,1,2,'Esta paella valenciana es auténtica. Mi suegra valenciana la aprobó, ¡y eso ya es decir mucho!','2025-06-01 18:15:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(4,4,2,'Excelente receta. El secreto está en no remover el arroz una vez añadido el caldo.','2025-06-02 10:00:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(5,1,3,'El flan me quedó súper cremoso. Lo serví en la comunión de mi hija y todo el mundo preguntó por la receta.','2025-06-01 14:20:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(6,5,5,'Este gazpacho está buenísimo. Perfecto para estos días de calor que estamos teniendo.','2025-06-02 11:30:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(7,6,5,'Soy andaluz y confirmo que este gazpacho está hecho como Dios manda. ¡Enhorabuena!','2025-06-02 12:45:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(8,7,6,'El pulpo me quedó tiernísimo. El truco de asustarlo funciona de maravilla.','2025-06-02 17:00:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(9,8,7,'Las croquetas están para chuparse los dedos. La bechamel tiene el punto perfecto.','2025-06-02 19:15:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(10,1,9,'Las lentejas con chorizo son mi plato de cuchara favorito. Esta receta me recuerda a las de mi madre.','2025-06-02 11:00:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(11,3,11,'Las torrijas están espectaculares. Las hice para Semana Santa y triunfaron.','2025-06-02 09:30:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(12,4,12,'La escalivada es perfecta como entrante. Las verduras asadas tienen un sabor increíble.','2025-06-02 18:00:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(13,2,13,'El salmorejo cordobés me encanta. Más espeso que el gazpacho y igual de refrescante.','2025-06-02 12:30:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(14,5,19,'Las patatas bravas están de muerte. La salsa tiene el picante justo.','2025-06-02 20:00:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(15,6,20,'La sopa de ajo es reconfortante como pocas. Perfecta para los días fríos.','2025-06-02 10:45:00','2025-06-02 19:25:40','2025-06-02 19:25:40'),(16,3,8,'El cordero asado me quedó en su punto. La clave está en no abrirlo mucho el horno.','2025-06-02 13:30:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(17,4,10,'El bacalao al pil pil es todo un arte. Me costó varias veces conseguir la salsa perfecta.','2025-06-02 15:45:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(18,5,16,'El cochinillo asado es el plato perfecto para celebraciones especiales. ¡Impresionante!','2025-06-02 17:30:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(19,7,18,'La fabada asturiana me transporta a Asturias cada vez que la hago. Auténtica comfort food.','2025-06-02 19:00:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(20,8,17,'La crema catalana es mi postre favorito. El contraste del azúcar quemado es perfecto.','2025-06-02 14:15:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(21,1,15,'El risotto de setas me quedó cremosísimo. El secreto está en añadir el caldo poco a poco.','2025-06-02 12:00:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(22,2,14,'El marmitako es un plato marinero que me encanta. Perfecto para los días de lluvia.','2025-06-02 10:30:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(23,6,4,'El pisto manchego es perfecto como acompañamiento o como plato principal con un huevo frito encima.','2025-06-02 18:30:00','2025-06-02 19:26:01','2025-06-02 19:26:01'),(24,10,21,'¡Excelente receta! El curry quedó delicioso y muy aromático.','2024-11-16 13:30:00',NULL,NULL),(25,11,21,'Perfecto para una cena rápida y saludable. Lo haré otra vez.','2024-11-17 18:45:00',NULL,NULL),(26,9,26,'No se nota que sea sin gluten, está buenísima la tarta.','2024-11-19 15:20:00',NULL,NULL),(27,12,22,'Me encanta esta ensalada, es muy completa y nutritiva.','2024-11-21 11:15:00',NULL,NULL),(28,9,31,'Refresco perfecto para el desayuno, muy tropical.','2024-12-03 07:30:00',NULL,NULL);
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favoritos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `receta_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favoritos_user_id_receta_id_unique` (`user_id`,`receta_id`),
  KEY `favoritos_receta_id_foreign` (`receta_id`),
  CONSTRAINT `favoritos_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favoritos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favoritos`
--

LOCK TABLES `favoritos` WRITE;
/*!40000 ALTER TABLE `favoritos` DISABLE KEYS */;
INSERT INTO `favoritos` VALUES (1,1,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(2,1,6,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(3,1,10,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(4,2,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(5,2,5,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(6,2,18,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(7,3,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(8,3,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(9,3,19,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(10,4,12,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(11,4,15,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(12,4,4,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(13,5,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(14,5,7,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(15,5,13,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(16,6,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(17,6,10,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(18,6,14,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(19,7,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(20,7,9,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(21,7,20,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(22,8,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(23,8,8,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(24,8,16,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(25,9,26,NULL,NULL),(26,10,21,NULL,NULL),(27,10,22,NULL,NULL),(28,11,21,NULL,NULL),(29,11,35,NULL,NULL),(30,12,22,NULL,NULL),(31,12,31,NULL,NULL);
/*!40000 ALTER TABLE `favoritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredientes`
--

DROP TABLE IF EXISTS `ingredientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `unidad_medida` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredientes`
--

LOCK TABLES `ingredientes` WRITE;
/*!40000 ALTER TABLE `ingredientes` DISABLE KEYS */;
INSERT INTO `ingredientes` VALUES (1,'Patatas','kg','2025-06-02 17:56:32','2025-06-02 17:56:32'),(2,'Huevos','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(3,'Aceite de oliva virgen extra','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(4,'Sal','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(5,'Cebolla','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(6,'Ajo','dientes','2025-06-02 17:56:32','2025-06-02 17:56:32'),(7,'Tomate','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(8,'Pimiento rojo','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(9,'Pimiento verde','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(10,'Arroz bomba','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(11,'Caldo de pollo','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(12,'Pollo','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(13,'Conejo','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(14,'Judías verdes','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(15,'Garrofón','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(16,'Azafrán','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(17,'Pimentón dulce','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(18,'Perejil','pizca','2025-06-02 17:56:32','2025-06-02 17:56:32'),(19,'Limón','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(20,'Pan','rebanadas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(21,'Jamón serrano','lonchas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(22,'Queso manchego','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(23,'Aceitunas','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(24,'Atún','latas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(25,'Mayonesa','cucharadas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(26,'Lechuga','hojas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(27,'Pepino','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(28,'Vinagre de Jerez','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(29,'Harina','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(30,'Azúcar','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(31,'Mantequilla','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(32,'Leche','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(33,'Nata líquida','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(34,'Chocolate negro','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(35,'Vainilla','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(36,'Garbanzos','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(37,'Chorizo','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(38,'Morcilla','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(39,'Tocino','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(40,'Repollo','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(41,'Zanahoria','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(42,'Calabaza','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(43,'Lentejas','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(44,'Laurel','hojas','2025-06-02 17:56:32','2025-06-02 17:56:32'),(45,'Vino blanco','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(46,'Bacalao','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(47,'Pimientos del piquillo','unidades','2025-06-02 17:56:32','2025-06-02 17:56:32'),(48,'Almendras','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(49,'Canela','g','2025-06-02 17:56:32','2025-06-02 17:56:32'),(50,'Miel','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(51,'Garbanzos','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(52,'Alubias blancas','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(53,'Lentejas rojas','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(54,'Quinoa','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(55,'Tofu','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(56,'Tempeh','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(57,'Almendras','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(58,'Nueces','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(59,'Berenjena','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(60,'Calabacín','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(61,'Pimiento rojo','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(62,'Pimiento amarillo','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(63,'Cebolla','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(64,'Ajo','diente','2025-06-02 17:56:32','2025-06-02 17:56:32'),(65,'Tomate','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(66,'Zanahoria','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(67,'Puerro','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(68,'Brócoli','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(69,'Espinacas frescas','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(70,'Harina de arroz','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(71,'Harina de almendra','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(72,'Maicena','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(73,'Harina de coco','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(74,'Curry en polvo','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(75,'Comino','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(76,'Pimentón dulce','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(77,'Cúrcuma','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(78,'Jengibre fresco','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(79,'Aceite de oliva virgen extra','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(80,'Vinagre de manzana','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(81,'Sal marina','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(82,'Pimienta negra','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32'),(83,'Leche de coco','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(84,'Leche de almendras','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(85,'Bebida de soja','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(86,'Nata de coco','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(87,'Arroz integral','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(88,'Avena sin gluten','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(89,'Semillas de chía','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(90,'Semillas de lino','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(91,'Semillas de girasol','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(92,'Plátano','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(93,'Manzana','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(94,'Limón','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(95,'Naranja','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(96,'Papaya','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(97,'Mango','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(98,'Fresas','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(99,'Arándanos','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(100,'Sirope de agave','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(101,'Dátiles','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(102,'Azúcar de coco','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(103,'Stevia','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(104,'Pan rallado sin gluten','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(105,'Levadura nutricional','gr','2025-06-02 17:56:32','2025-06-02 17:56:32'),(106,'Agua','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(107,'Caldo vegetal','ml','2025-06-02 17:56:32','2025-06-02 17:56:32'),(108,'Huevo','unidad','2025-06-02 17:56:32','2025-06-02 17:56:32'),(109,'Vainilla','cdta','2025-06-02 17:56:32','2025-06-02 17:56:32');
/*!40000 ALTER TABLE `ingredientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_02_09_185807_create_categorias_table',1),(5,'2025_02_10_095042_create_ingredientes_table',1),(6,'2025_02_10_095054_create_recetas_table',1),(7,'2025_02_11_082326_create_receta_ingrediente_table',1),(8,'2025_04_07_185951_create_colecciones_table',1),(9,'2025_04_07_190122_create_pasos_table',1),(10,'2025_04_07_190222_create_comentarios_table',1),(11,'2025_04_07_190334_create_favoritos_table',1),(12,'2025_04_07_190416_create_seguidores_table',1),(13,'2025_04_07_190459_create_valoraciones_table',1),(14,'2025_04_07_190537_create_coleccion_receta_table',1),(15,'2025_04_19_213418_change_dificultad_column_in_recetas_table',1),(16,'2025_04_19_214655_add_unidad_to_receta_ingrediente_table',1),(17,'2025_04_21_212340_add_imagen_to_recetas_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pasos`
--

DROP TABLE IF EXISTS `pasos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pasos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `receta_id` bigint(20) unsigned NOT NULL,
  `descripcion` text NOT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pasos_receta_id_foreign` (`receta_id`),
  CONSTRAINT `pasos_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pasos`
--

LOCK TABLES `pasos` WRITE;
/*!40000 ALTER TABLE `pasos` DISABLE KEYS */;
INSERT INTO `pasos` VALUES (1,1,'Pela las patatas y córtalas en láminas de aproximadamente 3 mm de grosor.',1,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(2,1,'Calienta abundante aceite de oliva en una sartén amplia y fríe las patatas a fuego medio durante 15-20 minutos hasta que estén tiernas pero no doradas.',2,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(3,1,'Escurre las patatas y deja que se enfríen ligeramente. Reserva un poco del aceite.',3,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(4,1,'Bate los huevos en un bol grande con una pizca de sal y mezcla suavemente con las patatas.',4,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(5,1,'Calienta una sartén antiadherente de 22-24 cm con un poco del aceite reservado.',5,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(6,1,'Vierte la mezcla de huevo y patatas en la sartén y cuaja a fuego medio-bajo durante 5-6 minutos.',6,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(7,1,'Con ayuda de un plato grande, da la vuelta a la tortilla y cuaja por el otro lado 3-4 minutos más.',7,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(8,1,'Sirve caliente o a temperatura ambiente. ¡La tortilla española está lista!',8,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(9,2,'Corta el pollo y el conejo en trozos medianos. Sazona con sal.',1,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(10,2,'En una paellera, calienta aceite de oliva y sofríe las carnes hasta que estén doradas por todos los lados.',2,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(11,2,'Añade las judías verdes y el garrofón. Sofríe durante 5 minutos.',3,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(12,2,'Incorpora el tomate rallado y el pimentón dulce. Sofríe 2 minutos más.',4,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(13,2,'Añade el arroz y remueve para que se impregne de los sabores durante 2-3 minutos.',5,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(14,2,'Vierte el caldo caliente con el azafrán diluido. No remuevas más a partir de este momento.',6,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(15,2,'Cuece a fuego fuerte durante 10 minutos, después reduce a fuego lento 10 minutos más.',7,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(16,2,'Deja reposar la paella 5 minutos antes de servir. Decora con ramitas de perejil y gajos de limón.',8,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(17,3,'Prepara el caramelo poniendo 100g de azúcar en una sartén a fuego medio hasta que se derrita y tome color dorado.',1,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(18,3,'Vierte el caramelo líquido en el molde del flan y déjalo enfriar para que se endurezca.',2,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(19,3,'Bate los huevos enteros con el azúcar restante hasta que estén bien mezclados.',3,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(20,3,'Calienta la leche con la vainilla sin que llegue a hervir.',4,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(21,3,'Incorpora la leche caliente a los huevos batidos, removiendo suavemente.',5,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(22,3,'Cuela la mezcla para eliminar posibles grumos y viértela sobre el caramelo.',6,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(23,3,'Cuece al baño maría en el horno precalentado a 160°C durante 50-60 minutos.',7,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(24,3,'Deja enfriar completamente antes de desmoldar. Refrigera al menos 4 horas antes de servir.',8,'2025-06-02 18:25:03','2025-06-02 18:25:03'),(25,4,'Preparar todas las verduras: Picar la cebolla y los ajos en trozos pequeños. El pisto manchego se caracteriza por presentar las verduras en dados pequeños para una cocción uniforme.',1,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(26,4,'Cortar los pimientos: Picar el pimiento rojo y el pimiento verde en trozos pequeños para que se cocinen más rápido y mantengan su textura.',2,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(27,4,'Preparar el sofrito base: Poner una cazuela al fuego con un buen chorro de aceite de oliva virgen extra. Cuando esté caliente, añadir la cebolla y los ajos picados. Cocinar a fuego medio durante 3-5 minutos hasta que se pochen.',3,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(28,4,'Añadir los pimientos: Cuando la cebolla esté pochada, agregar los pimientos rojos y verdes. Remover bien para mezclar todos los ingredientes y dejar cocinar unos 10 minutos más, removiendo ocasionalmente para evitar que se quemen.',4,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(29,4,'Preparar el calabacín: Mientras se pochan las verduras anteriores, picar el calabacín en cuadraditos del mismo tamaño que las otras verduras para una cocción homogénea.',5,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(30,4,'Incorporar calabacín y tomate: Añadir a la cazuela los calabacines cortados y el tomate triturado (preferiblemente casero). Agregar sal al gusto. Para el tomate tradicional: hacer un corte en cruz a tomates frescos, escalfar 15 minutos, pasar por agua fría, retirar la piel y triturar.',6,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(31,4,'Cocción lenta: Remover todos los ingredientes y dejar cocinar a fuego lento durante unos 30 minutos o hasta que todas las verduras estén tiernas y el conjunto tenga la consistencia deseada. La clave está en la paciencia y el fuego lento.',7,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(32,4,'Ajustar sabor y textura: Probar de sal y rectificar si es necesario. Si observamos que el pisto se pega al fondo, añadir un poco más de tomate triturado o un vasito de agua para mantener la humedad.',8,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(33,4,'Reposo final: Una vez terminada la cocción, dejar reposar el pisto entre 20-30 minutos para que se asiente y adquiera la textura típica del pisto manchego tradicional.',9,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(34,4,'Servir: El pisto manchego está listo para servir como acompañamiento de carnes, pescados, o como plato principal. Opcionalmente, se puede servir con un huevo frito o escalfado por encima para la presentación tradicional.',10,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(35,5,'Remoja el pan duro en agua durante 15 minutos hasta que esté bien empapado.',1,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(36,5,'Pela y trocea los tomates, pepino, pimiento y cebolla. Pela los dientes de ajo.',2,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(37,5,'En una batidora, tritura todos los ingredientes: verduras, pan escurrido, aceite, vinagre y sal.',3,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(38,5,'Pasa la mezcla por un colador fino para obtener una textura suave y homogénea.',4,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(39,5,'Prueba y ajusta de sal y vinagre según tu gusto.',5,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(40,5,'Refrigera durante al menos 2 horas antes de servir.',6,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(41,5,'Sirve bien frío acompañado de daditos de pepino, tomate, pimiento y pan tostado.',7,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(42,6,'Congela el pulpo la noche anterior para que se ablande la carne.',1,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(43,6,'Pon una olla grande con agua a hervir. Añade cebolla y hojas de laurel.',2,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(44,6,'Sumerge el pulpo 3 veces en el agua hirviendo antes de dejarlo cocer (esto es \"asustarlo\").',3,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(45,6,'Cuece el pulpo durante 45-60 minutos dependiendo del tamaño, hasta que esté tierno.',4,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(46,6,'Mientras tanto, cuece las patatas por separado con piel hasta que estén tiernas.',5,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(47,6,'Saca el pulpo del agua y déjalo reposar 10 minutos antes de cortarlo.',6,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(48,6,'Corta el pulpo en rodajas de 1 cm y las patatas en láminas gruesas.',7,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(49,6,'Sirve en plato de madera, espolvorea con pimentón dulce, sal gorda y riega con aceite de oliva.',8,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(50,7,'Pica muy fino el jamón serrano, casi hasta convertirlo en polvo.',1,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(51,7,'En una sartén, derrite la mantequilla a fuego medio y añade la harina removiendo constantemente.',2,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(52,7,'Incorpora la leche poco a poco, sin dejar de remover, hasta obtener una bechamel espesa.',3,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(53,7,'Añade el jamón picado a la bechamel y mezcla bien. Sazona con sal y pimienta.',4,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(54,7,'Extiende la mezcla en una bandeja y deja enfriar en la nevera durante al menos 4 horas.',5,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(55,7,'Con las manos húmedas, forma las croquetas de tamaño uniforme.',6,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(56,7,'Pasa cada croqueta por harina, huevo batido y pan rallado, en ese orden.',7,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(57,7,'Fríe en aceite muy caliente hasta que estén doradas por todos los lados. Sirve inmediatamente.',8,'2025-06-02 18:28:21','2025-06-02 18:28:21'),(58,4,'Preparar todas las verduras: Picar la cebolla y los ajos en trozos pequeños. El pisto manchego se caracteriza por presentar las verduras en dados pequeños para una cocción uniforme.',1,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(59,4,'Cortar los pimientos: Picar el pimiento rojo y el pimiento verde en trozos pequeños para que se cocinen más rápido y mantengan su textura.',2,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(60,4,'Preparar el sofrito base: Poner una cazuela al fuego con un buen chorro de aceite de oliva virgen extra. Cuando esté caliente, añadir la cebolla y los ajos picados. Cocinar a fuego medio durante 3-5 minutos hasta que se pochen.',3,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(61,4,'Añadir los pimientos: Cuando la cebolla esté pochada, agregar los pimientos rojos y verdes. Remover bien para mezclar todos los ingredientes y dejar cocinar unos 10 minutos más, removiendo ocasionalmente para evitar que se quemen.',4,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(62,4,'Preparar el calabacín: Mientras se pochan las verduras anteriores, picar el calabacín en cuadraditos del mismo tamaño que las otras verduras para una cocción homogénea.',5,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(63,4,'Incorporar calabacín y tomate: Añadir a la cazuela los calabacines cortados y el tomate triturado (preferiblemente casero). Agregar sal al gusto. Para el tomate tradicional: hacer un corte en cruz a tomates frescos, escalfar 15 minutos, pasar por agua fría, retirar la piel y triturar.',6,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(64,4,'Cocción lenta: Remover todos los ingredientes y dejar cocinar a fuego lento durante unos 30 minutos o hasta que todas las verduras estén tiernas y el conjunto tenga la consistencia deseada. La clave está en la paciencia y el fuego lento.',7,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(65,4,'Ajustar sabor y textura: Probar de sal y rectificar si es necesario. Si observamos que el pisto se pega al fondo, añadir un poco más de tomate triturado o un vasito de agua para mantener la humedad.',8,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(66,4,'Reposo final: Una vez terminada la cocción, dejar reposar el pisto entre 20-30 minutos para que se asiente y adquiera la textura típica del pisto manchego tradicional.',9,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(67,4,'Servir: El pisto manchego está listo para servir como acompañamiento de carnes, pescados, o como plato principal. Opcionalmente, se puede servir con un huevo frito o escalfado por encima para la presentación tradicional.',10,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(68,5,'Remoja el pan duro en agua durante 15 minutos hasta que esté bien empapado.',1,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(69,5,'Pela y trocea los tomates, pepino, pimiento y cebolla. Pela los dientes de ajo.',2,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(70,5,'En una batidora, tritura todos los ingredientes: verduras, pan escurrido, aceite, vinagre y sal.',3,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(71,5,'Pasa la mezcla por un colador fino para obtener una textura suave y homogénea.',4,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(72,5,'Prueba y ajusta de sal y vinagre según tu gusto.',5,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(73,5,'Refrigera durante al menos 2 horas antes de servir.',6,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(74,5,'Sirve bien frío acompañado de daditos de pepino, tomate, pimiento y pan tostado.',7,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(75,6,'Congela el pulpo la noche anterior para que se ablande la carne.',1,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(76,6,'Pon una olla grande con agua a hervir. Añade cebolla y hojas de laurel.',2,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(77,6,'Sumerge el pulpo 3 veces en el agua hirviendo antes de dejarlo cocer (esto es \"asustarlo\").',3,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(78,6,'Cuece el pulpo durante 45-60 minutos dependiendo del tamaño, hasta que esté tierno.',4,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(79,6,'Mientras tanto, cuece las patatas por separado con piel hasta que estén tiernas.',5,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(80,6,'Saca el pulpo del agua y déjalo reposar 10 minutos antes de cortarlo.',6,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(81,6,'Corta el pulpo en rodajas de 1 cm y las patatas en láminas gruesas.',7,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(82,6,'Sirve en plato de madera, espolvorea con pimentón dulce, sal gorda y riega con aceite de oliva.',8,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(83,7,'Pica muy fino el jamón serrano, casi hasta convertirlo en polvo.',1,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(84,7,'En una sartén, derrite la mantequilla a fuego medio y añade la harina removiendo constantemente.',2,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(85,7,'Incorpora la leche poco a poco, sin dejar de remover, hasta obtener una bechamel espesa.',3,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(86,7,'Añade el jamón picado a la bechamel y mezcla bien. Sazona con sal y pimienta.',4,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(87,7,'Extiende la mezcla en una bandeja y deja enfriar en la nevera durante al menos 4 horas.',5,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(88,7,'Con las manos húmedas, forma las croquetas de tamaño uniforme.',6,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(89,7,'Pasa cada croqueta por harina, huevo batido y pan rallado, en ese orden.',7,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(90,7,'Fríe en aceite muy caliente hasta que estén doradas por todos los lados. Sirve inmediatamente.',8,'2025-06-02 18:30:45','2025-06-02 18:30:45'),(91,8,'Precalienta el horno a 180°C.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(92,8,'Sazona el cordero con sal, pimienta, ajo picado y romero fresco.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(93,8,'Corta las patatas en trozos medianos y colócalas en la bandeja de horno.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(94,8,'Coloca el cordero sobre las patatas en la bandeja.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(95,8,'Riega con aceite de oliva y vino blanco por toda la superficie.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(96,8,'Hornea durante 45 minutos, luego da la vuelta al cordero.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(97,8,'Continúa horneando otros 45 minutos más hasta que esté dorado.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(98,8,'Deja reposar 10 minutos antes de servir.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(99,9,'Pon las lentejas en remojo la noche anterior.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(100,9,'Escurre y enjuaga las lentejas.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(101,9,'En una olla grande, sofríe la cebolla picada hasta que esté transparente.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(102,9,'Añade el ajo picado, la zanahoria en daditos y el chorizo troceado.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(103,9,'Sofríe todo junto durante 5 minutos.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(104,9,'Incorpora las lentejas y cubre con caldo caliente.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(105,9,'Añade el pimentón dulce, la hoja de laurel y sal al gusto.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(106,9,'Cuece a fuego medio durante 30 minutos hasta que las lentejas estén tiernas.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(107,9,'Sirve caliente con un chorrito de aceite de oliva crudo.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(108,10,'Desala el bacalao sumergiéndolo en agua fría durante 24-48 horas, cambiando el agua varias veces.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(109,10,'Seca bien el bacalao con papel de cocina.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(110,10,'Lamina los ajos finamente.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(111,10,'En una sartén, confita los ajos laminados en aceite de oliva suave a temperatura baja.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(112,10,'Retira los ajos cuando estén dorados y reserva.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(113,10,'En el mismo aceite, confita el bacalao con la piel hacia arriba durante 15 minutos.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(114,10,'Traslada el bacalao a una cazuela de barro.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(115,10,'Vierte el aceite de confitar y mueve la cazuela en círculos para emulsionar y crear el pil pil.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(116,10,'Decora con los ajos confitados y sirve inmediatamente.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(117,11,'Hierve la leche con una rama de canela y cáscara de limón.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(118,11,'Deja enfriar la leche infusionada completamente.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(119,11,'Corta el pan en rebanadas de 2 cm de grosor.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(120,11,'Empapa cada rebanada en la leche fría durante unos segundos.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(121,11,'Pasa las rebanadas empapadas por huevo batido.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(122,11,'Fríe en aceite caliente hasta que estén doradas por ambos lados.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(123,11,'Escurre sobre papel absorbente.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(124,11,'Reboza inmediatamente en azúcar mezclado con canela en polvo.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(125,12,'Precalienta el horno a 200°C.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(126,12,'Coloca las berenjenas, pimientos rojos y cebollas enteros en una bandeja de horno.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(127,12,'Asa las verduras durante 45 minutos o hasta que estén tiernas y la piel se desprenda fácilmente.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(128,12,'Retira del horno y deja enfriar.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(129,12,'Pela todas las verduras y retira las semillas de los pimientos.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(130,12,'Corta las verduras en tiras anchas.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(131,12,'Coloca en una fuente y aliña con aceite de oliva, sal y vinagre.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(132,12,'Deja macerar al menos 30 minutos antes de servir.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(133,13,'Remoja el pan duro en agua durante 10 minutos.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(134,13,'Escurre el pan y desmiga.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(135,13,'Pela y trocea los tomates muy maduros.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(136,13,'Tritura los tomates con el pan, un diente de ajo, aceite de oliva y sal.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(137,13,'Bate hasta obtener una crema espesa y homogénea.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(138,13,'Pasa la mezcla por un colador fino.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(139,13,'Refrigera durante al menos 2 horas.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(140,13,'Sirve frío decorado con huevo duro picado y jamón serrano en daditos.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(141,14,'Sofríe la cebolla cortada en juliana en aceite de oliva hasta que esté transparente.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(142,14,'Añade los pimientos cortados en tiras y sofríe 5 minutos más.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(143,14,'Incorpora el tomate rallado y cocina hasta que se evapore el agua.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(144,14,'Añade las patatas cortadas en trozos irregulares (a cuchillo).',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(145,14,'Cubre con caldo de pescado caliente.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(146,14,'Cuece durante 15 minutos hasta que las patatas estén tiernas.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(147,14,'Incorpora el atún en trozos grandes.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(148,14,'Cuece 5 minutos más sin remover demasiado.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(149,14,'Rectifica de sal y sirve caliente.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(150,15,'Limpia y lamina las setas variadas.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(151,15,'Rehoga las setas en una sartén con aceite hasta que estén doradas. Reserva.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(152,15,'Calienta el caldo de verduras y manténlo caliente.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(153,15,'En una olla, sofríe la cebolla picada finamente hasta que esté transparente.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(154,15,'Añade el arroz y tuesta durante 2 minutos removiendo constantemente.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(155,15,'Vierte el vino blanco y remueve hasta que se evapore.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(156,15,'Añade el caldo caliente poco a poco, cucharón a cucharón, removiendo constantemente.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(157,15,'Continúa añadiendo caldo y removiendo durante 18-20 minutos.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(158,15,'Incorpora las setas salteadas, mantequilla y queso parmesano.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(159,15,'Remueve hasta obtener una textura cremosa y sirve inmediatamente.',10,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(160,16,'Precalienta el horno a 180°C.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(161,16,'Sazona el cochinillo por dentro y por fuera con sal gorda.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(162,16,'Unta toda la superficie con manteca de cerdo.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(163,16,'Coloca el cochinillo en una bandeja de horno grande con un poco de agua en el fondo.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(164,16,'Hornea boca abajo durante la primera hora.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(165,16,'Riega frecuentemente con sus propios jugos.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(166,16,'Dale la vuelta y continúa asando 1-2 horas más según el tamaño.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(167,16,'Los últimos 30 minutos, sube la temperatura para dorar la piel.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(168,16,'Deja reposar 15 minutos antes de trinchar.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(169,17,'Hierve la leche con cáscara de limón y una rama de canela.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(170,17,'En un bol, bate las yemas de huevo con azúcar hasta blanquear.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(171,17,'Añade la maicena a las yemas y mezcla bien.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(172,17,'Incorpora la leche caliente poco a poco a las yemas, removiendo constantemente.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(173,17,'Vuelve la mezcla al fuego y cuece removiendo hasta que espese.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(174,17,'Retira del fuego y cuela la crema.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(175,17,'Reparte en cazuelitas individuales y deja enfriar.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(176,17,'Refrigera durante al menos 4 horas.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(177,17,'Antes de servir, espolvorea azúcar por encima y quema con soplete.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(178,18,'Pon las fabes en remojo durante 24 horas.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(179,18,'Escurre y enjuaga las fabes.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(180,18,'En una olla grande, coloca las fabes con agua fría.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(181,18,'Añade el lacón, chorizo y morcilla.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(182,18,'Lleva a ebullición y espuma.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(183,18,'Reduce el fuego y cuece a fuego lento durante 2 horas.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(184,18,'A media cocción, añade una pizca de azafrán y pimentón dulce.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(185,18,'Sala al final de la cocción.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(186,18,'Debe quedar caldosa pero no aguada.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(187,18,'Sirve muy caliente con los compangos troceados.',10,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(188,19,'Corta las patatas en dados de tamaño similar.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(189,19,'Fríe las patatas en aceite caliente hasta que estén doradas y crujientes.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(190,19,'Escurre sobre papel absorbente y reserva.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(191,19,'Para la salsa brava: sofríe ajo picado en aceite.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(192,19,'Añade tomate frito, pimentón dulce y cayena al gusto.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(193,19,'Incorpora un poco de caldo y cuece 10 minutos.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(194,19,'Sazona la salsa con sal.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(195,19,'Sirve las patatas calientes cubiertas con la salsa brava.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(196,19,'Acompaña con mayonesa al lado.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(197,20,'Corta el pan en rebanadas finas.',1,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(198,20,'Lamina los ajos finamente.',2,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(199,20,'En una cazuela de barro, dora las rebanadas de pan en aceite.',3,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(200,20,'Añade los ajos laminados y dora sin que se quemen.',4,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(201,20,'Incorpora el pimentón dulce y remueve rápidamente.',5,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(202,20,'Añade agua o caldo caliente y sal.',6,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(203,20,'Cuece durante 15 minutos a fuego suave.',7,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(204,20,'Casca los huevos directamente sobre la sopa.',8,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(205,20,'Cuece hasta que los huevos cuajen a tu gusto.',9,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(206,20,'Sirve inmediatamente bien caliente.',10,'2025-06-02 18:34:16','2025-06-02 18:34:16'),(207,21,'Escurrir y enjuagar los garbanzos si son de bote. Si son secos, cocerlos previamente hasta que estén tiernos.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(208,21,'Picar finamente la cebolla y el ajo. Cortar la zanahoria en cubitos pequeños.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(209,21,'Calentar aceite de oliva en una sartén grande y sofreír la cebolla hasta que esté transparente.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(210,21,'Añadir el ajo y la zanahoria, cocinar 3 minutos más.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(211,21,'Incorporar el curry en polvo, comino y cúrcuma. Mezclar bien y cocinar 1 minuto.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(212,21,'Agregar los garbanzos y el caldo vegetal. Dejar cocinar 15 minutos a fuego medio.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(213,21,'Servir sobre arroz integral cocido y decorar con cilantro fresco.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(214,22,'Enjuagar la quinoa bajo agua fría hasta que el agua salga clara.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(215,22,'Cocinar la quinoa en agua hirviendo con sal durante 15 minutos hasta que esté tierna.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(216,22,'Mientras tanto, cortar el pimiento, tomate y cebolla en cubitos pequeños.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(217,22,'Preparar el aliño mezclando aceite de oliva, vinagre de manzana, sal y pimienta.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(218,22,'Dejar enfriar la quinoa y mezclar con las verduras cortadas.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(219,22,'Aliñar la ensalada y añadir las almendras picadas por encima.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(220,22,'Dejar reposar 10 minutos antes de servir para que se integren los sabores.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(221,23,'Precalienta el horno a 200°C. Lava las berenjenas y córtalas por la mitad a lo largo.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(222,23,'Haz cortes profundos en la pulpa de las berenjenas sin llegar a la piel, sazona con sal y deja reposar 30 minutos.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(223,23,'Vacía las berenjenas con una cuchara extrayendo la pulpa y reserva. Coloca las berenjenas vacías en una fuente de horno.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(224,23,'Pica la cebolla, el pimiento, el calabacín y el tomate. Sofríe todas las verduras en una sartén con aceite de oliva durante 10 minutos.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(225,23,'Incorpora la pulpa de berenjena reservada al sofrito y cocina 5 minutos más. Sazona con sal, pimienta y hierbas aromáticas.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(226,23,'Rellena las berenjenas vacías con el sofrito de verduras, presionando ligeramente para que quede compacto.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(227,23,'Espolvorea queso rallado vegano por encima de cada berenjena rellena (opcional).',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(228,23,'Hornea durante 25-30 minutos hasta que las berenjenas estén tiernas y el relleno dorado.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(229,24,'Pela y pica 1 cebolla, 1 zanahoria, 1 puerro mediano y 2 dientes de ajo.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(230,24,'Calienta 4 cucharadas de aceite de oliva en una sartén y sofríe la cebolla, zanahoria y puerro a fuego medio durante 10 minutos removiendo frecuentemente.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(231,24,'Añade el ajo picado al sofrito y rehogar 1 minuto más. Reserva la mitad del sofrito.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(232,24,'En un robot de cocina, tritura ligeramente 400g de alubias blancas cocidas, 100g de arroz cocido y la mitad del sofrito.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(233,24,'Transfiere la mezcla a un bol e incorpora el resto del sofrito reservado y 50g de almendras molidas.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(234,24,'Añade 2 cucharadas de pan rallado si es necesario para ajustar la consistencia. Sazona con sal, pimienta y una pizca de comino.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(235,24,'Divide la masa en 4 porciones y forma hamburguesas con las manos o usando un aro de emplatar.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(236,24,'Engrasa una sartén con aceite y dora las hamburguesas 2-3 minutos por cada lado hasta que estén doradas.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(237,25,'Lava los calabacines y corta los extremos. Córtalos en rodajas de aproximadamente 1 cm de grosor.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(238,25,'Seca las rodajas de calabacín con papel de cocina para eliminar el exceso de humedad.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(239,25,'Calienta una plancha o sartén antiadherente a fuego medio-alto.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(240,25,'Rocía las rodajas de calabacín con aceite de oliva virgen extra por ambos lados.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(241,25,'Coloca las rodajas en la plancha caliente y cocina durante 2-3 minutos por cada lado hasta que tengan marcas doradas.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(242,25,'Sazona con sal y pimienta al gusto. Opcionalmente añade hierbas frescas como tomillo o romero.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(243,25,'Sirve inmediatamente como guarnición o acompañamiento.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(244,26,'Precalienta el horno a 180°C. Engrasa un molde de tarta de 24 cm con aceite vegetal.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(245,26,'Mezcla 250g de harina sin gluten, 100g de azúcar y una pizca de sal en un bol grande.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(246,26,'Incorpora 100ml de aceite vegetal neutro y 2-3 cucharadas de bebida vegetal hasta formar una masa homogénea.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(247,26,'Extiende la masa en el molde engrasado, cubriendo el fondo y los bordes uniformemente.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(248,26,'Pela y lamina 4-5 manzanas. Colócalas sobre la masa formando círculos concéntricos.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(249,26,'Espolvorea las manzanas con 2 cucharadas de azúcar y canela al gusto.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(250,26,'Hornea durante 45-50 minutos hasta que la masa esté dorada y las manzanas tiernas.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(251,26,'Deja enfriar antes de desmoldar y servir. Opcionalmente, glasea con mermelada de albaricoque.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(252,27,'Precalienta el horno a 180°C. Engrasa y enharina un molde de bizcocho con harina sin gluten.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(253,27,'Bate 3 huevos con 150g de azúcar hasta que la mezcla blanquee y doble su volumen.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(254,27,'Tamiza 200g de harina sin gluten con 1 cucharadita de levadura en polvo.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(255,27,'Incorpora gradualmente la harina tamizada a la mezcla de huevos batiendo suavemente.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(256,27,'Añade 100ml de aceite vegetal y 100ml de bebida vegetal, mezclando hasta obtener una masa homogénea.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(257,27,'Vierte la masa en el molde preparado y alisa la superficie.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(258,27,'Hornea durante 35-40 minutos o hasta que al insertar un palillo salga limpio.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(259,27,'Deja enfriar en el molde 10 minutos antes de desmoldar sobre una rejilla.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(260,28,'Precalienta el horno a 180°C. Forra una bandeja de horno con papel vegetal.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(261,28,'Mezcla 100g de harina de arroz, 50g de harina de almendra y una pizca de sal en un bol.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(262,28,'En otro bol, bate 80g de azúcar con 60ml de aceite vegetal hasta formar una crema.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(263,28,'Incorpora las harinas mezcladas a la crema de azúcar y aceite, mezclando hasta formar una masa.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(264,28,'Añade 1 cucharadita de esencia de vainilla y mezcla bien.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(265,28,'Forma bolitas con la masa y colócalas en la bandeja preparada, dejando espacio entre ellas.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(266,28,'Aplasta ligeramente cada bolita con un tenedor para darles forma de galleta.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(267,28,'Hornea durante 12-15 minutos hasta que los bordes estén ligeramente dorados.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(268,28,'Deja enfriar en la bandeja antes de transferir a una rejilla.',9,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(269,29,'En un bol, mezcla 100g de maicena, 50g de harina de arroz y una pizca de sal.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(270,29,'Bate 2 huevos en otro bol hasta que estén bien mezclados.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(271,29,'Incorpora gradualmente 300ml de bebida vegetal a los huevos batiendo constantemente.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(272,29,'Añade las harinas tamizadas a la mezcla líquida y bate hasta obtener una masa lisa sin grumos.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(273,29,'Incorpora 2 cucharadas de aceite vegetal a la masa y mezcla bien. Deja reposar 30 minutos.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(274,29,'Calienta una sartén antiadherente a fuego medio y engrase ligeramente con aceite.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(275,29,'Vierte un cucharón de masa en la sartén y extiende girando la sartén para formar un crepe fino.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(276,29,'Cocina 1-2 minutos hasta que los bordes se despeguen, dale la vuelta y cocina 1 minuto más.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(277,29,'Repite el proceso con el resto de la masa. Sirve calientes con el relleno deseado.',9,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(278,30,'Precalienta el horno a 180°C. Prepara bandejas de horno con papel vegetal.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(279,30,'Mezcla 200g de harina sin gluten, 100g de azúcar, 1 cucharadita de polvo de hornear y una pizca de sal.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(280,30,'Incorpora 100g de margarina vegetal blanda y mezcla hasta formar una masa arenosa.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(281,30,'Añade 1 huevo batido y 1 cucharadita de esencia de vainilla, integrando hasta formar una masa homogénea.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(282,30,'Extiende la masa con un rodillo entre dos papeles vegetal hasta 5mm de grosor.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(283,30,'Corta círculos con un cortante y haz un agujero pequeño en el centro de cada uno.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(284,30,'Coloca las pepas en las bandejas preparadas dejando espacio entre ellas.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(285,30,'Rellena el centro de cada pepa con dulce de membrillo o mermelada.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(286,30,'Hornea durante 20-25 minutos hasta que estén ligeramente doradas.',9,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(287,30,'Deja enfriar completamente antes de retirar de la bandeja.',10,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(288,31,'Pelar y cortar la papaya en trozos, desechando las semillas.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(289,31,'Colocar la papaya en la batidora junto con la leche de coco fría.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(290,31,'Añadir una pizca de vainilla y endulzante al gusto si se desea.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(291,31,'Batir hasta obtener una mezcla homogénea y cremosa.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(292,31,'Servir inmediatamente en vasos fríos, decorar con coco rallado.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(293,32,'Lava y desinfecta 2 tazas de espinacas frescas, retirando los tallos más gruesos.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(294,32,'Pela y corta en trozos 1 manzana verde, removiendo el corazón y las semillas.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(295,32,'Pela y corta un trozo pequeño de jengibre fresco (1 cm aproximadamente).',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(296,32,'Exprime el zumo de medio limón y reserva.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(297,32,'Coloca todos los ingredientes en la batidora: espinacas, manzana, jengibre y zumo de limón.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(298,32,'Añade 200ml de agua fría y 1 cucharadita de miel o sirope de agave (opcional).',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(299,32,'Bate a alta velocidad durante 1-2 minutos hasta obtener una mezcla homogénea y cremosa.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(300,32,'Sirve inmediatamente en un vaso alto, opcionalmente con hielo.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(301,33,'Lava 100g de fresas y retira las hojas verdes. Corta en mitades si son muy grandes.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(302,33,'Mide 50g de arándanos frescos o congelados.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(303,33,'Pela y corta en rodajas 1 plátano maduro.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(304,33,'Coloca todos los frutos en la batidora junto con 150ml de bebida vegetal o yogur natural.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(305,33,'Añade 1 cucharada de miel o sirope de arce para endulzar (opcional).',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(306,33,'Bate a alta velocidad durante 1-2 minutos hasta obtener una textura cremosa y homogénea.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(307,33,'Prueba y ajusta el dulzor si es necesario.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(308,33,'Sirve inmediatamente en vasos fríos, decorando con frutos rojos enteros.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(309,34,'Coloca 2 cucharadas de semillas de chía en un vaso grande de 300ml.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(310,34,'Añade 250ml de agua filtrada a temperatura ambiente.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(311,34,'Exprime el zumo de medio limón y añádelo al vaso.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(312,34,'Añade 1 cucharadita de miel o sirope de agave para endulzar (opcional).',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(313,34,'Mezcla bien todos los ingredientes con una cuchara.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(314,34,'Deja reposar 5 minutos y vuelve a mezclar para evitar que las semillas se aglomeren.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(315,34,'Refrigera durante al menos 30 minutos o hasta que las semillas formen un gel.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(316,34,'Sirve frío, mezclando antes de beber. Se conserva en refrigerador hasta 2 días.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(317,35,'Remoja 200g de anacardos crudos en agua durante 4 horas o toda la noche.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(318,35,'Prepara la base triturando 200g de galletas veganas con 80g de margarina vegetal derretida.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(319,35,'Presiona la mezcla de galletas en el fondo de un molde desmoldable de 20 cm. Refrigera 30 minutos.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(320,35,'Escurre los anacardos y colócalos en una batidora potente con 200g de tofu sedoso escurrido.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(321,35,'Añade 80ml de sirope de agave, el zumo de 1 limón y 1 cucharadita de esencia de vainilla.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(322,35,'Bate hasta obtener una crema completamente lisa y sin grumos (3-4 minutos).',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(323,35,'Vierte la crema sobre la base de galletas y alisa la superficie con una espátula.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(324,35,'Refrigera durante al menos 4 horas o toda la noche hasta que esté firme.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(325,35,'Desmolda cuidadosamente antes de servir. Decora con frutos rojos si se desea.',9,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(326,36,'Refrigera una lata de leche de coco entera durante toda la noche sin agitar.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(327,36,'Abre la lata con cuidado y extrae solo la parte sólida de la superficie con una cuchara.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(328,36,'Coloca la parte sólida del coco en un bol frío y desecha el líquido del fondo.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(329,36,'Bate con varillas eléctricas durante 2-3 minutos hasta obtener una textura de nata montada.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(330,36,'Añade 1-2 cucharadas de azúcar glass o sirope de agave al gusto mientras bates.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(331,36,'Incorpora unas gotas de esencia de vainilla si se desea.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(332,36,'Utiliza inmediatamente o conserva en refrigerador hasta 3 días.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(333,37,'Derrite 150g de chocolate negro vegano al baño maría o en microondas, removiendo frecuentemente.',1,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(334,37,'Pela y deshiesa 2 aguacates maduros, asegurándote de que estén en su punto óptimo de madurez.',2,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(335,37,'Coloca la pulpa de aguacate en una batidora o procesador de alimentos.',3,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(336,37,'Añade el chocolate derretido templado a los aguacates.',4,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(337,37,'Incorpora 3 cucharadas de cacao en polvo sin azúcar y 3 cucharadas de sirope de agave.',5,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(338,37,'Bate hasta obtener una mezcla completamente lisa y homogénea sin grumos.',6,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(339,37,'Prueba y ajusta el dulzor añadiendo más sirope si es necesario.',7,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(340,37,'Reparte en 4 copas individuales y refrigera durante al menos 2 horas.',8,'2025-06-02 18:55:27','2025-06-02 18:55:27'),(341,37,'Sirve frío, opcionalmente decorado con frutos rojos o virutas de chocolate.',9,'2025-06-02 18:55:27','2025-06-02 18:55:27');
/*!40000 ALTER TABLE `pasos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `receta_ingrediente`
--

DROP TABLE IF EXISTS `receta_ingrediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `receta_ingrediente` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `receta_id` bigint(20) unsigned NOT NULL,
  `ingrediente_id` bigint(20) unsigned NOT NULL,
  `cantidad` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unidad` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receta_ingrediente_receta_id_foreign` (`receta_id`),
  KEY `receta_ingrediente_ingrediente_id_foreign` (`ingrediente_id`),
  CONSTRAINT `receta_ingrediente_ingrediente_id_foreign` FOREIGN KEY (`ingrediente_id`) REFERENCES `ingredientes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `receta_ingrediente_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `receta_ingrediente`
--

LOCK TABLES `receta_ingrediente` WRITE;
/*!40000 ALTER TABLE `receta_ingrediente` DISABLE KEYS */;
INSERT INTO `receta_ingrediente` VALUES (1,1,1,0.8,'2025-06-02 18:58:42','2025-06-02 18:58:42','kg'),(2,1,2,6,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(3,1,3,200,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(4,1,4,5,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(5,2,10,400,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(6,2,11,1200,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(7,2,12,400,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(8,2,13,400,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(9,2,14,200,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(10,2,15,100,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(11,2,16,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(12,2,17,5,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(13,2,3,80,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(14,2,7,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(15,2,4,10,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(16,3,2,4,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(17,3,32,500,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(18,3,30,150,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(19,3,35,5,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(20,5,7,1000,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(21,5,27,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(22,5,8,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(23,5,5,0.5,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(24,5,6,2,'2025-06-02 18:58:42','2025-06-02 18:58:42','dientes'),(25,5,20,50,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(26,5,3,60,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(27,5,28,15,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(28,5,4,8,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(29,9,43,400,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(30,9,37,150,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(31,9,5,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(32,9,6,2,'2025-06-02 18:58:42','2025-06-02 18:58:42','dientes'),(33,9,41,1,'2025-06-02 18:58:42','2025-06-02 18:58:42','unidades'),(34,9,44,2,'2025-06-02 18:58:42','2025-06-02 18:58:42','hojas'),(35,9,17,5,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(36,9,3,30,'2025-06-02 18:58:42','2025-06-02 18:58:42','ml'),(37,9,4,8,'2025-06-02 18:58:42','2025-06-02 18:58:42','g'),(38,21,36,400,NULL,NULL,'gr'),(39,21,5,1,NULL,NULL,'unidad'),(40,21,6,3,NULL,NULL,'dientes'),(41,21,41,1,NULL,NULL,'unidad'),(42,21,79,30,NULL,NULL,'ml'),(43,21,74,1,NULL,NULL,'cdta'),(44,21,75,0.5,NULL,NULL,'cdta'),(45,21,77,0.5,NULL,NULL,'cdta'),(46,21,87,200,NULL,NULL,'gr'),(47,21,107,300,NULL,NULL,'ml'),(48,21,81,1,NULL,NULL,'cdta'),(49,21,82,0.5,NULL,NULL,'cdta'),(50,22,54,200,NULL,NULL,'gr'),(51,22,61,1,NULL,NULL,'unidad'),(52,22,65,2,NULL,NULL,'unidad'),(53,22,63,0.5,NULL,NULL,'unidad'),(54,22,57,50,NULL,NULL,'gr'),(55,22,79,40,NULL,NULL,'ml'),(56,22,80,20,NULL,NULL,'ml'),(57,22,81,1,NULL,NULL,'cdta'),(58,22,82,0.5,NULL,NULL,'cdta'),(59,23,59,2,NULL,NULL,'unidad'),(60,23,60,1,NULL,NULL,'unidad'),(61,23,61,1,NULL,NULL,'unidad'),(62,23,63,1,NULL,NULL,'unidad'),(63,23,64,3,NULL,NULL,'dientes'),(64,23,65,2,NULL,NULL,'unidad'),(65,23,79,50,NULL,NULL,'ml'),(66,23,81,1,NULL,NULL,'cdta'),(67,23,82,0.5,NULL,NULL,'cdta'),(68,23,18,1,NULL,NULL,'pizca'),(69,24,52,400,NULL,NULL,'gr'),(70,24,63,1,NULL,NULL,'unidad'),(71,24,64,2,NULL,NULL,'dientes'),(72,24,66,1,NULL,NULL,'unidad'),(73,24,104,50,NULL,NULL,'gr'),(74,24,79,30,NULL,NULL,'ml'),(75,24,75,0.5,NULL,NULL,'cdta'),(76,24,81,1,NULL,NULL,'cdta'),(77,24,82,0.5,NULL,NULL,'cdta'),(78,25,60,2,NULL,NULL,'unidad'),(79,25,79,20,NULL,NULL,'ml'),(80,25,81,0.5,NULL,NULL,'cdta'),(81,25,64,1,NULL,NULL,'diente'),(82,26,93,4,NULL,NULL,'unidad'),(83,26,70,200,NULL,NULL,'gr'),(84,26,71,50,NULL,NULL,'gr'),(85,26,85,200,NULL,NULL,'ml'),(86,26,108,3,NULL,NULL,'unidad'),(87,26,102,100,NULL,NULL,'gr'),(88,26,79,80,NULL,NULL,'ml'),(89,26,109,1,NULL,NULL,'cdta'),(90,26,49,1,NULL,NULL,'gr'),(91,27,70,200,NULL,NULL,'gr'),(92,27,71,50,NULL,NULL,'gr'),(93,27,102,150,NULL,NULL,'gr'),(94,27,108,3,NULL,NULL,'unidad'),(95,27,84,200,NULL,NULL,'ml'),(96,27,79,100,NULL,NULL,'ml'),(97,27,109,1,NULL,NULL,'cdta'),(98,28,70,150,NULL,NULL,'gr'),(99,28,71,100,NULL,NULL,'gr'),(100,28,102,80,NULL,NULL,'gr'),(101,28,79,60,NULL,NULL,'ml'),(102,28,84,50,NULL,NULL,'ml'),(103,28,109,0.5,NULL,NULL,'cdta'),(104,29,72,100,NULL,NULL,'gr'),(105,29,70,50,NULL,NULL,'gr'),(106,29,84,300,NULL,NULL,'ml'),(107,29,108,2,NULL,NULL,'unidad'),(108,29,79,20,NULL,NULL,'ml'),(109,29,81,0.5,NULL,NULL,'cdta'),(110,30,70,200,NULL,NULL,'gr'),(111,30,71,50,NULL,NULL,'gr'),(112,30,102,100,NULL,NULL,'gr'),(113,30,79,80,NULL,NULL,'ml'),(114,30,84,80,NULL,NULL,'ml'),(115,30,109,1,NULL,NULL,'cdta'),(116,30,101,3,NULL,NULL,'unidad'),(117,31,96,300,NULL,NULL,'gr'),(118,31,83,250,NULL,NULL,'ml'),(119,31,109,0.5,NULL,NULL,'cdta'),(120,31,100,10,NULL,NULL,'ml'),(121,32,69,100,NULL,NULL,'gr'),(122,32,93,1,NULL,NULL,'unidad'),(123,32,78,10,NULL,NULL,'gr'),(124,32,92,1,NULL,NULL,'unidad'),(125,32,106,200,NULL,NULL,'ml'),(126,32,94,0.5,NULL,NULL,'unidad'),(127,33,98,150,NULL,NULL,'gr'),(128,33,99,100,NULL,NULL,'gr'),(129,33,92,1,NULL,NULL,'unidad'),(130,33,84,200,NULL,NULL,'ml'),(131,33,100,10,NULL,NULL,'ml'),(132,34,89,20,NULL,NULL,'gr'),(133,34,94,1,NULL,NULL,'unidad'),(134,34,106,500,NULL,NULL,'ml'),(135,34,100,10,NULL,NULL,'ml'),(136,35,57,200,NULL,NULL,'gr'),(137,35,55,300,NULL,NULL,'gr'),(138,35,83,150,NULL,NULL,'ml'),(139,35,102,80,NULL,NULL,'gr'),(140,35,94,1,NULL,NULL,'unidad'),(141,35,109,1,NULL,NULL,'cdta'),(142,35,104,100,NULL,NULL,'gr'),(143,36,86,400,NULL,NULL,'ml'),(144,36,102,20,NULL,NULL,'gr'),(145,36,109,0.5,NULL,NULL,'cdta'),(146,37,34,200,NULL,NULL,'gr'),(147,37,92,2,NULL,NULL,'unidad'),(148,37,83,100,NULL,NULL,'ml'),(149,37,100,20,NULL,NULL,'ml'),(150,37,109,1,NULL,NULL,'cdta'),(151,4,59,1,NULL,NULL,'unidad'),(152,4,60,1,NULL,NULL,'unidad'),(153,4,8,1,NULL,NULL,'unidades'),(154,4,9,1,NULL,NULL,'unidades'),(155,4,5,1,NULL,NULL,'unidades'),(156,4,7,3,NULL,NULL,'unidades'),(157,4,6,2,NULL,NULL,'dientes'),(158,4,3,60,NULL,NULL,'ml'),(159,4,4,1,NULL,NULL,'g'),(160,6,1,800,NULL,NULL,'kg'),(161,6,5,1,NULL,NULL,'unidades'),(162,6,44,2,NULL,NULL,'hojas'),(163,6,3,80,NULL,NULL,'ml'),(164,6,17,1,NULL,NULL,'g'),(165,6,4,2,NULL,NULL,'g'),(166,7,31,80,NULL,NULL,'g'),(167,7,29,80,NULL,NULL,'g'),(168,7,32,500,NULL,NULL,'ml'),(169,7,21,150,NULL,NULL,'lonchas'),(170,7,2,2,NULL,NULL,'unidades'),(171,7,20,100,NULL,NULL,'rebanadas'),(172,7,3,200,NULL,NULL,'ml'),(173,7,4,1,NULL,NULL,'g'),(174,8,1,1,NULL,NULL,'kg'),(175,8,6,6,NULL,NULL,'dientes'),(176,8,3,60,NULL,NULL,'ml'),(177,8,45,100,NULL,NULL,'ml'),(178,8,4,2,NULL,NULL,'g'),(179,10,46,800,NULL,NULL,'g'),(180,10,6,6,NULL,NULL,'dientes'),(181,10,3,200,NULL,NULL,'ml'),(182,10,4,1,NULL,NULL,'g'),(183,11,20,8,NULL,NULL,'rebanadas'),(184,11,32,500,NULL,NULL,'ml'),(185,11,2,2,NULL,NULL,'unidades'),(186,11,30,100,NULL,NULL,'g'),(187,11,49,1,NULL,NULL,'g'),(188,11,19,1,NULL,NULL,'unidades'),(189,11,3,100,NULL,NULL,'ml'),(190,12,59,2,NULL,NULL,'unidad'),(191,12,8,2,NULL,NULL,'unidades'),(192,12,5,1,NULL,NULL,'unidades'),(193,12,3,60,NULL,NULL,'ml'),(194,12,28,20,NULL,NULL,'ml'),(195,12,4,1,NULL,NULL,'g'),(196,13,7,1,NULL,NULL,'unidades'),(197,13,20,100,NULL,NULL,'rebanadas'),(198,13,6,1,NULL,NULL,'dientes'),(199,13,3,100,NULL,NULL,'ml'),(200,13,28,20,NULL,NULL,'ml'),(201,13,2,2,NULL,NULL,'unidades'),(202,13,21,50,NULL,NULL,'lonchas'),(203,13,4,1,NULL,NULL,'g'),(204,14,24,2,NULL,NULL,'latas'),(205,14,1,600,NULL,NULL,'kg'),(206,14,8,1,NULL,NULL,'unidades'),(207,14,5,1,NULL,NULL,'unidades'),(208,14,7,2,NULL,NULL,'unidades'),(209,14,3,60,NULL,NULL,'ml'),(210,14,4,1,NULL,NULL,'g'),(211,15,10,320,NULL,NULL,'g'),(212,15,5,1,NULL,NULL,'unidades'),(213,15,45,100,NULL,NULL,'ml'),(214,15,11,1000,NULL,NULL,'ml'),(215,15,22,50,NULL,NULL,'g'),(216,15,31,50,NULL,NULL,'g'),(217,15,3,40,NULL,NULL,'ml'),(218,15,4,1,NULL,NULL,'g'),(219,16,1,1,NULL,NULL,'kg'),(220,16,6,4,NULL,NULL,'dientes'),(221,16,3,60,NULL,NULL,'ml'),(222,16,4,2,NULL,NULL,'g'),(223,17,32,500,NULL,NULL,'ml'),(224,17,2,6,NULL,NULL,'unidades'),(225,17,30,100,NULL,NULL,'g'),(226,17,49,1,NULL,NULL,'g'),(227,17,19,1,NULL,NULL,'unidades'),(228,17,72,20,NULL,NULL,'g'),(229,18,52,500,NULL,NULL,'gr'),(230,18,37,200,NULL,NULL,'g'),(231,18,38,200,NULL,NULL,'g'),(232,18,39,200,NULL,NULL,'g'),(233,18,16,1,NULL,NULL,'g'),(234,18,17,1,NULL,NULL,'g'),(235,18,4,2,NULL,NULL,'g'),(236,19,1,800,NULL,NULL,'kg'),(237,19,6,3,NULL,NULL,'dientes'),(238,19,7,2,NULL,NULL,'unidades'),(239,19,17,1,NULL,NULL,'g'),(240,19,25,3,NULL,NULL,'cucharadas'),(241,19,3,100,NULL,NULL,'ml'),(242,19,11,200,NULL,NULL,'ml'),(243,19,4,1,NULL,NULL,'g'),(244,20,20,4,NULL,NULL,'rebanadas'),(245,20,6,6,NULL,NULL,'dientes'),(246,20,2,4,NULL,NULL,'unidades'),(247,20,17,1,NULL,NULL,'g'),(248,20,3,60,NULL,NULL,'ml'),(249,20,11,800,NULL,NULL,'ml'),(250,20,4,1,NULL,NULL,'g'),(251,1,1,0.8,'2025-06-02 19:18:13','2025-06-02 19:18:13','kg'),(252,1,2,6,'2025-06-02 19:18:13','2025-06-02 19:18:13','unidades'),(253,1,3,200,'2025-06-02 19:18:13','2025-06-02 19:18:13','ml'),(254,1,4,5,'2025-06-02 19:18:13','2025-06-02 19:18:13','g');
/*!40000 ALTER TABLE `receta_ingrediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recetas`
--

DROP TABLE IF EXISTS `recetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recetas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `categoria_id` bigint(20) unsigned NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `preparacion` text NOT NULL,
  `dificultad` varchar(255) NOT NULL,
  `coccion` int(11) NOT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `porciones` int(11) NOT NULL,
  `publica` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recetas_user_id_foreign` (`user_id`),
  KEY `recetas_categoria_id_foreign` (`categoria_id`),
  CONSTRAINT `recetas_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  CONSTRAINT `recetas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recetas`
--

LOCK TABLES `recetas` WRITE;
/*!40000 ALTER TABLE `recetas` DISABLE KEYS */;
INSERT INTO `recetas` VALUES (1,1,1,'Tortilla Española Clásica','La auténtica tortilla de patatas española, jugosa por dentro y dorada por fuera. Un clásico que nunca falla.','Pela y corta las patatas en láminas finas. Fríe en aceite abundante a fuego medio hasta que estén tiernas. Bate los huevos con sal y mezcla con las patatas escurridas. Cuaja en una sartén antiadherente dándole la vuelta con ayuda de un plato.','Fácil',25,'2025-06-01',4,1,'recetas/tortilla_espanola.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(2,2,5,'Paella Valenciana Tradicional','La auténtica paella valenciana con pollo, conejo, judías verdes y garrofón. Receta tradicional de Valencia.','Sofríe el pollo y conejo troceados. Añade las verduras, el tomate rallado y el pimentón. Incorpora el arroz y el caldo caliente con azafrán. Cuece a fuego fuerte 10 min y después a fuego lento 10 min más. Deja reposar 5 minutos.','Media',40,'2025-06-01',6,1,'recetas/paella_valenciana.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(3,3,3,'Flan de Huevo Casero','Flan de huevo tradicional con caramelo líquido, cremoso y con el sabor de siempre.','Prepara el caramelo fundiendo azúcar hasta que esté dorado. Bate huevos con leche, azúcar y vainilla. Cuela la mezcla y vierte sobre el caramelo. Cuece al baño maría en el horno 50 minutos a 160°C. Deja enfriar antes de desmoldar.','Fácil',60,'2025-06-01',6,1,'recetas/flan_huevo.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(4,4,7,'Pisto Manchego','Pisto de verduras tradicional de Castilla-La Mancha, perfecto como plato principal o acompañamiento.','Corta todas las verduras en dados pequeños. Sofríe primero la cebolla, luego el pimiento, después la berenjena y por último el calabacín y el tomate. Condimenta con sal, pimienta y hierbas aromáticas. Cuece a fuego lento 20 minutos.','Fácil',35,'2025-06-01',4,1,'recetas/pisto_manchego.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(5,5,4,'Gazpacho Andaluz','El gazpacho más refrescante y tradicional de Andalucía, perfecto para los días de calor.','Remoja el pan en agua. Tritura todos los ingredientes: tomates, pepino, pimiento, cebolla, ajo, pan, aceite, vinagre y sal. Pasa por un colador fino. Ajusta de sal y vinagre. Sirve bien frío con daditos de pepino, tomate y pan tostado.','Fácil',15,'2025-06-02',4,1,'recetas/gazpacho_andaluz.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(6,6,1,'Pulpo a la Gallega','Pulpo tierno cocido con patatas, aceite de oliva, pimentón y sal gorda. Especialidad gallega.','Cuece el pulpo en agua hirviendo con cebolla y laurel durante 45-60 minutos. Cuece las patatas por separado. Corta el pulpo en rodajas y las patatas en láminas. Sirve en plato de madera con aceite, pimentón dulce y sal gorda.','Media',75,'2025-06-02',4,1,'recetas/pulpo_gallega.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(7,7,2,'Croquetas de Jamón','Croquetas cremosas de jamón serrano, perfectas como aperitivo o tapa.','Prepara una bechamel espesa con mantequilla, harina y leche. Añade jamón picado muy fino. Deja enfriar en nevera 4 horas. Forma las croquetas, pasa por harina, huevo y pan rallado. Fríe en aceite caliente hasta dorar.','Media',30,'2025-06-02',20,1,'recetas/croquetas_jamon.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(8,8,1,'Cordero Asado','Cordero asado al horno con patatas, ajo y romero. Plato dominical por excelencia.','Sazona el cordero con sal, pimienta, ajo y romero. Coloca en bandeja de horno con patatas cortadas. Riega con aceite y vino blanco. Asa a 180°C dándole la vuelta a media cocción. Tiempo total aproximado 90 minutos según el peso.','Media',90,'2025-06-02',6,1,'recetas/cordero_asado.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(9,1,6,'Lentejas con Chorizo','Lentejas estofadas con chorizo y verduras, plato de cuchara tradicional español.','Pon las lentejas en remojo la noche anterior. Sofríe cebolla, ajo, zanahoria y chorizo. Añade las lentejas, cubre con caldo y cuece 30 minutos. Incorpora pimentón, laurel y sal. Sirve caliente con un chorrito de aceite crudo.','Fácil',45,'2025-06-02',4,1,'recetas/lentejas_chorizo.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(10,2,1,'Bacalao al Pil Pil','Bacalao confitado en aceite de oliva con ajo, especialidad vasca tradicional.','Desala el bacalao y sécalo bien. Confita los ajos laminados en aceite suave. Retira los ajos y confita el bacalao en el mismo aceite. En una cazuela de barro, emulsiona el aceite moviendo la cazuela para crear el pil pil. Sirve inmediatamente.','Difícil',35,'2025-06-02',4,1,'recetas/bacalao_pilpil.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(11,3,3,'Torrijas','Torrijas tradicionales de Semana Santa, empapadas en leche con canela y fritas.','Hierve la leche con canela y cáscara de limón. Deja enfriar. Empapa las rebanadas de pan en la leche, después en huevo batido. Fríe hasta dorar. Reboza en azúcar con canela mientras están calientes.','Fácil',20,'2025-06-02',8,1,'recetas/torrijas.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(12,4,7,'Escalivada','Verduras asadas catalanas: berenjena, pimiento rojo y cebolla, aliñadas con aceite de oliva.','Asa las verduras enteras en el horno a 200°C hasta que estén tiernas y la piel se desprenda fácilmente. Pela y corta en tiras. Aliña con aceite de oliva, sal y vinagre. Deja macerar antes de servir.','Fácil',45,'2025-06-02',4,1,'recetas/escalivada.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(13,5,2,'Salmorejo Cordobés','Crema fría de tomate espesa, típica de Córdoba, servida con huevo duro y jamón.','Remoja el pan en agua. Tritura tomates muy maduros con pan, ajo, aceite y sal hasta obtener una crema espesa. Pasa por colador. Sirve frío decorado con huevo duro picado y jamón serrano en daditos.','Fácil',15,'2025-06-02',4,1,'recetas/salmorejo_cordobes.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(14,6,1,'Marmitako','Guiso de atún con patatas, pimientos y cebolla, plato marinero vasco tradicional.','Sofríe cebolla y pimientos en aceite. Añade tomate y patatas cortadas en trozos irregulares. Cubre con caldo de pescado y cuece 15 minutos. Incorpora el atún en trozos y cuece 5 minutos más. Rectifica de sal.','Fácil',30,'2025-06-02',4,1,'recetas/marmitako.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(15,7,5,'Risotto de Setas','Risotto cremoso con setas variadas, queso parmesano y vino blanco.','Rehoga las setas laminadas y reserva. Sofríe cebolla picada, añade el arroz y tuesta 2 minutos. Añade vino blanco y después caldo caliente poco a poco removiendo constantemente. Incorpora las setas, mantequilla y queso al final.','Media',25,'2025-06-02',4,1,'recetas/risotto_setas.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(16,8,1,'Cochinillo Asado','Cochinillo asado segoviano, tierno y con la piel crujiente, tradición castellana.','Sazona el cochinillo con sal y unto. Coloca en bandeja de horno con agua en el fondo. Asa a 180°C regando frecuentemente con su jugo. Dale la vuelta a media cocción. Tiempo total 2-3 horas según tamaño.','Difícil',180,'2025-06-02',8,1,'recetas/cochinillo_asado.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(17,1,3,'Crema Catalana','Postre tradicional catalán similar al flan pero más cremoso, con azúcar quemado por encima.','Hierve leche con cáscara de limón y canela. Bate yemas con azúcar y maicena. Incorpora la leche caliente poco a poco. Cuece removiendo hasta espesar. Sirve en cazuelitas, espolvorea azúcar y quema con soplete.','Media',20,'2025-06-02',6,1,'recetas/crema_catalana.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(18,2,6,'Fabada Asturiana','Fabada con fabes, chorizo, morcilla y lacón, plato tradicional asturiano.','Pon las fabes en remojo 24 horas. Cuece con los compangos (chorizo, morcilla, lacón) a fuego lento durante 2 horas. Añade azafrán y pimentón. Debe quedar caldosa pero no aguada. Sirve muy caliente.','Media',120,'2025-06-02',6,1,'recetas/fabada_asturiana.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(19,3,2,'Patatas Bravas','Patatas fritas con salsa brava picante, tapa madrileña clásica.','Corta las patatas en dados y fríe hasta dorar. Para la salsa: sofríe ajo, añade tomate frito, pimentón, cayena y caldo. Cuece 10 minutos. Sirve las patatas calientes cubiertas con la salsa y mayonesa.','Fácil',25,'2025-06-02',4,1,'recetas/patatas_bravas.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(20,4,4,'Sopa de Ajo','Sopa castellana con ajo, pimentón, huevo y pan, reconfortante y tradicional.','Dora rebanadas de pan en aceite con ajos laminados. Añade pimentón, agua o caldo y sal. Cuece 15 minutos. Casca huevos encima y cuece hasta que cuajen. Sirve inmediatamente bien caliente.','Fácil',20,'2025-06-02',4,1,'recetas/sopa_ajo.jpg','2025-06-02 18:12:49','2025-06-02 18:12:49'),(21,9,9,'Curry de Garbanzos con Arroz','Una forma diferente de disfrutar de un plato de legumbres. Combina las propiedades y beneficios de los garbanzos con un delicioso curry y arroz.','Un plato 100% vegetal apto para veganos y vegetarianos, además de muy rápido de hacer si utilizas garbanzos de bote.','Fácil',25,'2024-11-15',4,1,'curry_garbanzos.jpg',NULL,NULL),(22,10,14,'Ensalada de Quinoa Vegana','La quinoa es un pseudocereal rico en proteínas perfecto para preparar una deliciosa ensalada con ingredientes de origen vegetal.','Una combinación refrescante y deliciosa además de fácil, rápida y saludable para incluirla en tu menú diario.','Fácil',15,'2024-11-20',2,1,'ensalada_quinoa.jpg',NULL,NULL),(23,9,10,'Berenjenas Rellenas Vegetarianas','Deliciosas berenjenas rellenas con una variedad de verduras y hortalizas mezcladas con la pulpa horneada.','Receta vegana que utiliza únicamente ingredientes vegetales para crear un relleno muy sabroso.','Medio',45,'2024-11-10',4,1,'berenjenas_rellenas.jpg',NULL,NULL),(24,10,15,'Hamburguesa de Alubias Blancas','Hamburguesa vegana muy fácil de preparar y sana, elaborada con alubias blancas y verduras.','Una alternativa saludable y deliciosa a las hamburguesas tradicionales, perfecta para veganos.','Fácil',20,'2024-11-25',4,1,'hamburguesa_alubias.jpg',NULL,NULL),(25,9,2,'Calabacín a la Plancha','Uno de los mejores recursos cuando buscamos una receta de guarnición fácil, rápida y con pocos ingredientes.','Preparación sencilla que resalta el sabor natural del calabacín con un toque de aceite de oliva.','Fácil',10,'2024-12-01',2,1,'calabacin_plancha.jpg',NULL,NULL),(26,10,11,'Tarta de Manzana Sin Gluten y Sin Lactosa','Deliciosa tarta de manzana apta para celíacos e intolerantes a la lactosa, igualmente deliciosa que la versión tradicional.','Preparada con harina sin gluten y bebida vegetal, manteniendo todo el sabor de la tarta clásica.','Medio',50,'2024-11-18',8,1,'tarta_manzana_sg.jpg',NULL,NULL),(27,10,11,'Bizcocho Sin Gluten y Sin Lactosa','Bizcocho esponjoso y delicioso apto para celíacos e intolerantes a la lactosa.','Receta fácil que utiliza harinas alternativas para conseguir la textura perfecta.','Fácil',40,'2024-11-22',6,1,'bizcocho_sg.jpg',NULL,NULL),(28,10,11,'Galletas Sin Gluten para Celíacos','Galletas súper fáciles y deliciosas elaboradas con harina de arroz y almendra.','Perfectas para acompañar el té o café, crujientes y sabrosas.','Fácil',15,'2024-12-03',20,1,'galletas_sg.jpg',NULL,NULL),(29,10,11,'Crepes Sin Gluten y Sin Lactosa','Crepes perfectos para celíacos e intolerantes a la lactosa, versátiles para dulce o salado.','Masa suave y flexible elaborada con maicena y leche vegetal.','Fácil',20,'2024-11-28',8,1,'crepes_sg.jpg',NULL,NULL),(30,10,11,'Pepas Sin Gluten (Sin TACC)','Galletitas tradicionales adaptadas para celíacos, perfectas para la hora del té.','Elaboradas con harinas alternativas manteniendo el sabor tradicional.','Medio',25,'2024-12-05',15,1,'pepas_sg.jpg',NULL,NULL),(31,11,8,'Licuado de Papaya con Leche de Coco','La combinación ideal de frescura, suavidad y sabor tropical. Bebida increíblemente fácil de preparar.','Clásico en países donde las frutas tropicales son protagonistas de la gastronomía.','Fácil',5,'2024-12-02',2,1,'licuado_papaya.jpg',NULL,NULL),(32,11,8,'Batido Verde Detox','Batido nutritivo con espinacas, manzana y jengibre para depurar el organismo.','Combinación perfecta de verduras y frutas para un aporte vitamínico completo.','Fácil',5,'2024-11-30',1,1,'batido_verde.jpg',NULL,NULL),(33,11,8,'Smoothie de Frutos Rojos','Batido antioxidante con fresas, arándanos y plátano.','Bebida energética perfecta para el desayuno o merienda.','Fácil',5,'2024-12-01',2,1,'smoothie_frutos_rojos.jpg',NULL,NULL),(34,11,8,'Agua de Chía con Limón','Bebida hidratante y nutritiva con semillas de chía y zumo de limón.','Perfecta para hidratarse mientras se obtienen omega-3 y fibra.','Fácil',10,'2024-11-29',1,1,'agua_chia.jpg',NULL,NULL),(35,12,13,'Tarta de Queso Vegana','Versión vegana de la tarta de queso tradicional, cremosa y deliciosa sin ingredientes de origen animal.','Elaborada con cashews y tofu sedoso para conseguir la textura cremosa característica.','Medio',30,'2024-11-16',8,1,'tarta_queso_vegana.jpg',NULL,NULL),(36,12,13,'Nata Vegana de Coco','Alternativa perfecta a la nata montada tradicional, ideal para veganos e intolerantes a la lactosa.','Elaborada únicamente con leche de coco, consiguiendo el mismo resultado que la nata tradicional.','Fácil',5,'2024-12-04',4,1,'nata_coco.jpg',NULL,NULL),(37,12,13,'Mousse de Chocolate Vegano','Mousse cremoso y intenso elaborado con chocolate negro y aguacate.','Postre saludable que sorprende por su textura sedosa sin usar huevos ni lácteos.','Medio',15,'2024-11-21',4,1,'mousse_chocolate_vegano.jpg',NULL,NULL);
/*!40000 ALTER TABLE `recetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguidores`
--

DROP TABLE IF EXISTS `seguidores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguidores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `seguidor_id` bigint(20) unsigned NOT NULL,
  `seguido_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seguidores_seguidor_id_seguido_id_unique` (`seguidor_id`,`seguido_id`),
  KEY `seguidores_seguido_id_foreign` (`seguido_id`),
  CONSTRAINT `seguidores_seguido_id_foreign` FOREIGN KEY (`seguido_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seguidores_seguidor_id_foreign` FOREIGN KEY (`seguidor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguidores`
--

LOCK TABLES `seguidores` WRITE;
/*!40000 ALTER TABLE `seguidores` DISABLE KEYS */;
INSERT INTO `seguidores` VALUES (1,1,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(2,1,3,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(3,2,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(4,2,6,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(5,3,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(6,3,4,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(7,4,3,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(8,4,7,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(9,5,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(10,5,6,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(11,6,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(12,6,5,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(13,7,1,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(14,7,4,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(15,8,2,'2025-06-02 19:23:45','2025-06-02 19:23:45'),(16,8,6,'2025-06-02 19:23:45','2025-06-02 19:23:45');
/*!40000 ALTER TABLE `seguidores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'María González','maria.gonzalez@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/maria.jpg','Chef especializada en cocina mediterránea y recetas familiares tradicionales','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(2,'Carlos Ruiz','carlos.ruiz@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/carlos.jpg','Cocinero profesional con 15 años de experiencia en alta cocina','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(3,'Ana Martín','ana.martin@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/ana.jpg','Amante de la repostería y los postres caseros. Recetas de la abuela','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(4,'Javier López','javier.lopez@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/javier.jpg','Especialista en cocina vegetariana y vegana. Vida saludable','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(5,'Carmen Sánchez','carmen.sanchez@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/carmen.jpg','Cocina andaluza tradicional. Transmitiendo sabores de generación en generación','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(6,'Diego Fernández','diego.fernandez@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/diego.jpg','Chef especializado en mariscos y pescados. Cocina gallega auténtica','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(7,'Isabel Torres','isabel.torres@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/isabel.jpg','Recetas rápidas para familias ocupadas. Mamá de 3 niños','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(8,'Antonio Jiménez','antonio.jimenez@email.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','perfiles/antonio.jpg','Asador profesional. Especialista en carnes a la parrilla y cocina al aire libre','2025-06-02 17:50:14',NULL,'2025-06-02 17:50:14','2025-06-02 17:50:14'),(9,'Chef Verde','chefverde@realfoodie.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','chef_verde.jpg','Especialista en cocina vegana y vegetariana',NULL,NULL,NULL,NULL),(10,'Cocina Saludable','saludable@realfoodie.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','cocina_saludable.jpg','Experta en recetas sin gluten y para celíacos',NULL,NULL,NULL,NULL),(11,'Bebidas Naturales','bebidas@realfoodie.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bebidas_naturales.jpg','Creadora de batidos y bebidas saludables',NULL,NULL,NULL,NULL),(12,'Postres Veganos','postres@realfoodie.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','postres_veganos.jpg','Repostera especializada en dulces veganos',NULL,NULL,NULL,NULL),(13,'Paula','paula@gmail.com','$2y$12$CPEAQuMsUHx8s/EnY0cBaerCvR/f3vJOutNBipyp3thbvdeEZ0qm2',NULL,NULL,NULL,NULL,'2025-06-02 17:32:45','2025-06-02 17:32:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valoraciones`
--

DROP TABLE IF EXISTS `valoraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `valoraciones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `receta_id` bigint(20) unsigned NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `valoraciones_user_id_receta_id_unique` (`user_id`,`receta_id`),
  KEY `valoraciones_receta_id_foreign` (`receta_id`),
  CONSTRAINT `valoraciones_receta_id_foreign` FOREIGN KEY (`receta_id`) REFERENCES `recetas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `valoraciones_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valoraciones`
--

LOCK TABLES `valoraciones` WRITE;
/*!40000 ALTER TABLE `valoraciones` DISABLE KEYS */;
INSERT INTO `valoraciones` VALUES (1,1,2,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(2,1,6,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(3,1,10,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(4,2,1,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(5,2,5,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(6,2,18,3,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(7,3,1,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(8,3,2,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(9,3,19,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(10,4,12,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(11,4,15,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(12,4,4,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(13,5,1,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(14,5,7,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(15,5,13,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(16,6,2,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(17,6,10,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(18,6,14,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(19,7,1,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(20,7,9,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(21,7,20,3,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(22,8,2,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(23,8,8,5,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(24,8,16,4,'2025-06-02 19:24:02','2025-06-02 19:24:02'),(72,3,8,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(73,4,10,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(74,5,16,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(75,7,18,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(76,8,17,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(77,1,15,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(78,2,14,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(79,6,4,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(80,1,11,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(81,3,12,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(82,5,20,3,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(83,7,3,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(84,8,5,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(85,2,7,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(86,4,9,4,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(87,6,13,5,'2025-06-02 19:26:01','2025-06-02 19:26:01'),(88,10,21,5,NULL,NULL),(89,11,21,5,NULL,NULL),(90,12,21,4,NULL,NULL),(91,9,22,5,NULL,NULL),(92,11,22,4,NULL,NULL),(93,10,26,5,NULL,NULL),(94,12,26,4,NULL,NULL),(95,9,31,5,NULL,NULL),(96,10,35,5,NULL,NULL);
/*!40000 ALTER TABLE `valoraciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-02 21:42:20
