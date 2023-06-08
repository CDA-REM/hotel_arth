<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     *
     * @return array
     */
    public function definition()
    {
        $rooms = Room::all()->pluck('id');
        $reservations = Reservation::all()->pluck('id');
        return [
            'room_id' => $this->faker->randomElement($rooms),
            'reservation_id' => $this->faker->randomElement($reservations)
        ];
    }
}
