@extends('layouts.esf')
@section('content')
<!--左边-->
<div class="jjrenlt">
  <div class="un2_box btno">
    <div class="titHouse">
      <div class="fl inpbox pl10"> <strong>{{{$company->gsmc}}}</strong> </div>
    </div>

    <!--列表单行 start-->
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
            <td> {{isset($gsgm[$company->gsgm]) ? $gsgm[$company->gsgm] : '未知' }} </td>
          </tr>
          <tr>
            <th>法定代表人</th>
            <td> {{{$company->realname}}} </td>
            <th>联系电话</th>
            <td class="telNum">{{{$company->telphone}}}</td>
          </tr>
          <tr>
            <th>备案编号</th>
            <td>{{{$company->babh}}}</td>
            <th>组织机构代码号：</th>
            <td>{{{$company->zzjgdm}}}</td>
          </tr>
          <tr>
            <th>税务登记证号</th>
            <td>{{{$company->swdjzh}}} </td>
            <th>注册资金：</th>
            <td>{{{$company->zczj}}}</td>
          </tr>
          <tr>
            <th>成立日期</th>
            <td>{{{$company->clrq}}}</td>
            <th>备案期限：</th>
            <td>{{{$company->baqx}}}</td>
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
          <tr>
            <th>公司徽标</th>
            <td>
              <img width="160" height="180" src="{{{ Config::get('app.url') . $company->logo}}}">
            </td>
            <th>法人照片</th>
            <td><img width="160" height="180" src="{{{ Config::get('app.url') . $company->photo}}}"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tabDate clearfix">
      <a class="tab01 tabs" href="#con_fifteen_1"><span>二手房</span></a>
      <a class="tabs" href="#con_fifteen_2"><span>租房</span></a>
      <a class="tabs" href="#con_fifteen_3"><span>经纪人</span></a>
      <a class="tabs" href="#con_fifteen_5"><span>公司简介</span></a>
    </div>
    <div id="con_fifteen_1">
      <div class="boxCens">
        <a href="{{route('esf.house.index')}}" class="mone">更多&gt;&gt;</a>
        <div class="esfbuy">
          <ul>
            @foreach ( $last_houses as $value )
            <li>
              <span class="li2"><strong><a target="_blank" href="{{route( 'esf.' . $value['type'] . '.show', $value['foreign_id'] )}}">{{{$value['title']}}}</a></strong>({{{ isset($regions[$value['area_id']]) ? $regions[$value['area_id']]['name'] : '' }}} {{{ isset($regions[$value['region_id']]) ? $regions[$value['region_id']]['name'] : '' }}})</span>
              @if ( isset( $value['room_structure'] ) )
              <span class="li1">{{{$value['room_structure']}}}</span>
              @endif
              <span class="li3"><strong>{{{$value['price']}}}</strong>元/月</span>
              <span class="li5">{{\lib\Tool::get_timeago( strtotime($value['updated_at']) )}}</span>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div id="con_fifteen_2" class="hidbox">
      <div class="boxCens">
        <a href="{{route('esf.rent.index')}}" class="mone">更多&gt;&gt;</a>
        <div class="esfbuy">
          <ul>
            @foreach( $rents as $value )
            <li>
              <span class="li2"><strong><a target="_blank" href="{{route( 'esf.' . $value['type'] . '.show', $value['foreign_id'] )}}">{{{$value['title']}}}</a></strong>({{{ isset($regions[$value['area_id']]) ? $regions[$value['area_id']]['name'] : '' }}} {{{ isset($regions[$value['region_id']]) ? $regions[$value['region_id']]['name'] : '' }}})</span>
              @if ( isset( $value['room_structure'] ) )
              <span class="li1">{{{$value['room_structure']}}}</span>
              @endif
              <span class="li3"><strong>{{{$value['price']}}}</strong>元/月</span>
              <span class="li5">{{\lib\Tool::get_timeago( strtotime($value['updated_at']) )}}</span>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
    <div id="con_fifteen_3" class="hidbox">
      <div class="boxCens">
        <div class="zjgslb zjgslb2">
          <ul>
            @foreach ($brokers as $key => $broker)
            <li>
              <div class="a3"><a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}"><img border="0" src="{{{ Config::get('app.url') . $broker['photo']}}}"></a></div>
              <div class="a4">
                <span>姓名：<font><a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}">{{{$broker['realname']}}}</a></font></span>
                <span>电话：<font style="color:#333;">{{{$broker['mobile']}}}</font></span>
                <span>
                  出售：<a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}">{{{$broker['publish_num']}}}</a>出租：<a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}">{{{$broker['rent_publish_num']}}}</a>
                </span>
                <dl class="link_0969BD_12">
                  <a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}">进入我的店铺</a>
                </dl>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        <div class="clear"></div>
      </div>
    </div>
    <div id="con_fifteen_5" class="hidbox">
      <div class="boxCens">
        <div class="cenT pt20">
          <p>{{{$company->gsjj}}}</p>
        </div>
      </div>
    </div>
    <!--列表单行 end-->
    <!--列表 start-->
    <!--列表 end-->
  </div>
