@extends('layouts.recruit')
@section('header')
<link href="<?php echo asset("assets/css/user/login.css"); ?>" rel="stylesheet" type="text/css" />
@stop
@section('content')
<div class="wrap">
  <div class="compT">
    <h1>{{{$company->gsmc}}}</h1>
  </div>
  <div class="subTab"> <a class="tab01" id="one1" onclick="setTab('one',1,2)" target="_self" href="#">招聘信息</a> <a class="tab02" id="one2" onclick="setTab('one',2,2)" target="_self" href="#">公司信息</a> </div>
  <div id="con_one_1">
    <div class="msglist mb20">
      <ul class="tab03">
        <li>
          <label class="w127 fl mt10" for="input_LinkMan">职位名称：</label>
          <h2 class="zpmc fl">{{{$post->title}}}</h2>
        </li>
        <li>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">职位类别：</label>
            <span>{{ isset( $job_types[$post->job_type] ) ? $job_types[$post->job_type] : '无' }}</span>
          </div>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">招聘人数：</label>
            <span>{{{$post->people_num}}}人</span>
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">学历要求：</label>
            <span>{{ isset( $educations[$post->education] ) ? $educations[$post->education] : '' }}</span>
          </div>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">工作年限：</label>
            <span>{{ isset( $work_times[$post->work_time] ) ? $work_times[$post->work_time] : '不限' }}</span>
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">每月薪资：</label>
            <span>{{ isset( $salaries[$post->salary] ) ? $salaries[$post->salary] : '不限' }}</span>
          </div>
          <div class="w423 fl">
            <label class="w127" for="input_LinkMan">职位类型：</label>
            <span>{{ isset( $position_types[$post->position_type] ) ? $position_types[$post->position_type] : '不限' }}</span>
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">职位福利：</label>
          <span></span>
          <div class="contedit fl">
            @if ( is_array($welfares) && is_array($post->welfare) )
            <ul class="welfare" id="fuli">
              @foreach ($welfares as $key => $value )
              @if ( in_array( $key , $post->welfare ) )
              <li class="active"><label>{{$value}}</label></li>
              @endif
              @endforeach
            </ul>
            @endif
            <div class="clear"></div>
          </div>
          <div class="clear"></div>
        </li>
        <li>
          <label class="w127" for="input_LinkMan">职位联系人：</label>
          <span>{{{$post->contact_people}}}</span>
        </li>
        <li>
          <label class="w127" for="input_LinkMan">联系电话：</label>
          <span class="f20 c1">{{{ $post->ber }}}</span>
        </li>
        <li>
          <label class="w127" for="input_LinkMan">简历接收邮箱：</label>
          <span>{{{$post->email}}}</span>
        </li>
        <li>
          <label class="w127" for="input_LinkMan">工作地址：</label>
          <span>{{{$post->address}}}</span>
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">任职要求：</label>
          <div class="rzcen fl">
            {{ \lib\Tool::trim_script($post->content) }}
          </div>
          <div class="clear"></div>
        </li>
        <!-- <li>
          @if ( \Auth::check() )
          <a class="int_b" href="{{ route( 'post.deliver', array( 'id' => $post->id ) ) }}">投递简历</a>
          @else
          <a class="int_b" href="{{'http://www.0736fdc.com/user/login.html?redirect=' . urlencode(\Request::url())}}">投递简历</a>
          @endif
        </li> -->
      </ul>
    </div>
  </div>
  <div id="con_one_2" class="hidbox">
    <div class="basicMsg">
      <h2>基本资料</h2>
      <table class="mb20">
        <tbody>
          <tr>
            <th>公司资质</th>
            <td>
              @if ( empty($company->gszz) )
              <span title="营业执照未验证" class="vip-yan noyan"><i></i>营业执照未验证</span>
              @else
              <span title="营业执照已验证" class="vip-yan"><i></i>营业执照已验证</span>
              @endif
            </td>
            <?php $gsxz = array( '1' => '民营企业', '2' => '国营企业', '3' => '合资', '4' => '上市公司', '5' => '其他' ); ?>
            <th>公司性质</th>
            <td> {{isset( $gsxz[$company->gsxz] ) ? $gsxz[$company->gsxz] : '未知'}} </td>
          </tr>
          <tr>
            <?php $gshy = array( '1' => '房地产开发', '2' => '房地产经纪', '3' => '物业服务' ); ?>
            <th>公司行业</th>
            <td><span>{{isset( $gshy[$company->gshy] ) ? $gshy[$company->gshy] : '未知' }}</span></td>
            <?php $gsgm = array( '1' => '1-49人', '2' => '50-99人', '3' => '100-499人', '4' => '500人以上' ); ?>
            <th>公司规模</th>
            <td>{{isset($gsgm[$company->gsgm]) ? $gsgm[$company->gsgm] : '未知' }}</td>
          </tr>
          <tr>
            <th>法定代表人</th>
            <td>{{{$company->realname}}}</td>
            <th>联系电话</th>
            <td class="telNum">{{{$company->telphone}}}</td>
          </tr>
          <tr>
            <th>邮箱</th>
            <td>{{{$company->email}}}</td>
            <th>企业网址</th>
            <td>{{{$company->qywz}}}</td>
          </tr>
          <tr>
            <th>公司地址</th>
            <td colspan="3" class="adress"><span>{{{$company->gsdizhi}}}</span></td>
          </tr>
        </tbody>
      </table>
      <div id="infoview" class="pt20 pb10 clearfix">
        <span class="fl">公司福利：</span>
        @if ( is_array($post->customer_tag) )
        <ul class="welfare fl">
          @foreach ($post->customer_tag as $value )
          <li><span>{{$value}}</span></li>
          @endforeach
        </ul>
        @endif
      </div>
      <h2>公司简介</h2>
      <div class="cenT pt10">
        {{ \lib\Tool::trim_script($company->gsjj) }}
      </div>
    </div>
  </div>
</div>

@stop
@section('footer')
@stop