@extends('layouts.esf')
@section('content')
<!--二手房搜索 sta-->
<div class="guide mb10 pr">
  <a rel="nofollow" href="{{Config::get('app.url')}}"> 常德市房地产信息网 </a> &gt;
  <a href="{{route('esf.office.rent.index')}}"> 写字楼 </a> &gt;
  <a href="javascript:void(0);"> 出租 </a>
  <a target="_blank" href="{{route('rent_office.create')}}" class="btn-fabu pa">
    <img width="152" height="34" alt="发布出租" onmouseover="this.src='{{asset('assets/images/zf/but_cc_1.png')}}'" onmouseout="this.src='{{asset('assets/images/zf/but_cc_2.png')}}'" src="{{asset('assets/images/zf/but_cc_2.png')}}">
  </a>
</div>
<div class="tit_sea pr clear">
  <h2>高级搜索</h2>
</div>
<div class="un2_box w998 mr10" style="margin-top:-1px;">
  <div id="rentid_60" class="mt20 ml20">
    <form action="{{action('front\OfficeController@rent_lists')}}" method="get">
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
      <input type="text" placeholder="输入你想要查找的小区名称" value="{{{isset($p['keyword']) ? $p['keyword'] : '' }}}" class="input9" name="keyword">
      <input type="submit" class="btnSearch" value=" 搜 索 " />
    </form>
    <div class="clear"> </div>
  </div>
  <div class="sou_com w45li pr">
    <ul class="clearfix esf_ss_box pt10 pb10">
      <li class="clearfix">
        <strong class="s1">区域：</strong>
        <a href="{{action('front\OfficeController@rent_lists', array_diff_key( $p, array('region' => 0) ))}}"><span{{ ( !isset($p['region']) || empty($p['region']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ($regions as $region)
          @if ( $region['pid'] == 0 )
          <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('region' => $region['id']) ))}}"{{ ( isset($p['region']) && $p['region'] == $region['id']) ? ' class="cur"' : '' }}> {{{$region['name']}}} </a>
          @endif
          @endforeach
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">总价：</strong>
        <a href="{{action('front\OfficeController@rent_lists', array_diff_key( $p, array('price' => 0) ))}}"><span{{ ( !isset($p['price']) || empty($p['price']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $price as $value )
          <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('price' => $value->price) ))}}"{{ ( isset($p['price']) && $p['price'] == $value->price ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
          <input class="esf_textA" type="text" name="price[]" max="999999" min="0" value="{{ isset($p['price']) ? explode(',', $p['price'])[0] : '' }}" autocomplete="off">
          <span class="ml5 mr5">-</span>
          <input class="esf_textB" type="text" name="price[]" max="999999" min="0"  value="{{ isset($p['price']) && !empty($p['price']) ? explode(',', $p['price'])[1] : '' }}" autocomplete="off">
          <input class="iput_but1" id="price_filter" type="button" data-url="{{action('front\OfficeController@rent_lists')}}" data-query='{{json_encode($p)}}' value="价格筛选">
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">面积：</strong>
        <a href="{{action('front\OfficeController@rent_lists', array_diff_key( $p, array('area' => 0) ))}}"><span{{ ( !isset($p['area']) || empty($p['area']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $areas as $value )
          <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('area' => $value->area) ))}}"{{ ( isset($p['area']) && $p['area'] == $value->area ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">类型：</strong>
        <a href="{{action('front\OfficeController@rent_lists', array_diff_key( $p, array('type' => 0) ))}}"><span{{ ( !isset($p['type']) || empty($p['type']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $types as $value )
          <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('type' => $value->id) ))}}"{{ ( isset($p['type']) && $p['type'] == $value->id ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
        </div>
      </li>
    </ul>
    <!--更多找房条件 str-->
  </div>
</div>
<!--二手房搜索 end-->

<div class="clear mb10"></div>

