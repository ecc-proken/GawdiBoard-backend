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
            'IT' => [
                'とりあえずIT科',
                'モバイルアプリエンジニア',
                'フロントエンジニア',
                'バックエンドエンジニア',
                'インフラエンジニア',
            ],
            'GAME' => [
                'とりあえずゲーム科',
                'アプリケーションプログラマー',
                'エンジンプログラマー',
                'プランナー',
                'レベルデザイナー',
                'タスクマネジメント',
                'ツールプログラマー',
                'ゲームグラフィックデザイナー',
            ],
            'WEB' => [
                'とりあえずWEB科',
                'UIできる人',
                'UXできる人',
                'WEBデザイナー',
                'グラフィックデザイナー',
                '動画作れる人',
            ],
            '全体' => [
                '大会メンバー募集',
                'イベントスタッフ募集',
                'その他',
            ],

        ];

        $offer_id = TagGenre::where('genre_name', '募集')->first('id')->id;

        foreach ($array as $key => $arr) {
            $tag_target_id = TagTarget::where('target_name', $key)->first('id')->id;

            foreach ($arr as $key => $value) {
                $tag = new Tag();

                $tag->tag_name = $value;
                $tag->tag_genre_id = $offer_id;
                $tag->tag_target_id = $tag_target_id;

                $tag->save();
            }
        }
    }
}
