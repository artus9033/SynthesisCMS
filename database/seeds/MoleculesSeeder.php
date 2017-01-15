<?php

use Illuminate\Database\Seeder;

class MoleculesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('molecules')->insert([
             'title' => 'Default',
             'description' => 'This is the default SynthesisCMS Molecule. It is not deleteable, but it\'s name and description are customizable. Have fun!',
         ]);
    }
}
