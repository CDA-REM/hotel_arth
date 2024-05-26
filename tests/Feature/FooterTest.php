<?php

namespace Tests\Feature;

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\Footer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\Factory;


class FooterTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_footer_is_rendered()
    {

        Footer::factory()->count(3)->create();

        $response = $this->get('api/home/footer');

        $response->assertStatus(200);
    }

    public function test_footer_modification_link()
    {

        // User with role admin
        $user = User::factory()->create([
            'user_role' => 'admin'
        ]);

        // Creating links in footer
        Footer::factory()->count(3)->create();

        $response = $this->actingAs($user)->put('api/home/footer/2',  [
            'column_number' => '1',
            'entry_name' => ['fr' => 'Se connecter', 'en' => 'Login'],
            'url_redirection' => '/login'
        ]);
        $response->assertStatus(200);
    }


    public function test_footer_delete()
    {
        // User with role admin
        $user = User::factory()->create([
            'user_role' => 'admin'
        ]);

        // Creating links in footer
        Footer::factory()->count(3)->create();

        $response = $this->actingAs($user)->delete('api/home/footer/3');
        $response->assertStatus(200);
    }


        public function test_footer_creation_link()
    {
        // User with role admin
        $user = User::factory()->create([
            'user_role' => 'admin'
        ]);

        $response = $this->actingAs($user)->post('api/home/footer',  [
            'column_number' => '1',
            'entry_name' => ['fr' => 'Nous rejoindre', 'en' => 'Join us'],
            'url_redirection' => '/contact'
        ]);
        $response->assertStatus(200);
    }

}
