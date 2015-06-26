@extends('layouts.esf')
@section('content')
<!--二手房搜索 sta-->
<div class="guide mb10 pr">
  <a rel="nofollow" href="{{Config::get('app.url')}}"> 常德市房地产信息网 </a> &gt;
  <a href="{{route('house.index')}}"> 二手房 </a> &gt;
  <a href="javascript:void(0);"> 全部房源 </a>
  <a target="_blank" href="{{route('house.create')}}" class="btn-fabu pa">
    <img width="152" height="34" alt="发布出租" onmouseover="this.src='{{asset('assets/images/zf/but_cc_1.png')}}'" onmouseout="this.src='{{asset('assets/images/zf/but_cc_2.png')}}'" src="{{asset('assets/images/zf/but_cc_2.png')}}">
  </a>
</div>
<div class="tit_sea pr clear">
  <h2>高级搜索</h2>
</div>
<div class="un2_box w998 mr10" style="margin-top:-1px;">
  <div id="rentid_60" class="mt20 ml20">
    <form action="{{action('front\HouseController@lists')}}" method="get">
      @foreach ( $s as $key => $value )
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
      <input type="text" placeholder="输入你想要查找的小区名称" id="mykeyword" class="input9" name="keyword">
      <input type="submit" class="btnSearch" value=" 搜 索 " />
    </form>
    <div class="clear"> </div>
  </div>
  <div class="sou_com w45li pr">
    <ul class="clearfix esf_ss_box pt10 pb10">
      <li class="clearfix">
        <strong class="s1">区域：</strong>
        <a href="{{action('front\HouseController@lists', array_merge( $s, array('region' => 0) ))}}"><span{{ ( !isset($s['region']) || empty($s['region']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ($regions as $region)
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('region' => $region->id) ))}}"{{ ( isset($s['region']) && $s['region'] == $region->id) ? ' class="cur"' : '' }}> {{{$region->name}}} </a>
          @endforeach
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">总价：</strong>
        <a href="{{action('front\HouseController@lists', array_merge( $s, array('price' => 0) ))}}"><span{{ ( !isset($s['price']) || empty($s['price']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $price as $value )
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('price' => $value->price) ))}}"{{ ( isset($s['price']) && $s['price'] == $value->price ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
          <input class="esf_textB" type="text" name="price[]" max="999999" min="0" value="{{ isset($s['price']) ? explode(',', $s['price'])[0] : '' }}" autocomplete="off">
          <span class="ml5 mr5">-</span>
          <input class="esf_textB" type="text" name="price[]" max="999999" min="0"  value="{{ isset($s['price']) && !empty($s['price']) ? explode(',', $s['price'])[1] : '' }}" autocomplete="off">
          <input class="iput_but1" type="button" data-url="{{action('front\HouseController@lists', $s)}}" value="价格筛选">
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">户型：</strong>
        <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 0) ))}}"><span{{ ( !isset($s['room']) || empty($s['room']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 1, 'room_compare' => '=' ) ))}}"{{ ( isset($s['room']) && $s['room'] == 1) ? ' class="cur"' : '' }}> 一室 </a>
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 2, 'room_compare' => '=' ) ))}}"{{ ( isset($s['room']) && $s['room'] == 2) ? ' class="cur"' : '' }}> 二室 </a>
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 3, 'room_compare' => '=' ) ))}}"{{ ( isset($s['room']) && $s['room'] == 3) ? ' class="cur"' : '' }}> 三室 </a>
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 4, 'room_compare' => '=' ) ))}}"{{ ( isset($s['room']) && $s['room'] == 4) ? ' class="cur"' : '' }}> 四室 </a>
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('room' => 5, 'room_compare' => '>=' ) ))}}"{{ ( isset($s['room']) && $s['room'] == 5) ? ' class="cur"' : '' }}> 四室以上 </a>
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">面积：</strong>
        <a href="{{action('front\HouseController@lists', array_merge( $s, array('area' => 0) ))}}"><span{{ ( !isset($s['area']) || empty($s['area']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $areas as $value )
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('area' => $value->area) ))}}"{{ ( isset($s['area']) && $s['area'] == $value->area ) ? ' class="cur"' : '' }}> {{{$value->name}}} </a>
          @endforeach
        </div>
      </li>
      <li class="clearfix">
        <strong class="s1">特色：</strong>
        <a href="{{action('front\HouseController@lists', array_merge( $s, array('tag' => 0) ))}}"><span{{ ( !isset($s['tag']) || empty($s['tag']) ) ? ' class="s2 cur"' : ' class="s2"' }}>不限</span></a>
        <div class="s3">
          @foreach ( $tags as $tag )
          <a href="{{action('front\HouseController@lists', array_merge( $s, array('tag' => $tag->id) ))}}"{{ ( isset($s['tag']) && $s['tag'] == $tag->id) ? ' class="cur"' : '' }}> {{{$tag->name}}} </a>
          @endforeach
        </div>
      </li>
    </ul>
    <!--更多找房条件 str-->
    <div class="moresearchinfo">
      <span class="fl mr10 mt5">更多找房条件：</span>
      <div class="mr10 fl">
        <div id="list_C02_19" class="selectbox">
          <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_towards')" onMouseMove="dvmouseover(this,'options_towards')" class="tag_select"> {{empty($s['direction']) ? '朝向' : $s['directions'][$s['direction']]}} </div>
          <ul style="position: absolute; z-index: 999; display: none;" class="tag_options" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_towards">
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('direction' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($s['direction']) || empty($s['direction']) ) ? 'open_selected' : 'open' }}"> 不限 </li>
            @foreach ( $directions as $direction )
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('direction' => $direction->id) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($s['direction']) && ($s['direction'] == $direction->id) ) ? 'open_selected' : 'open' }}">{{{$direction->name}}}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="mr10 fl">
        <div id="list_C02_20" class="selectbox">
          <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_floor')" onMouseMove="dvmouseover(this,'options_floor')" class="tag_select"> {{empty($s['floor']) ? '楼层' : $s['directions'][$s['direction']]}} </div>
          <ul style="position: absolute; z-index: 999; display: none;" class="tag_options" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_floor">
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( empty($s['floor']) ) ? 'open_selected' : 'open' }}"> 不限 </li>
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => 0, 'floor_compare' => '<' ) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="open"> 地下</li>
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => 1, 'floor_compare' => '=' ) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="open"> 1层</li>
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => '1,6', 'floor_compare' => 'in' ) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="open"> 6层以下</li>
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => '6,12', 'floor_compare' => 'in' ) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="open"> 6-12层</li>
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('floor' => '12', 'floor_compare' => '>' ) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="open"> 12层以上</li>
          </ul>
        </div>
      </div>
      <div class="mr10 fl">
        <div class="selectbox">
          <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_equipment')" onMouseMove="dvmouseover(this,'options_equipment')" class="tag_select"> {{empty($s['decoration']) ? '装修' : $decorations[$s['decoration']]['name']}} </div>
          <ul style="position: absolute; z-index: 999; display: none;" class="tag_options" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_equipment">
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('decoration' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($s['decoration']) || empty($s['decoration']) ) ? 'open_selected' : 'open' }}"> 不限 </li>
            @foreach ( $decorations as $decoration )
            <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\HouseController@lists', array_merge( $s, array('decoration' => $decoration->id) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($s['decoration']) && ($s['decoration'] == $decoration->id) ) ? 'open_selected' : 'open' }}">{{{$decoration->name}}}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div>
        <div onMouseOut="document.getElementById('morePt').style.display='none';" onMouseMove="document.getElementById('morePt').style.display= 'block';" id="dv_hset" class="Pt fl pr">
          配套
          <dl class="morePt blue" id="morePt" style="display: none;" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)">
            <form action="{{action('front\HouseController@lists')}}" method="get">
              @foreach ( $s as $key => $value )
              @if ( $key != 'supporting')
              <input type="hidden" name="{{$key}}" value="{{$value}}" />
              @endif
              @endforeach
              @foreach ( $house_supportings as $supporting )
              <dd>
                <input type="checkbox" value="{{$supporting->id}}" {{ isset($s['supporting']) && in_array( $supporting->id, $s['supporting'] ) ? "checked" : ""}} name="supporting[]">
                {{$supporting->name}}
              </dd>
              @endforeach
              <dt>
                <input type="submit" value="确定">
              </dt>
              <div class="clear"></div>
            </form>
          </dl>
        </div>
      </div>
      <div class="clear"> </div>
    </div>
    <!--更多找房条件 end-->
  </div>
