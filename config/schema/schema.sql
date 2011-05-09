#Logs sql generated on: 2011-05-09 05:26:41 : 1304918801

DROP TABLE IF EXISTS `logs`;


CREATE TABLE `logs` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) DEFAULT NULL,
	`model_id` int(11) DEFAULT NULL,
	`version_id` int(11) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`model` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`action` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`change` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`request` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,	PRIMARY KEY  (`id`),
	UNIQUE KEY `version_id` (`version_id`),
	KEY `model_id` (`model_id`)
)	DEFAULT CHARSET=utf8, COLLATE=utf8_general_ci, ENGINE=InnoDB;

