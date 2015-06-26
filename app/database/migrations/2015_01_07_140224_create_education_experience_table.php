<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEducationExperienceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('education_experience'))
		{
			Schema::drop('education_experience');
		}
		Schema::create('education_experience', function($t)
		{
			$t->increments('id');
			$t->string('school_name');
			$t->string('major');
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
		if (Schema::hasTable('education_experience'))
		{
			Schema::drop('education_experience');
		}
	}

}
