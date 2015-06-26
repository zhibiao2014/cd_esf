<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPercentageForJobApply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->tinyInteger('percentage')->default(60);
			$table->string('avatar');
			$table->text('images');

			$table->tinyInteger('has_work_experience')->default(0);
			$table->tinyInteger('has_education_experience')->default(0);
			$table->tinyInteger('has_images')->default(0);
			$table->tinyInteger('has_light')->default(0);

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
			$table->dropColumn('percentage');
			$table->dropColumn('images');
			$table->dropColumn('avatar');

			$table->dropColumn('has_work_experience');
			$table->dropColumn('has_education_experience');
			$table->dropColumn('has_images');
			$table->dropColumn('has_light');

		});
	}

}
