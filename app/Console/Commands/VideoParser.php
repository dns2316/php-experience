<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VideoParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse movie command';


    /**
     * Create a new command instance.
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
        echo "Hello world";
    }
}