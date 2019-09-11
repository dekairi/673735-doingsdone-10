CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` char(255) NOT NULL DEFAULT '',
  `user` int(11) unsigned NOT NULL,
  KEY `title` (`title`),
  KEY `user` (`user`),
  CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`id`)
);

CREATE TABLE `task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `date_created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `file` text,
  `date_todo` datetime DEFAULT NULL,
  `project` int(11) unsigned NOT NULL,
  `user` int(11) unsigned NOT NULL,
  KEY `title` (`title`(255)),
  KEY `category` (`project`),
  KEY `author` (`user`),
  CONSTRAINT `author` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  CONSTRAINT `category` FOREIGN KEY (`project`) REFERENCES `projects` (`id`)
);


CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `register_date` datetime NOT NULL,
  `email` char(128) NOT NULL DEFAULT '',
  `name` char(128) NOT NULL DEFAULT '',
  `password` text NOT NULL
);
