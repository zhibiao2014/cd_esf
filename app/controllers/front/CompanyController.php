<?php
namespace front;

class CompanyController extends \BaseController {

  /* 公司首页 */
  public function index() {
    $params['p'] = \Input::all();
    $params['sort'] = array('regtime', 'asc');
    $params['companies'] = \User::where(array('level' => 2, 'show' => 1));
    $params['company_count'] = \User::where(array('level' => 2, 'show' => 1))->count();
    /*if (isset( $params['p']['s'] )) {
      $params['sort'] = $params['p']['s'];
      unset($params['p']['s']);
    }
    if (isset( $params['p']['keyword'] ) && !empty($params['p']['keyword']) ) {
      $params['brokers'] = $params['brokers']->where( 'realname', 'like' , '%'.$params['p']['keyword'].'%' );
    }*/
    $params['companies'] = $params['companies']->orderBy( $params['sort'][0], $params['sort'][1] )->paginate(10);
    // 统计当天发布数
    $current_publish = count(\SecondHandHousing::where( 'status', '1' )->whereRaw( ' DATEDIFF( CURDATE(), `created_at` ) < 1 ' )->groupBy('member_id')->get());
    $last_houses = \SecondHandHousing::where( 'status', '1' )->orderBy( 'refresh_at' , 'desc' )->take(3)->get();
    return \View::make( 'esf.company.index', $params )->with( 'current_publish' , $current_publish )->with( 'last_houses', $last_houses )->withRoute('companny');
  }

  public function show( $id ) {
    // 城区
    $params['regions'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['regions'] = \lib\Tool::array_key_translate($params['regions']);

    $params['company'] = \User::where(array( 'id' => $id, 'show' => 1))->first();
    $params['brokers'] = \User::where(array( 'fid' => $id, 'show' => 1))->get()->toArray();
    $params['recommend_brokers'] = array_slice($params['brokers'] , 0, 3);
    $broker_ids = array(0);
    foreach ($params['brokers'] as $key => $broker) {
      $broker_ids[] = $broker['id'];
    }
    $params['houses'] = \SaleCommon::where( 'status', '1' )->whereIn( 'member_id' , $broker_ids )->orderBy( 'created_at' , 'desc' )->take(10)->get()->toArray();
    foreach ($params['houses'] as $key => $value) {
      if ( $value['type'] == 'house' ) {
        $params['houses'][$key]['room_structure'] = \SecondHandHousing::getRoomStructure( $value['foreign_id'] );
      }
    }
    $params['last_houses'] = array_slice($params['houses'] , 0, 3);
    $params['rents'] = \RentCommon::where( 'status', '1' )->whereIn( 'member_id' , $broker_ids )->orderBy( 'created_at' , 'desc' )->take(10)->get();
    foreach ($params['rents'] as $key => $value) {
      if ( $value['type'] == 'rent' ) {
        $params['rents'][$key]['room_structure'] = \Rent::getRoomStructure( $value['foreign_id'] );
      }
    }
    return \View::make( 'esf.company.show', $params )->withRoute('companny');
  }
}