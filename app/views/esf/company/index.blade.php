@extends('layouts.esf')
@section('content')
<div class="guide mb10 pr">
  <a rel="nofollow" href="{{Config::get('app.url')}}"> 常德市房地产信息网 </a> &gt;
  <a href="{{route('esf')}}"> 二手房 </a> &gt;
  <a href="javascript:void(0);"> 中介公司 </a>
</div>
<!--左边-->
<div class="jjrenlt">
  <div class="un2_box btno">
    <div class="titHouse">
      {{ \lib\Tool::pagination( $companies ) }}
      <div class="fl inpbox pl10"> 共有 <span class="c4">{{{$company_count}}}</span> 家中介公司 </div>
    </div>
    <!--列表单行 start-->
    <div class="zjgslb">
      <ul>
        @foreach ( $companies as $company)
        <li>
          <div class="a1">
          <a href="{{route('esf.company.show', $company->id)}}">
          <img src="{{{ Config::get('app.url') . $company->photo}}}">
          </a>
          <a href="{{route('esf.company.show', $company->id)}}">
          <span class="link_0969BD_12">进入店铺</span>
          </a>
          </div>
          <div class="a2">
          <span>公司名称：<a href="{{route('esf.company.show', $company->id)}}">{{{$company->gsmc}}}</a></span>
          <span>公司地址：<font style="color:#333;">{{{$company->lxdz}}}</font></span>
          <span>所在区域：<font style="color:#333;">瑶海区</font></span>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    <!--列表单行 end-->
    <!--列表 start-->
    <div class="clearfix mb30">
      {{ \lib\Tool::pagination( $companies ) }}
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