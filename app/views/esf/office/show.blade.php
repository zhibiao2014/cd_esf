@extends('layouts.esf')
@section('content')
<!--center start-->
<div class="cen_esf clearfix">
  <div class="esf_title_box pl10 pr10 mb10">
    <div class="fr"><a href="{{{route('esf.house.index')}}}" class="c5">切换到房源列表&gt;&gt;</a></div>
    <h1>{{{$house->title}}}</h1>
    <p class="c2">发布时间：{{{$house->created_at}}}(<span id="Time">{{{ '刷新时间: ' . \lib\Tool::get_timeago( strtotime( $house->refresh_at ) ) }}}</span>)</p>
  </div>
  <div class="fl esfcenLt">
    <div class="one_box mb10">
      <div class="clearfix">
        <div class="fr pr10 pt10">
          <!-- Baidu Button BEGIN -->
          <div class="bshare-custom"><span>分享到：</span><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="分享到腾讯微博" class="bshare-qqmb"></a><a title="分享到网易微博" class="bshare-neteasemb"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a></div>
          <!-- Baidu Button END -->
        </div>
        <div class="pt10 pl10">
          <?php $i = 0; ?>
          @if ( !empty($house->tag) )
          @foreach ( $tags as $tag )
          @if ( in_array( $tag->id, $house->tag ) )
          <span class="label_fang g_tagSon{{($i++%4)+1}}">{{{$tag->name}}}</span>
          @endif
          @endforeach
          @endif

          <?php $customer_tag = json_decode($house->customer_tag, true); ?>
          @if ( !empty( $customer_tag ) )
          @foreach ( $customer_tag as $value )
          <span class="label_fang g_tagSon{{($i++%4)+1}}">{{{$value}}}</span>
          @endforeach
          @endif

        </div>
      </div>
      <div class="p10">
        <!-- /*幻灯*/start -->
        <div class="w356 fl" id="slideContainer">
          <div id="frameHlicAe">
            @if ( !empty($house->room_images) )
            <ul class="slideshow3" id="slidesImgs">
              @foreach( $house->room_images as $image )
              <li>
                <a href="javascript:"><img src="{{{$image['url']}}}" width="356" height="267" /></a>
              </li>
              @endforeach
            </ul>
            <div class="slidebar mt5" id="slideBar">
              <?php $i = 1; ?>
              @foreach( $house->room_images as $image )
              <span <?php echo $i == 1 ? ' class="on"' : ''; ?>>{{{$i++}}}</span>
              @endforeach
            </div>
            @else
            <img src="{{{asset('assets/images/esf/moren.jpg')}}}"  width="356" height="267"/>
            @endif
          </div>
        </div>
        <!-- /*幻灯*/end -->
        <div class="un1_box t_no w380 fr">
          <ul class="Flist clearfix p10">
            <li><em>总价：</em><span class="c1 f16">{{{$house->price}}}</span>万元</li>
            <li><em>联系人：</em><span class="c1 f16">{{{$house->contacts}}}</span></li>
            <li class="pr tslw"><em>面积：</em><span>{{{$house->construction_area}}}㎡</span></li>
            <li><em>楼层：</em><span>第{{{$house->current_floor}}}层，共{{{$house->total_floor}}}层</span></li>
            <li class="w_w"><em>地址：</em><span>{{{$house->address}}}</span></li>
          </ul>
          <div class="phone_top ml20"><span id="mobilecode">{{{$house->phone}}}</span></div>
          <ul class="Flist clearfix p10">
            <li>
              <em>区域：</em><span>{{{isset($regions[$house->area_id]) ? $regions[$house->area_id]['name'] : ''}}}{{isset($regions[$house->region_id]) ? '-' . $regions[$house->region_id]['name'] : ''}} </span>
            </li>
            <li><em>装修：</em><span>{{{isset($decorations[$house->decoration_id]) ? $decorations[$house->decoration_id]['name'] : '' }}}</span></li>
            <li>
              <em>小区：</em> <span><a href="{{ !empty($house->community_id) ? route('esf.community.show', $house->community_id) : 'javascript:void(0);' }}">{{{$house->community_name}}}</a></span>
            </li>
            <li class="w_w">
              <em>交通状况：</em> <span>{{\lib\Tool::trim_script($house->traffic)}}</span>
            </li>
          </ul>
        </div>
        <div class="clear"></div>
        <!-- <ul class="tool">
          <li class="icon_send"><a href="javascript:void(0)" title="发送到手机" onclick="showDialog.show({id:'UpdatePanel1'});">发送到手机</a></li>
          <li class="icon_order"><a href="javascript:void(0)" title="预约看房" onclick="showDialog.show({id:'UpdatePanel3'});">预约看房</a></li>
          <li class="icon_report"><a href="javascript:void(0)" title="举报虚假房源" onclick="showDialog.show({id:'UpdatePanel2'});">举报虚假</a></li>
          <li id="esfshxq_105" class="icon_collect"><a href="javascript:void(0)" title="收藏到选房单" onclick="shoucang()">收藏</a></li>
        </ul> -->
        <div class="clear"></div>
      </div>
    </div>
    <div class="one_box mb10 p10">
      <div class="house_detail">
        <div class="tilte">
          <ul>
            <li id="anchor_des" style="padding-left: 0pt;" class="li_on">房源详情</li>
            <li class="li_line">|</li>
            <li><a href="#anchor_pic" rel="nofollow">房源图片({{{count($house->room_images)}}})</a></li>
            @if ( isset($community) && !empty($community) )
            <li class="li_line">|</li>
            <li id="esfshxq_113"><a href="#anchor_int" rel="nofollow">小区简介</a></li>
            @endif
          </ul>
          <span class="more"><a id="esfshxq_114" href="#" rel="nofollow">返回顶部</a></span>
        </div>
        <div class="describe mt10">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="w-120">标题</td>
              <td><strong>{{{$house->title}}}</strong></td>
              <td class="w-120">小区</td>
              <td><a href="{{ !empty($house->community_id) ? route('esf.community.show', $house->community_id) : 'javascript:void(0);' }}">{{{$house->community_name}}}</a></td>
            </tr>
            <tr>
              <td class="w-120">区域</td>
              <td>{{{isset($regions[$house->area_id]) ? $regions[$house->area_id]['name'] : ''}}}{{isset($regions[$house->region_id]) ? '-' . $regions[$house->region_id]['name'] : ''}}</td>
              <td class="w-120">地址</td>
              <td>{{{$house->address}}}</td>
            </tr>
            <tr>
              <td class="w-120">建筑面积</td>
              <td>{{{ $house->construction_area }}}</td>
              <td class="w-120">建筑年代</td>
              <td>{{{$house->construct_year}}}</td>
            </tr>
            <tr>
              <td class="w-120">物业费</td>
              <td>{{{ $house->property_costs }}}元/平米/月</td>
              <td class="w-120">物业公司</td>
              <td>{{{$house->property_corporation}}}</td>
            </tr>
            <tr>
              <td class="w-120">装修程度</td>
              <td>{{{isset($decorations[$house->decoration_id]) ? $decorations[$house->decoration_id]['name'] : '' }}}</td>
              <td class="w-120">有效期</td>
              <td>{{{ $house->validity }}}</td>
            </tr>
            <tr>
              <td class="w-120">房屋配套</td>
              <td colspan="3">
              @if ( !empty($house->supporting) )
              @foreach ( $house->supporting as $key => $support )
              @if ( isset( $house_supportings[$support] ) )
              {{{ $key == 0 ? $house_supportings[$support]['name'] : ' , ' . $house_supportings[$support]['name'] }}}
              @endif
              @endforeach
              @endif
              </td>
            </tr>
            <tr>
              <td class="w-120">交通状况</td>
              <td colspan="3">{{\lib\Tool::trim_script($house->traffic)}}</td>
            </tr>
            <tr>
              <td class="w-120">周边配套</td>
              <td colspan="3">{{\lib\Tool::trim_script($house->around)}}</td>
            </tr>
            <tr>
              <td class="w-120">房源描述</td>
              <td colspan="3">{{\lib\Tool::trim_script($house->content)}}</td>
            </tr>
          </table>
        </div>
        <div class="clear"> </div>
      </div>
    </div>
    <div class="one_box mb10 p10">
      <div class="house_detail">
        <div class="tilte">
          <ul>
            <li style="padding-left: 0pt;"><a href="#anchor_des" class="nofollow">房源详情</a></li>
            <li class="li_line">|</li>
            <li class="li_on" id="anchor_pic">房源图片({{{count($house->room_images)}}})</li>
            @if ( isset($community) && !empty($community) )
            <li class="li_line">|</li>
            <li id="esfshxq_113"><a href="#anchor_int" rel="nofollow">小区简介</a></li>
            @endif
          </ul>
          <span class="more"><a id="A1" href="#" rel="nofollow">返回顶部</a></span>
        </div>
        <div class="describe mt10">
          @if ( !empty($house->room_images) )
          @foreach( $house->room_images as $image )
          <div class="img"><img alt="房型图" src="{{{$image['url']}}}"></div>
          @endforeach
          @endif
        </div>
      </div>
    </div>
    @if ( isset($community) && !empty($community) )
    <div class="one_box mb10 p10">
      <div class="house_detail">
        <div class="tilte">
          <ul>
            <li id="esfshxq_122" style="padding-left: 0pt;"><a href="#anchor_des">房源详情</a></li>
            <li class="li_line">|</li>
            <li><a href="#anchor_pic" rel="nofollow">房源图片({{{count($house->room_images)}}})</a></li>
            <li class="li_line">|</li>
            <li class="li_on" id="anchor_int">小区简介</li>
          </ul>
          <span class="more"><a id="esfshxq_124" href="#">返回顶部</a></span>
        </div>
        <div class="introduct mt10">
          <dl class="mt10">
            <dt>
              <span class="c23">楼盘名称：</span>
              <a href="{{{route('esf.community.show', $community->id)}}}">{{{$community->title}}}</a>
              ( {{{$cdfdc_regions[$community->area]['name'] }}} )  &nbsp;&nbsp;
              <a target="_blank" href="{{Config::get('app.url')}}/house/view/{{{$community->id}}}.html">查看楼盘详情&gt;&gt;</a>
            </dt>
            <dd>
              <span class="c23">物业类型：</span>
              @foreach ( $community->wuye as $key => $value )
              {{ $key>0 ? ', ' : ''; }}{{{$wuye[$value]}}}
              @endforeach
            </dd>
            <dd><span class="c23">绿 化 率：</span>{{{$community->greening_rate}}}%</dd>
            <dd><span class="c23">物 业 费：</span>{{{$community->property_costs}}}元/平方米·月</dd>
            <dd><span class="c23">物业公司：</span>{{{$community->property_company}}}</dd>
            <dd><span class="c23">开 发 商：</span>{{{$community->company}}}</dd>
            <div class="clear"></div>
          </dl>
          <div class="clear"></div>

          <h2 class="mt10"><span class="xcMore"><a target="_blank" href="{{{ Config::get('app.url') . '/house/view/huxing/' . $community->id . '.html'}}}">户型图</a></span><span class="xcMore"><a target="_blank" href="{{{ Config::get('app.url') . '/house/view/xiangce/' . $community->id . '.html'}}}">全部图片</a></span>小区相册</h2>
          <div class="img">
            @foreach( $community->show_pictures as $pic )
            <li>
              <img width="180px" height="134px" src="{{{Config::get('app.url').$pic['url']}}}">
              <span>{{{$pic['title']}}}</span>
            </li>
            @endforeach
            <div class="clear"></div>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    @endif
  </div>
  <div class="fr esfcenRt">
    @if ( $house->is_broker && !empty($user) )
    <div class="one_box mb10">
      <div class="photoBox p10 tc">
        <a title="{{{$user->realname}}}" href="{{{route('esf.broker.show', $user->id)}}}" class="pic_k">
          <img alt="{{{$user->realname}}}" src="{{{ Config::get( 'app.url' ) . $user->photo }}}">
        </a>
        <p>{{{$user->realname}}}</p>
        @if (isset($company->gsmc))
        <p>
          <a href="{{{route('esf.company.show', $company->id)}}}" target="_blank" class="c1">{{{$company->gsmc}}}</a>
        </p>
        @endif
        <p><a href="{{{route('esf.broker.show', $user->id)}}}" target="_blank">进入网上店铺 &gt;&gt;</a></p>
      </div>
      <ul class="renzheng clearfix">
        <li>
          <p><img src="{{{asset('assets/images')}}}/esf/attest_1.gif" alt="已通过身份证认证"></p>
          <p>身份认证</p>
        </li>
        <li>
          <p><img src="{{{asset('assets/images')}}}/esf/attest_2.gif" alt="已通过名片认证"></p>
          <p>名片认证</p>
        </li>
      </ul>
    </div>
    @endif
    <!-- <div class="un1_box one_box mb10">
      <div class="t1 clearfix">
        <h4 class="t2">最近浏览过的房源</h4>
      </div>
      <ul class="column_c clearfix">
        <li><span class="wid75"> <a title="泰达润景园" href="#" target="_blank">泰达润景园</a></span><span class="wid45"> 96㎡</span><span class="wid60 c1"><a target="_blank" href="#">550万</a></span></li>
        <li><span class="wid75"> <a title="泰达润景园" href="#" target="_blank">泰达润景园</a></span><span class="wid45"> 96㎡</span><span class="wid60 c1"><a target="_blank" href="#">550万</a></span></li>
        <li><span class="wid75"> <a title="泰达润景园" href="#" target="_blank">泰达润景园</a></span><span class="wid45"> 96㎡</span><span class="wid60 c1"><a target="_blank" href="#">550万</a></span></li>
        <li><span class="wid75"> <a title="泰达润景园" href="#" target="_blank">泰达润景园</a></span><span class="wid45"> 96㎡</span><span class="wid60 c1"><a target="_blank" href="#">550万</a></span></li>
      </ul>
    </div> -->
    <div class="un1_box one_box mb10">
      <div class="t1 clearfix">
        <h4 class="t2">本小区其他写字楼</h4>
      </div>
      @if ( is_array($community_other_house) && !empty($community_other_house) )
      <ul class="column_c clearfix">
        @foreach ( $community_other_house as $value )
        <li>
          <span class="wid75">
            <a title="{{{$value['title']}}}" href="{{{route('esf.house.show', $value['id'])}}}">{{{$value['title']}}}</a>
          </span>
          <span class="wid45"> {{{$value['construction_area']}}}㎡</span><span class="wid60 c1">{{{$value['price']}}}万</span>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
    <div class="un1_box one_box mb10">
      <div class="t1 clearfix">
        <h4 class="t2">与之相近价格的写字楼</h4>
      </div>
      @if ( is_array($price_siblings)  && !empty($price_siblings) )
      <ul class="column_c clearfix">
        @foreach ( $price_siblings as $value )
        <li>
          <span class="wid75">
            <a title="{{{$value['title']}}}" href="{{{route('esf.house.show', $value['id'])}}}">{{{$value['title']}}}</a>
          </span>
          <span class="wid45"> {{{$value['construction_area']}}}㎡</span><span class="wid60 c1">{{{$value['price']}}}万</span>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
    @if ( isset( $broker_other_house ) )
    <div class="un1_box one_box mb10">
      <div class="t1 clearfix">
        <h4 class="t2">该经纪人其他写字楼</h4>
      </div>
      @if ( is_array($broker_other_house) && !empty( $broker_other_house ))
      <ul class="column_c clearfix">
        @foreach ( $broker_other_house as $value )
        <li>
          <span class="wid75">
            <a title="{{{$value['title']}}}" href="{{{route('esf.house.show', $value['id'])}}}">{{{$value['title']}}}</a>
          </span>
          <span class="wid45"> {{{$value['construction_area']}}}㎡</span><span class="wid60 c1">{{{$value['price']}}}万</span>
        </li>
        @endforeach
      </ul>
      @endif
    </div>
    @endif
  </div>
