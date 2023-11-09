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
        return [
                "title" => json_encode(["fr" => "Une expérience unique dans une ambiance relaxante", "en" => "A unique experience in a relaxing atmosphere"]),
                "description" => json_encode(["fr" => "Découvrez les délices de notre Chef au restaurant de l'Hôtel Arth.",
                    "en" => "Discover the delights of our chef at the Hotel Arth's restaurant."]),
                "video_url" => "storage/video/presentation_video.mp4",
        ];
    }
}
