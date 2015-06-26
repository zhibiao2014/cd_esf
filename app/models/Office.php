<?php
class Office extends CustomerModel {

  protected $table = 'office';
  protected $fillable = array(
    'contacts'
    , 'phone'
    , 'community_name'
    , 'community_id'
    , 'area_id'
    , 'address'
    , 'construction_area'
    , 'price'
    , 'decoration_id'
    , 'current_floor'
    , 'total_floor'
    , 'title'
    , 'is_commissioned'
    , 'region_id'
    // office
    , 'validity'
    , 'type_id'
    , 'construct_year'
    , 'property_costs'
    , 'property_corporation'

    );


  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    $input['current_floor'] = $input['floor']['floor'];
    $input['total_floor'] = $input['floor']['total_floor'];
    $house->floor = json_encode($input['floor']);

    if ( isset($input['house_number']) ) {
      $house->house_number = json_encode($input['house_number']);
    }
    if ( isset($input['tag']) ) {
      $house->tag = json_encode( $input['tag'] );
    }
    if ( isset($input['customer_tag']) ) {
      $house->customer_tag = json_encode( $input['customer_tag'] );
    }
    if ( isset($input['room_images']) ) {
      $house->thumbnail = current($input['room_images'])['url'];
      $house->room_images = json_encode( $input['room_images'] );
    }
    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode( $input['supporting'] );
    }
    if ( isset($input['content']) ) {
      $house->content = \lib\Tool::trim_textarea( $input['content'] );
    }
    if ( isset($input['traffic']) ) {
      $house->traffic = \lib\Tool::trim_textarea( $input['traffic'] );
    }
    if ( isset($input['around']) ) {
      $house->around = \lib\Tool::trim_textarea( $input['around'] );
    }
    if (empty($model)) {
      $house->refresh_at = date("Y-m-d H:i:s");
    } else {
      if ($house->status != 1) {
        $house->status = 2;
      }
    }
    $house->fill( $input );
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

    // 面积
    if (isset( $conditions['area'] ) && !empty($conditions['area']) ) {
      $model = $model->whereBetween( 'construction_area', explode(',', $conditions['area']) );
    }

    // 类型
    if (isset( $conditions['type'] ) && !empty($conditions['type']) ) {
      $model = $model->where( 'type_id', $conditions['type'] );
    }
    return $model;
  }

}
