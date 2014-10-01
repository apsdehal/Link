CREATE TABLE IF NOT EXISTS `posts` (
	`id` int(11) NOT NULL AUTO_INCREMENT ,
	`title` varchar(350) NOT NULL,
	`content` text NOT NULL,
	PRIMARY KEY (`id`)
)