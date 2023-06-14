<?php

namespace Database\Seeders;

use App\Models\KeyCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //KeyCard::factory(10)->create();
        DB::table('key_cards')->insert([
            [
                'key_code' => '6d0d6590-9c02-333b-bea4-7a738b23060f',
                'room_id' => 12,
                'reservation_id' => 1,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'e46a8bfe-695b-323a-afc3-e07dffc98623',
                'room_id' => 30,
                'reservation_id' => 11,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => '6481a885-fbbe-3e4e-b4d2-dab93ec0a822',
                'room_id' => 12,
                'reservation_id' => 2,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'efe16c3f-ef34-3474-9fb9-f01ab14938b5',
                'room_id' => 8,
                'reservation_id' => 12,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'd35fdd25-e007-31f7-8b4e-e044f75fabc9',
                'room_id' => 15,
                'reservation_id' => 2,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'a7375c6d-5e1b-3d20-8f1c-b5a1c80eace6',
                'room_id' => 18,
                'reservation_id' => 14,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'fcfa22a-dd09-3de5-9c57-61a168e293f7',
                'room_id' => 27,
                'reservation_id' => 4,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'cffb4375-96ed-3ec2-9128-5f35a98032a9',
                'room_id' => 28,
                'reservation_id' => 15,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => 'a18f0172-6cda-34ae-b1df-f2a05b488e93',
                'room_id' => 14,
                'reservation_id' => 16,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
            [
                'key_code' => '48a089ff-7981-3b50-a13b-3edabf9dc896',
                'room_id' => 4,
                'reservation_id' => 17,
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
