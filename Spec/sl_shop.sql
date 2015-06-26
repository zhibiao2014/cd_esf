-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-10-21 17:10:03
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
-- 表的结构 `sl_second_hand_housing`
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
  `construct_year` SMALLINT(6) NOT NULL COMMENT '建筑年代',
  `price` float(8,2) NOT NULL COMMENT '单价',
  `floor` varchar(255) NOT NULL COMMENT '楼层；存储json格式的数据，如：json_encode( array( ‘total_floor’ => 1, ‘floor’ => 1 ) )',
  `type_id` smallint(6) DEFAULT NULL COMMENT '类型ID',
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sl_second_hand_housing`
--
ALTER TABLE `sl_shop`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sl_second_hand_housing`
--
ALTER TABLE `sl_shop`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
