<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_number' => User::inRandomOrder()->limit(1)->get('student_number')[0],
            'offer_id' => 1,
            'chat' => 'テストチャット',
            'created_at' => now(),
        ];
    }
}
