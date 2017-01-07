CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL,
  UNIQUE KEY `email` (`email`)
);

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `image` varchar(1000) NOT NULL,
  UNIQUE KEY `id` (`id`)
);