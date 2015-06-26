<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsDefaultForJobApply extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_apply', function(Blueprint $table)
		{
			$table->tinyInteger( 'is_default' )->default(0);
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
			$table->dropColumn( 'is_default' );
		});
	}

}
