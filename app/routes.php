<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::pattern('id', '[0-9]+');

/*
Route::get('login', array('as' => 'login', 'uses' => 'UserController@showLogin' ) );
Route::post('login', array('as' => 'login', 'uses' => 'UserController@doLogin' ) );
*/
Route::get('houselist', array( 'as' => 'houselist', 'uses' => 'HouseController@index' ) );

if ( Config::get('app.env', 'server') == 'local' ) {
  $usercenter_group = array( 'before' => 'auth', 'namespace' => 'usercenter' );

  $home_group = array( 'namespace' => 'front', 'prefix' => 'esf', 'before' => 'filter_tags' );

  $api_group = array( 'before' => 'auth', 'prefix' => 'api', 'namespace' => 'api' );

  $jobs_group = array( 'prefix' => 'recruit', 'namespace' => 'front' );
} else {
  $usercenter_group = array( 'before' => 'auth', 'namespace' => 'usercenter', 'domain' => 'my.0736fdc.com' );
  $home_group = array( 'namespace' => 'front', 'domain' => 'esf.0736fdc.com', 'before' => 'filter_tags' );
  $api_group = array( 'namespace' => 'api', 'domain' => 'api.0736fdc.com' );

  $jobs_group = array( 'namespace' => 'front', 'domain' => 'zp.0736fdc.com' );
}

// 会员中心路由组
Route::group( $usercenter_group , function() {

  Route::get('/',  array('as' => 'home', 'uses' => 'HomeController@index') );
  // User Routes Start
  /*
  Route::get('user', array( 'as' => 'user', 'uses' => 'UserController@showSetting' ) );
  Route::post('user/setting', array( 'as' => 'user', 'uses' => 'UserController@doSetting' ) );
  Route::get('logout', array( 'as' => 'logout', 'uses' => 'UserController@logout' ) );
  */
  // User Routes End

  Route::resource('house', 'SecondHandHousingController', array('except' => array('show')));

  Route::resource( 'villas', 'VillasController', array('except' => array('show')) );

  Route::resource( 'office', 'OfficeController', array('except' => array('show')) );

  Route::resource( 'shop', 'ShopController', array('except' => array('show')) );

  Route::resource( 'rent', 'RentController', array('except' => array('show')) );

  Route::resource( 'rent_villas', 'RentVillasController', array('except' => array('show')) );

  Route::resource( 'rent_office', 'RentOfficeController', array('except' => array('show')) );

  Route::resource( 'rent_shop', 'RentShopController', array('except' => array('show')) );

  Route::post( 'attachment', array( 'as' => 'attachment.store', 'uses' => 'AttachmentController@store' ) );

  Route::post( 'refresh', 'HomeController@refresh' );
  Route::post( 'rent_refresh', 'HomeController@rent_refresh' );

  Route::resource( 'i_wanna_buy_property', 'IWannaBuyPropertyController', array('except' => array('show')) );

  Route::resource( 'i_wanna_rent_property', 'IWannaRentPropertyController', array('except' => array('show')) );

  Route::post( 'work_experience', array( 'as' => 'work_experience.store', 'uses' => 'JobsController@store_experience' ));
  Route::get( 'delete_experience/{id}/{job_apply_id}', array( 'as' => 'work_experience.delete', 'uses' => 'JobsController@delete_experience' ));

  Route::post( 'education_experience', array( 'as' => 'education_experience.store', 'uses' => 'JobsController@store_education_experience' ));
  Route::get( 'delete_education_experience/{id}/{job_apply_id}', array( 'as' => 'education_experience.delete', 'uses' => 'JobsController@delete_education_experience' ));

  Route::resource('jobs', 'JobsController');
  Route::post( 'jobs/refresh', array( 'as' => 'jobs.refresh', 'uses' => 'JobsController@refresh' ));
  Route::post( 'jobs/set_default', array( 'as' => 'jobs.set_default', 'uses' => 'JobsController@set_default' ));
  Route::post( 'jobs/{id}/save_images', array( 'as' => 'jobs.save_images', 'uses' => 'JobsController@save_images' ));

  Route::post( 'jobs/{id}/save_tags', array( 'as' => 'jobs.save_tags', 'uses' => 'JobsController@save_tags' ));

  Route::post( 'jobs/{id}/save_content', array( 'as' => 'jobs.save_content', 'uses' => 'JobsController@save_content' ));

  Route::resource('post', 'JobPostController', array('except' => array('show')) );
  Route::get( 'post/{id}/change_status', array( 'as' => 'post.change_status', 'uses' => 'JobPostController@change_status' ));
  Route::post( 'post/refresh', array( 'as' => 'post.refresh', 'uses' => 'JobPostController@refresh' ));

});

