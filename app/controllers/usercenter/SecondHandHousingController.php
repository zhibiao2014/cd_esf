<?php
namespace usercenter;

class SecondHandHousingController extends \BaseController {
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
		, 'construction_area.min' => '建筑面积必须大于1'
		, 'price.min' => '价格必须大于1'
		, 'price.required' => '价格必填'
		, 'price.numeric' => '价格必须为数字'
		, 'floor.required' => '楼层必填'
		, 'title.required' => '房源标题必填'
		, 'valid_code.valid_code' => '验证码不匹配'
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
		$status = (\Input::get('status', false) !== false) ? intval(\Input::get('status')) : 1;
		$second_hand_housings = \DB::select('select * , "house" as type , "SecondHandHousing" as model from ' . \Config::get('database.connections.mysql.prefix') . 'second_hand_housing where status = ? and member_id = ? ' , array( $status, $this->user->id ));
		$villas = \DB::select('select * , "villas" as type , "Villas" as model from ' . \Config::get('database.connections.mysql.prefix') . 'villas where status = ? and member_id = ? ' , array( $status, $this->user->id ));
		$offices = \DB::select('select * , "office" as type , "Office" as model from ' . \Config::get('database.connections.mysql.prefix') . 'office where status = ? and member_id = ? ' , array( $status, $this->user->id ));
		$shops = \DB::select('select * , "shop" as type , "Shop" as model from ' . \Config::get('database.connections.mysql.prefix') . 'shop where status = ? and member_id = ? ' , array( $status, $this->user->id ));
		$sell = array_merge( $second_hand_housings, $villas, $offices, $shops );
		uasort( $sell, array( 'CustomerModel', 'sort_refresh_at') );
    // var_dump($sell);
		// 朝向
		$directions = \Direction::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
		if ( !empty($directions) ) { $directions = \lib\Tool::array_key_translate($directions); }
		return \View::make( 'usercenter.second_hand_housing.index', array( 'sell' => $sell, 'directions' => $directions ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		// 城区
		$areas = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
		$areas = \lib\Tool::array_key_translate($areas);
		// 朝向
		$directions = \Direction::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
		// 装修
		$decorations = \Decoration::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
		// 房屋配套
		$house_supportings = \HouseSupporting::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
		// 特色标签
		$tags = \Tag::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();

		return \View::make('usercenter.second_hand_housing.create', array( 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags ));
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
			return \Redirect::to('house/create')->withErrors($validator)->withInput(\Input::all());
		}
		$second_hand_housing = \SecondHandHousing::constructHouseModel($input);
		if ( $second_hand_housing->save() ) {
			/* 插入房源公共表 */
			$input['foreign_id'] = $second_hand_housing->id;
			$input['type'] = 'house';
			\SaleCommon::constructHouseModel($input);
			/* 插入房源公共表 END */

			// 更新用户信息
			if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->last_refresh_date)) ) ) {
				$this->user->refresh_time += 1;
			} else {
				$this->user->refresh_time = 1;
			}
			$this->user->publish_num += 1;
			$this->user->last_refresh_date = date("Y-m-d H:i:s");
			$this->user->save();

			return \Redirect::to( 'house' );
		} else {
			return \Redirect::to('house/create')->withMessage( '发布失败' )->withInput(\Input::all());
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {
		$second_hand_housing = \SecondHandHousing::find($id)->toArray();
		if ( $second_hand_housing ) {
			$this->filterOwner($second_hand_housing);
			// 城区
			$areas = \Area::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
			$areas = \lib\Tool::array_key_translate($areas);
			// 朝向
			$directions = \Direction::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
			// 装修
			$decorations = \Decoration::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
			// 房屋配套
			$house_supportings = \HouseSupporting::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
			// 特色标签
			$tags = \Tag::whereIn('belong', array( 0, 2 ))->orderBy('sort')->orderBy('id')->get()->toArray();
			$second_hand_housing['room_structure'] = json_decode($second_hand_housing['room_structure'], true);
			$second_hand_housing['floor'] = json_decode($second_hand_housing['floor'], true);
			$second_hand_housing['house_number'] = empty( $second_hand_housing['house_number'] ) ? array('floor' => '', 'unit' => '', 'room' => '' ) : json_decode($second_hand_housing['house_number'], true);
			$second_hand_housing['tag'] = empty( $second_hand_housing['tag'] ) ? array() : json_decode($second_hand_housing['tag'], true);

			$second_hand_housing['customer_tag'] = empty( $second_hand_housing['customer_tag'] ) ? array() : json_decode($second_hand_housing['customer_tag'], true);

			$second_hand_housing['supporting'] = empty( $second_hand_housing['supporting'] ) ? array() : json_decode($second_hand_housing['supporting'], true);

			$second_hand_housing['room_images'] = empty( $second_hand_housing['room_images'] ) ? array() : json_decode($second_hand_housing['room_images'], true);

			return \View::make('usercenter.second_hand_housing.edit', array( 'second_hand_housing' => $second_hand_housing, 'areas' => $areas, 'directions' => $directions, 'decorations' => $decorations, 'house_supportings' => $house_supportings, 'tags' => $tags ));
		} else {
			return \Redirect::to( 'house' )->withMessage( "二手房不存在" );
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {
		$second_hand_housing = \SecondHandHousing::find($id);
		if ( $second_hand_housing ) {
			$this->filterOwner($second_hand_housing);
			$input = \Input::get('info');
			$validator = \Validator::make($input, $this->rules, $this->messages);
			if ($validator->fails()) {
				return \Redirect::to('house/' . $id . '/edit')->withErrors($validator);
			}
			$second_hand_housing = \SecondHandHousing::constructHouseModel($input, $second_hand_housing);
			if ( $second_hand_housing->save() ) {

				/* 更新房源公共表 */
				$sale_common = \SaleCommon::where( array( 'foreign_id' => $second_hand_housing->id, 'type' => 'house' ) )->first();
				if ( $sale_common ) {
					\SaleCommon::constructHouseModel($input, $sale_common);
				} else {
					$input['foreign_id'] = $second_hand_housing->id;
					$input['type'] = 'house';
					\SaleCommon::constructHouseModel($input);
				}
				/* 更新房源公共表 END */

				return \Redirect::to( 'house' );
			} else {
				return \Redirect::to('house/' . $id . '/edit')->withMessage( '发布失败' );
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
		$second_hand_housing = \SecondHandHousing::find($id);
		if ( $second_hand_housing ) {
			$this->filterOwner($second_hand_housing);
      // 删除公共房源表信息
			\SaleCommon::where( array( 'foreign_id' => $second_hand_housing->id, 'type' => 'house' ) )->delete();
      // 删除公共房源表信息
			if ( $second_hand_housing->delete() ) {
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
			return \Redirect::to( 'house' )->withMessage( "二手房不存在" );
		}
	}
}
