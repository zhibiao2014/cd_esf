<?php
namespace front;

class CommunityController extends \BaseController {

  /* 二手房首页 */
  public function index() {
    return \View::make( 'esf.community.index' )->withRoute('community');;
  }
  public function show( $id ) {
    return \View::make('error.notice')->withRoute('community');
  }
}