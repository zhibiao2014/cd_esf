@extends('layouts.recruit')
@section('header')
<link href="<?php echo asset("assets/css/user/login.css"); ?>" rel="stylesheet" type="text/css" />
@stop
@section('content')
<!--简历信息-->
<div class="jL_info">
  <h1>
    <span class="name">{{{$resume->name}}}</span><span class="f16">（{{ $resume->sex == 1 ? '男' : '女' }}，{{ date("Y") - date( "Y", strtotime( $resume->birthday ) ) }}岁）</span> <i class="I-phone-2"></i><span class="f12 fn">手机已认证</span>
    <p class="gxtim">
      <span class="time"><span class="f-f30 fb"></span>{{ $resume->updated_at }}更新</span>
      <!-- <span class="dataInfo">
        <span class="pr5">两周内：投递<span id="deliverycount" class="c1 fb">9</span>次</span>
        <span class="pr5">被下载<span id="downcount" class="c1 fb">2</span>次</span>
      </span> -->
    </p>
  </h1>
  <div class="expectTitle">
    <h2>{{ isset( $job_types[$resume->job_type] ) ? $job_types[$resume->job_type] : '无' }}</h2>
    <ul class="expectDetail">
      <li>{{ isset( $educations[$resume->education] ) ?  $educations[$resume->education] : '无' }}</li>
      <li class="divide">|</li>
      <li> {{$resume->work_time}}年工作经验 </li>
      <li class="divide">|</li>
      <li>现居{{{$resume->living_place}}}</li>
      <li class="divide">|</li>
      <li>{{{$resume->birth_place}}}人</li>
      <!-- class="br0" -->
    </ul>
    <ul class="expectDetail">
      <li class="pl0">{{ isset( $job_types[$resume->job_type] ) ? '求职' . $job_types[$resume->job_type] : '' }}</li>
      <li class="divide">|</li>
      <li>想在 {{{$resume->work_place}}} 工作 </li>
      <li class="divide">|</li>
      <li class="br0"> 期望薪资 {{ isset( $salaries[$resume->money] ) ? $salaries[$resume->money] . '/月' : '面议' }} </li>
    </ul>
  </div>
  <div class="intrCon">
    {{ nl2br( strip_tags( $resume->self_introduce ) ) }}
  </div>
  <!--调用个人亮点-->
  @if (is_array($resume['tags']))
  <div class="ability-con clearfix mb20">
    <ul>
      @foreach ($resume['tags'] as $key => $tag)
      <li>
        <div class="green"><i></i><span>{{{$tag}}}</span></div>
      </li>
      @endforeach
    </ul>
  </div>
  @endif
  <!--工作经验-->
  <div class="postContent">
    @if( is_array($work_experiences) && !empty( $work_experiences ) )
    <h3> <span>工作经验</span> </h3>
    @foreach( $work_experiences as $value )
    <div class="showList">
      <p class="detailList"><span>{{{$value['entry_date']}}}-{{{$value['entry_date']}}}</span><span class="divide">|</span><span>{{{$value['corporation_name']}}}</span><span class="divide">|</span><span>{{ isset( $job_types[$value['job_type']] ) ? $job_types[$value['job_type']] : '' }}</span><span class="divide">|</span><span>{{{$value['salary']}}}元/月</span></p>
      <p class="detailCon"><span class="title">工作内容：</span><span>{{{$value['content']}}}</span>
      </p>
    </div>
    @endforeach
    @endif

    @if( is_array($education_experiences) && !empty( $education_experiences ) )
    <h3><span>教育经历</span></h3>
    <div class="showDiv">
      @foreach( $education_experiences as $value )
      <div class="showList">
        <p class="detailList"><span>{{{$value['entry_date']}}}-{{{$value['entry_date']}}}</span><span class="divide">|</span><span>{{{$value['school_name']}}}</span><span class="divide">|</span><span>{{{$value['major']}}}</span></p>
      </div>
      @endforeach
    </div>
    @endif


    @if ( is_array( $resume['images'] ) && !empty( $resume['images'] ) )
    <h3> <span>照片/作品</span></h3>
    <div class="showDiv pl20 mt10">
      <div class="schoolDetail">
        <ul class="myphoto clearfix" id="ulpics">
          @foreach ($resume['images'] as $key => $image)
          <li><img src="{{{$image['url']}}}"></li>
          @endforeach
        </ul>
      </div>
    </div>
    @endif

    <h3><span>特别说明</span></h3>
    <div class="pl20 mt10">
      <p>{{ nl2br( strip_tags( $resume->content ) ) }}</p>
    </div>
    <!-- <div>
      @if ( \Auth::check() )
      <a class="int_b" href="{{ route( 'resume.invite', array( 'id' => $resume->id ) ) }}">邀请面试</a>
      @else
      <a class="int_b" href="{{'http://www.0736fdc.com/user/login.html?redirect=' . urlencode(\Request::url())}}">邀请面试</a>
      @endif
    </div> -->
  </div>
</div>
<div class="zp_list_tab" style="width:100%;">
  <h3 class="bgh3 pl10">向您推荐的优质简历</h3>
  <div id="con_zptab_2">
    @foreach ( $recommend_resumes as $value )
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
      <dd class="w120">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type] : '无' }}</dd>
      <dd class="w80">{{ \lib\Tool::get_timeago( strtotime( $value->updated_at ) ) }}</dd>
      <!-- <dd class="w50"><a href="#" class="c20">下载</a></dd> -->
    </dl>
    @endforeach
  </div>
</div>

@stop
@section('footer')
@stop