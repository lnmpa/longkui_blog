# Host: 127.0.0.1  (Version: 5.5.40)
# Date: 2016-03-18 00:23:00
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "onethink_good_attr"
#

DROP TABLE IF EXISTS `onethink_good_attr`;
CREATE TABLE `onethink_good_attr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_id` varchar(11) DEFAULT '0',
  `property` varchar(255) DEFAULT NULL,
  `property_value` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133 DEFAULT CHARSET=utf8;

#
# Data for table "onethink_good_attr"
#

/*!40000 ALTER TABLE `onethink_good_attr` DISABLE KEYS */;
INSERT INTO `onethink_good_attr` VALUES (120,'14582310401','1','18',0),(121,'14582310401','2','4',0),(122,'14582310401','2','3',0),(123,'14582310401','3','4',0),(129,'14582312751','1','7',0),(130,'14582312751','2','17',0),(131,'14582312751','2','18',0),(132,'14582312751','3','4',0);
/*!40000 ALTER TABLE `onethink_good_attr` ENABLE KEYS */;
