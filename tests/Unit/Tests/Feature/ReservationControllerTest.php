<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test the index method of the class.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        $user = User::factory()->create();
        Reservation::factory()->count(5)->create(['user_id' => $user->id]);
        $response = $this->getJson('/api/reservations');
        $response->dump();
        $response->assertStatus(200);
        $response->assertJsonCount(5,);
    }

    /**
     * Test the create reservation functionality.
     *
     * This function creates a reservation by sending a POST request to the '/api/reservations/create' endpoint
     * with the required data. It then asserts that the response status is 201 and that the reservation is
     * successfully stored in the database.
     *
     * @throws \Exception if there is an error during the test.
     */
    public function testCreateReservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'started_date' => now()->addDays(1)->format('Y-m-d'), // Date de début future
            'end_date' => now()->addWeeks(1)->format('Y-m-d'),    // Date de fin après la date de début
            'numberOfPeople' => $this->faker->numberBetween(1, 4), // Nombre aléatoire de personnes
            'isTravelForWork' => $this->faker->boolean,           // Valeur booléenne aléatoire
            'numberOfRooms' => $this->faker->numberBetween(1, 10), // Nombre aléatoire de chambres
            'roomCategory' => $this->faker->randomElement(['classic', 'luxury', 'royal']), // Catégorie de chambre aléatoire
            'formOptions' => [], // Options, si nécessaires
            'user_id' => $user->id,
        ];

        $response = $this->postJson('/api/reservations/create', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'number_of_people' => $data['numberOfPeople'],
            'stay_type' => $data['isTravelForWork'] ? 'pro' : 'personal'
        ]);
    }


    /**
     * Test the checkin method.
     *
     * @return void
     */
    public function testCheckinMethod()
    {
        $user = User::factory()->create(['user_role' => 'admin']);
        $this->actingAs($user);

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'status' => 'validated'
        ]);

        // Vérifier que la réservation existe dans la base de données avant d'effectuer le check-in
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'status' => 'validated']);

        // Faire une requête POST pour effectuer le check-in
        $response = $this->putJson("/api/reservations/checkin/{$reservation->id}");
        $response->dump();
        // Vérifier que la réponse est OK (200)
        $response->assertStatus(200);

        $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'status' => 'in_progress']);
    }

    /**
     * Test the functionality of the `getUserReservations` method.
     *
     * This method tests the retrieval of reservations for a user by making a GET request to the `/api/users/{user_id}/reservations` API endpoint. It creates a test user, authenticates as that user, creates three reservations associated with the user, and then makes the API request to retrieve the reservations. The method asserts that the response status is 200 and that the response JSON contains three reservation data objects.
     *
     * @return void
     */
    public function testGetUserReservations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Reservation::factory()->count(3)->create(['user_id' => $user->id]);
        $response = $this->getJson('/api/users/{$user->id}/reservations');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
