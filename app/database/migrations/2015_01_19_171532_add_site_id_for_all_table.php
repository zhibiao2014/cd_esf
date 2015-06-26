<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSiteIdForAllTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('area', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('attachment', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('decoration', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('direction', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('floor', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('house_supporting', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_apply', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_education', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_post', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_salary', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_type', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('job_welfare', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('pay_method', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('rent_method', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('shop_face_type', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('shop_manager_type', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('s_area', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('s_price', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

		Schema::table('tag', function($table)
		{
			$table->tinyInteger('siteid')->default(1)->comment('站点ID');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('area', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('attachment', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('decoration', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('direction', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('floor', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('house_supporting', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_apply', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_education', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_post', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_salary', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_type', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('job_welfare', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('pay_method', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('rent_method', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('shop_face_type', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('shop_manager_type', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('s_area', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('s_price', function($table)
		{
			$table->dropColumn('siteid');
		});

		Schema::table('tag', function($table)
		{
			$table->dropColumn('siteid');
		});

	}

}
