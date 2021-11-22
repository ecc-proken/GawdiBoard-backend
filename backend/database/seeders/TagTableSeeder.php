<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\TagGenre;
use App\Models\TagTarget;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [//IT
                'とりあえずIT科募集', 
                'モバイルアプリエンジニア募集', 
                'フロントエンジニア募集', 
                'バックエンドエンジニア募集', 
                'インフラエンジニア募集', 
            ],
            [//GAME
                'とりあえずゲーム科募集',
                'アプリケーションプログラマー募集',
                'エンジンプログラマー募集',
                'プランナー募集',
                'レベルデザイナー募集',
                'タスクマネジメント募集',
                'ツールプログラマー募集',
                'ゲームグラフィックデザイナー募集',
            ],
            [//WEB
                'とりあえずWEB科募集',
                'UIできる人募集',
                'UXできる人募集',
                'WEBデザイナー募集',
                'グラフィックデザイナー募集',
                '動画作れる人募集',
            ],

        ];
        
        $genre = ['IT', 'GAME', 'WEB'];

        $tagTarget = new TagTarget();
        $tagGenre = new TagGenre();

        foreach($array as $index => $arr){
            foreach($arr as $value){
                $tag = new Tag();

                $tag->tag_name = $value;
                $tag->tag_genre_id = $tagGenre->where("genre_name", "=", "募集")->get()[0]->id;
                if($index == 0) $tag->tag_target_id = $tagTarget->where("target_name", $genre[$index])->get("id")[0]->id;

                $tag->save();
            }
        }
    }
}
