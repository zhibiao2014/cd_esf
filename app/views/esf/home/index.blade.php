@extends('layouts.esf')
@section('content')
<div class="w754 fl">
  <!--二手房首页 搜索 start-->
  <div class="esf_sousuo un1_box p10 mb10">
    <p>这里有 <span class="f16 c1">{{{$total_publish}}}</span> 套房子正在出售， 最新发布的有 <span class="f16 c1">{{{$last_publish}}}</span> 套</p>
    <div class="clearfix mb10">
      <form action="{{action('front\HouseController@lists')}}" method="get">
        <input type="text" placeholder="输入你想要查找的关键词" class="inputTextb" name="keyword">
        <input type="submit" class="smb_btnb" value=" 搜 索 " />
      </form>
      <a href="{{route('esf.house.index')}}" class="ml20 mt10 fl">更多找房条件&gt;&gt;</a>
    </div>
    <div class="sou_com">
      <ul class="clearfix esf_ss_box">
        <!-- <li class="clearfix">
          <span class="s1">热门搜索：</span>
          <div class="s3"> <a href="#">兴园小区</a> <a href="#">学区房</a></div>
          </li>
          <li class="clearfix linkbm pb10 mb10">
          <span class="s1">快速通道：</span>
          <div class="s3"> <a href="#">特价房</a> <a href="#">小户型</a> <a href="#">满5年</a> <a href="#">50万以下</a> <a href="#">急售房源无税</a>
          </div>
        </li> -->
        <li class="clearfix">
          <strong class="s1">区域：</strong>
          <a href="{{action('front\HouseController@lists', array('region' => 0))}}"><span class="s2 cur">不限</span></a>
          <div class="s3">
            @foreach ($regions as $region)
            @if ( $region['pid'] == 0 )
            <a href="{{action('front\HouseController@lists', array('region' => $region['id']))}}"> {{{$region['name']}}} </a>
            @endif
            @endforeach
          </div>
        </li>
        <li class="clearfix">
          <strong class="s1">总价：</strong>
          <a href="{{action('front\HouseController@lists', array('price' => 0))}}"><span class="s2 cur">不限</span></a>
          <div class="s3">
            @foreach ( $price as $value )
            <a href="{{action('front\HouseController@lists', array('price' => $value->price))}}"> {{{$value->name}}} </a>
            @endforeach
          </div>
        </li>
        <li class="clearfix">
          <strong class="s1">户型：</strong>
          <a href="{{action('front\HouseController@lists', array('room' => 0, 'room_compare' => ''))}}"><span class="s2 cur">不限</span></a>
          <div class="s3">
            <a href="{{action('front\HouseController@lists', array('room' => 1, 'room_compare' => '=' ))}}"> 一室 </a>
            <a href="{{action('front\HouseController@lists', array('room' => 2, 'room_compare' => '=' ))}}"> 二室 </a>
            <a href="{{action('front\HouseController@lists', array('room' => 3, 'room_compare' => '=' ))}}"> 三室 </a>
            <a href="{{action('front\HouseController@lists', array('room' => 4, 'room_compare' => '=' ))}}"> 四室 </a>
            <a href="{{action('front\HouseController@lists', array('room' => 5, 'room_compare' => '>=' ))}}"> 四室以上 </a>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <!--二手房首页 搜索 end-->
  <!-- 您可能感兴趣的房子 start -->
  <dl id="esf_B03_13" class="interesthouse mb10">
    <dt class="title"><span class="fl">优质出售房源推荐</span></dt>
    @foreach ( $houses as $house )
    <dd>
      <a class="pic" target="_blank" href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}">
        <img src="{{{empty($house['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $house['thumbnail'] }}}" width="125" height="95" />
      </a>
      <p class="words">
        <a target="_blank" href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}">{{{$house['title']}}}</a>
        @if ( $house['type'] == 'house' )
        <br> {{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}，
        @endif
        {{{$house['construction_area']}}}㎡<br>
        <span class="c1">{{{$house['price']}}}万</span>
      </p>
    </dd>
    @endforeach
  </dl>
  <dl id="esf_B03_13" class="interesthouse mb10">
    <dt id="" class="title"><span class="fl">优质出租房源推荐</span></dt>
    @foreach ( $rents as $house )
    <dd>
      <a class="pic" target="_blank" href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}">
        <img src="{{{empty($house['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $house['thumbnail'] }}}" width="125" height="95" />
      </a>
      <p class="words">
        <a target="_blank" href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}">{{{$house['title']}}}</a>
        @if ( $house['type'] == 'rent' )
        <br> {{ Rent::getRoomStructure( $house['foreign_id'] ) }}，
        @endif
        {{{$house['construction_area']}}}㎡<br>
        <span class="c1">{{{$house['price']}}}元/月</span>
      </p>
    </dd>
    @endforeach
  </dl>
  <!-- 您可能感兴趣的房子 end--  -->
  <!-- 推荐房源 start -->
  <div id="TabView1" class="pr houseshow mt10 pt10">
    <div class="tabDate">
      <a class="tab01 tabs" href="#commissioned"><span>本网房源推荐</span></a>
      <a class="tabs" href="#individual"><span>个人房源推荐</span></a>
      <a class="tabs" href="#broker"><span>经纪人房源推荐</span></a>
    </div>
    <div id="commissioned">
      <div class="pl10 clearfix">
        <a class="more" href="{{route('esf.house.index')}}?type=4">更多&gt;&gt;</a>
        @if ( is_array($commissioned_houses) )
        @foreach ( $commissioned_houses as $house )
        <dl class="housebox">
          <dt>
            <a target="_blank" href="{{route( 'esf.house.show', $house['id'] )}}">
              <img width="100" height="75" src="{{{empty($house['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $house['thumbnail'] }}}">
            </a>
          </dt>
          <dd>
            <p><a target="_blank" href="{{route( 'esf.house.show', $house['id'] )}}">{{{$house['title']}}}</a></p>
            <p>
              {{{ $house['room'] . '室' . $house['hall'] . '厅' }}}，{{{$house['construction_area']}}}㎡
            </p>
            <p class="c1"><strong>{{{$house['price']}}}</strong>万元</p>
          </dd>
        </dl>
        @endforeach
        @endif
      </div>
    </div>
    <div id="individual" class="hidbox">
      <div class="list">
        <a class="more" href="{{route('esf.house.index')}}?type=2">更多&gt;&gt;</a>
        @if ( is_array($individual_houses) )
        <dl class="righdot">
          <dt>
            <span class="wid160">物业名称/地址</span>
            <span class="wid60">户型</span>
            <span class="wid60r">面积</span>
            <span class="wid60r">价格</span>
          </dt>
          @foreach ( $individual_houses as $key => $house )
          @if ( ceil( count($individual_houses)/2 ) == ($key) )
        </dl>
        <dl>
          <dt>
            <span class="wid160">物业名称/地址</span>
            <span class="wid60">户型</span>
            <span class="wid60r">面积</span>
            <span class="wid60r">价格</span>
          </dt>
        </dl>
        <dl>
          @endif
          <dd>
            <span class="c20 wid160">
              <a target="_blank" title="{{{$house['title']}}}" href="{{route( 'esf.house.show', $house['id'] )}}">{{{$house['title']}}}</a>
            </span>
            <span class="wid60">{{{ $house['room'] . '室' . $house['hall'] . '厅' }}}</span>
            <span class="wid60r">{{{$house['construction_area']}}}㎡</span>
            <span class="c4 wid60r">{{{$house['price']}}}万</span>
          </dd>
          @endforeach
        </dl>
        @endif
      </div>
    </div>
    <div id="broker" class="hidbox">
      <div class="list">
        <a class="more" href="{{route('esf.house.index')}}?type=3">更多&gt;&gt;</a>
        @if ( is_array($broker_houses) )
        <dl class="righdot">
          <dt>
            <span class="wid160">物业名称/地址</span>
            <span class="wid60">户型</span>
            <span class="wid60r">面积</span>
            <span class="wid60r">价格</span>
          </dt>
          @foreach ( $broker_houses as $key => $house )
          @if ( ceil( count($broker_houses)/2 ) == ($key) )
        </dl>
        <dl>
          <dt>
            <span class="wid160">物业名称/地址</span>
            <span class="wid60">户型</span>
            <span class="wid60r">面积</span>
            <span class="wid60r">价格</span>
          </dt>
        </dl>
        <dl>
          @endif
          <dd>
            <span class="c20 wid160">
              <a target="_blank" title="{{{$house['title']}}}" href="{{route( 'esf.house.show', $house['id'] )}}">{{{$house['title']}}}</a>
            </span>
            <span class="wid60">{{{ $house['room'] . '室' . $house['hall'] . '厅' }}}</span>
            <span class="wid60r">{{{$house['construction_area']}}}㎡</span>
            <span class="c4 wid60r">{{{$house['price']}}}万</span>
          </dd>
          @endforeach
        </dl>
        @endif
      </div>
    </div>
  </div>
  <!-- 推荐房源 end -->
  <!-- 商铺 start -->
  <div id="TabView1" class="pr houseshow mt10 pt10">
    <div class="tabDate">
      <a class="tab01 tabs" href="#shop"><span>商铺</span></a>
      <a class="tabs" href="#office"><span>写字楼</span></a>
    </div>
    <div id="shop">
      <div class="pl10 clearfix">
        <a class="more" href="{{route('esf.shop.index')}}">更多&gt;&gt;</a>
        @if ( is_array($shops) )
        @foreach ( $shops as $house )
        <dl class="housebox">
          <dt>
          <a target="_blank" href="{{route( 'esf.shop.show', $house['id'] )}}">
              <img width="100" height="75" src="{{{empty($house['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $house['thumbnail'] }}}">
            </a>
          </dt>
          <dd>
            <p><a target="_blank" href="{{route( 'esf.shop.show', $house['id'] )}}">{{{$house['title']}}}</a></p>
            <p>{{{$house['construction_area']}}}㎡</p>
            <p class="c1"><strong>{{{$house['price']}}}</strong>万元</p>
          </dd>
        </dl>
        @endforeach
        @endif
      </div>
    </div>
    <div id="office" class="hidbox">
      <div class="pl10 clearfix">
        <a class="more" href="{{route('esf.office.index')}}">更多&gt;&gt;</a>
        @if ( is_array($offices) )
        @foreach ( $offices as $house )
        <dl class="housebox">
          <dt>
            <a target="_blank" href="{{route( 'esf.office.show', $house['id'] )}}">
              <img width="100" height="75" src="{{{empty($house['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $house['thumbnail'] }}}">
            </a>
          </dt>
          <dd>
            <p><a target="_blank" href="{{route( 'esf.office.show', $house['id'] )}}">{{{$house['title']}}}</a></p>
            <p>{{{$house['construction_area']}}}㎡</p>
            <p class="c1"><strong>{{{$house['price']}}}</strong>万元</p>
          </dd>
        </dl>
        @endforeach
        @endif
      </div>
    </div>
  </div>
  <!-- 写字楼 end -->
