<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <div class="w315 fl mr10">
    <div class="un1_box h290 t_yellow">
      <div class="tab_s clearfix"> <a class="tab01" id="five1" onmousemove="setTab('five',1,2)" href="javascript:void(0);">最新二手房</a></div>
      <div id="con_five_1" style="display: block;">
        <div class="p10">
          <ul class="Fast_ss">
            @foreach( $last_houses as $key => $house )
            <li class="w60">{{{ isset( $regions[$house['region_id']] ) ? '[' . $regions[$house['region_id']]['name'] . ']' : '' }}}</li>
            <li class="w90">
              <a href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}" title="{{{$house['title']}}}" target="_blank" class="t3">{{{ \lib\Tool::str_cut($house['title'], 20) }}}</a>
            </li>
            <li class="w60">
              @if ( $house['type'] == 'house' )
              {{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}
              @endif
            </li>
            <li class="w60">{{{$house['price']}}}万</li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>
  </div>
  <div class="w423 fl mr10">
    <div class="un1_box t_yellow h290">
      <div class="tab_s clearfix">
        <a class="tab01" id="six1" onmousemove="setTab('six',1,2)" href="javascript:void(0);">个人二手房</a>
        <a class="tab02" id="six2" onmousemove="setTab('six',2,4)" href="javascript:void(0);">经纪人二手房</a>
        <a class="tab02" id="six3" onmousemove="setTab('six',3,4)" href="javascript:void(0);">本网二手房</a>
      </div>
      <div id="con_six_1">
        <div class="p10">
          <ul class="table_01 clearfix">
            @foreach( $individual_houses as $key => $house )
            <li class="w60">{{{ isset( $regions[$house['region_id']] ) ? '[' . $regions[$house['region_id']]['name'] . ']' : '' }}}</li>
            <li class="w128">
              <a href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}" title="{{{$house['title']}}}" target="_blank" class="t3">{{{ \lib\Tool::str_cut($house['title'], 30) }}}</a>
            </li>
            <li class="w60">
              @if ( $house['type'] == 'house' )
              {{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}
              @endif
            </li>
            <li class="w60">{{{$house['price']}}}万</li>
            <li class="w90">{{{\lib\Tool::str_cut($house['title'], 25)}}}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div id="con_six_2" class="hidbox">
        <div class="p10">
          <ul class="table_01 clearfix">
            @foreach( $broker_houses as $key => $house )
            <li class="w60">{{{ isset( $regions[$house['region_id']] ) ? '[' . $regions[$house['region_id']]['name'] . ']' : '' }}}</li>
            <li class="w128">
              <a href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}" title="{{{$house['title']}}}" target="_blank" class="t3">{{{ \lib\Tool::str_cut($house['title'], 30) }}}</a>
            </li>
            <li class="w60">
              @if ( $house['type'] == 'house' )
              {{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}
              @endif
            </li>
            <li class="w60">{{{$house['price']}}}万</li>
            <li class="w90">{{{\lib\Tool::str_cut($house['title'], 25)}}}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div id="con_six_3" class="hidbox">
        <div class="p10">
          <ul class="table_01 clearfix">
            @foreach( $site_houses as $key => $house )
            <li class="w60">{{{ isset( $regions[$house['region_id']] ) ? '[' . $regions[$house['region_id']]['name'] . ']' : '' }}}</li>
            <li class="w128">
              <a href="{{route( 'esf.' . $house['type'] . '.show', $house['foreign_id'] )}}" title="{{{$house['title']}}}" target="_blank" class="t3">{{{ \lib\Tool::str_cut($house['title'], 30) }}}</a>
            </li>
            <li class="w60">
              @if ( $house['type'] == 'house' )
              {{ SecondHandHousing::getRoomStructure( $house['foreign_id'] ) }}
              @endif
            </li>
            <li class="w60">{{{$house['price']}}}万</li>
            <li class="w90">{{{\lib\Tool::str_cut($house['title'], 25)}}}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>