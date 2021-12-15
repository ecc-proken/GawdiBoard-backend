<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,

            TagGenresTableSeeder::class,
            TagTargetsTableSeeder::class,
            TagTableSeeder::class,

            OfferTableSeeder::class,
            OfferTagTableSeeder::class,

            PromotionTableSeeder::class,
            PromotionTagTableSeeder::class,
        ]);
    }
}
