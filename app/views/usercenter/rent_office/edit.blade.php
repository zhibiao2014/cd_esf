@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all()) }}
  {{ Form::model($rent_office, array('route' => array('rent_office.update', $rent_office['id']), 'method' => 'put' , 'id' => 'residence')) }}
  <div class="title_477 mb5">
    <h2>联系方式</h2>
  </div>
  <div class="msglist mb20">
    <ul>
      <li>
        <label class="w127" for="contacts"><span class="c1">*</span>联 系 人：</label>
        <input type="text" value="<?php echo $rent_office['contacts']; ?>" class="Input_1" name="info[contacts]" id="contacts"/>
      </li>
      <li class="phone">
        <label class="w127" for="phone"><span class="c1">*</span>手机号码：</label>
        <span class="origin_phone Input_1">{{$rent_office['phone']}}</span>
        <input type="text" name="info[phone]" value="{{$rent_office['phone']}}" class="Input_1 hidbox" id='phone' />
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
          <label class="w127" for="community_name"><span class="c1">*</span>小区名称：</label>
          {{ Form::text('info[community_name]', $rent_office['community_name'], array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'community_name', 'autocomplete' => 'off' )) }}
          <ul id="lp_results" class="lp_results pa" style="display: none;">
          </ul>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>区域：</label>
          <select autocomplete="off" class="input_7" name="info[region_id]" id="area_top">
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == 0 ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $areas[$rent_office['area_id']]['pid'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <select autocomplete="off" class="input_7" id="area" name="info[area_id]" >
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == $areas[$rent_office['area_id']]['pid'] ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $rent_office['area_id'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="address"><span class="c1">*</span>地址：</label>
          {{ Form::text('info[address]', $rent_office['address'], array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'address' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>类型：</label>
          <select class="input_7" name="info[type_id]" id="type">
            <option value="">请选择</option>
            <?php foreach ($types as $key => $type) { ?>
            <option value="<?php echo $type['id']; ?>" <?php if( $type['id'] == $rent_office['type_id'] ) { echo "selected"; } ?>><?php echo $type['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="rent_method_id"><span class="c1">*</span>租赁方式：</label>
          <select class="input_7" name="info[rent_method_id]" id="rent_method_id">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($rent_methods as $key => $value) { ?>
            <option value="<?php echo $value['id']; ?>" <?php if( $value['id'] == $rent_office['rent_method_id'] ) { echo "selected"; } ?>><?php echo $value['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>建筑面积：</label>
          {{ Form::text('info[construction_area]', $rent_office['construction_area'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>
        <li>
          <label class="w127" for="input_House_Floor"><span class="c1">*</span>楼层：</label>
          {{ Form::text('info[floor][floor]', $rent_office['floor']['floor'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'floor' )) }}
          层 共
          {{ Form::text('info[floor][total_floor]', $rent_office['floor']['total_floor'], array('class' => 'Input_1', 'style' => 'width:32px;', 'id' => 'total_floor' )) }}
          层
        </li>
        <li>
          <label class="w127">装修：</label>
          <select class="input_7" name="info[decoration_id]" id="slt_House_Fitment">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($decorations as $key => $decoration) { ?>
            <option value="<?php echo $decoration['id']; ?>"<?php if( $decoration['id'] == $rent_office['decoration_id'] ) {echo " selected";} ?>><?php echo $decoration['name']; ?></option>
            <?php } ?>
          </select>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>有 效 期：</label>
          <select id="validity" class="input_7" name="info[validity]">
            <option value="15" <?php if( 15 == $rent_office['validity'] ) {echo " selected";} ?>>15</option>
            <option value="30"<?php if( 30 == $rent_office['validity'] ) {echo " selected";} ?>>30</option>
            <option value="60"<?php if( 60 == $rent_office['validity'] ) {echo " selected";} ?>>60</option>
          </select>
          <span>天</span>
        </li>
        <li>
          <label class="w127" for="price"><span class="c1">*</span>租金：</label>
          {{ Form::text('info[price]', $rent_office['price'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }} 元/月
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>支付方式：</label>
          <?php foreach ($pay_methods as $key => $method) { ?>
          <label><input type="radio" value="<?php echo $method['id'] ?>" <?php echo $key == $rent_office['pay_method_id'] ? 'checked' : ""; ?> name="info[pay_method_id]" /><?php echo $method['name']; ?></label>
          <?php } ?>
          <input type="hidden" id="pay_method_id"/>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>是否包含物业费：</label>
          <label><input type="radio" value="1" <?php echo $rent_office['is_include_property_costs'] == 1 ? "checked" : ""; ?> name="info[is_include_property_costs]" /> 是 </label>
          <label><input type="radio" value="0" <?php echo $rent_office['is_include_property_costs'] == 0 ? "checked" : ""; ?> name="info[is_include_property_costs]" /> 否 </label>
        </li>
        <li>
          <label class="w127" for="price">物业费：</label>
          {{ Form::text('info[property_costs]', $rent_office['property_costs'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'property_costs' )) }} 元/平米·月 年
        </li>
        <li>
          <label class="w127" for="price">物业公司：</label>
          {{ Form::text('info[property_corporation]', $rent_office['property_corporation'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'property_corporation' )) }}
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">特色标签：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($tags as $key => $tag) { ?>
              <li <?php if ( in_array($tag['id'], $rent_office['tag']) ) { echo ' class="active"'; } ?>>
                <label for="{{$tag['id']}}"><?php echo $tag['name']; ?></label>
                <input type="checkbox" id="{{$tag['id']}}" name="info[tag][]"<?php if ( in_array($tag['id'], $rent_office['tag']) ) { echo ' checked'; } ?> value="<?php echo $tag['id']; ?>"  autocomplete="off" />
              </li>
              <?php } ?>
            </ul>
            <ul class="brightspot" id="brightspot">
              <?php foreach ($rent_office['customer_tag'] as $key => $tag) { ?>
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
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" value="<?php echo $rent_office['title']; ?>" autocomplete="off" />
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
              <p class="f12 c1 mt5">已上传图片<span class="c1 upload_count">{{count($rent_office['room_images'])}}</span>/10，支持多张上传，最多上传10张，单张照片不超过3M。真实且未经处理的照片更能吸引网友关注。</p><p>如果图片太大，请把图片发给客服QQ：421467754或者发送邮件到421467754@qq.com，附上房源的网址，我们代处理。</p>
            </div>
          </div>
        </li>
        <!-- <li class="commission">
          <div class="mb30 mt20 tc">
            <a class="wt_button {{ $rent_office['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='1'><strong>快速委托</strong></a>
            <a class="wt_button {{ !$rent_office['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='0'><strong>个人发布</strong></a>
            <input type="hidden" name="info[is_commissioned]" value="{{{$rent_office['is_commissioned']}}}" />
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
  var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>', 'image_num' : {{count($rent_office['room_images'])}} };
  // 所有小区名称列表JSON, 需要字段id, address, title, price。
  $.getJSON( '<?php echo route("houselist"); ?>', function( data ) {
    GlobalParams.houses = data;
    // console.log(data);
  });
  GlobalParams.areas = $.parseJSON('<?php echo json_encode($areas); ?>');
  var ue = UE.getEditor('editor');
  var customer_tag = <?php echo count($rent_office['customer_tag']); ?>;
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
    $("#construction_area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"}).defaultPassed();

    $("#construction_area").formValidator({onshow:"请填写产证面积",onfocus:"请填写产证面积"}).inputValidator({min:1,onerror:"建筑面积不能为空"}).defaultPassed();
    $("#pay_method_id").formValidator({onshow:"",onfocus:""}).functionValidator({ fun:function( val, elem ){
      if ( $('input[name="info[pay_method_id]"]').is(":checked") ) {
        return true;
      } else {
        return "支付方式是必选项";
      }
    }}).defaultPassed();
    $("#rent_method_id").formValidator({onshow:"请选择租赁方式",onfocus:"请选择租赁方式"}).inputValidator({min:1,onerror:"租赁方式必选"}).defaultPassed();

    $("#price").formValidator({onshow:"请填写期望的租金",onfocus:"请填写期望的租金"}).inputValidator({min:1,onerror:"租金不能为空"}).defaultPassed();
    $("#total_floor").formValidator({onshow:"请填写总楼层",onfocus:"请填写总楼层"}).inputValidator({min:1,onerror:"总楼层必须为正整数"}).defaultPassed();
    $("#floor").formValidator({onshow:"请填写所在楼层，地下室请填写负数",onfocus:"请填写所在楼层，地下室请填写负数"}).inputValidator({min:1,max:99,onerror:"楼层必须为整数"}).defaultPassed();

    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"}).defaultPassed();
    $("#validity").formValidator({onshow:"请填写有效期",onfocus:"请填写有效期"}).inputValidator({}).regexValidator({regExp:'intege1',onerror:"有效期格式不正确"}).defaultPassed();
    $("#type").formValidator({onshow:"请选择有效期",onfocus:"请选择有效期"}).inputValidator({min:1,onerror:"有效期是必选项"}).defaultPassed();
    /* 表单验证结束 */
  });
</script>
@stop