@extends('layouts.esf')
@section('content')
<!--左边-->
<div class="jjrenlt">
  <!--   滑门 start   -->
  <div class="tabDate clearfix">
    <a class="tab01 tabs" href="#index"><span>店铺首页</span></a>
    <a href="{{ route( 'esf.broker.sale_show', $broker->id ) }}"><span>出售房源</span></a>
    <a href="{{ route( 'esf.broker.rent_show', $broker->id ) }}"><span>出租房源</span></a>
    <a class="tabs" href="#broker_detail"><span>经纪人信息</span></a>
  </div>
  <!--  滑门 end    -->
  <div id="index">
    <div class="un2_box btno pr">
      <!--列表 start-->

      <h2 class="sale">出售</h2>
      @if ( is_array( $houses ) && !empty( $houses ) )
      @foreach ( $houses as $house )
      <div class="fclist clearfix">
        <a title="{{{$house['title']}}}" target="_blank" href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}" class="pic_k">
          <img alt="{{{$house['title']}}}" src="{{{$house['thumbnail']}}}">
        </a>
        <ul class="centxt4 w350">
          <li><a href="xiangqing.php" target="_blank" class="t3">{{{$house['title']}}}</a></li>
          <li>{{{$house['address']}}}</li>
          @if ( $house['type'] == 'house' )
          <li>{{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}</li>
          @endif
          <li>{{ ($house['construction_area'] > 0) ? ceil( $house['price']*10000 / $house['construction_area'] ) : '' }}元/平米</li>
          <li><span class="c2">{{\lib\Tool::get_timeago( strtotime( $house['created_at'] ) )}}</span></li>
        </ul>
        <div class="E_area">{{{$house['construction_area']}}}平米</div>
        <div class="E_money"><span class="c11">{{{$house['price']}}}<span class="f12">万元</span></span></div>
      </div>
      @endforeach
      @endif

      <h2 class="sale">出租</h2>
      @if ( is_array( $rents ) && !empty( $rents ) )
      @foreach ( $rents as $rent )
      <div class="fclist clearfix">
        <a title="{{{$rent['title']}}}" target="_blank" href="{{route( 'esf.' . $rent['type'] . '.show', $rent['foreign_id'] )}}" class="pic_k">
          <img alt="{{{$rent['title']}}}" src="{{{$rent['thumbnail']}}}">
        </a>
        <ul class="centxt4 w350">
          <li><a href="xiangqing.php" target="_blank" class="t3">{{{$rent['title']}}}</a></li>
          <li>{{{$rent['address']}}}</li>
          @if ( $rent['type'] == 'rent' )
          <li>{{ Rent::getRoomStructure( $rent['foreign_id'] ) }}</li>
          @endif
          <li><span class="c2">{{\lib\Tool::get_timeago( strtotime( $rent['created_at'] ) )}}</span></li>
        </ul>
        <div class="E_area">{{{$rent['construction_area']}}}平米</div>
        <div class="E_money"><span class="c11">{{{$rent['price']}}}<span class="f12">元</span></span></div>
      </div>
      @endforeach
      @endif

      <!--列表 end-->
    </div>
  </div>
  <div id="broker_detail" class="hidbox">
    <div class="un2_box btno">
      <ul class="Flist clearfix p10">
        <li class="w_w"><em>姓名：</em><strong class="f12">{{{$broker->realname}}}</strong></li>
        <li class="w_w"><em>所属公司：</em><span class="c4 f14">{{{$company->gsmc}}}</span></li>
        <li class="w_w"><em>注册时间：</em><span>{{date('Y-m-d', strtotime($broker->regtime))}}</span></li>
        <li class="w_w"><em>电话：</em><span>{{{$broker->mobile}}}</span></li>
        <li class="w_w"><em>邮箱：</em><span>{{{$broker->email}}}</span></li>
        <li class="w_w"><em>QQ：</em><span>{{{$broker->oicq}}}</span></li>
      </ul>
    </div>
  </div>
</div>
<!--右边-->
<div class="jjrenrt">
  <div class="one_box mb10">
    <div class="photoBox p10 tc">
      <a class="pic_k" href="{{route('esf.broker.show', $broker->id)}}" title="{{{$broker->name}}}">
        <img src="{{{ Config::get( 'app.url' ) . $broker->photo }}}" alt="{{{$broker->name}}}">
      </a>
      <p>{{{$broker->realname}}}</p>
    </div>
    <div class="rezhengphone">
      <span class="phonenum">{{{$broker['mobile']}}}</span>
    </div>
    <ul class="renzheng clearfix">
      <li class="pl20">
        <p><a rel="nofollow" href="#" target="_blank"><img title="已通过身份证认证" alt="已通过身份证认证" src="{{asset('assets/images')}}/esf/attest_1.gif"></a></p>
        <p>身份认证</p>
      </li>
      <li>
        <p><a rel="nofollow" href="#" target="_blank"><img title="已通过名片认证" alt="已通过名片认证" src="{{asset('assets/images')}}/esf/attest_2.gif"></a></p>
        <p>名片认证</p>
      </li>
    </ul>
    <ul class="cont02 mb10">
      <li>公<span class="pl24">司</span>：<strong>{{{$company->gsmc}}}</strong></li>
      <li>服务区县：{{{ $cdfdc_regions[$broker['areaids'][0]]['name'] . ' - ' . $cdfdc_regions[$broker['areaids'][1]]['name']}}}</li>
      <li>注册时间：{{{date('Y-m-d', strtotime($broker->regtime))}}}</li>
    </ul>
  </div>
  <div class="un1_box">
    <h4 class="t2">二手房楼盘</h4>
    <ul class="searchlist">
      @if ( !empty( $communities ) )
      <li>
        @foreach ( $communities as $community )
        <a href="{{route( 'esf.community.show', $community->community_id )}}" title="{{{$community->community_name}}}">{{{$community->community_name}}}({{{$community->num}}})</a>
        @endforeach
      </li>
      @endif
    </ul>
  </div>
</div>
@stop