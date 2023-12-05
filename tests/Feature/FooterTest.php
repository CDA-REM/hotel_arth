<?php

namespace Tests\Feature;

use App\Models\Footer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;



class FooterTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * Test that the footer is rendered.
     *
     * @return void
     */

    public function test_footer_is_rendered()
    {
        $response = $this->get('api/home/footer');

        $response->assertStatus(200);
    }

    /**
     * Test that a link has been modified in the footer
     *
     * @return void
     */
    public function test_footer_modification_link()
    {
        $footer = Footer::factory()->create();

        $this->withoutMiddleware();
        $response = $this->putJson('api/home/footer/' . $footer->getRouteKey(),  [
            'column_number' => '1',
            'entry_name' => ['fr' => 'Se connecter', 'en' => 'Login'],
            'url_redirection' => '/login'
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test that a link has been deleted in the footer
     *
     * @return void
     */
    public function test_footer_delete()
    {
        $footer = Footer::factory()->create();
        $this->withoutMiddleware();
        $response = $this->delete('api/home/footer/' . $footer->getRouteKey());
        $response->assertStatus(200);
    }

    /**
     * Test that a link has been created in the footer
     *
     * @return void
     */
        public function test_footer_creation_link()
    {
        $this->withoutMiddleware();
        $response = $this->post('api/home/footer',  [
            'column_number' => '1',
            'entry_name' => ['fr' => 'Nous rejoindre', 'en' => 'Join us'],
            'url_redirection' => '/contact'
        ]);
        $response->assertStatus(200);
    }

}
