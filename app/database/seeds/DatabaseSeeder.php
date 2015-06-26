<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		// $this->call('InitSeeder');
		$this->call('InitJobSeeder');
		// $this->call('AttachmentTableSeeder');

	}

}