</div>
<div class="w232 fr">
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">个人免费发布房源</h4>
    </div>
    <div class="p10">
      <p>高访问量，迅速出售；<br />
        常德专业平台，免费安心省心！<br />
        常德今天已有<span class="c6">{{{$current_publish}}}</span>人发布了出售房源
      </p>
      <div class="weituo_btn">
        <a target="_blank" href="{{{route('house.create')}}}"> 我要出售 </a>
        <a target="_blank" href="{{{route('house.index')}}}"> 管理房源 </a>
      </div>
      <div class="mt5 tc c1">
        <a target="_blank" href="{{{route('house.index')}}}"> 修改 / 删除个人房源&gt;&gt; </a>
      </div>
    </div>
  </div>
  <div class="clear mb10"></div>
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">推荐房源</h4>
    </div>
    <div class="RecommendListings">
      @foreach ( $last_houses as $value )
      <?php $room_structure = json_decode( $value->room_structure, true ); ?>
      <dl class="clearfix">
        <dt>
          <a title="{{{$value->community_name}}}" href="{{route('esf.house.show', array('id' => $value->id))}}"><img alt="{{{$value->community_name}}}" src="{{empty($value->thumbnail) ? asset('assets/images/esf/moren.jpg') : $value->thumbnail}}"></a>
        </dt>
        <dd>
          <h3 class="t4"> <a href="{{route('esf.house.show', array('id' => $value->id))}}">{{{$value->title}}}</a> </h3>
          <p> <span>{{{$value->construction_area}}}㎡</span> <span>{{{$room_structure['room']}}}室{{{$room_structure['hall']}}}厅{{{$room_structure['bathroom']}}}卫</span> <span>{{{$value->price}}}万</span> <span>{{{$value->community_name}}}</span> <span class="c2">{{{ \lib\Tool::get_timeago( strtotime( $value->refresh_at ) ) }}}</span></p>
        </dd>
      </dl>
      @endforeach
    </div>
  </div>
  <div class="clear mb10"></div>
  {{ \lib\Template::feed() }}
</div>
<div class="clear mb10"></div>
@stop