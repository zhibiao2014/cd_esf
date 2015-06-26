@extends('layouts.esf')
@section('content')
<div class="guide mb10 pr">
  <a rel="nofollow" href="{{Config::get('app.url')}}"> 常德市房地产信息网 </a> &gt;
  <a href="{{route('esf')}}"> 二手房 </a> &gt;
  <a href="javascript:void(0);"> 经纪人 </a>
</div>
<div class="un1_box w998 mr10">
  <div class="t1 clearfix">
    <h4 class="t2">经纪人搜索</h4>
  </div>
  <div id="rentid_60" class="mt20 ml20 mb20">
    <form action="{{action('front\BrokerController@index')}}" method="get">
      <input type="text" value="{{{isset($p['keyword']) ? $p['keyword'] : '' }}}" class="input9" name="keyword" placeholder="输入你想要查找的经纪人姓名">
      <input type="submit" class="btnSearch" value="搜 索">
    </form>
    <div class="clear"></div>
  </div>
</div>
<div class="clear mb10"></div>

<div class="w998 fl">

  <div class="un2_box btno">
    <div class="titHouse">
      <div class="fl inpbox pl10">
        <select name="s" id="sort_select" data-url="{{action('front\BrokerController@index', array_merge($p, array( 's' => '', 'page' => 1)))}}">
          <option value="regtime-desc"{{($sort[0] == 'regtime' && $sort[1] == 'asc') ? ' selected' : ''}}>默认排序</option>
          <option value="publish_num-desc"{{($sort[0] == 'publish_num' && $sort[1] == 'desc') ? ' selected' : ''}}>按二手房源数从多到少排序</option>
          <option value="rent_publish_num-desc"{{($sort[0] == 'rent_publish_num' && $sort[1] == 'desc') ? ' selected' : ''}}>按租房房源数从多到少排序</option>
        </select>
      </div>
      {{ \lib\Tool::pagination( $brokers->appends($p) ) }}
    </div>
    <!--列表 start-->
    @foreach ( $brokers as $broker )
    <div class="fclist2 clearfix">
      <a title="{{{$broker->realname}}}" href="{{route('esf.broker.show', $broker->id)}}" class="pic_k">
        <img alt="{{{$broker->realname}}}" src="{{Config::get('app.url') . $broker->photo}}">
      </a>
      <ul class="centxt">
        <li>
          <a title="<?php echo $broker->realname; ?>" href="{{route('esf.broker.show', $broker->id)}}" class="t3">{{{$broker->realname}}}</a>
        </li>
        <li>所属公司： {{{ isset($companies[$broker->fid]) ? $companies[$broker->fid]['gsmc'] : ''}}}</li>
        <li>联系电话： {{{$broker->mobile}}} </li>
        <li>
          <span>出售(<span class="c1">{{{$broker->publish_num}}}</span>)套</span> <span class="ml5">出租(<span class="c1">{{{$broker->rent_publish_num}}}</span>)套</span>
        </li>
        <li>开店时间： {{{date('Y-m-d', strtotime($broker->regtime))}}} </li>
      </ul>
      <ul class="centxt2"><li><i class="NMID mr5"></i><i class="NMcard"></i></li></ul>
      <div class="centxt3 mr10"><a href="{{route('esf.broker.show', $broker->id)}}" class="c20">进入网上店铺&gt;&gt;</a></div>
    </div>
    @endforeach

    <!--列表 end-->
  </div>
</div>

<div class="clear mb10"></div>
@stop