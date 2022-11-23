<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footers')->insert([
            [
                "column_number" => 1,
                "entry_name" => json_encode(["fr" => "Nous contacter", "en" => "contact us"]),
                "url_redirection" => "/contact",
            ],
            [
                "column_number" => 1,
                "entry_name" => json_encode(["fr" => "A propos", "en" => "About"]),
                "url_redirection" => "/about",
            ],
        ]);
    }
}
