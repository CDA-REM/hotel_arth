<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class FooterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'column_number' => $this->faker->numberBetween(1, 2),
            'entry_name' => ['fr' => $this->faker->word(), 'en' => $this->faker->word()],
            'url_redirection' => $this->faker->url(),

        ];
    }
}
