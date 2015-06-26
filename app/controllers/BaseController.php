<?php

class BaseController extends Controller {

  protected $user;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout() {
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

  /**
   * Filter the is accessible.
   */
  public function filterAccess($route, $request) {
    $controller = substr( $route->getActionName(), 0, strpos($route->getActionName(), '@') );
    $action = substr($route->getActionName(), (strpos($route->getActionName(), '@') + 1));
    $access = $this->access;
    /*\Session::put( 'controller', $controller );
    \Session::put( 'action', $action );
    \Session::put( 'access', $access );*/
    switch ($this->user->level) {
      case 1:
      if ( in_array($action, $access['individual']) ) {
        return ;
      } else {
        echo \View::make( 'usercenter.common.access_notice' )->withUser($this->user);
        exit();
      }
      break;
      case 7:
      if ( in_array($action, $access['broker']) ) {
        return ;
      } else {
        echo \View::make( 'usercenter.common.access_notice' )->withUser($this->user);
        exit();
      }
      break;
      case 2:
      if ( in_array($action, $access['company']) ) {
        return ;
      } else {
        echo \View::make( 'usercenter.common.access_notice' )->withUser($this->user);
        exit();
      }
      default:
      echo \View::make( 'usercenter.common.access_notice' )->withUser($this->user);
      exit();
      break;
    }
  }

  /**
   * Filter the project owner.
   */
  public function filterOwner( $model ) {
    if ( $this->user->id != $model['member_id'] ) {
      echo \View::make( 'usercenter.common.owner_notice' )->withUser($this->user);
      exit();
    }
  }

  /**
   * Filter the publish limit.
   */
  public function filterPublish($route, $request) {
    if ( $this->user->publish_num >= $this->user->allow_publish_num ) {
      return \View::make( 'usercenter.common.publish_notice' )->withUser($this->user);
    }
  }

  /**
   * Filter the rent publish limit.
   */
  public function filterRentPublish($route, $request) {
    if ( $this->user->rent_publish_num >= $this->user->rent_allow_publish_num ) {
      return \View::make( 'usercenter.common.publish_notice' )->withUser($this->user);
    }
  }

  /**
   * Filter the rent publish limit.
   */
  public function filterWannaPublish($route, $request) {
    if ( $this->user->wanna_publish_num >= $this->user->wanna_allow_publish_num ) {
      return \View::make( 'usercenter.common.publish_notice' )->withUser($this->user);
    }
  }

}
