@extends('layouts.recruit')
@section('content')
<div class="zp_search_box">
  <h2>招聘搜索条件</h2>
  <div class="sub-tag mb30">
    <dl class="">
      <dt>类别：</dt>
      <dd>
        <ul class="seljobCate clearfix mb10">
          <li><a {{ ( !isset($p['job_type']) || empty($p['job_type']) ) ? 'class="select"' : '' }} href="{{ action('front\RecruitController@resume', array_diff_key( $p, array( 'job_type' => 0 ) ) ) }}"><strong>全部</strong></a></li>
          @foreach ($job_types as $type)
          <li><a href="{{ action('front\RecruitController@resume', array_merge( $p, array( 'job_type' => $type['id'] ) ) ) }}" {{ ( isset($p['job_type']) && $p['job_type'] == $type['id']) ? 'class="select"' : '' }}> {{{$type['name']}}} </a></li>
          @endforeach
        </ul>
      </dd>
      <dd>
        <ul class="seljobCate clearfix mb10">
          <li><a {{ ( !isset($p['work_place']) || empty($p['work_place']) ) ? 'class="select"' : '' }} href="{{ action('front\RecruitController@resume', array_diff_key( $p, array( 'work_place' => 0 ) ) ) }}"><strong>全部</strong></a></li>
          @foreach ($work_places as $value)
          <li><a href="{{ action('front\RecruitController@resume', array_merge( $p, array( 'work_place' => $value ) ) ) }}" {{ ( isset($p['work_place']) && $p['work_place'] == $value) ? 'class="select"' : '' }}> {{{$value}}} </a></li>
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
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_diff_key( $p, array('salary' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($p['salary']) || empty($p['salary']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
                @foreach ( $salaries as $key => $salary )
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_merge( $p, array('salary' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['salary']) && ($p['salary'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$salary}}}</a></li>
                @endforeach
              </ul>
            </div>


            <div class="itemInfo hire_item">
              <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_equipment')" onMouseMove="dvmouseover(this,'options_equipment')" class="itemT"> {{empty($p['education']) ? '学历' : $educations[$p['education']]}} </div>
              <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_equipment">
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_diff_key( $p, array('education' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( !isset($p['education']) || empty($p['education']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
                @foreach ( $educations as $key => $education )
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_merge( $p, array('education' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['education']) && ($p['education'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$education}}}</a></li>
                @endforeach
              </ul>
            </div>

            <div id="list_C02_20" class="itemInfo edu_item">
              <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_work')" onMouseMove="dvmouseover(this,'options_work')" class="itemT"> {{empty($p['work_times']) ? '工作经验' : $work_times[$p['work_times']]}} </div>
              <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_work">
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_diff_key( $p, array('work_times' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( empty($p['work_times']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
                @foreach ( $work_times as $key => $value )
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_merge( $p, array('work_times' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['work_times']) && ($p['work_times'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$value}}}</a></li>
                @endforeach
              </ul>
            </div>

            <?php
            $days = array( '1' => '一天以内', '3' => '三天以内', '7' => '七天以内', '15' => '十五天以内', '30' => '一个月以内' );
            ?>
            <div id="list_C02_20" class="itemInfo ex_item">
              <div style="cursor: pointer;" onMouseOut="dvmouseout(this,'options_floor')" onMouseMove="dvmouseover(this,'options_floor')" class="itemT"> {{empty($p['days']) ? '发布时间' : $days[$p['days']]}} </div>
              <ul style="position: absolute; z-index: 999; display: none;" class="salalist" onMouseOver="showPt(this)" onMouseOut="hiddenPt(this)" id="options_floor">
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_diff_key( $p, array('days' => 0) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( empty($p['days']) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)"> 不限 </a></li>
                @foreach ( $days as $key => $value )
                <li style="cursor: pointer;" onClick="LocationHrefReplace('{{action('front\RecruitController@resume', array_merge( $p, array('days' => $key) ))}}')" onMouseOut="limouseout(this)" onMouseMove="limouseover(this)" class="{{ ( isset($p['days']) && ($p['days'] == $key) ) ? 'ophover' : 'open' }}"><a href="javascript:void(0)">{{{$value}}}</a></li>
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
  <a class="tab02" href="{{route( 'recruit' )}}">职位</a>
  <a class="tab01" href="javascript:void(0);">简历</a>
</div>
<!--左边招聘列表 sta-->
<div class="zp_list_tab fl">
  <div id="con_zptab_1">
    @foreach ( $resumes as $value )
    <dl>
      <dt>
      <a href="{{route('resume.show', $value->id)}}">{{{$value->title}}}</a>
      @if ( count( json_decode( $value->images ) ) > 0 )
      <span class="tu c6 f12">[{{count( json_decode( $value->images ) )}}图]</span>
      @endif
      </dt>
      <dd class="w80">{{{$value->name}}}</dd>
      <dd class="w30">{{ $value->sex == 1 ? '男' : '女' }}</dd>
      <dd class="w50">{{ date("Y") - date( "Y", strtotime( $value->birthday ) ) }}岁</dd>
      <dd class="w50">{{{$value->work_time}}}年</dd>
      <dd class="w50">{{ isset( $educations[$value->education] ) ?  $educations[$value->education] : '无' }}</dd>
      <dd class="w120">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type]['name'] : '无' }}</dd>
      <dd class="w80">{{ \lib\Tool::get_timeago( strtotime( $value->updated_at ) ) }}</dd>
      <!-- <dd class="w50"><a href="#" class="c20">下载</a></dd> -->
    </dl>
    @endforeach
  </div>
  <div class="pagination pr mb30">
    {{ \lib\Tool::pagination( $resumes->appends($p) ) }}
  </div>
</div>
<!--左边招聘列表 end-->
<!--右边推广 sta-->
<div class="zp_r_box fr">
  <div class="zp_hot">
    <div class="title">
      <h2>推广</h2>
    </div>
    @if ( is_array($recommend_resumes) )
    <ul>
      @foreach ( $recommend_resumes as $post )
      <li onmouseout="$(this).css('background-color','');" onmouseover="$(this).css('background-color','#f9f9f9');">
        <a target="_blank" href="{{route('resume.show', $post['id'])}}">
          <h3>{{{$post['title']}}}</h3>
          <p>工作区域：{{{ $post['work_place'] }}}<br> 薪资：<b>{{{ isset($salaries[$post['money']]) ? $salaries[$post['money']] : '面议' }}}/月</b></p>
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