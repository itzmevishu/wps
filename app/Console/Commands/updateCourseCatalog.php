<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateCourseCatalog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ecomm:updateCourseCatalog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update course catalog from Litmos.';

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
        $ceuClass = new \App\Functions\getCourses;  

        $ceuClass->runUpdate();
    }
}
