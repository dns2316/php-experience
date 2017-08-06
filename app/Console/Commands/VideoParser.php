<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Royalmar\HtmlDomParser\HtmlDomParser;


class VideoParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:parse {slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse movie command';

    /**
     * @var HtmlDomParser
     */
    protected $parser;

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct(HtmlDomParser $parser)
    {
        $this->parser = $parser;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $slug = $this->argument('slug');
        $url = "http://www.torrentino.me/serial/{$slug}";
        $html = $this->parser->fileGetHtml($url);
        foreach($html->find('img') as $images)
        {
            echo $images->src.'\n';
        }
    }
}
