<?php
namespace front;

class HomeController extends \BaseController {

  /* 二手房首页 */
  public function index() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);
    // 价格区间
    $params['price'] = \DB::table('s_price')->whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get();
    $params['price'] = \lib\Tool::array_key_translate($params['price'], 'price');
    // 统计所有房源
    $params['total_publish'] = \SaleCommon::where( 'status', '1' )->count();
    // 统计三天内发布房源数目
    $params['last_publish'] = \SaleCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 4 ' )->count();
    // 统计当天有多少人发布数
    $params['current_publish'] = \SaleCommon::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->count();

    $params['last_houses'] = \SecondHandHousing::where( 'status', '1' )->orderBy( 'refresh_at' , 'desc' )->take(3)->get();
    // 推荐房源
    $params['houses'] = \SaleCommon::join( 'position_data', 'sale_common.foreign_id', '=', 'position_data.id' )->where( array( 'status' => 1, 'module' => 'Sale', 'posid' => 9 ) )->orderBy('created_at', 'desc')->take(5)->select('sale_common.*')->get()->toArray();
    // 推荐出租
    $params['rents'] = \RentCommon::join( 'position_data', 'rent_common.foreign_id', '=', 'position_data.id' )->where( array( 'status' => 1, 'module' => 'Rent', 'posid' => 10 ) )->orderBy('created_at', 'desc')->take(5)->select('rent_common.*')->get()->toArray();

    // 本网房源
    $params['commissioned_houses'] = \SecondHandHousing::where( 'status', '1' )->where( 'is_commissioned', 1 )->orderBy('created_at', 'desc')->take(6)->get()->toArray();
    // 个人房源
    $params['individual_houses'] = \SecondHandHousing::where( 'status', '1' )->where( 'is_individual', 1 )->orderBy('created_at', 'desc')->take(12)->get()->toArray();
    // 中介房源
    $params['broker_houses'] = \SecondHandHousing::where( 'status', '1' )->where( 'is_broker', 1 )->orderBy('created_at', 'desc')->take(12)->get()->toArray();

    // 商铺
    $params['shops'] = \Shop::where( 'status', '1' )->orderBy('created_at', 'desc')->take(6)->get()->toArray();
    // 写字楼
    $params['offices'] = \Office::where( 'status', '1' )->orderBy('created_at', 'desc')->take(6)->get()->toArray();

    return \View::make( 'esf.home.index', $params );
  }

  function embed_index() {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    // 最新房源
    $params['last_houses'] = \SaleCommon::where( 'status', '1' )->orderBy('created_at', 'desc')->take(10)->get()->toArray();
    // 个人二手房
    $params['individual_houses'] = \SaleCommon::where( 'status', '1' )->where( 'is_individual' , 1 )->orderBy('created_at', 'desc')->take(10)->get()->toArray();
    // 经纪人二手房
    $params['broker_houses'] = \SaleCommon::where( 'status', '1' )->where( 'is_broker' , 1 )->orderBy('created_at', 'desc')->take(10)->get()->toArray();
    // 本网二手房
    $params['site_houses'] = \SaleCommon::where( 'status', '1' )->where( 'is_admin' , 1 )->orderBy('created_at', 'desc')->take(10)->get()->toArray();
    return \View::make( 'esf.home.embed_index', $params );
  }

}