</div>
<!--右边-->
<div class="jjrenrt">
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">推荐经纪人</h4>
    </div>
    <div class="piccona">
      <ul>
        @foreach ($recommend_brokers as $key => $broker)
        <li>
          <div onmouseover="document.getElementById('{{$key}}').className='ab';" onmouseout="document.getElementById('{{$key}}')').className='aa';" class="aa" id="{{$key}}')">
            <div class="c2">
              <a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}"><img border="0" src="{{{ Config::get('app.url') . $broker['photo']}}}"></a>
            </div>
            <div class="c1"><a target="_blank" href="{{route('esf.broker.show', $broker['id'])}}">{{{$broker['realname']}}}</a></div>
            <div class="c1"> 出售：<a target="_blank" href="{{route('esf.broker.sale_show', $broker['id'])}}">{{{$broker['publish_num']}}}</a>&nbsp;
              出租：<a target="_blank" href="{{route('esf.broker.rent_show', $broker['id'])}}">{{{$broker['rent_publish_num']}}}</a>
            </div>
            <div class="c1">电话：{{{$broker['mobile']}}}</div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear mb10"></div>
  <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">推荐房源</h4>
    </div>
    <div class="RecommendListings">
      @foreach ( $last_houses as $value )
      <dl class="clearfix">
        <dt>
          <a title="{{{$value['community_name']}}}" href="{{route('esf.rent.show', $value['id'])}}"><img alt="{{{$value['community_name']}}}" src="{{empty($value['thumbnail']) ? asset('assets/images/esf/moren.jpg') : $value['thumbnail']}}"></a>
        </dt>
        <dd>
          <h3 class="t4"> <a href="{{route('esf.rent.show', $value['id'])}}">{{{$value['title']}}}</a> </h3>
          <p>
          <span>{{{$value['construction_area']}}}㎡</span>
          @if ( isset( $value['room_structure'] ) )
          <span>{{{$value['room_structure']}}}</span>
          @endif
          <span>{{{$value['price']}}}元</span>
          <span>{{{$value['community_name']}}}</span>
          <span class="c2">{{{ \lib\Tool::get_timeago( strtotime( $value['created_at'] ) ) }}}</span>
          </p>
        </dd>
      </dl>
      @endforeach
    </div>
  </div>
  <div class="clear mb10"></div>
  {{ \lib\Template::feed() }}
  <!-- <div class="un1_box">
    <div class="t1 clearfix">
      <h4 class="t2">意见反馈</h4>
    </div>
    <ul class="p10">
      <li>
        <p class="c2 mb5">如果您在使用中遇到什么问题，或者对我们有什么建议，请按下面的格式填写后发给我们，我们将尽快修复和完善网站，感谢您对我们的支持和关注！</p>
      </li>
      <li><span class="c1">* </span>Email：
        <input type="text" style="width:150px; border:1px solid #ccc;" id="fbEmail">
      </li>
      <li style="display:none;margin-left:55px;" class="c1" id="errEmail">请输入邮箱地址</li>
      <li style="margin-top:5px;"><span class="c1">* </span>意 见：
        <textarea onblur="if(this.value=='')this.value='用的还满意吗？我来说几句！'" onfocus="if(this.value=='用的还满意吗？我来说几句！')this.value=''" id="fbComment" style="width:150px;height:60px;overflow:hidden;color:#666666;vertical-align:top;">用的还满意吗？我来说几句！</textarea>
      </li>
      <li style="display:none;margin-left:55px;" class="c1" id="errComment">请输入您的宝贵意见</li>
      <li style="margin: 10px 0pt 0pt 55px;">
        <input type="submit" />
      </li>
    </ul>
  </div> -->
</div>
@stop