<?php
class CustomerModel extends Eloquent {

  public function setConnect( $connect ) {
    $this->connection = $connect;
  }

  public function setTable( $table ) {
    $this->table = $table;
  }

  /*public function getCreatedAtAttribute($date) {
    return $this->getUserDate($date);
  }

  public function getUpdatedAtAttribute($date) {
    return $this->getUserDate($date);
  }

  protected function getUserTimezone() {
    $user = Auth::user();
    return ( $user && !empty($user->timezone) ) ? $user->timezone : Config::get('app.timezone', 'UTC');
  }

  protected function getUserDate($date) {
    $timezone = $this->getUserTimezone();
    $timestamp = strtotime($date);
    date_default_timezone_set( $timezone );
    $user_date = date('Y-m-d H:i:s', $timestamp);
    date_default_timezone_set( Config::get('app.timezone', 'UTC') );
    return $user_date;
  }*/
  public static function sort_created_at( $a, $b ) {
    if ($a->created_at == $b->created_at) {
      return 0;
    }
    return ($a->created_at < $b->created_at) ? -1 : 1;
  }

  public static function sort_refresh_at( $a, $b ) {
    if ($a->refresh_at == $b->refresh_at) {
      return 0;
    }
    return ($a->refresh_at > $b->refresh_at) ? -1 : 1;
  }

  public static function sort_updated_at( $a, $b ) {
    if ($a->updated_at == $b->updated_at) {
      return 0;
    }
    return ($a->updated_at < $b->updated_at) ? -1 : 1;
  }

  public static function set_user_info( $model ) {
    $user = \Auth::user();
    $model->member_id = $user->id;
    switch ($user->level) {
      case 1:
      $model->is_individual = 1;
      break;
      case 2:
      $model->is_broker = 1;
      break;
      case 7:
      $model->is_broker = 1;
      break;
    }
    return $model;
  }
}