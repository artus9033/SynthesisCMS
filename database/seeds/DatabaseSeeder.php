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
		echo(" => SynthesisCMS beginning database seeding." . PHP_EOL);
		$count = 0;
		$count += DatabaseSeedsHistory::seedIfNotAlreadySeeded(SettingsSeeder::class, $this, true);
		$count += DatabaseSeedsHistory::seedIfNotAlreadySeeded(ArticleCategoriesSeeder::class, $this, true);
		$count += DatabaseSeedsHistory::seedIfNotAlreadySeeded(ArticlesSeeder::class, $this, true);
		$count += DatabaseSeedsHistory::seedIfNotAlreadySeeded(UsersSeeder::class, $this, true);
		$count += DatabaseSeedsHistory::seedIfNotAlreadySeeded(PagesSeeder::class, $this, true);
		echo(" => SynthesisCMS database seeding done. " . $count . " seeders have been run." . PHP_EOL);
	}
}

?>
