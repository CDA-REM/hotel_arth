<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ReservationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        // Initialisation supplémentaire requise pour les tests
    }

    public function testReservationFunctionality()
    {
        // Arrange : Création de données de test pour la réservation
        $user = User::factory()->create();
        $started_random_date = now()->addDays(rand(1, 10));

        // Arrange : Création et enregistrement de l'instance de réservation
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'number_of_people' => $this->faker->numberBetween(1, 9),
            'started_date' => $started_random_date,
            'end_date' => $this->faker->dateTimeBetween($started_random_date, '+2 weeks'),
            'price' => $this->faker->randomFloat(2, 70, 3500),
            'stay_type' => $this->faker->randomElement(['pro', 'personal']),
            'status' => 'validated',
        ]);


        // Act : Récupération de l'instance depuis la base de données
        $retrievedReservation = Reservation::find($reservation->id);

        // Assert: Vérification que les données enregistrées correspondent
        $this->assertNotNull($retrievedReservation);
        $this->assertEquals($reservation['user_id'], $retrievedReservation->user_id);
        $this->assertEquals($reservation['number_of_people'], $retrievedReservation->number_of_people);
        $this->assertEquals($reservation['started_date']->format('Y-m-d H:i:s'), $retrievedReservation->started_date);
        $this->assertEquals($reservation['end_date']->format('Y-m-d H:i:s'), $retrievedReservation->end_date);
        $this->assertEquals($reservation['price'], $retrievedReservation->price);
        $this->assertEquals($reservation['stay_type'], $retrievedReservation->stay_type);
        $this->assertEquals($reservation['status'], $retrievedReservation->status);
    }

    public function testReservationStatusUpdateToInProgress()
    {
        // Arrange : Créer une réservation initiale
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'status' => 'validated'
        ]);

        // Act : Modifier le statut de la réservation
        $reservation->status = 'in_progress';
        $reservation->save();

        // Act : Récupérer la réservation mise à jour
        $updatedReservation = Reservation::find($reservation->id);

        // Assert : Vérifier si le statut a été mis à jour
        $this->assertEquals('in_progress', $updatedReservation->status);
    }
}
