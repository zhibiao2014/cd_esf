<?php

class InitSeeder extends Seeder {
  public function run() {
    // DB::statement("source ./cdfdc_usercenter.sql");

    $source = dirname(__FILE__) . "/cdfdc_usercenter.sql";

    $command="mysql -h" . \Config::get('database.connections.mysql.host') . " -u" . \Config::get('database.connections.mysql.username') .  " -p" . \Config::get('database.connections.mysql.password') . " " . \Config::get('database.connections.mysql.database') . " < {$source}";
    exec($command, $output, $worked);
    switch($worked) {
      case 0:
      $this->command->info('successfully imported to database');
      break;
      case 1:
      $this->command->info('There was an error during import.');
      break;
    }
  }
}