</div>
<!--center end-->
<div class="clear mb10"></div>
@stop

@section('lightbox')
<!--发送房源到手机 弹出层 sta-->
<div id="UpdatePanel1" style="display:none">
  <div class="popbox">
    <div class="tit clearfix">
      <h1> 发送到手机</h1>
      <a onclick="showDialog.hide()" class="close" href="javascript:void();"> </a>
    </div>
    <p> 以下内容将发送到您的手机上</p>
    <div class="send-msg">
      <span id="lblTitle">上品雅园，总价：162万，面积：75平米<br> 两房两厅， 经纪人：蔡俊15768275294</span>
    </div>
    <div id="divAlert" class="msg clearfix"> 带*的为必填项</div>
    <dl>
      <dt><span class="c1">*</span>手机：</dt>
      <dd>
        <input type="text" onpaste="return checkPhoneNumInput(2)" onkeypress="return checkPhoneNumInput(1)" class="base-inp w220 h28 mr10" id="txtPhoneNo" maxlength="11" name="txtPhoneNo">
      </dd>
      <dd>
        <input type="submit" class="send-nz" id="btnSend" onclick="javascript:return checkPhoneNum();" value="发送验证码" name="btnSend">
      </dd>
    </dl>
    <dl>
      <dt><span class="c1">*</span>验证码：</dt>
      <dd>
        <input type="text" class="base-inp w220 h28" id="txtCheckNo" name="txtCheckNo">
      </dd>
    </dl>
    <div class="bottom clearfix">
      <input type="submit" class="base-but red-bg mr15" id="btnSave" onclick="return checkData();" value="确定" name="btnSave">
      <input type="button" onclick="javascript:parent.$.modal.close();" value="取消" class="base-but gray-bg02" name="">
    </div>
  </div>
