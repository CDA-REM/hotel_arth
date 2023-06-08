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
        User::factory()
           ->count(5)
           ->create();


        DB::table('users') -> insert([

            [
                'gender' => 'mister',
                'personal_address' => json_encode(['address' => '51 route de la ligne', 'zip_code' => '75015',  'city' => 'Paris']),
                'enterprise_name' => 'Le Campus numérique',
                'professional_address' => json_encode(['address' => '1 Esplanade Augustin Aussedat', 'zip_code' => '74000',  'city' => 'Annecy']),
                'firstname' => 'Kaley',
                'lastname' => 'King',
                'email' => 'rem@hotel.fr',
                'phone' => '1-281-295-6068',
                'avatar_url' => 'storage/avatars/avatar1.png',
                'password' => '$2y$10$y8F7O8DXCuPskVcv4vOuvOhjTBVSLmbVofU4Sc3dgnNGqadkLbQiC',
                'role' => "admin",
            ],
//            [
//                "firstname" => "Jean",
//                "lastname" => "Glloq",
//                "email" => "J.glloq@example.net",
//                "phone" => "854-862-2256",
//                "avatar_url" => "storage/avatars/avatar1.png",
//                "password" => "mM:w`,v,?%%%K9'o",
//            ],
//            [
//                "firstname" => "Maryse",
//                "lastname" => "Longueville",
//                "email" => "m.longueville@example.com",
//                "phone" => "+15209556585",
//                "avatar_url" => "storage/avatars/avatar1.png",
//                "password" => "2wtZ0Q,o1hR",
//            ],
//            [
//                "firstname" => "Elsa",
//                "lastname" => "Patchez",
//                "email" => "e.patchez@example.com",
//                "phone" => "+19542804851",
//                "avatar_url" => "storage/avatars/avatar1.png",
//                "password" => "CWsA5>80'",
//            ],
//            [
//                "firstname" => "Juanita",
//                "lastname" => "Carter",
//                "email" => "j.carter@example.com",
//                "phone" => "(985) 918-6629",
//                "avatar_url" => "storage/avatars/avatar1.png",
//                "password" => "Onf3cfxEUi8dmUq3}Uj",
//            ],
//            [
//                "firstname" => "Annie",
//                "lastname" => "Rogahn",
//                "email" => "a.roghan@example.com",
//                "phone" => "+33698011350",
//                "avatar_url" => "storage/avatars/avatar1.png",
//                "password" => ",*1iAy5KEUK&-`3&0$2",
//            ],
        ]);
        /* "firstname" => Str::random(8),
            "lastname" => Str::random(8),
            "email" => Str::random(10).'@example.com',
            "phone" => Int::random(10),
            "avatar_url" => "storage/avatars/avatar1.png",
            "password"=> Hash::make('password'),
        */

    }
}
