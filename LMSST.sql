-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 10 Sie 2015, 10:58
-- Server version: 5.1.56-log
-- PHP Version: 5.3.28-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


--
-- Struktura tabeli dla tabeli `stck_groups`
--

CREATE TABLE IF NOT EXISTS `stck_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantityid` int(11) NOT NULL,
  `quantitycheck` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `modid` int(11) NOT NULL DEFAULT '0',
  `creationdate` int(11) NOT NULL DEFAULT '0',
  `moddate` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_manufacturers`
--

CREATE TABLE IF NOT EXISTS `stck_manufacturers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationdate` int(11) NOT NULL,
  `moddate` int(11) NOT NULL,
  `creatorid` int(11) NOT NULL,
  `modid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=255 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_products`
--

CREATE TABLE IF NOT EXISTS `stck_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturerid` int(11) NOT NULL DEFAULT '0',
  `groupid` int(11) NOT NULL DEFAULT '0',
  `taxid` int(11) NOT NULL DEFAULT '0',
  `typeid` int(11) NOT NULL DEFAULT '0',
  `quantityid` int(11) NOT NULL,
  `quantitycheck` tinyint(1) NOT NULL DEFAULT '1',
  `ean` varchar(30) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `creationdate` int(11) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `moddate` int(11) NOT NULL DEFAULT '0',
  `modid` int(11) NOT NULL DEFAULT '0',
  `comment` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `manufacturerid` (`manufacturerid`),
  KEY `groupid` (`groupid`),
  KEY `taxid` (`taxid`),
  KEY `typeid` (`typeid`),
  KEY `quantityid` (`quantityid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_quantities`
--

CREATE TABLE IF NOT EXISTS `stck_quantities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `def` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(10) NOT NULL,
  `comment` text NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `stck_quantities`
--

