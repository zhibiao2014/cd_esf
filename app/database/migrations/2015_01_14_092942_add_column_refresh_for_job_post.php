<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRefreshForJobPost extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_post', function(Blueprint $table)
		{
			$table->timestamp('refreshed_at')->comment('刷新时间');
		});
		\DB::statement(\DB::raw( 'ALTER TABLE `xy_job_post` CHANGE `refreshed_at` `refreshed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP' ));
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
			$table->dropColumn('refreshed_at');
		});
	}

}
