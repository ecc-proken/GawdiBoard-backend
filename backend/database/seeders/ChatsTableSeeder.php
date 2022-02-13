<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Chat;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            ['chat' => 'おはよう'],
            ['chat' => 'こんにちは'],
            ['chat' => 'こんばんは'],
        ];

        foreach ($arr as $value) {
            Chat::factory()->create($value);
        }
    }
}
