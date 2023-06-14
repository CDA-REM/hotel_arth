<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() :array
    {
        $user_id = User::all()->pluck('id')->toArray();
        $started_random_date = $this->faker->dateTimeInInterval('-4 week', '+1 week');

        return [
            'user_id'=> $this->faker->randomElement($user_id),
            'number_of_people' => $this->faker->numberBetween(1, 9),
            'started_date' => $started_random_date,
            'end_date' => $this->faker->dateTimeBetween($started_random_date, '+1 week'),
            'price' => $this->faker->randomFloat(2, 70, 3500),
            'stay_type' => $this->faker->randomElement(['pro', 'personal']),
            'status' => 'validated',
        ];
    }
}
