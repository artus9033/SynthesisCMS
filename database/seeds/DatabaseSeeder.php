<?php

use Illuminate\Database\Seeder;
use \App\Models\Database\DatabaseSeedsHistory;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DatabaseSeedsHistory::seedIfNotAlreadySeeded(SettingsSeeder::class, $this, true);
		DatabaseSeedsHistory::seedIfNotAlreadySeeded(ArticleCategoriesSeeder::class, $this, true);
		DatabaseSeedsHistory::seedIfNotAlreadySeeded(ArticlesSeeder::class, $this, true);
		DatabaseSeedsHistory::seedIfNotAlreadySeeded(UsersSeeder::class, $this, true);
		DatabaseSeedsHistory::seedIfNotAlreadySeeded(PagesSeeder::class, $this, true);
	}
}

?>
