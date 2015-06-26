<?php
namespace usercenter;

class IWannaBuyPropertyController extends \BaseController {
  private $rules = array(
    'area_id' => 'required:integer'
    , 'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'title' => 'required'
    );
  private $messages = array(
    'area_id.required' => '城区必选区域'
    , 'area_id.integer' => '城区格式不正确'
    , 'construction_area.required' => '建筑面积必填'
    , 'construction_area.numeric' => '建筑面积必须为数字'
    , 'price.required' => '价格必填'
    , 'price.numeric' => '价格必须为数字'
    , 'title.required' => '标题必填'
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
    $iwannas = \IWannaBuyProperty::where(array( 'status' => $status, 'member_id' => $this->user->id ))->get();
    // 朝向
    $directions = \Direction::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 装修
    $decorations = \Decoration::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();

    if ( !empty($directions) ) { $directions = \lib\Tool::array_key_translate($directions); }
    return \View::make( 'usercenter.i_wanna_buy_property.index', array( 'iwannas' => $iwannas, 'directions' => $directions ) );
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    $model = \Input::get('model', 1); 
    $params = array();
    switch ( $model ) {
      case 'office':
      $belong = 4;
      $view = 'usercenter.i_wanna_buy_property.create_office';
        // 类型
      $params['types'] = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
        // 额外验证信息
      $this->rules = array_merge($this->rules, array( 
        'type_id' => 'required:integer', 
        'decoration_id' => 'required:integer' 
        ) );

      $this->messages = array_merge($this->messages, array( 
        'type_id.required' => '类型必选区域',
        'type_id.integer' => '类型格式不正确',
        'decoration_id.required' => '装修程度必选',
        'decoration_id.integer' => '装修程度格式不正确'
        ) );
      break;
      case 'shop':
      $belong = 3;
      $view = 'usercenter.i_wanna_buy_property.create_shop';
        // 可经营类别
      $params['shop_manager_types'] = \ShopManagerType::orderBy('sort')->orderBy('id')->get()->toArray();
        // 类型
      $params['types'] = \Type::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
        // 额外验证信息
      $this->rules = array_merge($this->rules, array( 
        'type_id' => 'required:integer', 
        'decoration_id' => 'required:integer' 
        ) );

      $this->messages = array_merge($this->messages, array( 
        'type_id.required' => '类型必选区域',
        'type_id.integer' => '类型格式不正确',
        'decoration_id.required' => '装修程度必选',
        'decoration_id.integer' => '装修程度格式不正确'
        ) );
      break;
      default:
      $belong = 2;
      $view = 'usercenter.i_wanna_buy_property.create';
        // 额外验证信息
      $this->rules = array_merge($this->rules, array( 
        'room_structure' => 'required', 
        ) );

      $this->messages = array_merge($this->messages, array( 
        'room_structure.required' => '户型必填'
        ) );
      break;
    }
    // 城区
    $params['areas'] = \Area::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $params['areas'] = \lib\Tool::array_key_translate($params['areas']);
    // 朝向
    $params['directions'] = \Direction::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 装修
    $params['decorations'] = \Decoration::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 房屋配套
    $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 楼层
    $params['floors'] = \Floor::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
    return \View::make($view, $params);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = \Input::get('info'); 
    switch ( $input['type'] ) {
      case 2:
      $view = 'i_wanna_buy_property/create?model=office';
      break;
      case 3:
      $view = 'i_wanna_buy_property/create?model=shop';
      break;
      default:
      $view = 'i_wanna_buy_property/create';
      break;
    }
    $validator = \Validator::make($input, $this->rules, $this->messages);
    if ($validator->fails()) {
      return \Redirect::to($view)->withErrors($validator)->withInput(\Input::all());
    }
    $i_wanna_buy_property = \IWannaBuyProperty::constructModel($input);
    if ( $i_wanna_buy_property->save() ) {
      return \Redirect::to( 'i_wanna_buy_property' );
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
    $i_wanna_buy_property = \IWannaBuyProperty::find($id)->toArray();
    if ( $i_wanna_buy_property ) {
      $this->filterOwner($i_wanna_buy_property);
      $params = array();
      switch ( $i_wanna_buy_property['type'] ) {
        case 2:
        $belong = 4;
        $view = 'usercenter.i_wanna_buy_property.edit_office';
        // 类型
        $params['types'] = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
        // 额外验证信息
        $this->rules = array_merge($this->rules, array( 
          'type_id' => 'required:integer', 
          'decoration_id' => 'required:integer' 
          ) );

        $this->messages = array_merge($this->messages, array( 
          'type_id.required' => '类型必选区域',
          'type_id.integer' => '类型格式不正确',
          'decoration_id.required' => '装修程度必选',
          'decoration_id.integer' => '装修程度格式不正确'
          ) );
        break;
        case 3:
        $belong = 3;
        $view = 'usercenter.i_wanna_buy_property.edit_shop';
        // 可经营类别
        $params['shop_manager_types'] = \ShopManagerType::orderBy('sort')->orderBy('id')->get()->toArray();
        // 类型
        $params['types'] = \Type::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
        $i_wanna_buy_property['shop_manager_type'] = json_decode($i_wanna_buy_property['shop_manager_type']);
        $i_wanna_buy_property['type_id'] = json_decode($i_wanna_buy_property['type_id']);
        // 额外验证信息
        $this->rules = array_merge($this->rules, array( 
          'type_id' => 'required:integer', 
          'decoration_id' => 'required:integer' 
          ) );

        $this->messages = array_merge($this->messages, array( 
          'type_id.required' => '类型必选区域',
          'type_id.integer' => '类型格式不正确',
          'decoration_id.required' => '装修程度必选',
          'decoration_id.integer' => '装修程度格式不正确'
          ) );
        break;
        default:
        $belong = 2;
        $view = 'usercenter.i_wanna_buy_property.edit';
        // 额外验证信息
        $this->rules = array_merge($this->rules, array(
          'room_structure' => 'required', 
          ) );
        $this->messages = array_merge($this->messages, array( 
          'room_structure.required' => '户型必填'
          ) );
        $i_wanna_buy_property['room_structure'] = json_decode($i_wanna_buy_property['room_structure'], true);
        break;
      }
      $i_wanna_buy_property['supporting'] = empty($i_wanna_buy_property['supporting']) ? array() : json_decode($i_wanna_buy_property['supporting']);
      // 城区
      $params['areas'] = \Area::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $params['areas'] = \lib\Tool::array_key_translate($params['areas']);
      // 朝向
      $params['directions'] = \Direction::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 装修
      $params['decorations'] = \Decoration::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 房屋配套
      $params['house_supportings'] = \HouseSupporting::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 楼层
      $params['floors'] = \Floor::whereIn('belong', array( 0, $belong ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $params['i_wanna_buy_property'] = $i_wanna_buy_property;
      return \View::make($view, $params);

    } else {
      return \Redirect::to( 'i_wanna_buy_property' )->withMessage( "数据不存在或未通过审核！" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $i_wanna_buy_property = \IWannaBuyProperty::find($id);
    if ( $i_wanna_buy_property ) {
      $this->filterOwner($i_wanna_buy_property);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('i_wanna_buy_property/' . $id . '/edit')->withErrors($validator);
      }
      $i_wanna_buy_property = \IWannaBuyProperty::constructModel($input, $i_wanna_buy_property);
      if ( $i_wanna_buy_property->save() ) {
        return \Redirect::to( 'i_wanna_buy_property' );
      } else {
        return \Redirect::to('i_wanna_buy_property/' . $id . '/edit')->withMessage( '发布失败' );
      }
    } else {
      return \Redirect::to( 'i_wanna_buy_property' )->withMessage( "内容不存在！" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $i_wanna_buy_property = \IWannaBuyProperty::find($id);
    if ( $i_wanna_buy_property ) {
      $this->filterOwner($i_wanna_buy_property);
      if ( $i_wanna_buy_property->delete() ) {
        return \Redirect::to( 'i_wanna_buy_property' );
      } else {
        return \Redirect::to( 'i_wanna_buy_property' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'i_wanna_buy_property' )->withMessage( "请求信息不存在！" );
    }
  }
}
