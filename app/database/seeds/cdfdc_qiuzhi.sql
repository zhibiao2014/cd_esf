-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-01-04 07:09:16
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cdfdc_new`
--

-- --------------------------------------------------------

--
-- 表的结构 `xy_job_education`
--

CREATE TABLE IF NOT EXISTS `xy_job_education` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '学历',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `xy_job_education`
--

INSERT INTO `xy_job_education` (`id`, `name`, `sort`) VALUES
(1, '初中', 0),
(2, '高中', 0),
(3, '中专', 0),
(4, '大专', 0),
(5, '本科', 0),
(6, '硕士', 0),
(7, '博士', 0),
(8, '培训', 0),
(9, '其它', 0);

-- --------------------------------------------------------

--
-- 表的结构 `xy_job_salary`
--

CREATE TABLE IF NOT EXISTS `xy_job_salary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `xy_job_salary`
--

INSERT INTO `xy_job_salary` (`id`, `name`, `sort`) VALUES
(1, '面议', 0),
(2, '1000以下', 0),
(3, '1000-2000元', 0),
(4, '2000-3000元', 0),
(5, '3000-5000元', 0),
(6, '5000-8000元', 0),
(7, '8000-12000元', 0),
(8, '12000-20000元', 0),
(9, '20000-25000元', 0),
(10, '25000以上', 0);

-- --------------------------------------------------------

--
-- 表的结构 `xy_job_type`
--

CREATE TABLE IF NOT EXISTS `xy_job_type` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `xy_job_type`
--

INSERT INTO `xy_job_type` (`id`, `name`, `pid`, `sort`) VALUES
(1, '房产建筑类', 0, 0),
(2, '装饰设计类', 0, 0),
(3, '其他类', 0, 0),
(4, '管理类', 1, 0),
(5, '建筑类', 1, 0),
(6, '装饰类', 1, 0),
(7, '销售类', 1, 0),
(8, '其他类', 1, 0),
(9, '总(副)工程师', 4, 0),
(10, '房地产前期', 4, 0),
(11, '房地产估价师', 4, 0),
(12, '房地产开发/策划', 4, 0),
(13, '物业管理', 4, 0),
(14, '报建员\r\n', 4, 0),
(15, '招投标人员', 4, 0),
(17, '现场施工管理', 5, 0),
(18, '土建工程师', 5, 0),
(19, '质量管理员', 5, 0),
(20, '工程监理', 5, 0),
(21, '设备工程师', 5, 0),
(22, '建筑设计制图', 5, 0),
(23, '室内外墙装饰', 6, 0),
(24, '给排水', 6, 0),
(25, '电气\r\n', 6, 0),
(26, '供暖', 6, 0),
(27, '房产(销售)顾问', 7, 0),
(28, '房产经纪人', 7, 0),
(29, '室内设计', 2, 0),
(30, '园林景观设计', 2, 0),
(31, '设计师', 29, 0),
(32, '制图员', 29, 0),
(33, '设计师', 30, 0);

-- --------------------------------------------------------

--
-- 表的结构 `xy_job_welfare`
--

CREATE TABLE IF NOT EXISTS `xy_job_welfare` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '职位福利',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `xy_job_welfare`
--

INSERT INTO `xy_job_welfare` (`id`, `name`, `sort`) VALUES
(1, '五险一金', 2),
(2, '包吃', 5),
(3, '包住', 0),
(4, '周末双休', 0),
(5, '年底双薪', 0),
(6, '房补', 0),
(7, '话补', 0),
(8, '交通补助', 0),
(9, '饭补', 0),
(10, '加班补助', 1);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
