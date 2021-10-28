<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Classes\RssParser;

class RssCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:parse {\'url\'}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads, Parses, and Stores RSS Feed';

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
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('\'url\'');

        $rss = new RssParser;

        $feed = $rss->getAndParseFeed($url);
        if ($feed === true) {
            echo "\n\n".$url ." - OK\n\n";
        } else {
            echo "\n\n".$url ." - ERROR (Getting and Parsing)\n\n";
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

}
