<?php

use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('synthesiscms_articles')->insert(
			[
				'title' => 'Hello World!!!',
				'description' => '<p style="text-align: center;">This is a sample Article from SynthesisCMS with no image!</p>',
				'created_at' => '2017-01-01 00:00:00',
				'updated_at' => '2017-01-01 00:00:00',
			]
		);
		// Cannot be in one DB::table closure, as all rows would need the same columns & values count
		DB::table('synthesiscms_articles')->insert(
			[
				'title' => 'Hello World With Image!!!',
				'description' => '<p style="text-align: center;">This is a sample Article from SynthesisCMS with no image!</p>',
				'created_at' => '2017-01-01 00:00:00',
				'updated_at' => '2017-01-01 00:00:00',
				'hasImage' => true,
				'image' => 'http://materializecss.com/images/sample-1.jpg',
			]
		);
	}
}
