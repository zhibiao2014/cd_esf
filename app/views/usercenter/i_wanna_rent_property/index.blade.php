@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
@stop
@section('content')
<?php $user = \Auth::user(); ?>
<div class="set_cent fr">
  <!--内容 start-->
  <div class="title_477 mb5">
    <h2>管理我的求租</h2>
  </div>
  <div class="Managementlist pt20 pb20">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="pr">
      <!-- <a class="pa b_wyz" href="javascript:void(0);">被退回的求租</a> -->
      <ul id="details-ul" class="clearfix" style="margin-bottom:10px">
        <li class="tab01"><a id="zx" href="javascript:void(0);">全部求租</a></li>
      </ul>
    </div>
    <?php foreach ($iwannas as $key => $value) { ?>
    <?php if ( isset($value->room_structure) ) { $room_structure = json_decode( $value->room_structure, true ); } ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo $value->type; ?>">
      <tbody>
        <tr class="grayBg">
          <td colspan="4"><span><a class="fb" target="_blank" href="{{route( 'esf.wanna.rent.show', $value->id )}}"><?php echo $value->title; ?></a></span><span class="c2">（<?php echo $value->phone; ?>）</span></td>
        </tr>
        <tr>
          <td rowspan="3">
            <p><?php echo $value->community_name; ?></p>
            <p>
              <?php if (isset($room_structure)) { ?>
              <?php echo $room_structure['room']; ?>室
              <?php echo $room_structure['hall']; ?>厅
              <?php echo $room_structure['bathroom']; ?>卫，
              <?php } ?>
            </p>
            <p class="c2 f12">更新时间：<?php echo $value->updated_at; ?></p>
          </td>
          <td width="13%" rowspan="3" class="f14 c1 tc"><strong><?php echo $value->construction_area; ?>㎡</strong></td>
          <td width="15%" rowspan="3" class="f14 c1 tc"><strong><?php echo $value->price; ?>元/月</strong></td>
          <td width="20%" rowspan="3" class="tc">
            <a href="<?php echo route( 'i_wanna_rent_property.edit', array('id' => $value->id)); ?>">修改</a> |
            <a target="_blank" href="{{route( 'esf.wanna.rent.show', $value->id )}}">浏览</a> |
            {{ Form::open(array('url' =>  'i_wanna_rent_property/' . $value->id, 'class' => 'delete_house')) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::button('删除', array('class' => 'delete_button')) }}
            {{ Form::close() }}
          </td>
        </tr>
      </tbody>
    </table>
    <?php } ?>
  </div>
  <!--内容 end-->
</div>
<div class="clear"></div>
@stop
@section('footer')
<script src="<?php echo asset("assets/js/artdialog/dist/dialog-min.js"); ?>"></script>
@stop