<?php
namespace front;

class RecruitController extends \BaseController {

  /* 招聘首页 */
  public function index() {
    $params['p'] = \Input::all();
    $params['sort'] = array('updated_at', 'desc');
    $params['job_posts'] = \JobPost::search($params['p']);

    $params['job_posts'] = $params['job_posts']->where( 'status', 1 )->orderBy('updated_at', 'desc')->paginate(20);

    // 工作类型
    $params['job_types'] = \JobType::where( 'has_child', 0 )->orderBy('sort', 'desc')->orderBy('id', 'desc')->get()->toArray();
    $params['job_types'] = \lib\Tool::array_key_translate( $params['job_types'] );
    // 福利
    $params['welfares'] = \JobWelfare::orderBy('sort')->orderBy('id')->get()->toArray();

    // 教育程度
    $educations = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
    $params['educations'] = \lib\Tool::array_translate($educations);

    // 薪资
    $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
    $params['salaries'] = \lib\Tool::array_translate($salaries);

    $params['recommends_post'] = \JobPost::where( 'status', 1 )->where( 'is_recommend' , 1 )->get()->toArray();

    return \View::make( 'recruit.jobs.index', $params );
  }

  public function resume() {
    $params['p'] = \Input::all();
    $params['sort'] = array('updated_at', 'desc');
    $params['resumes'] = \JobApply::search($params['p']);
    $params['resumes'] = $params['resumes']->where( 'status', 1 )->orderBy('updated_at', 'desc')->paginate(20);
    // 城区
    $params['work_places'] = array( '武陵区', '鼎城区', '安乡县', '汉寿县', '澧县', '临澧县', '桃源县', '石门县', '津市市' );
    // 工作类型
    $params['job_types'] = \JobType::where( 'has_child', 0 )->orderBy('sort', 'desc')->orderBy('id', 'desc')->get()->toArray();
    $params['job_types'] = \lib\Tool::array_key_translate( $params['job_types'] );
    // 教育程度
    $educations = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
    $params['educations'] = \lib\Tool::array_translate($educations);
    // 薪资
    $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
    $params['salaries'] = \lib\Tool::array_translate($salaries);

    // 工作年限
    $params['work_times'] = array( 1 => '一年以上', 2 => '2年以上', 3 => '3年以上', 5 => '5年以上', 10 => '10年以上' );

    $params['recommend_resumes'] = \JobApply::where( 'status', 1 )->where( 'is_recommend' , 1 )->get()->toArray();

    return \View::make( 'recruit.jobs.resume', $params );
  }

  public function resume_show( $id ) {
    $params['resume'] = \JobApply::where( 'status', 1 )->find( $id );
    if ($params['resume']) {
      $params['resume']->view_count += 1;
      $params['resume']->save();
      $params['resume']['tags'] = json_decode($params['resume']['tags'], true);
      // 工作类型
      $params['job_types'] = \JobType::where( 'has_child', 0 )->orderBy('sort', 'desc')->orderBy('id', 'desc')->get()->toArray();
      $params['job_types'] = \lib\Tool::array_translate( $params['job_types'] );

      // 教育程度
      $educations = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['educations'] = \lib\Tool::array_translate($educations);

      // 薪资
      $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['salaries'] = \lib\Tool::array_translate($salaries);

      // 工作经验
      $params['work_experiences'] = \WorkExperience::where(array( 'job_apply_id' => $params['resume']['id'] ))->get()->toArray();

      // 教育经历
      $params['education_experiences'] = \EducationExperience::where(array( 'job_apply_id' => $params['resume']['id'] ))->get()->toArray();

      $params['recommend_resumes'] = \JobApply::where( 'status', 1 )->where( 'is_recommend' , 1 )->orderBy( \DB::raw('rand()') )->take(5)->get();

      // $params['company'] = \User::find( $params['resume']->member_id );
      return \View::make( 'recruit.jobs.resume_show', $params );
    } else {
      return \View::make( 'error.404' );
    }
  }


  public function post_show( $id ) {
    $params['post'] = \JobPost::find( $id );
    if ($params['post']) {

      $params['post']->view_count += 1;
      $params['post']->save();

      $params['post']['welfare'] = json_decode( $params['post']['welfare'], true );
      $params['post']['customer_tag'] = json_decode( $params['post']['customer_tag'], true );

      // 职位类型
      $params['job_types'] = \JobType::where( 'has_child', 0 )->orderBy('sort', 'desc')->orderBy('id', 'desc')->get()->toArray();
      $params['job_types'] = \lib\Tool::array_translate( $params['job_types'] );

      // 福利
      $params['welfares'] = \JobWelfare::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['welfares'] = \lib\Tool::array_translate( $params['welfares'] );

      // 教育程度
      $educations = \JobEducation::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['educations'] = \lib\Tool::array_translate($educations);

      // 薪资
      $salaries = \JobSalary::orderBy('sort')->orderBy('id')->get()->toArray();
      $params['salaries'] = \lib\Tool::array_translate($salaries);

      // 工作年限
      $params['work_times'] = array( 1 => '一年以上', 2 => '2年以上', 3 => '3年以上', 5 => '5年以上', 10 => '10年以上' );

      // 工作类别
      $params['position_types'] = array( '1' => '全职', '2' => '兼职', '3' => '实习');

      $params['company'] = \User::find( $params['post']->member_id );
      return \View::make( 'recruit.jobs.post_show', $params );
    } else {
      return \View::make( 'error.404' );
    }
  }

  public function invite( $id ) {
    $user = \Auth::user();

  }

  public function deliver( $id ) {
    $user = \Auth::user();

  }
}