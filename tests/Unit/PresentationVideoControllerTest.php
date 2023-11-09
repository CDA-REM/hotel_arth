<?php

namespace Tests\Unit;

use App\Http\Controllers\PresentationVideoController;
use App\Http\Resources\PresentationVideoResource;
use App\Models\PresentationVideo;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresentationVideoControllerTest extends TestCase
{
    use RefreshDatabase; // Si vous voulez rafraîchir la base de données pour chaque test

    /**
     * Assert that the response is a resource of a given type.
     *
     * @param  \Illuminate\Testing\TestResponse  $response
     * @param  \Illuminate\Http\Resources\Json\JsonResource  $resource
     * @return void
     */

    /**
     * Test the index method of the PresentationVideoController.
     *
     * @return void
     */
    public function testIndexReturnsPresentationVideoResource()
    {
        // Arrange: Créer une instance de PresentationVideo à l'aide d'une factory
        $presentationVideo = PresentationVideo::factory()->create();

        // Act: Appeler la méthode index du contrôleur
        $controller = new PresentationVideoController();
        $response = $controller->index();

        // Assert: Vérifier que la réponse est une instance de PresentationVideoResource
        $this->assertInstanceOf(PresentationVideoResource::class, $response);
        // Vérifier que la réponse contient la bonne vidéo
        $this->assertEquals($presentationVideo->id, $response->resource->id);
    }
}
