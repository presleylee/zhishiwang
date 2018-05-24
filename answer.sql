/*
MySQL Data Transfer
Source Host: localhost
Source Database: db_wenda
Target Host: localhost
Target Database: db_wenda
Date: 2018/5/24 22:31:32
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for answer
-- ----------------------------
CREATE TABLE `answer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `qid` mediumint(9) NOT NULL DEFAULT '0',
  `answer` varchar(255) NOT NULL,
  `is_right` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for question
-- ----------------------------
CREATE TABLE `question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `category1` smallint(6) NOT NULL DEFAULT '0',
  `category2` smallint(6) NOT NULL DEFAULT '0',
  `category3` smallint(6) NOT NULL DEFAULT '0',
  `right_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `right` mediumint(9) NOT NULL DEFAULT '0',
  `error` mediumint(9) NOT NULL DEFAULT '0',
  `total` mediumint(9) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
