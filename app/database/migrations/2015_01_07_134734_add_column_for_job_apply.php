<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnForJobApply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->tinyInteger('work_time')->default(0);
			$table->text('content');
			$table->text('tags');
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
			$table->dropColumn('work_time');
			$table->dropColumn('content');
			$table->dropColumn('tags');
		});
	}

}
