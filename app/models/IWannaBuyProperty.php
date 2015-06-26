<?php
class IWannaBuyProperty extends CustomerModel {

  protected $table = 'i_wanna_buy_property';
  protected $fillable = array(
    'contacts'
    , 'type'
    , 'phone'
    , 'area_id'
    , 'construction_area'
    , 'price'
    , 'house_age'
    , 'direction_id'
    , 'decoration_id'
    , 'floor'
    , 'title'
    , 'content'
    );
  
  static public function constructModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    if ( isset($input['shop_manager_type']) ) {
      $house->shop_manager_type = json_encode($input['shop_manager_type']);
    }
    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode($input['supporting']);
    }
    if ( isset($input['type_id']) && is_array($input['type_id']) ) {
      $house->type_id = json_encode($input['type_id']);
    }
    if ( isset($input['room_structure']) ) {
      $house->room_structure = json_encode($input['room_structure']);
      $house->room = $input['room_structure']['room'];
      $house->hall = $input['room_structure']['hall'];
      $house->bathroom = $input['room_structure']['bathroom'];
    }
    $input['contacts'] = \Auth::user()->realname;
    $input['phone'] = \Auth::user()->mobile;
    $house->fill( $input );
    return $house;
  }

}
