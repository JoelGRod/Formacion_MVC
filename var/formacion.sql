-- MySQL dump 10.13  Distrib 8.0.21, for Linux (x86_64)
--
-- Host: localhost    Database: formacion
-- ------------------------------------------------------
-- Server version	8.0.21-0ubuntu0.20.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `becario`
--

DROP TABLE IF EXISTS `becario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `becario` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `nacionalidad_id` int unsigned NOT NULL,
  `formacion_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_becario_nacionalidad_idx` (`nacionalidad_id`),
  KEY `fk_becario_formacion1_idx` (`formacion_id`),
  CONSTRAINT `fk_becario_formacion1` FOREIGN KEY (`formacion_id`) REFERENCES `formacion` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_becario_nacionalidad` FOREIGN KEY (`nacionalidad_id`) REFERENCES `nacionalidad` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `becario`
--

LOCK TABLES `becario` WRITE;
/*!40000 ALTER TABLE `becario` DISABLE KEYS */;
/*!40000 ALTER TABLE `becario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formacion`
--

DROP TABLE IF EXISTS `formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formacion` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formacion`
--

LOCK TABLES `formacion` WRITE;
/*!40000 ALTER TABLE `formacion` DISABLE KEYS */;
INSERT INTO `formacion` VALUES (1,'Desarrollador'),(2,'Web Designer'),(3,'Autocad'),(4,'Administracion');
/*!40000 ALTER TABLE `formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formador`
--

DROP TABLE IF EXISTS `formador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formador` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `sala_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_formador_sala1_idx` (`sala_id`),
  CONSTRAINT `fk_formador_sala1` FOREIGN KEY (`sala_id`) REFERENCES `sala` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formador`
--

LOCK TABLES `formador` WRITE;
/*!40000 ALTER TABLE `formador` DISABLE KEYS */;
INSERT INTO `formador` VALUES (2,'Estefanía','Morales HonHon',1),(3,'Pablo','García Arripe',2),(4,'Emilio','Martín Cruz',3),(5,'María','González Sánchez',4);
/*!40000 ALTER TABLE `formador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formador_has_becario`
--

DROP TABLE IF EXISTS `formador_has_becario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formador_has_becario` (
  `formador_id` int unsigned NOT NULL,
  `becario_id` int unsigned NOT NULL,
  PRIMARY KEY (`formador_id`,`becario_id`),
  KEY `fk_formador_has_becario_becario1_idx` (`becario_id`),
  KEY `fk_formador_has_becario_formador1_idx` (`formador_id`),
  CONSTRAINT `fk_formador_has_becario_becario1` FOREIGN KEY (`becario_id`) REFERENCES `becario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_formador_has_becario_formador1` FOREIGN KEY (`formador_id`) REFERENCES `formador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formador_has_becario`
--

LOCK TABLES `formador_has_becario` WRITE;
/*!40000 ALTER TABLE `formador_has_becario` DISABLE KEYS */;
/*!40000 ALTER TABLE `formador_has_becario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `formador_has_formacion`
--

DROP TABLE IF EXISTS `formador_has_formacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `formador_has_formacion` (
  `formador_id` int unsigned NOT NULL,
  `formacion_id` int unsigned NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`formador_id`,`formacion_id`),
  KEY `fk_formador_has_formacion_formacion1_idx` (`formacion_id`),
  KEY `fk_formador_has_formacion_formador1_idx` (`formador_id`),
  CONSTRAINT `fk_formador_has_formacion_formacion1` FOREIGN KEY (`formacion_id`) REFERENCES `formacion` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_formador_has_formacion_formador1` FOREIGN KEY (`formador_id`) REFERENCES `formador` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `formador_has_formacion`
--

LOCK TABLES `formador_has_formacion` WRITE;
/*!40000 ALTER TABLE `formador_has_formacion` DISABLE KEYS */;
INSERT INTO `formador_has_formacion` VALUES (2,1,'2020-02-01','2021-02-02'),(2,2,'2020-07-29','2021-04-14'),(2,3,'2020-05-01','2021-05-02'),(2,4,'2020-03-01','2021-04-02'),(3,1,'2020-02-01','2021-02-02'),(3,2,'2020-07-29','2021-04-14'),(3,3,'2020-05-01','2021-05-02'),(3,4,'2020-03-01','2021-04-02'),(4,1,'2020-02-01','2021-02-02'),(4,2,'2020-07-29','2021-04-14'),(4,3,'2020-05-01','2021-05-02'),(4,4,'2020-03-01','2021-04-02'),(5,1,'2020-02-01','2021-02-02'),(5,2,'2020-07-29','2021-04-14'),(5,3,'2020-05-01','2021-05-02'),(5,4,'2020-03-01','2021-04-02');
/*!40000 ALTER TABLE `formador_has_formacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nacionalidad`
--

DROP TABLE IF EXISTS `nacionalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nacionalidad` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nacionalidad`
--

LOCK TABLES `nacionalidad` WRITE;
/*!40000 ALTER TABLE `nacionalidad` DISABLE KEYS */;
INSERT INTO `nacionalidad` VALUES (1,'España'),(2,'Alemania'),(3,'Francia'),(4,'Rusia'),(5,'Italia'),(6,'Japon');
/*!40000 ALTER TABLE `nacionalidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sala`
--

DROP TABLE IF EXISTS `sala`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sala` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `etiqueta` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala`
--

LOCK TABLES `sala` WRITE;
/*!40000 ALTER TABLE `sala` DISABLE KEYS */;
INSERT INTO `sala` VALUES (1,'101'),(2,'102'),(3,'201'),(4,'202');
/*!40000 ALTER TABLE `sala` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-10-07 11:51:51
