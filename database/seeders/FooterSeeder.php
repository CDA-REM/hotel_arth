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
                'column_number' => 1,
                'entry_name' => json_encode(['fr' => 'Nous contacter', 'en' => 'Contact us']),
                'url_redirection' => '/contact',
            ],
            [
                'column_number' => 1,
                'entry_name' => json_encode(['fr' => 'A propos', 'en' => 'About']),
                'url_redirection' => '/about',
            ],
            [
                'column_number' => 2,
                'entry_name' => json_encode(['fr' => 'Promotions', 'en' => 'Sales']),
                'url_redirection' => '/sales',
            ],

        ]);
    }
}
