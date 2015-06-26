<?php
namespace usercenter;

class WorkExperienceController extends \BaseController {
  private $rules = array(
    'corporation_name' => 'required'
    , 'job_type' => 'required|numeric|min:1'
    , 'salary' => 'required|numeric|min:1'
    , 'entry_date' => 'required'
    , 'leaving_date' => 'required'
    , 'content' => 'required'
    );
  private $messages = array(
    'corporation_name.required' => '公司名称必填'
    , 'job_type.required' => '职业类别必选'
    , 'job_type.numeric' => '职业类别格式不正确'
    , 'job_type.min' => '职业类别格式不正确'
    , 'salary.required' => '薪资必填'
    , 'salary.numeric' => '薪资必填格式不正确'
    , 'salary.min' => '薪资必填格式不正确'
    , 'entry_date.required' => '在职时间必填'
    , 'leaving_date.required' => '在职时间必填'
    , 'content.required' => '工作内容必填'

    );

  protected $access = array(
    'individual' => array('index', 'create', 'store', 'edit', 'update', 'destroy'),
    'broker' => array('index', 'create', 'store', 'edit', 'update', 'destroy'),
    'company' => array()
    );

  public function __construct() {
    $this->user = \Auth::user();
    $this->beforeFilter('@filterAccess');
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $work_experiences = \WorkExperience::where(array( 'member_id' => $this->user->id ))->get();
    return \View::make( 'usercenter.work_experience.index', array( 'work_experiences' => $work_experiences ) );
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
      return \Redirect::to('jobs/' . $input['job_apply_id'])->with( 'work_errors', $validator )->withInput(\Input::all());
    }
    $model = \WorkExperience::constructModel($input);
    if ( $model->save() ) {
      return \Redirect::to( 'jobs/' . $input['job_apply_id'] );
    } else {
      return \Redirect::to('jobs/' . $input['job_apply_id'])->withMessage( '发布失败' )->withInput(\Input::all());
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