</div>
<!--二手房搜索 end-->

<div class="clear mb10"></div>

<div class="w754 fl">
  <div class="tab_house clearfix">
    <a class="tab01" href="{{url('house/list')}}"><span>全部房源</span></a>
    <a class="tab02" href="{{action('front\HouseController@lists',array('is_individual' => 1))}}"><span>个人房源</span></a>
    <a class="tab02" href="{{action('front\HouseController@lists',array('is_broker' => 1))}}"><span>中介房源</span></a>
    <a class="tab02" href="{{action('front\HouseController@lists',array('is_commissioned' => 1))}}"><span>本网房源</span></a>
  </div>
  <div class="un2_box btno pr">
    {{$houses->appends($s)->links('structure.pagination-simple')}}
    <dl id="tips" class="titHouse updown">
      <dt id="rentid_111"> </dt>
      <dd id="rentid_64" class="black">
        <div class="fl ml10">排序：</div>
        <select name="" class="xList">
          <option>默认排序</option>
          <option>按发布时间排序</option>
          <option>按更新时间排序</option>
          <option>按面积从小到大排序</option>
          <option>按面积从大到小排序</option>
          <option>按单价从低到高排序</option>
          <option>按单价从高到低排序</option>
          <option>按总价从低到高排序</option>
          <option>按总价从高到低排序</option>
          <option>按面积从小到大排序</option>
        </select>
        <a href="/esfhouse-g04/" id="list_52"> <span id="pricehigh">总价</span> </a>
        <!--默认无样式 点击第一次 class="rank2" 点击第二次 class="rank3"-->
        <a href="/esfhouse-g08/" id="list_53"> <span id="sortsort">面积</span> </a>
        <!--默认无样式 点击第一次 class="rank2" 点击第二次 class="rank3"-->
        <a href="/esfhouse-g010/" id="list_54"> <span id="spricesort">单价</span> </a>
        <!--默认无样式 点击第一次 class="rank2" 点击第二次 class="rank3"-->
        <a href="/esfhouse-g016/" id="list_55"> <span class="rank4" id="timesort">发布时间</span> </a>
      </dd>
    </dl>
    <!--列表 start-->
    @foreach ( $houses as $house )
    <?php
      $room_structure = json_decode( $house->room_structure, true );
      $house->tag = json_decode( $house->tag, true );
      $i = 1;
    ?>
    <div class="fclist clearfix">
      <a title="公园世家" target="_blank" href="{{url()}}" class="pic_k"><span class="I_more_pic">7 图</span><img alt="公园世家" src="{{empty($house->thumbnail) ? asset('assets/images/esf/moren.jpg') : $house->thumbnail}}"></a>
      <ul class="centxt">
        <li>
          <div class="fr"><span class="c11">{{{$house->price}}}</span> 万 <span class="ml10">{{{ceil($house->price * 10000 /$house->construction_area)}}}元/㎡</span></div>
          <a href="{{route('house.show', array('id' => $house->id))}}" target="_blank" class="t3"> {{{$house->title}}} {{{$room_structure['room']}}}室{{{$room_structure['hall']}}}厅{{{$room_structure['bathroom']}}}卫 {{{$house->construction_area}}}㎡ {{{ empty($house->customer_tag) ? "" : implode(' ', json_decode($house->customer_tag, true))}}} </a>
        </li>
        <li>
          <div class="fr"><span>{{{$room_structure['room']}}}室{{{$room_structure['hall']}}}厅{{{$room_structure['bathroom']}}}卫({{{$house->construction_area}}}㎡) </span></div>
          @foreach ( $tags as $tag )
          @if ( in_array( $tag->id, $house->tag ) )
          <span class="label_fang g_tagSon{{$i++}}">{{{$tag->name}}}</span>
          @endif
          @endforeach
        </li>
        <li>
          <div class="fr"><span class="benwangrenzhen"></span></div>
          <a href="#" target="_blank" title="泓鑫城市花园"><span>泓鑫城市花园</span></a> <span class="iconAdress ml10">鼎城 - 桥南市场斜对面</span>
        </li>
        <li>
          <div class="fr"><span class="c2">58分前</span></div>
          商品房 <span class="ml5 mr5">/</span> 房龄6年 <span class="ml5 mr5">/</span> 3/6层 <span class="ml5 mr5">/</span> 3室2厅1卫 <span class="ml5 mr5">/</span> 中等装修 <span class="ml5 mr5">/</span> 朝南北 / 07-23
        </li>
      </ul>
    </div>
    @endforeach
    <div class="clearfix mb30">
      {{ \lib\Tool::pagination( $houses->appends($s) ) }}
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
        常德今天已有<span class="c6">1</span>人发布了出售房源
      </p>
      <div class="weituo_btn"> <a target="_blank" href="#"> 我要出售 </a> <a target="_blank" href="#"> 管理房源 </a> </div>
      <div class="mt5 tc c1"> <a target="_blank" href="#"> 修改 / 删除个人房源&gt;&gt; </a> </div>
    </div>
  </div>
  <div class="clear mb10"></div>
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">推荐房源</h4>
    </div>
    <div class="RecommendListings">
      <dl class="clearfix">
        <dt> <a href="#"> <img src="{{asset('assets/images/esf/moren.jpg')}}" alt="公园世家"> </a> </dt>
        <dd>
          <h3 class="t4"> <a href="#"> 大润发附近精装出租 </a> </h3>
          <p> <span>162.00㎡</span> <span>4室2厅2卫</span> <span>￥48万</span> <span>团圆路梓山苑小区</span> <span class="c2">3天前</span></p>
        </dd>
      </dl>
      <dl class="clearfix">
        <dt> <a href="#"> <img src="{{asset('assets/images/esf/moren.jpg')}}" alt="公园世家"> </a> </dt>
        <dd>
          <h3 class="t4"> <a href="#"> 大润发附近精装出租 </a> </h3>
          <p> <span>162.00㎡</span> <span>4室2厅2卫</span> <span>￥48万</span> <span>团圆路梓山苑小区</span> <span class="c2">3天前</span></p>
        </dd>
      </dl>
      <dl class="clearfix no">
        <dt> <a href="#"> <img src="{{asset('assets/images/esf/moren.jpg')}}" alt="公园世家"> </a> </dt>
        <dd>
          <h3 class="t4"> <a href="#"> 大润发附近精装出租 </a> </h3>
          <p> <span>162.00㎡</span> <span>4室2厅2卫</span> <span>￥48万</span> <span>团圆路梓山苑小区</span> <span class="c2">3天前</span></p>
        </dd>
      </dl>
    </div>
  </div>
  <div class="clear mb10"></div>
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">意见反馈</h4>
    </div>
    <ul class="p10">
      <li>
        <p class="c2 mb5">如果您在使用中遇到什么问题，或者对我们有什么建议，请按下面的格式填写后发给我们，我们将尽快修复和完善网站，感谢您对我们的支持和关注！</p>
      </li>
      <li><span class="c1">* </span>Email：
        <input type="text" style="width:150px; border:1px solid #ccc;" id="fbEmail">
      </li>
      <li style="display:none;margin-left:55px;" class="c1" id="errEmail">请输入邮箱地址</li>
      <li style="margin-top:5px;"><span class="c1">* </span>意 见：
        <textarea onblur="if(this.value=='')this.value='用的还满意吗？我来说几句！'" onfocus="if(this.value=='用的还满意吗？我来说几句！')this.value=''" id="fbComment" style="width:150px;height:60px;overflow:hidden;color:#666666;vertical-align:top;">用的还满意吗？我来说几句！</textarea>
      </li>
      <li style="display:none;margin-left:55px;" class="c1" id="errComment">请输入您的宝贵意见</li>
      <li style="margin: 10px 0pt 0pt 55px;">
        <input type="submit" />
      </li>
    </ul>
  </div>
