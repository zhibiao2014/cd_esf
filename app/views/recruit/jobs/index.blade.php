@extends('layouts.recruit')
@section('content')
<div class="zp_search_box">
  <h2>招聘搜索条件</h2>
  <div class="sub-tag mb30">
    <dl class="">
      <dt>类别：</dt>
      <dd>
        <ul class="seljobCate clearfix mb10">
          <li><a {{ ( !isset($p['job_type']) || empty($p['job_type']) ) ? 'class="select"' : '' }} href="{{ action('front\RecruitController@index', array_diff_key( $p, array( 'job_type' => 0 ) ) ) }}"><strong>全部</strong></a></li>
          @foreach ($job_types as $type)
          <li><a href="{{ action('front\RecruitController@index', array_merge( $p, array( 'job_type' => $type['id'] ) ) ) }}" {{ ( isset($p['job_type']) && $p['job_type'] == $type['id']) ? 'class="select"' : '' }}> {{{$type['name']}}} </a></li>
          @endforeach
        </ul>
      </dd>
    </dl>
    <dl>
      <dt>福利：</dt>
      <dd>
        <ul class="seljobWelfare clearfix mb10">
          <li><a {{ ( !isset($p['welfare']) || empty($p['welfare']) ) ? 'class="select"' : '' }} href="{{ action('front\RecruitController@index', array_diff_key( $p, array( 'welfare' => 0 ) ) ) }}"><strong>全部</strong></a></li>
          @foreach ($welfares as $value)
          <li><a href="{{ action('front\RecruitController@index', array_merge( $p, array( 'welfare' => $value['id'] ) ) ) }}" {{ ( isset($p['welfare']) && $p['welfare'] == $value['id']) ? 'class="select"' : '' }}> {{{$value['name']}}} </a></li>
          @endforeach
        </ul>
      </dd>
    </dl>
    <dl>
      <dt class="seljobMore">更多：</dt>
      <dd>
        <!--更多搜索条件 str-->
        <div class="moresearchinfo">

          <div id="list_C02_19" class="itemInfo sala_item">
            <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_towards')" onMouseMove="dvmouseover(this,'options_towards')" class="itemT"> {{empty($p['salary']) ? '薪资' : $salaries[$p['salary']]}} </div>
            <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_towards">
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_diff_key( $p, array('salary' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($p['salary']) || empty($p['salary']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
              @foreach ( $salaries as $key => $salary )
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_merge( $p, array('salary' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['salary']) && ($p['salary'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$salary}}}</a></li>
              @endforeach
            </ul>
          </div>


          <div class="itemInfo hire_item">
            <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_equipment')" onMouseMove="dvmouseover(this,'options_equipment')" class="itemT"> {{empty($p['education']) ? '学历' : $educations[$p['education']]}} </div>
            <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_equipment">
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_diff_key( $p, array('education' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($p['education']) || empty($p['education']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
              @foreach ( $educations as $key => $education )
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_merge( $p, array('education' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['education']) && ($p['education'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$education}}}</a></li>
              @endforeach
            </ul>
          </div>


          <?php
          $work_times = array( 1 => '一年以下', 2 => '1-2年', 3 => '3-5年', 4 => '6-7年', 5 => '8-10年', 6 => '10年以上' );
          ?>
          <div id="list_C02_20" class="itemInfo edu_item">
            <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_floor')" onMouseMove="dvmouseover(this,'options_floor')" class="itemT"> {{empty($p['work_times']) ? '工作经验' : $work_times[$p['work_times']]}} </div>
            <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_floor">
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_diff_key( $p, array('work_times' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( empty($p['work_times']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
              @foreach ( $work_times as $key => $value )
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_merge( $p, array('work_times' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['work_times']) && ($p['work_times'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$value}}}</a></li>
              @endforeach
            </ul>
          </div>


          <?php
          $days = array( '1' => '一天以内', '3' => '三天以内', '7' => '七天以内', '15' => '十五天以内', '30' => '一个月以内' );
          ?>
          <div id="list_C02_20" class="itemInfo ex_item">
            <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'fb_time')" onMouseMove="dvmouseover(this,'fb_time')" class="itemT"> {{empty($p['days']) ? '发布时间' : $days[$p['days']]}} </div>
            <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="fb_time">
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_diff_key( $p, array('days' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( empty($p['days']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
              @foreach ( $days as $key => $value )
              <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@index', array_merge( $p, array('days' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['days']) && ($p['days'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$value}}}</a></li>
              @endforeach
            </ul>
          </div>

          <div class="clear"></div>
        </div>
        <!--更多搜索条件 end-->
      </dd>
    </dl>
  </div>
</div>
<div class="subTab">
  <a class="tab01" id="zptab1">职位</a>
  <a class="tab02" id="zptab2" href="{{route('resume')}}">简历</a>
</div>
<!--左边招聘列表 sta-->
<div class="zp_list_tab fl">
  <div id="con_zptab_1">
    @foreach ( $job_posts as $value )
    <dl>
      <dt>
        <a href="{{ route( 'post.show', $value->id ) }}">{{{$value->title}}}</a>
      </dt>
      <dd class="w101"><a href="javascript:void(0)">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type]['name'] : '无' }}</a></dd>
      <dd class="w260">{{{ $value->address }}}</dd>
      <dd class="w101">{{ \lib\Tool::get_timeago( strtotime( $value->updated_at ) ) }}</dd>
      <dd class="w61"><a href="{{route('post.show', $value->id)}}" class="c20">查看详情</a></dd>
    </dl>
    @endforeach
  </div>
  <div class="pagination pr mb30">
    {{ \lib\Tool::pagination( $job_posts->appends($p) ) }}
  </div>
</div>
<!--左边招聘列表 end-->
<!--右边推广 sta-->
<div class="zp_r_box fr">
  <div class="zp_hot">
    <div class="title">
      <h2>推广</h2>
    </div>
    @if ( is_array($recommends_post) )
    <ul>
      @foreach ( $recommends_post as $post )
      <li onmouseout="$(this).css('background-color','');" onmouseover="$(this).css('background-color','#f9f9f9');">
        <a target="_blank" href="{{ route( 'post.show', $value->id ) }}">
          <h3>{{{$post['title']}}}</h3>
          <p>工作地址：{{{ $post['address'] }}}<br> 薪资：<b>{{{ isset($salaries[$post['salary']]) ? $salaries[$post['salary']] : '面议' }}}</b></p>
        </a>
      </li>
      @endforeach
    </ul>
    @endif
  </div>
</div>
<!--右边推广 end-->
@stop

@section('footer')

<script type="text/javascript">
  function dvmouseout(obj, ulid) {
    document.getElementById(ulid).style.display = 'none';
    obj.className = "itemT";
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
    obj.display = 'block';
  }

  function limouseover(obj) {
    if (obj.className != "ophover") {
      obj.display = 'none'
    }
  }
  function limouseout(obj) {
    if (obj.attributes["selected"] == "true") {
      obj.className = 'ophover';
    }
    else {
      if (obj.className != "ophover") {
        obj.className = '';
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