<?php

use Illuminate\Database\Seeder;

class AtomsSeeder extends Seeder
{
	/**
	* Run the database seeds.
	*
	* @return void
	*/
	public function run()
	{
		DB::table('atoms')->insert([
			'title' => 'Hello World!!!',
			'description' => '<p style="text-align: center;">This is a sample Atom from SynthesisCMS with no image!</p>',
			'created_at' => '2017-01-01 00:00:00',
			'updated_at' => '2017-01-01 00:00:00',
		],
		[
			'title' => 'Hello World!!!',
			'description' => '<p style="text-align: center;">This is a sample Atom from SynthesisCMS with no image!</p>',
			'created_at' => '2017-01-01 00:00:00',
			'updated_at' => '2017-01-01 00:00:00',
			'hasImage' => true,
			'imageSourceType' => 'web',
			'image' => 'http://materializecss.com/images/sample-1.jpg',
		]
	);
}
}
