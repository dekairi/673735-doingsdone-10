# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.23)
# Database: doingsdone
# Generation Time: 2019-09-08 2:03:00 PM +0000
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

INSERT INTO `projects` (`title`, `user`)
VALUES
	('Входящие',1),
	('Учеба',2),
	('Работа',1),
	('Домашние дела',1),
	('Авто',2);

# Dump of table task
# ------------------------------------------------------------

INSERT INTO `task` (`date_created`, `status`, `title`, `file`, `date_todo`, `project`, `user`)
VALUES
	('2017-08-19',0,'Собеседование в IT компании',NULL,'2019-12-01',3,1),
	('2018-08-01',0,'Выполнить тестовое задание',NULL,'2019-08-24',3,1),
	('2018-08-01',1,'Сделать задание первого раздела',NULL,'2019-12-16',2,2),
	('2019-08-01',0,'Встреча с другом',NULL,'2019-12-22',1,1),
	('2019-08-02',1,'Купить корм для кота\n',NULL,NULL,4,1),
	('2019-08-04',0,'Заказать пиццу и суши',NULL,NULL,4,1);

# Dump of table user
# ------------------------------------------------------------

INSERT INTO `user` (`register_date`, `email`, `name`, `password`)
VALUES
	('2017-08-04 00:00:00','123@123.123','Ирина','5677'),
	('2019-10-14 00:00:00','767@474.484','Дмитрий','667к');


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
