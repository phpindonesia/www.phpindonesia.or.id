/*
Navicat MySQL Data Transfer

Source Server         : Xampp 1.7.3
Source Server Version : 50141
Source Host           : localhost:3306
Source Database       : phpindonesia

Target Server Type    : MYSQL
Target Server Version : 50141
File Encoding         : 65001

Date: 2015-07-10 20:35:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for komunitas
-- ----------------------------
DROP TABLE IF EXISTS `komunitas`;
CREATE TABLE `komunitas` (
  `id_komunitas` int(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `alamat` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `facebook` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `twitter` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `skill` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `lat` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `lng` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `status` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_komunitas`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