<div class="w754 fl">
  <div class="tab_house clearfix">
    <a class="tab02" href="{{route('esf.office.index')}}"><span>写字楼出售</span></a>
    <a class="tab01" href="{{action('front\OfficeController@rent_lists')}}"><span>写字楼出租</span></a>
  </div>
  <div class="un2_box btno pr">
    {{$houses->appends($p)->links('structure.pagination-simple')}}
    <dl id="tips" class="titHouse updown">
      <dt id="rentid_111"> </dt>
      <dd id="rentid_64" class="black">
        <div class="fl ml10">排序：</div>
        <select name="s" id="sort_select" data-url="{{action('front\OfficeController@rent_lists', array_merge($p, array( 's' => '', 'page' => 1)))}}">
          <option value="refresh_at-desc"{{($sort[0] == 'refresh_at' && $sort[1] == 'desc') ? ' selected' : ''}}>默认排序</option>
          <option value="created_at-desc"{{($sort[0] == 'created_at' && $sort[1] == 'desc') ? ' selected' : ''}}>按发布时间排序</option>
          <option value="updated_at-desc"{{($sort[0] == 'updated_at' && $sort[1] == 'desc') ? ' selected' : ''}}>按更新时间排序</option>
          <option value="construction_area-asc"{{($sort[0] == 'construction_area' && $sort[1] == 'asc') ? ' selected' : ''}}>按面积从小到大排序</option>
          <option value="construction_area-desc"{{($sort[0] == 'construction_area' && $sort[1] == 'desc') ? ' selected' : ''}}>按面积从大到小排序</option>
          <option value="sprice-asc"{{($sort[0] == 'sprice' && $sort[1] == 'asc') ? ' selected' : ''}}>按单价从低到高排序</option>
          <option value="sprice-desc"{{($sort[0] == 'sprice' && $sort[1] == 'desc') ? ' selected' : ''}}>按单价从高到低排序</option>
          <option value="price-asc"{{($sort[0] == 'price' && $sort[1] == 'asc') ? ' selected' : ''}}>按总价从低到高排序</option>
          <option value="price-desc"{{($sort[0] == 'price' && $sort[1] == 'desc') ? ' selected' : ''}}>按总价从高到低排序</option>
        </select>
        @if ( isset($sort) && $sort[0] == 'price' && $sort[1] == 'desc' )
        <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('s' => array( 'price', 'asc' ) ) ))}}"><span class="rank2">总价</span> </a>
        @else
        <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('s' => array( 'price', 'desc' ) ) ))}}"><span class="rank1">总价</span></a>
        @endif
        @if ( isset($sort) && $sort[0] == 'construction_area' && $sort[1] == 'desc' )
        <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('s' => array( 'construction_area', 'asc' ) ) ))}}"><span class="rank2">面积</span> </a>
        @else
        <a href="{{action('front\OfficeController@rent_lists', array_merge( $p, array('s' => array( 'construction_area', 'desc' ) ) ))}}"><span class="rank1">面积</span></a>
        @endif
      </dd>
    </dl>
    <!--列表 start-->
    @foreach ( $houses as $house )
    <?php
    $room_structure = json_decode( $house->room_structure, true );
    $house->tag = empty($house->tag) ? NULL : json_decode( $house->tag, true );
    $room_images = json_decode( $house->room_images, true );
    $i = 1;
    ?>
    @if ( !$house['is_broker'] )
    <div class="fclist clearfix">
      <a title="{{{$house->community_name}}}" target="_blank" href="{{route('esf.rent_office.show', array('id' => $house->id))}}" class="pic_k"><span class="I_more_pic">{{{count($room_images)}}} 图</span><img alt="{{{$house->community_name}}}" src="{{empty($house->thumbnail) ? asset('assets/images/esf/moren.jpg') : $house->thumbnail}}"></a>
      <ul class="centxt">
        <li>
          <div class="fr"><span class="c11">{{{$house->price}}}</span> 元/月 </div>
          <a href="{{route('esf.rent_office.show', array('id' => $house->id))}}" target="_blank" class="t3"> {{{$house->title}}}
            {{{ $house['type_id'] ? $types[$house['type_id']]->name : ''}}} {{{$house->construction_area}}}㎡
          </a>
        </li>
        <li>
          <div class="fr">
            <span>({{{$house->construction_area}}}㎡)</span>
          </div>
          @if ( !empty($house->tag) )
          @foreach ( $tags as $tag )
          @if ( in_array( $tag->id, $house->tag ) )
          <span class="label_fang g_tagSon{{$i++}}">{{{$tag->name}}}</span>
          @endif
          @endforeach
          @endif

          <?php $customer_tag = json_decode($house->customer_tag, true); ?>
          @if ( !empty( $customer_tag ) )
          @foreach ( $customer_tag as $value )
          <span class="label_fang g_tagSon{{($i++%4)+1}}">{{{$value}}}</span>
          @endforeach
          @endif

        </li>
        <li>
          <div class="fr">
            @if ( $house->is_commissioned )
            <span class="benwangrenzhen"></span>
            @elseif ( $house->is_individual && $house->is_admin )
            <span class="gerenrenzhen"></span>
            @endif
          </div>
          <a href="http://www.0736fdc.com/house/view/{{{$house->community_id}}}.html" target="_blank" title="{{{$house->community_name}}}"><span>{{{$house->community_name}}}</span></a> <span class="iconAdress ml10">{{{$regions[$house->area_id]['name']}}} - {{{$house->address}}}</span>
        </li>
        <li>
          <div class="fr"><span class="c2">{{{ '刷新时间: ' . \lib\Tool::get_timeago( strtotime( $house->refresh_at ) ) }}}</span></div>
          {{{$room_structure['room']}}}室{{{$room_structure['hall']}}}厅{{{$room_structure['bathroom']}}}卫 <span class="ml5 mr5">/</span> {{empty($house->decoration_id) ? '' : $decorations[$house->decoration_id]['name'] . ' <span class="ml5 mr5">/</span> ' }}{{empty($house->direction_id) ? '' : $directions[$house->direction_id]['name'] . ' <span class="ml5 mr5">/</span> '}}{{{ date( 'm-d', strtotime( $house->created_at ) ) }}}
        </li>
      </ul>
    </div>
    @else
    <div class="fclist clearfix">
      <a title="{{{$house->community_name}}}" target="_blank" href="{{route('esf.rent_office.show', array('id' => $house->id))}}" class="pic_k"><span class="I_more_pic">{{{count($room_images)}}} 图</span><span class="mianshuiPic"></span><img alt="{{{$house->community_name}}}" src="{{empty($house->thumbnail) ? asset('assets/images/esf/moren.jpg') : $house->thumbnail}}"></a>
      <ul class="centxt4">
        <li> <a href="{{route('esf.rent_office.show', array('id' => $house->id))}}" target="_blank" class="t3"> {{{$house->title}}} </a> </li>
        <li>
          <a href="http://www.0736fdc.com/house/view/{{{$house->community_id}}}.html">{{{$house->community_name}}}</a>
          <span class="iconAdress ml10">{{{$house->address}}}</span>
        </li>
        <li>
          {{{$room_structure['room']}}}室{{{$room_structure['hall']}}}厅{{{$room_structure['bathroom']}}}卫，{{{ceil($house->price * 10000 /$house->construction_area)}}}元/平米，{{{ empty($house->direction_id) ? '' : $directions[$house->direction_id]['name'] }}}
        </li>
        <li>
          <span class="c2"> {{{ '刷新时间: ' . \lib\Tool::get_timeago( strtotime( $house->refresh_at ) ) }}}</span>
        </li>
      </ul>
      <div class="E_area2">
        <p class="mb10">{{{$house->construction_area}}}平米</p>
        @if ( !empty($house->tag) )
        @foreach ( $tags as $tag )
        @if ( in_array( $tag->id, $house->tag ) )
        <p><span class="label_fang g_tagSon{{$i++}}">{{{$tag->name}}}</span></p>
        @endif
        @endforeach
        @endif
      </div>
      <div class="E_money"><span class="c11">{{{$house->price}}}<span class="f12">万元</span></span></div>
    </div>
    @endif

    @endforeach
    <div class="clearfix mb30">
      {{ \lib\Tool::pagination( $houses->appends($p) ) }}
    </div>
    <!--列表 end-->
  </div>
</div>

<!-- sidebar -->
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
        <a target="_blank" href="{{{route('office.create')}}}"> 我要出售 </a>
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
          <a title="{{{$value->community_name}}}" href="{{route('esf.rent_office.show', array('id' => $value->id))}}"><img alt="{{{$value->community_name}}}" src="{{empty($value->thumbnail) ? asset('assets/images/esf/moren.jpg') : $value->thumbnail}}"></a>
        </dt>
        <dd>
          <h3 class="t4"> <a href="{{route('esf.rent_office.show', array('id' => $value->id))}}">{{{$value->title}}}</a> </h3>
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
@section('footer')
<script type="text/javascript">
</script>
@stop