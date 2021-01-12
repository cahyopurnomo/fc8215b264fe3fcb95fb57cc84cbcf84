# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.5.6-MariaDB-1:10.5.6+maria~focal)
# Database: world_x
# Generation Time: 2021-01-09 14:49:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


/*!40000 DROP DATABASE IF EXISTS `world_x`*/;

CREATE DATABASE `world_x` DEFAULT CHARACTER SET utf8mb4;

USE `world_x`;

# Dump of table mail_sent
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mail_sent`;

CREATE TABLE `mail_sent` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `_to` varchar(200) NOT NULL,
  `_subject` varchar(200) NOT NULL DEFAULT '',
  `_from` varchar(200) NOT NULL,
  `_content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `mail_sent` WRITE;
/*!40000 ALTER TABLE `mail_sent` DISABLE KEYS */;

INSERT INTO `mail_sent` (`id`, `_to`, `_subject`, `_from`, `_content`)
VALUES
	(1,'guest@yahoo.com','testing email','c.purnomo@gmail.com','konten email'),
	(2,'guest@yahoo.com','testing email','c.purnomo@gmail.com','konten email'),
	(3,'guest@yahoo.com','testing email','c.purnomo@gmail.com','konten email');

/*!40000 ALTER TABLE `mail_sent` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
