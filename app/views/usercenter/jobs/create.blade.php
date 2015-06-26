@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
<link rel="stylesheet" href="<?php echo asset("assets/css/lib/jquery-ui.min.css"); ?>">
<style type="text/css">
  #self_introduceTip {
    clear: both;
    display: block;
    margin-left: 145px;
  }
</style>
@stop
@section('content')

<div class="set_cent fr">
  <!--内容 start-->
  <div class="title_477 mb5">
    <h2>您正在创建简历...</h2>
  </div>
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::open(array( 'route' => array('jobs.store'), 'id' => 'residence' )) }}
  <div class="Managementlist pt20 pb20">
    <div class="msglist mb20">
      <ul class="tab03">
        <li>
          <label class="w127"><span class="c1">*</span>简历标题：</label>
          {{ Form::text('info[title]', Input::old('info[title]'), array('class' => 'Input_1', 'placeholder' => '例：求职销售 2年经验' , 'id' => 'title' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>职位类别：</label>
          <select id="job_type" name="info[job_type]" class="input_7">
            <option value="0">不限</option>
            {{$job_types_option}}
          </select>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>期待薪资：</label>
          {{ Form::select( 'info[money]', $salaries, Input::old('info[money]'), array( 'id' => 'money' ) ) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>姓名：</label>
          {{ Form::text('info[name]', Input::old('info[name]') ? Input::old('info[name]') : $user->realname, array('class' => 'Input_1', 'id' => 'name' )) }}
        </li>
        <li>
          <span class="w127"><span class="c1">*</span>性别：</span>
          <label>{{ Form::radio('info[sex]', '0', true) }} 男</label>
          <label class="ml20">{{ Form::radio('info[sex]', '1') }} 女</label>
          <input type="hidden" id="sex"/>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>出生日期：</label>
          <input name="info[birthday]" type="text" value="{{ Input::old('info[birthday]') ? Input::old('info[birthday]') : '1990-01-01' }}" class="Input_1 datepicker" id="birthday" />
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>最高学历：</label>
          {{ Form::select( 'info[education]', $education, Input::old('info[education]'), array( 'id' => 'education' ) ) }}
        </li>
        <li>
          <label class="w127 fl"><span class="c1">*</span>工作年限：</label>
          {{ Form::text('info[work_time]', Input::old('info[work_time]'), array('class' => 'Input_1', 'style' => 'width: 100px;', 'id' => 'work_time' )) }}年
        </li>
        <li>
          <label class="w127 fl"><span class="c1">*</span>籍 贯：</label>
          {{ Form::text('info[birth_place]', Input::old('info[birth_place]'), array('class' => 'Input_1', 'placeholder' => "如：湖南常德", 'id' => 'birth_place' )) }}
        </li>
        <li>
          <label class="w127 fl"><span class="c1">*</span>现居住地：</label>
          <select name="info[living_place][province]"></select>
          <select name="info[living_place][city]"></select>
          <select name="info[living_place][area]" id="living_place"></select>
        </li>
        <li>
          <label class="w127 fl"><span class="c1">*</span>想在哪工作：</label>
          <select name="info[work_place][province]"></select>
          <select name="info[work_place][city]"></select>
          <select name="info[work_place][area]" id="work_place"></select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>邮箱：</label>
          {{ Form::text('info[email]', (Input::old('info[email]') ? Input::old('info[email]') : $user->email), array('class' => 'Input_1', 'id' => 'email' )) }}
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>手机号码：</label>
          {{ Form::text('info[phone_number]', (Input::old('info[phone_number]') ? Input::old('info[phone_number]') : $user->mobile), array('class' => 'Input_1', 'id' => 'phone' )) }}
        </li>

        <li class="valid_code">
          <label class="w127" for="valid_code"><span class="c1">*</span>验证码：</label>
          <input type="text" name="info[valid_code]" class="Input_1" id='valid_code' data-code="<?php echo \Session::get('temp_mcode'); ?>" />
          <input type="button" value="向此手机发送验证码" class="Input_6" onclick="sendsms('<?php echo route('api.sms.send'); ?>')" id="btn_getcode" />
        </li>
        <li id="valid_code_notice" style="display:none;">
          <label class="w127"></label>
          <p class="c1 pl125">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;验证码已下发到您的手机，请查收！如果接收不到短信验证码,请拨打4000736600转0</p>
        </li>
        <li class="clearfix">
          <label class="w127 fl"><span class="c1">*</span>自我介绍 ：</label>
          <textarea class="text3 mt10 mb5 fl" name="info[self_introduce]" id="self_introduce" cols="" rows="" placehold="请输入评论内容">{{Input::old('info[self_introduce]')}}</textarea>
          <div class="anlbox ml20 fl pr">
            <a href="javascript:void(0);" onmouseover="hoverDiv('exbpx1', 'show');" onmouseout="hoverDiv('exbpx1', 'hide');" class="anl1 mb10">范例一</a>

            <div class="exList pa" style="display:none;" id="exbpx1" onmouseover="hoverDiv('exbpx1', 'show');" onmouseout="hoverDiv('exbpx1', 'hide');">

              <p><strong>社会简历</strong>（例：销售）</p>

              <p class="f12">
                1.本人性格开朗，为人正直。有6年的销售经验，年销售额过百万，曾获"销售之星"荣誉。<br />2.普工话标准，谈判能力强。适应出差。<br />3.对市场、渠道和经销商管理有丰富的经验。
              </p>
              <p>
                <strong>技术岗位</strong>
                （例：司机）
              </p>
              <p class="f12">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;本人A2本，有5年金杯驾驶经验、2年出租经验。熟悉本地路况，自带小面。诚信为本，爱护车辆，希望求得一份商务司机或货车司机的职位。
              </p>
            </div>
            <a href="javascript:void(0);" onmouseover="hoverDiv('exbpx2', 'show');" onmouseout="hoverDiv('exbpx2', 'hide');" class="anl2">范例二</a>
            <div class="exList pa" style="display:none;" id="exbpx2" onmouseover="hoverDiv('exbpx2', 'show');" onmouseout="hoverDiv('exbpx2', 'hide');">
              <p><strong>学生简历</strong></p>
              <p class="f12">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;曾担任外联部部长一职，负责学校12个大小型活动的赞助商招揽，并成功筹集活动资金10万元。具备较强的组织领导能力和沟通能力。并于假期参加过销售岗位实习，积累了一定经验。希望找到一份市场策划的工作，实现自己的职位理想！
              </p>
            </div>
          </div>
          <!-- <div class="fr" style="margin-right:100px;">您已经输入 <span class="c10">0</span> 个字</div>
          <div class="clear"></div> -->
        </li>
        <li>
          <input type="submit" class="int_b" value="保存简历" ct="submit" />
        </li>
      </ul>
    </div>
  </div>
  {{ Form::close() }}
  <!--内容 end-->
</div>
<div class="clear"></div>
@stop
@section('footer')
<script src="<?php echo asset("assets/js/ueditor/ueditor.config.js"); ?>"></script>
<script src="<?php echo asset("assets/js/ueditor/ueditor.all.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidator.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidatorregex.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/uploadify/jquery.uploadify.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/lib/jquery-ui.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/lib/city_menu_select.js"); ?>"></script>
<script type="text/javascript">
  function hoverDiv(obj, sType) {
    var oDiv = document.getElementById(obj);
    if (sType == 'show') { oDiv.style.display = 'block';}
    if (sType == 'hide') { oDiv.style.display = 'none';}
  }
  var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>' };

  // var ue = UE.getEditor('editor');

  var customer_tag = 0;
  $(function() {
    new PCAS("info[work_place][province]","info[work_place][city]","info[work_place][area]","湖南省","常德市","武陵区");
    new PCAS("info[living_place][province]","info[living_place][city]","info[living_place][area]","湖南省","常德市","武陵区");

    /* 表单验证 */
    $.formValidator.initConfig({ formid:"residence", autotip:true, onerror:function(msg,obj) { $(obj).focus(); } });
    $("#name").formValidator({onshow:"请填写姓名",onfocus:"请填写姓名"}).inputValidator({min:1,onerror:"姓名必填"}).defaultPassed();
    $("#phone").formValidator({onshow:"请填写手机号码",onfocus:"请填写手机号码",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"mobile",onerror:"手机号码格式不正确"}).defaultPassed();
    $("#valid_code").formValidator({onshow:"请填写验证码",onfocus:"请填写验证码",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( val != $("#valid_code").data('code') ) {
        return "验证码不正确！";
      } else {
        return true;
      };
    }});

    $("#email").formValidator({onshow:"请填写邮箱地址",onfocus:"请填写邮箱地址",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"email",onerror:"邮箱格式不正确"}).defaultPassed();

    $("#sex").formValidator({onshow:"",onfocus:"",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ){
      if ( $('input[name="info[sex]"]').is(":checked") ) {
        return true;
      } else {
        return "性别是必选项";
      }
    }});

    $("#job_type").formValidator({onshow:"请选择职位类别",onfocus:"请选择职位类别",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "职位类别必选";
      }
    }}).defaultPassed();

    $("#work_time").formValidator({onshow:"请填写工作时间",onfocus:"请填写工作时间",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"num1",onerror:"工作时间不能为空"});

    $("#money").formValidator({onshow:"请选择期待薪资",onfocus:"请选择期待薪资",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "期待薪资必选";
      }
    }}).defaultPassed();
    // regexValidator({datatype:"enum",regexp:"date",onerror:"期待薪资必选"});

    $("#birthday").formValidator({onshow:"请填写出生日期",onfocus:"请填写出生日期",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"date",onerror:"日期格式不正确"}).defaultPassed();
    // inputValidator({min:1,onerror:"出生日期不能为空"});
    // regexValidator({datatype:"enum",regexp:"date",onerror:"日期格式不正确"});

    $("#birth_place").formValidator({onshow:"请填写籍贯",onfocus:"请填写籍贯",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"籍贯不能为空"});

    $("#title").formValidator({onshow:"亲，2-12个字",onfocus:"亲，2-12个字",oncorrect:"输入正确"}).inputValidator({min:2,onerror:"职位名称必须在2-12个字之间"}).inputValidator({max:24,onerror:"职位名称必须在2-12个字之间"});

    $( "#work_place" ).formValidator({onshow:"请选择地址",onfocus:"请选择地址",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"地址格式不正确"}).defaultPassed();
    $( "#living_place" ).formValidator({onshow:"请选择地址",onfocus:"请选择地址",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"地址格式不正确"}).defaultPassed();

    $("#self_introduce").formValidator({onshow:"请输入自我介绍",onfocus:"请输入自我介绍",oncorrect:"输入正确"}).inputValidator({min:10,onerror:"自我介绍至少10个字"});
    /* 表单验证结束 */

  });
</script>
@stop