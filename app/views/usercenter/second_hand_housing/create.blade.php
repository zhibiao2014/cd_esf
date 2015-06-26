@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::open(array( 'route' => array('house.store'), 'id' => 'residence' )) }}
  <div class="title_477 mb5">
    <h2>联系方式</h2>
  </div>
  <div class="msglist mb20">
    <ul>
      <li>
        <label class="w127" for="contacts"><span class="c1">*</span>联 系 人：</label>
        <input type="text" value="<?php echo \Auth::user()->realname; ?>" class="Input_1" name="info[contacts]" id="contacts"/>
      </li>
      <li class="phone">
        <label class="w127" for="phone"><span class="c1">*</span>手机号码：</label>
        <span class="origin_phone Input_1">{{\Auth::user()->mobile}}</span>
        <input type="text" name="info[phone]" value="{{\Auth::user()->mobile}}" class="Input_1 hidbox" id='phone' />
        <a href="###" id="edit_phone" style="text-decoration:underline">修改</a>
      </li>
      <li class="valid_code" style="display:none;">
        <label class="w127" for="valid_code"><span class="c1">*</span>验证码：</label>
        <input type="text" name="info[valid_code]" class="Input_1" id='valid_code' data-code="<?php echo \Session::get('temp_mcode'); ?>" />
        <input type="button" value="向此手机发送验证码" class="Input_6" onclick="sendsms('<?php echo route('api.sms.send'); ?>')" id="btn_getcode" />
      </li>
    </ul>
  </div>
  <div class="title_477 mb5">
    <h2>发布类型</h2>
  </div>
  <div class="msglist mb20">
    <ul class="tab03 type_tab">
      <li>
        <label class="w127"><span class="c1">*</span>请选择发布类型：</label>
        <label class="tab01">
          <input name="public" type="radio" checked="checked" />
          <span class="mr20">住宅</span>
        </label>
        <!-- <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('villas.create'); ?>"/>
          <span class="mr20">别墅</span>
        </label> -->
        <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('office.create'); ?>" />
          <span class="mr20">写字楼</span>
        </label>
        <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('shop.create'); ?>" />
          <span class="mr20">商铺</span>
        </label>
      </li>
    </ul>
  </div>

  <div id="con_one_1">
    <div class="title_477 mb5">
      <h2>基本信息</h2>
    </div>
    <div class="msglist mb20">
      <ul>
        <li class="pr">
          <label class="w127" for="community_name"><span class="c1">*</span>楼盘名称：</label>
          <input type="text" maxlength="15" class="Input_1" style="width:300px;" id="community_name" name="info[community_name]" autocomplete="off"/>
          <input type="hidden" name="info[community_id]" id="community_id"/>
          <ul id="lp_results" class="lp_results pa" style="display: none;">
          </ul>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>区域：</label>
          <select autocomplete="off" class="input_7" name="info[region_id]" id="area_top">
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
          <label class="w127" for="address"><span class="c1">*</span>地址：</label>
          {{ Form::text('info[address]', Input::old('info[address]'), array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'address' )) }}
        </li>
        <li>
          <label class="w127" for="room_structure"><span class="c1">*</span>户型：</label>
          {{ Form::text('info[room_structure][room]', Input::old('info[room_structure][room]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Room' )) }}
          <span>室</span>
          {{ Form::text('info[room_structure][hall]', Input::old('info[room_structure][hall]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Hall' )) }}
          <span>厅</span>
          {{ Form::text('info[room_structure][bathroom]', Input::old('info[room_structure][bathroom]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Toilet' )) }}
          <span>卫</span>
        </li>
        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>建筑面积：</label>
          {{ Form::text('info[construction_area]', Input::old('info[construction_area]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>
        <li>
          <label class="w127" for="price"><span class="c1">*</span>售价：</label>
          {{ Form::text('info[price]', Input::old('info[price]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }}万元
        </li>
        <li>
          <label class="w127" for="input_House_Floor"><span class="c1">*</span>楼层：</label>
          {{ Form::text('info[floor][floor]', Input::old('info[floor][floor]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'floor' )) }}
          层 共
          {{ Form::text('info[floor][total_floor]', Input::old('info[floor][total_floor]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'total_floor' )) }}
          层
        </li>
        <li>
          <label class="w127" for="input_House_Block">楼 栋 号：</label>
          {{ Form::text('info[house_number][floor]', Input::old('info[house_number][floor]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Block' )) }}
          幢/号/层
          {{ Form::text('info[house_number][unit]', Input::old('info[house_number][unit]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_UnitNumber' )) }}
          单元
          {{ Form::text('info[house_number][room]', Input::old('info[house_number][room]'), array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_RoomNum' )) }}
          室
          <span class="c1 f12 ml10">(楼栋号不对外显示)</span>
        </li>
        <li>
          <label class="w127">朝向/装修：</label>
          <select class="input_7" name="info[direction_id]" id="slt_House_Forward">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($directions as $key => $direction) { ?>
            <option value="<?php echo $direction['id']; ?>"><?php echo $direction['name']; ?></option>
            <?php } ?>
          </select>
          <select class="input_7" name="info[decoration_id]" id="decoration">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($decorations as $key => $decoration) { ?>
            <option value="<?php echo $decoration['id']; ?>"><?php echo $decoration['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">特色标签：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($tags as $key => $tag) { ?>
              <li>
                <label for="{{$tag['id']}}"><?php echo $tag['name']; ?></label>
                <input type="checkbox" name="info[tag][]" value="<?php echo $tag['id']; ?>" id="{{$tag['id']}}" autocomplete="off" />
              </li>
              <?php } ?>
            </ul>
            <ul class="brightspot" id="brightspot">
            </ul>
            <div class="clear"></div>
            <div id="OthBrig">
              <input type="text" id="customer_tag" class="textstyle" maxlength="20" placeholder="最多增加3个特色标签" value="" autocomplete="off" >
              <input type="button" class="addbrig" id="add_customer_tag" value="添加特色" style="display: inline-block;">
              <span id="txtOthBrig1_Tip"></span>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div class="title_477 mb5">
      <h2>详细信息</h2>
    </div>
    <div class="msglist mb20">
      <ul>
        <li>
          <label class="w127" for="input_TITLE"><span class="c1">*</span>房源标题：</label>
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" />
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
          <label class="w127 flptao" for="input_DESCRIPTION">房源描述：</label>
          <div class="frptao">
            <script id="editor" type="text/plain" name="info[content]" style="width:568px;height:120px;"></script>
            <p><i class="ico_warn ml10"></i><span class="f12">请输入房源描述，最少5个字符。</span></p>
          </div>
        </li>
        <li class="clearfix">
          <label class="w127 flptao">上传图片：</label>
          <div class="clearfix pre-z" id="">
            <div id="preview">
            </div>
            <div class="frptao">
              <!--<a href="#" class="but_02 f14 fb">请上传图片</a>-->
            </div>
            <div class="frptao clearfix">
              <div class="ButUp_box fl">
                <input id="file_upload" name="file_upload" type="file" multiple="true" class="ButUpImg_2">
              </div>
              <div class="clearfix"></div>
              <p class="f12 c1 mt5">已上传图片<span class="c1 upload_count">0</span>/10，支持多张上传，最多上传10张，单张照片不超过3M。真实且未经处理的照片更能吸引网友关注。</p><p>如果图片太大，请把图片发给客服QQ：421467754或者发送邮件到421467754@qq.com，附上房源的网址，我们代处理。</p>
            </div>
          </div>
        </li>
        <li><div class="tc"><input type="submit" class="but_fabu f12" value="确认发布信息" /></div></li>
      </ul>
    </div>
  </div>
  {{Form::close()}}
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
  // 所有小区名称列表JSON, 需要字段id, address, title, price。
  $.getJSON( '<?php echo route("houselist"); ?>', function( data ) {
    GlobalParams.houses = data;
    // console.log(data);
  });
  GlobalParams.areas = $.parseJSON('<?php echo json_encode($areas); ?>');
  var ue = UE.getEditor('editor');
  var customer_tag = 0;

  $(function() {
    /* 表单验证 */
    $.formValidator.initConfig({ formid:"residence", autotip:true, onerror:function(msg,obj) { $(obj).focus(); } });
    $("#contacts").formValidator({onshow:"请填写联系人",onfocus:"请填写联系人"}).inputValidator({min:1,onerror:"联系人必填"}).defaultPassed();
    $("#phone").formValidator({onshow:"请填写手机号码",onfocus:"请填写手机号码",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"mobile",onerror:"手机号码格式不正确"}).defaultPassed();
    $("#valid_code").formValidator({onshow:"请填写验证码",onfocus:"请填写验证码",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
      if ( $("#edit_phone").length > 0 ) {
        return true;
      };
      if ( val != $("#valid_code").data('code') ) {
        return "验证码不正确！";
      } else {
        return true;
      };
    }});
    $("#community_name").formValidator({onshow:"请填写楼盘名称",onfocus:"使用标准小区名称更有利于网友搜索到您的房源"}).inputValidator({min:1,onerror:"楼盘名称必填"});
    $("#area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"});
    $("#address").formValidator({onshow:"请填写房源详细地址",onfocus:"请填写房源详细地址"}).inputValidator({min:1,onerror:"地址必填"});

    $("#input_House_Room, #input_House_Hall, #input_House_Toilet").formValidator({}).regexValidator({datatype:"enum",regexp:"num1",onerror:"请输入正确的户型"});
    $("#construction_area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"});

    $("#construction_area").formValidator({onshow:"请填写产证面积",onfocus:"请填写产证面积"}).inputValidator({min:1,onerror:"建筑面积不能为空"});

    $("#price").formValidator({onshow:"请填写期望的售价",onfocus:"请填写期望的售价"}).inputValidator({min:1,onerror:"价格不能为空"});
    $("#total_floor").formValidator({onshow:"请填写总楼层",onfocus:"请填写总楼层"}).inputValidator({min:1,onerror:"总楼层必须为正整数"});
    $("#floor").formValidator({onshow:"请填写所在楼层，地下室请填写负数",onfocus:"请填写所在楼层，地下室请填写负数"}).inputValidator({min:1,max:99,onerror:"楼层必须为整数"});
    $("#input_House_Block").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体楼号"}).inputValidator();
    $("#input_House_UnitNumber").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体单元号"}).inputValidator();
    $("#input_House_RoomNum").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体门牌号"}).inputValidator();
    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"});
    // $("#decoration").formValidator({onshow:"请选择装修状况",onfocus:"请选择装修状况"}).inputValidator({min:1,onerror:"装修状况必选"});

    /* 表单验证结束 */

});

</script>
@stop