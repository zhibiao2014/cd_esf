<?php
class JobPost extends CustomerModel {
  protected $table = 'job_post';
  protected $fillable = array(
    'title'
    ,'job_type'
    , 'people_num'
    , 'education'
    , 'work_time'
    , 'salary'
    , 'position_type'
    , 'content'
    , 'contact_people'
    , 'tel_number'
    , 'email'
    , 'address'
    , 'accept_intern'
    , 'welfare'
    , 'customer_tag'
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
    if (isset( $conditions['welfare'] ) && !empty($conditions['welfare']) ) {
      $model = $model->where( 'welfare', 'like', '%"' . $conditions['welfare'] . '"%' );
    }

    // 薪资
    if (isset( $conditions['salary'] ) && !empty($conditions['salary']) ) {
      $model = $model->where( 'salary', $conditions['salary'] );
    }

    // 学历
    if (isset( $conditions['education'] ) && !empty($conditions['education']) ) {
      $model = $model->where( 'education', $conditions['education'] );
    }

    // 工作经验
    if (isset( $conditions['work_times'] ) && !empty($conditions['work_times']) ) {
      $model = $model->whereIn( 'work_time', array( 0, $conditions['work_times'] ) );
    }

    // 发布时间
    if (isset( $conditions['days'] ) && !empty($conditions['days']) ) {
      $model = $model->whereRaw( ' DATEDIFF( "' . date( 'Y-m-d H:i:s' ) . '" , `created_at` ) < ' . $conditions['days'] );
    }

    return $model;
  }

}
