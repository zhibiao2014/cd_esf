<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJobInviteDeliverRecords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('job_invite_deliver_records'))
		{
			Schema::drop('job_invite_deliver_records');
		}
		Schema::create('job_invite_deliver_records', function($t)
		{
			$t->increments('id');
			$t->integer( 'user_id' )->comment( '用户' );
			$t->integer( 'resume_id' )->default(0)->comment( '简历' );
			$t->integer( 'post_id' )->default(0)->comment( '职位' );
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('job_invite_deliver_records'))
		{
			Schema::drop('job_invite_deliver_records');
		}
	}

}
