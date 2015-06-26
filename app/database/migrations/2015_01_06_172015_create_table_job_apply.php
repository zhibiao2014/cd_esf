<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJobApply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('job_apply'))
		{
			Schema::drop('job_apply');
		}
		Schema::create('job_apply', function($t)
		{
			$t->increments('id');
			$t->string('title');
			$t->smallInteger('job_type');
			$t->string('name');
			$t->tinyInteger('sex');
			$t->dateTime('birthday');
			$t->smallInteger('education');
			$t->string('birth_place');
			$t->string('living_place');
			$t->string('work_place');
			$t->string('email');
			$t->char('phone_number', 11);
			$t->text('self_introduce');
			$t->Integer('member_id');
			$t->tinyInteger('status')->default(1);
			$t->smallInteger('money');
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
		if (Schema::hasTable('job_apply'))
		{
			Schema::drop('job_apply');
		}
	}

}
