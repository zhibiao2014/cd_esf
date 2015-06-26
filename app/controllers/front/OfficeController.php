<?php
namespace front;

class OfficeController extends \BaseController {

  public function lists() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);
    // 价格区间
    $params['price'] = \DB::table('s_price')->whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get();
    $params['price'] = \lib\Tool::array_key_translate($params['price'], 'price');
    // 面积区间
    $params['areas'] = \DB::table('s_area')->whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get();
    $params['areas'] = \lib\Tool::array_key_translate($params['areas'], 'area');

    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['types'] = \lib\Tool::array_key_translate($types);

    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['directions'] = \lib\Tool::array_key_translate($params['directions']);
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['decorations'] = \lib\Tool::array_key_translate($params['decorations']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);
    // 特色标签
    $params['tags'] = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['tags'] = \lib\Tool::array_key_translate($params['tags']);

    $params['p'] = \Input::all();
    foreach ($params['p'] as $key => $value) {
        if (empty($value)) {
            unset($params['p'][$key]);
        }
    }
    $params['sort'] = array('refresh_at', 'desc');
    if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      // unset($params['p']['s']);
    }
    if ( isset($params['p']['price']) && is_array($params['p']['price']) ) {
      $params['p']['price'] = implode(',', $params['p']['price']);
    }
    $url = action( 'front\HouseController@lists', $params['p'] );
    $house_model = \Office::search($params['p']);

    $communities = \House::select('id', 'title', 'address', 'price', 'area')->get()->toArray();
    $communities = \lib\Tool::array_key_translate($communities);

    // 统计当天发布数
    $current_publish = \SaleCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->count();
    if ( $params['sort'][0] != 'sprice' ) {
      $houses = $house_model->where('status', '1')->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(20);
    } else {
      $houses = $house_model->where('status', '1')->select( '*', \DB::raw('price/construction_area as sprice') )->orderBy( 'sprice', $params['sort'][1] )->paginate(20);
    }
    unset($params['p']['page']);

    $last_houses = \Office::where( 'status', '1' )->orderBy( 'refresh_at' , 'desc' )->take(3)->get();

    return \View::make( 'esf.office.list', $params )->withUrl($url)->withHouses($houses)->with('communities', $communities)->with( 'current_publish' , $current_publish )->with( 'last_houses', $last_houses )->withRoute('office');
  }


  public function show($id) {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['types'] = \lib\Tool::array_key_translate($types);

    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['directions'] = \lib\Tool::array_key_translate($params['directions']);
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['decorations'] = \lib\Tool::array_key_translate($params['decorations']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);
    // 特色标签
    $params['tags'] = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['tags'] = \lib\Tool::array_key_translate($params['tags']);

    $params['wuye'] = array("1" => "普通住宅", "2" => "公寓", "3" => "商住", "4" => "写字楼", "5" => "商铺", "6" => "别墅", "7" => "仓库", "9" => "其他" );
    // var_dump($params['wuye']);

    $model = new \CustomerModel;
    $model->setConnect('cdfdc');
    $model->setTable('categories');
    $params['cdfdc_regions'] = $model->where( 'enum', 'area' )->get()->toArray();
    $params['cdfdc_regions'] = \lib\Tool::array_key_translate($params['cdfdc_regions']);

    $params['house'] = \Office::find($id);
    $params['house']->tag = empty($params['house']->tag) ? NULL : json_decode( $params['house']->tag, true );
    $params['house']->room_images = empty($params['house']->room_images) ? NULL : json_decode( $params['house']->room_images, true );
    $params['house']->supporting = empty($params['house']->supporting) ? NULL : json_decode( $params['house']->supporting, true );
    if ( !empty( $params['house']->community_id ) ) {
      $params['community'] = \House::join('developers', 'property.devid', '=', 'developers.id')->select('property.*','developers.company')->find($params['house']->community_id);
      $params['community']->wuye = json_decode($params['community']->wuye, true);
      $params['community']->show_pictures = json_decode($params['community']->show_pictures, true);
    }

    if ( $params['house']->is_broker ) {
      $params['user'] = \User::find( $params['house']->member_id );
      $params['broker_other_house'] = \Office::where( 'id', '<>', $params['house']->id )->where( 'member_id', $params['house']->member_id )->get()->toArray();
      if ( !empty($params['user']) ) {
        $params['company'] = \User::find( $params['user']->fid );
      }
    }

    $price_greater_than_siblings = \Office::where('price', '>=' , $params['house']->price)->where( 'id', '<>', $params['house']->id )->orderBy( 'price', 'asc' )->take(2)->get()->toArray();

    $price_less_than_siblings = \Office::where('price', '<' , $params['house']->price)->orderBy( 'price', 'desc' )->take(2)->get()->toArray();
    $params['price_siblings'] = array_merge($price_less_than_siblings, $price_greater_than_siblings);

    $params['community_other_house'] = \Office::where( 'community_name' , $params['house']->community_name )->where( 'id', '<>', $params['house']->id )->take(5)->get()->toArray();

    return \View::make('esf.office.show' , $params )->withRoute('office');
  }

  public function rent_lists() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);
    // 价格区间
    $params['price'] = \DB::table('s_price')->whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get();
    $params['price'] = \lib\Tool::array_key_translate($params['price'], 'price');
    // 面积区间
    $params['areas'] = \DB::table('s_area')->whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get();
    $params['areas'] = \lib\Tool::array_key_translate($params['areas'], 'area');
    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['types'] = \lib\Tool::array_key_translate($types);

    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['directions'] = \lib\Tool::array_key_translate($params['directions']);
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['decorations'] = \lib\Tool::array_key_translate($params['decorations']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);
    // 特色标签
    $params['tags'] = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['tags'] = \lib\Tool::array_key_translate($params['tags']);

    $params['p'] = \Input::all();
    foreach ($params['p'] as $key => $value) {
        if (empty($value)) {
            unset($params['p'][$key]);
        }
    }
    $params['sort'] = array('refresh_at', 'desc');
    if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      // unset($params['p']['s']);
    }
    if ( isset($params['p']['price']) && is_array($params['p']['price']) ) {
      $params['p']['price'] = implode(',', $params['p']['price']);
    }
    $url = action( 'front\HouseController@lists', $params['p'] );
    $house_model = \RentOffice::search($params['p']);

    $communities = \House::select('id', 'title', 'address', 'price', 'area')->get()->toArray();
    $communities = \lib\Tool::array_key_translate($communities);

    // 统计当天发布数
    $current_publish = \RentCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->count();
    if ( $params['sort'][0] != 'sprice' ) {
      $houses = $house_model->where('status', '1')->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(20);
    } else {
      $houses = $house_model->where('status', '1')->select( '*', \DB::raw('price/construction_area as sprice') )->orderBy( 'sprice', $params['sort'][1] )->paginate(20);
    }
    unset($params['p']['page']);

    $last_houses = \RentOffice::where( 'status', '1' )->orderBy( 'refresh_at' , 'desc' )->take(3)->get();

    return \View::make( 'esf.office.rent_list', $params )->withUrl($url)->withHouses($houses)->with('communities', $communities)->with( 'current_publish' , $current_publish )->with( 'last_houses', $last_houses )->withRoute('office');
  }

  public function rent_show($id) {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['types'] = \lib\Tool::array_key_translate($types);

    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['directions'] = \lib\Tool::array_key_translate($params['directions']);
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['decorations'] = \lib\Tool::array_key_translate($params['decorations']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);
    // 特色标签
    $params['tags'] = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get();
    $params['tags'] = \lib\Tool::array_key_translate($params['tags']);
    // 支付方式
    $params['pay_methods'] = \PayMethod::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['pay_methods'] = \lib\Tool::array_key_translate($params['pay_methods']);

    $params['wuye'] = array("1" => "普通住宅", "2" => "公寓", "3" => "商住", "4" => "写字楼", "5" => "商铺", "6" => "别墅", "7" => "仓库", "9" => "其他" );
    // var_dump($params['wuye']);

    $model = new \CustomerModel;
    $model->setConnect('cdfdc');
    $model->setTable('categories');
    $params['cdfdc_regions'] = $model->where( 'enum', 'area' )->get()->toArray();
    $params['cdfdc_regions'] = \lib\Tool::array_key_translate($params['cdfdc_regions']);

    $params['house'] = \RentOffice::find($id);
    $params['house']->tag = empty($params['house']->tag) ? NULL : json_decode( $params['house']->tag, true );
    $params['house']->room_images = empty($params['house']->room_images) ? NULL : json_decode( $params['house']->room_images, true );
    $params['house']->supporting = empty($params['house']->supporting) ? NULL : json_decode( $params['house']->supporting, true );
    $params['house']->floor = empty($params['house']->floor) ? NULL : json_decode( $params['house']->floor, true );

    if ( !empty( $params['house']->community_id ) ) {
      $params['community'] = \House::join('developers', 'property.devid', '=', 'developers.id')->select('property.*','developers.company')->find($params['house']->community_id);
      $params['community']->wuye = json_decode($params['community']->wuye, true);
      $params['community']->show_pictures = json_decode($params['community']->show_pictures, true);
    }

    if ( $params['house']->is_broker ) {
      $params['user'] = \User::find( $params['house']->member_id );
      $params['broker_other_house'] = \RentOffice::where( 'id', '<>', $params['house']->id )->where( 'member_id', $params['house']->member_id )->get()->toArray();
      if ( !empty($params['user']) ) {
        $params['company'] = \User::find( $params['user']->fid );
      }
    }

    $price_greater_than_siblings = \RentOffice::where('price', '>=' , $params['house']->price)->where( 'id', '<>', $params['house']->id )->orderBy( 'price', 'asc' )->take(2)->get()->toArray();

    $price_less_than_siblings = \RentOffice::where('price', '<' , $params['house']->price)->orderBy( 'price', 'desc' )->take(2)->get()->toArray();
    $params['price_siblings'] = array_merge($price_less_than_siblings, $price_greater_than_siblings);

    $params['community_other_house'] = \RentOffice::where( 'community_name' , $params['house']->community_name )->where( 'id', '<>', $params['house']->id )->take(5)->get()->toArray();

    return \View::make('esf.office.rent_show' , $params )->withRoute('office');
  }

}
?>