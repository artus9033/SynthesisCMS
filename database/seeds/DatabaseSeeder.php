<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    $this->call(SettingsSeeder::class);
	    $this->call(MoleculesSeeder::class);
	    $this->call(AtomsSeeder::class);
	    $this->call(UsersSeeder::class);
	    $this->call(PagesSeeder::class);
    }
}
?>
