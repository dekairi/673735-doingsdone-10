# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.23)
# Database: doingsdone
# Generation Time: 2019-08-26 11:15:49 AM +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table projects
# ------------------------------------------------------------

CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(255) NOT NULL DEFAULT '',
  `user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `user` (`user`),
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



# Dump of table task
# ------------------------------------------------------------

CREATE TABLE `task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `file` text,
  `date_todo` datetime DEFAULT NULL,
  `project` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`(255)),
  KEY `category` (`project`),
  KEY `author` (`user`),
  CONSTRAINT `author` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  CONSTRAINT `category` FOREIGN KEY (`project`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `register_date` datetime NOT NULL,
  `email` char(128) NOT NULL DEFAULT '',
  `name` char(128) NOT NULL DEFAULT '',
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