</div>
<!-- 发送房源到手机 弹出层 end -->
<!--举报 弹出层 sta-->
<div id="UpdatePanel2" style="display:none">
  <div style="width: 420px; height:313px;" class="popbox">
    <div class="tit clearfix">
      <h1> 举报</h1>
      <a onclick="showDialog.hide()" class="close" href="javascript:void();"></a>
    </div>
    <div id="divAlert" class="msg clearfix"> 带*的为必填项</div>
    <dl>
      <dt><span class="c1">*</span>举报理由：</dt>
      <dd>
        <select class="base-inp w220 h28 mr15" id="rbtlReasonType" name="rbtlReasonType">
          <option value="1" selected="selected">联系方式错误</option>
          <option value="2">房源信息错误</option>
          <option value="3">其它错误信息</option>
        </select>
      </dd>
    </dl>
    <dl>
      <dt><span class="c1">*</span>详细说明：<br>
        (100个字以内)
      </dt>
      <dd>
        <textarea class="base-inp w220 h80" id="txtMessage" cols="20" rows="2" name="txtMessage"></textarea>
      </dd>
    </dl>
    <div class="cl"> </div>
    <dl>
      <dt>手机：</dt>
      <dd>
        <input type="text" class="base-inp w220 h28" id="txtPhoneNumber" name="txtPhoneNumber">
      </dd>
    </dl>
    <div class="bottom clearfix">
      <input type="submit" class="base-but red-bg mr15" id="btnSave" onclick="return checkData();" value="确定" name="btnSave">
      <input type="button" onclick="javascript:parent.$.modal.close();" value="取消" class="base-but gray-bg02" name="">
    </div>
  </div>
