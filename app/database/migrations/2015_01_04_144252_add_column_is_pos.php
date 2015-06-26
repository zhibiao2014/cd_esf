<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsPos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('second_hand_housing', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('office', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('shop', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('villas', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('sale_common', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('rent', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('rent_office', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('rent_shop', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('rent_villas', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});

		Schema::table('rent_common', function($table)
		{
			$table->tinyInteger('is_pos')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('second_hand_housing', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('office', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('shop', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('villas', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('sale_common', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('rent', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('rent_office', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('rent_shop', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('rent_villas', function($table)
		{
			$table->dropColumn('is_pos');
		});

		Schema::table('rent_common', function($table)
		{
			$table->dropColumn('is_pos');
		});

	}

}
