<?php
namespace usercenter;

use BaseController;
use View;
use Validator;
use Input;
use Redirect;
use Auth;
use Config;
use Log;
use User;
use Response;
use URL;

class UserController extends BaseController {

    /**
     * Show the profile for the given user.
     */
    public function showSetting() {
        $user = Auth::user();
        return View::make('usercenter.user.setting', array('user' => $user));
    }

    /**
     * Set the profile for the given user.
     */
    public function doSetting() {
        $user = Auth::user();
        return View::make('usercenter.user.setting', array('user' => $user));
    }

    public function showLogin() {
        return Redirect::away( \Config::get('auth.sso.sign_in') . "?application=". Config::get('auth.sso.application_slug') ."&referrer=" . URL::to("/") );
        // return View::make("usercenter.user.login");
    }

    public function sso_sync_login() {
        $token = \Input::get('token');
        Log::info('login token', array('token' => $token) );
        $validate_sync_login_token = Config::get('auth.sso.validate_sync_login_token');
        $app_access_token = Config::get('auth.sso.app_access_token');
        if ( $validate_sync_login_token ) {
            $curl = new \Curl\Curl();
            $curl->post( $validate_sync_login_token , array('token' => $token, 'app_access_token' => $app_access_token ) );
            if ( $curl->error === false ) {
                $data = json_decode($curl->response, true);
                if ( $data['status'] == 'success') {
                    $user_info = $data['identity'];
                    $user = User::where( array('email' => $user_info['email']) )->first();
                    if ( empty($user) ) {
                        $user = new User();
                    }
                    $user->first_name = $user_info['first_name'];
                    $user->last_name = $user_info['last_name'];
                    $user->email = $user_info['email'];
                    $user->timezone = $user_info['time_zone'];
                    $user->avatar = 'https://id.deepdevelop.com/api/' . $user_info['avatar'];
                    $user->status = 99;
                    $user->save();
                    if ( Auth::login($user) ) {
                        if ( isset( $data['sync_login_html'] ) ) {
                            return Redirect::intended('/')->with('sync_login_html' , $data['sync_login_html'] );
                        } else {
                            return Redirect::intended('/');
                        }
                        
                    } else {
                        return Redirect::to('/');
                    }
                } else {
                    // Log::info('callback data', array('data' => $data) );
                    return Response::json( array('error message' => $data) , 200 );    
                }
            } else {
                return Response::json( array('error message' => $curl->error_message) , 200 );
                // Log::info('error message', array('error message' => $curl->error_message) );
            }
        } else {
            return Response::json( array('error message' => 'sory login' ) , 200 );
            // Log::info('callback data');
        }
    }

    public function doLogin() {
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:3'
            );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password') );
            if (Auth::attempt( $userdata , true )) {
                return Redirect::intended('/');
            } else {
                return Redirect::to('login');
            }
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::to( Config::get('auth.sso.logout') . '?referrer=' . URL::to('/') );
    }

}