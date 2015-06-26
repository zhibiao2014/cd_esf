<?php
class RentVillas extends CustomerModel {
  protected $table = 'rent_villas';

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
    $house->room_structure = json_encode($input['room_structure']);
    $house->construction_area = $input['construction_area'];
    $house->price = $input['price'];
    $house->rent_method_id = $input['rent_method_id'];
    $house->pay_method_id = $input['pay_method_id'];

    $house->floor = $input['floor'];
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
}
