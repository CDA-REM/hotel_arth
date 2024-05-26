<?php

namespace Tests\Unit;

use App\Models\KeyCard;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Repository\KeyCardRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class KeyCardTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test that attributs are correctly set
     *
     * @return void
     */

    public function test_attributs_are_set_correctly()
    {
        $keyCode = Str::uuid();
        // create a new instance of KeyCard with attributs
       $keyCard = new KeyCard([
           'key_code' => $keyCode,
            'reservation_id' => 1,
            'room_id' => 3,
        ]);

        // Check that the result is what we are waiting for (the right number of key card)
        $this->assertEquals($keyCode, $keyCard->key_code);
        $this->assertEquals(1, $keyCard->reservation_id);
        $this->assertEquals(3, $keyCard->room_id);
    }

    public function test_get_number_of_card_for_room()
    {

        // Arrange : create a room
        $room = Room::factory()->create();
        // Arrange : create a reservation
        $reservation = Reservation::factory([
            'user_id' => 3,
        ])
            ->hasAttached($room)
            ->create();
        // Arrange : create a KeyCard link to room and reservation
        KeyCard::factory()->create([
            'reservation_id' => $reservation->id,
            'room_id' => $room->id,
            'key_code' => $this->faker->uuid,
        ]);

        // Arrange : create a second keyCard
        KeyCard::factory()->create([
            'reservation_id' => $reservation->id,
            'room_id' => $room->id,
            'key_code' => $this->faker->uuid,
        ]);

        // Act : call to getCurrentCard()
        $result = KeyCardRepository::getCurrentCards($room->id, $reservation->id);

        // Assert : check that the result is 2 keycargs created for the same room
        $this->assertEquals(2, $result);
        $this->assertNotEquals(1, $result);

    }


}
