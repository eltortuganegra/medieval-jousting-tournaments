CREATE DATABASE  IF NOT EXISTS `caballeros` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `caballeros`;
-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: caballeros
-- ------------------------------------------------------
-- Server version	5.5.43-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `achievements` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT 'Los logros tienen un nombre, descripción, una fecha de alta, de baja, un status. Los status serán disponible y desactivado o lo que se me vaya ocurriendo por el camino.',
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL COMMENT 'El tipo de logro puede ser referente a experiencia, dinero, etc.',
  PRIMARY KEY (`id`),
  KEY `fk_achievements_constants1` (`status`),
  KEY `fk_achievements_constants2` (`type`),
  CONSTRAINT `fk_achievements_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_achievements_constants2` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_rules_level`
--

DROP TABLE IF EXISTS `app_rules_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_rules_level` (
  `level` int(11) NOT NULL,
  `attribute_cost` int(11) DEFAULT NULL,
  `skill_cost` int(11) DEFAULT NULL,
  `wins_combats_next_level` int(11) DEFAULT NULL,
  `cache` int(11) DEFAULT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_rules_level`
--

LOCK TABLES `app_rules_level` WRITE;
/*!40000 ALTER TABLE `app_rules_level` DISABLE KEYS */;
INSERT INTO `app_rules_level` VALUES (1,100,10,50,3),(2,200,20,100,8),(3,400,40,200,19),(4,800,80,400,38),(5,1600,160,800,80),(6,3200,320,1600,160),(7,6400,640,3200,320),(8,12800,1280,6400,640),(9,25600,2560,12800,1280),(10,51200,5120,25600,2560),(11,102400,10240,51200,5120),(12,204800,20480,102400,10240),(13,409600,40960,204800,20480),(14,819200,81920,409600,40960),(15,1638400,163840,819200,81920),(16,3276800,327680,1638400,163840),(17,6553600,655360,3276800,327680),(18,13107200,1310720,6553600,655360),(19,26214400,2621440,13107200,1310720),(20,52408800,5240880,26214400,2621440);
/*!40000 ALTER TABLE `app_rules_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_stats`
--

DROP TABLE IF EXISTS `app_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_stats` (
  `knights_suscribe` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_received` int(10) unsigned NOT NULL DEFAULT '0',
  `money_total_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `money_maximum_earned_combat` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `desqualities` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Almacena todas las estadisticas que los caballeros han hecho';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_stats`
--

LOCK TABLES `app_stats` WRITE;
/*!40000 ALTER TABLE `app_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_stats_by_date`
--

DROP TABLE IF EXISTS `app_stats_by_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_stats_by_date` (
  `date` date NOT NULL,
  `knights_suscribe` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_received` int(10) unsigned NOT NULL DEFAULT '0',
  `money_total_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `money_maximum_earned_combat` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `desqualities` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_stats_by_date`
--

LOCK TABLES `app_stats_by_date` WRITE;
/*!40000 ALTER TABLE `app_stats_by_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_stats_by_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `armours`
--

DROP TABLE IF EXISTS `armours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armours` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `armours_materials_id` tinyint(3) unsigned NOT NULL,
  `equipment_qualities_id` tinyint(3) unsigned NOT NULL,
  `equipment_size_id` tinyint(3) unsigned NOT NULL,
  `equipment_rarity_id` tinyint(3) unsigned NOT NULL,
  `endurance` smallint(5) unsigned NOT NULL,
  `pde` tinyint(3) unsigned NOT NULL,
  `prize` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_armours_constants1` (`type`),
  KEY `fk_armours_equipement_materials1` (`armours_materials_id`),
  KEY `fk_armours_equipment_size1` (`equipment_size_id`),
  KEY `fk_armours_equipement_qualities1` (`equipment_qualities_id`),
  KEY `fk_armours_equipment_rarity2` (`equipment_rarity_id`),
  CONSTRAINT `fk_armours_constants1` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_armours_equipement_materials1` FOREIGN KEY (`armours_materials_id`) REFERENCES `armours_materials` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_armours_equipement_qualities1` FOREIGN KEY (`equipment_qualities_id`) REFERENCES `equipment_qualities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_armours_equipment_rarity2` FOREIGN KEY (`equipment_rarity_id`) REFERENCES `equipment_rarity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_armours_equipment_size1` FOREIGN KEY (`equipment_size_id`) REFERENCES `equipment_size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='La form es sólo para escudos.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armours`
--

LOCK TABLES `armours` WRITE;
/*!40000 ALTER TABLE `armours` DISABLE KEYS */;
INSERT INTO `armours` VALUES (1,'casco de entrenamiento',47,2,1,2,1,1,200,8),(2,'Hombrera izquierda de entrenamiento',45,1,1,1,1,1,200,6),(3,'guante izquierdo de entrenamiento',43,2,1,1,1,1,200,6),(4,'guante derecho de entrenamiento',65,2,1,1,1,1,200,6),(5,'Hombrera derecha de entrenamiento',67,2,1,1,1,1,200,6),(6,'Codera izquierda de entrenamiento',44,2,1,1,1,1,200,6),(7,'Codera derecha de entrenamiento',66,2,1,1,1,1,200,6),(8,'Coraza de entrenamiento',46,2,1,4,1,1,200,25),(9,'Escudo de entrenamiento',48,2,1,1,1,1,200,6);
/*!40000 ALTER TABLE `armours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `armours_materials`
--

DROP TABLE IF EXISTS `armours_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armours_materials` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `endurance` tinyint(3) unsigned NOT NULL,
  `prize` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armours_materials`
--

LOCK TABLES `armours_materials` WRITE;
/*!40000 ALTER TABLE `armours_materials` DISABLE KEYS */;
INSERT INTO `armours_materials` VALUES (1,'ropa',0,0),(2,'Ropa pesada',1,1),(3,'cuero',2,2),(4,'cuero pesado',3,4),(5,'cuero curtido',4,8),(6,'mallas',5,16),(7,'escamas',6,32),(8,'anillas',7,64),(9,'mallas reforzadas',8,128),(10,'placas mejoradas',9,256),(11,'placas reforzadas',10,512),(12,'placas pesadas',11,1024);
/*!40000 ALTER TABLE `armours_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `armours_objects`
--

DROP TABLE IF EXISTS `armours_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `armours_objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `armours_id` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `current_pde` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_armours_objects_armours1` (`armours_id`),
  KEY `fk_armours_objects_knights1` (`knights_id`),
  CONSTRAINT `fk_armours_objects_armours1` FOREIGN KEY (`armours_id`) REFERENCES `armours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_armours_objects_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `armours_objects`
--

LOCK TABLES `armours_objects` WRITE;
/*!40000 ALTER TABLE `armours_objects` DISABLE KEYS */;
/*!40000 ALTER TABLE `armours_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avatars`
--

DROP TABLE IF EXISTS `avatars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avatars` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL COMMENT 'Todos los avatares disponibles para los jugadores',
  `achievements_id` int(10) unsigned DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `position` smallint(5) unsigned NOT NULL COMMENT 'position hace referencia a la posición que va a ocupar en el listado de logros.',
  PRIMARY KEY (`id`),
  KEY `fk_avatars_achievements1` (`achievements_id`),
  CONSTRAINT `fk_avatars_achievements1` FOREIGN KEY (`achievements_id`) REFERENCES `achievements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatars`
--

LOCK TABLES `avatars` WRITE;
/*!40000 ALTER TABLE `avatars` DISABLE KEYS */;
INSERT INTO `avatars` VALUES (1,'initial',NULL,'2012-08-13 10:00:00',NULL,1);
/*!40000 ALTER TABLE `avatars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combats`
--

DROP TABLE IF EXISTS `combats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_knight` int(10) unsigned NOT NULL,
  `to_knight` int(10) unsigned NOT NULL,
  `date` datetime DEFAULT NULL,
  `type` int(10) unsigned NOT NULL COMMENT 'amistosos, torneos, etc.',
  `status` int(10) unsigned NOT NULL COMMENT 'Si está pendiente, rechazado, en curso o finalizado.',
  `result` int(10) unsigned DEFAULT NULL COMMENT 'resultado del combate. Puede ser ganador from_knight, ganador to_knight o empate',
  `result_by` int(10) unsigned DEFAULT NULL COMMENT 'indica si el combate se ha terminado por 3 caidas, herida o lo que se ocurra en el futuro.',
  `from_knight_injury_type` int(10) unsigned DEFAULT NULL COMMENT 'El tipo de herida que ha sufrido from_knight',
  `to_knight_injury_type` int(10) unsigned DEFAULT NULL COMMENT 'tipo de herida que tiene to_knight',
  PRIMARY KEY (`id`),
  KEY `fk_combats_knights1` (`from_knight`),
  KEY `fk_combats_knights2` (`to_knight`),
  KEY `fk_combats_constants1` (`status`),
  KEY `fk_combats_constants2` (`result`),
  KEY `fk_combats_constants3` (`type`),
  KEY `fk_combats_constants4` (`from_knight_injury_type`),
  KEY `fk_combats_constants5` (`to_knight_injury_type`),
  KEY `fk_combats_constants6` (`result_by`),
  CONSTRAINT `fk_combats_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_constants2` FOREIGN KEY (`result`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_constants3` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_constants4` FOREIGN KEY (`from_knight_injury_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_constants5` FOREIGN KEY (`to_knight_injury_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_constants6` FOREIGN KEY (`result_by`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_knights1` FOREIGN KEY (`from_knight`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_knights2` FOREIGN KEY (`to_knight`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Los tipos de combate hacen referencia a si son amistosos, to';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combats`
--

LOCK TABLES `combats` WRITE;
/*!40000 ALTER TABLE `combats` DISABLE KEYS */;
/*!40000 ALTER TABLE `combats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combats_postcombat`
--

DROP TABLE IF EXISTS `combats_postcombat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combats_postcombat` (
  `combats_id` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `knight_rival_level` tinyint(3) unsigned NOT NULL,
  `experience_generate` int(10) unsigned NOT NULL COMMENT 'La experiencia generada por el adversario o la suya propia antes de aplicar modificaciones.',
  `percent_by_result` smallint(5) unsigned NOT NULL,
  `percent_by_injury` smallint(6) NOT NULL,
  `earned_experience` int(11) NOT NULL COMMENT 'La experiencia puede ser negativa.',
  `total_experience` int(10) unsigned NOT NULL,
  `total_coins` int(10) unsigned NOT NULL,
  `earned_coins` int(10) unsigned NOT NULL,
  `injury_type` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`combats_id`,`knights_id`),
  KEY `fk_combats_postcombat_knights1` (`knights_id`),
  KEY `fk_combats_postcombat_constants1` (`injury_type`),
  CONSTRAINT `fk_combats_postcombat_combats1` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_postcombat_constants1` FOREIGN KEY (`injury_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_postcombat_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combats_postcombat`
--

LOCK TABLES `combats_postcombat` WRITE;
/*!40000 ALTER TABLE `combats_postcombat` DISABLE KEYS */;
/*!40000 ALTER TABLE `combats_postcombat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combats_precombat`
--

DROP TABLE IF EXISTS `combats_precombat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combats_precombat` (
  `combats_id` int(10) unsigned NOT NULL,
  `from_knight_cache` int(10) unsigned NOT NULL,
  `from_knight_fame` tinyint(3) unsigned NOT NULL,
  `from_knight_fans_throw` tinyint(3) unsigned NOT NULL,
  `to_knight_cache` int(10) unsigned NOT NULL,
  `to_knight_fame` tinyint(3) unsigned NOT NULL,
  `to_knight_fans_throw` tinyint(3) unsigned NOT NULL,
  `from_knight_gate` int(10) unsigned NOT NULL,
  `to_knight_gate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`combats_id`),
  CONSTRAINT `fk_combats_precombat_combats1` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combats_precombat`
--

LOCK TABLES `combats_precombat` WRITE;
/*!40000 ALTER TABLE `combats_precombat` DISABLE KEYS */;
/*!40000 ALTER TABLE `combats_precombat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `combats_tricks`
--

DROP TABLE IF EXISTS `combats_tricks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `combats_tricks` (
  `combats_id` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `tricks_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`combats_id`,`knights_id`,`tricks_id`),
  KEY `fk_combats_tricks_tricks1` (`tricks_id`),
  KEY `fk_combats_tricks_knights1` (`knights_id`),
  CONSTRAINT `fk_combats_tricks_combats1` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_tricks_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_combats_tricks_tricks1` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `combats_tricks`
--

LOCK TABLES `combats_tricks` WRITE;
/*!40000 ALTER TABLE `combats_tricks` DISABLE KEYS */;
/*!40000 ALTER TABLE `combats_tricks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `constants`
--

DROP TABLE IF EXISTS `constants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `constants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `type` int(10) unsigned DEFAULT NULL COMMENT 'Esta tabla contiene todas las constantes de la aplicación. El campo type se utiliza para indicar la constante que tiene por padre. Por ejemplo, knights_status almacenaría todos los estados de un caballero y para ello, todos lo estados tendrían como type, ',
  PRIMARY KEY (`id`),
  KEY `fk_constants_constants` (`type`),
  CONSTRAINT `fk_constants_constants` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `constants`
--

LOCK TABLES `constants` WRITE;
/*!40000 ALTER TABLE `constants` DISABLE KEYS */;
INSERT INTO `constants` VALUES (1,'enabled',NULL),(2,'pending',NULL),(3,'users_status',NULL),(4,'pending_activation',3),(5,'knights',NULL),(6,'pending_activation',5),(7,'enable',3),(8,'listo para el combate',5),(9,'knights_location',NULL),(10,'head top left',9),(11,'head top right',9),(12,'head bottom left',9),(13,'head bottom right',9),(14,'left shoulder left',9),(15,'left shoulder right',9),(16,'armour top left',9),(17,'armour top right',9),(18,'right shoulder left',9),(19,'right shoulder right',9),(20,'left elbow top left',9),(21,'left elbow top right',9),(22,'armour medium top left outer',9),(23,'armour medium top lef inner',9),(24,'armour medium top right inner ',9),(25,'armour medium top right outer',9),(26,'right elbow top left',9),(27,'right elbow top right',9),(28,'left elbow bottom left',9),(29,'left elbow bottom right',9),(30,'armour medium bottom left outer',9),(31,'armour medium bottom left inner',9),(32,'armour medium bottom right inner',9),(33,'amour medium bottom right outer',9),(34,'right elbow bottom left',9),(35,'right elbow bottom right',9),(36,'left hand',9),(37,'armour bottom left outer',9),(38,'armour bottom left inner',9),(39,'armour bottom right inner',9),(40,'armour bottom right outer',9),(41,'right hand',9),(42,'armours_type',NULL),(43,'guante izquierdo',42),(44,'codera izquierda',42),(45,'hombrera izquierda',42),(46,'coraza',42),(47,'casco',42),(48,'escudo 2x2',42),(49,'escudo 2x3',42),(50,'escudo 3x2',42),(51,'escudo 3x3',42),(52,'escudo 4x3',42),(53,'escudo 3x4',42),(54,'escudo 4x4',42),(55,'equipments_type',NULL),(56,'armour',55),(57,'spear',55),(58,'spears_type',NULL),(59,'training',58),(60,'rookie',58),(61,'amateur',58),(62,'professional',58),(63,'master',58),(64,'leyend',58),(65,'guante derecho',42),(66,'codera derecha',42),(67,'hombrera derecha',42),(68,'trick',55),(69,'knight_attributes',NULL),(70,'strength',69),(71,'dexterity',69),(72,'constitution',69),(73,'perception',69),(74,'intelligence',69),(75,'skill',69),(76,'charisma',69),(77,'will',69),(78,'knight_skills',NULL),(79,'spear',78),(80,'shield',78),(81,'act',78),(82,'trade',78),(83,'manipulation',78),(84,'concentration',78),(85,'alert',78),(86,'stealth',78),(87,'knights_evolution_type',NULL),(88,'Mejora',87),(89,'Perdida',87),(90,'events_type',NULL),(91,'combats',90),(92,'knighsts_evolution',90),(93,'vacio',90),(94,'friends_type',NULL),(95,'a la espera',94),(96,'aceptada',94),(97,'rechazada',94),(98,'ocultar',94),(99,'terminada por emisor',94),(100,'terminada por receptor',94),(101,'mensaje',NULL),(102,'enviado',101),(103,'leidoo',101),(104,'borrado',101),(105,'combat_status',NULL),(106,'pendiente',105),(107,'activo',105),(108,'finalizado',105),(109,'combats_type',NULL),(110,'amistoso',109),(111,'torneo',109),(112,'combats_result',NULL),(113,'rechazado',112),(114,'gana emisor',112),(115,'gana emisor con herida',112),(116,'gana emisor con herida grave',112),(117,'gana emisor con herida muy grave',112),(118,'gana emisor con fatalidad',112),(119,'gana retado',112),(120,'gana retado con herida',112),(121,'gana retado con herida grave',112),(122,'gana retado con heria muy grave',112),(123,'gana retado con fatalidad',112),(124,'empate',112),(125,'empate con heridas',112),(126,'empate con heridas graves',112),(127,'empate con heridas muy graves',112),(128,'empate con fatalidades',112),(129,'rounds_status',NULL),(130,'en curso',129),(131,'Retador gana',129),(132,'Retado gana',129),(133,'empate',129),(134,'escudo',42),(135,'knight_injuries',NULL),(136,'herida leve',135),(137,'herida grave',135),(138,'herida muy grave',135),(139,'fatalidad',135),(140,'rounds_data_status',NULL),(141,'pendiente',140),(142,'aguantado',140),(143,'derribado',140),(144,'ko',140),(145,'lesionado',140),(146,'retador gana por 3 caidas',112),(147,'retado gana por 3 caidas',112),(148,'empate por caidas',112),(149,'combats_result_by',NULL),(150,'por 3 caidas',149),(151,'por lesión',149),(152,'por ko',149),(153,'sin equipo',112),(154,'knights_purchases_status',NULL),(155,'comprado',154),(156,'buscando',154),(157,'encontrado',154),(158,'no encontrado',154),(159,'jobs_status',NULL),(160,'working',159),(161,'finished',159),(162,'cancelled',159),(163,'trabajo',90),(164,'trabajando',5),(165,'en combate',5),(166,'emails_status',NULL),(167,'pendiente',166),(168,'enviado',166),(169,'error',166),(170,'yellow_page_letters',NULL),(171,'[0-9]',170),(172,'A',170),(173,'B',170),(174,'C',170),(175,'D',170),(176,'E',170),(177,'F',170),(178,'G',170),(179,'H',170),(180,'I',170),(181,'J',170),(182,'K',170),(183,'L',170),(184,'M',170),(185,'N',170),(186,'Ñ',170),(187,'O',170),(188,'P',170),(189,'Q',170),(190,'R',170),(191,'S',170),(192,'T',170),(193,'U',170),(194,'W',170),(195,'X',170),(196,'Y',170),(197,'Z',170),(198,'falta equipo',5),(200,'descalificación',149);
/*!40000 ALTER TABLE `constants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `controlCronjobs`
--

DROP TABLE IF EXISTS `controlCronjobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `controlCronjobs` (
  `id` tinyint(3) unsigned NOT NULL COMMENT 'identificador del job',
  `status` tinyint(1) DEFAULT NULL COMMENT 'estado del job. 0 sin ejecución 1 hay un proceso de ejecución.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Controla que sólo haya un cron del mismo tipo ejecutándose.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `controlCronjobs`
--

LOCK TABLES `controlCronjobs` WRITE;
/*!40000 ALTER TABLE `controlCronjobs` DISABLE KEYS */;
INSERT INTO `controlCronjobs` VALUES (1,0),(2,0),(3,0),(4,0),(5,0);
/*!40000 ALTER TABLE `controlCronjobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emails` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `destination` varchar(255) NOT NULL COMMENT 'dirección de email a la que enviar el correo.',
  `headers` text NOT NULL COMMENT 'las cabeceras para enviar el email',
  `title` varchar(255) NOT NULL COMMENT 'el título del email\n',
  `body` text NOT NULL COMMENT 'el cuerpo del email.',
  `status` int(10) unsigned NOT NULL COMMENT 'Status is pending, sended, error',
  `date` datetime NOT NULL COMMENT 'Fecha de cuando se registra.',
  PRIMARY KEY (`id`),
  KEY `fk_emails_constants1` (`status`),
  CONSTRAINT `fk_emails_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena los emails automáticos que la plataforma no envia d';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_qualities`
--

DROP TABLE IF EXISTS `equipment_qualities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_qualities` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `percent` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_qualities`
--

LOCK TABLES `equipment_qualities` WRITE;
/*!40000 ALTER TABLE `equipment_qualities` DISABLE KEYS */;
INSERT INTO `equipment_qualities` VALUES (1,'mala',0),(2,'común',1),(3,'buena',1),(4,'muy buena',2);
/*!40000 ALTER TABLE `equipment_qualities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_rarity`
--

DROP TABLE IF EXISTS `equipment_rarity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_rarity` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `percent` tinyint(3) unsigned NOT NULL,
  `difficulty` tinyint(3) unsigned NOT NULL,
  `search_time` smallint(5) unsigned NOT NULL COMMENT 'Hace referencia al tiempo que invierte el caballero en buscar el objeto en el mercado. Para hacer otra búsqueda tiene que esperar este tiempo. el tiempo está en minutos. ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Almacena los tipos de rareza del objeto. Sirve para ver cuan';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_rarity`
--

LOCK TABLES `equipment_rarity` WRITE;
/*!40000 ALTER TABLE `equipment_rarity` DISABLE KEYS */;
INSERT INTO `equipment_rarity` VALUES (1,'muy frecuente',100,0,0),(2,'frecuente',50,12,30),(3,'poco frecuente',25,15,60),(4,'rara',10,18,160),(5,'muy rara',5,21,360),(6,'legendaria',2,27,1440),(7,'única',1,30,0);
/*!40000 ALTER TABLE `equipment_rarity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_requirements`
--

DROP TABLE IF EXISTS `equipment_requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_requirements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identificator` int(10) unsigned NOT NULL,
  `equipments_type` int(10) unsigned NOT NULL,
  `requirements_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_equipment_requirements_constants1` (`equipments_type`),
  KEY `fk_equipment_requirements_identificator` (`equipments_type`,`identificator`),
  KEY `fk_equipment_requirements_requirements1` (`requirements_id`),
  CONSTRAINT `fk_equipment_requirements_constants1` FOREIGN KEY (`equipments_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_requirements_requirements1` FOREIGN KEY (`requirements_id`) REFERENCES `requirements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena el identificador del equipo, el tipo de equipamient';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_requirements`
--

LOCK TABLES `equipment_requirements` WRITE;
/*!40000 ALTER TABLE `equipment_requirements` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipment_requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_size`
--

DROP TABLE IF EXISTS `equipment_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment_size` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `size` tinyint(3) unsigned NOT NULL,
  `percent` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Almacenamos  el tipo de equipo (armadura/lanza), el identifi';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_size`
--

LOCK TABLES `equipment_size` WRITE;
/*!40000 ALTER TABLE `equipment_size` DISABLE KEYS */;
INSERT INTO `equipment_size` VALUES (1,'pequeño',1,25),(2,'medio',2,33),(3,'grande',3,66),(4,'muy grande',4,100);
/*!40000 ALTER TABLE `equipment_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` int(10) unsigned NOT NULL,
  `to_user` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `delete_by_user` int(10) unsigned DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_friends_constants1` (`status`),
  KEY `fk_friends_users1` (`from_user`),
  KEY `fk_friends_users2` (`to_user`),
  CONSTRAINT `fk_friends_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_users1` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_friends_users2` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `healings`
--

DROP TABLE IF EXISTS `healings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `healings` (
  `knights_id` int(10) unsigned NOT NULL COMMENT 'caballero',
  `next_healing_date` datetime DEFAULT NULL COMMENT 'null no hay curación pendiente. Si hay una fecha indica que hay una curación pendiente para esa fecha.',
  PRIMARY KEY (`knights_id`),
  CONSTRAINT `fk_healings_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Almacena la siguiente curación de un caballero. Las curacion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `healings`
--

LOCK TABLES `healings` WRITE;
/*!40000 ALTER TABLE `healings` DISABLE KEYS */;
/*!40000 ALTER TABLE `healings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL COMMENT 'Almacena la posición de un objeto de un tipo por cada caballero.',
  `type` int(10) unsigned NOT NULL COMMENT 'El type hace referencia al tipo del objeto que almacena si es armour, spears o artimaña.el identificador hace referencia al id del tipo que sea y la posición, la posición que ocupa dentro del inventario.',
  `identificator` int(10) unsigned NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `amount` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'El type es el tipo de objeto (lanza, armadura o artimaña). El identificator es el identificador de ese tipo de objeto, la position es la posicion que ocupa en el inventario. Amount es la cantidad de objetos que porta de ese  mismo objeto (utilizado para a',
  PRIMARY KEY (`id`),
  KEY `fk_inventory_knights1` (`knights_id`),
  KEY `fk_inventory_constants1` (`type`),
  CONSTRAINT `fk_inventory_constants1` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inventory_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory`
--

LOCK TABLES `inventory` WRITE;
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `knight_level` tinyint(3) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `hours` tinyint(3) unsigned NOT NULL COMMENT 'Cantidad de horas trabajadas.',
  `status` int(10) unsigned NOT NULL COMMENT 'Si está trabajando (working), si ha terminado el trabajo (finished) en cuyo caso se le ha pagado por el nivel o si ha cancelado el trabajo (cancelled) en cuyo caso no ve un pavo.',
  PRIMARY KEY (`id`),
  KEY `fk_jobs_knights1` (`knights_id`),
  KEY `fk_jobs_constants1` (`status`),
  CONSTRAINT `fk_jobs_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_jobs_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights`
--

DROP TABLE IF EXISTS `knights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(10) unsigned NOT NULL,
  `suscribe_date` datetime NOT NULL,
  `unsuscribe_date` datetime DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `endurance` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `life` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `pain` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `coins` int(10) unsigned NOT NULL DEFAULT '0',
  `experiencie_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `experiencie_used` int(10) unsigned NOT NULL DEFAULT '0',
  `avatars_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_knights_users1` (`users_id`),
  KEY `fk_knights_constants1` (`status`),
  KEY `fk_knights_avatars1` (`avatars_id`),
  CONSTRAINT `fk_knights_avatars1` FOREIGN KEY (`avatars_id`) REFERENCES `avatars` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights`
--

LOCK TABLES `knights` WRITE;
/*!40000 ALTER TABLE `knights` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_achievements`
--

DROP TABLE IF EXISTS `knights_achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_achievements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `achievements_id` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_knights_achivements_knights1` (`knights_id`),
  KEY `fk_knights_achivements_achievements1` (`achievements_id`),
  CONSTRAINT `fk_knights_achivements_achievements1` FOREIGN KEY (`achievements_id`) REFERENCES `achievements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_achivements_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=dec8 COLLATE=dec8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_achievements`
--

LOCK TABLES `knights_achievements` WRITE;
/*!40000 ALTER TABLE `knights_achievements` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_card`
--

DROP TABLE IF EXISTS `knights_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_card` (
  `knights_id` int(10) unsigned NOT NULL,
  `strength` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dexterity` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `constitution` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `perception` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `intelligence` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `skill` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `charisma` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `will` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `spear` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `shield` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `act` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `trade` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `manipulation` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `concentration` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `alert` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `stealth` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`knights_id`),
  CONSTRAINT `fk_knights_attributes_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_card`
--

LOCK TABLES `knights_card` WRITE;
/*!40000 ALTER TABLE `knights_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_events`
--

DROP TABLE IF EXISTS `knights_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `identificator` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_knights1` (`knights_id`),
  KEY `fk_knights_events_constants1` (`type`),
  CONSTRAINT `fk_events_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_events_constants1` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registramos todos los eventos de un caballero. El tipo indic';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_events`
--

LOCK TABLES `knights_events` WRITE;
/*!40000 ALTER TABLE `knights_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_events_last`
--

DROP TABLE IF EXISTS `knights_events_last`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_events_last` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `identificator` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_knights1` (`knights_id`),
  KEY `fk_table1_constants1` (`type`),
  CONSTRAINT `fk_table1_constants1` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='igual que la tabla de events pero almacena exclusivamente un';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_events_last`
--

LOCK TABLES `knights_events_last` WRITE;
/*!40000 ALTER TABLE `knights_events_last` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_events_last` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_evolution`
--

DROP TABLE IF EXISTS `knights_evolution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_evolution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `type` int(10) unsigned NOT NULL,
  `characteristic` int(10) unsigned NOT NULL,
  `value` tinyint(3) unsigned NOT NULL COMMENT 'el valor antes de subir o bajar.',
  `experiencie_used` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `combats_id` int(10) unsigned DEFAULT NULL COMMENT 'en los casos de downgrade identifica el combate en el cual se ha producido. En los upgrades es nulo.',
  PRIMARY KEY (`id`),
  KEY `fk_knights_evolution_knights1` (`knights_id`),
  KEY `fk_knights_evolution_constants1` (`type`),
  KEY `fk_knights_evolution_constants2` (`characteristic`),
  KEY `fk_knights_evolution_combats1` (`combats_id`),
  CONSTRAINT `fk_knights_evolution_combats1` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_evolution_constants1` FOREIGN KEY (`type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_evolution_constants2` FOREIGN KEY (`characteristic`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_evolution_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registra la evolución del caballero. La característica que h';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_evolution`
--

LOCK TABLES `knights_evolution` WRITE;
/*!40000 ALTER TABLE `knights_evolution` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_evolution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_purchases`
--

DROP TABLE IF EXISTS `knights_purchases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_purchases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `inventory_type_id` int(10) unsigned NOT NULL,
  `identificator` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `knights_card_charisma` tinyint(3) unsigned DEFAULT NULL,
  `knights_card_trade` tinyint(4) DEFAULT NULL,
  `throw` tinyint(3) unsigned DEFAULT NULL COMMENT 'tirada para ver si se encuentra.',
  PRIMARY KEY (`id`),
  KEY `fk_knights_purchases_knights1` (`knights_id`),
  KEY `fk_knights_purchases_constants1` (`inventory_type_id`),
  KEY `fk_knights_purchases_constants2` (`status`),
  CONSTRAINT `fk_knights_purchases_constants1` FOREIGN KEY (`inventory_type_id`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_purchases_constants2` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_purchases_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='compras de los caballeros. Cuando un objeto es comprado pasa';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_purchases`
--

LOCK TABLES `knights_purchases` WRITE;
/*!40000 ALTER TABLE `knights_purchases` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_purchases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_settings`
--

DROP TABLE IF EXISTS `knights_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_settings` (
  `knights_id` int(10) unsigned NOT NULL,
  `emailToSendChallenge` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `emailToFinishedCombat` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `emailToSendMessage` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `emailToSendFriendlyRequest` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`knights_id`),
  CONSTRAINT `fk_knights_settings_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_settings`
--

LOCK TABLES `knights_settings` WRITE;
/*!40000 ALTER TABLE `knights_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_stats`
--

DROP TABLE IF EXISTS `knights_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_stats` (
  `knights_id` int(10) unsigned NOT NULL,
  `combats_wins` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_received` int(10) unsigned NOT NULL DEFAULT '0',
  `money_total_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `money_maximum_earned_combat` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `desquality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `desquality_received` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`knights_id`),
  CONSTRAINT `fk_knights_stats_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tabla que alamcena todas las estadísticas totales de un caba';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_stats`
--

LOCK TABLES `knights_stats` WRITE;
/*!40000 ALTER TABLE `knights_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_stats_attack_location`
--

DROP TABLE IF EXISTS `knights_stats_attack_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_stats_attack_location` (
  `knights_id` int(10) unsigned NOT NULL,
  `location` int(10) unsigned NOT NULL,
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`knights_id`,`location`),
  KEY `fk_knights_stats_attacks_points_constants1` (`location`),
  CONSTRAINT `fk_knights_stats_attacks_points_constants1` FOREIGN KEY (`location`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_stats_attacks_points_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_stats_attack_location`
--

LOCK TABLES `knights_stats_attack_location` WRITE;
/*!40000 ALTER TABLE `knights_stats_attack_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_stats_attack_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_stats_by_date`
--

DROP TABLE IF EXISTS `knights_stats_by_date`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_stats_by_date` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `combats_wins` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_received` int(10) unsigned NOT NULL DEFAULT '0',
  `money_total_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `money_maximum_earned_combat` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received_successful` int(11) NOT NULL DEFAULT '0',
  `date` date NOT NULL,
  `desquality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `desquality_received` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_knights_stats_knights10` (`knights_id`),
  CONSTRAINT `fk_knights_stats_knights10` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tabla que alamcena todas las estadísticas totales de un caba';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_stats_by_date`
--

LOCK TABLES `knights_stats_by_date` WRITE;
/*!40000 ALTER TABLE `knights_stats_by_date` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_stats_by_date` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_stats_defense_location`
--

DROP TABLE IF EXISTS `knights_stats_defense_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_stats_defense_location` (
  `knights_id` int(10) unsigned NOT NULL,
  `location` int(10) unsigned NOT NULL,
  `armours_type` int(10) unsigned NOT NULL COMMENT 'Is size of shield ',
  `amount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`knights_id`,`location`,`armours_type`),
  KEY `fk_knights_stats_defense_location_constants1` (`location`),
  KEY `fk_knights_stats_defense_location_constants2` (`armours_type`),
  CONSTRAINT `fk_knights_stats_defense_location_constants1` FOREIGN KEY (`location`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_stats_defense_location_constants2` FOREIGN KEY (`armours_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_stats_defense_location_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_stats_defense_location`
--

LOCK TABLES `knights_stats_defense_location` WRITE;
/*!40000 ALTER TABLE `knights_stats_defense_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_stats_defense_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knights_stats_vs`
--

DROP TABLE IF EXISTS `knights_stats_vs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `knights_stats_vs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `opponent` int(10) unsigned NOT NULL,
  `combats_wins` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_wins_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_draw_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose` int(10) unsigned NOT NULL DEFAULT '0',
  `combats_loose_injury` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `hits_total_received_blocked` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `damage_maximum_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_light_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_very_serious_received` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `injury_total_fatality_received` int(10) unsigned NOT NULL DEFAULT '0',
  `money_total_earned` int(10) unsigned NOT NULL DEFAULT '0',
  `money_maximum_earned_combat` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_used_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received` int(10) unsigned NOT NULL DEFAULT '0',
  `tricks_total_received_successful` int(10) unsigned NOT NULL DEFAULT '0',
  `desquality_produced` int(10) unsigned NOT NULL DEFAULT '0',
  `desquality_received` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_knights_stats_knights2` (`opponent`),
  KEY `fk_knights_stats_knights11` (`knights_id`),
  CONSTRAINT `fk_knights_stats_knights11` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_knights_stats_knights21` FOREIGN KEY (`opponent`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tabla que alamcena todas las estadísticas totales de un caba';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knights_stats_vs`
--

LOCK TABLES `knights_stats_vs` WRITE;
/*!40000 ALTER TABLE `knights_stats_vs` DISABLE KEYS */;
/*!40000 ALTER TABLE `knights_stats_vs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_user` int(10) unsigned NOT NULL,
  `to_user` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `text` varchar(140) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_messages_constants1` (`status`),
  KEY `fk_messages_users1` (`from_user`),
  KEY `fk_messages_users2` (`to_user`),
  CONSTRAINT `fk_messages_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users1` FOREIGN KEY (`from_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users2` FOREIGN KEY (`to_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_last_one_by_user`
--

DROP TABLE IF EXISTS `messages_last_one_by_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_last_one_by_user` (
  `users_id` int(10) unsigned NOT NULL,
  `with_user` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `text` varchar(140) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`users_id`,`with_user`),
  KEY `fk_messages_general_users1` (`users_id`),
  KEY `fk_messages_general_users2` (`with_user`),
  KEY `fk_messages_last_one_by_user_constants1` (`status`),
  CONSTRAINT `fk_messages_general_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_general_users2` FOREIGN KEY (`with_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_last_one_by_user_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Para la pantalla messages, donde salen el último mensaje esc';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages_last_one_by_user`
--

LOCK TABLES `messages_last_one_by_user` WRITE;
/*!40000 ALTER TABLE `messages_last_one_by_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages_last_one_by_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_last_one_new`
--

DROP TABLE IF EXISTS `messages_last_one_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_last_one_new` (
  `users_id` int(10) unsigned NOT NULL,
  `with_user` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `text` varchar(140) NOT NULL COMMENT 'esta tabla almacena los mensajes de la barra superior.',
  `date` datetime NOT NULL,
  PRIMARY KEY (`users_id`,`with_user`),
  KEY `fk_message_last_one_new_users1` (`users_id`),
  KEY `fk_message_last_one_new_users2` (`with_user`),
  KEY `fk_message_last_one_new_constants1` (`status`),
  CONSTRAINT `fk_message_last_one_new_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_last_one_new_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_last_one_new_users2` FOREIGN KEY (`with_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages_last_one_new`
--

LOCK TABLES `messages_last_one_new` WRITE;
/*!40000 ALTER TABLE `messages_last_one_new` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages_last_one_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `object_repairs`
--

DROP TABLE IF EXISTS `object_repairs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `object_repairs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knights_id` int(10) unsigned NOT NULL,
  `inventory_type` int(10) unsigned NOT NULL COMMENT 'Typo de item en el inventario. Puede ser lanza, armadura o trampa aún qué trampa no se utilice.',
  `combats_id` int(10) unsigned DEFAULT NULL COMMENT 'Identifica si se ha realizado automáticamente después de un combate. Sino null\n',
  `object_identificator` int(10) unsigned NOT NULL COMMENT 'identificador del objeto.',
  `class_identificator` int(10) unsigned NOT NULL COMMENT 'identificador de la clase del objeto. Es el id de la tabla armours o spears.',
  `current_pde` tinyint(3) unsigned NOT NULL COMMENT 'pde al finalizar el combate.',
  `maximum_pde` tinyint(3) unsigned NOT NULL,
  `repair_cost` int(10) unsigned NOT NULL COMMENT 'coste de la reparacion en monedas de oro.',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_combats_postcombat_repairs_constants1` (`inventory_type`),
  KEY `fk_object_repair_knights1` (`knights_id`),
  KEY `fk_object_repairs_combats1` (`combats_id`),
  CONSTRAINT `fk_combats_postcombat_repairs_constants1` FOREIGN KEY (`inventory_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_object_repairs_combats1` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_object_repair_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Regitra las reparaciones que se han realizado automáticament';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `object_repairs`
--

LOCK TABLES `object_repairs` WRITE;
/*!40000 ALTER TABLE `object_repairs` DISABLE KEYS */;
/*!40000 ALTER TABLE `object_repairs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requirements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `attribute` int(10) unsigned DEFAULT NULL,
  `skill` int(10) unsigned DEFAULT NULL,
  `value` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_equipment_requirement_constants1` (`attribute`),
  KEY `fk_equipment_requirement_constants2` (`skill`),
  CONSTRAINT `fk_equipment_requirement_constants1` FOREIGN KEY (`attribute`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_equipment_requirement_constants2` FOREIGN KEY (`skill`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirements`
--

LOCK TABLES `requirements` WRITE;
/*!40000 ALTER TABLE `requirements` DISABLE KEYS */;
/*!40000 ALTER TABLE `requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rounds`
--

DROP TABLE IF EXISTS `rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rounds` (
  `combats_id` int(10) unsigned NOT NULL,
  `number` tinyint(3) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL COMMENT 'status es si está pendiente (amarillo), si ha ganado el jugador azul, rojo o están empatados.',
  PRIMARY KEY (`combats_id`,`number`),
  KEY `fk_confrontations_constants1` (`status`),
  CONSTRAINT `fk_confrontations_combats2` FOREIGN KEY (`combats_id`) REFERENCES `combats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_confrontations_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rounds`
--

LOCK TABLES `rounds` WRITE;
/*!40000 ALTER TABLE `rounds` DISABLE KEYS */;
/*!40000 ALTER TABLE `rounds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rounds_data`
--

DROP TABLE IF EXISTS `rounds_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rounds_data` (
  `rounds_combats_id` int(10) unsigned NOT NULL,
  `rounds_number` tinyint(3) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `date` datetime NOT NULL,
  `knights_endurance` tinyint(3) unsigned NOT NULL,
  `knights_life` tinyint(3) unsigned NOT NULL,
  `knights_pain` tinyint(3) unsigned NOT NULL,
  `attack_point` tinyint(3) unsigned NOT NULL,
  `defense_point` tinyint(3) unsigned NOT NULL,
  `pain_throw` tinyint(3) unsigned DEFAULT NULL,
  `knights_will` tinyint(3) unsigned NOT NULL,
  `knights_concentration` tinyint(3) unsigned NOT NULL,
  `knights_skill` tinyint(3) unsigned NOT NULL,
  `knights_dexterity` tinyint(3) unsigned NOT NULL,
  `knights_spear` tinyint(3) unsigned NOT NULL,
  `knights_shield` tinyint(3) unsigned NOT NULL,
  `knights_constitution` tinyint(3) unsigned NOT NULL,
  `armour_id` int(10) unsigned DEFAULT NULL,
  `armour_object_pde_initial` tinyint(3) unsigned DEFAULT NULL,
  `armour_object_pde_final` tinyint(3) unsigned DEFAULT NULL,
  `shield_id` int(10) unsigned NOT NULL,
  `shield_object_pde_initial` tinyint(3) unsigned NOT NULL,
  `shield_object_pde_final` tinyint(3) unsigned DEFAULT NULL,
  `spears_id` int(10) unsigned NOT NULL,
  `spears_object_pde_initial` tinyint(3) unsigned NOT NULL,
  `spears_object_pde_final` tinyint(3) unsigned DEFAULT NULL,
  `attack_throw` tinyint(3) unsigned NOT NULL,
  `defense_throw` tinyint(3) unsigned NOT NULL,
  `is_pain_throw_pass` tinyint(1) unsigned DEFAULT NULL,
  `received_impact_inventory_position` tinyint(3) unsigned DEFAULT NULL,
  `is_received_impact_defended` tinyint(1) unsigned DEFAULT '0',
  `received_damage` tinyint(3) unsigned DEFAULT NULL COMMENT 'daño que recibe el caballero',
  `defended_damage` tinyint(3) unsigned DEFAULT NULL COMMENT 'daño que defiende el caballero\n',
  `is_falled` tinyint(1) unsigned DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `injury_type` int(10) unsigned DEFAULT NULL,
  `pde_armour_loosed` tinyint(3) unsigned DEFAULT NULL,
  `pde_shield_loosed` tinyint(3) unsigned DEFAULT NULL,
  `pde_spear_loosed` tinyint(3) unsigned DEFAULT NULL,
  `is_armour_destroyed` tinyint(1) unsigned DEFAULT '0',
  `is_shield_destroyed` tinyint(1) unsigned DEFAULT '0',
  `is_spear_destroyed` tinyint(1) unsigned DEFAULT '0',
  `extra_damage` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`rounds_combats_id`,`rounds_number`,`knights_id`),
  KEY `fk_confrontations_knights1` (`knights_id`),
  KEY `fk_rounds_data_rounds1` (`rounds_combats_id`,`rounds_number`),
  KEY `fk_rounds_data_spears1` (`spears_id`),
  KEY `fk_rounds_data_armours1` (`armour_id`),
  KEY `fk_rounds_data_armours2` (`shield_id`),
  KEY `fk_rounds_data_constants1` (`status`),
  KEY `fk_rounds_data_constants2` (`injury_type`),
  CONSTRAINT `fk_confrontations_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_armours1` FOREIGN KEY (`armour_id`) REFERENCES `armours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_armours2` FOREIGN KEY (`shield_id`) REFERENCES `armours` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_constants2` FOREIGN KEY (`injury_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_rounds1` FOREIGN KEY (`rounds_combats_id`, `rounds_number`) REFERENCES `rounds` (`combats_id`, `number`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rounds_data_spears1` FOREIGN KEY (`spears_id`) REFERENCES `spears` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contiene todos los datos necesario para resolver un combate.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rounds_data`
--

LOCK TABLES `rounds_data` WRITE;
/*!40000 ALTER TABLE `rounds_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `rounds_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `users_id` int(11) unsigned DEFAULT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spears`
--

DROP TABLE IF EXISTS `spears`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spears` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `spears_materials_id` int(10) unsigned NOT NULL,
  `equipment_size_id` tinyint(3) unsigned NOT NULL,
  `equipment_qualities_id` tinyint(3) unsigned NOT NULL,
  `equipment_rarity_id` tinyint(3) unsigned NOT NULL,
  `damage` tinyint(3) unsigned NOT NULL,
  `pde` tinyint(3) unsigned NOT NULL,
  `prize` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_spears_spears_materials1` (`spears_materials_id`),
  KEY `fk_spears_equipment_size1` (`equipment_size_id`),
  KEY `fk_spears_equipment_qualities1` (`equipment_qualities_id`),
  KEY `fk_spears_equipment_rarity1` (`equipment_rarity_id`),
  CONSTRAINT `fk_spears_equipment_qualities1` FOREIGN KEY (`equipment_qualities_id`) REFERENCES `equipment_qualities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_spears_equipment_rarity1` FOREIGN KEY (`equipment_rarity_id`) REFERENCES `equipment_rarity` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_spears_equipment_size1` FOREIGN KEY (`equipment_size_id`) REFERENCES `equipment_size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_spears_spears_materials1` FOREIGN KEY (`spears_materials_id`) REFERENCES `spears_materials` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spears`
--

LOCK TABLES `spears` WRITE;
/*!40000 ALTER TABLE `spears` DISABLE KEYS */;
INSERT INTO `spears` VALUES (1,'Lanza de entrenamiento',2,1,1,1,5,20,2);
/*!40000 ALTER TABLE `spears` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spears_materials`
--

DROP TABLE IF EXISTS `spears_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spears_materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` tinyint(3) unsigned NOT NULL,
  `maximum_damage` float unsigned NOT NULL,
  `prize` int(10) unsigned NOT NULL,
  `endurance` smallint(5) unsigned NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spears_materials`
--

LOCK TABLES `spears_materials` WRITE;
/*!40000 ALTER TABLE `spears_materials` DISABLE KEYS */;
INSERT INTO `spears_materials` VALUES (1,1,1,1,1,'entrenamiento'),(2,2,2,2,2,'entrenamiento reforzado'),(3,3,7.5,4,3,'novato'),(4,4,13,8,4,'amateur'),(5,5,17.5,16,5,'amateur reforzado'),(6,6,21,32,6,'profesional'),(7,7,24.5,64,7,'profesional reforzado'),(8,8,28,128,8,'maestro'),(9,9,31.5,256,9,'gran maestro'),(10,10,35,512,10,'leyenda nivel 1'),(11,11,38.5,1024,11,'leyenda nivel 2'),(12,12,42,2048,12,'leyenda nivel 3'),(13,13,45.5,4096,13,'leyenda épica'),(14,14,49,8192,14,'leyenda épica nivel 2'),(15,15,52.5,16384,15,'leyenda épica nivel 3'),(16,16,56,32768,16,'leyenda épica nivel 4'),(17,17,59.5,65536,17,'leyenda épica nivel 5'),(18,18,63,131072,18,'leyenda épica nivel 6'),(19,19,66.5,262144,19,'leyenda épica nivel 7'),(20,20,70,524288,20,'leyenda épica nivel 8');
/*!40000 ALTER TABLE `spears_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `spears_objects`
--

DROP TABLE IF EXISTS `spears_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spears_objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `spears_id` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  `current_pde` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_spears_objects_spears1` (`spears_id`),
  KEY `fk_spears_objects_knights1` (`knights_id`),
  CONSTRAINT `fk_spears_objects_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_spears_objects_spears1` FOREIGN KEY (`spears_id`) REFERENCES `spears` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `spears_objects`
--

LOCK TABLES `spears_objects` WRITE;
/*!40000 ALTER TABLE `spears_objects` DISABLE KEYS */;
/*!40000 ALTER TABLE `spears_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tricks`
--

DROP TABLE IF EXISTS `tricks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tricks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `usedInTime` int(10) unsigned NOT NULL COMMENT 'el  usedInTime se refiere a si es PRE-COMBATE, COMBATE o POST-combate.',
  `throw` varchar(60) DEFAULT NULL COMMENT 'throw es la tirada que hay que hacer sino tiene éxito automático. Almacena la tirada que hay que superar. En los casos de tirada enfrentada lleva un formato: "skill+steal>perception+alert" mientras que en los casos en los que un caballero tiene un valor d',
  `automaticSuccessful` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Hace referencia a si tiene o no éxito automático.',
  `knight_target` int(10) unsigned NOT NULL COMMENT 'hace referencia al caballero que es objetivo. puede ser el mismo que utiliza la artimaña o el adversario.',
  `effect_type` int(10) unsigned NOT NULL COMMENT 'Hace referencia al tipo de efecto, puntos o %, repetir tirada.',
  `value` smallint(5) unsigned DEFAULT NULL COMMENT 'hace referencia al valor que, dependiendo del effect_type, será 5 puntos o 5 % o una tirada mayor o menor que 5. ',
  `target_effect` int(10) unsigned NOT NULL COMMENT 'Es el objetivo del efecto, puede ser la vida del caballero, la resistencia, la tirada de ataque o defensa, o modificador a la tirada.',
  PRIMARY KEY (`id`),
  KEY `fk_tricks_constants1` (`usedInTime`),
  KEY `fk_tricks_constants2` (`knight_target`),
  KEY `fk_tricks_constants3` (`effect_type`),
  KEY `fk_tricks_constants4` (`target_effect`),
  CONSTRAINT `fk_tricks_constants1` FOREIGN KEY (`usedInTime`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tricks_constants2` FOREIGN KEY (`knight_target`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tricks_constants3` FOREIGN KEY (`effect_type`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tricks_constants4` FOREIGN KEY (`target_effect`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tricks`
--

LOCK TABLES `tricks` WRITE;
/*!40000 ALTER TABLE `tricks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tricks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password_md5` varchar(32) NOT NULL,
  `password_sha512` varchar(128) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `suscribe_date` datetime NOT NULL,
  `unsuscribe_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_constants1` (`status`),
  CONSTRAINT `fk_users_constants1` FOREIGN KEY (`status`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yellow_pages_total`
--

DROP TABLE IF EXISTS `yellow_pages_total`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yellow_pages_total` (
  `letter` int(10) unsigned NOT NULL,
  `total` int(10) unsigned NOT NULL,
  PRIMARY KEY (`letter`),
  CONSTRAINT `fk_yellow_pages_total_constants1` FOREIGN KEY (`letter`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yellow_pages_total`
--

LOCK TABLES `yellow_pages_total` WRITE;
/*!40000 ALTER TABLE `yellow_pages_total` DISABLE KEYS */;
/*!40000 ALTER TABLE `yellow_pages_total` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yellow_pages_total_by_letter`
--

DROP TABLE IF EXISTS `yellow_pages_total_by_letter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yellow_pages_total_by_letter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `letter` int(10) unsigned NOT NULL,
  `knights_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_yellow_pages_total_constants1` (`letter`),
  KEY `fk_yellow_pages_total_by_letter_knights1` (`knights_id`),
  CONSTRAINT `fk_yellow_pages_total_by_letter_knights1` FOREIGN KEY (`knights_id`) REFERENCES `knights` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_yellow_pages_total_constants10` FOREIGN KEY (`letter`) REFERENCES `constants` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yellow_pages_total_by_letter`
--

LOCK TABLES `yellow_pages_total_by_letter` WRITE;
/*!40000 ALTER TABLE `yellow_pages_total_by_letter` DISABLE KEYS */;
/*!40000 ALTER TABLE `yellow_pages_total_by_letter` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-16 17:50:46
