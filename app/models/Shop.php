<?php
class Shop extends CustomerModel {

  protected $table = 'shop';
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
    , 'title'
    , 'is_commissioned'
    , 'region_id'
    // shop
    , 'validity'
    , 'type_id'
    , 'construct_year'
    , 'shop_face_type_id'

    );

  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    /*$house->contacts = $input['contacts'];
    $house->phone = $input['phone'];
    $house->community_name = $input['community_name'];
    $house->area_id = $input['area_id'];
    $house->address = $input['address'];
    $house->construction_area = $input['construction_area'];
    $house->price = $input['price'];
    $house->shop_face_type_id = $input['shop_face_type_id'];
    $house->validity = $input['validity'];
    $house->type_id = $input['type_id'];
    $house->title = $input['title'];

    if ( isset($input['decoration_id']) ) {
      $house->decoration_id = $input['decoration_id'];
    }
    if ( isset($input['construct_year']) ) {
      $house->construct_year = $input['construct_year'];
    }
    if ( isset($input['is_commissioned']) ) {
      $house->is_commissioned = $input['is_commissioned'];
    }*/

    if ( isset($input['shop_manager_type']) ) {
      $house->shop_manager_type = json_encode($input['shop_manager_type']);
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

    // 经营行业
    if (isset( $conditions['shop_manager_type'] ) && !empty($conditions['shop_manager_type']) ) {
      $model = $model->where( 'shop_manager_type', 'like' ,'%"' . $conditions['shop_manager_type'] . '"%' );
    }

    return $model;
  }

}
