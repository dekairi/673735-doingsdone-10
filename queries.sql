# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.23)
# Database: doingsdone
# Generation Time: 2019-08-21 2:17:00 PM +0000
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

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;

INSERT INTO `projects` (`id`, `title`, `user`)
VALUES
	(0,'Входящие',0),
	(1,'Учеба',1),
	(2,'Работа',0),
	(3,'Домашние дела',0),
	(4,'Авто',1);

/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task
# ------------------------------------------------------------

LOCK TABLES `task` WRITE;
/*!40000 ALTER TABLE `task` DISABLE KEYS */;

INSERT INTO `task` (`id`, `date_created`, `status`, `title`, `file`, `date_todo`, `project`, `user`)
VALUES
	(0,'2017-08-19 00:00:00',0,'Собеседование в IT компании',NULL,'2019-12-01 00:00:00',2,0),
	(1,'2018-08-01 00:00:00',0,'Выполнить тестовое задание',NULL,'2019-08-24 00:00:00',2,0),
	(2,'2018-08-01 00:00:00',1,'Сделать задание первого раздела',NULL,'2019-12-16 00:00:00',1,1),
	(3,'2019-08-01 00:00:00',0,'Встреча с другом',NULL,'2019-12-22 00:00:00',0,0),
	(4,'2019-08-02 00:00:00',0,'Купить корм для кота\n',NULL,NULL,3,0),
	(5,'2019-08-04 00:00:00',0,'Заказать пиццу',NULL,NULL,3,0);

/*!40000 ALTER TABLE `task` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `register_date`, `email`, `name`, `password`)
VALUES
	(0,'2016-06-19 00:00:00','someemail@somedomain.com','Ирина','1234'),
	(1,'2017-08-04 00:00:00','123@123.123','Дмитрий','5677');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

# Get projects of user 0
SELECT * FROM `projects` WHERE `user` = '0' LIMIT 0,1000;

# Get list of task for project 3
SELECT * FROM `task` WHERE `project` = '3' LIMIT 0,1000;

# Mark task as done
UPDATE `task` SET `status` = '1' WHERE `id` = '4';

# Update task title
UPDATE `task` SET `title` = 'Заказать пиццу и суши' WHERE `id` = '5';


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
