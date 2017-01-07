CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(1000) NOT NULL,
  UNIQUE KEY `id` (`id`)
);