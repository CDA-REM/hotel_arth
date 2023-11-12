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
        $started_random_date = $this->faker->dateTimeBetween('-2 weeks', '+2 weeks');

        return [
            'user_id'=> $this->faker->randomElement($user_id),
            'number_of_people' => $this->faker->numberBetween(1, 3),
            'started_date' => $started_random_date,
            'end_date' => $this->faker->dateTimeBetween($started_random_date, '+2 weeks'),
            'price' => $this->faker->numberBetween(70, 3500),
            'stay_type' => $this->faker->randomElement(['pro', 'personal']),
            'status' => 'validated',
        ];
    }
}
