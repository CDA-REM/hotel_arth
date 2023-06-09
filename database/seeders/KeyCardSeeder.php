<?php

namespace Database\Seeders;

use App\Models\KeyCard;
use Illuminate\Database\Seeder;

class KeyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        KeyCard::factory(10)->create();
    }
}
