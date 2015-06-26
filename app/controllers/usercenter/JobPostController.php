<?php
namespace usercenter;

class JobPostController extends \BaseController {
  private $rules = array(

    'title' => 'required'
    , 'job_type' => 'required|integer'
    , 'people_num' => 'required|integer'
    , 'contact_people' => 'required'
    , 'education' => 'required|integer'
    , 'email' => 'required|email'
    , 'tel_number' => 'required'
    , 'work_time' => 'required'
    , 'salary' => 'required'
    , 'position_type' => 'required'

    );
  private $messages = array(
    'title.required' => '职位名称不能为空'
    , 'job_type.required' => '职位类别必填'
    , 'job_type.integer' => '职位类别格式不正确'
    , 'people_num.required' => '招聘人数必填'
    , 'people_num.integer' => '招聘人数格式不正确'
    , 'contact_people.required' => '联系人不能为空'
    , 'education.required' => '学历必选'
    , 'education.integer' => '学历格式不正确'
    , 'email.required' => '邮箱必填'
    , 'email.email' => '邮箱格式不正确'
    , 'tel_number.required' => '联系电话不能为空'
    , 'work_time.required' => '工作年限不能为空'
    , 'salary.required' => '薪资不能为空'
    , 'position_type.required' => '职位类型不能为空'

    );

  protected $access = array(
    'individual' => array(),
    'broker' => array(),
    'company' => array('index', 'create', 'store', 'edit', 'update', 'destroy', 'change_status', 'refresh')
    );

  public function __construct() {
    $this->user = \Auth::user();
    $this->beforeFilter('@filterAccess');
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index() {
    $status = (\Input::get('status', false) !== false) ? intval(\Input::get('status')) : 1;
    $posts = \JobPost::where(array( 'status' => $status, 'member_id' => $this->user->id ))->get();
    $post_num = \JobPost::where( 'member_id' , $this->user->id )->count();

    // 工作类型
    $job_types = \JobType::orderBy('sort')->orderBy('id')->get()->toArray();
    $job_types = \lib\Tool::array_translate( $job_types );

    return \View::make( 'usercenter.job_post.index', array( 'job_types' => $job_types, 'posts' => $posts, 'post_num' => $post_num, 'status' => $status ) );
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

    // 工作年限
    $work_times = array( 0 => '不限', 1 => '一年以下', 2 => '1-2年', 3 => '3-5年', 4 => '6-7年', 5 => '8-10年', 6 => '10年以上' );

    return \View::make('usercenter.job_post.create', array( 'job_types_option' => $job_types_option, 'welfares' => $welfares, 'salaries' => $salaries, 'user' => $this->user, 'education' => $education, 'work_times' => $work_times ));
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
      return \Redirect::to('post/create')->withErrors($validator)->withInput(\Input::all());
    }
    $input['welfare'] = json_encode( $input['welfare'] );
    $input['customer_tag'] = json_encode( $input['customer_tag'] );
    $model = \JobPost::constructModel($input);
    if ( $model->save() ) {
      return \Redirect::to( 'post' );
    } else {
      return \Redirect::to('post/create')->withMessage( '发布失败' )->withInput(\Input::all());
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id) {
    $post = \JobPost::find($id)->toArray();
    if ( $post ) {
      $this->filterOwner($post);
      $params = array();

      $post['welfare'] = json_decode( $post['welfare'], true );
      $post['customer_tag'] = json_decode( $post['customer_tag'], true );

      // 工作类型
      $job_types = \JobType::orderBy('sort')->orderBy('id')->get()->toArray();
      $job_types = \lib\Tool::array_key_translate( $job_types );
      $tree = new \lib\Tree;
      $tree->init( $job_types, 'pid' );
      $params['job_types_option'] = $tree->get_tree(0, "<option value=\$id \$selected>\$spacer\$name</option>", $sid = $post['job_type'], $adds = '', $str_group = "");

      // 月薪
      $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['salaries'] = \lib\Tool::array_translate($salaries);

      // 教育程度
      $education = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['education'] = \lib\Tool::array_translate($education);

      // 工作年限
      $params['work_times'] = array( 0 => '不限', 1 => '一年以下', 2 => '1-2年', 3 => '3-5年', 4 => '6-7年', 5 => '8-10年', 6 => '10年以上' );
      // 福利
      $params['welfares'] = \JobWelfare::orderBy('sort')->orderBy('id')->get()->toArray();

      $params['post'] = $post;
      return \View::make('usercenter.job_post.edit', $params);
    } else {
      return \Redirect::to( 'post' )->withMessage( "数据不存在或未通过审核！" );
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id) {
    $post = \JobPost::find($id);
    if ( $post ) {
      $this->filterOwner($post);
      $input = \Input::get('info');
      $validator = \Validator::make($input, $this->rules, $this->messages);
      if ($validator->fails()) {
        return \Redirect::to('post/' . $id . '/edit')->withErrors($validator);
      }
      $input['accept_intern'] = isset($input['accept_intern']) ? $input['accept_intern'] : 0;
      $input['welfare'] = json_encode( $input['welfare'] );
      $input['customer_tag'] = json_encode( $input['customer_tag'] );

      $post = \JobPost::constructModel($input, $post);
      if ( $post->save() ) {
        return \Redirect::to( 'post');
      } else {
        return \Redirect::to('post/' . $id . '/edit')->withMessage( '更新失败' );
      }
    } else {
      return \Redirect::to( 'post' )->withMessage( "内容不存在！" );
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id) {
    $post = \JobPost::find($id);
    if ( $post ) {
      $this->filterOwner($post);
      if ( $post->delete() ) {
        return \Redirect::to( 'post' );
      } else {
        return \Redirect::to( 'post' )->withMessage( "删除失败" );
      }
    } else {
      return \Redirect::to( 'post' )->withMessage( "请求信息不存在！" );
    }
  }

  public function change_status($id) {
    $post = \JobPost::find($id);
    if ( $post ) {
      $this->filterOwner($post);
      $post->status = \Input::get('status');
      if ( $post->save() ) {
        return \Redirect::to( 'post' );
      } else {
        return \Redirect::to( 'post' )->withMessage( "操作失败" );
      }
    } else {
      return \Redirect::to( 'post' )->withMessage( "请求信息不存在！" );
    }
  }

  public function refresh() {
    if ( \Request::ajax() ) {
      $data = \JobPost::find( \Input::get('id') );
      if ( \lib\Tool::isToday( date("Y-m-d" , strtotime($data->refreshed_at) ) ) ) {
        return \Response::json( array( 'error_code' => 1, 'message' => '今天已经刷新过了，明天再来吧！' ) , 200 );
      }
      if ( $data && $data->member_id == $this->user->id ) {
        $data->refreshed_at = date("Y-m-d H:i:s");
        $data->save();
        return \Response::json( array( 'error_code' => 0, 'message' => '刷新成功' ) , 200 );
      } else {
        return \Response::json( array( 'error_code' => 1, 'message' => '刷新失败，请确认该数据存在并且属于你' ) , 200 );
      }
    } else {
      \APP::abort(403, 'forbid request!');
    }
  }

}
