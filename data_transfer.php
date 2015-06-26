<?php
require __DIR__.'/bootstrap/autoload.php';
$app = require_once __DIR__.'/bootstrap/start.php';

// date_default_timezone_set('Australia/Brisbane');
$cdfdc_con = DB::connection('cdfdc');
$cdfdc_usercenter_con = DB::connection('mysql');
$cdfdc_usercenter_con = DB::connection('mysql');

// $areas = $cdfdc_con->table('categories')->where( 'enum' , 'area' )->get();
// $areas = \lib\Tool::array_key_translate( $areas );

$esfs = $cdfdc_con->table('esf')->where('fid', '0')->get();

function esf_data_switch( $esfs ) {
  $temp = array();
  foreach ($esfs as $key => $esf) {
    $data = array( 'contacts' => $esf->lianxiren,
      'phone' => $esf->mobile,
      'community_name' => $esf->xqmc ,
      'community_id' => $esf->proid,
      'region_id' => '',
      'area_id' => '',
      'address' => $esf->address,
      'room_structure' => json_encode( array('room' => $esf->fx_s, 'hall' => $esf->fx_t, 'bathroom' => $esf->fx_w) ),
      'room' => $esf->fx_s ,
      'hall' => $esf->fx_t ,
      'bathroom' => $esf->fx_w ,
      'construction_area' => $esf->czmj,
      'price' => $esf->price,
      'floor' => json_encode( array( 'floor' => $esf->louceng, 'total_floor' => $esf->gong ) ) ,
      'current_floor' => $esf->louceng ,
      'total_floor' => $esf->gong ,
      'house_number' => '' ,
      'direction_id' => '' ,
      'decoration_id' => '' ,
      'tag' => '' ,
      'customer_tag' => $esf->fytsbq ,
      'title' => $esf->title ,
      'supporting' => '' ,
      'content' => $esf->content,
      'thumbnail' => $esf->cover_image ? Config::get( 'app.url' ) . $esf->cover_image : '',
      'content' => $esf->content,
      'is_commissioned' => 0 ,
      'is_broker' => 0 ,
      'is_admin' => 0 ,
      'is_individual' => 1 ,
      'member_id' => $esf->userid,
      'status' => $esf->allow,
      'refresh_at' => $esf->updatetime ,
      'created_at' => $esf->updatetime ,
      'updated_at' => $esf->updatetime ,
      );
    $room_images = array();
    $esf->show_pictures = json_decode($esf->show_pictures, true);
    if ( ! empty($esf->show_pictures) ) {
      foreach ($esf->show_pictures as $key => $value) {
        if (isset($value['id'])) {
          $room_images[$key]['id'] = $value['id'];
        }
        if (isset($value['url'])) {
          $room_images[$key]['url'] = Config::get( 'app.url' ) . $value['url'];
        }
      }
    }
    $data['room_images'] = json_encode($room_images);
    $temp[] = $data;
  }
  return $temp;
}

$switched_data = esf_data_switch($esfs);

foreach ($switched_data as $key => $value) {
  $user = $cdfdc_con->table( 'member' )->where('id', $value['member_id'])->first();
  if (empty($user)) {
    continue;
  }
  $id = $cdfdc_usercenter_con->table( 'second_hand_housing' )->insertGetId( $value );
  echo $id . "<br>\n";
  $common_data = array( 'type' => 'house',
    'title' => $value['title'],
    'community_id' => $value['community_id'],
    'community_name' => $value['community_name'],
    'foreign_id' => $id,
    'thumbnail' => $value['thumbnail'],
    'address' => $value['address'],
    'price' => $value['price'],
    'construction_area' => $value['construction_area'],
    'region_id' => $value['region_id'],
    'area_id' => $value['area_id'],
    'is_individual' => $value['is_individual'],
    'is_commissioned' => $value['is_commissioned'],
    'is_broker' => $value['is_broker'],
    'is_admin' => $value['is_admin'],
    'member_id' => $value['member_id'],
    'status' => $value['status'],
    'created_at' => $value['created_at'],
    'updated_at' => $value['updated_at'] );
  $cdfdc_usercenter_con->table( 'sale_common' )->insert( $common_data );

  // 更新用户信息
  if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($user->last_refresh_date)) ) ) {
    $userdata['refresh_time'] = $user->refresh_time + 1;
  } else {
    $userdata['refresh_time'] = 1;
  }
  $userdata['publish_num'] = $user->publish_num + 1;
  $userdata['last_refresh_date'] = date("Y-m-d H:i:s");
  $cdfdc_con->table( 'member' )->where('id', $value['member_id'])->update( $userdata );
}

// var_dump();

/*echo "<pre>";
var_dump( $switched_data );
echo "</pre>";
*/




