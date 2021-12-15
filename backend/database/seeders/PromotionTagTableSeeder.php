<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\PromotionTag;
use App\Models\Tag;

use Illuminate\Database\Seeder;

class PromotionTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = Promotion::all();

        foreach ($promotions as $promotion) {
            $tags_id = Tag::inRandomOrder()->limit(random_int(1, 10))->get('id');

            foreach ($tags_id as $tag_id) {
                $promotion_tag = new PromotionTag();

                $promotion_tag->promotion_id = $promotion->id;
                $promotion_tag->tag_id = $tag_id->id;

                $promotion_tag->save();
            }
        }
    }
}
