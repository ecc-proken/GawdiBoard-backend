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
            "IT" => [
                'とりあえずIT科募集', 
                'モバイルアプリエンジニア募集', 
                'フロントエンジニア募集', 
                'バックエンドエンジニア募集', 
                'インフラエンジニア募集', 
            ],
            "GAME" => [
                'とりあえずゲーム科募集',
                'アプリケーションプログラマー募集',
                'エンジンプログラマー募集',
                'プランナー募集',
                'レベルデザイナー募集',
                'タスクマネジメント募集',
                'ツールプログラマー募集',
                'ゲームグラフィックデザイナー募集',
            ],
            "WEB" => [
                'とりあえずWEB科募集',
                'UIできる人募集',
                'UXできる人募集',
                'WEBデザイナー募集',
                'グラフィックデザイナー募集',
                '動画作れる人募集',
            ],

        ];

        $offerId = TagGenre::where("genre_name", "募集")->first('id')->id;
        
        foreach($array as $key => $arr){
            $TagTargetId = TagTarget::where('target_name', $key)->first('id')->id;

            foreach($arr as $key => $value){
                $tag = new Tag();

                $tag->tag_name = $value;
                $tag->tag_genre_id = $offerId;
                $tag->tag_target_id = $TagTargetId;

                $tag->save();
            }
        }
    }
}
