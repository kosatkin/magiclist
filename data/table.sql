CREATE TABLE `shopping_list` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `name` varchar(120) NOT NULL DEFAULT '',
 PRIMARY KEY (`id`),
 KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8