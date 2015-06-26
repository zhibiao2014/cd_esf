<?php
class RentOffice extends CustomerModel {
  protected $table = 'rent_office';

  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    $house->contacts = $input['contacts'];
    $house->phone = $input['phone'];
    $house->community_name = $input['community_name'];
    $house->area_id = $input['area_id'];
    $house->address = $input['address'];
    $house->construction_area = $input['construction_area'];
    $house->price = $input['price'];
    $house->rent_method_id = $input['rent_method_id'];
    $house->pay_method_id = $input['pay_method_id'];
    $house->is_include_property_costs = $input['is_include_property_costs'];
    $house->title = $input['title'];
    $house->floor = json_encode($input['floor']);
    $house->type_id = $input['type_id'];

    if ( isset($input['property_costs']) ) {
      $house->property_costs = $input['property_costs'];
    }
    if ( isset($input['property_corporation']) ) {
      $house->property_corporation = $input['property_corporation'];
    }
    if ( isset($input['house_number']) ) {
      $house->house_number = json_encode($input['house_number']);
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
    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode( $input['supporting'] );
    }
    if ( isset($input['content']) ) {
      $house->content = $input['content'];
    }
    if ( isset($input['room_images']) ) {
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
