<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users') -> insert([

            [
                'civility' => 'mister',
                'personal_address' => json_encode(['address' => '51 route de la ligne', 'zip_code' => '75015',  'city' => 'Paris']),
                'enterprise_name' => 'Le Campus numérique',
                'professional_address' => json_encode(['address' => '1 Esplanade Augustin Aussedat', 'zip_code' => '74000',  'city' => 'Annecy']),
                'firstname' => 'Kaley',
                'lastname' => 'King',
                'email' => 'rem@hotel.fr',
                'phone' => '1-281-295-6068',
                'avatar_url' => 'storage/avatars/avatar1.png',
                'password' => '$2y$10$y8F7O8DXCuPskVcv4vOuvOhjTBVSLmbVofU4Sc3dgnNGqadkLbQiC',
                'user_role' => "admin",
            ]
        ]);

        User::factory()
            ->count(5)
            ->create();
    }
}
