<?php
class SaleCommon extends CustomerModel {

  protected $table = 'sale_common';
  protected $fillable = array(
    'type'
    , 'title'
    ,'community_name'
    , 'community_id'
    , 'foreign_id'
    , 'thumbnail'
    , 'address'
    , 'price'
    , 'construction_area'
    , 'area_id'
    , 'region_id'
    , 'is_commissioned'
    , 'status'
    );

  static public function constructHouseModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    } else {
      if ($house->status != 1) {
        $house->status = 2;
      }
    }
    if ( isset($input['room_images']) ) {
      $house->thumbnail = current($input['room_images'])['url'];
    }
    return $house->fill( $input )->save();
  }

}
