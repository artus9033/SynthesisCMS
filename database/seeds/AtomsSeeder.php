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
            'description' => 'This is a sample Atom from SynthesisCMS with no image!',
		  'created_at' => '2017-01-01 00:00:00',
		  'updated_at' => '2017-01-01 00:00:00',
        ]);
    }
}
