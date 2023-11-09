<?php

namespace Tests\Unit;

use App\Models\PresentationVideo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresentationVideoTest extends TestCase
{
    use RefreshDatabase;

    public function testPresentationVideoModel()
    {
        // Arrange: Crée une instance de votre modèle PresentationVideo
        $presentationVideo = new PresentationVideo();

        // Act: Défini des valeurs pour les attributs
        $presentationVideo->title = json_encode(["fr" => "Une expérience unique dans une ambiance relaxante", "en" => "A unique experience in a relaxing atmosphere"]);
        $presentationVideo->video_url = "storage/video/presentation_video.mp4";
        $presentationVideo->description = json_encode(["fr" => "Découvrez les délices de notre Chef au restaurant de l'Hôtel Arth.",
            "en" => "Discover the delights of our chef at the Hotel Arth's restaurant."]);

        // Enregistre le modèle
        $presentationVideo->save();

        // Récupère la première entrée de la table presentation_videos
        $presentationVideo = PresentationVideo::first();

        // Assert: Vérifie que le modèle a été correctement créé
        $this->assertNotNull($presentationVideo);

        // Vérifie que les attributs title, description et video_url ne sont pas vides
        $this->assertNotEmpty($presentationVideo->title);
        $this->assertNotEmpty($presentationVideo->description);
        $this->assertNotEmpty($presentationVideo->video_url);

        // Vérifie que les timestamps ont été automatiquement mis à jour
        $this->assertNotNull($presentationVideo->created_at);
        $this->assertNotNull($presentationVideo->updated_at);
    }
}

