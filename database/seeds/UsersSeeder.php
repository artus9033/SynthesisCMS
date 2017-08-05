<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('synthesiscms_users')->insert([[
			'name' => 'admin',
			'email' => 'admin@admin.admin',
			'password' => bcrypt('secret'),
			'is_admin' => true,
		],
			[
				'name' => 'user',
				'email' => 'user@user.user',
				'password' => bcrypt('secret'),
				'is_admin' => false,
			]]);
	}
}

?>
