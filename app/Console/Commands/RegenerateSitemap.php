<?php namespace App\Console\Commands;

use App\SynthesisCMS\API\ExtensionsCallbacksBridge;
use Illuminate\Console\Command;

class RegenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regenerateSitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate the sitemap.xml and robots.txt files for the website. Automatically done by SynthesisCMS every time a user makes any changes to the routes.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ExtensionsCallbacksBridge::regenerateSitemap();

        echo ("Sitemap & robots.txt regenerated successfully!\n");
    }
}
