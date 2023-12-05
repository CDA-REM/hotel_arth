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
            'column_number' => $this->faker->randomElement(['1','2']),
            'entry_name' => ['fr' => $this->faker->title(), 'en' => $this->faker->title()],
            'url_redirection' => '/test',
        ];
    }
}
