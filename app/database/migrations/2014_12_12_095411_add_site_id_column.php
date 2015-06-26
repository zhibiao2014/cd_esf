<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteIdColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('second_hand_housing', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('office', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('shop', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('villas', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('sale_common', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('rent', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('rent_office', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('rent_shop', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('rent_villas', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('rent_common', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('i_wanna_buy_property', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
		});

		Schema::table('i_wanna_rent_property', function($table)
		{
			$table->tinyInteger('siteid')->default(1);
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
			$table->dropColumn('siteid');
		});

		Schema::table('office', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('shop', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('villas', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('sale_common', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent_office', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent_shop', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent_villas', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent_common', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('i_wanna_buy_property', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('i_wanna_rent_property', function($table)
		{
			$table->dropColumn('siteid');
		});
	}

}
