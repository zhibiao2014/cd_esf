<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="@yield('keywords', '常德二手房,常德租房,常德商铺,常德写字楼,常德二手房出售')" />
  <meta name="description" content="@yield('description', '常德房地产信息网(www.0736fdc.com)致力打造本地最权威的房地产信息平台,提供常德房地产,常德二手房,常德房价等专业化的全方面服务,力争成为常德最信赖的房地产网站.')" />
  <title>@yield('title', '二手房')-常德二手房</title>
  <link href="<?php echo asset("assets/css/main.css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset("assets/css/house.css"); ?>" rel="stylesheet" type="text/css" />
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

      <div class="fl" style="width:670px; height:28px;">
        <a target="_blank" href="http://www.0736fdc.com/index.html" class="fcwlink"><i></i>房产网</a>
        <a target="_blank" href="http://www.0736fdc.com/news/">资讯</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/house/market.html">新房</a> <span class="c3">|</span>
        <a target="_blank" href="<?php echo route('esf.house.index'); ?>">二手房</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.rent.index')}}">租房</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.shop.index')}}">商铺</a><span class="c2">|</span>
        <a target="_blank" href="{{route('esf.office.index')}}">写字楼</a><span class="c2">|</span>
        <a target="_blank" href="{{route('recruit')}}">招聘</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><span class="c2">|</span>
        <a target="_blank" href="http://bbs.0736fdc.com">业主论坛</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/news/list/zhibo.html">视频</a><span class="c2">|</span>
        <a target="_blank" href="http://www.0736fdc.com/about/sitemap.html">网站地图</a>
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
    <!--hander start-->
    <div class="hander mb10 clearfix">
      <div class="logobox fl mt5"><a class="esf_logo" title="常德市房地产信息网-二手房" href="{{route('esf')}}">常德市房地产信息网-二手房</a></div>
      <div class="city fl pr">
        <div id="city_Name" class="cne1">
          <a class="oc">常德</a>
        </div>
      </div>

      <div class="hs_ss fr">
        <div class="search_box fl mt10">
          <div class="sstabs clearfix">
            <a id="WebSearch1" onclick="SwapTab('WebSearch','tab01','tab02',1,4)" href="javascript:void(0);" class="tab02">新房</a>
            <a id="WebSearch2" onclick="SwapTab('WebSearch','tab01','tab02',2,4)" href="javascript:void(0);" class="{{(!isset($route) || $route != 'rent') ? 'tab01' : 'tab02' }}">二手房</a>
            <a id="WebSearch3" onclick="SwapTab('WebSearch','tab01','tab02',3,4)" href="javascript:void(0);" class="{{(isset($route) && $route == 'rent') ? 'tab01' : 'tab02' }}">租房</a>
            <a id="WebSearch4" onclick="SwapTab('WebSearch','tab01','tab02',4,4)" href="javascript:void(0);" class="tab02">资讯</a>
            <a href="http://bbs.0736fdc.com" target="_blank">论坛</a>
            <a href="http://www.0736fdc.com/ask/" target="_blank">问房</a>
            <a href="http://www.0736fdc.com/house/map.html" target="_blank">地图</a>
          </div>
          <div id="con_WebSearch_1" class="hidbox">
            <form method="get" action="http://www.0736fdc.com/house/market.html">
              <div class="ss clearfix pr">
                <div class="cb fl clearfix">
                  <a data-target="area_1" class="menubar area" href="javascript:void(0);">区域</a>
                  <a data-target="property_1" class="menubar property" href="javascript:void(0);">物业类型</a>
                  <a data-target="price_1" class="menubar price" href="javascript:void(0);">价格范围</a>
                  <i></i>
                  <input type="text" placeholder="例如：徳景园" class="txt fl" name="keywords" id="search_keywords">
                  <!--选择区域   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick Area hidbox" id="area_1" data-target="area">
                    <a href="#area=0" val="-1">全部区域</a>
                    <a href="#area=6" val="6">武陵区</a>
                    <a href="#area=7" val="7">鼎城区</a>
                    <a href="#area=94" val="94">德山区</a>
                    <a href="#area=581" val="581">柳叶湖</a>
                    <a href="#area=86" val="86">汉寿</a>
                    <a href="#area=10" val="10">桃源</a>
                    <a href="#area=85" val="85">临澧</a>
                    <a href="#area=84" val="84">石门</a>
                    <a href="#area=9" val="9">澧县</a>
                    <a href="#area=11" val="11">安乡</a>
                    <a href="#area=8" val="8">津市</a>
                    <a href="#area=580" val="580">西湖</a>
                    <a href="#area=578" val="578">西洞庭</a>
                    <a href="#area=582" val="582">桃花源</a>
                    <input type="hidden" name="area" class="area">
                  </div>
                  <!--选择区域   弹出框 模仿下拉菜单 end-->

                  <!--选择类型   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick prop hidbox" id="property_1" data-target="property">
                    <a href="javascript:void(0);" val="0">不限类型</a>
                    <a href="#wuye=1" val="1">普通住宅</a>
                    <a href="#wuye=2" val="2">公寓</a>
                    <a href="#wuye=3" val="3">商住</a>
                    <a href="#wuye=4" val="4">写字楼</a>
                    <a href="#wuye=5" val="5">商铺</a>
                    <a href="#wuye=6" val="6">别墅</a>
                    <a href="#wuye=7" val="7">仓库</a>
                    <a href="#wuye=9" val="9">其他</a>
                    <input type="hidden" name="wuye" class="property">
                  </div>
                  <!--选择类型   弹出框 模仿下拉菜单 end-->

                  <!--选择价格   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick price hidbox" id="price_1" data-target="price">
                    <a href="javascript:void(0);" val="0">不限价格</a>
                    <a href="#price=1" val="1">5000以下</a>
                    <a href="#price=2" val="2">5000-6000</a>
                    <a href="#price=3" val="3">6000-7000</a>
                    <a href="#price=4" val="4">7000-8000</a>
                    <a href="#price=5" val="5">8000-10000</a>
                    <a href="#price=6" val="6">10000以上</a>
                    <input type="hidden" name="price" class="price">
                  </div>
                  <!--选择价格   弹出框 模仿下拉菜单 end-->
                </div>
                <input class="iput fl" type="submit" value="搜 索">
                <div class="molink fl">
                  <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><br>
                  <a target="_blank" href="http://www.0736fdc.com/search.html">高级搜索</a>
                </div>
              </div>
            </form>
          </div>
          <div id="con_WebSearch_2" {{(!isset($route) || $route != 'rent') ? '' : 'class="hidbox"' }}>
            <form method="get" action="{{route('esf.house.index')}}">
              <div class="ss clearfix pr">
                <div class="cb fl clearfix">
                  <a data-target="region_2" class="menubar region" href="javascript:void(0);">区域</a>
                  <a data-target="area_2" class="menubar area" href="javascript:void(0);">面积</a>
                  <a data-target="price_2" class="menubar price" href="javascript:void(0);">价格范围</a>
                  <i></i>
                  <input type="text" class="txt fl" placeholder="请输入房源特征，如地点和小区名" name="keyword">
                  <!--选择区域   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick region hidbox" id="region_2" data-target="region">
                    {{\lib\Template::topSearchRegionSelect()}}
                    <input type="hidden" name="region" class="region" value="{{isset($route) && $route == 'rent' && isset( $p['region'] ) ? $p['region'] : ''}}">
                  </div>
                  <!--选择区域   弹出框 模仿下拉菜单 end-->

                  <!--选择类型   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick prop hidbox" id="area_2" data-target="area">
                    {{\lib\Template::topSearchAreaSelect()}}
                    <input type="hidden" name="area" class="area" value="{{isset( $p['area'] ) ? $p['area'] : ''}}">
                  </div>
                  <!--选择类型   弹出框 模仿下拉菜单 end-->

                  <!--选择价格   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick price hidbox" id="price_2" data-target="price">
                    {{\lib\Template::topSearchPriceSelect()}}
                    <input type="hidden" name="price" class="price" value="{{isset($route) && $route == 'rent' && isset( $p['price'] ) ? $p['price'] : ''}}">
                  </div>
                  <!--选择价格   弹出框 模仿下拉菜单 end-->
                </div>
                <input class="iput fl esfsearch" type="submit" value="搜 索">
                <div class="molink fl">
                  <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><br>
                  <a target="_blank" href="http://www.0736fdc.com/search.html">高级搜索</a>
                </div>
              </div>
            </form>
          </div>
          <div id="con_WebSearch_3" {{(isset($route) && $route == 'rent') ? '' : 'class="hidbox"' }}>
            <form method="get" action="{{route('esf.rent.index')}}">
              <div class="ss clearfix pr">
                <div class="cb fl clearfix">
                  <a data-target="region_3" class="menubar region" href="javascript:void(0);">区域</a>
                  <a data-target="area_3" class="menubar area" href="javascript:void(0);">面积</a>
                  <a data-target="price_3" class="menubar price" href="javascript:void(0);">价格范围</a>
                  <i></i>
                  <input type="text" class="txt fl" placeholder="请输入房源特征，如地点和小区名" name="keyword">
                  <!--选择区域   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick region hidbox" id="region_3" data-target="region">
                    {{\lib\Template::topSearchRegionSelect()}}
                    <input type="hidden" name="region" class="region" value="{{isset($route) && $route == 'rent' && isset( $p['region'] ) ? $p['region'] : ''}}">
                  </div>
                  <!--选择区域   弹出框 模仿下拉菜单 end-->

                  <!--选择类型   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick prop hidbox" id="area_3" data-target="area">
                    {{\lib\Template::topSearchAreaSelect()}}
                    <input type="hidden" name="area" class="area" value="{{isset($route) && $route == 'rent' && isset( $p['area'] ) ? $p['area'] : ''}}">
                  </div>
                  <!--选择类型   弹出框 模仿下拉菜单 end-->

                  <!--选择价格   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick price hidbox" id="price_3" data-target="price">
                    {{\lib\Template::topSearchPriceSelect()}}
                    <input type="hidden" name="price" class="price" value="{{isset($route) && $route == 'rent' && isset( $p['price'] ) ? $p['price'] : ''}}">
                  </div>
                  <!--选择价格   弹出框 模仿下拉菜单 end-->
                </div>
                <input class="iput fl esfsearch" type="submit" value="搜 索">
                <div class="molink fl">
                  <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><br>
                  <a target="_blank" href="http://www.0736fdc.com/search.html">高级搜索</a>
                </div>
              </div>
            </form>
          </div>
          <div id="con_WebSearch_4" class="hidbox">
            <form method="get" id="formnew" action="">
              <div class="ss clearfix pr">
                <div class="cb fl clearfix">
                  <a class="menubar area" href="javascript:void(0);" data-target="area_4">区域</a>
                  <i></i>
                  <input type="text" id="news_keywords" placeholder="请输入房源特征，如地点和小区名" class="txt2 fl" value="请输入房源特征，如地点和小区名" name="keywords">
                  <!--选择区域   弹出框 模仿下拉菜单 strat-->
                  <div class="pa pick Area hidbox" id="area_4" data-target="area">
                    <a href="javascript:void(0);" val="http://www.0736fdc.com"><span>常德市</span></a>
                    <a href="javascript:void(0);" val="http://hanshou.0736fdc.com"><span>汉寿</span></a>
                    <a href="javascript:void(0);" val="http://taoyuan.0736fdc.com"><span>桃源</span></a>
                    <a href="javascript:void(0);" val="http://linli.0736fdc.com"><span>临澧</span></a>
                    <a href="javascript:void(0);" val="http://shimen.0736fdc.com"><span>石门</span></a>
                    <a href="javascript:void(0);" val="http://lixian.0736fdc.com"><span>澧县</span></a>
                    <a href="javascript:void(0);" val="http://anxiang.0736fdc.com"><span>安乡</span></a>
                    <a href="javascript:void(0);" val="http://jinshi.0736fdc.com"><span>津市</span></a>
                    <a href="javascript:void(0);" val="http://xihu.0736fdc.com"><span>西湖</span></a>
                    <a href="javascript:void(0);" val="http://xidongting.0736fdc.com"><span>西洞庭</span></a>
                    <a href="javascript:void(0);" val="http://taohuayuan.0736fdc.com"><span>桃花源</span></a>
                    <input type="hidden" id="schsite" value="http://www.0736fdc.com" class="site">
                  </div>
                  <!--选择区域   弹出框 模仿下拉菜单 end-->
                </div>
                <input class="iput fl" type="submit" value="搜 索" onclick="if(document.getElementById('news_keywords').value=='请输入房源特征，如地点和小区名'){document.getElementById('news_keywords').value='';} $('#formnew').attr('action',$('#schsite').val()+'/news/search.html');">
                <div class="molink fl">
                  <a target="_blank" href="http://www.0736fdc.com/house/map.html">地图找房</a><br>
                  <a target="_blank" href="http://www.0736fdc.com/search.html">高级搜索</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!--二手房nav start-->
    <div class="mb10 esf_color_bg">
      <ul class="clearfix nav">
        <li {{!isset($route) ? 'class="li-on"' : '' }}>
          <a href="{{route('esf')}}">二手房首页</a>
        </li>
        <li {{(isset($route) && $route == 'house') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.house.index')}}">二手房</a>
        </li>
        <li {{(isset($route) && $route == 'rent') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.rent.index')}}">租房</a>
        </li>
        <li {{(isset($route) && $route == 'shop') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.shop.index')}}">商铺</a>
        </li>
        <li {{(isset($route) && $route == 'office') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.office.index')}}">写字楼</a>
        </li>
        <!-- <li {{(isset($route) && $route == 'community') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.community.index')}}">小 区</a>
        </li> -->
        <li {{(isset($route) && $route == 'broker') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.broker.index')}}">经纪人</a>
        </li>
        <li {{(isset($route) && $route == 'companny') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.company.index')}}">中介公司</a>
        </li>
        <li {{(isset($route) && $route == 'wanna_buy') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.wanna.buy')}}">求 购</a>
        </li>
        <li {{(isset($route) && $route == 'wanna_rent') ? 'class="li-on"' : '' }}>
          <a href="{{route('esf.wanna.rent')}}">求 租</a>
        </li>
      </ul>
    </div>
    <!--二手房nav end-->
    <!--hander end-->
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

      /*$('#con_WebSearch_2 form').submit( function() {
        return false;
      });*/
  });
  </script>
  @yield('footer')
</body>
</html>