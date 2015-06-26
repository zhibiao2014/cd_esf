<?php
namespace usercenter;

class VillasController extends \BaseController {

  private $rules = array(
    'contacts' => 'required'
    , 'phone' => 'required|digits:11'
    , 'community_name' => 'required'
    , 'area_id' => 'required:integer'
    , 'room_structure' => 'required'
    , 'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'floor' => 'required'
    , 'title' => 'required'
    , 'valid_code' => 'valid_code'
    );
  private $messages = array(
    'contacts.required' => '联系人必填'
    , 'phone.required' => '手机号码必填'
    , 'phone.digits' => '手机号码必须为11位纯数字'
    , 'community_name.required' => '楼盘名称必填'
    , 'area_id.required' => '城区必选区域'
    , 'area_id.integer' => '城区格式不正确'
    , 'room_structure.required' => '户型必填'
    , 'construction_area.required' => '建筑面积必填'
    , 'construction_area.numeric' => '建筑面积必须为数字'
    , 'price.required' => '价格必填'
    , 'price.numeric' => '价格必须为数字'
    , 'floor.required' => '楼层必填'
    , 'title.required' => '房源标题必填'
    , 'valid_code.valid_code' => '验证码不匹配'
    , 'construction_area.min' => '建筑面积必须大于1'
    , 'price.min' => '价格必须大于1'
    );

  protected $access = array(
    'individual' => array('index', 'create', 'store', 'edit', 'update', 'destroy'),
    'broker' => array('index', 'create', 'store', 'edit', 'update', 'destroy'),
    'company' => array()
    );

  public function __construct() {
    $this->user = \Auth::user();
    \Validator::extend('valid_code', function($attribute, $value, $parameters) {
      if ( empty($value) && $input['phone'] == $second_hand_housing->phone ) {
        return true;
      } else {
        return $value == \Session::get('temp_mcode');
      }
    });
    $this->beforeFilter('@filterAccess');
    $this->beforeFilter( '@filterPublish', array('only' => array('create', 'store')) );
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    return \Redirect::to( 'house' )->withType('villas');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    // 城区
    $areas = \Area::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $areas = \lib\Tool::array_key_translate($areas);
    // 朝向
    $directions = \Direction::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 装修
    $decorations = \Decoration::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 房屋配套
    $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 特色标签
    $tags = \Tag::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    
    return \View::make('usercenter.villas.create', array( 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = \Input::get('info');
    $validator = \Validator::make($input, $this->rules, $this->messages);
    if ($validator->fails()) {
      return \Redirect::to('villas/create')->withErrors($validator)->withInput(\Input::all());
    }
    $villas = \Villas::constructHouseModel($input);
    if ( $villas->save() ) {
      // 公共信息
      $input['foreign_id'] = $second_hand_housing->id;
      $input['type'] = 'house';
      \SaleCommon::constructHouseModel($input);

      // 更新用户信息
      if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->last_refresh_date)) ) ) {
        $this->user->refresh_time += 1;
      } else {
        $this->user->refresh_time = 1;
      }
      $this->user->publish_num += 1;
      $this->user->last_refresh_date = date("Y-m-d H:i:s");
      $this->user->save();

      return \Redirect::to( 'house' )->withType('villas');
    } else {
      return \Redirect::to('villas/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $villas = \Villas::find($id)->toArray();
    // if ( $villas && $villas['member_id'] == $this->user->id ) {
    if ( $villas ) {
      $this->filterOwner($villas);
      // 城区
      $areas = \Area::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $areas = \lib\Tool::array_key_translate($areas);
      // 朝向
      $directions = \Direction::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 装修
      $decorations = \Decoration::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 房屋配套
      $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 特色标签
      $tags = \Tag::whereIn('belong', array( 0, 5 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $villas['room_structure'] = json_decode($villas['room_structure'], true);
      $villas['house_number'] = empty( $villas['house_number'] ) ? array( 'floor' => '', 'unit' => '' ) : json_decode($villas['house_number'], true);
      $villas['tag'] = empty( $villas['tag'] ) ? array() : json_decode($villas['tag'], true);

      $villas['customer_tag'] = empty( $villas['customer_tag'] ) ? array() : json_decode($villas['customer_tag'], true);
      
      $villas['supporting'] = empty( $villas['supporting'] ) ? array() : json_decode($villas['supporting'], true);
      
      $villas['room_images'] = empty( $villas['room_images'] ) ? array() : json_decode($villas['room_images'], true);
      
      return \View::make('usercenter.villas.edit', array( 'villas' => $villas, 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags ));
    } else {
      return \Redirect::to( 'house' )->withType('villas')->withMessage( "别墅不存在" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $villas = \Villas::find($id);
    if ( $villas ) {
      $this->filterOwner($villas);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('villas/'.$id.'/edit')->withErrors($validator);
      }
      $villas = \Villas::constructHouseModel($input, $villas);
      if ( $villas->save() ) {

        // 公共信息
        $sale_common = \SaleCommon::where( array( 'foreign_id' => $villas->id, 'type' => 'villas' ) )->first();
        if ( $sale_common ) {
          \SaleCommon::constructHouseModel($input, $sale_common);
        } else {
          $input['foreign_id'] = $villas->id;
          $input['type'] = 'villas';
          \SaleCommon::constructHouseModel($input);
        }

        return \Redirect::to( 'house' );
      } else {
        return \Redirect::to('villas/'.$id.'/edit')->withMessage( '发布失败' );
      }
    } else {
      return \Redirect::to( 'house' )->withMessage( "二手房不存在" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $villas = \Villas::find($id);
    if ( $villas ) {
      $this->filterOwner($villas);
      
      // 删除公共信息
      \SaleCommon::where( array( 'foreign_id' => $villas->id, 'type' => 'villas' ) )->delete();

      if ( $villas->delete() ) {
        // 更新用户信息
        if ($this->user->publish_num > 0) {
          $this->user->publish_num--;
        } else {
          $this->user->publish_num = 0;
        }
        $this->user->save();

        return \Redirect::to( 'house' );
      } else {
        return \Redirect::to( 'house' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'house' )->withMessage( "别墅不存在" );
    }
  }
}