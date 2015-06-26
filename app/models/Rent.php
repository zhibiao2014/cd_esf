<?php
class Rent extends CustomerModel {
  protected $table = 'rent';

  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    $house->contacts = $input['contacts'];
    $house->phone = $input['phone'];
    $house->community_name = $input['community_name'];
    if( isset($input['community_id']) ) {
      $house->community_id = $input['community_id'];
    }
    $house->area_id = $input['area_id'];
    $house->region_id = $input['region_id'];
    $house->address = $input['address'];

    $house->room_structure = json_encode($input['room_structure']);
    $house->hall = $input['room_structure']['hall'];
    $house->room = $input['room_structure']['room'];
    $house->bathroom = $input['room_structure']['bathroom'];

    $house->construction_area = $input['construction_area'];
    $house->price = $input['price'];
    $house->rent_method_id = $input['rent_method_id'];
    $house->pay_method_id = $input['pay_method_id'];

    $house->current_floor = $input['floor']['floor'];
    $house->total_floor = $input['floor']['total_floor'];
    $house->floor = json_encode($input['floor']);
    if ( isset($input['house_number']) ) {
      $house->house_number = json_encode($input['house_number']);
    }
    if ( isset($input['direction_id']) ) {
      $house->direction_id = $input['direction_id'];
    }
    if ( isset($input['decoration_id']) ) {
      $house->decoration_id = $input['decoration_id'];
    }
    if ( isset($input['tag']) ) {
      $house->tag = json_encode( $input['tag'] );
    }
    if ( isset($input['customer_tag']) ) {
      $house->customer_tag = json_encode( $input['customer_tag'] );
    }
    $house->title = $input['title'];
    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode( $input['supporting'] );
    }
    if ( isset($input['content']) ) {
      $house->content = $input['content'];
    }
    if ( isset($input['room_images']) ) {
      $house->thumbnail = current($input['room_images'])['url'];
      $house->room_images = json_encode( $input['room_images'] );
    }
    if ( isset($input['is_commissioned']) ) {
      $house->is_commissioned = $input['is_commissioned'];
    }
    if (empty($model)) {
      $house->refresh_at = date("Y-m-d H:i:s");
    } else {
      if ($house->status != 1) {
        $house->status = 2;
      }
    }
    return $house;
  }

  static public function search( $conditions = array() ) {
    $model = new self();
    // 小区名字
    if (isset( $conditions['keyword'] ) && !empty($conditions['keyword']) ) {
      $model = $model->where( 'community_name', 'like' , '%'.$conditions['keyword'].'%' )->orWhere( 'title', 'like', '%'.$conditions['keyword'].'%' );
    }

    // 区域
    if (isset( $conditions['region'] ) && !empty($conditions['region']) ) {
      $model = $model->where( 'region_id', $conditions['region'] );
    }

    // 价格
    if (isset( $conditions['price'] ) && !empty($conditions['price']) ) {
      $model = $model->whereBetween( 'price', explode(',', $conditions['price']) );
    }

    // 室
    if (isset( $conditions['room'] ) && !empty($conditions['room']) ) {
      $conditions['room_compare'] = isset($conditions['room_compare']) ? $conditions['room_compare'] : '=';
      $conditions['room_compare'] = htmlspecialchars_decode($conditions['room_compare']);
      $model = $model->where( 'room', $conditions['room_compare'] , $conditions['room'] );
    }

    // 面积
    if (isset( $conditions['area'] ) && !empty($conditions['area']) ) {
      $model = $model->whereBetween( 'construction_area', explode(',', $conditions['area']) );
    }

    // 特色标签
    if (isset( $conditions['tag'] ) && !empty($conditions['tag']) ) {
      $model = $model->where( 'tag', 'like', '%"' . $conditions['tag'] . '"%' );
    }

    // 朝向
    if (isset( $conditions['direction'] ) && !empty($conditions['direction']) ) {
      $model = $model->where( 'direction_id', $conditions['direction'] );
    }

    // 楼层
    if (isset( $conditions['floor'] ) && !empty($conditions['floor']) ) {
      $conditions['floor_compare'] = isset($conditions['floor_compare']) ? $conditions['floor_compare'] : '=';
      if ($conditions['floor_compare'] == 'in' ) {
        $model = $model->whereBetween( 'area', explode(',', $conditions['floor']) );
      } else {
        $conditions['floor_compare'] = htmlspecialchars_decode($conditions['floor_compare']);
        $model = $model->where( 'current_floor', $conditions['floor_compare'] , $conditions['floor'] );
      }
    }

    // 装修
    if (isset( $conditions['decoration'] ) && !empty($conditions['decoration']) ) {
      $model = $model->where( 'decoration_id', $conditions['decoration'] );
    }

    // 配套设施
    if (isset( $conditions['supporting'] ) && is_array($conditions['supporting']) ) {
      foreach ($conditions['supporting'] as $key => $supporting) {
        $model = $model->where( 'supporting', 'like' ,'%"' . $supporting . '"%' );
      }
    }
    return $model;
  }

  static public function getListInfo( $id ) {
    $rent = self::find( $id );
    if (!empty($rent)) {
      return '<li>' . $rent->current_floor . '/' . $rent->total_floor . '层 <span class="ml5 mr5">/</span>' . $rent->room . '室' . $rent->hall . '厅' . $rent->bathroom . '卫<span class="ml5 mr5">/</span> ' . date('Y-m-d', strtotime($rent->refresh_at)) . ' </li>';
    }
    return '';
  }

  static public function getRoomStructure( $id ) {
    $room = self::find( $id );
    if (!empty($room)) {
      return $room->room . '室' . $room->hall . '厅' . $room->bathroom . '卫';
    }
    return '';
  }

}
