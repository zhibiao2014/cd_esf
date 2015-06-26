@extends('layouts.esf')
@section('content')
<!--求购搜索 sta-->

<div class="guide mb10 pr">
  <a rel="nofollow" href="{{Config::get('app.url')}}"> 常德市房地产信息网 </a> &gt;
  <a href="{{route('esf.house.index')}}"> 二手房 </a> &gt;
  <a href="javascript:void(0);"> 求 购 </a>
  <a target="_blank" href="{{route('i_wanna_buy_property.create')}}" class="btn-fabu pa">
    <img width="152" height="34" alt="发布出租" onmouseover="this.src='{{asset('assets/images/zf/but_qg_2.png')}}'" onmouseout="this.src='{{asset('assets/images/zf/but_qg_1.png')}}'" src="{{asset('assets/images/zf/but_qg_1.png')}}">
  </a>
</div>
<div class="tit_sea pr clear">
  <h2>高级搜索</h2>
</div>
<div class="un2_box w998 mr10" style="margin-top:-1px;">
  <div id="rentid_60" class="mt20 ml20">
    <form action="{{action('front\WannaController@buy')}}" method="get">
      @foreach ( $p as $key => $value )
      @if ( $key != 'keyword')
      @if ( is_array($value) )
      @foreach ( $value as $key_2 => $value_2 )
      <input type="hidden" name="{{$key}}[]" value="{{$value_2}}" />
      @endforeach
      @else
      <input type="hidden" name="{{$key}}" value="{{$value}}" />
      @endif
      @endif
      @endforeach
      <input type="text" placeholder="输入你想要查找的关键词" value="{{{isset($p['keyword']) ? $p['keyword'] : '' }}}" class="input9" name="keyword">
      <input type="submit" class="btnSearch" value=" 搜 索 " />
    </form>
    <div class="clear"> </div>
  </div>
  <div class="sou_com w45li pr">
    <ul class="clearfix esf_ss_box pt10 pb10">
      <li class="clearfix">
        <strong class="s1">区域：</strong>
        <a href="{{action('front\WannaController@buy', array_diff_key( $p, array('region' => 0) ))}}"><span{{ ( !isset($p['region']) || empty($p['region']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ($regions as $region)
          @if ( $region['pid'] == 0 )
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('region' => $region['id']) ))}}"{{ ( isset($p['region']) && $p['region'] == $region['id']) ? ' class="cur"' : '' }}> {{{$region['name']}}} </a>
          @endif
          @endforeach
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">总价：</strong>
        <a href="{{action('front\WannaController@buy', array_diff_key( $p, array('price' => 0) ))}}"><span{{ ( !isset($p['price']) || empty($p['price']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $price as $value )
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('price' => $value->price) ))}}"{{ ( isset($p['price']) && $p['price'] == $value->price ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
          <input class="esf_textA" type="text" name="price[]" max="999999" min="0" value="{{ isset($p['price']) ? explode(',', $p['price'])[0] : '' }}" autocomplete="off">
          <span class="ml5 mr5">-</span>
          <input class="esf_textB" type="text" name="price[]" max="999999" min="0"  value="{{ isset($p['price']) && !empty($p['price']) ? explode(',', $p['price'])[1] : '' }}" autocomplete="off">
          <input class="iput_but1" id="price_filter" type="button" data-url="{{action('front\WannaController@buy')}}" data-query='{{json_encode($p)}}' value="价格筛选">
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">户型：</strong>
        <a href="{{action('front\WannaController@buy', array_diff_key( $p, array('room' => 0, 'room_compare' => '') ))}}"><span{{ ( !isset($p['room']) || empty($p['room']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('room' => 1, 'room_compare' => '=' ) ))}}"{{ ( isset($p['room']) && $p['room'] == 1) ? ' class="cur"' : '' }}> 一室 </a>
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('room' => 2, 'room_compare' => '=' ) ))}}"{{ ( isset($p['room']) && $p['room'] == 2) ? ' class="cur"' : '' }}> 二室 </a>
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('room' => 3, 'room_compare' => '=' ) ))}}"{{ ( isset($p['room']) && $p['room'] == 3) ? ' class="cur"' : '' }}> 三室 </a>
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('room' => 4, 'room_compare' => '=' ) ))}}"{{ ( isset($p['room']) && $p['room'] == 4) ? ' class="cur"' : '' }}> 四室 </a>
          <a href="{{action('front\WannaController@buy', array_merge( $p, array('room' => 5, 'room_compare' => '>=' ) ))}}"{{ ( isset($p['room']) && $p['room'] == 5) ? ' class="cur"' : '' }}> 四室以上 </a>
        </div>
      </li>
    </ul>
  </div>
</div>
<!--求购搜索 end-->
<div class="clear mb10"></div>
<!--左边-->
<div class="jjrenlt">
  <div class="un2_box btno">
    <div class="titHouse">
    {{$houses->appends($p)->links('structure.pagination-simple')}}
    </div>
    <dl id="tips" class="updown">
      <dt id="rentid_111">
        @if ( isset($sort) && $sort[0] == 'price' && $sort[1] == 'desc' )
        <a href="{{action('front\WannaController@buy', array_merge( $p, array('s' => array( 'price', 'asc' ) ) ))}}"><span class="rank2">总价</span> </a>
        @else
        <a href="{{action('front\WannaController@buy', array_merge( $p, array('s' => array( 'price', 'desc' ) ) ))}}"><span class="rank1">总价</span></a>
        @endif
        @if ( isset($sort) && $sort[0] == 'created_at' && $sort[1] == 'desc' )
        <a href="{{action('front\WannaController@buy', array_merge( $p, array('s' => array( 'created_at', 'asc' ) ) ))}}"><span class="rank6">发布时间</span> </a>
        @else
        <a href="{{action('front\WannaController@buy', array_merge( $p, array('s' => array( 'created_at', 'desc' ) ) ))}}"><span class="rank4">发布时间</span></a>
        @endif
      </dt>
    </dl>
    <!--列表单行 start-->
    <div class="esfbuy">
      <ul>
        @foreach ( $houses as $house )
        <li>
          <span class="li2"><strong><a href="{{{route('esf.wanna.buy.show', $house->id)}}}">{{{$house->title}}}</a></strong>({{{$regions[$house->area_id]['name']}}})</span>
          <span class="li1">{{{$house->room}}}室{{{$house->hall}}}厅</span>
          <span class="li3"><strong>{{{$house->price}}}</strong>万</span>
          <span class="li4">&nbsp;</span>
          <span class="li5">{{{ \lib\Tool::get_timeago( strtotime( $house->updated_at ) ) }}}</span>
        </li>
        @endforeach
      </ul>
    </div>
    <!--列表单行 end-->
    <!--列表 start-->
    <div class="clearfix mb30">
      {{ \lib\Tool::pagination( $houses->appends($p) ) }}
    </div>
    <!--列表 end-->
  </div>
</div>
<!--右边-->
<div class="jjrenrt">
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
@stop