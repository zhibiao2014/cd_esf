@extends('layouts.main')
@section('content')
<div class="set_cent fr">
  @if (Session::has('message'))
  <div class="alert alert-info">{{ Session::get('message') }}</div>
  @endif
  {{ HTML::ul($errors->all() )}}
  {{ Form::open(array( 'route' => array('rent_shop.store'), 'id' => 'residence' )) }}
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
          <input type="radio" value="" name="public" data-url="<?php echo route('rent.create'); ?>"/>
          <span class="mr20">住宅</span>
        </label>
        <!-- <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('rent_villas.create'); ?>"/>
          <span class="mr20">别墅</span>
        </label> -->
        <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('rent_office.create'); ?>" />
          <span class="mr20">写字楼</span>
        </label>
        <label class="tab02">
          <input type="radio" value="" name="public" data-url="<?php echo route('rent_shop.create'); ?>" checked="checked" />
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
        <li>
          <label class="w127"><span class="c1">*</span>类别：</label>
          <label><input type="radio" value="0" name="info[rent_type]" checked />商铺出租</label>
          <label><input type="radio" value="1" name="info[rent_type]" />商铺转让</label>
          <input type="hidden" id="rent_type"/>
        </li>
        <li class="pr">
          <label class="w127" for="community_name"><span class="c1">*</span>商铺名称：</label>
          <input type="text" autocomplete="off" maxlength="15" class="Input_1" style="width:300px;" id="community_name" name="info[community_name]"/>
          <ul id="lp_results" class="lp_results pa" style="display: none;">
          </ul>
        </li>
        <li>
          <label class="w127" for="address"><span class="c1">*</span>商铺地址：</label>
          {{ Form::text('info[address]', Input::old('info[address]'), array('class' => 'Input_1', 'style' => 'width:300px;', 'id' => 'address' )) }}
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
          <label class="w127"><span class="c1">*</span>商铺类型：</label>
          <select class="input_7" name="info[type_id]" id="type">
            <option selected="" value="">请选择</option>
            <?php foreach ($types as $key => $type) { ?>
            <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>铺面类型：</label>
          <select class="input_7" name="info[shop_face_type_id]" id="shop_face_type_id">
            <option selected="" value="">请选择</option>
            <?php foreach ($shop_face_types as $key => $type) { ?>
            <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>当前状态：</label>
          <label><input type="radio" value="0" name="info[shop_status]" checked />营业中</label>
          <label><input type="radio" value="1" name="info[shop_status]" />闲置中</label>
          <label><input type="radio" value="2" name="info[shop_status]" />新铺</label>
          <input type="hidden" id="shop_status"/>
        </li>
        <li class="clearfix">
          <label class="w127 flptao">可经营类别：</label>
          <div class="frptao">
            <?php foreach ($shop_manager_types as $key => $value) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $value['id']; ?>" name="info[shop_manager_type][]" autocomplete="off" /><?php echo $value['name']; ?></label>
            <?php } ?>
            <input type="hidden" name="shop_manager_type_check" id="shop_manager_type_check"/>
          </div>
        </li>
        <li>
          <label class="w127" for="construction_area"><span class="c1">*</span>建筑面积：</label>
          {{ Form::text('info[construction_area]', Input::old('info[construction_area]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'construction_area' )) }}平方米
        </li>
        <li>
          <label class="w127" for="price"><span class="c1">*</span>租金：</label>
          {{ Form::text('info[price]', Input::old('info[price]'), array('class' => 'Input_1', 'style' => 'width:120px;', 'id' => 'price' )) }}
          <label><input type="radio" value="0" name="info[price_unit]" checked />元/月</label>
          <label><input type="radio" value="1" name="info[price_unit]" />元/平米/天</label>
          <label><input type="radio" value="2" name="info[price_unit]" />元/平米/月</label>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>支付方式：</label>
          <?php foreach ($pay_methods as $key => $method) { ?>
          <label><input type="radio" value="<?php echo $method['id'] ?>" <?php echo $key == 0 ? 'checked' : ""; ?> name="info[pay_method_id]" /><?php echo $method['name']; ?></label>
          <?php } ?>
          <input type="hidden" id="pay_method_id"/>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>装修程度：</label>
          <select class="input_7" name="info[decoration_id]" id="decoration_id">
            <option selected="selected" value="">请选择</option>
            <?php foreach ($decorations as $key => $decoration) { ?>
            <option value="<?php echo $decoration['id']; ?>"><?php echo $decoration['name']; ?></option>
            <?php } ?>
          </select>
        </li>
        <li class="clearfix">
          <label class="w127 flptao">房屋配套：</label>
          <div class="frptao">
            <?php foreach ($house_supportings as $key => $supporting) { ?>
            <label class="w127 fwptcheck"><input type="checkbox" value="<?php echo $supporting['id']; ?>" name="info[supporting][]" autocomplete="off" /><?php echo $supporting['name']; ?></label>
            <?php } ?>
            <input type="button" class="selectall" onclick="selectall('info[supporting][]');" value="全选" />
          </div>
        </li>
        <li>
          <label class="w127"><span class="c1">*</span>有 效 期：</label>
          <select id="validity" class="input_7" name="info[validity]">
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="60">60</option>
          </select>
          <span>天</span>
        </li>
        <li>
          <label class="w127 fl" for="input_LinkMan">特色标签：</label>
          <div class="contedit fl">
            <ul class="welfare" id="fuli">
              <?php foreach ($tags as $key => $tag) { ?>
              <li>
                <label for="{{$tag['id']}}"><?php echo $tag['name']; ?></label>
                <input type="checkbox" id="{{$tag['id']}}" name="info[tag][]" value="<?php echo $tag['id']; ?>"  autocomplete="off" />
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
          <input type="text" maxlength="40" size="40" class="Input_1" style="width:300px;" id="title" name="info[title]" autocomplete="off" />
        </li>
        <li class="clearfix">
          <label class="w127 flptao" for="input_DESCRIPTION">房源描述：</label>
          <div class="frptao">
            <textarea style="width:568px;height:120px;" name="info[content]"></textarea>
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

    $("#pay_method_id").formValidator({onshow:"",onfocus:""}).functionValidator({ fun:function( val, elem ){
      if ( $('input[name="info[pay_method_id]"]').is(":checked") ) {
        return true;
      } else {
        return "支付方式是必选项";
      }
    }});
    $("#community_name").formValidator({onshow:"请填写楼盘名称",onfocus:"使用标准小区名称更有利于网友搜索到您的房源"}).inputValidator({min:1,onerror:"楼盘名称必填"});
    $("#area").formValidator({onshow:"请选择区域",onfocus:"请选择区域"}).inputValidator({min:1,onerror:"城区必选区域"});
    $("#type").formValidator({onshow:"请选择商铺类型",onfocus:"请选择商铺类型"}).inputValidator({min:1,onerror:"商铺类型必选区域"});
    $("#shop_face_type_id").formValidator({onshow:"请选择铺面类型",onfocus:"请选择铺面类型"}).inputValidator({min:1,onerror:"铺面类型必选区域"});
    $("#address").formValidator({onshow:"请填写房源详细地址",onfocus:"请填写房源详细地址"}).inputValidator({min:1,onerror:"地址必填"});
    $("#validity").formValidator({onshow:"请填写有效期",onfocus:"请填写有效期"}).inputValidator({}).regexValidator({regExp:'intege1',onerror:"有效期格式不正确"}).defaultPassed();

    $("#shop_manager_type_check").formValidator({onshow:"请填写选择经营类别",onfocus:"请填写选择经营类别"}).functionValidator({fun:function(val,elem){ return true; }});

    $("#construction_area").formValidator({onshow:"请填写产证面积",onfocus:"请填写产证面积"}).inputValidator({min:1,onerror:"建筑面积不能为空"});
    $("#price").formValidator({onshow:"请填写期望的租金",onfocus:"请填写期望的租金"}).inputValidator({min:1,onerror:"租金不能为空"});
    $("#decoration_id").formValidator({onshow:"请选择装修程度",onfocus:"请选择装修程度"}).inputValidator({min:1,onerror:"装修程度必选"});

    $("#title").formValidator({onshow:"吸引人的标题可以更快的促进交易哦！",onfocus:"吸引人的标题可以更快的促进交易哦！"}).inputValidator({min:1,onerror:"标题必填"});
    /* 表单验证结束 */

});
</script>
@stop