</div>
<div class="clear mb10"></div>
@stop
@section('footer')
<script type="text/javascript">
  function dvmouseout(obj, ulid) {
    document.getElementById(ulid).style.display = 'none';
    obj.className = "tag_select";
  }
  function LocationHrefReplace(url) {
    if (navigator.userAgent.indexOf("MSIE") > 0) {
      var referLink = document.createElement('a');
      referLink.href = url;
      document.body.appendChild(referLink);
      referLink.click();
    } else {
      window.location.replace(url);
    }
  }
  function dvmouseover(obj, ulid) {
    document.getElementById(ulid).style.display = '';
    obj.className = "tag_select_hover";
  }

  function limouseover(obj) {
    if (obj.className != "open_selected") {
      obj.className = 'open_hover';
    }
  }
  function limouseout(obj) {
    if (obj.attributes["selected"] == "true") {
      obj.className = 'open_selected';
    }
    else {
      if (obj.className != "open_selected") {
        obj.className = 'open';
      }
    }
  }
  var timeout;
  function hiddenPt(dl) {
    var citychange = document.getElementById(dl.id);
    citychange.style.display = "none";
    timeout = setTimeout("hiddenPt", 100)
  }
  function showPt(dl) {
    var citychange = document.getElementById(dl.id);
    window.clearTimeout(timeout);
    citychange.style.display = "block";
  }
</script>
@stop