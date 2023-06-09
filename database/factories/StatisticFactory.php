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
        $card_id = KeyCard::all()->pluck('id')->toArray();

        return [
            'key_card_id' => $this->faker->randomElement($card_id),
            'traceability' => '',
        ];
    }
}
