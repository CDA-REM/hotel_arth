<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PresentationVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition(): array
    {
        /*return [
            'video_url' => 'storage/video/presentation_video.mp4',
            'title' => $this->faker->title(30),
            'title_english' => $this->faker->title(50),
            'description' => $this->faker->text(200),
            'description_english' => $this->faker->text(200),
        ];*/

        return [
                "title" => json_encode(["fr" => "Une expérience unique dans une ambiance relaxante", "en" => "A unique experience in a relaxing atmosphere"]),
                "description" => json_encode(["fr" => "Découvrez les délices de notre Chef au restaurant de l'Hôtel Arth.",
                    "en" => "Discover the delights of our chef at the Hotel Arth's restaurant."]),
                "video_url" => "storage/video/presentation_video.mp4",
        ];
    }
}
