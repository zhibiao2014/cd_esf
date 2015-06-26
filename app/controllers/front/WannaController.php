<?php
namespace front;

class WannaController extends \BaseController {

  public function buy() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 价格区间
    $params['price'] = \DB::table('s_price')->whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get();
    $params['price'] = \lib\Tool::array_key_translate($params['price'], 'price');



    $params['p'] = \Input::all();
    $params['sort'] = array('created_at', 'desc');
    if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      // unset($params['p']['s']);
    }

    if ( isset($params['p']['price']) && is_array($params['p']['price']) ) {
      $params['p']['price'] = implode(',', $params['p']['price']);
    }

    $url = action( 'front\WannaController@buy', $params['p'] );

    $house_model = new \IWannaBuyProperty;
    // 小区名字
    if (isset( $conditions['keyword'] ) && !empty($conditions['keyword']) ) {
      $model = $model->where( 'title', 'like' , '%'.$conditions['keyword'].'%' );
    }
    // 价格
    if (isset( $params['p']['price'] ) && !empty($params['p']['price']) ) {
      $house_model = $house_model->whereBetween( 'price', explode(',', $params['p']['price']) );
    }
    // 室
    if (isset( $params['p']['room'] ) && !empty($params['p']['room']) ) {
      $params['p']['room_compare'] = isset($params['p']['room_compare']) ? $params['p']['room_compare'] : '=';
      $house_model = $house_model->where( 'room', $params['p']['room_compare'] , $params['p']['room'] );
    }
    $houses = $house_model->where('status', '1')->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(20);
    // 统计当天发布数
    $current_publish = \SaleCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->count();

    $last_houses = \SecondHandHousing::orderBy( 'refresh_at' , 'desc' )->take(3)->get();
    return \View::make( 'esf.wanna.buy', $params )->withUrl($url)->withHouses($houses)->with( 'current_publish' , $current_publish )->with( 'last_houses', $last_houses )->withRoute('wanna_buy');
  }

  public function buy_show( $id ) {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0,  array( 0, 2 ) ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['directions'] = \lib\Tool::array_key_translate($params['directions']);
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0,  array( 0, 2 ) ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['decorations'] = \lib\Tool::array_key_translate($params['decorations']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0,  array( 0, 2 ) ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);
    // 楼层
    $params['floors'] = \Floor::whereIn('belong', array( 0,  array( 0, 2 ) ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['floors'] = \lib\Tool::array_key_translate($params['floors']);

    $params['wanna_buy'] = \IWannaBuyProperty::where(array( 'status' => 1, 'id' => $id ))->first();
    $params['wanna_buy']->supporting = json_decode($params['wanna_buy']->supporting, true);

    $params['other_wanna_buys'] = \IWannaBuyProperty::where('status' , 1 )->where( 'id' , '<>' , $id )->take( 5 )->get()->toArray();

    $params['member'] = \User::find( $params['wanna_buy']->member_id );
    return \View::make('esf.wanna.buy_show', $params)->withRoute('wanna_buy');
  }

  public function rent() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 价格区间
    $params['price'] = \DB::table('s_price')->whereIn('belong', array( 0, 6 ))->orderBy('sort')->orderBy('id')->get();
    $params['price'] = \lib\Tool::array_key_translate($params['price'], 'price');



    $params['p'] = \Input::all();
    $params['sort'] = array('created_at', 'desc');
    if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      // unset($params['p']['s']);
    }

    if ( isset($params['p']['price']) && is_array($params['p']['price']) ) {
      $params['p']['price'] = implode(',', $params['p']['price']);
    }

    $url = action( 'front\WannaController@buy', $params['p'] );

    $house_model = new \IWannaRentProperty;
    // 小区名字
    if (isset( $conditions['keyword'] ) && !empty($conditions['keyword']) ) {
      $model = $model->where( 'title', 'like' , '%'.$conditions['keyword'].'%' );
    }
    // 价格
    if (isset( $params['p']['price'] ) && !empty($params['p']['price']) ) {
      $house_model = $house_model->whereBetween( 'price', explode(',', $params['p']['price']) );
    }
    // 室
    if (isset( $params['p']['room'] ) && !empty($params['p']['room']) ) {
      $params['p']['room_compare'] = isset($params['p']['room_compare']) ? $params['p']['room_compare'] : '=';
      $house_model = $house_model->where( 'room', $params['p']['room_compare'] , $params['p']['room'] );
    }
    $houses = $house_model->where('status', '1')->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(20);
    // 统计当天发布数
    $current_publish = \RentCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->count();

    $last_houses = \SecondHandHousing::orderBy( 'refresh_at' , 'desc' )->take(3)->get();
    return \View::make( 'esf.wanna.rent', $params )->withUrl($url)->withHouses($houses)->with( 'current_publish' , $current_publish )->with( 'last_houses', $last_houses )->withRoute('wanna_rent');
  }

  public function rent_show( $id ) {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0,  array( 0, 2 ) ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['house_supportings'] = \lib\Tool::array_key_translate($params['house_supportings']);

    // 租赁方式
    $params['rent_methods'] = \RentMethod::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['rent_methods'] = \lib\Tool::array_key_translate($params['rent_methods']);

    $params['wanna_rent'] = \IWannaRentProperty::where(array( 'status' => 1, 'id' => $id ))->first();
    $params['wanna_rent']->supporting = json_decode($params['wanna_rent']->supporting, true);

    $params['other_wanna_rents'] = \IWannaRentProperty::where('status' , 1 )->where( 'id' , '<>' , $id )->take( 5 )->get()->toArray();

    $params['member'] = \User::find( $params['wanna_rent']->member_id );
    return \View::make('esf.wanna.rent_show', $params)->withRoute('wanna_rent');
  }
}