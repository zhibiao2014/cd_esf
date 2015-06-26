@extends('layouts.main')
@section('header')
<link rel="stylesheet" href="<?php echo asset("assets/js/artdialog/css/ui-dialog.css"); ?>">
@stop
@section('content')
<?php $user = \Auth::user(); ?>
<div class="set_cent fr">
  <!--内容 start-->
  <div class="title_477 mb5">
    <h2>管理我发布的出租</h2>
  </div>
  <div class="Managementlist pt20 pb20">
    @if (Session::has('message'))
    <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    <div class="pr">
      <a class="pa b_wyz" href="{{route( 'rent.index', array('status' => 0) )}}">需要修改的房源</a>
      <ul id="details-ul" class="clearfix" style="margin-bottom:10px">
        <li class="tab01"><a id="zx" href="javascript:void(0);">全部房源</a></li>
        <!-- <li id="sabfour2" onclick="setTab('sabfour',2,5)"><a href="javascript:void(0);">住宅</a></li>
        <li id="sabfour3" onclick="setTab('sabfour',3,5)"><a href="javascript:void(0);">别墅</a></li>
        <li id="sabfour4" onclick="setTab('sabfour',4,5)"><a href="javascript:void(0);">写字楼</a></li>
        <li id="sabfour5" onclick="setTab('sabfour',5,5)"><a href="javascript:void(0);">商铺</a></li> -->
      </ul>
    </div>
    <?php foreach ($rent as $key => $value) { ?>
    <?php if ( isset($value->room_structure) ) { $room_structure = json_decode( $value->room_structure, true ); } ?>
    <?php if ( isset($value->floor) ) { $floor = json_decode( $value->floor, true); } ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php echo 'status' . $value->status; ?> <?php echo $value->type; ?>">
      <tbody>
        <tr class="grayBg">
          <td width="55%"><span><a class="fb" target="_blank" href="{{{route('esf.' . $value->type . '.show', $value->id)}}}"><?php echo $value->title; ?></a></span><span class="c2">（<?php echo $value->phone; ?>）</span></td>
          <td align="right" colspan="3"><span class="f12">多传几张高质量的照片吧！<a href="<?php echo route( $value->type . '.edit', array('id' => $value->id)); ?>">去完善资料&gt;&gt;</a></span></td>
        </tr>
        <tr>
          <td rowspan="3">
            <p><?php echo $value->community_name . '&nbsp;&nbsp;&nbsp;' . $value->address; ?></p>
            <p class="f12">
              @if ( $value->type == 'rent_shop' && $value->rent_type == 1 )
              [转让]
              @else
              [整租]
              @endif
              {{$value->construction_area}}平米
              <?php if ( isset( $value->decoration_id ) && !empty($value->decoration_id) && isset($decorations[$value->decoration_id]) ) { echo " " . $decorations[$value->decoration_id]['name']; } ?>
              <?php if (isset( $floor )) {
                if (isset($floor['total_floor'])) {
                  echo " 第" . $floor['floor'] . "层，共" . $floor['total_floor'] . '层';
                } else {
                  echo " 共" . $floor['floor'] . '层';
                }
              } ?>
              <?php if ( isset( $value->direction_id ) && !empty($value->direction_id) && isset($directions[$value->direction_id]) ) { echo " " . $directions[$value->direction_id]['name']; } ?>
            </p>
            <p class="c2 f12">更新时间：<?php echo $value->updated_at; ?></p>
          </td>
          <?php if (isset($room_structure)) { ?>
          <td width="10%" rowspan="3" class="f14 c1 tc"><strong>
            <?php echo $room_structure['room']; ?>室
            <?php echo $room_structure['hall']; ?>厅
            <?php echo $room_structure['bathroom']; ?>卫
          </strong></td>
          <?php } ?>
          <td width="16%" rowspan="3" class="f14 c1 tc"><strong>{{$value->price}}/月</strong></td>
          <td width="19%" rowspan="3" class="tc">
            <a href="<?php echo route( $value->type . '.edit', array('id' => $value->id)); ?>">修改</a> |
            <a href="#" class="refresh" data-id="<?php echo $value->id; ?>" data-model="<?php echo $value->model; ?>">刷新</a><br />
            <a target="_blank" href="{{{route('esf.' . $value->type . '.show', $value->id)}}}">浏览</a> |
            {{ Form::open(array('url' =>  $value->type . '/' . $value->id, 'class' => 'delete_house')) }}
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
<script type="text/javascript">
  var GlobalParams = {
    'rent_allow_refresh_time' : <?php echo $user->allow_refresh_time; ?>,
    'rent_refresh_time' : <?php echo (\lib\Tool::isToday( date("Y-m-d" , strtotime($user->last_refresh_date)) )) ? $user->refresh_time : 0; ?>,
    'refresh_url' : "<?php echo url('rent_refresh'); ?>"
  };
</script>
@stop