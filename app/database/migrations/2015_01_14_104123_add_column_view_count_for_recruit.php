<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnViewCountForRecruit extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->integer('view_count')->default(0)->comment('浏览次数');
		});
		Schema::table('job_post', function(Blueprint $table)
		{
			$table->integer('view_count')->default(0)->comment('浏览次数');
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
			$table->dropColumn('view_count');
		});
		Schema::table('job_post', function(Blueprint $table)
		{
			$table->dropColumn('view_count');
		});
	}

}
