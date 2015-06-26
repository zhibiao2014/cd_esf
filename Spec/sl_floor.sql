
CREATE TABLE IF NOT EXISTS `sl_i_wanna_buy_property` (
  `id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '发布类型，1:住宅，2:写字楼，3:商铺',
  `contacts` char(20) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '联系人手机',
  `area_id` smallint(6) NOT NULL COMMENT '城区ID',
  `construction_area` float(8,2) NOT NULL COMMENT '建筑面积',
  `room_structure` varchar(255) NOT NULL COMMENT '户型；存储json格式的数据，如：json_encode( array( ‘room’ => 1, ‘hall’ => 1, ‘bathroom’ => 1 ) )',
  `price` float(8,2) NOT NULL COMMENT '售价',
  `house_age` float(8,2) NOT NULL COMMENT '期望房龄',
  `direction_id` smallint(6) DEFAULT NULL COMMENT '朝向ID',
  `decoration_id` smallint(6) DEFAULT NULL COMMENT '装修表id',
  `floor_id` tinyint(3) NOT NULL COMMENT '期望楼层，楼层表id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(255) NOT NULL COMMENT '描述',
  `type_id` smallint(6) DEFAULT NULL COMMENT '写字楼，商铺类型，类型ID',
  `shop_type` varchar(255) NOT NULL COMMENT '关联经营类别表；存储json格式的数据，如：json_encode( array(‘1’, ‘2’, ‘3’ ……) )',
  `is_broker` tinyint(1) NOT NULL COMMENT '是否为中介发布',
  `is_individual` tinyint(1) NOT NULL COMMENT '是否为个人发布',
  `is_admin` tinyint(1) NOT NULL COMMENT '是否为本网发布',
  `member_id` int(11) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态;审核状态 0：退回，1：再次提交审核，99：审核通过。默认审核通过',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sl_second_hand_housing`
--
ALTER TABLE `sl_i_wanna_buy_property`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sl_second_hand_housing`
--
ALTER TABLE `sl_i_wanna_buy_property`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;