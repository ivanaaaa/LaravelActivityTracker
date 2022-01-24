<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activity::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::latest()->value('id'),
            'activity_date' => $this->faker->dateTimeBetween('now','+ 1 month'),
            'duration' => $this->faker->numberBetween(1,12),
            'description' =>  Str::random(20)

        ];
    }
}
