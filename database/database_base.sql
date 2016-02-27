-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: etecsocial
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.10-MariaDB

CREATE DATABASE etecsocial;
use etecsocial;

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
-- Table structure for table `agendas`
--

DROP TABLE IF EXISTS `agendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agendas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_publico` tinyint(1) DEFAULT '0',
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_turma` int(11) NOT NULL DEFAULT '0',
  `id_modulo` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_turma`),
  KEY `idx_start` (`start`),
  KEY `idx_end` (`end`),
  KEY `fk_agendas_users1_idx` (`id_user`),
  KEY `fk_agendas_turmas1_idx` (`id_turma`),
  CONSTRAINT `fk_agendas_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agendas`
--

LOCK TABLES `agendas` WRITE;
/*!40000 ALTER TABLE `agendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `agendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `amizades`
--

DROP TABLE IF EXISTS `amizades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amizades` (
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) NOT NULL,
  `aceitou` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `amizades_id_user1_foreign` (`id_user1`),
  KEY `amizades_id_user2_foreign` (`id_user2`),
  CONSTRAINT `amizades_id_user1_foreign` FOREIGN KEY (`id_user1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `amizades_id_user2_foreign` FOREIGN KEY (`id_user2`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amizades`
--

LOCK TABLES `amizades` WRITE;
/*!40000 ALTER TABLE `amizades` DISABLE KEYS */;
/*!40000 ALTER TABLE `amizades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `msg` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` int(11) NOT NULL,
  `visto` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `chats_id_remetente_foreign` (`id_remetente`),
  KEY `chats_id_destinatario_foreign` (`id_destinatario`),
  CONSTRAINT `chats_id_destinatario_foreign` FOREIGN KEY (`id_destinatario`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chats_id_remetente_foreign` FOREIGN KEY (`id_remetente`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chats`
--

LOCK TABLES `chats` WRITE;
/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_post` int(10) unsigned NOT NULL,
  `comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comentarios_id_user_foreign` (`id_user`),
  KEY `comentarios_id_post_foreign` (`id_post`),
  CONSTRAINT `comentarios_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios_discussao`
--

DROP TABLE IF EXISTS `comentarios_discussao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios_discussao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_discussao` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comentarios_discussao_grupo_discussao1_idx` (`id_discussao`),
  KEY `fk_comentarios_discussao_grupo1_idx` (`id_grupo`),
  KEY `fk_comentarios_discussao_users1_idx` (`id_user`),
  CONSTRAINT `fk_comentarios_discussao_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentarios_discussao_grupo_discussao1` FOREIGN KEY (`id_discussao`) REFERENCES `grupo_discussao` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentarios_discussao_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios_discussao`
--

LOCK TABLES `comentarios_discussao` WRITE;
/*!40000 ALTER TABLE `comentarios_discussao` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios_discussao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentarios_pergunta`
--

DROP TABLE IF EXISTS `comentarios_pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comentarios_pergunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(300) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pergunta` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_comentarios_pergunta_users1_idx` (`id_user`),
  KEY `fk_comentarios_pergunta_grupo_pergunta1_idx` (`id_pergunta`),
  KEY `fk_comentarios_pergunta_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_comentarios_pergunta_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentarios_pergunta_grupo_pergunta1` FOREIGN KEY (`id_pergunta`) REFERENCES `grupo_pergunta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comentarios_pergunta_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios_pergunta`
--

LOCK TABLES `comentarios_pergunta` WRITE;
/*!40000 ALTER TABLE `comentarios_pergunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios_pergunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denuncia`
--

DROP TABLE IF EXISTS `denuncia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denuncia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mensagem` int(11) NOT NULL,
  `data` date NOT NULL,
  `denuncia` varchar(50) NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `excluir` int(3) NOT NULL,
  `num_avaliacoes` int(11) NOT NULL,
  `id_prof_1` int(11) NOT NULL,
  `id_prof_2` int(11) NOT NULL,
  `id_prof_3` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` int(11) NOT NULL,
  `id_post` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_denuncia_users1_idx` (`id_usuario`),
  KEY `fk_denuncia_posts1_idx` (`id_post`),
  CONSTRAINT `fk_denuncia_posts1` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncia_users1` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denuncia`
--

LOCK TABLES `denuncia` WRITE;
/*!40000 ALTER TABLE `denuncia` DISABLE KEYS */;
/*!40000 ALTER TABLE `denuncia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denuncias_grupo`
--

DROP TABLE IF EXISTS `denuncias_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denuncias_grupo` (
  `tipo` varchar(20) NOT NULL,
  `id_pub` int(11) NOT NULL,
  `denuncia` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `visto` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_autor_denuncia` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_autor_pub` int(11) NOT NULL,
  PRIMARY KEY (`tipo`,`id_pub`,`denuncia`,`id_autor_denuncia`,`id_grupo`),
  KEY `fk_denuncias_grupo_users1_idx` (`id_autor_denuncia`),
  KEY `fk_denuncias_grupo_grupo1_idx` (`id_grupo`),
  KEY `fk_denuncias_grupo_users2_idx` (`id_autor_pub`),
  CONSTRAINT `fk_denuncias_grupo_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncias_grupo_users1` FOREIGN KEY (`id_autor_denuncia`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_denuncias_grupo_users2` FOREIGN KEY (`id_autor_pub`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denuncias_grupo`
--

LOCK TABLES `denuncias_grupo` WRITE;
/*!40000 ALTER TABLE `denuncias_grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `denuncias_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favoritos` (
  `id_user` int(11) NOT NULL,
  `id_post` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_user`,`id_post`),
  KEY `favoritos_id_post_foreign` (`id_post`),
  CONSTRAINT `favoritos_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favoritos_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favoritos`
--

LOCK TABLES `favoritos` WRITE;
/*!40000 ALTER TABLE `favoritos` DISABLE KEYS */;
/*!40000 ALTER TABLE `favoritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `assunto` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `criacao` date NOT NULL,
  `materia` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_criador` int(11) NOT NULL,
  `expiracao` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_participantes` int(11) NOT NULL,
  `num_discussoes` int(11) NOT NULL,
  `num_perguntas` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_ativ`
--

DROP TABLE IF EXISTS `grupo_ativ`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_ativ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_rem` int(11) NOT NULL,
  `desc` varchar(55) DEFAULT NULL,
  `tipo` varchar(10) NOT NULL,
  `data_evento` date NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_ativ_grupo1_idx` (`id_grupo`),
  KEY `fk_grupo_ativ_users1_idx` (`id_rem`),
  CONSTRAINT `fk_grupo_ativ_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_ativ_users1` FOREIGN KEY (`id_rem`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_ativ`
--

LOCK TABLES `grupo_ativ` WRITE;
/*!40000 ALTER TABLE `grupo_ativ` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_ativ` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_discussao`
--

DROP TABLE IF EXISTS `grupo_discussao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_discussao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(40) NOT NULL DEFAULT 'Sem título',
  `assunto` varchar(40) NOT NULL,
  `discussao` varchar(2000) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_discussao_grupo1_idx` (`id_grupo`),
  KEY `fk_grupo_discussao_users1_idx` (`id_autor`),
  CONSTRAINT `fk_grupo_discussao_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_discussao_users1` FOREIGN KEY (`id_autor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_discussao`
--

LOCK TABLES `grupo_discussao` WRITE;
/*!40000 ALTER TABLE `grupo_discussao` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_discussao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_material`
--

DROP TABLE IF EXISTS `grupo_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(15) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `caminho` varchar(100) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_material_grupo1_idx` (`id_grupo`),
  KEY `fk_grupo_material_users1_idx` (`id_autor`),
  CONSTRAINT `fk_grupo_material_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_material_users1` FOREIGN KEY (`id_autor`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_material`
--

LOCK TABLES `grupo_material` WRITE;
/*!40000 ALTER TABLE `grupo_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_notas`
--

DROP TABLE IF EXISTS `grupo_notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_notas` (
  `id` int(11) NOT NULL,
  `nota` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_prof` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_notas_users1_idx` (`id_prof`),
  KEY `fk_grupo_notas_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_grupo_notas_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_notas_users1` FOREIGN KEY (`id_prof`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_notas`
--

LOCK TABLES `grupo_notas` WRITE;
/*!40000 ALTER TABLE `grupo_notas` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_pergunta`
--

DROP TABLE IF EXISTS `grupo_pergunta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_pergunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `assunto` varchar(30) NOT NULL DEFAULT 'Sem assunto',
  `pergunta` varchar(200) NOT NULL,
  `data` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_autor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_pergunta_grupo1_idx` (`id_grupo`),
  KEY `fk_grupo_pergunta_users1_idx` (`id_autor`),
  CONSTRAINT `fk_grupo_pergunta_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_pergunta_users1` FOREIGN KEY (`id_autor`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_pergunta`
--

LOCK TABLES `grupo_pergunta` WRITE;
/*!40000 ALTER TABLE `grupo_pergunta` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_pergunta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_saiu`
--

DROP TABLE IF EXISTS `grupo_saiu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_saiu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `motivo` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_grupo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_saiu_users1_idx` (`id_user`),
  KEY `fk_grupo_saiu_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_grupo_saiu_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_saiu_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_saiu`
--

LOCK TABLES `grupo_saiu` WRITE;
/*!40000 ALTER TABLE `grupo_saiu` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_saiu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_usuario`
--

DROP TABLE IF EXISTS `grupo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) unsigned NOT NULL,
  `id_user` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_banido` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_grupo_usuario_users1_idx` (`id_user`),
  KEY `fk_grupo_usuario_grupo1_idx` (`id_grupo`),
  CONSTRAINT `fk_grupo_usuario_grupo1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_usuario_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_usuario`
--

LOCK TABLES `grupo_usuario` WRITE;
/*!40000 ALTER TABLE `grupo_usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lista_etecs`
--

DROP TABLE IF EXISTS `lista_etecs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lista_etecs` (
  `id_etec` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(90) DEFAULT NULL,
  `cod_prof` int(7) DEFAULT NULL,
  PRIMARY KEY (`id_etec`),
  UNIQUE KEY `cod_prof_UNIQUE` (`cod_prof`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lista_etecs`
--

LOCK TABLES `lista_etecs` WRITE;
/*!40000 ALTER TABLE `lista_etecs` DISABLE KEYS */;
INSERT INTO `lista_etecs` VALUES (1,'ETEC Pedro Ferreira Alves',2830),(2,'ETEC Euro Albino de Souza',1276);
/*!40000 ALTER TABLE `lista_etecs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulos` (
  `id` int(11) NOT NULL,
  `modulo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'1'),(2,'2'),(3,'3');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificacaos`
--

DROP TABLE IF EXISTS `notificacaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificacaos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_rem` int(11) NOT NULL,
  `id_dest` int(11) NOT NULL,
  `texto` varchar(60) NOT NULL,
  `is_post` tinyint(1) NOT NULL DEFAULT '0',
  `visto` tinyint(1) NOT NULL,
  `action` varchar(90) NOT NULL DEFAULT '0',
  `data` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`id_dest`),
  KEY `fk_notificacaos_users1_idx` (`id_rem`),
  KEY `fk_notificacaos_users2_idx` (`id_dest`),
  CONSTRAINT `fk_notificacaos_users1` FOREIGN KEY (`id_rem`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_notificacaos_users2` FOREIGN KEY (`id_dest`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificacaos`
--

LOCK TABLES `notificacaos` WRITE;
/*!40000 ALTER TABLE `notificacaos` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificacaos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(45) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Sem título',
  `publicacao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_favoritos` int(11) NOT NULL DEFAULT '0',
  `num_reposts` int(11) NOT NULL DEFAULT '0',
  `num_comentarios` int(11) NOT NULL DEFAULT '0',
  `url_midia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_imagem` tinyint(1) NOT NULL DEFAULT '0',
  `is_video` tinyint(1) NOT NULL DEFAULT '0',
  `is_publico` tinyint(1) NOT NULL DEFAULT '0',
  `is_repost` tinyint(1) NOT NULL DEFAULT '0',
  `id_repost` int(10) unsigned NOT NULL,
  `is_question` tinyint(1) NOT NULL,
  `user_repost` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `posts_id_user_foreign` (`id_user`),
  CONSTRAINT `posts_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (190,1,'InfoBus','Eu já não gosto. Joga fora mt longe.',1,0,0,'images/place-post.jpg',0,0,0,1,189,0,60,'2015-12-08 01:43:23','2015-12-08 03:43:23');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id_post` int(10) unsigned NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `tags_id_post_foreign` (`id_post`),
  CONSTRAINT `tags_id_post_foreign` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarefas`
--

DROP TABLE IF EXISTS `tarefas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarefas` (
  `desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` int(11) NOT NULL,
  `data_checked` int(11) NOT NULL DEFAULT '0',
  `checked` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tarefas_users1_idx` (`id_user`),
  CONSTRAINT `fk_tarefas_users1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarefas`
--

LOCK TABLES `tarefas` WRITE;
/*!40000 ALTER TABLE `tarefas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tarefas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turmas`
--

DROP TABLE IF EXISTS `turmas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `sigla` varchar(60) NOT NULL,
  `id_escola` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_turmas_lista_etecs1_idx` (`id_escola`),
  CONSTRAINT `fk_turmas_lista_etecs1` FOREIGN KEY (`id_escola`) REFERENCES `lista_etecs` (`id_etec`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turmas`
--

LOCK TABLES `turmas` WRITE;
/*!40000 ALTER TABLE `turmas` DISABLE KEYS */;
INSERT INTO `turmas` VALUES (1,'Ensino Médio Integrado a Informática para Internet','EMIA',1),(2,'Ensino Médio Integrado a Meio Ambiente','EMMEIO',1),(3,'Ensino Médio Integrado a Mecânica','EMMEC',1),(4,'Ensino Médio Integrado a Administração','EMAD',1),(5,'Ensino Médio Turma A','EMA',1),(6,'Ensino Médio Turma B','EMB',1),(7,'Ensino Médio Integrado a Informática para Internet RA','EMIRA',1);
/*!40000 ALTER TABLE `turmas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `email_alternativo` varchar(45) DEFAULT NULL,
  `tipo` int(1) NOT NULL,
  `password` varchar(110) NOT NULL,
  `nome` varchar(110) DEFAULT NULL,
  `info_academica` text,
  `status` varchar(180) DEFAULT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `reputacao` int(11) NOT NULL DEFAULT '0',
  `num_desafios` int(11) NOT NULL DEFAULT '0',
  `num_auxilios` int(11) NOT NULL DEFAULT '0',
  `confirmation_code` varchar(255) DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT '0',
  `nasc` date NOT NULL,
  `empresa` varchar(255) NOT NULL DEFAULT '0',
  `cargo` varchar(255) NOT NULL DEFAULT '0',
  `habilidades` varchar(255) NOT NULL DEFAULT '0',
  `cidade` varchar(255) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_turma` int(11) DEFAULT NULL,
  `id_escola` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_alternativo_UNIQUE` (`email_alternativo`),
  KEY `fk_users_turmas1_idx` (`id_turma`),
  CONSTRAINT `fk_users_turmas1` FOREIGN KEY (`id_turma`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'marcio','eu@marciosimoes.com','',1,'$2y$10$S.CSLSgVoU2fAUMRr1h4uOUzlrDjYwgkpXZlgEtCxqi7g4XgfKQda','Marcio Simões','{\"is_prof\":false,\"instituicao\":\"ETEC Pedro Ferreira Alves\",\"modulo\":\"3\\u00ba S\\u00e9rie\",\"curso\":\"Ensino M\\u00e9dio Integrado a Inform\\u00e1tica para Internet\",\"conclusao\":\"2015\"}','oi',0,0,0,0,NULL,1,'0000-00-00','','0','','Mogi Guaçu','MJY98tAFfY9kkzadAAMffNWwKGHujffH9PrVPZSxdHB86uef1qOuC7EMgjMJ','2016-02-27 02:22:20','2016-02-27 02:22:20',1,1,3);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-27 16:24:53
