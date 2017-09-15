# Host: 127.0.0.1  (Version: 5.5.40)
# Date: 2016-03-18 00:23:41
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "onethink_good_property"
#

DROP TABLE IF EXISTS `onethink_good_property`;
CREATE TABLE `onethink_good_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "onethink_good_property"
#

/*!40000 ALTER TABLE `onethink_good_property` DISABLE KEYS */;
INSERT INTO `onethink_good_property` VALUES (1,'颜色'),(2,'尺寸'),(3,'种类');
/*!40000 ALTER TABLE `onethink_good_property` ENABLE KEYS */;
