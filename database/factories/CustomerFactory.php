<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname'  => $this->faker->lastName(),
            'email'  => $this->faker->unique()->safeEmail(),
//            'email_verified_at' => now(), // TODO - Enable ?
            'phone' => $this->faker->phoneNumber(),
            'avatar' => 'storage/avatars/avatar1.png',
            'password' => $this->faker->password(),
//            'remember_token' => Str::random(10), // TODO - Enable ?


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
