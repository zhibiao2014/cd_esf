<?php
class JobApply extends CustomerModel {
  protected $table = 'job_apply';
  protected $fillable = array(
    'title'
    ,'job_type'
    , 'money'
    , 'name'
    , 'sex'
    , 'birthday'
    , 'education'
    , 'birth_place'
    , 'email'
    , 'phone_number'
    , 'living_place'
    , 'work_place'
    , 'self_introduce'
    , 'work_time'
    );

  static public function constructModel( $input, $temp = null ) {
    $model = empty( $temp ) ? new self() : $temp;
    if ( empty($temp) ) {
      $user = \Auth::user();
      $model->member_id = $user->id;
    } else {
      if ($model->status != 1) {
        $model->status = 2;
      }
    }
    $model->fill( $input );
    return $model;
  }

  static public function search( $conditions = array() ) {
    $model = new self();
    // 关键词
    if (isset( $conditions['keyword'] ) && !empty($conditions['keyword']) ) {
      $model = $model->where( 'title', 'like', '%'.$conditions['keyword'].'%' );
    }
    // 职位
    if (isset( $conditions['job_type'] ) && !empty($conditions['job_type']) ) {
      $model = $model->where( 'job_type', $conditions['job_type'] );
    }
    // 区域
    if (isset( $conditions['region'] ) && !empty($conditions['region']) ) {
      $model = $model->where( 'region', $conditions['region'] );
    }
    // 福利
    if (isset( $conditions['work_place'] ) && !empty($conditions['work_place']) ) {
      $model = $model->where( 'work_place', 'like', '%' . $conditions['work_place'] . '%' );
    }
    // 薪资
    if (isset( $conditions['salary'] ) && !empty($conditions['salary']) ) {
      $model = $model->where( 'money', $conditions['salary'] );
    }
    // 学历
    if (isset( $conditions['education'] ) && !empty($conditions['education']) ) {
      $model = $model->where( 'education', $conditions['education'] );
    }
    // 工作经验
    if (isset( $conditions['work_times'] ) && !empty($conditions['work_times']) ) {
      $model = $model->where( 'work_time', '>=' , $conditions['work_times'] );
    }
    // 发布时间
    if (isset( $conditions['days'] ) && !empty($conditions['days']) ) {
      $model = $model->whereRaw( ' DATEDIFF( "' . date( 'Y-m-d H:i:s' ) . '" , `created_at` ) < ' . $conditions['days'] );
    }
    return $model;
  }
}
