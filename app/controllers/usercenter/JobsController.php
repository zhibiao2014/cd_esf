<?php
namespace usercenter;

class JobsController extends \BaseController {
  private $rules = array(
    'title' => 'required'
    , 'job_type' => 'required|integer'
    , 'money' => 'required|integer'
    , 'name' => 'required'
    , 'sex' => 'required'
    , 'birthday' => 'required|date_format:Y-m-d'
    , 'education' => 'required|integer'
    , 'birth_place' => 'required'
    , 'email' => 'required|email'
    , 'phone_number' => 'required|digits:11'
    , 'valid_code' => 'valid_code'
    , 'living_place' => 'my_place'
    , 'work_place' => 'my_place'

    );
  private $messages = array(
    'title.required' => '职位名称不能为空'
    , 'job_type.required' => '职位类别必填'
    , 'job_type.integer' => '职位类别格式不正确'
    , 'money.required' => '期待薪资必填'
    , 'money.integer' => '期待薪资格式不正确'
    , 'name.required' => '姓名不能为空'
    , 'sex.required' => '性别必选'
    , 'birthday.required' => '性别必选'
    , 'education.required' => '学历必选'
    , 'education.integer' => '学历格式不正确'
    , 'birth_place.required' => '籍贯必填'
    , 'email.required' => '邮箱必填'
    , 'email.email' => '邮箱格式不正确'
    , 'phone_number.required' => '手机号码不能为空'
    , 'phone_number.digits' => '手机号码格式不正确'
    , 'valid_code.valid_code' => '验证码不匹配'
    , 'living_place.my_place' => '现居地格式不正确'
    , 'work_place.my_place' => '现居地格式不正确'

    );

