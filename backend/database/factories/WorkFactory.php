<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'picture' => $this->faker->imageUrl(),
            'link' => $this->faker->url(),
            'post_date' => new Carbon('-' . (string) random_int(1, 800) . ' day'),
            'student_number' => User::inRandomOrder()->limit(1)->get('student_number')[0],
        ];
    }
}
