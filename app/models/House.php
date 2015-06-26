<?php
class House extends CustomerModel {
  
  protected $table = 'property';
  protected $connection = 'cdfdc';
  public $timestamps = false;
  
}