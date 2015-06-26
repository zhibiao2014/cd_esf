<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="@yield('keywords', '常德房地产,常德市房地产信息网,常德新房,常德二手房,常德租房,常德房屋中介,常德住房团购')" />
	<meta name="description" content="@yield('description', '常德市房地产信息网是常德市地区最权威的房产信息网，我们有最权威的数据，最优秀的房产信息发布平台。')" />
	<title>@yield('title')会员中心-常德市房地产信息网</title>
	<link href="<?php echo asset("assets/css/main.css"); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset("assets/css/user/login.css"); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo asset("assets/css/user/zp.css"); ?>" rel="stylesheet" type="text/css" />
	@yield('header')
</head>
<body class="wrap_bg">
	<div class="Ucen_hander mb20">
		<div class="clearfix w1000">
			<div class="logobox2 fl"><a class="Ucen_logo2" title="常德市房地产信息网" href="{{{route('home')}}}">常德市房地产信息网</a></div>
		</div>
		<div class="user_nav">
			<ul class="clearfix">
				<li><a href="<?php echo route('home'); ?>" class="cur">会员中心首页</a></li>
				<li><a href="http://www.0736fdc.com/user/account/index.html">用户中心</a></li>
				<li><a href="http://www.0736fdc.com/user/safecenter.html">安全中心</a></li>
				<li><a href="http://www.0736fdc.com/user/message.html">短消息中心</a></li>
				<li><a href="#">帮助中心</a></li>
				<li><a href="http://www.0736fdc.com/user/logout.html">退出登陆</a></li>
			</ul>
		</div>
	</div>

	<div class="wrap">
		<div class="user_center">
			<!-- 左导航开始 -->
			<div class="set_side fl">
				<div class="myhome"><a href="<?php echo route('home'); ?>" class="tab01">我的首页</a></div>
				<?php
				$path = \Route::current()->getPath();
				$user = \Auth::user();
				?>
				@if ( $user->level == 1 || $user->level == 7 )
				<h2 class="tit867">出售出租</h2>
				<ul class="nav_side">
					<li>
						<a <?php if( in_array( $path, array("house/create", "office/create", "villas/create", "shop/create" )) ) { echo 'class="tab01" '; } ?> href="<?php echo route('house.create'); ?>">发布出售</a>
					</li>
					<li><a <?php if( $path == "house" ) { echo 'class="tab01" '; } ?>href="<?php echo route('house.index'); ?>">管理出售</a></li>
					<li>
						<a <?php if( in_array( $path, array("rent/create", "rent_office/create", "rent_villas/create", "rent_shop/create" )) ) { echo 'class="tab01" '; } ?> href="<?php echo route('rent.create'); ?>">发布出租</a>
					</li>
					<li><a <?php if( $path == "rent") { echo 'class="tab01" '; } ?> href="<?php echo route('rent.index'); ?>">管理出租</a></li>
				</ul>
				<h2 class="tit867">求租求购</h2>
				<ul class="nav_side">
					<li><a <?php if( $path == "i_wanna_buy_property/create") { echo 'class="tab01" '; } ?> href="<?php echo route('i_wanna_buy_property.create'); ?>">发布求购</a></li>
					<li><a <?php if( $path == "i_wanna_buy_property") { echo 'class="tab01" '; } ?> href="<?php echo route('i_wanna_buy_property.index'); ?>">管理求购</a></li>
					<li><a <?php if( $path == "i_wanna_rent_property/create") { echo 'class="tab01" '; } ?> href="<?php echo route('i_wanna_rent_property.create'); ?>">发布求租</a></li>
					<li><a <?php if( $path == "i_wanna_rent_property") { echo 'class="tab01" '; } ?> href="<?php echo route('i_wanna_rent_property.index'); ?>">管理求租</a></li>
				</ul>
				<h2 class="tit867">我的求职</h2>
				<ul class="nav_side">
					<li><a <?php if( $path == "jobs/create") { echo 'class="tab01" '; } ?> href="{{route('jobs.create')}}">发布求职</a></li>
					<li><a <?php if( $path == "jobs") { echo 'class="tab01" '; } ?>  href="{{route('jobs.index')}}">我的简历</a></li>
					<!-- <li><a <?php if( $path == "post/create") { echo 'class="tab01" '; } ?>  href="{{route('post.create')}}">发布招聘</a></li>
					<li><a <?php if( $path == "post") { echo 'class="tab01" '; } ?>  href="{{route('post.index')}}">招聘职位</a></li>
					<li><a href="index_3_5.php">简历投递记录</a></li>
					<li><a href="index_3_6.php">谁下载了我的简历</a></li>
					<li><a href="index_3_7.php">面试邀请</a></li> -->
				</ul>
				@elseif ( $user->level == 2 )
				<ul class="nav_side">
					<li><a class="tab02" id="settwo2" href="http://www.0736fdc.com/user/account/corporate.html">企业资料修改</a></li>
					<li><a class="tab02" id="settwo5" href="http://www.0736fdc.com/user/account/broker.html">经纪人管理</a></li>
				</ul>
				<h2 class="tit867">公司招聘</h2>
				<ul class="nav_side">
					<li><a <?php if( $path == "post/create") { echo 'class="tab01" '; } ?>  href="{{route('post.create')}}">发布招聘</a></li>
					<li><a <?php if( $path == "post") { echo 'class="tab01" '; } ?>  href="{{route('post.index')}}">招聘职位</a></li>
					<!-- <li><a href="index_3_9.php">推荐简历</a></li>
					<li><a href="index_3_10.php">已下载简历</a></li>
					<li><a href="index_3_11.php">发送的面试邀请</a></li>
					<li><a href="index_3_12.php">公司资料</a></li> -->
				</ul>
				<!-- <h2 class="tit867">经纪公司管理</h2>
				<ul class="nav_side">
					<li><a href="index_5_1.php">添加经纪人</a></li>
					<li><a href="index_5_2.php">关联经纪人</a></li>
					<li><a href="index_5_3.php">经纪人管理</a></li>
				</ul> -->
				@endif
				<!-- <h2 class="tit867">关注收藏</h2>
				<ul class="nav_side">
					<li><a href="javascript:void(0);">房源收藏</a></li>
					<li><a href="index_4_2.php">关注楼盘</a></li>
				</ul> -->
			</div>
			<!-- 左导航结束 -->

			<!-- 内容 -->
			@yield('content')
			<!-- 内容结束 -->

		</div>
		<!-- 底部 -->
		<div class="Copyright clear">
			<p>
				<a href="http://www.0736fdc.com/about/wzjj.html" target="_blank">网站简介</a> |
				<a href="http://www.0736fdc.com/about/ggfw.html" target="_blank">广告服务</a> |
				<a href="http://www.0736fdc.com/about/cpyc.html" target="_blank">诚聘英才</a> |
				<a href="http://www.0736fdc.com/about/yytd.html" target="_blank">运营团队</a> |
				<a href="http://www.0736fdc.com/about/lxwm.html" target="_blank">联系我们</a> |
				<a href="http://www.0736fdc.com/about/jszc.html" target="_blank">技术支持</a> |
				<a href="http://www.0736fdc.com/about/lxwm.html" target="_blank">联系我们</a> |
				<a href="http://www.0736fdc.com/about/wmdys.html" target="_blank">我们的优势</a> |
				<a href="http://www.0736fdc.com/about/mzsm.html" target="_blank">免责声明</a>
				<br>
				<span><a href="http://www.0736fdc.com" target="_blank">常德市房地产信息网</a>&nbsp;&nbsp;Copyright 2003-2014 All Rights Reserved&nbsp;&nbsp;Version：2.1.2正式版&nbsp;&nbsp;</span><br>
				<span>湘ICP备05013990号-9</span>
				电话：<span>0736-7201965</span>(总编室)&nbsp;<span>0736-7203060</span>(房屋备案)<br>
				提示：本站的新房、二手房、招聘、求职等信息真实性请用户自行辨别，由此产生的经济纠纷等法律责任本站不与承担。<br>
				技术支持：<a href="http://www.cdwanxun.com/" target="_blank">万讯互动</a>
			</p>
			<!-- 底部结束 -->
		</div>
	</div>
	<script src="<?php echo asset("assets/js/lib/jquery-1.11.0.min.js"); ?>"></script>
	<script src="<?php echo asset("assets/js/lib/jquery.placeholder.js"); ?>"></script>
	<script src="<?php echo asset("assets/js/functions.js"); ?>"></script>
	<script src="<?php echo asset("assets/js/global.js"); ?>"></script>
	@yield('footer')
</body>
</html>