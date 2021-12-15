<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Offer;
use Carbon\Carbon;
use App\Models\User;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $func = new CommonFactory();

        return [
            'target' => $func->createTargetName(),
            'job' => $func->createJobName(),
            'link' => $this->faker->url,
            'picture' => $this->faker->imageUrl(),
            'post_date' => new Carbon('-' . (string) random_int(1, 30) . ' day'),
            'end_date' => new Carbon('+' .  (string) random_int(1, 30) . ' day'),
            'user_class' => $func->createClassName(),
            'student_number' => User::inRandomOrder()->limit(1)->get('student_number')[0],
        ];
    }
}
