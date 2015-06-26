@extends('layouts.esf')
@section('content')
<!--center start-->
<div class="esf_genren_box clearfix">
  <div class="fl flmsg1">
    <div class="box2_line clearfix mb20">
      <div class="detail">
        <dl id="esfszxq_06" class="card">
          <dd> 联 系 人：{{{$member->realname}}} </dd>
          <dd> 手&#12288;&#12288;机：<strong class="tel14">{{{$member->mobile}}}</strong> </dd>
          <dt class="wenxin">温馨提示：若信息标题、备注、图片中出现电话或者手机，此房源可能不是个人发布。</dt>
        </dl>
      </div>
      <div class="info">
        <h1> <span> {{{$wanna_rent->title}}}</span> </h1>
        <p class="c2">发布时间：{{{$wanna_rent->created_at}}} (<span id="Time">{{{\lib\Tool::get_timeago( strtotime($wanna_rent->updated_at) )}}}</span>) </p>
        <dl class="price">
          <dt>期望租金：<span class="c6">{{{$wanna_rent->price}}}</span>元内</dt>
          <dt>租赁方式：<span class="c6">{{{$rent_methods[$wanna_rent->rent_method_id]['name']}}}</span></dt>
          @if ( $wanna_rent->type == 1 )
          <dt>求租区域：<span>{{isset($regions[$regions[$wanna_rent->area_id]['pid']]) ? $regions[$regions[$wanna_rent->area_id]['pid']]['name'] : ''}} - {{isset($regions[$wanna_rent->area_id]) ? $regions[$wanna_rent->area_id]['name'] : ''}}</span></dt>
          @else
          <dt>意向小区：<span>{{ implode( '/' , json_decode( $wanna_rent->community, true ) ) }}</span></dt>
          @endif
        </dl>
        <dl class="house">
          <dt>
            <span class="tel">联系电话:<span class="f20">{{{$member->mobile}}}</span></span>
            <span class="telr"></span>
          </dt>
          <dd> 期望户型：<span>{{{$wanna_rent->room}}}室{{{$wanna_rent->hall}}}厅{{{$wanna_rent->bathroom}}}卫</span> </dd>
          <dd> 期望面积：<span>≥{{{$wanna_rent->construction_area}}}㎡</span></dd>
          <dd> 房屋配套：<span>
            @if ( is_array( $wanna_rent->supporting ) && !empty($wanna_rent->supporting) )
            <?php
            $supportings = $wanna_rent->supporting;
            $current_supporting = current($supportings);
            array_shift($supportings);
            ?>
            {{ isset($house_supportings[$current_supporting]) ? $house_supportings[$current_supporting]['name'] : '' }}
            @foreach ( $supportings as $key => $value )
            {{ isset($house_supportings[$value]) ? $house_supportings[$value]['name'] . ' / ' : '' }}
            @endforeach
            @endif
          </span></dd>
        </dl>
      </div>
    </div>
    <div class="un1_box">
      <div class="t1 clearfix">
        <h4 class="t2">详细求租信息</h4>
      </div>
      <div class="p10">
        <p>{{{ $wanna_rent->content }}}</p>
      </div>
    </div>
  </div>

  <div class="fr flmsg2">
    <div class="un1_box one_box mb10">
      <div class="t1 clearfix">
        <h4 class="t2">其他求租</h4>
      </div>
      @if( !empty( $other_wanna_rents ) && is_array( $other_wanna_rents ) )
      <ul class="column_c clearfix">
        @foreach ( $other_wanna_rents as $key => $value )
        <li>
          <span class="wid75">
            <a title="{{{$value['title']}}}" href="{{route('esf.wanna.buy.show', $value['id'])}}" target="_blank">{{{$value['title']}}}</a>
          </span>
          <span class="wid45"> {{{$value['construction_area']}}}㎡</span>
          <span class="wid60 c1">{{{$value['price']}}}元</span>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
  </div>
</div>
<!--center end-->

@stop