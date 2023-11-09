<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePresentationVideosTable extends Migration
{
    public function up()
    {
        Schema::table('presentation_videos', function (Blueprint $table) {
            $table->dateTime('created_at')->nullable()->after('description');
            $table->dateTime('updated_at')->nullable()->after('created_at');
        });
    }

    public function down()
    {
        Schema::table('presentation_videos', function (Blueprint $table) {
            $table->dropColumn('created_at')->nullable();
            $table->dropColumn('updated_at')->nullable();
        });
    }
}

