<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\UserOffer;

class UserOffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $chats = Chat::all();

        foreach ($chats as $chat) {
            $user_offer = new UserOffer();

            $user_offer->student_number = $chat->student_number;
            $user_offer->offer_id = $chat->offer_id;

            $user_offer->save();
        }
    }
}
