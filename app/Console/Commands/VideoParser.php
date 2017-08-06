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
    protected $signature = 'movie:parse {id_name} {season} {episode} {--detailed} {--summary}';

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
        $out_answer = [];
        // read parameters and option for run parser
        $option_detailed = $this->option('detailed');
        $option_summary = $this->option('summary');

        // $id_name must be type site/serial/id-name => 12345-name!
        $id_name = $this->argument('id_name');
        $season = $this->argument('season');
        $episode = $this->argument('episode');

        $base_url = "http://www.torrentino.me/serial/{$id_name}";

        // for parse info about episode
        if ($option_detailed == true){
            $url = $base_url.'/season-'.$season.'/episode-'.$episode;
            $html = $this->parser->fileGetHtml($url);

            $list_all_links_episode = $html->find('table.table-list .quality .series tbody');
            $link = $list_all_links_episode->find('tr.item]');

            $episode_links = [];

            foreach ($list_all_links_episode->find('tr.item') as $link_in_cycle) {
                $link_quality = $link_in_cycle->find('td.column .first .video')->innertext;
                $link_audio = $link_in_cycle->find('td.column .audio')->innertext;
                $link_size = $link_in_cycle->find('td.column .size')->innertext;
                $link_seed = $link_in_cycle->find('td.column .seed-leech span.seed')->innertext;
                $link_download_url = $link_in_cycle->find('td.column .last .download a')->attr['data-default'];
                $episode_arr = [
                    "quality" => $link_quality,
                    "audio" => $link_audio,
                    "size" => $link_size,
                    "seed" => $link_seed,
                    "magnet" => $link_download_url,
                ];
//            add array 1 link to array all links episode
                array_merge($episode_links, $episode_arr);
            }
            array_merge($out_answer, $episode_links);
        }

//        for parse info about serial all seasons and episodes
        if ($option_summary == true){
            $html = $this->parser->fileGetHtml($base_url);

            $serial_arr = [];

//            $season_arr = [];

            $list_all_seasons = $html->find('div.tab .tab0 .open');

            $season_number_in_list = $list_all_seasons->find('h4 a')->innertext;

            $table_episodes_in_season = $list_all_seasons->find('table.table-list .seasons tbody');

            // count seasons
            $count_seasons = $season_number_in_list->length;

            while ($count_seasons > 0){
                // number season
                $season_number = $season_number_in_list[$count_seasons];

                // table episodes of season
                $season_table = $table_episodes_in_season[$count_seasons];

                $episode_in_season = $season_table->find('tr.item');

                $season_arr = [
                    "season" => $season_number,
                ];

                foreach($episode_in_season as $episode_in_cycle)
                {
                    $episode_number = $episode_in_cycle->find('td.column .first .episode');
                    $episode_name = $episode_in_cycle->find('td.column .name');
                    $episode_date = $episode_in_cycle->find('td.column .date');
                    $episode_download_btn = $episode_in_cycle->find('td.column .last .link-to a.button');

                    // boolean toogle download button (if button empty (without "download") = false, else: button = true).
                    // isset or empty?
                    if ( empty($episode_download_btn) ){
                        $episode_download_btn = false;
                    } else {
                        $episode_download_btn = true;
                    }

                    // add episode to season array
                    array_merge($season_arr,
                        $episode_number = [
                            "number" => $episode_number,
                            "name" => $episode_name,
                            "date" => $episode_date,
                            "ready_dwl" => $episode_download_btn
                        ]
                    );
                }

                $count_seasons --;
            }
            array_merge($out_answer, $serial_arr);
        }

        return($out_answer);
    }
}