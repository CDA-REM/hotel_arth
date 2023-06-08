<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'gender' => $this->faker->randomElement(['madam', 'mister']),
            'lastname'  => $this->faker->lastName(),
            'email'  => $this->faker->unique()->safeEmail(),
            //'email_verified_at' => now(), // TODO - Enable ?
            'phone' => $this->faker->phoneNumber(),
            'avatar_url' => 'storage/avatars/avatar1.png',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'personal_address' => json_encode(["address" => "260 rue de l'Artichaut", "zip_code" => "74000", "city" => "Annecy"]),
            'enterprise_name' =>  'La Tortue',
            'professional_address' =>  json_encode(["address" => "18 Chemin du Moulin", "zip_code" => "74000", "city" => "Annecy"]),
            'role' => 'customer',
//            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
