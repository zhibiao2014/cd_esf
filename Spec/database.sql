-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-11-12 08:33:54
-- 服务器版本： 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cdfdc_usercenter`
--

-- --------------------------------------------------------

--
-- 表的结构 `sl_area`
--

CREATE TABLE IF NOT EXISTS `sl_area` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `pid` smallint(6) NOT NULL DEFAULT '0' COMMENT '父ID',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 COMMENT '区域表';

-- --------------------------------------------------------

--
-- 表的结构 `sl_attachment`
--

CREATE TABLE IF NOT EXISTS `sl_attachment` (
`id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL COMMENT '所属栏目',
  `title` varchar(255) NOT NULL COMMENT '自定义标题',
  `description` varchar(255) NOT NULL COMMENT '自定义描述',
  `path` varchar(255) NOT NULL COMMENT '附件路径',
  `name` varchar(255) NOT NULL COMMENT '附件本身名字',
  `size` int(10) NOT NULL COMMENT '附件大小',
  `ext` char(10) NOT NULL COMMENT '附件扩展名',
  `user_id` int(11) NOT NULL COMMENT '上传用户',
  `upload_ip` char(15) NOT NULL COMMENT '上传IP',
  `upload_time` int(10) NOT NULL COMMENT '上传时间',
  `compression_image` varchar(255) NOT NULL,
  `sort` smallint(6) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `width` smallint(6) DEFAULT NULL,
  `height` smallint(6) DEFAULT NULL,
  `compression_url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COMMENT '附件表';

-- --------------------------------------------------------

--
-- 表的结构 `sl_decoration`
--

CREATE TABLE IF NOT EXISTS `sl_decoration` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 COMMENT '装修表';

-- --------------------------------------------------------

--
-- 表的结构 `sl_direction`
--

CREATE TABLE IF NOT EXISTS `sl_direction` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 COMMENT '朝向表';

-- --------------------------------------------------------

--
-- 表的结构 `sl_house_supporting`
--

CREATE TABLE IF NOT EXISTS `sl_house_supporting` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0' COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 COMMENT '房屋配套表';

-- --------------------------------------------------------

--
-- 表的结构 `sl_laravel_sessions`
--

CREATE TABLE IF NOT EXISTS `sl_laravel_sessions` (
  `id` varchar(255) NOT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sl_migrations`
--

