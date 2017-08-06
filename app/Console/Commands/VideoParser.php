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
    public function handle($serial, $id_name, $season, $episode)
    {
        $url = 'http://www.torrentino.me/serial/'.$serial;

        $xp=new DOMXPath(@DOMDocument::loadHTMLFile($url));

//        summary info about serial   site/serial/id-name
//        =======================================================================================
        $list_all_seasons = $xp->query('//div[@class="tab tab0 open"]');

//        make serial array
        $serial_arr = [];
//        =====
        $season_number_in_list = $list_all_seasons->query('//h4 a');

//        count seasons
        $count_seasons = $season_number_in_list->length;

        $table_episodes_in_season = $list_all_seasons->query('//table[@class="table-list seasons"] tbody');

//        then find by index season
        $index = $count_seasons;
        while ($index > 0) {

            $episode_in_season = $table_episodes_in_season[$index]->query('//tr[@class="item"]');

//            make season array
            $season_arr = array(
                "season" => $season_number_in_list[$index]
            );

//            foreach episodes in season
            foreach($episode_in_season as $episode_in_cycle)
            {
                $episode_number = $episode_in_cycle->query('//td[@class="column first episode"]');
                $episode_name = $episode_in_cycle->query('//td[@class="column name"]');
                $episode_date = $episode_in_cycle->query('//td[@class="column date"]');
                $episode_download_btn = $episode_in_cycle->query('//td[@class="column last link-to"] a[@class="button"]');

//                boolean toogle download button (if button empty (without "download") = false, else: button = true).
//                isset or empty?
                if ( empty($episode_download_btn) ){
                    $episode_download_btn = false;
                } else {
                    $episode_download_btn = true;
                }
//                add episode to season array
//                error in append to array in (arr1, arr2). Maybe need wrap in brackets arr2?!
                array_merge($season_arr,
                    $episode_number = [
                        "name" => $episode_name,
                        "date" => $episode_date,
                        "ready_dwl" => $episode_download_btn
                    ]
                );
            }

//            add season array to serial array
            array_merge($serial_arr, $season_arr);

            $index ++;
        }
//        =====
//        detailed info about episode   site/serial/id-name/season-season_int/episode-episode_int
//        =======================================================================================
        $list_all_links_episode = $xp->query('//table[@class="table-list quality series"] tbody');
        $link = $list_all_links_episode->query('//tr[@class="item"]');

        $episode_links = [];

        foreach($link as $link_in_cycle){
            $link_quality = $link_in_cycle->query('//td[@class="column first video"]');
            $link_audio = $link_in_cycle->query('//td[@class="column audio"]');
            $link_size = $link_in_cycle->query('//td[@class="column size"]');
            $link_seed = $link_in_cycle->query('//td[@class="column seed-leech"] span[@class="seed"]');
            $link_download_url = $link_in_cycle->query('//td[@class="column last download"] a')->getAttribute("data-default");

            $episode_arr = [
                "quality" => $link_quality,
                "audio" => $link_audio,
                "size" => $link_size,
                "seed" => $link_seed,
                "magnet" => $link_download_url
            ];

//            add array 1 link to array all links episode
            array_merge($episode_links, $episode_arr);
        }
    }
}