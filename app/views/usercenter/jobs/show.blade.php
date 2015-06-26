<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="@yield('keywords', '常德房地产,常德市房地产信息网,常德新房,常德二手房,常德租房,常德房屋中介,常德住房团购')" />
  <meta name="description" content="@yield('description', '常德市房地产信息网是常德市地区最权威的房产信息网，我们有最权威的数据，最优秀的房产信息发布平台。')" />
  <title>会员中心-常德市房地产信息网</title>
  <link href="<?php echo asset("assets/css/main.css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset("assets/css/user/login.css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset("assets/css/user/zp.css"); ?>" rel="stylesheet" type="text/css" />
  <script src="<?php echo asset("assets/js/lib/jquery-1.11.0.min.js"); ?>"></script>
  <!--时间插件-->
  <link href="<?php echo asset("assets/zp/css/date/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo asset("assets/zp/css/date/daterangepicker-bs3.css"); ?>" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="<?php echo asset("assets/zp/js/date/moment.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/zp/js/date/daterangepicker.js"); ?>"></script>
  <style type="text/css">
    #self_introduceTip {
      clear: both;
      display: block;
      margin-left: 145px;
    }
  </style>
</head>
<body class="wrap_bg">
  <div class="Ucen_hander mb20">
    <div class="clearfix w1000">
      <div class="logobox2 fl"><a class="Ucen_logo2" title="常德市房地产信息网" href="{{{route('home')}}}">常德市房地产信息网</a></div>
    </div>
    <div class="user_nav">
      <ul class="clearfix">
        <li><a href="<?php echo route('home'); ?>" class="cur">会员中心首页</a></li>
        <li><a href="http://www.0736fdc.com/user/account/index.html">用户中心</a></li>
        <li><a href="http://www.0736fdc.com/user/safecenter.html">安全中心</a></li>
        <li><a href="http://www.0736fdc.com/user/message.html">短消息中心</a></li>
        <li><a href="#">帮助中心</a></li>
        <li><a href="http://www.0736fdc.com/user/logout.html">退出登陆</a></li>
      </ul>
    </div>
  </div>
  <!--登录框 start-->
  <div class="wrap postContent pr">
    <div id="completeContainer" class="completeContainer">
      <div class="perIcon perIcon{{$jobs['percentage']}}" id="completeIcon"></div>
      <input type="hidden" value="{{$jobs['percentage']}}" id="completeVal">
      <input type="hidden" value="1" id="isMidHigh">
      <input type="hidden" value="0" id="isLow">
      <div id="completeTips" class="perTips">
        <i class="topArrow"></i>
        <p class="perBasicTips">您已完成基本资料！</p>
        <p class="perDetailTips">工作经历最能体现您的能力，继续完善可增加完整度分数哦！</p>
      </div>
    </div>
    <div class="typeListInfo">
      @if (Session::has('message'))
      <div class="alert alert-info">{{ Session::get('message') }}</div>
      @endif
      <div class="basicInfo">
        <h3> <span>基本信息</span> <a class="changeBtn" id="changeBtn" href="javascript:void(0)">修改</a> </h3>
        <div id="baseshow" class="basicConShow showDiv">
          <dl>
            <dt> <span>{{{$jobs['name']}}}</span> <span class="sexAge">[{{{$jobs['title']}}}]</span> </dt>
            <dd> <span class="title">求职意向：</span> <span class="jobType">{{ isset( $job_types[$jobs['job_type']] ) ? $job_types[$jobs['job_type']]['name'] : '' }}</span> <span class="divide">|</span> <span>{{ isset( $salaries[$jobs['money']] ) ? $salaries[$jobs['money']] : '' }}/月</span> <span class="divide">|</span> <span>{{{$jobs['birth_place']}}}</span> </dd>
            <dd> <span class="title">个人情况：</span> <span>{{ $jobs['sex'] == 0 ? '男' : '女' }}</span> <span class="divide">|</span> <span>{{ date("Y") - date( "Y", strtotime($jobs['birthday']) ) }}岁</span> <span class="divide">|</span> <span>现居住{{{ join('', $jobs['living_place']) }}}</span> <span class="divide">|</span> <span>{{ isset( $education[$jobs['education']] ) ? $education[$jobs['education']] : '' }}</span> <span class="divide">|</span> <span> {{{$jobs['work_time']}}}年以上工作经验 </span> </dd>
            <dd> <span class="title">联系方式：</span> <span> {{{$jobs['email']}}}、{{{$jobs['phone_number']}}} </span> <i class="I-phone-2"></i> </dd>
            <dd> <span class="title db">自我介绍：</span> <span class="w710">{{{$jobs['self_introduce']}}}</span> </dd>
          </dl>
        </div>
        <div id="Managementlist" class="Managementlist pt20 pb20" style="display:none">
          @if ( Session::get('type') == 'jobs' )
          {{ HTML::ul($errors->all() )}}
          @endif
          {{ Form::model($jobs, array('route' => array('jobs.update', $jobs['id']), 'method' => 'put' , 'id' => 'residence')) }}
          <div class="msglist mb20">
            <ul class="tab03">
              <li>
                <label class="w127"><span class="c1">*</span>简历标题：</label>
                {{ Form::text('info[title]', $jobs['title'], array('class' => 'Input_1', 'id' => 'title' )) }}
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
                {{ Form::select( 'info[money]', $salaries, $jobs['money'], array( 'id' => 'money' ) ) }}
              </li>
              <li>
                <label class="w127"><span class="c1">*</span>姓名：</label>
                {{ Form::text('info[name]', $jobs['name'], array('class' => 'Input_1', 'id' => 'name' )) }}
              </li>
              <li>
                <span class="w127"><span class="c1">*</span>性别：</span>
                <label>{{ Form::radio('info[sex]', '0', $jobs['sex'] == 0 ) }} 男</label>
                <label class="ml20">{{ Form::radio('info[sex]', '1', $jobs['sex'] == 1 ) }} 女</label>
                <input type="hidden" id="sex"/>
              </li>
              <li>
                <label class="w127"><span class="c1">*</span>出生日期：</label>
                <input name="info[birthday]" type="text" value="{{ $jobs['birthday'] }}" class="Input_1 datepicker" id="birthday" />
              </li>
              <li>
                <label class="w127"><span class="c1">*</span>最高学历：</label>
                {{ Form::select( 'info[education]', $education, $jobs['education'], array( 'id' => 'education' ) ) }}
              </li>
              <li>
                <label class="w127 fl"><span class="c1">*</span>工作时间：</label>
                {{ Form::text('info[work_time]', $jobs['work_time'], array('class' => 'Input_1', 'id' => 'work_time' )) }}年
              </li>
              <li>
                <label class="w127 fl"><span class="c1">*</span>籍 贯：</label>
                {{ Form::text('info[birth_place]', $jobs['birth_place'], array('class' => 'Input_1', 'placeholder' => "如：湖南常德", 'id' => 'birth_place' )) }}
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
                {{ Form::text('info[email]', $jobs['email'], array('class' => 'Input_1', 'id' => 'email' )) }}
              </li>

              <li>
                <label class="w127"><span class="c1">*</span>手机号码：</label>
                {{ Form::text('info[phone_number]', $jobs['phone_number'], array('class' => 'Input_1', 'id' => 'phone' )) }}
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
                <textarea class="text3 mt10 mb5 fl" name="info[self_introduce]" id="self_introduce" cols="" rows="" placehold="请输入评论内容">{{$jobs['self_introduce']}}</textarea>
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
              </li>
              <li>
                <input type="submit" class="int_b" value="保存简历" ct="submit" />
              </li>
            </ul>
          </div>
          {{ Form::close() }}
        </div>
        <div id="containerexperience" style="display:block;">
          <h3> <span class="c1">*</span> <span>工作经验</span> <span style="" class="tips">（投递必填）</span><span class="hideTips"><i class="botArrow"></i>该信息仅自己可见</span> </h3>
          @if( is_array($work_experiences) )
          @foreach( $work_experiences as $value )
          <div class="showList">
            <p class="detailList"><span>{{$value['entry_date']}}-{{$value['entry_date']}}</span><span class="divide">|</span><span>{{{$value['corporation_name']}}}</span><span class="divide">|</span><span>{{ isset( $job_types[$value['job_type']] ) ? $job_types[$value['job_type']]['name'] : '' }}</span><span class="divide">|</span><span>{{{$value['salary']}}}元/月</span></p>
            <p class="detailCon"><span class="title">工作内容：</span><span>{{{$value['content']}}}</span>
            </p>
            <p class="operBtn">
              <a onclick="$(this).delConfirm()" href="{{route('work_experience.delete', array( 'id' => $value['id'], 'job_apply_id' => $value['job_apply_id'] ) )}}">删除</a>
            </p>
          </div>
          @endforeach
          @endif

          <div class="msglist mb20 pt10">
            @if ( Session::get('type') == 'work_experience' )
            {{ HTML::ul($errors->all() )}}
            @endif
            {{ Form::open(array( 'route' => array('work_experience.store'), 'id' => 'work_experience' )) }}
            <input type="hidden" name="info[job_apply_id]" value="{{$jobs['id']}}">
            <ul class="tab03">
              <li>
                <label class="w127"><span class="c1">*</span>公司名称：</label>
                {{ Form::text('info[corporation_name]', Input::old('info[corporation_name]'), array('class' => 'Input_1', 'placeholder' => '例：求职销售 2年经验' , 'id' => 'corporation_name' )) }}
              </li>
              <li>
                <label class="w127"><span class="c1">*</span>职位类别：</label>
                <select id="work_experience_job_type" name="info[job_type]" class="input_7">
                  {{$job_types_option}}
                </select>
              </li>
              <li>
                <label class="w127" for="salary"><span class="c1">*</span>薪资：</label>
                <input type="text" id="salary" name="info[salary]" value="{{{Input::old('info[salary]')}}}"/>元/月
              </li>
              <li>
                <label class="w127 fl pt10"><span class="c1">*</span>在职时间：</label>
                <div class="control-group">
                  <div class="controls">
                    <div class="input-prepend input-group"> <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                      <input type="text" readonly="readonly" style="width: 200px" name="info[date]" id="reservation" class="form-control" value="{{{Input::old('info[date]')}}}" />
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
                  $(document).ready(function() {
                    $('#reservation').daterangepicker({'showDropdowns' : true});
                  });
                </script>
                <div class="clear"></div>
              </li>
              <li>
                <label class="w127 fl"><span class="c1">*</span>工作内容：</label>
                <textarea class="text3 mt10 mb5 fl" name="info[content]" id="work_content" cols="" rows="" title="请输入评论内容">{{{Input::old('info[content]')}}}</textarea>
                <div class="anlbox ml20 fl pr">
                  <a href="javascript:void(0);" onmouseover="hoverDiv('exbpx3', 'show');" onmouseout="hoverDiv('exbpx3', 'hide');" class="anl1 mb10">范例一</a>
                  <div class="exList pa" style="display:none;" id="exbpx3" onmouseover="hoverDiv('exbpx3', 'show');" onmouseout="hoverDiv('exbpx3', 'hide');">
                    <p><strong>（职责）</strong><br />
                      身为企划主管，任职期间负责公司在全国的整体宣传工作，包括制订并实施营销计划、广告宣传计划、培训、培养公司市场人员。
                    </p>
                    <p><strong>（业绩）</strong><br />
                      在任职期间，公司销售额增长40%，全国市场占有率达到80%以上；成功策划并实施了"重金收购灰尘"、"赞助北京国安足球队胸前广告"等大型公关活动。
                    </p>
                  </div>
                  <a href="javascript:void(0);" onmouseover="hoverDiv('exbpx4', 'show');" onmouseout="hoverDiv('exbpx4', 'hide');" class="anl2">范例二</a>
                  <div class="exList pa" style="display:none;" id="exbpx4" onmouseover="hoverDiv('exbpx4', 'show');" onmouseout="hoverDiv('exbpx4', 'hide');">
                    <p> 1. 能根据公司的近期和远期目标、财务预算，制定高效的销售计划，提出产品价格政策。 <br />
                      2. 根据同类其他产品的市场动态、销售动态、存在问题及市场竞争发展状况等实施分析汇总，并提出改进方案，协同销售计划的顺利完成。 <br />
                      3. 保持与客户的良好关系，维护客户管理，定期组织市场调研，分析市场特点和发展趋势。 <br />
                      4. 带领团队于2012年成功拓展市场，实现销售额800万的产品销售业绩。
                    </p>
                  </div>
                </div>
                <div class="fr" style="margin-right:100px;">您还能输入 <span class="c10">1000</span> 个字</div>
                <div class="clear"></div>
              </li>
              <li>
                <div class="tc">
                  <input type="submit" class="saveBtn" value="保存" ct="submit" />
                </div>
              </li>
            </ul>
            {{ Form::close() }}
          </div>
        </div>
        <div id="containereducation" style="display:block;">
          <h3> <span class="c1">*</span> <span>教育经历</span> <span style="" class="tips">（投递必填）</span><span class="hideTips"><i class="botArrow"></i>该信息仅自己可见</span> </h3>
          <div class="showDiv" id="eduDiv">
            @if( is_array($education_experiences) )
            @foreach( $education_experiences as $value )
            <div class="showList">
              <p class="detailList"><span>{{$value['entry_date']}}-{{$value['entry_date']}}</span><span class="divide">|</span><span>{{{$value['school_name']}}}</span><span class="divide">|</span><span>{{{$value['major']}}}</span></p>
              <p class="operBtn">
                <a onclick="$(this).delConfirm()" href="{{route('education_experience.delete', array( 'id' => $value['id'], 'job_apply_id' => $value['job_apply_id'] ) )}}">删除</a>
              </p>
            </div>
            @endforeach
            @endif
          </div>

          <div class="msglist mb20 pt10">

            @if ( Session::get('type') == 'education_experience' )
            {{ HTML::ul($errors->all() )}}
            @endif
            {{ Form::open(array( 'route' => array('education_experience.store'), 'id' => 'education_experience' )) }}
            <input type="hidden" name="info[job_apply_id]" value="{{$jobs['id']}}">
            <ul class="tab03">
              <li>
                <label class="w127"><span class="c1">*</span>学校名称：</label>
                <input type="text" id="school_name" name="info[school_name]" value="{{{Input::old('info[school_name]')}}}"/>
              </li>
              <li>
                <label class="w127"><span class="c1">*</span>专业：</label>
                <input type="text" id="major" name="info[major]" value="{{{Input::old('info[major]')}}}"/>
              </li>
              <li>
                <label class="w127 fl pt10"><span class="c1">*</span>在校时间：</label>
                <div class="control-group">
                  <div class="controls">
                    <div class="input-prepend input-group">
                      <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                      <input type="text" readonly="readonly" style="width: 200px" name="info[in_school_date]" id="reservation2" class="form-control" value="{{{Input::old('info[in_school_date]')}}}" />
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
                  $(document).ready(function() {
                    $('#reservation2').daterangepicker({'showDropdowns' : true});
                  });
                </script>
                <div class="clear"></div>
              </li>
              <li>
                <div class="tc">
                  <input type="submit" class="saveBtn" value="保存" ct="submit" />
                </div>
              </li>
            </ul>
            {{ Form::close() }}
          </div>
        </div>
        <div id="containerphoto" style="display:block;">
          <h3> <span>照片/作品</span><span class="hideTips"><i class="botArrow"></i>该信息仅自己可见</span> </h3>
          <div class="msglist mb20 pt10">
            @if ( Session::get('type') == 'images' )
            {{ HTML::ul($errors->all() )}}
            @endif
            {{ Form::open(array( 'route' => array('jobs.save_images', $jobs['id']), 'id' => 'images' )) }}
            <ul class="tab03">
              <li class="clearfix">
                <label class="w127 flptao">上传图片：</label>
                <div class="clearfix pre-z" id="">
                  <div id="preview">
                    @if ( is_array( $jobs['images'] ) )
                    @foreach ($jobs['images'] as $key => $image)
                    <div class="imgbox">
                      <div class="w_upload">
                        <a href="javascript:void(0)" class="item_close">删除</a>
                        <span class="item_box"><img src="<?php echo $image['url'] ?>"></span>
                      </div>
                      <input type="hidden" name="info[images][{{$image['id']}}][id]" value="{{$image['id']}}" />
                      <input type="hidden" name="info[images][{{$image['id']}}][url]" value="{{$image['url']}}" />
                    </div>
                    @endforeach
                    @endif
                  </div>
                  <div class="frptao">
                    <!--<a href="#" class="but_02 f14 fb">请上传图片</a>-->
                  </div>
                  <div class="frptao clearfix">
                    <div class="ButUp_box fl" id="upload_box" data-input="images">
                      <input id="file_upload" name="file_upload" type="file" multiple="true" class="ButUpImg_2">
                    </div>
                    <div class="clearfix"></div>
                    <p class="f12 c1 mt5">已上传图片<span class="c1 upload_count">{{count($jobs['images'])}}</span>/10，支持多张上传，最多上传10张，单张照片不超过3M。</p>
                  </div>
                </div>
              </li>

              <li>
                <div class="tc"><input type="submit" class="saveBtn" value="保存" ct="submit" /></div>
              </li>
            </ul>
            {{ Form::close() }}
          </div>
        </div>

        <div id="mylight" style="display:block;">
          {{ Form::open(array( 'route' => array('jobs.save_tags', $jobs['id']), 'id' => 'tags' )) }}
          <h3> <span>我的亮点</span> <span class="c2 f12 fn ml10">（增加亮点更容易被关注）</span></h3>
          <div class="advantCon showDiv">
            <div style="" id="tabModyBrig" class="advantAdd">
              <div class="adCon">
                <ul class="brightspot" id="brightspot">
                  <?php if (is_array($jobs['tags'])) { foreach ($jobs['tags'] as $key => $tag) { ?>
                  <li class='actived'><?php echo $tag; ?><a href='javascript:void(0);' class='cbdel'></a><input type='hidden' name='info[customer_tag][]' value='<?php echo $tag; ?>'/></li>
                  <?php } } ?>
                </ul>
                <div class="clear"></div>
                <div id="OthBrig">
                  <input type="text" id="customer_tag" class="textstyle" maxlength="20" placeholder="请输入不超过8个字" autocomplete="off" >
                  <input type="button" class="addbrig" id="add_customer_tag" value="添加亮点" style="display: inline-block;" data-num="10" data-length="8" data-placeholder="亮点">
                  <span id="txtOthBrig1_Tip"></span>
                </div>
              </div>
              <div class="clear"></div>
              <div class="tc"><input type="submit" class="saveBtn" value="保存" ct="submit" /></div>
            </div>
          </div>
          {{ Form::close() }}
        </div>

        <div id="containerhighlights" style="display:block;">
          {{ Form::open(array( 'route' => array('jobs.save_content', $jobs['id']), 'id' => 'content' )) }}
          <h3><span>特别说明</span></h3>
          <!-- <div class="pl20">
            <p>1、三年以上php开发经验，有大型网站或系统开发者优先<br />
              2、对php优化或者解决高并发有一定认知<br />
              3、熟悉并能手写标准sql,并对数据库优化有一定认知<br />
              4、具有良好的编码习惯 熟悉至少一种主流php开发框架<br />
              5、有良好的团队协作能力和沟通能力 <br />
              6、至少懂得一种版本控制软件的使用（svn&git&vss） 有一定js、css基础，能手写常用js，看懂css，熟悉jquery框架者尤佳 会linux基本操作的优先 熟悉mongdb或者sphinx者优先<br />
              7、一经录用公司将提供广阔的发展空间
            </p>
          </div> -->
          <div class="msglist mb20 pt10">
            <ul class="tab03">
              <li>
                <label class="w127 fl">特长/其他：</label>
                <textarea placeholder="请输入评论内容" name="info[content]" class="text3 mb5 fl">{{{$jobs['content']}}}</textarea>
                <div class="clear"></div>
              </li>
              <li>
                <div class="tc"><input type="submit" class="saveBtn" value="保存" ct="submit" /></div>
              </li>
            </ul>
          </div>
          {{ Form::close() }}
        </div>

      </div>
    </div>
    <div class="Copyright clear">
      <p>
        <a href="http://www.0736fdc.com/about/wzjj.html" target="_blank">网站简介</a> |
        <a href="http://www.0736fdc.com/about/ggfw.html" target="_blank">广告服务</a> |
        <a href="http://www.0736fdc.com/about/cpyc.html" target="_blank">诚聘英才</a> |
        <a href="http://www.0736fdc.com/about/yytd.html" target="_blank">运营团队</a> |
        <a href="http://www.0736fdc.com/about/lxwm.html" target="_blank">联系我们</a> |
        <a href="http://www.0736fdc.com/about/jszc.html" target="_blank">技术支持</a> |
        <a href="http://www.0736fdc.com/about/lxwm.html" target="_blank">联系我们</a> |
        <a href="http://www.0736fdc.com/about/wmdys.html" target="_blank">我们的优势</a> |
        <a href="http://www.0736fdc.com/about/mzsm.html" target="_blank">免责声明</a>
        <br>
        <span><a href="http://www.0736fdc.com" target="_blank">常德市房地产信息网</a>&nbsp;&nbsp;Copyright 2003-2014 All Rights Reserved&nbsp;&nbsp;Version：2.1.2正式版&nbsp;&nbsp;</span><br>
        <span>湘ICP备05013990号-9</span>
        电话：<span>0736-7201965</span>(总编室)&nbsp;<span>0736-7203060</span>(房屋备案)<br>
        提示：本站的新房、二手房、招聘、求职等信息真实性请用户自行辨别，由此产生的经济纠纷等法律责任本站不与承担。<br>
        技术支持：<a href="http://www.cdwanxun.com/" target="_blank">万讯互动</a>
      </p>
      <!-- 底部结束 -->
    </div>
  </div>
  <script src="<?php echo asset("assets/js/functions.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/lib/jquery.placeholder.js"); ?>"></script>
  <script src="<?php echo asset("assets/js/global.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/js/uploadify/jquery.uploadify.js"); ?>"></script>
  <script type="text/javascript">
    var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>', 'image_num' : {{count($jobs['images'])}} };

    //第一种形式 第二种形式 更换显示样式
    function setTab(name,cursel,n) {
      for(i=1;i<=n;i++){
        var menu=document.getElementById(name+i);
        var con=document.getElementById("con_"+name+"_"+i);
        menu.className=i==cursel?"tab01":"tab02";
        con.style.display=i==cursel?"block":"none";
      }
    }

    $(function(){
      $("body").click(function(){
        $(".menubar").each( function(index, obj) {
          $("#"+$(obj).data("target")).addClass("hidbox");
        });
      });
      $(".menubar").click( function(e) {
        e.stopPropagation();
        $(".menubar").each( function(index, obj) {
          $("#"+$(obj).data("target")).addClass("hidbox");
              // if(obj != this ) {$("#"+$(obj).data("target")).addClass("hidbox");}
            });
        $id = $(this).data("target");
        if ($("#"+$id).hasClass('hidbox')) {
          $("#"+$id).removeClass('hidbox');
        } else {
          $("#"+$id).addClass('hidbox');
        };
      });

      $(".search_box .pick a").click(function(){
        $cls = $(this).parent(".pick").data("target");
        $(this).siblings("input").val($(this).text());
        $(this).parent(".pick").siblings("a."+$cls).text($(this).text());
        $(this).parent(".pick").addClass("hidbox");
      });
    });

    function SwapTab(name,cls_show,cls_hide,cur,cnt){
      for(i=1;i<=cnt;i++){
        if(i==cur){
          $('#con_'+name+'_'+i).show();
          $('#'+name+i).attr('class',cls_show);
        }else{
          $('#con_'+name+'_'+i).hide();
          $('#'+name+i).attr('class',cls_hide);
        }
      }
    }

    //新房 搜索 "展示 隐藏"
    function show_div(){
      var obj_div=document.getElementById("showMo");
      obj_div.className=(obj_div.className=="clearfix hidbox")?"clearfix":"clearfix hidbox";
      var obj_div=document.getElementById("butMo");
      obj_div.className=(obj_div.className=="pa but2_Mo")?"pa but1_Mo":"pa but2_Mo";
    }

    //资讯中心 城市分类隐藏显示
    var showcity;
    function showMessage(){
     window.clearTimeout(showcity);
     document.getElementById('city_Name').className = 'cne2';
     document.getElementById('city_List').className = 'citybox pa p10';
   }
   function hiddenMessage(){
     showcity=window.setTimeout("hidden();",600);
   }
   function hidden(){
     document.getElementById('city_Name').className = 'cne1';
     document.getElementById('city_List').className = 'citybox pa p10 hidbox';
   }

    //幻灯window.onload=function
    function SlideShow(c) {
      var a = document.getElementById("slideContainer"), f = document.getElementById("slidesImgs").getElementsByTagName("li"), h = document.getElementById("slideBar"), n = h.getElementsByTagName("span"), d = f.length, c = c || 3000, e = lastI = 0, j, m;
      function b() {
        m = setInterval(function () {
          e = e + 1 >= d ? e + 1 - d : e + 1;
          g()
        }, c)
      }
      function k() {
        clearInterval(m)
      }
      function g() {
        f[lastI].style.display = "none";
        n[lastI].className = "";
        f[e].style.display = "block";
        n[e].className = "on";
        lastI = e
      }
      f[e].style.display = "block";
      a.onmouseover = k;
      a.onmouseout = b;
      h.onmouseover = function (i) {
        j = i ? i.target : window.event.srcElement;
        if (j.nodeName === "SPAN") {
          e = parseInt(j.innerHTML, 10) - 1;
          g()
        }
      };
      b();
    };
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#changeBtn").click(function(){
        $("#baseshow").hide();
        $("#Managementlist").show();
      });
    });
    //隐藏显示
    function hoverDiv(obj, sType) {
      var oDiv = document.getElementById(obj);
      if (sType == 'show') { oDiv.style.display = 'block';}
      if (sType == 'hide') { oDiv.style.display = 'none';}
    }
    //============
    $(document).ready(function(){
      $("#hide_1").click(function(){
        $("#containerexperience").hide();
      });
      $("#hide_2").click(function(){
        $("#containereducation").hide();
      });
      $("#hide_3").click(function(){
        $("#containerphoto").hide();
      });
      $("#hide_4").click(function(){
        $("#containerhighlights").hide();
      });
    });
  </script>

  <script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidator.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/js/jquery-validation/formvalidatorregex.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/js/uploadify/jquery.uploadify.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/js/lib/jquery-ui.min.js"); ?>"></script>
  <script type="text/javascript" src="<?php echo asset("assets/js/lib/city_menu_select.js"); ?>"></script>
  <script type="text/javascript">
    var GlobalParams = { 'upload_swf' : '<?php echo asset("assets/js/uploadify/uploadify.swf"); ?>', 'upload_url' : '<?php echo route("attachment.store"); ?>' };

    var customer_tag = 0;
    $(function() {
      new PCAS("info[work_place][province]","info[work_place][city]","info[work_place][area]","{{{ isset($jobs['work_place'][0]) ? $jobs['work_place'][0] : '湖南省' }}}","{{{ isset($jobs['work_place'][1]) ? $jobs['work_place'][1] : '常德市' }}}","{{{ isset($jobs['work_place'][2]) ? $jobs['work_place'][2] : '武陵区' }}}");
      new PCAS("info[living_place][province]","info[living_place][city]","info[living_place][area]","{{{ isset($jobs['living_place'][0]) ? $jobs['living_place'][0] : '湖南省' }}}","{{{ isset($jobs['living_place'][1]) ? $jobs['living_place'][1] : '常德市' }}}","{{{ isset($jobs['living_place'][2]) ? $jobs['living_place'][2] : '武陵区' }}}");

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
      }}).defaultPassed();;

      $("#job_type").formValidator({onshow:"请选择职位类别",onfocus:"请选择职位类别",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
        if ( /^[1-9]\d*|0$/.test(val) ) {
          return true;
        } else {
          return "职位类别必选";
        }
      }}).defaultPassed();

      $("#money").formValidator({onshow:"请选择期待薪资",onfocus:"请选择期待薪资",oncorrect:"输入正确"}).functionValidator({ fun:function( val, elem ) {
        if ( /^[1-9]\d*|0$/.test(val) ) {
          return true;
        } else {
          return "期待薪资必选";
        }
      }}).defaultPassed();

      $("#birthday").formValidator({onshow:"请填写出生日期",onfocus:"请填写出生日期",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"date",onerror:"日期格式不正确"}).defaultPassed();

      $("#work_time").formValidator({onshow:"请填写工作时间",onfocus:"请填写工作时间",oncorrect:"输入正确"}).regexValidator({datatype:"enum",regexp:"num1",onerror:"工作时间不能为空"}).defaultPassed();

      $("#birth_place").formValidator({onshow:"请填写籍贯",onfocus:"请填写籍贯",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"籍贯不能为空"}).defaultPassed();;

      $("#title").formValidator({onshow:"亲，2-12个字",onfocus:"亲，2-12个字",oncorrect:"输入正确"}).inputValidator({min:2,onerror:"职位名称必须在2-12个字之间"}).inputValidator({max:24,onerror:"职位名称必须在2-12个字之间"}).defaultPassed();;

      $( "#work_place" ).formValidator({onshow:"请选择地址",onfocus:"请选择地址",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"地址格式不正确"}).defaultPassed();
      $( "#living_place" ).formValidator({onshow:"请选择地址",onfocus:"请选择地址",oncorrect:"输入正确"}).inputValidator({min:1,onerror:"地址格式不正确"}).defaultPassed();
      $("#self_introduce").formValidator({onshow:"请输入自我介绍",onfocus:"请输入自我介绍",oncorrect:"输入正确"}).inputValidator({min:10,onerror:"自我介绍至少10个字"}).defaultPassed();
      /* 表单验证结束 */

    });
</script>
</body>
</html>