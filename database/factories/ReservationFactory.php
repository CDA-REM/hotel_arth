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
    public function definition()
    {
        $user_id = User::all()->pluck('id')->toArray();

        return [
            'user_id'=> $this->faker->randomElement($user_id),
            'number_of_people' => $this->faker->numberBetween(1, 9),
            'started_date' => $this->faker->dateTime(),
            'end_date' => $this->faker->dateTime(),
            'price' => $this->faker->randomFloat(2, 70, 3500),
            'stay_type' => $this->faker->randomElement(['pro', 'personal']),
            'status' => $this->faker->randomElement(['cancelled', 'terminated', 'no-show', 'validated']),
        ];
    }
}
