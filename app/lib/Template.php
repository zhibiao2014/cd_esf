<?php
namespace lib;

class Template {
  public static function feed() {
    return "";
  }

  public static function topSearchRegionSelect( $belong = 2 ) {
    // 城区
    $regions = \Area::where( 'pid', 0 )->whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $region_string = "<a href='javascript:void(0);' val=''>全部区域</a>";
    foreach ($regions as $key => $value) {
      $region_string .= "<a href='javascript:void(0);' val='" . $value['id'] . "'>" . $value['name'] . "</a>";
    }
    return $region_string;
  }

  public static function topSearchPriceSelect( $belong = 2 ) {
    // 价格区间
    $price = \DB::table('s_price')->whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get();
    $price_string = "<a href='javascript:void(0);' val=''>不限价格</a>";
    foreach ($price as $key => $value) {
      $price_string .= "<a href='javascript:void(0);' val='" . $value->price . "'>" . $value->name . "</a>";
    }
    return $price_string;
  }

  public static function topSearchAreaSelect( $belong = 2 ) {
    // 面积区间
    $areas = \DB::table('s_area')->whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get();
    $area_string = "<a href='javascript:void(0);' val=''>不限面积</a>";
    foreach ($areas as $key => $value) {
      $area_string .= "<a href='javascript:void(0);' val='" . $value->area . "'>" . $value->name . "</a>";
    }
    return $area_string;
  }

}