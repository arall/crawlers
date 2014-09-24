-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.38-0ubuntu0.14.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for view carCrawler.avgCars
DROP VIEW IF EXISTS `avgCars`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `avgCars` (
	`num` BIGINT(21) NOT NULL,
	`marca` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modelo` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`year` INT(11) NULL,
	`media` DECIMAL(14,4) NULL,
	`maximo` INT(11) NULL,
	`minimo` INT(11) NULL
) ENGINE=MyISAM;


-- Dumping structure for view carCrawler.avgCars2
DROP VIEW IF EXISTS `avgCars2`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `avgCars2` (
	`num` BIGINT(21) NOT NULL,
	`marca` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modelo` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`media` DECIMAL(14,4) NULL,
	`maximo` INT(11) NULL,
	`minimo` INT(11) NULL
) ENGINE=MyISAM;


-- Dumping structure for table carCrawler.cars
DROP TABLE IF EXISTS `cars`;
CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `websiteId` varchar(100) DEFAULT NULL,
  `title` varchar(512) DEFAULT NULL,
  `desciption` text,
  `url` varchar(1024) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `marcaId` int(11) DEFAULT '0',
  `modelo` varchar(50) DEFAULT NULL,
  `modeloId` int(11) DEFAULT '0',
  `year` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `mileage` int(11) DEFAULT '0',
  `fuel` int(11) DEFAULT '0',
  `bodywork` int(11) DEFAULT '0',
  `productDate` varchar(50) DEFAULT NULL,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for view carCrawler.carsOffers
DROP VIEW IF EXISTS `carsOffers`;
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `carsOffers` (
	`marca` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`modelo` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci',
	`price` INT(11) NULL,
	`year` INT(11) NULL,
	`total` BIGINT(21) NULL,
	`media` DECIMAL(14,4) NULL,
	`dif` DECIMAL(15,4) NULL,
	`url` VARCHAR(1024) NULL COLLATE 'latin1_swedish_ci'
) ENGINE=MyISAM;


-- Dumping structure for table carCrawler.houses
DROP TABLE IF EXISTS `houses`;
CREATE TABLE IF NOT EXISTS `houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `websiteId` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `zone` varchar(200) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `address` varchar(512) DEFAULT NULL,
  `lat` varchar(512) DEFAULT NULL,
  `lon` varchar(512) DEFAULT NULL,
  `m2` int(11) DEFAULT NULL,
  `parking` tinyint(4) DEFAULT NULL,
  `furnished` tinyint(4) DEFAULT NULL,
  `features` text,
  `year` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table carCrawler.marcas
DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for table carCrawler.modelos
DROP TABLE IF EXISTS `modelos`;
CREATE TABLE IF NOT EXISTS `modelos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marcaId` int(11) DEFAULT '0',
  `nombre` varchar(50) DEFAULT NULL,
  `dateInsert` datetime DEFAULT NULL,
  `dateUpdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.


-- Dumping structure for view carCrawler.avgCars
DROP VIEW IF EXISTS `avgCars`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `avgCars`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `avgCars` AS select count(`cars`.`id`) AS `num`,`cars`.`marca` AS `marca`,`cars`.`modelo` AS `modelo`,`cars`.`year` AS `year`,avg(`cars`.`price`) AS `media`,max(`cars`.`price`) AS `maximo`,min(`cars`.`price`) AS `minimo` from `cars` group by `cars`.`marcaId`,`cars`.`modeloId`,`cars`.`year`;


-- Dumping structure for view carCrawler.avgCars2
DROP VIEW IF EXISTS `avgCars2`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `avgCars2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `avgCars2` AS select count(`cars`.`id`) AS `num`,`cars`.`marca` AS `marca`,`cars`.`modelo` AS `modelo`,avg(`cars`.`price`) AS `media`,max(`cars`.`price`) AS `maximo`,min(`cars`.`price`) AS `minimo` from `cars` group by `cars`.`marcaId`,`cars`.`modeloId`;


-- Dumping structure for view carCrawler.carsOffers
DROP VIEW IF EXISTS `carsOffers`;
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `carsOffers`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `carsOffers` AS select `c`.`marca` AS `marca`,`c`.`modelo` AS `modelo`,`c`.`price` AS `price`,`c`.`year` AS `year`,(select `a`.`num` from `avgCars2` `a` where ((`a`.`marca` = `c`.`marca`) and (`a`.`modelo` = `c`.`modelo`))) AS `total`,(select `a`.`media` from `avgCars2` `a` where ((`a`.`marca` = `c`.`marca`) and (`a`.`modelo` = `c`.`modelo`))) AS `media`,((select `a`.`media` from `avgCars2` `a` where ((`a`.`marca` = `c`.`marca`) and (`a`.`modelo` = `c`.`modelo`))) - `c`.`price`) AS `dif`,`c`.`url` AS `url` from `cars` `c` order by ((select `a`.`media` from `avgCars2` `a` where ((`a`.`marca` = `c`.`marca`) and (`a`.`modelo` = `c`.`modelo`))) - `c`.`price`) desc;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
