<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Statistic::factory(10)->create();
    }
}
