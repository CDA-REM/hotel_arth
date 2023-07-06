<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeyCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() :array
    {
        $room_id = Room::all()->pluck('id')->toArray();

        return [
            'key_code' => $this->faker->uuid,
            'room_id' => $this->faker->randomElement($room_id),
        ];
    }
}
