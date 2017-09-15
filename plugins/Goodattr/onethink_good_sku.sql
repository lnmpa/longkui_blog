# Host: 127.0.0.1  (Version: 5.5.40)
# Date: 2016-03-18 00:23:53
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "onethink_good_sku"
#

DROP TABLE IF EXISTS `onethink_good_sku`;
CREATE TABLE `onethink_good_sku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_id` varchar(255) DEFAULT NULL,
  `properies` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;

#
# Data for table "onethink_good_sku"
#

/*!40000 ALTER TABLE `onethink_good_sku` DISABLE KEYS */;
INSERT INTO `onethink_good_sku` VALUES (185,'14582310401','1:18|2:4|3:4','99','99'),(186,'14582310401','1:18|2:3|3:4','100','100'),(190,'14582312751','1:7|2:17|3:4','9999','100'),(191,'14582312751','1:7|2:18|3:4','50','100');
/*!40000 ALTER TABLE `onethink_good_sku` ENABLE KEYS */;
