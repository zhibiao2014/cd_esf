<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsRecommendForJobApply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->tinyInteger('is_recommend')->comment('是否推荐');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->dropColumn('is_recommend');
		});
	}

}
