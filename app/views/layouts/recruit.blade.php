<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="@yield('keywords', '常德二手房,常德租房,常德商铺,常德写字楼,常德二手房出售')" />
  <meta name="description" content="@yield('description', '常德房地产信息网(www.0736fdc.com)致力打造本地最权威的房地产信息平台,提供常德房地产,常德二手房,常德房价等专业化的全方面服务,力争成为常德最信赖的房地产网站.')" />
  <title>@yield('title', '二手房')-常德二手房</title>
  <link href="<?php echo asset("assets/css/main.css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset("assets/css/user/zp.css"); ?>" rel="stylesheet" type="text/css" />
  @yield('header')
</head>
<body>
  <!--mini-top start-->
  <div class="mininav">
    <div class="wrap">
      <!-- 登陆判断 -->

      <div class="fl" style="width:auto; height:28px;">
        @if ( \Auth::check() )
        <?php $user = \Auth::user(); ?>
        <span id="toploginbox">
          <div class="U-name" onmouseover="this.className='U-name U-name-hover'" onmouseout="this.className='U-name'">
            <a class="n-syt" target="_blank" href="{{route('home')}}">{{$user->user_name}}<i></i></a>
            <div class="T-menu-sub">
              <ul>
                <li><a href="{{route('home')}}">个人中心</a></li>
                <li><a href="{{route('house.index')}}">我发布的信息</a></li>
                <li><a href="http://www.0736fdc.com/user/account/index.html">完善资料</a></li>
                <li><a href="http://www.0736fdc.com/user/logout.html">退出</a></li>
              </ul>
            </div>
          </div>
        </span>
        @else
        <span id="toploginbox">
          <a target="_blank" href="http://www.0736fdc.com/user/reg.html">[注册]</a>
          <a target="_blank" href="http://www.0736fdc.com/user/login.html">[登录]</a>
        </span>
        @endif
      </div>

      <div class="fl" style="width:640px; height:28px;">
        <a target="_blank" href="http://www.0736fdc.com/index.html" class="fcwlink"><i></i>房产网</a>
        <a target="_blank" href="http://www.0736fdc.com/news/">资讯</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/house/market.html">新房</a> <span class="c2">|</span>
        <a target="_blank" href="<?php echo route('esf.house.index'); ?>">二手房</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.rent.index')}}">租房</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.shop.index')}}">商铺</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.office.index')}}">写字楼</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><span class="c2">|</span>
        <a target="_blank" href="http://bbs.0736fdc.com">业主论坛</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/news/list/zhibo.html">视频</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/about/sitemap.html">网站地图</a><span class="c2">|</span>
        <a target="_blank" href="{{route('recruit')}}">招聘</a>
      </div>
      <div class="fr" style="width:232px; height:28px;">
        <span style="float:left; padding-top:4px;"><a href="http://218.75.129.178:81/" target="_blank" class="bancx">网签合同备案</a></span>
        <span style="float:right; padding-top:3px;">
          <!-- WPA Button Begin -->
          <script charset="utf-8" type="text/javascript" src="http://wpa.b.qq.com/cgi/wpa.php?key=XzkzODAxMjk1NV8yMTUyNzhfNDAwMDczNjYwMF8"></script>
          <!-- WPA Button End -->
        </span>
      </div>
    </div>
  </div>
  <!--mini-top end-->
  <div class="wrap pt10">
    <!--招聘头部-->
    <div class="zp_hander clearfix">
      <h1 class="fl logo"><a href="{{route('recruit')}}"><img src="{{asset('assets/images/user/zp/logo.png')}}" width="170" height="57" alt="人才招聘-常德市房地产信息网" /></a></h1>
      <form action="{{action('recruit')}}" method="get">
        <div class="zp_ss_box fl">
          <input placeholder="请输入职位名称或公司名称" class="keyword" id="keywordtop" value="{{{ isset($_GET['keyword']) ? $_GET['keyword'] : ''}}}" name="keyword">
          <input class="but_ss" type="submit" value="搜 索" />
        </div>
      </form>
      <div class="fabu fr">
        @if ( !\Auth::check() || $user->level == 2 )
        <a target="_blank" class="fabu_zp" href="{{route('post.create')}}">发布招聘</a>
        @endif
        @if ( !\Auth::check() || $user->level != 2 )
        <a target="_blank" class="fabu_zp2" href="{{route('jobs.create')}}">登记简历</a>
        @endif
      </div>
      <!--招聘搜索-->
    </div>

    @yield('content')
  </div>
  @yield('lightbox')
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
  <script src="<?php echo asset("assets/js/lib/jquery-1.11.0.min.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/lib/jquery-ui.min.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/lib/jquery.placeholder.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/functions.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/global.js"); ?>"></script>
  <script type="text/javascript">
    $(function(){
      // 内容区块切换
      $( "#tabs" ).tabs({
        event: "mouseover",
        activate: function( event, ui ) {
          ui.newTab.addClass('cur arrow');
          ui.oldTab.removeClass('cur arrow');
        }
      });
    });
  </script>
  @yield('footer')
</body>
</html>