// 二手房前台路由组
Route::group( $home_group, function() {
  // 首页
  Route::get('/', array('as' => 'esf', 'uses' => 'HomeController@index'));
  Route::get('/index', array('as' => 'esf.index', 'uses' => 'HomeController@index'));

  // 二手房出租出售
  Route::get('house/list', array('as' => 'esf.house.index', 'uses' => 'HouseController@lists') );
  Route::get('house/rent/list', array('as' => 'esf.rent.index', 'uses' => 'HouseController@rent_lists') );
  Route::get('house/show/{id}', array('as' => 'esf.house.show', 'uses' => 'HouseController@show') );
  Route::get('house/rent/show/{id}', array('as' => 'esf.rent.show', 'uses' => 'HouseController@rent_show') );

  // 商铺出租出售
  Route::get('shop/list', array('as' => 'esf.shop.index', 'uses' => 'ShopController@lists') );
  Route::get('shop/rent/list', array('as' => 'esf.shop.rent.index', 'uses' => 'ShopController@rent_lists') );
  Route::get('shop/show/{id}', array('as' => 'esf.shop.show', 'uses' => 'ShopController@show') );
  Route::get('shop/rent/show/{id}', array('as' => 'esf.rent_shop.show', 'uses' => 'ShopController@rent_show') );

  // 写字楼出租出售
  Route::get('office/list', array('as' => 'esf.office.index', 'uses' => 'OfficeController@lists') );
  Route::get('office/rent/list', array('as' => 'esf.office.rent.index', 'uses' => 'OfficeController@rent_lists') );
  Route::get('office/show/{id}', array('as' => 'esf.office.show', 'uses' => 'OfficeController@show') );
  Route::get('office/rent/show/{id}', array('as' => 'esf.rent_office.show', 'uses' => 'OfficeController@rent_show') );

  // 别墅出租出售
  Route::get('villas/list', array('as' => 'esf.villas.index', 'uses' => 'VillasController@lists') );
  Route::get('villas/rent/list', array('as' => 'esf.villas.rent.index', 'uses' => 'VillasController@rent_lists') );
  Route::get('villas/show/{id}', array('as' => 'esf.villas.show', 'uses' => 'VillasController@show') );
  Route::get('villas/rent/show/{id}', array('as' => 'esf.rent_villas.show', 'uses' => 'VillasController@rent_show') );

  // 经纪人
  Route::get('broker', array('as' => 'esf.broker.index', 'uses' => 'BrokerController@index') );
  Route::get('broker/show/{id}', array('as' => 'esf.broker.show', 'uses' => 'BrokerController@show') );
  Route::get('broker/sale_show/{id}', array('as' => 'esf.broker.sale_show', 'uses' => 'BrokerController@sale_show') );
  Route::get('broker/rent_show/{id}', array('as' => 'esf.broker.rent_show', 'uses' => 'BrokerController@rent_show') );

  // 中介公司
  Route::get('company', array('as' => 'esf.company.index', 'uses' => 'CompanyController@index') );
  Route::get('company/show/{id}', array('as' => 'esf.company.show', 'uses' => 'CompanyController@show') );

  // 小区
  Route::get('community', array('as' => 'esf.community.index', 'uses' => 'CommunityController@index') );
  Route::get('community/show/{id}', array('as' => 'esf.community.show', 'uses' => 'CommunityController@show') );

  // 求购求租
  Route::get('wanna/buy', array('as' => 'esf.wanna.buy', 'uses' => 'WannaController@buy') );
  Route::get('wanna/buy/show/{id}', array('as' => 'esf.wanna.buy.show', 'uses' => 'WannaController@buy_show') );

  Route::get('wanna/rent', array('as' => 'esf.wanna.rent', 'uses' => 'WannaController@rent') );
  Route::get('wanna/rent/show/{id}', array('as' => 'esf.wanna.rent.show', 'uses' => 'WannaController@rent_show') );

  Route::get('embed/index', 'HomeController@embed_index');
});

// 招聘前台路由
Route::group( $jobs_group, function() {
  Route::get('/', array('as' => 'recruit', 'uses' => 'RecruitController@index'));
  Route::get('resume', array('as' => 'resume', 'uses' => 'RecruitController@resume'));
  Route::get('resume/{id}', array('as' => 'resume.show', 'uses' => 'RecruitController@resume_show'));
  Route::get('resume/{id}/invite', array('as' => 'resume.invite', 'uses' => 'RecruitController@invite'));

  Route::get('post/{id}', array( 'before' => 'auth', 'as' => 'post.show', 'uses' => 'RecruitController@post_show'));
  Route::get('post/{id}/deliver', array( 'before' => 'auth', 'as' => 'post.deliver', 'uses' => 'RecruitController@deliver'));
});

// Api Routes
Route::group( array_replace($usercenter_group, array('namespace' => 'api'))  , function() {
  Route::post('sms/send', array('as' => 'api.sms.send', 'uses' => 'SMSController@send') );
  Route::get('sms/valid', array('as' => 'api.sms.valid', 'uses' => 'SMSController@valid'));
});

// Api Routes
/*Route::group( $api_group   , function() {
  Route::get( 'sms/send', array('as' => 'api.sms.send', 'uses' => 'SMSController@send') );
  Route::get( 'sms/valid', array('as' => 'api.sms.valid', 'uses' => 'SMSController@valid') );
});*/


