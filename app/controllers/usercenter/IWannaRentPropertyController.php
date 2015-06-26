<?php
namespace usercenter;

class IWannaRentPropertyController extends \BaseController {
  private $rules = array(
    'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'title' => 'required'
    , 'room_structure' => 'required'
    , 'rent_method_id' => 'required'
    );
  private $messages = array(
    'construction_area.required' => '意向面积必填'
    , 'construction_area.numeric' => '意向面积必须为数字'
    , 'price.required' => '期望租金必填'
    , 'price.numeric' => '期望租金必须为数字'
    , 'title.required' => '标题必填'
    , 'title.room_structure' => '期望户型必填'
    , 'title.rent_method_id' => '租赁方式必填'
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
    $this->beforeFilter('@filterAccess');
    // $this->beforeFilter( '@filterPublish', array('only' => array('create', 'store')) );
  }
  
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $status = \Input::get('status', false) ? intval(\Input::get('status')) : 1;
    $iwannas = \IWannaRentProperty::where(array( 'status' => $status, 'member_id' => $this->user->id ))->get();
    
    return \View::make( 'usercenter.i_wanna_rent_property.index', array( 'iwannas' => $iwannas ) );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    $model = \Input::get('model', 1); 
    $params = array();
    // 城区
    $params['areas'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['areas'] = \lib\Tool::array_key_translate($params['areas']);
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 租赁方式
    $params['rent_methods'] = \RentMethod::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    
    return \View::make('usercenter.i_wanna_rent_property.create', $params);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = \Input::get('info'); 
    if ( $input['type'] == 1 ) {
      $this->rules = array_merge($this->rules, array( 
        'area_id' => 'required:integer'
        ) );
      $this->messages = array_merge($this->messages, array( 
        'area_id.required' => '城区必选区域'
        , 'area_id.integer' => '城区格式不正确'
        ) );
    }
    $validator = \Validator::make($input, $this->rules, $this->messages);
    if ($validator->fails()) {
      return \Redirect::to($view)->withErrors($validator)->withInput(\Input::all());
    }
    $i_wanna_rent_property = \IWannaRentProperty::constructModel($input);
    if ( $i_wanna_rent_property->save() ) {
      return \Redirect::to( 'i_wanna_rent_property' );
    } else {
      return \Redirect::to($view)->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $i_wanna_rent_property = \IWannaRentProperty::find($id)->toArray();
    if ( $i_wanna_rent_property ) {
      $this->filterOwner($i_wanna_rent_property);
      $params = array();
      $i_wanna_rent_property['supporting'] = empty($i_wanna_rent_property['supporting']) ? array() : json_decode($i_wanna_rent_property['supporting'], true);
      
      $i_wanna_rent_property['room_structure'] = empty($i_wanna_rent_property['room_structure']) ? array() : json_decode($i_wanna_rent_property['room_structure'], true);

      $i_wanna_rent_property['community'] = empty($i_wanna_rent_property['community']) ? array('', '', '') : json_decode($i_wanna_rent_property['community'], true);
      // 城区
      $params['areas'] = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $params['areas'] = \lib\Tool::array_key_translate($params['areas']);
      // 房屋配套
      $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 租赁方式
      $params['rent_methods'] = \RentMethod::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();

      $params['i_wanna_rent_property'] = $i_wanna_rent_property;
      return \View::make( 'usercenter.i_wanna_rent_property.edit' , $params);

    } else {
      return \Redirect::to( 'i_wanna_rent_property' )->withMessage( "数据不存在或未通过审核！" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $i_wanna_rent_property = \IWannaRentProperty::find($id);
    if ( $i_wanna_rent_property ) {
      $this->filterOwner($i_wanna_rent_property);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('i_wanna_rent_property/' . $id . '/edit')->withErrors($validator);
      }
      $i_wanna_rent_property = \IWannaRentProperty::constructModel($input, $i_wanna_rent_property);
      if ( $i_wanna_rent_property->save() ) {
        return \Redirect::to( 'i_wanna_rent_property' );
      } else {
        return \Redirect::to('i_wanna_rent_property/' . $id . '/edit')->withMessage( '发布失败' );
      }
    } else {
      return \Redirect::to( 'i_wanna_rent_property' )->withMessage( "内容不存在！" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $i_wanna_rent_property = \IWannaRentProperty::find($id);
    if ( $i_wanna_rent_property ) {
      $this->filterOwner($i_wanna_rent_property);
      if ( $i_wanna_rent_property->delete() ) {
        return \Redirect::to( 'i_wanna_rent_property' );
      } else {
        return \Redirect::to( 'i_wanna_rent_property' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'i_wanna_rent_property' )->withMessage( "请求信息不存在！" );
    }
  }
}
