@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::model($rent_villas, array('route' => array('rent_villas.update', $rent_villas['id']), 'method' => 'put' , 'id' => 'residence')) }}
  <div class="title_477 mb5">
    <h2>联系方式</h2>
  </div>
  <div class="msglist mb20">
    <ul>
      <li>
        <label class="w127" for="contacts"><span class="c1">*</span>联 系 人：</label>
        <input type="text" value="<?php echo $rent_villas['contacts']; ?>" class="Input_1" name="info[contacts]" id="contacts"/>
      </li>
      <li class="phone">
        <label class="w127" for="phone"><span class="c1">*</span>手机号码：</label>
        <span class="origin_phone Input_1">{{$rent_villas['phone']}}</span>
        <input type="text" name="info[phone]" value="{{$rent_villas['phone']}}" class="Input_1 hidbox" id='phone' />
        <a href="###" id="edit_phone" style="text-decoration:underline">修改</a>
      </li>
      <li class="valid_code" style="display:none;">
        <label class="w127" for="valid_code"><span class="c1">*</span>验证码：</label>
        <input type="text" name="info[valid_code]" class="Input_1" id='valid_code' data-code="<?php echo \Session::get('temp_mcode'); ?>" />
        <input type="button" value="向此手机发送验证码" class="Input_6" onclick="sendsms('<?php echo route('api.sms.send'); ?>')" id="btn_getcode" />
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
          <input type="text" maxlength="15" class="Input_1" style="width:300px;" id="community_name" name="info[community_name]" value="<?php echo $rent_villas['community_name']; ?>" />
          <ul id="lp_results" class="lp_results pa" style="display: none;">
          </ul>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>区域：</label>
          <select autocomplete="off" class="input_7" name="info[region_id]" id="area_top">
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == 0 ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $areas[$rent_villas['area_id']]['pid'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <select autocomplete="off" class="input_7" id="area" name="info[area_id]" >
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == $areas[$rent_villas['area_id']]['pid'] ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $rent_villas['area_id'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="address"><span class="c1">*</span>地址：</label>
          {{ Form::text('info[address]', $rent_villas['address'], array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'address' )) }}
        </li>
        <li>
          <label class="w127" for="rent_method_id"><span class="c1">*</span>租赁方式：</label>
          <select class="input_7" name="info[rent_method_id]" id="rent_method_id">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($rent_methods as $key => $value) { ?>
            <option value="<?php echo $value['id']; ?>" <?php if( $value['id'] == $rent_villas['rent_method_id'] ) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="room_structure"><span class="c1">*</span>户型：</label>
          {{ Form::text('info[room_structure][room]', $rent_villas['room_structure']['room'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Room' )) }}
          <span>室</span>
          {{ Form::text('info[room_structure][hall]', $rent_villas['room_structure']['hall'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Hall' )) }}
          <span>厅</span>
          {{ Form::text('info[room_structure][bathroom]', $rent_villas['room_structure']['bathroom'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Toilet' )) }}
          <span>卫</span>
        </li>
        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>建筑面积：</label>
          {{ Form::text('info[construction_area]', $rent_villas['construction_area'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>
        <li>
          <label class="w127" for="price"><span class="c1">*</span>租金：</label>
          {{ Form::text('info[price]', $rent_villas['price'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }} 元/月
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>支付方式：</label>
          <select class="input_7" name="info[pay_method_id]" id="pay_method_id">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($pay_methods as $key => $method) { ?>
            <option value="<?php echo $method['id']; ?>" <?php if( $method['id'] == $rent_villas['pay_method_id'] ) { echo "selected"; } ?>><?php echo $method['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="input_House_Floor"><span class="c1">*</span>楼层：</label>
          共
          {{ Form::text('info[floor]', $rent_villas['floor'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'floor' )) }}
          层
        </li>
        <li>
          <label class="w127" for="input_House_Block">楼 栋 号：</label>
          {{ Form::text('info[house_number][floor]', $rent_villas['house_number']['floor'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_Block' )) }}
          幢/号/层
          {{ Form::text('info[house_number][unit]', $rent_villas['house_number']['unit'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'input_House_UnitNumber' )) }}
          单元
          <span class="c1 f12 ml10">(楼栋号不对外显示)</span>
        </li>
        <li>
          <label class="w127">朝向/装修：</label>
          <select class="input_7" name="info[direction_id]" id="slt_House_Forward">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($directions as $key => $direction) { ?>
            <option value="<?php echo $direction['id']; ?>"<?php if( $direction['id'] == $rent_villas['direction_id'] ) {echo " selected";} ?>><?php echo $direction['name']; ?></option>
            <?php } ?>
          </select>
          <select class="input_7" name="info[decoration_id]" id="slt_House_Fitment">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($decorations as $key => $decoration) { ?>
            <option value="<?php echo $decoration['id']; ?>"<?php if( $direction['id'] == $rent_villas['decoration_id'] ) {echo " selected";} ?>><?php echo $decoration['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">特色标签：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($tags as $key => $tag) { ?>
              <li <?php if ( in_array($tag['id'], $rent_villas['tag']) ) { echo ' class="active"'; } ?>>
                <label for="{{$tag['id']}}"><?php echo $tag['name']; ?></label>
                <input type="checkbox" id="{{$tag['id']}}" name="info[tag][]"<?php if ( in_array($tag['id'], $rent_villas['tag']) ) { echo ' checked'; } ?> value="<?php echo $tag['id']; ?>"  autocomplete="off" />
              </li>
              <?php } ?>
            </ul>
            <ul class="brightspot" id="brightspot">
              <?php foreach ($rent_villas['customer_tag'] as $key => $tag) { ?>
              <li class='actived'><?php echo $tag; ?><a href='javascript:void(0);' class='cbdel'></a><input type='hidden' name='info[customer_tag][]' value='<?php echo $tag; ?>'/></li>
              <?php } ?>
            </ul>
            <div class="clear"></div>
            <div id="OthBrig">
              <input type="text" id="customer_tag" class="textstyle" maxlength="20" placeholder="最多增加3个特色标签" autocomplete="off" >
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
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" value="<?php echo $rent_villas['title']; ?>" autocomplete="off" />
        </li>
        <li class="clearfix">
          <label class="w127 flptao">房屋配套： </label>
          <div class="frptao">
            <?php foreach ($house_supportings as $key => $supporting) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $supporting['id']; ?>" name="info[supporting][]" <?php if (in_array($supporting['id'], $rent_villas['supporting'])) { echo "checked"; } ?> autocomplete="off" /><?php echo $supporting['name']; ?></label>
            <?php } ?>
            <input type="button" class="selectall" onclick="selectall('info[supporting][]');" value="全选" />
          </div>
        </li>
        <li class="clearfix">
          <label class="w127 flptao" for="input_DESCRIPTION">房源描述：</label>
          <div class="frptao">
            <script id="editor" type="text/plain" style="width:568px;height:120px;" name="info[content]"><?php echo $rent_villas['content']; ?></script>
            <p><i class="ico_warn ml10"></i><span class="f12">请输入房源描述，最少5个字符。</span></p>
          </div>
        </li>
        <li class="clearfix">
          <label class="w127 flptao">上传图片：</label>
          <div class="clearfix pre-z" id="">
            <div id="preview">
              <?php foreach ($rent_villas['room_images'] as $key => $room_image) { ?>
              <div class="imgbox">
                <div class="w_upload">
                  <a href="javascript:void(0)" class="item_close">删除</a>
                  <span class="item_box"><img src="<?php echo $room_image['url'] ?>"></span>
                </div>
                <input type="hidden" name="info[room_images][<?php echo $room_image['id'] ?>][id]" value="<?php echo $room_image['id'] ?>" />
                <input type="hidden" name="info[room_images][<?php echo $room_image['id'] ?>][url]" value="<?php echo $room_image['url'] ?>" />
              </div>
              <?php } ?>
            </div>
            <div class="frptao">
              <!--<a href="#" class="but_02 f14 fb">请上传图片</a>-->
            </div>
            <div class="frptao clearfix">
              <div class="ButUp_box fl">
                <input id="file_upload" name="file_upload" type="file" multiple="true" class="ButUpImg_2">
              </div>
              <div class="clearfix"></div>
              <p class="f12 c1 mt5">已上传图片<span class="c1 upload_count">{{count($rent_villas['room_images'])}}</span>/10，支持多张上传，最多上传10张，单张照片不超过3M。真实且未经处理的照片更能吸引网友关注。</p><p>如果图片太大，请把图片发给客服QQ：421467754或者发送邮件到421467754@qq.com，附上房源的网址，我们代处理。</p>
            </div>
          </div>
        </li>
        <!-- <li class="commission">
          <div class="mb30 mt20 tc">
            <a class="wt_button {{ $rent_villas['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='1'><strong>快速委托</strong></a>
            <a class="wt_button {{ !$rent_villas['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='0'><strong>个人发布</strong></a>
            <input type="hidden" name="info[is_commissioned]" value="{{{$rent_villas['is_commissioned']}}}" />
          </div>
        </li> -->
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
  var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>', 'image_num' : {{count($rent_villas['room_images'])}} };
  // 所有小区名称列表JSON, 需要字段id, address, title, price。
  $.getJSON( '<?php echo route("houselist"); ?>', function( data ) {
    GlobalParams.houses = data;
    // console.log(data);
  });
  GlobalParams.areas = $.parseJSON('<?php echo json_encode($areas); ?>');
  var ue = UE.getEditor('editor');
  var customer_tag = <?php echo count($rent_villas['customer_tag']); ?>;
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
    $("#community_name").formValidator({onshow:"请填写楼盘名称",onfocus:"使用标准小区名称更有利于网友搜索到您的房源"}).inputValidator({min:1,onerror:"楼盘名称必填"}).defaultPassed();
    $("#area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"}).defaultPassed();
    $("#address").formValidator({onshow:"请填写房源详细地址",onfocus:"请填写房源详细地址"}).inputValidator({min:1,onerror:"地址必填"}).defaultPassed();

    $("#input_House_Room, #input_House_Hall, #input_House_Toilet").formValidator({}).regexValidator({datatype:"enum",regexp:"num1",onerror:"请输入正确的户型"}).defaultPassed();
    $("#construction_area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"}).defaultPassed();

    $("#construction_area").formValidator({onshow:"请填写产证面积",onfocus:"请填写产证面积"}).inputValidator({min:1,onerror:"建筑面积不能为空"}).defaultPassed();
    $("#pay_method_id").formValidator({onshow:"请选择支付方式",onfocus:"请选择支付方式"}).inputValidator({min:1,onerror:"支付方式必选"}).defaultPassed();
    $("#rent_method_id").formValidator({onshow:"请选择租赁方式",onfocus:"请选择租赁方式"}).inputValidator({min:1,onerror:"租赁方式必选"}).defaultPassed();

    $("#price").formValidator({onshow:"请填写期望的售价",onfocus:"请填写期望的售价"}).inputValidator({min:1,onerror:"价格不能为空"}).defaultPassed();
    $("#floor").formValidator({onshow:"请填写总楼层",onfocus:"请填写总楼层"}).inputValidator({min:1,onerror:"总楼层必须为正整数"}).defaultPassed();
    $("#input_House_Block").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体楼号"}).inputValidator().defaultPassed();
    $("#input_House_UnitNumber").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体单元号"}).inputValidator().defaultPassed();
    $("#input_House_RoomNum").formValidator({onshow:"请填写具体楼号",onfocus:"请填写具体门牌号"}).inputValidator().defaultPassed();
    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"}).defaultPassed();
    /* 表单验证结束 */

  });
</script>
@stop