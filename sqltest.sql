/*
SQLyog 企业版 - MySQL GUI v8.14 
MySQL - 5.0.45-community-nt : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `test`;

/*Table structure for table `phpdiy_auth_rbac` */

DROP TABLE IF EXISTS `phpdiy_auth_rbac`;

CREATE TABLE `phpdiy_auth_rbac` (
  `auth_id` int(10) NOT NULL auto_increment COMMENT '授权标识',
  `auth_role` int(10) NOT NULL COMMENT '授权角色',
  `auth_permissions` int(10) NOT NULL COMMENT '授权操作',
  `auth_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '授权时间',
  `auth_comment` varchar(100) default NULL COMMENT '授权备注',
  UNIQUE KEY `auth_id` (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='角色许可表';

/*Data for the table `phpdiy_auth_rbac` */

insert  into `phpdiy_auth_rbac`(`auth_id`,`auth_role`,`auth_permissions`,`auth_gtime`,`auth_comment`) values (1,3,1,'2011-08-15 23:55:00','一般用户拒绝访问后台入口'),(2,3,2,'2011-08-23 00:15:09','一般用户拒绝访问后台页面'),(3,1,3,'2011-08-23 00:37:39',NULL),(4,2,4,'2011-08-23 00:37:45',NULL),(5,4,5,'2011-08-23 23:54:43',NULL);

/*Table structure for table `phpdiy_objects_rbac` */

DROP TABLE IF EXISTS `phpdiy_objects_rbac`;

CREATE TABLE `phpdiy_objects_rbac` (
  `object_id` int(10) NOT NULL auto_increment COMMENT '对象id',
  `object_name` char(30) character set latin1 NOT NULL default '' COMMENT '对象名称',
  `object_type` int(1) NOT NULL COMMENT '对象类型[module,class,func]',
  `object_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '对象创建时间',
  `object_comment` varchar(100) NOT NULL default '' COMMENT '对象说明',
  `object_domains` int(1) NOT NULL COMMENT '对象领域[website,api]',
  UNIQUE KEY `object_id` (`object_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='对象表';

/*Data for the table `phpdiy_objects_rbac` */

insert  into `phpdiy_objects_rbac`(`object_id`,`object_name`,`object_type`,`object_gtime`,`object_comment`,`object_domains`) values (1,'admin',1,'2011-08-15 23:36:38','后台管理入口',1),(2,'home',1,'2011-08-15 23:40:03','前台访问入口',1),(3,'UserController',2,'2011-08-15 23:40:25','后台用户页面',1),(4,'ManageController',2,'2011-08-22 23:19:41','后台用户页面',1);

/*Table structure for table `phpdiy_operations_rbac` */

DROP TABLE IF EXISTS `phpdiy_operations_rbac`;

CREATE TABLE `phpdiy_operations_rbac` (
  `oper_id` int(10) NOT NULL auto_increment COMMENT '操作id',
  `oper_name` char(10) NOT NULL COMMENT '操作权限',
  `oper_comment` varchar(100) NOT NULL default '' COMMENT '操作备注',
  `oper_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '操作创建时间',
  UNIQUE KEY `oper_id` (`oper_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='操作表';

/*Data for the table `phpdiy_operations_rbac` */

insert  into `phpdiy_operations_rbac`(`oper_id`,`oper_name`,`oper_comment`,`oper_gtime`) values (1,'拒绝','拒绝','2011-08-15 23:41:45'),(2,'允许','允许','2011-08-15 23:41:52');

/*Table structure for table `phpdiy_permissions_rbac` */

DROP TABLE IF EXISTS `phpdiy_permissions_rbac`;

CREATE TABLE `phpdiy_permissions_rbac` (
  `per_id` int(10) NOT NULL auto_increment COMMENT '许可标识',
  `per_name` varchar(100) NOT NULL default '' COMMENT '许可名称',
  `per_object` int(10) NOT NULL COMMENT '许可对象',
  `per_operations` int(10) NOT NULL COMMENT '许可操作',
  `per_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '许可创建时间',
  UNIQUE KEY `per_id` (`per_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='许可表';

/*Data for the table `phpdiy_permissions_rbac` */

insert  into `phpdiy_permissions_rbac`(`per_id`,`per_name`,`per_object`,`per_operations`,`per_gtime`) values (1,'拒绝访问后台管理入口',1,1,'2011-08-15 23:44:52'),(2,'拒绝访问后台页面',4,1,'2011-08-23 00:16:10'),(3,'拒绝访问后台页面',2,2,'2011-08-23 00:38:14'),(4,'拒绝访问后台页面',3,2,'2011-08-23 00:38:14'),(5,'拒绝访问后台页面',1,1,'2011-08-23 23:56:44');

/*Table structure for table `phpdiy_roles_rbac` */

DROP TABLE IF EXISTS `phpdiy_roles_rbac`;

CREATE TABLE `phpdiy_roles_rbac` (
  `role_id` int(10) NOT NULL auto_increment COMMENT '角色标识',
  `role_name` char(30) character set latin1 NOT NULL default '' COMMENT '角色名称',
  `role_base` int(11) NOT NULL COMMENT '角色基数',
  `role_off` int(1) NOT NULL COMMENT '角色是否开启',
  `role_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT '角色创建时间',
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='角色表';

/*Data for the table `phpdiy_roles_rbac` */

insert  into `phpdiy_roles_rbac`(`role_id`,`role_name`,`role_base`,`role_off`,`role_gtime`) values (1,'admin',1,1,'2011-08-15 22:41:26'),(2,'vip1',100000,1,'2011-08-15 22:41:50'),(3,'user',2147483647,1,'2011-08-15 22:44:55'),(4,'anonymity',2147483647,1,'2011-08-23 23:28:05');

/*Table structure for table `phpdiy_users_rbac` */

DROP TABLE IF EXISTS `phpdiy_users_rbac`;

CREATE TABLE `phpdiy_users_rbac` (
  `id` int(11) NOT NULL auto_increment,
  `user_name` char(18) NOT NULL,
  `user_pass` char(32) NOT NULL default '',
  `user_pass_random` char(5) NOT NULL,
  `user_gtime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `user_role` int(2) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户记录表';

/*Data for the table `phpdiy_users_rbac` */

insert  into `phpdiy_users_rbac`(`id`,`user_name`,`user_pass`,`user_pass_random`,`user_gtime`,`user_role`) values (1,'phpdiyuser','9380729122029f4ef78b5432ec390abb','dsa23','2011-08-22 22:46:58',3),(2,'phpdiyadmin','123456','12dsa','2011-08-15 22:47:57',1),(3,'phpdiyvip1','123456','2a2a2','2011-08-15 22:48:28',2);

/*Table structure for table `test` */

DROP TABLE IF EXISTS `test`;

CREATE TABLE `test` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `test` */

insert  into `test`(`id`,`name`) values (1,'cwh'),(2,'cwh'),(3,'Fredo'),(4,'Sonny'),(5,'lau'),(6,'Fredo1'),(7,'Sonny1'),(8,'lau1'),(9,'cccc'),(10,'dsa'),(11,'cccc'),(12,'cccc'),(13,'cccc'),(14,'cccc');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
