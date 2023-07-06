<?php

namespace Database\Factories;

use App\Models\KeyCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $key_card_id = KeyCard::all()->pluck('id')->toArray();

        return [
//            'key_card_id' => $this->faker->randomElement($key_card_id),
            'key_card_id' => $this->faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'], 10),
            'traceability' => '',
        ];
    }
}
