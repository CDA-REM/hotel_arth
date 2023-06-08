<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            [
                'room_number' => 101,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 102,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 103,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 104,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 105,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 106,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 107,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 108,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 109,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 110,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 201,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 202,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 203,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 204,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 205,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 206,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 207,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 208,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 209,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 210,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 301,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 302,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 303,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 304,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 305,
                'style' => 'classic',
                'price' => 70,
            ],
            [
                'room_number' => 111,
                'style' => 'luxury',
                'price' => 140,
            ],
            [
                'room_number' => 211,
                'style' => 'luxury',
                'price' => 140,
            ],
            [
                'room_number' => 306,
                'style' => 'luxury',
                'price' => 140,
            ],
            [
                'room_number' => 307,
                'style' => 'luxury',
                'price' => 140,
            ],
            [
                'room_number' => 308,
                'style' => 'luxury',
                'price' => 140,
            ],
            [
                'room_number' => 309,
                'style' => 'royal',
                'price' => 280,
            ],
            [
                'room_number' => 310,
                'style' => 'royal',
                'price' => 280,
            ],
        ]);
    }
}
