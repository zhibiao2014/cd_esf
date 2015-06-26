<?php

class HouseController extends \BaseController {
  public function index() {
    $houses = \House::select('id', 'title', 'address', 'price', 'area')->get()->toArray();
    return \Response::json( $houses , 200);
  }

}
