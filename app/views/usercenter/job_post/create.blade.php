@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
@stop
@section('content')

<div class="set_cent fr">
  <!--内容 start-->
  <div class="title_477 mb5">
    <h2>您正在发布招聘信息...</h2>
  </div>
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::open(array( 'route' => array('post.store'), 'id' => 'residence' )) }}
  <div class="Managementlist pt20 pb20">
    <div class="msglist mb20">
      <ul class="tab03">
        <li>
          <label class="w127"><span class="c1">*</span>职位名称：</label>
          {{ Form::text('info[title]', Input::old('info[title]'), array('class' => 'Input_1', 'id' => 'title', 'placeholder' => '如经纪人3000包食宿' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>职位类别：</label>
          <select name="info[job_type]" id="job_type" class="input_7">
            <option value="0">不限</option>
            {{$job_types_option}}
          </select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>招聘人数：</label>
          {{ Form::text('info[people_num]', Input::old('info[people_num]'), array('class' => 'Input_1', 'id' => 'people_num' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>学历要求：</label>
          {{ Form::select( 'info[education]', $education, Input::old('info[education]'), array( 'id' => 'education' ) ) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>工作年限：</label>
          {{ Form::select( 'info[work_time]', $work_times, Input::old('info[work_time]'), array( 'id' => 'work_time' ) ) }}
          <span class="newpyn mr5"><input type="checkbox" value="1" name="info[accept_intern]" {{ Input::old('info[accept_intern]') == 1 ? 'checkout' : '' }}>可接收应届生 </span>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>每月薪资：</label>
          {{ Form::select( 'info[salary]', $salaries, Input::old('info[salary]'), array( 'id' => 'salary' ) ) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>职位类型：</label>
          {{ Form::select('info[position_type]', array('0' => '不限', '1' => '全职', '2' => '兼职', '3' => '实习'), Input::old('info[position_type]'), array( 'id' => 'position_type' ) ) }}
        </li>

        <li class="clearfix">
          <label class="w127 fl"><span class="c1">*</span>任职要求：</label>
          <script id="editor" type="text/plain" name="info[content]" style="width:568px;height:120px;float:left;">{{ Input::old('info[content]') }}</script>
        </li>

        <li class="clearfix">
          <label class="w127 fl"><span class="c1">*</span>职位福利：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($welfares as $key => $value) { ?>
              <li>
                <label for="{{$value['id']}}"><?php echo $value['name']; ?></label>
                <input  id="{{$value['id']}}" type="checkbox" name="info[welfare][]" value="<?php echo $value['id']; ?>"  autocomplete="off" />
              </li>
              <?php } ?>
            </ul>
            <ul class="brightspot" id="brightspot">
            </ul>
            <div class="clear"></div>
            <div id="OthBrig">
              <input type="text" id="customer_tag" class="textstyle" maxlength="20" placeholder="最多增加3自定义福利" value="" autocomplete="off" >
              <input type="button" class="addbrig" id="add_customer_tag" value="添加福利" style="display: inline-block;">
              <span id="txtOthBrig1_Tip"></span>
            </div>
          </div>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>职位联系人：</label>
          {{ Form::text('info[contact_people]', Input::old('info[contact_people]') ? Input::old('info[contact_people]') : $user->realname, array('class' => 'Input_1', 'id' => 'contact_people' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>联系电话：</label>
          {{ Form::text('info[tel_number]', Input::old('info[tel_number]') ? Input::old('info[tel_number]') : $user->mobile, array('class' => 'Input_1', 'id' => 'tel_number' )) }}
        </li>
        <li>
          <label class="w127">简历接收邮箱：</label>
          {{ Form::text('info[email]', Input::old('info[email]') ? Input::old('info[email]') : $user->email, array('class' => 'Input_1', 'id' => 'email' )) }}
        </li>
        <li>
          <label class="w127">工作地址：</label>
          {{ Form::text('info[address]', Input::old('info[address]'), array('class' => 'Input_1', 'id' => 'address' )) }}
        </li>
        <li>
          <input type="submit" id="fabu" class="int_b" value="确认并发布" ct="submit">
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

<script type="text/javascript">
  var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>' };

  var ue = UE.getEditor('editor');

  var customer_tag = 0;
  $(function() {
    /* 表单验证 */
    $.formValidator.initConfig({ formid:"residence", autotip:true, onerror:function(msg,obj) { $(obj).focus(); } });

    $("#title").formValidator({onshow:"请填写职位名称",onfocus:"请填写职位名称",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"职位名称必填"});
    $("#job_type").formValidator({onshow:"请选择职位类别",onfocus:"请选择职位类别",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "职位类别必选";
      }
    }}).defaultPassed();

    $("#people_num").formValidator({onshow:"请填写招聘人数",onfocus:"请填写招聘人数",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"num1",onerror:"招聘人数格式不正确"});

    $("#education").formValidator({onshow:"请选择学历要求",onfocus:"请选择学历要求",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "学历要求必选";
      }
    }});

    $("#work_time").formValidator({onshow:"请选择学历要求",onfocus:"请选择学历要求",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "学历要求必选";
      }
    }});

    $("#salary").formValidator({onshow:"请选择每月薪资",onfocus:"请选择每月薪资",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "每月薪资必选";
      }
    }});

    $("#position_type").formValidator({onshow:"请选择职位类型",onfocus:"请选择职位类型",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( /^[1-9]\d*|0$/.test(val) ) {
        return true;
      } else {
        return "职位类型必选";
      }
    }});

    $("#contact_people").formValidator({onshow:"请填写联系人",onfocus:"请填写联系人",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"联系人必填"}).defaultPassed();
    $("#tel_number").formValidator({onshow:"请填写联系方式",onfocus:"请填写联系方式",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"联系方式必填"}).defaultPassed();
    /* 表单验证结束 */

  });
</script>
@stop