<?php

namespace App\Modules\Bgtsldap\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BgtsldapDatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		$this->call(BgtsldapDomainSeeder::class);
		$this->call(BgtsldapUserSeeder::class);
	}
}
