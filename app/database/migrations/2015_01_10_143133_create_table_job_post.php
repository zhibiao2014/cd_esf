<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJobPost extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('job_post'))
		{
			Schema::drop('job_post');
		}
		Schema::create('job_post', function($t)
		{
			$t->increments('id');
			$t->string('title')->comment('职位名称');
			$t->string('job_type')->comment('职位类别');
			$t->tinyInteger('people_num')->comment('招聘人数');
			$t->tinyInteger('education')->comment('学历要求');
			$t->tinyInteger('work_time')->comment('工作年限');
			$t->tinyInteger('salary')->comment('薪资');
			$t->tinyInteger('position_type')->comment('工作类型');
			$t->text('content')->comment('任职要求');
			$t->string('contact_people')->comment('联系人');
			$t->string('tel_number')->comment('联系电话');
			$t->string('email')->comment('邮箱');
			$t->string('address')->comment('地址');
			$t->tinyInteger('accept_intern')->comment('是否接收实习生');
			$t->Integer('member_id')->comment('公司ID');
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('job_post'))
		{
			Schema::drop('job_post');
		}
	}

}
