@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  <div class="clearfix top_info mb20">
    <div class="info1">
      <span class="tx">
        <img src="{{empty($user->photo) ? 'http://www.0736fdc.com/public/images/moren.png' : 'http://www.0736fdc.com' . $user->photo}}" />
      </span>
      <a href="http://www.0736fdc.com/user/account/base.html" class="c2">修改图像</a>
    </div>
    <div class="info2">
      <ul>
        <li><span class="I-title">用  户 名：</span><span class="f14 fb">{{{$user->user_name}}}</span></li>
        <li><span class="I-title">注册时间：</span><span class="c5">{{date('Y-m-d', strtotime($user->regtime))}}</span></li>
        <li>
          <span class="I-title">认证信息：</span>
          <span class="mr10">
            @if ($user->mobileflag)
            <i class="I-phone-2"></i>
            <a href="javascript:void(0);">手机已认证</a>
            @else
            <i class="I-phone-1"></i>
            <a href="http://www.0736fdc.com/user/safecenter/mobile.html">手机未认证</a>
            @endif
          </span>
          <span class="mr10">
            @if ($user->mailflag)
            <i class="I-email-2"></i>
            <a href="javascript:void(0);">邮箱已经认证</a>
            @else
            <i class="I-email-1"></i>
            <a href="http://www.0736fdc.com/user/safecenter/email.html">邮箱未认证</a>
            @endif
          </span>
        </li>
        <!-- <li>
          <span class="I-title">消息提醒：</span>
          <a href="#">系统消息（<span class="c1">2</span>）</a>
        </li> -->
      </ul>
    </div>
  </div>
</div>
<div class="clear"></div>
@stop