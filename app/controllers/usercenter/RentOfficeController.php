<?php
namespace usercenter;

class RentOfficeController extends \BaseController {

  private $rules = array(
    'contacts' => 'required'
    , 'phone' => 'required|digits:11'
    , 'community_name' => 'required'
    , 'area_id' => 'required:integer'
    , 'address' => 'required'
    , 'rent_method_id' => 'required'
    , 'pay_method_id' => 'required'
    , 'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'floor' => 'required'
    , 'title' => 'required'
    , 'type_id' => 'required'
    , 'valid_code' => 'valid_code'
    );
  private $messages = array( 
    'contacts.required' => '联系人必填'
    , 'phone.required' => '手机号码必填'
    , 'phone.digits' => '手机号码必须为11位纯数字'
    , 'community_name.required' => '楼盘名称是必填项'
    , 'area_id.required' => '城区必选区域'
    , 'area_id.integer' => '城区格式不正确'
    , 'address.required' => '地址是必填项'
    , 'rent_method_id.required' => '租赁方式是必选项'
    , 'pay_method_id.required' => '租赁方式是必选项'
    , 'construction_area.required' => '建筑面积是必填项'
    , 'construction_area.numeric' => '建筑面积必须为数字'
    , 'price.required' => '价格是必填项'
    , 'price.numeric' => '价格必须为数字'
    , 'floor.required' => '楼层是必填项'
    , 'title.required' => '房源标题是必填项'
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
    $this->beforeFilter( '@filterRentPublish', array('only' => array('create', 'store')) );
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    return \Redirect::to( 'rent' )->withType('rent_office');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    // 城区
    $areas = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $areas = \lib\Tool::array_key_translate($areas);
    // 装修
    $decorations = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 房屋配套
    $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 特色标签
    $tags = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 租赁方式
    $rent_methods = \RentMethod::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 支付方式
    $pay_methods = \PayMethod::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();

    return \View::make('usercenter.rent_office.create', array( 'areas' => $areas, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'pay_methods' => $pay_methods, 'rent_methods' => $rent_methods, 'types' => $types ));
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
      return \Redirect::to('rent_office/create')->withErrors($validator)->withInput(\Input::all());
    }
    $office = \RentOffice::constructHouseModel($input);
    if ( $office->save() ) {

      /* 更新房源公共表 */
        $input['foreign_id'] = $office->id;
        $input['type'] = 'office';
        \RentCommon::constructHouseModel($input);
      /* 更新房源公共表 END */

      // 更新用户信息
      if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->rent_last_refresh_date)) ) ) {
        $this->user->rent_refresh_time += 1;
      } else {
        $this->user->rent_refresh_time = 1;
      }
      $this->user->rent_publish_num += 1;
      $this->user->rent_last_refresh_date = date("Y-m-d H:i:s");
      $this->user->save();

      return \Redirect::to( 'rent' );
    } else {
      return \Redirect::to('rent_office/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $rent_office = \RentOffice::find($id)->toArray();
    if ( $rent_office ) {
      $this->filterOwner($rent_office);
      // 城区
      $areas = \Area::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $areas = \lib\Tool::array_key_translate($areas);
      // 装修
      $decorations = \Decoration::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 房屋配套
      $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 特色标签
      $tags = \Tag::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 租赁方式
      $rent_methods = \RentMethod::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 支付方式
      $pay_methods = \PayMethod::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 类型
      $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();

      $rent_office['floor'] = json_decode($rent_office['floor'], true);

      $rent_office['house_number'] = empty( $rent_office['house_number'] ) ? array('floor' => '', 'unit' => '', 'room' => '' ) : json_decode($rent_office['house_number'], true);

      $rent_office['tag'] = empty( $rent_office['tag'] ) ? array() : json_decode($rent_office['tag'], true);

      $rent_office['customer_tag'] = empty( $rent_office['customer_tag'] ) ? array() : json_decode($rent_office['customer_tag'], true);
      $rent_office['supporting'] = empty( $rent_office['supporting'] ) ? array() : json_decode($rent_office['supporting'], true);
      $rent_office['room_images'] = empty( $rent_office['room_images'] ) ? array() : json_decode($rent_office['room_images'], true);
      
      return \View::make('usercenter.rent_office.edit', array( 'rent_office' => $rent_office, 'areas' => $areas, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'pay_methods' => $pay_methods, 'rent_methods' => $rent_methods, 'types' => $types ));
    } else {
      return \Redirect::to( 'rent' )->withMessage( "数据不存在" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $rent_office = \RentOffice::find($id);
    if ( $rent_office ) {
      $this->filterOwner($rent_office);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('rent_office/' . $id . '/edit')->withErrors($validator)->withInput(\Input::all());
      }
      $rent_office = \RentOffice::constructHouseModel($input, $rent_office);
      if ( $rent_office->save() ) {
        /* 更新房源公共表 */
        $sale_common = \RentCommon::where( array( 'foreign_id' => $rent_office->id, 'type' => 'office' ) )->first();
        if ( $sale_common ) {
          \RentCommon::constructHouseModel($input, $sale_common);
        } else {
          $input['foreign_id'] = $rent_office->id;
          $input['type'] = 'office';
          \RentCommon::constructHouseModel($input);
        }
        /* 更新房源公共表 END */
        return \Redirect::to( 'rent' );
      } else {
        return \Redirect::to('rent_office/' . $id . '/edit')->withMessage( '发布失败' );
      }
    } else {
      exit();
      return \Redirect::to( 'rent' )->withMessage( "数据不存在" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $rent_office = \RentOffice::find($id);
    if ( $rent_office ) {
      $this->filterOwner($rent_office);
      \RentCommon::where( array( 'foreign_id' => $rent_office->id, 'type' => 'office' ) )->delete();
      if ( $rent_office->delete() ) {

        // 更新用户信息
        if ($this->user->rent_publish_num > 0) {
          $this->user->rent_publish_num--;
        } else {
          $this->user->rent_publish_num = 0;
        }
        $this->user->save();

        return \Redirect::to( 'rent' );
      } else {
        return \Redirect::to( 'rent' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'rent' )->withMessage( "写字楼不存在" );
    }
  }
}



