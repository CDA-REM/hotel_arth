<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    //    To stop Laravel from creating updated_at and created_at fields while populating the db with a seeder
    public $timestamps = false;

    public $fillable = [
        'room_number',
        'style',
        'price',
    ];

    /**
     * Rooms that belongs to a reservations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function reservations() : BelongsToMany
    {
        return $this->hasMany(Reservation::class, 'reservation_rooms');
    }
}