  protected $access = array(
    'individual' => array('index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'refresh', 'store_experience', 'delete_experience', 'store_education_experience', 'delete_education_experience', 'save_images', 'save_content', 'save_tags', 'set_default'),
    'broker' => array('index', 'show', 'create', 'store', 'edit', 'update', 'destroy', 'refresh', 'store_experience', 'delete_experience', 'store_education_experience', 'delete_education_experience', 'save_images', 'save_content', 'save_tags', 'set_default'),
    'company' => array()
    );

  public function __construct() {
    $this->user = \Auth::user();
    \Validator::extend('valid_code', function($attribute, $value, $parameters) {
      return $value == \Session::get('temp_mcode');
    });
    \Validator::extend('my_place', function($attribute, $value, $parameters) {
      return is_array($value) && !empty($value['province']) && !empty($value['city']) && !empty($value['area']);
    });
    $this->beforeFilter('@filterAccess');
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $status = \Input::get('status', false) ? intval(\Input::get('status')) : 1;
    $jobs = \JobApply::where(array( 'status' => $status, 'member_id' => $this->user->id ))->get();

    return \View::make( 'usercenter.jobs.index', array( 'jobs' => $jobs ) );
  }

  public function show($id) {
    $jobs = \JobApply::find($id)->toArray();
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $params = array();

      $jobs['living_place'] = explode(',', $jobs['living_place'] );
      $jobs['work_place'] = explode(',',  $jobs['work_place'] );
      $jobs['images'] = json_decode( $jobs['images'], true );
      $jobs['tags'] = json_decode( $jobs['tags'], true );

      // 工作类型
      $job_types = \JobType::orderBy('sort')->orderBy('id')->get()->toArray();
      $job_types = \lib\Tool::array_key_translate( $job_types );
      $tree = new \lib\Tree;
      $tree->init( $job_types, 'pid' );
      $params['job_types_option'] = $tree->get_tree( 0, "<option value=\$id \$selected>\$spacer\$name</option>", $sid = 0, $adds = '', $str_group = "<optgroup label='\$spacer\$name'>" );
      // 月薪
      $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['salaries'] = \lib\Tool::array_translate($salaries);

      // 教育程度
      $education = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['education'] = \lib\Tool::array_translate($education);

      // 工作经验
      $params['work_experiences'] = \WorkExperience::where(array( 'job_apply_id' => $jobs['id'] ))->get()->toArray();

      // 教育经历
      $params['education_experiences'] = \EducationExperience::where(array( 'job_apply_id' => $jobs['id'] ))->get()->toArray();

      $params['jobs'] = $jobs;
      $params['job_types'] = $job_types;
      return \View::make('usercenter.jobs.show', $params);
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "数据不存在或未通过审核！" );
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create() {
    // 福利
    $welfares = \JobWelfare::orderBy('sort')->orderBy('id')->get()->toArray();

    // 工作类型
    $job_types = \JobType::orderBy('sort')->orderBy('id')->get()->toArray();
    $job_types = \lib\Tool::array_key_translate( $job_types );
    $tree = new \lib\Tree;
    $tree->init( $job_types, 'pid' );
    $job_types_option = $tree->get_tree( 0, "<option value=\$id \$selected>\$spacer\$name</option>", $sid = 0, $adds = '', $str_group = "<optgroup label='\$spacer\$name'>" );

    // 月薪
    $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
    $salaries = \lib\Tool::array_translate($salaries);

    // 教育程度
    $education = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
    $education = \lib\Tool::array_translate($education);

    return \View::make('usercenter.jobs.create', array( 'job_types_option' => $job_types_option, 'welfares' => $welfares, 'salaries' => $salaries, 'user' => $this->user, 'education' => $education ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store() {
    $input = \Input::get('info');
    $validator = \Validator::make($input, $this->rules, $this->messages);
    if ($validator->fails()) {
      return \Redirect::to('jobs/create')->withErrors($validator)->withInput(\Input::all());
    }
    $input['living_place'] = implode(',', $input['living_place'] );
    $input['work_place'] = implode(',', $input['work_place'] );
    $model = \JobApply::constructModel($input);
    if ( $model->save() ) {
      return \Redirect::to( 'jobs/' . $model->id );
    } else {
      return \Redirect::to('jobs/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $jobs = \JobApply::find($id)->toArray();
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $params = array();

      $jobs['living_place'] = explode(',', $jobs['living_place'] );
      $jobs['work_place'] = explode(',',  $jobs['work_place'] );

      // 工作类型
      $job_types = \JobType::orderBy('sort')->orderBy('id')->get()->toArray();
      $job_types = \lib\Tool::array_key_translate( $job_types );
      $tree = new \lib\Tree;
      $tree->init( $job_types, 'pid' );
      $params['job_types_option'] = $tree->get_tree(0, "<option value=\$id \$selected>\$spacer\$name</option>", $sid = $jobs['job_type'], $adds = '', $str_group = "<optgroup label='\$spacer\$name'>");

      // 月薪
      $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['salaries'] = \lib\Tool::array_translate($salaries);

      // 教育程度
      $education = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['education'] = \lib\Tool::array_translate($education);

      $params['jobs'] = $jobs;
      return \View::make('usercenter.jobs.edit', $params);
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "数据不存在或未通过审核！" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $jobs = \JobApply::find($id);
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('jobs/' . $id . '/edit')->with('type', 'jobs')->withErrors($validator);
      }

      $input['living_place'] = implode(',', $input['living_place'] );
      $input['work_place'] = implode(',', $input['work_place'] );

      $jobs = \JobApply::constructModel($input, $jobs);
      if ( $jobs->save() ) {
        return \Redirect::to( 'jobs/' . $jobs->id );
      } else {
        return \Redirect::to('jobs/' . $id . '/edit')->with('type', 'jobs')->withMessage( '更新失败' );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $jobs = \JobApply::find($id);
    if ( $jobs ) {
      $this->filterOwner($jobs);
      if ( $jobs->delete() ) {
        return \Redirect::to( 'jobs' );
      } else {
        return \Redirect::to( 'jobs' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "请求信息不存在！" );
    }
  }

  public function refresh() {
    if ( \Request::ajax() ) {
      $data = \JobApply::find( \Input::get('id') );
      if ( $data && $data->member_id == $this->user->id ) {
        $data->updated_at = date("Y-m-d H:i:s");
        $data->save();
        return \Response::json( array( 'error_code' => 0, 'message' => '刷新成功' ) , 200 );
      } else {
        return \Response::json( array( 'error_code' => 1, 'message' => '刷新失败，请确认该数据存在并且属于你' ) , 200 );
      }
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }

  public function set_default() {
    if ( \Request::ajax() ) {
      $data = \JobApply::find( \Input::get('id') );
      if ( $data && $data->member_id == $this->user->id ) {
        $data->is_default = \Input::get('is_default');
        $data->save();
        return \Response::json( array( 'error_code' => 0, 'message' => '设置成功' ) , 200 );
      } else {
        return \Response::json( array( 'error_code' => 1, 'message' => '设置失败，请确认该数据存在并且属于你' ) , 200 );
      }
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }

  public function save_images( $id ) {
    $jobs = \JobApply::find( $id );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $input = \Input::get('info');
      if ( isset($input['images']) ) {
        // $jobs->avatar = current($input['images'])['url'];
        $jobs->images = json_encode( $input['images'] );

        /*更新完整度*/
        if ( !$jobs->has_images ) {
          $jobs->has_images = 1;
          $jobs->percentage -= -10;
        }
      } else {
        $jobs->images = json_encode( array() );
        /*更新完整度*/
        if ( $jobs->has_images ) {
          $jobs->has_images = 0;
          $jobs->percentage -= 10;
        }
      }
      if ( $jobs->save() ) {
        return \Redirect::to( 'jobs/' . $jobs->id );
      } else {
        exit( '更新失败' );
        return \Redirect::to( 'jobs/' . $jobs->id )->with('type', 'images')->withMessage( '更新失败' );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function store_experience() {
    $input = \Input::get('info');
    $jobs = \JobApply::find( $input['job_apply_id'] );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $rules = array(
        'corporation_name' => 'required'
        , 'job_type' => 'required|numeric|min:1'
        , 'salary' => 'required|numeric|min:1'
        , 'entry_date' => 'required'
        , 'leaving_date' => 'required'
        , 'content' => 'required'
        );
      $messages = array(
        'corporation_name.required' => '公司名称必填'
        , 'job_type.required' => '职业类别必选'
        , 'job_type.numeric' => '职业类别格式不正确'
        , 'job_type.min' => '职业类别格式不正确'
        , 'salary.required' => '薪资必填'
        , 'salary.numeric' => '薪资必填格式不正确'
        , 'salary.min' => '薪资必填格式不正确'
        , 'entry_date.required' => '在职时间必填'
        , 'leaving_date.required' => '在职时间必填'
        , 'content.required' => '工作内容必填'
        );

      if ( !empty($input['date']) ) {
        list( $input['entry_date'], $input['leaving_date'] ) = explode(' - ', $input['date']);
      }
      $validator = \Validator::make($input, $rules, $messages);
      if ($validator->fails()) {
        return \Redirect::to('jobs/' . $input['job_apply_id'])->with('type', 'work_experience')->withErrors( $validator )->withInput(\Input::all());
      }
      $model = \WorkExperience::constructModel($input);
      if ( $model->save() ) {
        /*更新完整度*/
        if ( !$jobs->has_work_experience ) {
          $jobs->has_work_experience = 1;
          $jobs->percentage -= -10;
          $jobs->save();
        }
        return \Redirect::to( 'jobs/' . $input['job_apply_id'] );
      } else {
        return \Redirect::to('jobs/' . $input['job_apply_id'])->with('type', 'work_experience')->withMessage( '发布失败' )->withInput(\Input::all());
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function delete_experience( $id, $job_apply_id ) {
    $jobs = \JobApply::find( $job_apply_id );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $experience = \WorkExperience::find($id);
      if ( $experience ) {
        $this->filterOwner($experience);
        if ( $experience->delete() ) {

          /*统计工作经验信息，更新完整度*/
          $num = \WorkExperience::where( 'job_apply_id', $job_apply_id )->count();
          if ( $jobs->has_work_experience && empty($num) ) {
            $jobs->percentage -= 10;
            $jobs->has_work_experience = 0;
            $jobs->save();
          }

          return \Redirect::to( 'jobs/' . $job_apply_id );
        } else {
          return \Redirect::to( 'jobs/' . $job_apply_id )->withMessage( "删除失败" );
        }
      } else {
        return \Redirect::to( 'jobs/' . $job_apply_id )->withMessage( "请求信息不存在！" );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function store_education_experience() {
    $input = \Input::get('info');
    $jobs = \JobApply::find( $input['job_apply_id'] );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $rules = array(
        'school_name' => 'required'
        , 'major' => 'required'
        , 'entry_date' => 'required'
        , 'leaving_date' => 'required'
        );
      $messages = array(
        'school_name.required' => '学校名称必填'
        , 'major.required' => '专业必填'
        , 'entry_date.required' => '在职时间必填'
        , 'leaving_date.required' => '在职时间必填'
        );

      if ( !empty($input['in_school_date']) ) {
        list( $input['entry_date'], $input['leaving_date'] ) = explode(' - ', $input['in_school_date']);
      }
      $validator = \Validator::make($input, $rules, $messages);
      if ($validator->fails()) {
        return \Redirect::to('jobs/' . $input['job_apply_id'])->with('type', 'work_experience')->withErrors( $validator )->withInput(\Input::all());
      }
      $model = \EducationExperience::constructModel($input);
      if ( $model->save() ) {
        /*更新完整度*/
        if ( !$jobs->has_education_experience ) {
          $jobs->has_education_experience = 1;
          $jobs->percentage -= -10;
          $jobs->save();
        }
        return \Redirect::to( 'jobs/' . $input['job_apply_id'] );
      } else {
        return \Redirect::to('jobs/' . $input['job_apply_id'])->with('type', 'work_experience')->withMessage( '发布失败' )->withInput(\Input::all());
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function delete_education_experience( $id, $job_apply_id ) {
    $jobs = \JobApply::find( $job_apply_id );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $experience = \EducationExperience::find($id);
      if ( $experience ) {
        $this->filterOwner($experience);
        if ( $experience->delete() ) {
          /*统计教育经历信息，更新完整度*/
          $num = \EducationExperience::where( 'job_apply_id', $job_apply_id )->count();
          if ( $jobs->has_education_experience && empty($num) ) {
            $jobs->percentage -= 10;
            $jobs->has_education_experience = 0;
            $jobs->save();
          }

          return \Redirect::to( 'jobs/' . $job_apply_id );
        } else {
          return \Redirect::to( 'jobs/' . $job_apply_id )->withMessage( "删除失败" );
        }
      } else {
        return \Redirect::to( 'jobs/' . $job_apply_id )->withMessage( "请求信息不存在！" );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function save_tags( $id ) {
    $jobs = \JobApply::find( $id );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $input = \Input::get('info');
      if ( isset($input['customer_tag']) ) {
        $jobs->tags = json_encode( $input['customer_tag'] );

        /*更新完整度*/
        if ( !$jobs->has_light ) {
          $jobs->has_light = 1;
          $jobs->percentage -= -5;
        }
      } else {
        $jobs->tags = json_encode( array() );
        /*更新完整度*/
        if ( $jobs->has_light ) {
          $jobs->has_light = 0;
          $jobs->percentage -= 5;
        }
      }
      if ( $jobs->save() ) {
        return \Redirect::to( 'jobs/' . $jobs->id );
      } else {
        exit( '更新失败' );
        return \Redirect::to( 'jobs/' . $jobs->id )->with('type', 'images')->withMessage( '更新失败' );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

  public function save_content( $id ) {
    $jobs = \JobApply::find( $id );
    if ( $jobs ) {
      $this->filterOwner($jobs);
      $input = \Input::get('info');
      /*更新完整度*/
      if ( empty($input['content']) ) {
        if ( !empty($jobs->content) ) {
          $jobs->percentage -= 5;
        }
      } else {
        if ( empty($jobs->content) ) {
          $jobs->percentage -= -5;
        }
      }
      $jobs->content = $input['content'];

      if ( $jobs->save() ) {
        return \Redirect::to( 'jobs/' . $jobs->id );
      } else {
        exit( '更新失败' );
        return \Redirect::to( 'jobs/' . $jobs->id )->with('type', 'images')->withMessage( '更新失败' );
      }
    } else {
      return \Redirect::to( 'jobs' )->withMessage( "内容不存在！" );
    }
  }

}
