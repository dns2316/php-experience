<?php

use Illuminate\Database\Seeder;

class MovieTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movie')->insert([
        'name' => str_random(10),
        'tracking' => true,
        'season' => rand(0, 23),
        'episode' => rand(0, 255),
        'url' => 'http://www.imdb.com/title/tt5491994',
        'img' => 'https://images-na.ssl-images-amazon.com/images/M/MV5BZWYxODViMGYtMGE2ZC00ZGQ3LThhMWUtYTVkNGE3OWU4NWRkL2ltYWdlL2ltYWdlXkEyXkFqcGdeQXVyMjYwNDA2MDE@._V1_SY1000_CR0,0,666,1000_AL_.jpg'
        ]);
    }
}
