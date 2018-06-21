/*
MySQL Data Transfer
Source Host: localhost
Source Database: db_wenda
Target Host: localhost
Target Database: db_wenda
Date: 2018/6/21 23:13:31
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for admin
-- ----------------------------
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `verify` char(8) NOT NULL,
  `role_id` smallint(4) NOT NULL DEFAULT '0',
  `department` smallint(4) NOT NULL DEFAULT '0',
  `is_lock` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `authkey` char(32) NOT NULL COMMENT '登录校验码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_access
-- ----------------------------
CREATE TABLE `admin_access` (
  `id` int(10) NOT NULL,
  `role_id` mediumint(9) NOT NULL DEFAULT '0',
  `node_id` mediumint(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_login_log
-- ----------------------------
CREATE TABLE `admin_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_ip` char(15) NOT NULL,
  `login_time` int(10) NOT NULL DEFAULT '0',
  `authkey` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_node
-- ----------------------------
CREATE TABLE `admin_node` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `controller` varchar(20) NOT NULL,
  `action` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1、模块 2、方法',
  `pid` smallint(6) NOT NULL DEFAULT '0',
  `isMenu` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
CREATE TABLE `admin_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(8) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  `describe` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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
-- Table structure for category
-- ----------------------------
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` mediumint(9) NOT NULL,
  `name` varchar(50) NOT NULL,
  `describe` varchar(255) NOT NULL,
  `sort` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
INSERT INTO `admin` VALUES ('1', 'admin', 'b19e5cb27f667cd5944b4c7ea2ac76ce', 'd3e5dfd', '1', '1', '0', '0', '0a29b822a3e26a3341d4a9d5352d17bb');
INSERT INTO `admin_login_log` VALUES ('1', '1', 'admin', '127.0.0.1', '1525352840', '85d2e9bbe2d6207a9e0aeaecf3c1b821');
INSERT INTO `admin_login_log` VALUES ('2', '1', 'admin', '127.0.0.1', '1525698898', 'c389a2441440e5d0d5f2b508acc43e6f');
INSERT INTO `admin_login_log` VALUES ('3', '1', 'admin', '127.0.0.1', '1525787674', 'ab8761416620ac2d85664f03421308fa');
INSERT INTO `admin_login_log` VALUES ('4', '1', 'admin', '127.0.0.1', '1525872109', 'b52d0b1e65ca845fc821a634c03e30b7');
INSERT INTO `admin_login_log` VALUES ('5', '1', 'admin', '127.0.0.1', '1525959763', 'bc0186aca478e27a2d3d1bb38da97bcc');
INSERT INTO `admin_login_log` VALUES ('6', '1', 'admin', '127.0.0.1', '1526306635', 'e27a61b36ec80df37b509c468152c460');
INSERT INTO `admin_login_log` VALUES ('7', '1', 'admin', '127.0.0.1', '1526477944', '8422ccbe712d776fe44bbb183119648a');
INSERT INTO `admin_login_log` VALUES ('8', '1', 'admin', '127.0.0.1', '1527083739', '1d9a5be99cfcb936062e328a828a4059');
INSERT INTO `admin_login_log` VALUES ('9', '1', 'admin', '127.0.0.1', '1527170879', 'c52c81b63f11340b515c5093b6dc0c5c');
INSERT INTO `admin_login_log` VALUES ('10', '1', 'admin', '127.0.0.1', '1527514855', 'd19a27d96db11a4a7fc536ebd1308e75');
INSERT INTO `admin_login_log` VALUES ('11', '1', 'admin', '127.0.0.1', '1527775631', 'f6d198485e7c97e9b91254ed3f557ed2');
INSERT INTO `admin_login_log` VALUES ('12', '1', 'admin', '127.0.0.1', '1528120645', 'be27805cba469cf8f52036cadb5c22ba');
INSERT INTO `admin_login_log` VALUES ('13', '1', 'admin', '127.0.0.1', '1528124270', '87967b797bbbe7ce6ce40951b27c0da7');
INSERT INTO `admin_login_log` VALUES ('14', '1', 'admin', '127.0.0.1', '1528377892', 'ac97b13150436aff9f8cc7d330711f76');
INSERT INTO `admin_login_log` VALUES ('15', '1', 'admin', '127.0.0.1', '1528726564', 'a4ec4136ce6229008979063e54660c91');
INSERT INTO `admin_login_log` VALUES ('16', '1', 'admin', '127.0.0.1', '1528814551', 'a1a935f9c71b30092f9c1dd7f4f76b0b');
INSERT INTO `admin_login_log` VALUES ('17', '1', 'admin', '127.0.0.1', '1528989053', 'b7e2a70327ded10d1d86fe96027bb20c');
INSERT INTO `admin_login_log` VALUES ('18', '1', 'admin', '127.0.0.1', '1529502500', 'afbbc24c5a3c9ad4c4d375aee7367daa');
INSERT INTO `admin_login_log` VALUES ('19', '1', 'admin', '127.0.0.1', '1529590440', '0a29b822a3e26a3341d4a9d5352d17bb');
INSERT INTO `admin_node` VALUES ('1', '网站后台', 'Home', 'index', '1', '0', '1', '1');
INSERT INTO `admin_node` VALUES ('2', '系统设置', 'System', 'setting', '1', '1', '1', '1');
INSERT INTO `admin_node` VALUES ('3', '角色管理', 'Role', 'index', '1', '2', '1', '1');
INSERT INTO `admin_node` VALUES ('4', '节点管理', 'Node', 'index', '1', '2', '1', '1');
INSERT INTO `admin_node` VALUES ('5', '添加节点', 'Node', 'add', '1', '2', '0', '1');
INSERT INTO `admin_node` VALUES ('6', '问题管理', 'question', 'index', '1', '1', '1', '1');
INSERT INTO `admin_node` VALUES ('7', '问题列表', 'question', 'index', '1', '6', '1', '1');
INSERT INTO `admin_node` VALUES ('8', '问题分类', 'question', 'category', '1', '6', '1', '1');
INSERT INTO `admin_node` VALUES ('9', '用户管理', 'member', 'index', '1', '1', '1', '1');
INSERT INTO `admin_node` VALUES ('10', '用户列表', 'member', 'index', '1', '9', '1', '1');
INSERT INTO `admin_role` VALUES ('1', '0', '超级管理员', '', '1');
INSERT INTO `admin_role` VALUES ('2', '0', '问题列表', '', '1');
INSERT INTO `category` VALUES ('1', '0', '天文', '天文类问题', '0', '1');
INSERT INTO `category` VALUES ('2', '0', '历史', '历史类问题', '0', '1');
INSERT INTO `category` VALUES ('3', '0', '地理', '地理类问题', '0', '1');
