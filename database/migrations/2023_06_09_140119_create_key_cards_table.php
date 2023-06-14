<?php

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('key_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('key_code')->unique();
            $table->foreignIdFor(Room::class)->nullable(false);
            $table->foreignIdFor(Reservation::class)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('key_cards');
    }
}
