-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 08 月 09 日 16:03
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `session`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_session`
--

CREATE TABLE IF NOT EXISTS `tbl_session` (
  `id` char(30) NOT NULL,
  `session` text NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_session`
--

INSERT INTO `tbl_session` (`id`, `session`, `time`) VALUES
('ggg6suipa3d4rps44jh21u6v44', 'test1|s:6:"test24";test2|s:6:"test30";', 1312902849);