CREATE TABLE IF NOT EXISTS `sl_migrations` (
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sl_office`
--

CREATE TABLE IF NOT EXISTS `sl_office` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '单价',
  `floor` varchar(255) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `type_id` smallint(6) DEFAULT NULL COMMENT '类型ID',
  `validity` smallint(6) DEFAULT NULL COMMENT '有效期',
  `property_corporation` varchar(255) NOT NULL COMMENT '物业公司',
  `property_costs` varchar(255) NOT NULL COMMENT '物业费',
  `construct_year` smallint(6) NOT NULL COMMENT '建筑年代',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `traffic` text NOT NULL COMMENT '房源描述',
  `around` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 COMMENT '写字楼';

-- --------------------------------------------------------

--
-- 表的结构 `sl_pay_method`
--

CREATE TABLE IF NOT EXISTS `sl_pay_method` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `belong` tinyint(2) NOT NULL DEFAULT '0' COMMENT '(0:所有, 1:住宅出租，2:商铺出租，3:写字楼出租，4:别墅出租)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_rent`
--

CREATE TABLE IF NOT EXISTS `sl_rent` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `rent_method_id` smallint(6) NOT NULL COMMENT '租赁方式id',
  `room_structure` varchar(255) NOT NULL COMMENT '户型；存储json格式的数据，如：json_encode( array( ‘room’ => 1, ‘hall’ => 1, ‘bathroom’ => 1 ) )',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '租金',
  `pay_method_id` smallint(6) NOT NULL COMMENT '支付方式',
  `floor` varchar(255) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `house_number` varchar(255) NOT NULL COMMENT '楼栋号； 存储json格式的数据，如：json_encode( array( ‘floor’ => 1, ‘unit’ => 1, ‘room’ => 1 ) )',
  `direction_id` smallint(6) DEFAULT NULL COMMENT '朝向ID',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_rent_method`
--

CREATE TABLE IF NOT EXISTS `sl_rent_method` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `belong` tinyint(2) NOT NULL DEFAULT '0' COMMENT '(0:所有, 1:住宅出租，2:商铺出租，3:写字楼出租，4:别墅出租)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_rent_office`
--

CREATE TABLE IF NOT EXISTS `sl_rent_office` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `rent_method_id` varchar(255) NOT NULL COMMENT '租赁方式id',
  `type_id` smallint(6) NOT NULL,
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '租金',
  `validity` smallint(6) NOT NULL COMMENT '有效期',
  `pay_method_id` float(8,2) NOT NULL COMMENT '支付方式',
  `is_include_property_costs` tinyint(1) DEFAULT '1' COMMENT '是否包含物业费',
  `property_corporation` varchar(255) NOT NULL COMMENT '物业公司',
  `property_costs` varchar(255) NOT NULL COMMENT '物业费',
  `floor` varchar(255) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_rent_shop`
--

CREATE TABLE IF NOT EXISTS `sl_rent_shop` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `rent_type` tinyint(1) DEFAULT '0' COMMENT '0:出租，1转让',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `type_id` smallint(6) DEFAULT NULL COMMENT '类型ID',
  `shop_face_type_id` smallint(6) DEFAULT NULL COMMENT '铺面类型ID',
  `shop_status` smallint(6) DEFAULT NULL COMMENT '当前状态，1:营业中，2:闲置中，3:新铺',
  `shop_manager_type` varchar(255) NOT NULL COMMENT '关联经营类别表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '租金',
  `price_unit` tinyint(1) NOT NULL DEFAULT '0',
  `pay_method_id` float(8,2) NOT NULL COMMENT '支付方式',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `validity` smallint(6) DEFAULT NULL COMMENT '有效期',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商铺出租' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_rent_villas`
--

CREATE TABLE IF NOT EXISTS `sl_rent_villas` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `rent_method_id` varchar(255) NOT NULL COMMENT '租赁方式id',
  `room_structure` varchar(255) NOT NULL COMMENT '户型；存储json格式的数据，如：json_encode( array( ‘room’ => 1, ‘hall’ => 1, ‘bathroom’ => 1 ) )',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '租金',
  `pay_method_id` float(8,2) NOT NULL COMMENT '支付方式',
  `floor` smallint(6) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `house_number` varchar(255) NOT NULL COMMENT '楼栋号； 存储json格式的数据，如：json_encode( array( ‘floor’ => 1, ‘unit’ => 1, ‘room’ => 1 ) )',
  `direction_id` smallint(6) DEFAULT NULL COMMENT '朝向ID',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_second_hand_housing`
--

CREATE TABLE IF NOT EXISTS `sl_second_hand_housing` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `room_structure` varchar(255) NOT NULL COMMENT '户型；存储json格式的数据，如：json_encode( array( ‘room’ => 1, ‘hall’ => 1, ‘bathroom’ => 1 ) )',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '售价',
  `floor` varchar(255) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `house_number` varchar(255) NOT NULL COMMENT '楼栋号； 存储json格式的数据，如：json_encode( array( ‘floor’ => 1, ‘unit’ => 1, ‘room’ => 1 ) )',
  `direction_id` smallint(6) DEFAULT NULL COMMENT '朝向ID',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `outdoor_images` text NOT NULL COMMENT '外景图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `house_struct_images` text NOT NULL COMMENT '户型图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_shop`
--

CREATE TABLE IF NOT EXISTS `sl_shop` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `construct_year` smallint(6) NOT NULL COMMENT '建筑年代',
  `price` float(8,2) NOT NULL COMMENT '单价',
  `type_id` smallint(6) DEFAULT NULL COMMENT '商铺类型ID',
  `shop_face_type_id` smallint(6) DEFAULT NULL COMMENT '铺面类型ID',
  `shop_manager_type` varchar(255) NOT NULL COMMENT '关联经营类别表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `validity` smallint(6) DEFAULT NULL COMMENT '有效期',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `traffic` text NOT NULL COMMENT '交通状况',
  `around` text NOT NULL COMMENT '周边配套',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_shop_face_type`
--

CREATE TABLE IF NOT EXISTS `sl_shop_face_type` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_shop_manager_type`
--

CREATE TABLE IF NOT EXISTS `sl_shop_manager_type` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_tag`
--

CREATE TABLE IF NOT EXISTS `sl_tag` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_type`
--

CREATE TABLE IF NOT EXISTS `sl_type` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_villas`
--

CREATE TABLE IF NOT EXISTS `sl_villas` (
`id` int(10) unsigned NOT NULL,
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `community_name` varchar(255) NOT NULL COMMENT '小区名字',
  `community_id` int(11) DEFAULT NULL COMMENT '小区ID；如果小区名称在小区表中有，这里为名字对应的小区的ID',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `room_structure` varchar(255) NOT NULL COMMENT '户型；存储json格式的数据，如：json_encode( array( ‘room’ => 1, ‘hall’ => 1, ‘bathroom’ => 1 ) )',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `price` float(8,2) NOT NULL COMMENT '售价',
  `floor` smallint(6) NOT NULL COMMENT '楼层数',
  `house_number` varchar(255) NOT NULL COMMENT '楼栋号； 存储json格式的数据，如：json_encode( array( ‘floor’ => 1, ‘unit’ => 1 ) )',
  `direction_id` smallint(6) DEFAULT NULL COMMENT '朝向ID',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `tag` varchar(255) DEFAULT NULL COMMENT '特色标签；标签表id；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `customer_tag` varchar(255) DEFAULT NULL COMMENT '自定义特色标签; 存储json格式的数据，如：json_encode( array(‘特色标签1’, ‘特色标签2’, ‘特色标签3’) )',
  `title` varchar(255) NOT NULL COMMENT '房源标题',
  `supporting` varchar(255) NOT NULL COMMENT '房源配套; 关联配套表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `content` text NOT NULL COMMENT '房源描述',
  `room_images` text NOT NULL COMMENT '室内图; 关联附件表，存储json格式数据，包括图片id和图片地址。\n如：json_encode( array( array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’), array(‘id’, => 1, ‘url’ => ‘http://www.0736fdc.com/upload/2014/10/17/1231241324.png’) …… ) )\n',
  `is_commissioned` tinyint(1) NOT NULL COMMENT '是否委托',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介房源',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人房源',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网房源',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过',
  `refresh_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '刷新时间',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `sl_floor`
--

CREATE TABLE IF NOT EXISTS `sl_floor` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '名字',
  `sort` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `belong` smallint(6) NOT NULL DEFAULT '0' COMMENT '所属类别 (0:所有，1:新房，2：二手房，3：商铺，4：写字楼，5，别墅)，默认0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='楼层表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `sl_floor`
--

INSERT INTO `sl_floor` (`id`, `name`, `sort`, `belong`) VALUES
(1, '低层', 0, 0),
(2, '多层', 0, 0),
(3, '小高层', 0, 0),
(4, '高层', 0, 0),
(5, '超高层', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sl_floor`
--
ALTER TABLE `sl_floor`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sl_floor`
--
ALTER TABLE `sl_floor`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sl_area`
--
ALTER TABLE `sl_area`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_attachment`
--
ALTER TABLE `sl_attachment`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_decoration`
--
ALTER TABLE `sl_decoration`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_direction`
--
ALTER TABLE `sl_direction`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_house_supporting`
--
ALTER TABLE `sl_house_supporting`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_laravel_sessions`
--
ALTER TABLE `sl_laravel_sessions`
 ADD UNIQUE KEY `laravel_sessions_id_unique` (`id`);

--
-- Indexes for table `sl_office`
--
ALTER TABLE `sl_office`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_pay_method`
--
ALTER TABLE `sl_pay_method`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_rent`
--
ALTER TABLE `sl_rent`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_rent_method`
--
ALTER TABLE `sl_rent_method`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_rent_office`
--
ALTER TABLE `sl_rent_office`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_rent_shop`
--
ALTER TABLE `sl_rent_shop`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_rent_villas`
--
ALTER TABLE `sl_rent_villas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_second_hand_housing`
--
ALTER TABLE `sl_second_hand_housing`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_shop`
--
ALTER TABLE `sl_shop`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_shop_face_type`
--
ALTER TABLE `sl_shop_face_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_shop_manager_type`
--
ALTER TABLE `sl_shop_manager_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_tag`
--
ALTER TABLE `sl_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_type`
--
ALTER TABLE `sl_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sl_villas`
--
ALTER TABLE `sl_villas`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sl_area`
--
ALTER TABLE `sl_area`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `sl_attachment`
--
ALTER TABLE `sl_attachment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1415523688;
--
-- AUTO_INCREMENT for table `sl_decoration`
--
ALTER TABLE `sl_decoration`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sl_direction`
--
ALTER TABLE `sl_direction`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `sl_house_supporting`
--
ALTER TABLE `sl_house_supporting`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `sl_office`
--
ALTER TABLE `sl_office`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sl_pay_method`
--
ALTER TABLE `sl_pay_method`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sl_rent`
--
ALTER TABLE `sl_rent`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sl_rent_method`
--
ALTER TABLE `sl_rent_method`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sl_rent_office`
--
ALTER TABLE `sl_rent_office`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sl_rent_shop`
--
ALTER TABLE `sl_rent_shop`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sl_rent_villas`
--
ALTER TABLE `sl_rent_villas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sl_second_hand_housing`
--
ALTER TABLE `sl_second_hand_housing`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sl_shop`
--
ALTER TABLE `sl_shop`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sl_shop_face_type`
--
ALTER TABLE `sl_shop_face_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sl_shop_manager_type`
--
ALTER TABLE `sl_shop_manager_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sl_tag`
--
ALTER TABLE `sl_tag`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `sl_type`
--
ALTER TABLE `sl_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sl_villas`
--
ALTER TABLE `sl_villas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
