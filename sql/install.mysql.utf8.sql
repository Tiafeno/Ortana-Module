CREATE TABLE IF NOT EXISTS `ortana_clients` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`client` text NOT NULL,
	`contact` varchar(25) NOT NULL,

  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `ortana_clients` (`client`, `contact`) VALUES ('Hello World', 'xml@ortana.mg');
INSERT INTO `ortana_clients` (`client`, `contact`) VALUES ('Hola Mundo', 'example@ortana.mg');