<?php
class RentShop extends CustomerModel {
  protected $table = 'rent_shop';

  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    $house->contacts = $input['contacts'];
    $house->phone = $input['phone'];
    $house->rent_type = $input['rent_type'];
    $house->community_name = $input['community_name'];
    $house->area_id = $input['area_id'];
    $house->address = $input['address'];
    $house->type_id = $input['type_id'];
    $house->shop_face_type_id = $input['shop_face_type_id'];
    $house->shop_status = $input['shop_status'];

    if ( isset($input['shop_manager_type']) ) {
      $house->shop_manager_type = json_encode($input['shop_manager_type']);
    }

    $house->construction_area = $input['construction_area'];
    $house->price = $input['price'];
    $house->price_unit = isset($input['price_unit']) ? $input['price_unit'] : 0;
    $house->pay_method_id = $input['pay_method_id'];

    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode( $input['supporting'] );
    }

    $house->validity = $input['validity'];

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
    if ( isset($input['content']) ) {
      $house->content = \lib\Tool::trim_textarea( $input['content'] );
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

    // 经营行业
    if (isset( $conditions['shop_manager_type'] ) && !empty($conditions['shop_manager_type']) ) {
      $model = $model->where( 'shop_manager_type', 'like' ,'%"' . $conditions['shop_manager_type'] . '"%' );
    }

    return $model;
  }

}
