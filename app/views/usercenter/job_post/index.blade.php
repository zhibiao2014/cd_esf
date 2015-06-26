@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
@stop
@section('content')
<?php $user = \Auth::user(); ?>
<div class="set_cent fr">
  <!--内容 start-->
  <!--index_1_1 招聘职位-->
  <div class="title_477 mb5">
    <h2>招聘职位</h2>
  </div>
  <div class="xinxi-topinfomsg">招聘用户可以免费发布<strong>{{ Config::get('view.post_publish_limit') }}</strong>条信息，您已经发布<strong>{{ $post_num }}</strong>条，还可免费发布<strong>{{ Config::get('view.post_publish_limit') - $post_num }}</strong>条。<a href="{{route('post.create')}}">继续发布</a></div>
  <div class="xinxi-title">
    <ul id="details-ul" class="clearfix">
      <li {{ $status == 1 ? 'class="tab01"' : '' }}><a id="zx" href="{{ route('post.index', array('status' => 1)) }}">显示中的信息</a></li>
      <li {{ $status == 0 ? 'class="tab01"' : '' }}><a href="{{ route('post.index', array('status' => 0)) }}">审核中的信息</a></li>
      <li {{ $status == 2 ? 'class="tab01"' : '' }}><a href="{{ route('post.index', array('status' => 2)) }}">被退回的信息</a></li>
      <li {{ $status == 3 ? 'class="tab01"' : '' }}><a href="{{ route('post.index', array('status' => 3)) }}">关闭的信息</a></li>
    </ul>
  </div>
  @if ( $status == 1 )
  <div id="con_sabfour_1">
    <div class="xinxi-guanli-box">
      <table class="basetb">
        <tbody>
          <tr id="tablehead">
            <th width="70%">标题</th>
            <th width="28%" class="tit_cz">管理</th>
          </tr>
          @foreach ( $posts as $value )
          <tr>
            <td>
              <a href="{{ route( 'post.show', $value->id ) }}" target="_blank">{{{$value->title}}}</a>
              <span class="titletd">( <a href="javascript:void(0)">{{ $value->address }}</a>-<a href="javascript:void(0)">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type] : '' }}</a> )</span>
              <p class="titletd tc58">
                更新时间:{{$value->updated_at}} <cite>|</cite> 浏览{{{$value->view_count}}}次 &nbsp;<cite>|</cite>
                <!-- <span><a href="javascript:void(0)" onclick="showDialog.show({id:'blackcontentOuter'});" class="my_jianli">应聘简历<span id=" " class="c1">(1)</span></a></span> -->
              </p>
              <span class="c1"></span>
            </td>
            <td class="cza czav">
              <p>
                <a href="#" class="refresh_post" data-id="{{$value->id}}">刷新</a>
                <a href="{{route( 'post.edit', $value->id )}}" class="ml10 mr10">修改</a>
                <a href="{{route( 'post.change_status', array( 'id' => $value->id, 'status' => 3 ) )}}" class="my_shan">关闭</a>
              </p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @elseif ( $status == 0 )
  <div id="con_sabfour_2">
    <div class="xinxi-guanli-box">
      <table class="basetb">
        <tbody>
          <tr id="tablehead">
            <th width="100%">标题</th>
          </tr>
          @foreach ( $posts as $value )
          <tr>
            <td>
              <a href="{{ route( 'post.show', $value->id ) }}" target="_blank">{{{$value->title}}}</a>
              <span class="titletd">( <a href="javascript:void(0)">{{ $value->address }}</a>-<a href="javascript:void(0)">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type] : '' }}</a> )</span>
              <p class="titletd tc58">
                更新时间:{{$value->updated_at}} <cite>|</cite> 浏览{{{$value->view_count}}}次 &nbsp;<cite>|</cite>
                <!-- <span><a href="javascript:void(0)" onclick="showDialog.show({id:'blackcontentOuter'});" class="my_jianli">应聘简历<span id=" " class="c1">(1)</span></a></span> -->
              </p>
              <span class="c1"></span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @elseif ( $status == 2 )
  <div id="con_sabfour_3">
    <div class="xinxi-guanli-box">
      <table class="basetb">
        <tbody>
          <tr id="tablehead">
            <th width="70%">标题</th>
            <th width="28%" class="tit_cz">管理</th>
          </tr>
          @foreach ( $posts as $value )
          <tr>
            <td>
              <a href="{{ route( 'post.show', $value->id ) }}" target="_blank">{{{$value->title}}}</a>
              <span class="titletd">( <a href="javascript:void(0)">{{ $value->address }}</a>-<a href="javascript:void(0)">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type] : '' }}</a> )</span>
              <p class="titletd tc58">
                更新时间:{{$value->updated_at}} <cite>|</cite> 浏览{{{$value->view_count}}}次 &nbsp;<cite>|</cite>
                <!-- <span><a href="javascript:void(0)" onclick="showDialog.show({id:'blackcontentOuter'});" class="my_jianli">应聘简历<span id=" " class="c1">(1)</span></a></span> -->
              </p>
              <span class="c1"></span>
            </td>
            <td class="cza czav">
              <p>
                <a href="{{route( 'post.edit', $value->id )}}" class="ml10 mr10">修改</a>
              </p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @elseif ( $status == 3 )
  <div id="con_sabfour_4">
    <div class="xinxi-guanli-box">
      <table class="basetb">
        <tbody>
          <tr id="tablehead">
            <th width="70%">标题</th>
            <th width="28%" class="tit_cz">管理</th>
          </tr>
          @foreach ( $posts as $value )
          <tr>
            <td>
              <a href="{{ route( 'post.show', $value->id ) }}" target="_blank">{{{$value->title}}}</a>
              <span class="titletd">( <a href="javascript:void(0)">{{ $value->address }}</a>-<a href="javascript:void(0)">{{ isset( $job_types[$value->job_type] ) ? $job_types[$value->job_type] : '' }}</a> )</span>
              <p class="titletd tc58">
                更新时间:{{$value->updated_at}} <cite>|</cite> 浏览{{{$value->view_count}}}次 &nbsp;<cite>|</cite>
                <!-- <span><a href="javascript:void(0)" onclick="showDialog.show({id:'blackcontentOuter'});" class="my_jianli">应聘简历<span id=" " class="c1">(1)</span></a></span> -->
              </p>
              <span class="c1"></span>
            </td>
            <td class="cza czav">
              <p>
                <a href="{{route( 'post.change_status', array( 'id' => $value->id, 'status' => 1 ) )}}" class="my_shan">开启</a>
              </p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endif
  <div class="noteread">
    <p>
      <b>说明：</b>
    </p>
    <p> 1、刷新：相当于新发一条职位，在按时间排序的情况下信息将靠前显示，激活信息每天可免费刷新1次，对历史信息刷新需先激活。</p>
    <p> 2、待审核：待审核中的信息除了您自己外，其他人无法看到，不能修改或删除，工作人员会在24小时内为您审核。 </p>
    <p> 3、已关闭：别人无法看到信息，自己关闭的职位可以恢复。 </p>
  </div>
  <!--内容 end-->
</div>
<div class="clear"></div>
@stop
@section('footer')
<script src="<?php echo asset("assets/js/artdialog/dist/dialog-min.js"); ?>"></script>
<script type="text/javascript">
  $(function(){
    $('.refresh_post').click(function(e){
      refresh_obj = this;
      e.preventDefault();
      is_first = true;
      dialog({
        title: '提示',
        content: '确认刷新！',
        okValue: '确定',
        ok: function () {
          if ( !is_first ) {
            return false;
          };
          _this = this;
          this.content("刷新中……");
          is_first = false;
          $.ajax({
            url : "{{route('post.refresh')}}",
            type : 'post',
            data: { 'id' : $(refresh_obj).data('id') },
            dataType : 'json',
            success: function( res ) {
              _this.content( res.message );
              setTimeout(function () {
                _this.close().remove();
              }, 2000);
            },
            error: function() {
              _this.content('刷新失败，请稍后再试');
              _this.ok = function() {
                return ;
              };
              setTimeout(function () {
                _this.close().remove();
              }, 2000);
            }
          });
          return false;
        },
        cancelValue: '取消',
        cancel: function () {}
      }).show();
    });
  });
</script>
@stop