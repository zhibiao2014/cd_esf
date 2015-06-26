<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForJobPost extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_post', function(Blueprint $table)
		{
			$table->string('welfare')->comment('福利待遇');
			$table->string('customer_tag')->comment('自定义福利');
			$table->tinyInteger('status')->default(1)->comment('状态;审核状态 0：退回，2：再次提交审核，1：审核通过。默认审核通过');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_post', function(Blueprint $table)
		{
			$table->dropColumn('welfare');
			$table->dropColumn('customer_tag');
			$table->dropColumn('status');
		});
	}

}
