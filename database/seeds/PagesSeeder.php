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
	    DB::table('pages')->insert([
		  'slug' => '/hydrogen',
            'page_title' => 'The Hydrogen Route',
            'page_header' => 'This is a sample Route from SynthesisCMS with the Hydrogen Module selected as parent!',
            'module' => 'Hydrogen',
        ]);
	   $kpath = 'App\\Modules\\Hydrogen\\ModuleKernel';
	   $kernel = new $kpath;
	   $kernel->create(1);
    }
}
?>