<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresentationVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('presentation_videos') -> insert([
            "title" => "Séjour de rêve",
            "title_english" => "Dream stay",
            "description" => "Découvrez les délices de notre chef au restaurant de l'hôtel Arth.",
            "description_english" => "Discover the delights of our chef at the restaurant of the Hotel Arth.",
            "video_url" => "storage/video/presentation_video.mp4",
        ]);
    //        \App\Models\PresentationVideo::factory()->create();
    }
}
