<?php
namespace usercenter;

class OfficeController extends \BaseController {
  private $rules = array(
    'contacts' => 'required'
    , 'phone' => 'required|digits:11'
    , 'community_name' => 'required'
    , 'area_id' => 'required:integer'
    , 'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'floor' => 'required'
    , 'title' => 'required'
    , 'type_id' => 'required'
    , 'validity' => 'required|integer'
    , 'valid_code' => 'valid_code'
    );
  private $messages = array(
    'contacts.required' => '联系人必填'
    , 'phone.required' => '手机号码必填'
    , 'phone.digits' => '手机号码必须为11位纯数字'
    , 'community_name.required' => '楼盘名称必填'
    , 'area_id.required' => '城区必选区域'
    , 'area_id.integer' => '城区格式不正确'
    , 'validity.required' => '有效期必选区域'
    , 'validity.integer' => '有效期格式不正确'
    , 'construction_area.required' => '建筑面积必填'
    , 'construction_area.numeric' => '建筑面积必须为数字'
    , 'price.required' => '价格必填'
    , 'price.numeric' => '价格必须为数字'
    , 'floor.required' => '楼层必填'
    , 'title.required' => '房源标题必填'
    , 'type_id.required' => '类型必选'
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
    return \Redirect::to( 'house' )->withType('office');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 城区
    $areas = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $areas = \lib\Tool::array_key_translate($areas);
    // 朝向
    $directions = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 装修
    $decorations = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 房屋配套
    $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 特色标签
    $tags = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    
    return \View::make('usercenter.office.create', array( 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'types' =>$types ));
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
      return \Redirect::to('office/create')->withErrors($validator)->withInput(\Input::all());
    }
    $office = \Office::constructHouseModel($input);
    if ( $office->save() ) {
      /* 更新房源公共表 */
      $input['foreign_id'] = $office->id;
      $input['type'] = 'office';
      \SaleCommon::constructHouseModel($input);
      /* 更新房源公共表 END */

      // 更新用户信息
      if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->last_refresh_date)) ) ) {
        $this->user->refresh_time += 1;
      } else {
        $this->user->refresh_time = 1;
      }
      $this->user->publish_num += 1;
      $this->user->last_refresh_date = date("Y-m-d H:i:s");
      $this->user->save();

      return \Redirect::to( 'house' )->withType('office');
    } else {
      return \Redirect::to('office/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $office = \Office::find($id)->toArray();
    // if ( $office && $office['member_id'] == $this->user->id ) {
    if ( $office ) {
      $this->filterOwner($office);
      // 类型
      $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 城区
      $areas = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $areas = \lib\Tool::array_key_translate($areas);
      // 朝向
      $directions = \Direction::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 装修
      $decorations = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 房屋配套
      $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 特色标签
      $tags = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();

      $office['floor'] = json_decode($office['floor'], true);
      $office['house_number'] = empty( $office['house_number'] ) ? array( 'floor' => '', 'unit' => '' ) : json_decode($office['house_number'], true);
      $office['tag'] = empty( $office['tag'] ) ? array() : json_decode($office['tag'], true);
      $office['customer_tag'] = empty( $office['customer_tag'] ) ? array() : json_decode($office['customer_tag'], true);
      $office['supporting'] = empty( $office['supporting'] ) ? array() : json_decode($office['supporting'], true);

      $office['room_images'] = empty( $office['room_images'] ) ? array() : json_decode($office['room_images'], true);
      
      return \View::make('usercenter.office.edit', array( 'office' => $office, 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'types' =>$types ));
    } else {
      return \Redirect::to( 'house' )->withType('office')->withMessage( "写字楼不存在" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $office = \Office::find($id);
    // if ( $office && $office['member_id'] == $this->user->id ) {
    if ( $office ) {
      $this->filterOwner($office);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('office/' . $id . '/edit')->withErrors($validator);
      }
      $office = \Office::constructHouseModel($input, $office);
      if ( $office->save() ) {

        /* 更新房源公共表 */
        $sale_common = \SaleCommon::where( array( 'foreign_id' => $office->id, 'type' => 'office' ) )->first();
        if ( $sale_common ) {
          \SaleCommon::constructHouseModel($input, $sale_common);
        } else {
          $input['foreign_id'] = $office->id;
          $input['type'] = 'office';
          \SaleCommon::constructHouseModel($input);
        }
        /* 更新房源公共表 END */

        return \Redirect::to( 'house' );
      } else {
        return \Redirect::to('office/' . $id . '/edit')->withMessage( '发布失败' );
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
    $office = \Office::find($id);
    if ( $office ) {
      $this->filterOwner($office);
      // 删除公共房源表信息
      \SaleCommon::where( array( 'foreign_id' => $office->id, 'type' => 'office' ) )->delete();
      // 删除公共房源表信息
      if ( $office->delete() ) {
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
      return \Redirect::to( 'house' )->withMessage( "写字楼不存在" );
    }
  }
}
