<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(User::class)->nullable(false);
            $table->TinyInteger('number_of_people')->nullable(false);
            $table->dateTime('started_date')->nullable(false);
            $table->dateTime('end_date')->nullable(false);
            $table->dateTime('checkin')->nullable(true);
            $table->dateTime('checkout')->nullable(true);
            $table->float('price')->nullable(false);
            $table->enum('stay_type', ['pro', 'personal'])->nullable(false);
            $table->enum('status', ['cancelled', 'terminated', 'no-show', 'validated'])->nullable(false);
            $table->unique(["user_id", "started_date", "end_date"]);
            $table->index("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
