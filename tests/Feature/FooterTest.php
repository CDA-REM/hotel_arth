<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;



class FooterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_footer_is_rendered()
    {
        $response = $this->get('api/home/footer');

        $response->assertStatus(200);
    }

    public function test_footer_modification_link()
    {
        $this->withoutMiddleware();
        $response = $this->put('api/home/footer/2',  [
            'column_number' => '1',
            'entry_name' => ['fr' => 'Se connecter', 'en' => 'Login'],
            'url_redirection' => '/login'
        ]);
        $response->assertStatus(200);
    }


    public function test_footer_delete()
    {
        $this->withoutMiddleware();
        $response = $this->delete('api/home/footer/1');
        $response->assertStatus(200);
    }


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

//    public function test_seeder()
//    {
//        $this->seed();
//    }
}
