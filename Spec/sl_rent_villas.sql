-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-10-23 10:41:01
-- 服务器版本： 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cdfdc_usercenter`
--

-- --------------------------------------------------------

--
-- 表的结构 `sl_second_hand_housing`
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
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，1：再次提交审核，99：审核通过。默认审核通过',
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
ALTER TABLE `sl_rent_villas`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sl_second_hand_housing`
--
ALTER TABLE `sl_rent_villas`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;