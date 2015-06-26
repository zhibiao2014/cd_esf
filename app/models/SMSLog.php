<?php
class SMSLog extends CustomerModel {

  protected $table = 'mbcodelog';
  protected $connection = 'cdfdc';
  protected $fillable = array('mobile', 'mcode', 'addtime');
  
  public $timestamps = false;
  
}
