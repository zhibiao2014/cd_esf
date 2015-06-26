<?php
namespace api;

use BaseController;
use Session;

class SMSController extends BaseController {

  public function __construct() {
    $this->user = \Auth::user();
  }

  public function send() {
    if ( \Request::ajax() ) {
      $mobile = \Input::get('temp_mobile');
      if (empty($mobile) || !preg_match('@^1[0-9]{10}$@', $mobile)) {
        return \Response::json(array(false, '手机号码不正确！'));
      }

      if ( Session::get('temp_mcode_time') && time() < Session::get('temp_mcode_time') + 60) {
        return \Response::json(array(false, '短信发送太快，请稍后再发！'));
      }

      Session::put('temp_mobile', $mobile);
      Session::put('temp_mcode', rand(100000,999999));
      Session::put('temp_mcode_time', time());
      $msg = "您本次的验证码是：" . Session::get('temp_mcode') . " 非本人操作，可不用理会【0736fdc】";
      $smslog = new \SMSLog();
      $smslog->fill(array('mobile' => $mobile, 'mcode' => $msg, 'addtime' => date('Y-m-d H:i:s')))->save();
      \lib\SMS::send($mobile, $msg);
      return \Response::json(array(true, array( 'code' => Session::get('temp_mcode'), 'time' => 90 ) ));
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }
}
