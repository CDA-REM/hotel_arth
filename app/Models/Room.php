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
        // TODO - Modifier le modèle et tous les fichiers pour ajouter un tableau contenant les keycards id. Le tableau peut être vide. A la fin de la réservation il est remis à zéro.
        //'roomsKeyCards',
    ];

//    protected $casts = [
//        'keys' => 'array'
//    ];

    /**
     * Rooms that belongs to a reservations
     * @return BelongsToMany
     */
    public function reservations() : BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_rooms');
    }
}
