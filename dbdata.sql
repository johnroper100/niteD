CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL,
  `account_type` varchar(30) NOT NULL,
  UNIQUE KEY `email` (`email`)
);

INSERT INTO `users` (`id`, `name`, `email`, `password`, `account_type`) VALUES (1, 'Administrator', 'admin@admin.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'admin');

CREATE TABLE IF NOT EXISTS `tasks` (
  `task_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `task_name` varchar(50) NOT NULL,
  `task_desc` text NOT NULL,
  `task_state` varchar(20) NOT NULL,
  `task_image` text NOT NULL,
  UNIQUE KEY `task_id` (`task_id`)
);

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `comment_text` text NOT NULL,
  `task_id` int NOT NULL,
  UNIQUE KEY `comment_id` (`comment_id`)
);