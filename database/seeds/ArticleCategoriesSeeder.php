<?php

use Illuminate\Database\Seeder;

class ArticleCategoriesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('article_categories')->insert([
			'title' => 'Default',
			'description' => 'This is the default SynthesisCMS ArticleCategory. It is not deleteable, but it\'s name and description are customizable. Have fun!',
		]);
	}
}

?>
