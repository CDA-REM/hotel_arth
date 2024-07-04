<?php

namespace Tests\Feature;

use App\Models\KeyCard;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Repository\KeyCardRepository;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManagementCardTest extends TestCase
{

    Use RefreshDatabase, WithFaker;

    /**
     * Test creation of key card
     *
     * @return void
     */
    public function test_keyCard_is_created()
    {
        // Arrange : create a room
        $room = Room::factory()->create();

        // Arrange : create a reservation
        $started_random_date =  now()->addDays(rand(1, 10));

        $reservation = Reservation::factory()
            ->hasAttached($room)
            ->create([
                'user_id' => 2,
                'number_of_people' => $this->faker->numberBetween(1, 9),
                'started_date' => $started_random_date,
                'end_date' => $this->faker->dateTimeBetween($started_random_date, '+2 weeks'),
                'price' => $this->faker->randomFloat(2, 70, 3500),
                'stay_type' => $this->faker->randomElement(['pro', 'personal']),
                'status' => 'validated',
            ]);

        // Act
        $response = $this->post('/api/keycard', [
            'reservation_id' => $reservation->id,
            'room_id' => $room->id
        ]);
        $keyCard = KeyCard::where("reservation_id", $reservation->id)->first();

        // Assert
        $response
            ->assertStatus(201)
            ->assertJson(
                [
                    'id' => $keyCard->id,
                    'key_code' => $keyCard->key_code,
                    'room_id' => $room->id,
                    'reservation_id' => $reservation->id,
                ]);

    }

    public function test_keyCard_is_read()
    {

        // Arrange : create user
        $user = User::factory()->create();

        //Arrange create room
        $room = Room::factory()->create();

        // Arrange : create a reservation
        $started_random_date =  now()->addDays(rand(1, 10));

        $reservation = Reservation::factory()
            ->hasAttached($room)
            ->create([
                'user_id' => $user->id,
                'number_of_people' => $this->faker->numberBetween(1, 9),
                'started_date' => $started_random_date,
                'end_date' => $this->faker->dateTimeBetween($started_random_date, '+2 weeks'),
                'price' => $this->faker->randomFloat(2, 70, 3500),
                'stay_type' => $this->faker->randomElement(['pro', 'personal']),
                'status' => 'validated',
            ]);

        // Arrange : create a keyCard
        $keyCard = KeyCard::factory()->create([
            'room_id' => $room->id,
            'reservation_id' => $reservation->id]);


        // Act
        $response = $this->get('/api/keycard/' . $keyCard->key_code);

        // Assert
        $response
            ->assertStatus(200)
            ->assertJson(
                ['key_code' => $keyCard->key_code,
                    'userCivility' => $user->civility,
                    'user_name' => $user->firstname ." ". $user->name,
                    'reservation_id' => $reservation->id,
                    'room_number' => $room->room_number,
                    'room_id' => $room->id,
                    'started_date' => date_format($reservation->started_date, "Y-m-d H:i:s"),
                    'end_date' => date_format($reservation->end_date, "Y-m-d H:i:s"),
                    'price' => $reservation->price,
                ]);
    }

    public function test_allowsRoomAccess() {
        // Arrange : create user
        $user = User::factory()->create();

        //Arrange create room
        $room = Room::factory()->create();

        // Arrange : create a reservation
        $started_random_date =  date("Y-m-d H:i:s");

        $reservation = Reservation::factory()
            ->hasAttached($room)
            ->create([
                'user_id' => $user->id,
                'number_of_people' => $this->faker->numberBetween(1, 9),
                'started_date' => $started_random_date,
                'checkin' => $started_random_date,
                'end_date' => $this->faker->dateTimeBetween($started_random_date, '+2 weeks'),
                'price' => $this->faker->randomFloat(2, 70, 3500),
                'stay_type' => $this->faker->randomElement(['pro', 'personal']),
                'status' => 'validated',
            ]);

        // Arrange : create a keyCard
        $keyCard = KeyCard::factory()->create([
            'room_id' => $room->id,
            'reservation_id' => $reservation->id]);

        // Act

        $result = KeyCardRepository::allowsRoomAccess($room->id, $keyCard->key_code);


        // Assert
        $this->assertEquals(true, $result);


    }



}
