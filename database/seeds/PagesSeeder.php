<?php

use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('synthesiscms_pages')->insert([
			'slug' => '/hydrogen',
			'page_title' => 'The Hydrogen Route',
			'page_header' => 'This is a sample Route from SynthesisCMS with the Hydrogen Extension selected as parent!',
			'extension' => 'Hydrogen',
		]);
		$kpath = 'App\\Extensions\\Hydrogen\\ExtensionKernel';
		$kernel = new $kpath;
		$kernel->create(1);
		DB::table('synthesiscms_pages')->insert([
			'slug' => '/',
			'page_title' => 'SynthesisCMS Home',
			'page_header' => 'This is a sample Route from SynthesisCMS with the Hydrogen Extension selected as parent!',
			'extension' => 'Hydrogen',
		]);
		$kpath = 'App\\Extensions\\Hydrogen\\ExtensionKernel';
		$kernel = new $kpath;
		$kernel->create(2);
	}
}

?>
