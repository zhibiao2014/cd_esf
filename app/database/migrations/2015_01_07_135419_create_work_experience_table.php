<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkExperienceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('work_experience'))
		{
			Schema::drop('work_experience');
		}
		Schema::create('work_experience', function($t)
		{
			$t->increments('id');
			$t->string('corporation_name');
			$t->smallInteger('job_type');
			$t->smallInteger('salary');
			$t->date('entry_date');
			$t->date('leaving_date');
			$t->text('content');
			$t->Integer('member_id');
			$t->Integer('job_apply_id');
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
		if (Schema::hasTable('work_experience'))
		{
			Schema::drop('work_experience');
		}
	}

}
