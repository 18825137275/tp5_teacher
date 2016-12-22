/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-12-22 17:43:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yunzhi_course
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_course`;
CREATE TABLE `yunzhi_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunzhi_course
-- ----------------------------
INSERT INTO `yunzhi_course` VALUES ('1', 'thinkphp5入门实例', '0', '0');
INSERT INTO `yunzhi_course` VALUES ('2', 'angularjs入门实例', '0', '0');

-- ----------------------------
-- Table structure for yunzhi_klass
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_klass`;
CREATE TABLE `yunzhi_klass` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '名称',
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '教师ID',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunzhi_klass
-- ----------------------------
INSERT INTO `yunzhi_klass` VALUES ('1', '实验1班', '1', '0', '0');
INSERT INTO `yunzhi_klass` VALUES ('2', '实验2班', '2', '0', '0');
INSERT INTO `yunzhi_klass` VALUES ('3', '实验3班', '9', '0', '1482218889');
INSERT INTO `yunzhi_klass` VALUES ('5', '电子2班', '9', '1482204974', '1482204974');
INSERT INTO `yunzhi_klass` VALUES ('6', '营销2', '2', '1482205559', '1482205559');
INSERT INTO `yunzhi_klass` VALUES ('7', '二小', '12', '1482212412', '1482212412');
INSERT INTO `yunzhi_klass` VALUES ('8', '行政3班', '1', '1482212444', '1482212444');
INSERT INTO `yunzhi_klass` VALUES ('9', '行政5班', '13', '1482212567', '1482212567');

-- ----------------------------
-- Table structure for yunzhi_klass_course
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_klass_course`;
CREATE TABLE `yunzhi_klass_course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `klass_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunzhi_klass_course
-- ----------------------------
INSERT INTO `yunzhi_klass_course` VALUES ('2', '1', '2', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('4', '2', '2', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('6', '4', '2', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('8', '6', '2', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('9', '1', '3', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('10', '2', '3', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('11', '1', '4', '0', '0');
INSERT INTO `yunzhi_klass_course` VALUES ('12', '2', '4', '0', '0');

-- ----------------------------
-- Table structure for yunzhi_student
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_student`;
CREATE TABLE `yunzhi_student` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '姓名',
  `num` varchar(40) NOT NULL DEFAULT '',
  `sex` tinyint(2) NOT NULL DEFAULT '0',
  `klass_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(40) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunzhi_student
-- ----------------------------
INSERT INTO `yunzhi_student` VALUES ('1', '徐琳杰', '111', '0', '1', 'xulinjie@yunzhiclub.com', '1482212567', '0');
INSERT INTO `yunzhi_student` VALUES ('2', '魏静云', '112', '1', '2', 'weijingyun@yunzhiclub.com', '0', '0');
INSERT INTO `yunzhi_student` VALUES ('3', '刘茜', '113', '0', '2', 'liuxi@yunzhiclub.com', '0', '0');
INSERT INTO `yunzhi_student` VALUES ('4', '李甜', '114', '1', '1', 'litian@yunzhiclub.com', '0', '0');
INSERT INTO `yunzhi_student` VALUES ('5', '李翠彬', '115', '1', '3', 'licuibin@yunzhiclub.com', '0', '0');
INSERT INTO `yunzhi_student` VALUES ('6', '孔瑞平', '115', '0', '5', 'kongruiping@yunzhiclub.com', '0', '0');
INSERT INTO `yunzhi_student` VALUES ('7', '小二', '888', '0', '7', 'sdfdsf@qq.com', '1482303110', '1482303110');

-- ----------------------------
-- Table structure for yunzhi_teacher
-- ----------------------------
DROP TABLE IF EXISTS `yunzhi_teacher`;
CREATE TABLE `yunzhi_teacher` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '' COMMENT '姓名',
  `password` varchar(40) NOT NULL DEFAULT '',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0男，1女',
  `username` varchar(16) NOT NULL COMMENT '用户名',
  `email` varchar(30) DEFAULT '' COMMENT '邮箱',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunzhi_teacher
-- ----------------------------
INSERT INTO `yunzhi_teacher` VALUES ('1', '张三', 'aad612c18bfcb55e90e6af7da79bd34ff8a807d0', '0', 'zhangsan', 'zhangsan@mail.com', '123123', '123213');
INSERT INTO `yunzhi_teacher` VALUES ('2', '李四', '4b5a6e25532ec0374f7e21de3c5e773516936d8f', '1', 'lisi', 'lisi@yunzhi.club', '123213', '1232');
INSERT INTO `yunzhi_teacher` VALUES ('10', 'ccccc', 'a155efbb5f9700691dae26b55dbe150073c78252', '1', 'cccccc', 'sdf@qq.com', '1481539913', '1481539913');
INSERT INTO `yunzhi_teacher` VALUES ('9', 'bbbbb', '', '0', 'bbbbbb', 'sdfdsf@qq.com', '1481537334', '1481539078');
INSERT INTO `yunzhi_teacher` VALUES ('12', 'sses', '', '0', 'aacd', '', '1481543921', '1481543921');
INSERT INTO `yunzhi_teacher` VALUES ('13', 'sdfd', '', '0', 'sdfdsf', '', '1481544194', '1481544194');
SET FOREIGN_KEY_CHECKS=1;
