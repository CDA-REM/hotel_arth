<?php

use App\Models\Reservation;
use App\Models\Rooms;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_rooms', function (Blueprint $table) {

//            $table->integer('reservation_id')->nullable(false);
            $table->foreignId('reservation_id')->nullable(false);

//            $table->integer('room_number')->nullable(false);
            $table->foreignId('room_id')->nullable(false);

//            $table->unique(['reservation_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_room');
    }
}
