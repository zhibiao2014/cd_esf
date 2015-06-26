<?php
namespace front;

class BrokerController extends \BaseController {

  /* 首页 */
  public function index() {
    $params['p'] = \Input::all();
    $params['sort'] = array('regtime', 'asc');
    $params['brokers'] = \User::where(array('level' => 7, 'show' => 1));
    if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      // unset($params['p']['s']);
    }
    if (isset( $params['p']['keyword'] ) && !empty($params['p']['keyword']) ) {
      $params['brokers'] = $params['brokers']->where( 'realname', 'like' , '%'.$params['p']['keyword'].'%' );
    }
    $params['brokers'] = $params['brokers']->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(20);
    $companies = \User::where('level', 2)->get()->toArray();
    $params['companies'] = \lib\Tool::array_key_translate($companies);
    unset($companies);
    return \View::make( 'esf.broker.index', $params )->withRoute('broker');
  }

  public function show( $id ) {
    // echo $id;
    $params['broker'] = \User::where(array( 'id' => $id, 'level' => 7, 'show' => 1))->first();
    // var_dump($params['broker']);
    if ( empty( $params['broker'] )) {
      return \View::make('error.404')->withRoute('broker');
    }
    $params['broker']['areaids'] = json_decode( $params['broker']['areaids'], true );
    $params['company'] = \User::where( array('id' => $params['broker']->fid, 'show' => 1) )->first();

    $model = new \CustomerModel;
    $model->setConnect('cdfdc');
    $model->setTable('categories');
    $params['cdfdc_regions'] = $model->where( 'enum', 'userarea' )->get()->toArray();
    $params['cdfdc_regions'] = \lib\Tool::array_key_translate($params['cdfdc_regions']);

    $params['houses'] = \SaleCommon::where( array( 'status' => 1 , 'member_id' => $id ) )->orderBy( 'id' , 'desc' )->take(5)->get()->toArray();
    $params['rents'] = \RentCommon::where( array( 'status' => 1 , 'member_id' => $id ) )->orderBy( 'id' , 'desc' )->take(5)->get()->toArray();

    $params['communities'] = \SaleCommon::where( 'community_id', '>', 0 )->where( array( 'status' => 1 , 'member_id' => $id ) )->groupBy('community_id')->select( \DB::raw('count(*) as num, community_name, community_id') )->get();

    return \View::make('esf.broker.show', $params)->withRoute('broker');
  }

  public function rent_show( $id ) {
    $params['broker'] = \User::where(array( 'id' => $id, 'level' => 7, 'show' => 1))->first();
    if ( empty( $params['broker'] )) {
      return \View::make('error.404')->withRoute('broker');
    }
    $params['broker']['areaids'] = json_decode( $params['broker']['areaids'], true );
    $params['company'] = \User::where( array('id' => $params['broker']->fid, 'show' => 1) )->first();

    $model = new \CustomerModel;
    $model->setConnect('cdfdc');
    $model->setTable('categories');
    $params['cdfdc_regions'] = $model->where( 'enum', 'userarea' )->get()->toArray();
    $params['cdfdc_regions'] = \lib\Tool::array_key_translate($params['cdfdc_regions']);

    $params['rents'] = \RentCommon::where( array( 'status' => 1 , 'member_id' => $id ) )->orderBy( 'id' , 'desc' )->paginate(20);

    $params['communities'] = \RentCommon::where( 'community_id', '>', 0 )->where( array( 'status' => 1 , 'member_id' => $id ) )->groupBy('community_id')->select( \DB::raw('count(*) as num, community_name, community_id') )->get();
    return \View::make('esf.broker.rent_show', $params)->withRoute('broker');
  }

  public function sale_show( $id ) {
    $params['broker'] = \User::where(array( 'id' => $id, 'level' => 7, 'show' => 1))->first();
    if ( empty( $params['broker'] )) {
      return \View::make('error.404')->withRoute('broker');
    }
    $params['broker']['areaids'] = json_decode( $params['broker']['areaids'], true );
    $params['company'] = \User::where( array('id' => $params['broker']->fid, 'show' => 1) )->first();

    $model = new \CustomerModel;
    $model->setConnect('cdfdc');
    $model->setTable('categories');
    $params['cdfdc_regions'] = $model->where( 'enum', 'userarea' )->get()->toArray();
    $params['cdfdc_regions'] = \lib\Tool::array_key_translate($params['cdfdc_regions']);

    $params['houses'] = \SaleCommon::where( array( 'status' => 1 , 'member_id' => $id ) )->orderBy( 'id' , 'desc' )->paginate(20);

    $params['communities'] = \SaleCommon::where( 'community_id', '>', 0 )->where( array( 'status' => 1 , 'member_id' => $id ) )->groupBy('community_id')->select( \DB::raw('count(*) as num, community_name, community_id') )->get();
    return \View::make('esf.broker.sale_show', $params)->withRoute('broker');
  }

}