<?php
namespace usercenter;

class RentShopController extends \BaseController {

  private $rules = array(
    'contacts' => 'required'
    , 'phone' => 'required|digits:11'
    , 'community_name' => 'required'
    , 'area_id' => 'required:integer'
    , 'shop_status' => 'required|numeric'
    , 'construction_area' => 'required|numeric|min:1'
    , 'price' => 'required|numeric|min:1'
    , 'pay_method_id' => 'required'
    , 'type_id' => 'required'
    , 'shop_face_type_id' => 'required'
    , 'decoration_id' => 'required'
    , 'title' => 'required'
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
    , 'shop_status.required' => '当前状态必选'
    , 'shop_status.numeric' => '当前状态必须为数字'
    , 'pay_method_id.required' => '支付方式必选'
    , 'price.required' => '价格必填'
    , 'price.numeric' => '价格必须为数字'
    , 'type_id.required' => '商铺类型必选'
    , 'decoration_id.required' => '装修程度必选'
    , 'shop_face_type_id.required' => '铺面类型必选'
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
    $this->beforeFilter( '@filterRentPublish', array('only' => array('create', 'store')) );
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    return \Redirect::to( 'rent' )->withType('rent_shop');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    // 城区
    $areas = \Area::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    $areas = \lib\Tool::array_key_translate($areas);
    // 装修
    $decorations = \Decoration::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 房屋配套
    $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 特色标签
    $tags = \Tag::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 租赁方式
    $rent_methods = \RentMethod::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 支付方式
    $pay_methods = \PayMethod::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 类型
    $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
    // 可经营类别
    $shop_manager_types = \ShopManagerType::orderBy('sort')->orderBy('id')->get()->toArray();
    // 铺面类型
    $shop_face_types = \ShopFaceType::orderBy('sort')->orderBy('id')->get()->toArray();

    return \View::make('usercenter.rent_shop.create', array( 'areas' => $areas, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'pay_methods' => $pay_methods, 'rent_methods' => $rent_methods, 'types' =>$types, 'shop_manager_types' => $shop_manager_types, 'shop_face_types' => $shop_face_types ));
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
      return \Redirect::to('rent_shop/create')->withErrors($validator)->withInput(\Input::all());
    }
    $shop = \RentShop::constructHouseModel($input);
    if ( $shop->save() ) {

      /* 更新房源公共表 */
        $input['foreign_id'] = $shop->id;
        $input['type'] = 'shop';
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
      return \Redirect::to('rent_shop/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $rent_shop = \RentShop::find($id)->toArray();
    if ( $rent_shop ) {
      $this->filterOwner($rent_shop);
      // 城区
      $areas = \Area::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      $areas = \lib\Tool::array_key_translate($areas);
      // 装修
      $decorations = \Decoration::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 房屋配套
      $house_supportings = \HouseSupporting::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 特色标签
      $tags = \Tag::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 租赁方式
      $rent_methods = \RentMethod::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 支付方式
      $pay_methods = \PayMethod::whereIn('belong', array( 0, 3 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 类型
      $types = \Type::whereIn('belong', array( 0, 4 ))->orderBy('sort')->orderBy('id')->get()->toArray();
      // 可经营类别
      $shop_manager_types = \ShopManagerType::orderBy('sort')->orderBy('id')->get()->toArray();
      // 铺面类型
      $shop_face_types = \ShopFaceType::orderBy('sort')->orderBy('id')->get()->toArray();


      $rent_shop['tag'] = empty( $rent_shop['tag'] ) ? array() : json_decode($rent_shop['tag'], true);

      $rent_shop['customer_tag'] = empty( $rent_shop['customer_tag'] ) ? array() : json_decode($rent_shop['customer_tag'], true);
      $rent_shop['supporting'] = empty( $rent_shop['supporting'] ) ? array() : json_decode($rent_shop['supporting'], true);
      $rent_shop['room_images'] = empty( $rent_shop['room_images'] ) ? array() : json_decode($rent_shop['room_images'], true);
      $rent_shop['shop_manager_type'] = empty($rent_shop['shop_manager_type']) ? array() : json_decode($rent_shop['shop_manager_type'], true);

      return \View::make('usercenter.rent_shop.edit', array( 'rent_shop' => $rent_shop, 'areas' => $areas, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags, 'pay_methods' => $pay_methods, 'rent_methods' => $rent_methods, 'types' =>$types, 'shop_manager_types' => $shop_manager_types, 'shop_face_types' => $shop_face_types ));
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
    $rent_shop = \RentShop::find($id);
    if ( $rent_shop ) {
      $this->filterOwner($rent_shop);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('rent_shop/' . $id . '/edit')->withErrors($validator)->withInput(\Input::all());
      }
      $rent_shop = \RentShop::constructHouseModel($input, $rent_shop);
      if ( $rent_shop->save() ) {
        /* 更新房源公共表 */
        $sale_common = \RentCommon::where( array( 'foreign_id' => $rent_shop->id, 'type' => 'shop' ) )->first();
        if ( $sale_common ) {
          \RentCommon::constructHouseModel($input, $sale_common);
        } else {
          $input['foreign_id'] = $rent_shop->id;
          $input['type'] = 'shop';
          \RentCommon::constructHouseModel($input);
        }
        /* 更新房源公共表 END */
        return \Redirect::to( 'rent' );
      } else {
        return \Redirect::to('rent_shop/' . $id . '/edit')->withMessage( '发布失败' );
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
    $rent_shop = \RentShop::find($id);
    if ( $rent_shop ) {
      $this->filterOwner($rent_shop);
      \RentCommon::where( array( 'foreign_id' => $rent_shop->id, 'type' => 'shop' ) )->delete();
      if ( $rent_shop->delete() ) {
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