</div>
<!-- 举报 弹出层 end -->
<!-- 预约看房 弹出层 sta -->
<div id="UpdatePanel3" style="width:420px; height:358px; display:none" class="popbox">
  <div class="tit clearfix">
    <h1> 预约看房</h1>
    <a onclick="showDialog.hide()" class="close" href="javascript:void();"></a>
  </div>
  <div class="msg clearfix" id="divAlert"> 带*的为必填项</div>
  <dl>
    <dt><span class="c1">*</span>选择时间：</dt>
    <dd>
      <select class="base-inp w107 h28 mr15" id="rbtlSubscribeDate" name="rbtlSubscribeDate">
        <option value="1" selected="selected">工作日</option>
        <option value="2">周末</option>
        <option value="3">随时</option>
      </select>
    </dd>
    <dd>
      <select class="base-inp h28 w107" id="rbtlSubscribeTime" name="rbtlSubscribeTime">
        <option value="1" selected="selected">上午</option>
        <option value="2">下午</option>
        <option value="3">晚上</option>
        <option value="4">随时</option>
      </select>
    </dd>
  </dl>
  <dl>
    <dt><span class="c1">*</span>姓名：</dt>
    <dd>
      <input type="text" class="base-inp w130 h28 mr20" id="txtName" name="txtName">
    </dd>
    <dd class="mr10">
      <table border="0" id="rbtlSex">
        <tbody>
          <tr>
            <td><input type="radio" checked="checked" value="1" name="rbtlSex" id="rbtlSex_0">
              <label for="rbtlSex_0">男</label>
            </td>
            <td><input type="radio" value="0" name="rbtlSex" id="rbtlSex_1">
              <label for="rbtlSex_1">女</label>
            </td>
          </tr>
        </tbody>
      </table>
    </dd>
  </dl>
  <dl>
    <dt><span class="c1">*</span>手机：</dt>
    <dd>
      <input type="text" class="base-inp w220 h28" id="txtPhoneNumber" name="txtPhoneNumber">
    </dd>
  </dl>
  <dl>
    <dt>备注：<br>
      (50个字以内)
    </dt>
    <dd>
      <textarea class="base-inp w220 h80" id="txtMessage" cols="20" rows="2" name="txtMessage"></textarea>
    </dd>
  </dl>
  <div class="cl"> </div>
  <div class="bottom clearfix">
    <input type="submit" class="base-but red-bg mr15" id="btnSave" onclick="return checkData();" value="确定" name="btnSave">
    <input type="button" onclick="javascript:parent.$.modal.close();" value="取消" class="base-but gray-bg02" name="">
  </div>
</div>
<!-- 预约看房 弹出层 end -->
@stop

@section('footer')
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=2&amp;lang=zh"></script>
<script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
<script type="text/javascript">
  $(function(){
    if ($('#slidesImgs').length > 0) {
    SlideShow(5000);//幻灯播放速度
  };
});
</script>
@stop