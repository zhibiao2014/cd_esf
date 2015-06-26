<?php
class IWannaRentProperty extends CustomerModel {

  protected $table = 'i_wanna_rent_property';
  protected $fillable = array(
    'contacts'
    , 'type'
    , 'phone'
    , 'area_id'
    , 'construction_area'
    , 'price'
    , 'rent_method_id'
    , 'title'
    , 'content'
    );
  
  static public function constructModel( $input, $model = null ) {
    $house = empty( $model ) ? new self() : $model;
    if ( empty($model) ) {
      $house = self::set_user_info( $house );
    }
    if ( isset($input['room_structure']) ) {
      $house->room_structure = json_encode($input['room_structure']);
      $house->room = $input['room_structure']['room'];
      $house->hall = $input['room_structure']['hall'];
      $house->bathroom = $input['room_structure']['bathroom'];
    }
    if ( isset($input['supporting']) ) {
      $house->supporting = json_encode($input['supporting']);
    }
    if ( isset($input['community']) ) {
      $house->community = json_encode($input['community']);
    }
    
    $input['contacts'] = \Auth::user()->realname;
    $input['phone'] = \Auth::user()->mobile;
    $house->fill( $input );
    return $house;
  }

}
