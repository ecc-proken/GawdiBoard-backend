<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_number' => random_int(10 ** 6, 10 ** 7),
            'user_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'link' => $this->faker->url(),
            'self_introduction' => $this->faker->sentence(),
            'created_at' => now(),
        ];
    }
}
