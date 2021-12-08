<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TagGenre;

class TagGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['募集', '作品', '宣伝'];

        foreach($arr as $value){
            $tag_genre = new TagGenre();

            $tag_genre->genre_name = $value;
            $tag_genre->save();
        }
    }
}
