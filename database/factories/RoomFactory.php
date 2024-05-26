<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $roomNumbers = [305, 111, 309];
        $roomNumber = $this->faker->unique()->randomElement($roomNumbers);

        switch ($roomNumber) {
            case 305:
                $price = 70;
                $style = "classic";
            break;
            case 111:
                $price = 140;
                $style = "luxury";
            break;
            case 309:
                $price = 280;
                $style = "royal";
            break;
            default:
                $price = 70;
                $style = "classic";
        }

        return [
            'room_number' => $roomNumber,
            'style' => $style,
            'price' => $price,

        ];
    }
}
