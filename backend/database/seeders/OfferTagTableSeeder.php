<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\OfferTag;
use App\Models\Tag;

class OfferTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = Offer::all();

        foreach ($offers as $offer) {
            $tags_id = Tag::inRandomOrder()->limit(random_int(1, 10))->get('id');

            foreach ($tags_id as $tag_id) {
                $offer_tag = new OfferTag();

                $offer_tag->offer_id = $offer->id;
                $offer_tag->tag_id = $tag_id->id;

                $offer_tag->save();
            }
        }
    }
}
