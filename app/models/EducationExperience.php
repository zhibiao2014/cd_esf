<?php
class EducationExperience extends CustomerModel {
  protected $table = 'education_experience';
  protected $fillable = array(
    'school_name'
    , 'major'
    , 'entry_date'
    , 'leaving_date'
    , 'job_apply_id'
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

}
