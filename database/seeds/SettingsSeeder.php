<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('synthesiscms_settings')->insert([
 		 'header_title' => 'SynthesisCMS',
 		 'tab_title' => 'SynthesisCMS',
 		 'footer_copyright' => 'by artus9033',
 		 'footer_more_links_bottom_text' => 'More Links',
 		 'footer_more_links_bottom_href' => 'http://google.com',
 		 'footer_links_text' => 'Some Useful Links:',
 		 'footer_links_content' =>
 		 '<ul>
 			 <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
 			 <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
 			 <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
 			 <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
 		 </ul>',
 		 'footer_header' => 'SynthesisCMS Footer Content',
 		 'footer_content' => 'You can specify what to show inside the footer in SynthesisCMS Settings in the site backend.',
 		 'tab_color' => '#26a69a',
 		 'main_color' => '#26a69a',
 		 'active' => true,
 	  ]);
    }
}
