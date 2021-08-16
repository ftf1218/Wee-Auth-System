/*
MySQL Backup
Source Server Version: 5.6.37
Source Database: xjapp
Date: 2017-08-25 23:30:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `auth_block`
-- ----------------------------
DROP TABLE IF EXISTS `auth_block`;
CREATE TABLE `auth_block` (
  `url` varchar(150) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `db` varchar(255) NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_config`
-- ----------------------------
DROP TABLE IF EXISTS `auth_config`;
CREATE TABLE `auth_config` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `switch` int(1) NOT NULL DEFAULT '1',
  `update` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_kms`
-- ----------------------------
DROP TABLE IF EXISTS `auth_kms`;
CREATE TABLE `auth_kms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `km` varchar(255) NOT NULL,
  `zt` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `auth_log`
-- ----------------------------
DROP TABLE IF EXISTS `auth_log`;
CREATE TABLE `auth_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_pay`
-- ----------------------------
DROP TABLE IF EXISTS `auth_pay`;
CREATE TABLE `auth_pay` (
  `k` varchar(32) NOT NULL,
  `v` text,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_site`
-- ----------------------------
DROP TABLE IF EXISTS `auth_site`;
CREATE TABLE `auth_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `date` datetime NOT NULL,
  `authcode` varchar(100) DEFAULT NULL,
  `sign` varchar(20) DEFAULT NULL,
  `syskey` varchar(40) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE `auth_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `dlqq` varchar(150) NOT NULL,
  `last` datetime DEFAULT NULL,
  `dlip` varchar(15) DEFAULT NULL,
  `per_sq` int(1) NOT NULL DEFAULT '0',
  `per_db` int(1) NOT NULL DEFAULT '0',
  `active` int(1) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `auth_user` VALUES ('1','admin','123456','10000',NULL,NULL,'1','1','1');