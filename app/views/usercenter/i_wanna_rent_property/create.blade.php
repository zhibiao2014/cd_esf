@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::open(array( 'route' => array('i_wanna_rent_property.store'), 'id' => 'residence' )) }}
  <div class="title_477 mb5">
    <h2>发布类型</h2>
  </div>
  <div class="msglist mb20">
    <ul class="tab03 wanna_rent_type">
      <li>
        <label class="w127"><span class="c1">*</span>请选择发布类型：</label>
        <label class="tab01">
          <input type="radio" name="info[type]" value="1" checked />
          <span class="mr20">按区域</span>
        </label>
        <label class="tab02">
          <input type="radio" name="info[type]" value="2" />
          <span class="mr20">按小区求租</span>
        </label>
        <input type="hidden" value="1" name="type" id="type" />
      </li>
    </ul>
  </div>

  <div id="con_one_1">
    <div class="title_477 mb5">
      <h2>基本信息</h2>
    </div>
    <div class="msglist mb20">
      <ul>
        <li>
          <label class="w127" for="input_TITLE"><span class="c1">*</span>标题：</label>
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" />
        </li>
        <li class="iwanna_project" style="display:none;">
          <label class="w127">意向小区：</label>
          <input type="text" class="Input_1" style="width:120px;" size="21" name="info[community][]"> 或
          <input type="text" class="Input_1" style="width:120px;" size="21" name="info[community][]"> 或
          <input type="text" class="Input_1" style="width:120px;" size="21" name="info[community][]">
        </li>
        <li class="iwanna_area">
          <label class="w127"><span class="c1">*</span>区域：</label>
          <select autocomplete="off" class="input_7" id="area_top">
            <option selected="" value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == 0 ) { ?>
            <option value="<?php echo $area['id']; ?>"><?php echo $area['name']; ?></option>
            <?php } ?>          
            <?php } ?>
          </select>
          <select autocomplete="off" class="input_7" id="area" name="info[area_id]" >
            <option selected="" value="0">请选择</option>
          </select>
        </li>
        <li>
          <label class="w127" for="room_structure"><span class="c1">*</span>期望户型：</label>
          {{ Form::text('info[room_structure][room]', Input::old('info[room_structure][room]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Room' )) }}
          <span>室</span>
          {{ Form::text('info[room_structure][hall]', Input::old('info[room_structure][hall]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Hall' )) }}
          <span>厅</span>
          {{ Form::text('info[room_structure][bathroom]', Input::old('info[room_structure][bathroom]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Toilet' )) }}
          <span>卫</span>
        </li>
        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>期望面积：</label>
          大约{{ Form::text('info[construction_area]', Input::old('info[construction_area]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>
        <li>
          <label class="w127" for="price"><span class="c1">*</span>期望租金：</label>
          大约{{ Form::text('info[price]', Input::old('info[price]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }}元/月
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>租赁方式：</label>
          <select class="input_7" name="info[rent_method_id]" id="rent_method_id">
            <option value="">租赁方式</option>
            <?php foreach ($rent_methods as $key => $value) { ?>
            <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li class="clearfix">
          <label class="w127 flptao">房屋配套： </label>
          <div class="frptao">
            <?php foreach ($house_supportings as $key => $supporting) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $supporting['id']; ?>" name="info[supporting][]" autocomplete="off" /><?php echo $supporting['name']; ?></label>
            <?php } ?>
            <input type="button" class="selectall" onclick="selectall('info[supporting][]');" value="全选" />
          </div>
        </li>
        <li class="clearfix">
          <label class="w127 flptao" for="input_DESCRIPTION">需求描述：</label>
          <div class="frptao">
            <textarea name="info[content]" id="input_DESCRIPTION" class="textsize"></textarea>
          </div>
        </li>
        <li>
          <div class="mb30 mt20 tc">
            <input type="submit" class="but_fabu f12" value="个人发布信息" />
          </div>
        </li>
      </ul>
    </div>
  </div>
  {{Form::close()}}
</div>
<div class="clear"></div>
@stop
@section('footer')
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidator.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidatorregex.js"); ?>"></script>
<script type="text/javascript">
  var GlobalParams = {};
  GlobalParams.areas = $.parseJSON('<?php echo json_encode($areas); ?>');

  $(function(){
    $('.wanna_rent_type input[name="info[type]"]').change(function(){
      value = $(this).val();
      if ( value == 2 ) {
        $('.iwanna_area').hide();
        $('.iwanna_project').show();
      } else {
        $('.iwanna_project').hide();
        $('.iwanna_area').show();
      }
      $('#type').val( value );
    });

    /* 表单验证 */
    $.formValidator.initConfig({ formid:"residence", autotip:true, onerror:function(msg,obj) { $(obj).focus(); } });
    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"});
    $("#area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).functionValidator({ fun:function(val,elem){
      if( $('#type').val() == 2 ) {
        return true;
      } else {
        if ( val > 0 ) { return true; }; 
        return "区域必填";
      } 
    }});

    $("#input_House_Room, #input_House_Hall, #input_House_Toilet").formValidator({}).regexValidator({datatype:"enum",regexp:"num1",onerror:"请输入正确的户型"});

    $("#rent_method_id").formValidator({onshow:"请选择租赁方式",onfocus:"请选择租赁方式"}).inputValidator({min:1,onerror:"租赁方式必选"});
    $("#price").formValidator({onshow:"请填写期望的售价",onfocus:"请填写期望的售价"}).inputValidator({min:1,onerror:"价格不能为空"});
    $("#construction_area").formValidator({onshow:"请填写期望面积",onfocus:"请填写期望面积"}).inputValidator({min:1,onerror:"期望面积不能为空"});
    /* 表单验证结束 */
  })

</script>
@stop