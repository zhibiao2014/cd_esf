<?php
namespace usercenter;

use BaseController;
use View;

class HomeController extends BaseController {

  public function __construct() {
    $this->user = \Auth::user();
  }

  public function index() {
    return \View::make("hello")->withUser($this->user);
  }

  public function refresh() {
    if ( \Request::ajax() ) {
      if ( ! \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->last_refresh_date)) ) ) {
        $this->user->refresh_time = 0;
      }
      if ( $this->user->allow_refresh_time <= $this->user->refresh_time ) {
        return \Response::json( array( 'error_code' => 1, 'message' => '你今天的刷新次数已用完，明天再来吧！' ) , 200 );
      }
      $model = \Input::get('model');
      $model = new $model();
      $data = $model->find( \Input::get('id') );
      if ( $data && $data->member_id == $this->user->id ) {
        $data->refresh_at = date("Y-m-d H:i:s");
        $data->save();
        // 更新用户信息
        $this->user->refresh_time += 1;
        $this->user->last_refresh_date = date("Y-m-d H:i:s");
        $this->user->save();
        return \Response::json( array( 'error_code' => 0, 'message' => '刷新成功， 你今天还有' . ($this->user->allow_refresh_time - $this->user->refresh_time) . '次刷新机会' ) , 200 );
      } else {
        return \Response::json( array( 'error_code' => 1, 'message' => '刷新失败，请确认该数据存在并且属于你' ) , 200 );
      }
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }

  public function rent_refresh() {
    if ( \Request::ajax() ) {
      if ( ! \lib\Tool::isToday( date("Y-m-d" , strtotime($this->user->rent_last_refresh_date)) ) ) {
        $this->user->rent_refresh_time = 0;
      }
      if ( $this->user->rent_allow_refresh_time <= $this->user->rent_refresh_time ) {
        return \Response::json( array( 'error_code' => 1, 'message' => '你今天的刷新次数已用完，明天再来吧！' ) , 200 );
      }
      $model = \Input::get('model');
      $model = new $model();
      $data = $model->find( \Input::get('id') );
      if ( $data && $data->member_id == $this->user->id ) {
        $data->refresh_at = date("Y-m-d H:i:s");
        $data->save();
        // 更新用户信息
        $this->user->rent_refresh_time += 1;
        $this->user->rent_last_refresh_date = date("Y-m-d H:i:s");
        $this->user->save();
        return \Response::json( array( 'error_code' => 0, 'message' => '刷新成功， 你今天还有' . ($this->user->rent_allow_refresh_time - $this->user->rent_refresh_time) . '次刷新机会' ) , 200 );
      } else {
        return \Response::json( array( 'error_code' => 1, 'message' => '刷新失败，请确认该数据存在并且属于你' ) , 200 );
      }
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }


}
