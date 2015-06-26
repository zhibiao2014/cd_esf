<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnHasChildForJobType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_type', function(Blueprint $table)
		{
			$table->tinyInteger( 'has_child' )->default(0)->comment("是否有子类型");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_type', function(Blueprint $table)
		{
			$table->dropColumn( 'has_child' );
		});
	}

}