INSERT INTO `stck_quantities` (`id`, `def`, `name`, `comment`, `deleted`) VALUES
(1, 1, 'szt.', '', 0),
(2, 0, 'm.', '', 0),
(3, 0, 'g.', '', 0),
(4, 0, 'op.', 'Opakowanie', 0),
(5, 0, 'kpl.', 'Komplet', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_receivenotes`
--

CREATE TABLE IF NOT EXISTS `stck_receivenotes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplierid` int(11) NOT NULL,
  `number` varchar(255) NOT NULL,
  `creatorid` int(11) NOT NULL,
  `modid` int(11) NOT NULL,
  `creationdate` int(11) NOT NULL,
  `moddate` int(11) NOT NULL,
  `netvalue` decimal(9,2) NOT NULL,
  `grossvalue` decimal(9,2) NOT NULL,
  `paytype` int(11) NOT NULL,
  `datesettlement` int(11) NOT NULL,
  `datesale` int(11) NOT NULL,
  `deadline` int(11) NOT NULL,
  `paid` int(11) DEFAULT NULL,
  `comment` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `supplierid` (`supplierid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1250 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_stock`
--

CREATE TABLE IF NOT EXISTS `stck_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouseid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `supplierid` int(11) NOT NULL,
  `enterdocumentid` int(11) NOT NULL,
  `quitdocumentid` int(11) DEFAULT NULL,
  `creationdate` int(11) NOT NULL DEFAULT '0',
  `bdate` int(11) NOT NULL,
  `moddate` int(11) NOT NULL DEFAULT '0',
  `leavedate` int(11) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `modid` int(11) NOT NULL DEFAULT '0',
  `serialnumber` varchar(255) DEFAULT NULL,
  `warranty` int(11) DEFAULT NULL,
  `pricebuynet` decimal(9,2) NOT NULL DEFAULT '0.00',
  `taxid` int(11) NOT NULL,
  `pricebuygross` decimal(9,2) NOT NULL,
  `pricesell` decimal(9,2) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '1',
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `enterdocumentid` (`enterdocumentid`),
  KEY `supplierid` (`supplierid`),
  KEY `warehouseid` (`warehouseid`),
  KEY `idx1` (`pricebuynet`,`pricebuygross`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8744 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_stockassigments`
--

CREATE TABLE IF NOT EXISTS `stck_stockassigments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `stockid` int(11) NOT NULL,
  `assigmentid` int(11) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `stockid` (`stockid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17651 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_supplierassignments`
--

CREATE TABLE IF NOT EXISTS `stck_supplierassignments` (
  `IDSupplierAssignment` int(11) NOT NULL AUTO_INCREMENT,
  `IDCustomer` int(11) NOT NULL,
  `IDSupplier` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDSupplierAssignment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_types`
--

CREATE TABLE IF NOT EXISTS `stck_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `def` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `quantitycheck` tinyint(1) NOT NULL,
  `creationdate` int(11) NOT NULL DEFAULT '0',
  `moddate` int(11) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `modid` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `stck_types` (`id`, `def`, `name`, `quantitycheck`, `creationdate`, `moddate`, `creatorid`, `modid`, `deleted`) VALUES
(1, 0, 'Towar', 0, 0, 0, 0, 0, 0),
(2, 0, 'Usluga', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `stck_vpstock`
--
CREATE TABLE IF NOT EXISTS `stck_vpstock` (
`id` int(11)
,`warehouseid` int(11)
,`groupid` int(11)
,`productid` int(11)
,`supplierid` int(11)
,`enterdocumentid` int(11)
,`quitdocumentid` int(11)
,`creationdate` int(11)
,`bdate` int(11)
,`moddate` int(11)
,`leavedate` int(11)
,`creatorid` int(11)
,`modid` int(11)
,`serialnumber` varchar(255)
,`warranty` int(11)
,`pricebuynet` decimal(9,2)
,`taxid` int(11)
,`pricebuygross` decimal(9,2)
,`pricesell` decimal(9,2)
,`deleted` tinyint(4)
,`comment` text
,`pid` int(11)
,`pname` text
,`manufacturerid` int(11)
,`pcomment` text
,`pdeleted` tinyint(1)
,`gid` int(11)
,`gname` varchar(100)
,`gcomment` text
,`gdeleted` tinyint(1)
);
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stck_warehouses`
--

CREATE TABLE IF NOT EXISTS `stck_warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `comment` text,
  `def` tinyint(1) NOT NULL DEFAULT '0',
  `commerce` tinyint(1) NOT NULL DEFAULT '1',
  `creationdate` int(11) NOT NULL DEFAULT '0',
  `moddate` int(11) NOT NULL DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `modid` int(11) NOT NULL DEFAULT '0',
  `deleted` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Struktura widoku `stck_vpstock`
--
DROP TABLE IF EXISTS `stck_vpstock`;

CREATE VIEW `stck_vpstock` AS 
select 
`s`.`id` AS `id`,`s`.`warehouseid` AS `warehouseid`,`s`.`groupid` AS `groupid`,`s`.`productid` AS `productid`,
`s`.`supplierid` AS `supplierid`,`s`.`enterdocumentid` AS `enterdocumentid`,`s`.`quitdocumentid` AS `quitdocumentid`,
`s`.`creationdate` AS `creationdate`,`s`.`bdate` AS `bdate`,`s`.`moddate` AS `moddate`,`s`.`leavedate` AS `leavedate`,
`s`.`creatorid` AS `creatorid`,`s`.`modid` AS `modid`,`s`.`serialnumber` AS `serialnumber`,`s`.`warranty` AS `warranty`,
`s`.`pricebuynet` AS `pricebuynet`,`s`.`taxid` AS `taxid`,`s`.`pricebuygross` AS `pricebuygross`,
`s`.`pricesell` AS `pricesell`,`s`.`deleted` AS `deleted`,`s`.`comment` AS `comment`,
`p`.`id` AS `pid`,
`p`.`name` AS `pname`,`p`.`manufacturerid` AS `manufacturerid`,`p`.`comment` AS `pcomment`,`p`.`deleted` AS `pdeleted`,
`g`.`id` AS `gid`,`g`.`name` AS `gname`,`g`.`comment` AS `gcomment`,`g`.`deleted` AS `gdeleted` 
from (
	(
	    `stck_stock` `s` 
	    left join `stck_products` `p` on(`s`.`productid` = `p`.`id`)
	) 
	left join `stck_groups` `g` on(`p`.`id` = `g`.`id`)
    )
;




CREATE VIEW teryt_ulic AS
   SELECT st.ident AS woj, d.ident AS pow, b.ident AS gmi, b.type AS rodz_gmi,
       c.ident AS sym, s.ident AS sym_ul, s.name AS nazwa_1, s.name2 AS nazwa_2, t.name AS cecha, s.id
           FROM location_streets s
               JOIN location_street_types t ON (s.typeid = t.id)
               JOIN location_cities c ON (s.cityid = c.id)
               JOIN location_boroughs b ON (c.boroughid = b.id)
               JOIN location_districts d ON (b.districtid = d.id)
               JOIN location_states st ON (d.stateid = st.id)


--
-- Ograniczenia dla zrzutów tabel
--

ALTER TABLE `cash` ADD COLUMN `stockid` int(11) DEFAULT NULL;
ALTER TABLE `invoicecontents` ADD COLUMN `stockid` int(11) DEFAULT NULL;

--
-- Ograniczenia dla tabeli `stck_products`
--
ALTER TABLE `stck_products`
  ADD CONSTRAINT `stck_products_ibfk_1` FOREIGN KEY (`manufacturerid`) REFERENCES `stck_manufacturers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stck_products_ibfk_2` FOREIGN KEY (`groupid`) REFERENCES `stck_groups` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stck_products_ibfk_3` FOREIGN KEY (`typeid`) REFERENCES `stck_types` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stck_products_ibfk_4` FOREIGN KEY (`quantityid`) REFERENCES `stck_quantities` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `stck_receivenotes`
--
ALTER TABLE `stck_receivenotes`
  ADD CONSTRAINT `stck_receivenotes_ibfk_1` FOREIGN KEY (`supplierid`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `stck_stock`
--
ALTER TABLE `stck_stock`
  ADD CONSTRAINT `stck_stock_ibfk_1` FOREIGN KEY (`enterdocumentid`) REFERENCES `stck_receivenotes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stck_stock_ibfk_2` FOREIGN KEY (`supplierid`) REFERENCES `customers` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stck_stock_ibfk_3` FOREIGN KEY (`warehouseid`) REFERENCES `stck_warehouses` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `stck_stockassigments`
--
ALTER TABLE `stck_stockassigments`
  ADD CONSTRAINT `stck_stockassigments_ibfk_1` FOREIGN KEY (`stockid`) REFERENCES `stck_stock` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
