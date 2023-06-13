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
//        Statistic::factory(10)->create();
        DB::table('statistics')->insert([
            [
                'key_card_id' => 1,
                'traceability' => json_encode(['2021-05-01 00:00:00', '2021-05-02 00:00:00', '2021-05-03 00:00:00', '2021-05-04 00:00:00', '2021-05-05 00:00:00', '2021-05-06 00:00:00', '2021-05-07 00:00:00', '2021-05-08 00:00:00', '2021-05-09 00:00:00', '2021-05-10 00:00:00']),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 2,
                'traceability' => json_encode(['2021-05-01 00:00:00', '2021-05-02 00:00:00', '2021-05-03 00:00:00', '2021-05-04 00:00:00', '2021-05-05 00:00:00', '2021-05-06 00:00:00', '2021-05-07 00:00:00', '2021-05-08 00:00:00', '2021-05-09 00:00:00', '2021-05-10 00:00:00']),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 3,
                'traceability' => json_encode([]),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 4,
                'traceability' => json_encode([]),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 5,
                'traceability' => json_encode([]),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 6,
                'traceability' => json_encode([]),
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 7,
                'traceability' => json_encode([]),
                 "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 8,
                'traceability' => json_encode(['2023-06-11 09:10:00']),
                 "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 9,
                'traceability' => json_encode(['2023-06-11 09:10:00']),
                 "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_card_id' => 10,
                'traceability' => json_encode([]),
                 "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
