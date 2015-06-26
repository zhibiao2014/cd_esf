<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWorkTime extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('work_time'))
		{
			Schema::drop('work_time');
		}
		Schema::create('work_time', function($t)
		{
			$t->increments('id');
			$t->string( 'name' )->comment( '名字' );
			$t->tinyInteger( 'sort' )->default(0)->comment( '排序' );
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('work_time'))
		{
			Schema::drop('work_time');
		}
	}

}
