@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::model($rent_shop, array('route' => array('rent_shop.update', $rent_shop['id']), 'method' => 'put' , 'id' => 'residence')) }}
  <div class="title_477 mb5">
    <h2>联系方式</h2>
  </div>
  <div class="msglist mb20">
    <ul>
      <li>
        <label class="w127" for="contacts"><span class="c1">*</span>联 系 人：</label>
        <input type="text" value="<?php echo $rent_shop['contacts']; ?>" class="Input_1" name="info[contacts]" id="contacts"/>
      </li>
      <li class="phone">
        <label class="w127" for="phone"><span class="c1">*</span>手机号码：</label>
        <span class="origin_phone Input_1">{{$rent_shop['phone']}}</span>
        <input type="text" name="info[phone]" value="{{$rent_shop['phone']}}" class="Input_1 hidbox" id='phone' />
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
        <li>
          <label class="w127"><span class="c1">*</span>类别：</label>
          <label><input type="radio" value="0" name="info[rent_type]" <?php if($rent_shop['rent_type'] == 0) { echo "checked"; } ?> />商铺出租</label>
          <label><input type="radio" value="1" name="info[rent_type]" <?php if($rent_shop['rent_type'] == 1) { echo "checked"; } ?> />商铺转让</label>
          <input type="hidden" id="rent_type"/>
        </li>
        <li class="pr">
          <label class="w127" for="community_name"><span class="c1">*</span>商铺名称：</label>
          <input type="text" autocomplete="off" maxlength="15" class="Input_1" style="width:300px;" id="community_name" name="info[community_name]" value="<?php echo $rent_shop['community_name']; ?>" />
          <ul id="lp_results" class="lp_results pa" style="display: none;">
          </ul>
        </li>
        <li>
          <label class="w127" for="address"><span class="c1">*</span>商铺地址：</label>
          {{ Form::text('info[address]', $rent_shop['address'], array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'address' )) }}
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>区域：</label>
          <select autocomplete="off" class="input_7" name="info[region_id]" id="area_top">
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == 0 ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $areas[$rent_shop['area_id']]['pid'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
          <select autocomplete="off" class="input_7" id="area" name="info[area_id]" >
            <option value="0">请选择</option>
            <?php foreach ($areas as $key => $area) { ?>
            <?php if ($area['pid'] == $areas[$rent_shop['area_id']]['pid'] ) { ?>
            <option value="<?php echo $area['id']; ?>" <?php if( $area['id'] == $rent_shop['area_id'] ) { echo "selected"; } ?>><?php echo $area['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>商铺类型：</label>
          <select class="input_7" name="info[type_id]" id="type">
            <option value="">请选择</option>
            <?php foreach ($types as $key => $type) { ?>
            <option value="<?php echo $type['id']; ?>" <?php if( $type['id'] == $rent_shop['type_id'] ) { echo "selected"; } ?>><?php echo $type['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>铺面类型：</label>
          <select class="input_7" name="info[shop_face_type_id]" id="shop_face_type_id">
            <option value="">请选择</option>
            <?php foreach ($shop_face_types as $key => $type) { ?>
            <option value="<?php echo $type['id']; ?>" <?php if( $type['id'] == $rent_shop['shop_face_type_id'] ) { echo "selected"; } ?>><?php echo $type['name']; ?></option>
            <?php } ?>
          </select>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>当前状态：</label>
          <label><input type="radio" value="0" name="info[shop_status]" <?php echo $rent_shop['shop_status'] == 0 ? 'checked' : ""; ?> />营业中</label>
          <label><input type="radio" value="1" name="info[shop_status]" <?php echo $rent_shop['shop_status'] == 1 ? 'checked' : ""; ?> />闲置中</label>
          <label><input type="radio" value="2" name="info[shop_status]" <?php echo $rent_shop['shop_status'] == 2 ? 'checked' : ""; ?> />新铺</label>
          <input type="hidden" id="shop_status"/>
        </li>

        <li class="clearfix">
          <label class="w127 flptao"><span class="c1">*</span>可经营类别： </label>
          <div class="frptao">
            <?php foreach ($shop_manager_types as $key => $value) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $value['id']; ?>" name="info[shop_manager_type][]" <?php if (in_array($value['id'], $rent_shop['shop_manager_type'])) { echo "checked"; } ?> autocomplete="off" /><?php echo $value['name']; ?></label>
            <?php } ?>
            <input type="hidden" name="shop_manager_type_check" id="shop_manager_type_check"/>
          </div>
        </li>

        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>建筑面积：</label>
          {{ Form::text('info[construction_area]', $rent_shop['construction_area'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>

        <li>
          <label class="w127" for="price"><span class="c1">*</span>租金：</label>
          {{ Form::text('info[price]', $rent_shop['price'], array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }}
          <label><input type="radio" value="0" name="info[price_unit]" <?php echo $rent_shop['price_unit'] == 0 ? 'checked' : ""; ?> />元/月</label>
          <label><input type="radio" value="1" name="info[price_unit]" <?php echo $rent_shop['price_unit'] == 1 ? 'checked' : ""; ?> />元/平米/天</label>
          <label><input type="radio" value="2" name="info[price_unit]" <?php echo $rent_shop['price_unit'] == 2 ? 'checked' : ""; ?> />元/平米/月</label>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>支付方式：</label>
          <?php foreach ($pay_methods as $key => $method) { ?>
          <label><input type="radio" value="<?php echo $method['id'] ?>" <?php echo $key == $rent_shop['pay_method_id'] ? 'checked' : ""; ?> name="info[pay_method_id]" /><?php echo $method['name']; ?></label>
          <?php } ?>
          <input type="hidden" id="pay_method_id"/>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>装修程度：</label>
          <select class="input_7" name="info[decoration_id]" id="slt_House_Fitment">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($decorations as $key => $decoration) { ?>
            <option value="<?php echo $decoration['id']; ?>"<?php if( $decoration['id'] == $rent_shop['decoration_id'] ) {echo " selected";} ?>><?php echo $decoration['name']; ?></option>
            <?php } ?>
          </select>
        </li>

        <li class="clearfix">
          <label class="w127 flptao">房屋配套： </label>
          <div class="frptao">
            <?php foreach ($house_supportings as $key => $supporting) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $supporting['id']; ?>" name="info[supporting][]" <?php if (in_array($supporting['id'], $rent_shop['supporting'])) { echo "checked"; } ?> autocomplete="off" /><?php echo $supporting['name']; ?></label>
            <?php } ?>
            <input type="button" class="selectall" onclick="selectall('info[supporting][]');" value="全选" />
          </div>
        </li>

        <li>
          <label class="w127"><span class="c1">*</span>有 效 期：</label>
          <select id="validity" class="input_7" name="info[validity]">
            <option value="15" <?php if( 15 == $rent_shop['validity'] ) {echo " selected";} ?>>15</option>
            <option value="30"<?php if( 30 == $rent_shop['validity'] ) {echo " selected";} ?>>30</option>
            <option value="60"<?php if( 60 == $rent_shop['validity'] ) {echo " selected";} ?>>60</option>
          </select>
          <span>天</span>
        </li>

        <li>
          <label class="w127 fl" for="input_LinkMan">特色标签：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($tags as $key => $tag) { ?>
              <li <?php if ( in_array($tag['id'], $rent_shop['tag']) ) { echo ' class="active"'; } ?>>
                <label for="{{$tag['id']}}"><?php echo $tag['name']; ?></label>
                <input type="checkbox" id="{{$tag['id']}}" name="info[tag][]"<?php if ( in_array($tag['id'], $rent_shop['tag']) ) { echo ' checked'; } ?> value="<?php echo $tag['id']; ?>"  autocomplete="off" />
              </li>
              <?php } ?>
            </ul>
            <ul class="brightspot" id="brightspot">
              <?php foreach ($rent_shop['customer_tag'] as $key => $tag) { ?>
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
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" autocomplete="off" value="<?php echo $rent_shop['title']; ?>" />
        </li>

        <li class="clearfix">
          <label class="w127 flptao" for="input_DESCRIPTION">房源描述：</label>
          <div class="frptao">
            <textarea style="width:568px;height:120px;" name="info[content]"><?php echo \lib\Tool::br2nl($rent_shop['content']); ?></textarea>
          </div>
        </li>

        <li class="clearfix">
          <label class="w127 flptao">上传图片：</label>
          <div class="clearfix pre-z" id="">
            <div id="preview">
              <?php foreach ($rent_shop['room_images'] as $key => $room_image) { ?>
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
              <p class="f12 c1 mt5">已上传图片<span class="c1 upload_count">{{count($rent_shop['room_images'])}}</span>/10，支持多张上传，最多上传10张，单张照片不超过3M。真实且未经处理的照片更能吸引网友关注。</p><p>如果图片太大，请把图片发给客服QQ：421467754或者发送邮件到421467754@qq.com，附上房源的网址，我们代处理。</p>
            </div>
          </div>
        </li>

        <!-- <li class="commission">
          <div class="mb30 mt20 tc">
            <a class="wt_button {{ $rent_shop['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='1'><strong>快速委托</strong></a>
            <a class="wt_button {{ !$rent_shop['is_commissioned'] ? 'active' : '' }}" href="#" data-commission='0'><strong>个人发布</strong></a>
            <input type="hidden" name="info[is_commissioned]" value="{{{$rent_shop['is_commissioned']}}}" />
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
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidator.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidatorregex.js"); ?>"></script>
<script type="text/javascript" src="<?php echo asset("assets/js/uploadify/jquery.uploadify.js"); ?>"></script>

<script type="text/javascript">
  var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>', 'image_num' : {{count($rent_shop['room_images'])}} };
  // 所有小区名称列表JSON, 需要字段id, address, title, price。
  $.getJSON( '<?php echo route("houselist"); ?>', function( data ) {
    GlobalParams.houses = data;
    // console.log(data);
  });
  GlobalParams.areas = $.parseJSON('<?php echo json_encode($areas); ?>');
  var customer_tag = <?php echo count($rent_shop['customer_tag']); ?>;
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

    $("#pay_method_id").formValidator({onshow:"",onfocus:""}).functionValidator({ fun:function( val, elem ){
      if ( $('input[name="info[pay_method_id]"]').is(":checked") ) {
        return true;
      } else {
        return "支付方式是必选项";
      }
    }}).defaultPassed();
    $("#community_name").formValidator({onshow:"请填写楼盘名称",onfocus:"使用标准小区名称更有利于网友搜索到您的房源"}).inputValidator({min:1,onerror:"楼盘名称必填"}).defaultPassed();
    $("#area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"}).defaultPassed();
    $("#type").formValidator({onshow:"请选择商铺类型",onfocus:"请选择商铺类型"}).inputValidator({min:1,onerror:"商铺类型必选区域"}).defaultPassed();
    $("#shop_face_type_id").formValidator({onshow:"请选择铺面类型",onfocus:"请选择铺面类型"}).inputValidator({min:1,onerror:"铺面类型必选区域"}).defaultPassed();
    $("#address").formValidator({onshow:"请填写房源详细地址",onfocus:"请填写房源详细地址"}).inputValidator({min:1,onerror:"地址必填"}).defaultPassed();
    $("#validity").formValidator({onshow:"请填写有效期",onfocus:"请填写有效期"}).inputValidator({}).regexValidator({regExp:'intege1',onerror:"有效期格式不正确"}).defaultPassed();

    $("shop_manager_type_check").formValidator({onshow:"请选择营类别",onfocus:"请填写选择营类别"}).functionValidator({fun:function(val,elem){ return true; }}).defaultPassed();

    $("#construction_area").formValidator({onshow:"请填写产证面积",onfocus:"请填写产证面积"}).inputValidator({min:1,onerror:"建筑面积不能为空"}).defaultPassed();
    $("#price").formValidator({onshow:"请填写期望的租金",onfocus:"请填写期望的租金"}).inputValidator({min:1,onerror:"租金不能为空"}).defaultPassed();
    $("#decoration_id").formValidator({onshow:"请选择装修程度",onfocus:"请选择装修程度"}).inputValidator({min:1,onerror:"装修程度必选"}).defaultPassed();

    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"}).defaultPassed();
    /* 表单验证结束 */

  });
</script>
@stop