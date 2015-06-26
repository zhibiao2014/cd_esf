@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
@stop
@section('content')
<?php $user = \Auth::user(); ?>
<div class="set_cent fr">
  <!--内容 start-->
  <div class="title_477 mb5">
    <h2>我的简历</h2>
  </div>
  <div class="Managementlist pt20 pb20">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
  </div>
  <table class="qz">
    <tbody>
      <tr>
        <th width="145" class="fricol">简历名称</th>
        <th width="93">完整度</th>
        <th width="65" class="tit_cz">浏览</th>
        <th width="49" class="tit_cz">面试邀请</th>
        <th width="69" class="tit_cz">更新时间</th>
        <th width="165">操作</th>
      </tr>

      <!--第一处添加新结构-->
      @foreach ( $jobs as $value )
      <tr class="bg1">
        <td class="fricol">
          <div class="posrlt">
            <div class="rsmname">
              <a href="{{ route( 'resume.show', $value->id ) }}" target="_blank" class="rnview">{{{$value['title']}}}</a>
            </div>
          </div>
        </td>
        <td>
          <div class="citotal">
            <div class="ciper"> <span style="width:{{$value->percentage}}%" class="ciprog"></span> </div>
            <span class="gtnum">{{$value->percentage}}%</span>
          </div>
        </td>
        <td class="cza"><span class="bcClass">{{{$value->view_count}}}</span></td>
        <td class="cza"><!-- <a target="_parent" href="#">0</a>/0 --></td>
        <td id="updDate" class="cza">{{$value->updated_at}}</td>
        <td class="czav">
          <div class="posrlt">
            <a href="#" class="refresh_job" data-id="{{$value->id}}">刷新</a>
            <a href="{{route('jobs.show', $value->id)}}">完善信息</a>
            {{ Form::open(array('url' =>  'jobs/' . $value->id, 'class' => 'delete_house')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::button('删除', array('class' => 'delete_button')) }}
            {{ Form::close() }}
            <br />
            <a href="{{route('jobs.edit', array( 'id' => $value->id ))}}">修改</a>
            @if ( $value->is_default )
            <a href="#" class="set_default" data-id="{{$value->id}}" data-value="0">设为默认</a>
            @else
            <a href="#" class="set_default" data-id="{{$value->id}}" data-value="1">取消默认</a>
            @endif
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <!--内容 end-->
</div>
<div class="clear"></div>
@stop
@section('footer')
<script src="<?php echo asset("assets/js/artdialog/dist/dialog-min.js"); ?>"></script>
<script type="text/javascript">
  $(function(){
    $('.refresh_job').click(function(e){
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
            url : "{{route('jobs.refresh')}}",
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

    $('.set_default').click(function(e){
      obj = this;
      content = '确定' + $(obj).text() + "!"
      e.preventDefault();
      is_first = true;
      dialog({
        title: '提示',
        content: content,
        okValue: '确定',
        ok: function () {
          if ( !is_first ) {
            return false;
          };
          _this = this;
          this.content("处理中……");
          is_first = false;
          $.ajax({
            url : "{{route('jobs.set_default')}}",
            type : 'post',
            data: { 'id' : $(obj).data('id'), 'is_default' : $(obj).data('value') },
            dataType : 'json',
            success: function( res ) {
              $(obj).text( $(obj).data('value') ? '设置默认' : '取消默认' );
              $(obj).data('value') ? $(obj).data('value', 0) : $(obj).data('value', 1);
              _this.content( res.message );
              setTimeout(function () {
                _this.close().remove();
              }, 2000);
            },
            error: function() {
              _this.content('设置失败，请稍后再试');
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